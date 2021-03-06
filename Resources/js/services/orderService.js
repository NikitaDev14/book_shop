bookShop.service('orderService', function ($http) {
    this.getPayMethods = function (callback) {
        $http.get('index.php?controller=Order&action=getPayMethods').
            success(callback);
    };
    this.sendOrder = function (payMethod, callback) {
        $http.get('index.php?controller=Order&action=addOrder&payMethod='
            + payMethod).success(callback);
    };
    this.getOrders = function (callback) {
        $http.get('index.php?controller=Order&action=getOrders').
            success(callback);
    };
    this.getOrderDetails = function (idOrder, callback) {
        $http.get('index.php?controller=Order&action=getOrderDetails&idOrder='
            + idOrder).success(callback);
    };
});