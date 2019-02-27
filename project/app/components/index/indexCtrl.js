app.controller("indexCtrl", function($scope, helperFactory) {

    $scope.data = {
        checkAllCheckboxes: false
    };

    $scope.json1 = [];
    helperFactory.getData('json1.json').then(function(data) {
        $scope.json1 = data.data;
    });

    $scope.json2 = [];
    helperFactory.getData('json2.json').then(function(data) {
        $scope.json2 = data.data;
    });

    $scope.addColor = function(colorName, hexValue){
        var count = $scope.json2.colorsArray.length+1;
        if ( count >= 10 ) {
            $('.btn_add_color').attr('disabled', true);
        }
        $scope.json2.colorsArray.push({
            'colorName' : colorName,
            'hexValue' : hexValue
        });
        $scope.newColorName = '';
        $scope.newColorHex = '';
    };

    $scope.removeColor = function(index){
        $scope.json2.colorsArray.splice(index, 1);
        var count = $scope.json2.colorsArray.length;
        if ( count < 10 ) {
            $('.btn_add_color').attr('disabled', false);
        }
    }

    $scope.checkAllCheckboxesEvent = function(){
        angular.forEach($scope.json2.colorsArray, function(value, key) {
          value.isActive = $scope.data.checkAllCheckboxes;
        });
    }

    $scope.removeActiveAll = function(val){
        $scope.data.checkAllCheckboxes = false;
    }

    $scope.removeSelected = function(){
        var i = 0;
        angular.forEach($scope.json2.colorsArray, function(value, key) {
            if (value.isActive == true) {
                $scope.json2.colorsArray.splice(i, 1);
                console.log(i);                
            }
            i++;
        });
    }

});