app.factory('helperFactory', function($http){
    var obj = {};

    obj.getData = function(pathname) {
        return $http.get(pathname);
    };

    return obj;

});