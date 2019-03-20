app.controller("purchases", function ($scope, $http, MotoApi, purchasesCache, $window, $rootScope, $filter, rebrandingPrice, motoShopCurrencyInfo, currencyCache, $translate) {
    $scope.isViewLoading = true;
    $scope.usr_id = $window.user.id;
    $scope.locale = $window.user.locale;
    $scope.maxItems = 2;
    $scope.defaultOption = {
        "name": "select brand",
        "brand_name": "",
        "id": 0,
        "urlLogo": ""
    };
    $scope.currentPage = 1;
    $scope.pageSize = 10;
    $scope.regexPattern = {
        intNumber: /^(?!0+$)\d+$/,
        email: /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/,
        url: /[-a-zA-Z0-9@:%_\+.~#?&\/\/=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)?/
    };
    var url = 'user/' + $scope.usr_id + '/products';
    // Validation patterns
    $scope.ip_vld = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
    $scope.listBrands = {};

    $scope.motoShopCurrency = motoShopCurrencyInfo.getCurrency();
    $scope.currencySymbol = '$';


    $scope.initSelect = function () {
        $http({
            method: 'GET',
            url: '/api/brand/getexistbrand/' + $scope.usr_id
        }).then(function successCallback(data) {
            $scope.countLicenses = 0;
            if (typeof data.data.count_licenses !== "undefined") {
                $scope.countLicenses = data.data.count_licenses;
            }
            if (typeof data.data !== "undefined" && typeof data.data["brand"] !== "undefined") {
                $scope.listBrands = data.data["brand"];
                for (var i = 0; i < $scope.listBrands.length; i++) {
                    $scope.listBrands[i].urlLogo = $scope.listBrands[i].small_logo;
                }
                ;
                $scope.assignBrandToProducts();
            }
        }, function errorCallback(data) {
        });
    };

    $rootScope.$on('$translateChangeSuccess', function () {
        $scope.initSelect();
    });


    var cache = purchasesCache.get('purchases');
    if (cache) {
        $scope.purchases = cache;
        $scope.initSelect();
    } else {
        MotoApi.get(url).then(function (data) {
            $scope.purchases = $filter('orderBy')(data.data.products, "datetime", true);
            $scope.maxversions = data.data.maxversions;
            $rootScope.maxversions = data.data.maxversions;
            $scope.templates = window.templates;
            purchasesCache.put('purchases', data.data.products);
            $scope.initSelect();
        }, function (error) {
            // error handling here
        });
    }

    $scope.detectBrand = function (purchase) {
        for (var i = 0; i < $scope.listBrands.length; i++) {
            if ($scope.listBrands[i].id == 0) {
                return $scope.defaultOption;
            }
            if ($scope.listBrands[i].id == purchase.brand_id) {
                return $scope.listBrands[i];
            }
        }
        return $scope.defaultOption;
    }
    $scope.assignBrandToProducts = function () {
        for (var i = 0; i < $scope.purchases.length; i++) {
            $scope.purchases[i].brand = $scope.detectBrand($scope.purchases[i]);
            $scope.purchases[i].enableActivateOnDefoult = false;
        }
    }
    $scope.activetedBrand = function (index, selectValue) {
        var item = index;

        if (selectValue.id == item.brand.id && item.brand.id !== 0) {
            $('.select_error_allready_' + item.id).show();
            setTimeout(function () {
                $('.select_error_allready_' + item.id).fadeOut();
            }, 1000);
            return false;
        }
        if (item.brand.id == 0 && item.enableActivateOnDefoult == false) {
            $('.select_error_select_somthing_' + item.id).show();
            setTimeout(function () {
                $('.select_error_select_somthing_' + item.id).fadeOut();
            }, 1000);
            return false;
        }
        var data = {
            brand_id: selectValue.id,
            product_id: item.id
        }
        MotoApi.post('brand/activatedbrand/', data).then(function (data) {
            $scope.countLicenses = 0;
            item.brand = selectValue;
            if (typeof data !== "undefined" && typeof data.count_license !== "undefined") {
                $scope.countLicenses = data.count_license;
            }
        }, function (error) {
        });
    }
    /**
     * deactiveted brand
     * @param index
     * @param selectValue
     * @returns {{name: string, brand_name: string, id: number, urlLogo: string}|*}
     */
    $scope.deactivetedBrand = function (index, selectValue) {
        var item = index;

        var data = {
            product_id: item.id
        };
        MotoApi.post('brand/deactivatedbrand/', data).then(function (data) {
            item.brand = $scope.defaultOption;
            item.enableActivateOnDefoult = false;
            if (typeof data !== "undefined"
                && typeof data.countLicense !== "undefined"
            ) {
                $scope.countLicenses = +data.countLicense;
            }
        }, function (error) {
        });
        return $scope.defaultOption;
    };

    $scope.changeSelect = function (selectValue, index) {
        var item = index;
        item.enableActivateOnDefoult = true;
    }
    /* buy rebranding licenses */
    $scope.oneRebrandingPrice = 19;
    $scope.rebrandingPopupOpen = function () {
        $('body').css('overflow-y', 'hidden');
        $('.rebranding-popup-buy_licenses').fadeIn();
    }
    $scope.popClose = function () {
        $('.pop').fadeOut();
        $('body').css('overflow-y', 'visible');
    };
    $scope.createBuyLinkRebranding = function (count) {
        if (typeof count != "undefined" && count > 0) {
            var lang = $window.user.locale;
            var urlBuy = "https://www.motocms.com/website-templates/";
            if (lang !== "en") {
                urlBuy += lang + "/";
            }
            urlBuy += "cart/add/rebranding/" + count + "/";
            $window.open(urlBuy, '_blank');
        }
    };
    $scope.isViewLoading = false;
    $scope.activationPopupAct = function (template) {
        $scope.currentProduct = template;
        $('.pop_activation').fadeIn();
        $('body').css('overflow-y', 'hidden');
        $('.wrap').removeClass('act');
        $('.menu_open').removeClass('act');
        $('.pop__content').removeClass('act');
    }
    $scope.showActivationPopup = function (template) {
        $rootScope.activationPopupCaption = 'PURCHASES_TPL.POP_C_ACTIVATE_PRODUCT';
        $scope.activationPopupAct(template);
    }
    $scope.showReActivationPopup = function (template) {
        $rootScope.activationPopupCaption = 'PURCHASES_TPL.POP_C_REACTIVATE_PRODUCT';
        $scope.activationPopupAct(template);
    }
    $scope.toTimestamp = function (date) {
        return Date.parse($scope.parseDate(date));
    }
    $scope.parseDate = function (s) {
        var re = /^(\d{4})-(\d\d)-(\d\d) (\d\d):(\d\d):(\d\d)$/;
        var m = re.exec(s);
        return m ? new Date(m[1], m[2] - 1, m[3], m[4], m[5], m[6]) : null;
    }
    $scope.hideActivationPopup = function () {
        $('.pop_activation').fadeOut();
        $('body').css('overflow-y', 'visible');
    }
    $scope.showDeActivationPopup = function (template) {
        $scope.currentProduct = template;
        $('.menu_open').removeClass('act');
        $('.wrap').removeClass('act');
        $('.pop__content').removeClass('act');
        $('body').css('overflow-y', 'hidden');
        $('.pop_deactivation').fadeIn();
    }
    $scope.hideDeActivationPopup = function () {
        $('.pop_deactivation').fadeOut();
        $('body').css('overflow-y', 'visible');
    }
    $scope.deActivate = function (purchase) {
        $scope.currentProduct = purchase;
        var id = $scope.currentProduct.id;
        $scope.currentProduct.is_activated = 0;
        var updateData = {
            Product: {
                id: id,
                is_activated: 0
            }
        };
        MotoApi.post('activate/product/' + id, updateData).then(function (data) {
            $scope.currentProduct = data.data.product;
        });
        $scope.hideDeActivationPopup();
    };
    $scope.requestUpdate = function (purchase) {
        $scope.currentProduct = purchase;
        var id = $scope.currentProduct.id;
        var updateData = {};
        MotoApi.post('requestupdate/product/' + id, updateData, {
            'text': 'Update requested, please check your email',
            'color': 'yellow'
        }).then(function (data) {
            //$scope.currentProduct  = data.data.product;
        });
    };
    $scope.activateProduct = function (purchaseData) {
        $scope.productData = {};
        var updateData = {
            Product: {
                id: $scope.currentProduct.id
            }
        };
        if (purchaseData.ip) {
            updateData.Product.ip = purchaseData.ip;
        }
        if (purchaseData.domain) {
            updateData.Product.domain = purchaseData.domain;
        }
        if (purchaseData.domain || purchaseData.ip) {
            updateData.Product.is_activated = 1;
        }
        MotoApi.post('activate/product/' + $scope.currentProduct.id, updateData).then(function (data) {
            $scope.currentProduct.is_activated = data.data.product.is_activated;
            $scope.currentProduct.domain = data.data.product.domain;
            $scope.currentProduct.ip = data.data.product.ip;
            $scope.currentProduct.activation_count = data.data.product.activation_count;
        });
        $scope.hideActivationPopup();
    };

    /**
     *
     * @param product
     * @returns {boolean}
     */
    $scope.checkVersion = function (product) {
        if (typeof product !== "undefined"
            && typeof product.hasAllowedNewUpdate !== "undefined"
            && typeof product.versionNewUpdate !== "undefined"
            && +product.hasAllowedNewUpdate === 1
        ) {
            return true;
        }
        return false;
    };


    /*currency*/
    var _cacheCurrency = currencyCache.get('currency');
    if (_cacheCurrency) {
        if (typeof _cacheCurrency !== "undefined"
            && typeof _cacheCurrency.symbol !== "undefined"
        ) {
            $scope.currencySymbol = _cacheCurrency.symbol;
            $scope.rebrandingPrice = Math.floor($scope.rebrandingPrice * +_cacheCurrency.rate);
        }
    } else {
        $scope.motoShopCurrency.then(function (data) {
            if (typeof data !== "undefined"
                && typeof data.currency !== "undefined"
                && typeof data.currency.symbol !== "undefined"
            ) {
                $scope.rebrandingPrice = Math.floor($scope.rebrandingPrice * +data.currency.rate);
                $scope.currencySymbol = data.currency.symbol;
                currencyCache.put('currency', data.currency);
            }
        }, function (error) {
        });
    }

    /**
     *
     * @param productId
     * @returns {string}
     */
    $scope.productPreview = function (productId) {
        var productIdS = productId.toString();
        return 'https://s.tmimgcdn.com/scr/201x163/' + productIdS.substring(0, 3) + '00/' + productId + '-med.jpg';
    };

    /**
     * Resend License Key
     * @param $event
     * @param productId
     */
    $scope.resendLicenseKey = function ($event, productId) {
        if (typeof $event !== "undefined" && $event !== null) {
            $event.preventDefault();
            $event.target.disabled = true;
        }
        $translate.refresh();
        var message = $translate.instant('MESSAGES_TPL.MSG_RESEND_LICENSE_KEY', {
            email: $window.user.email,
        });

        MotoApi
            .post('product/resend-license-key', {
                productId: productId,
                _rnd: Date.now()
            })
            .then(function (data) {
                if (typeof $event !== "undefined" && $event !== null) {
                    $event.target.disabled = false;
                }

                if (typeof data !== "undefined"
                    && typeof data.body !== "undefined"
                    && typeof data.body.idQueue !== "undefined"
                    && typeof data.status !== "undefined"
                    && !!data.status === true
                ) {
                    $rootScope.showServiceMessage("green", message);
                    return false;
                }
                $rootScope.showServiceMessage("red", "MESSAGES_TPL.MSG_ERROR");
            }, function (error) {
                if (typeof $event !== "undefined" && $event !== null) {
                    $event.target.disabled = false;
                }
                $rootScope.showServiceMessage("red", "MESSAGES_TPL.MSG_ERROR");
            });
    }
});