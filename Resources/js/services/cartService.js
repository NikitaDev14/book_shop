bookShop.service('cartService', function ($http) {
    this.getCart = function (callback) {
        $http.get('index.php?' +
                'controller=Cart' +
                '&action=getCart'
        ).success(callback);
    };

    this.addToCart = function (book, count, callback) {
        $http.get('index.php?' +
                'controller=Cart' +
                '&action=addToCart' +
                '&idBook='+book+
                '&quantity='+count
        ).success(callback);
    };

    this.deleteFromCart = function (book, callback) {
        $http.get('index.php?' +
                'controller=Cart' +
                '&action=deleteFromCart' +
                '&idBook='+book
        ).success(callback);
    };

    this.updateCount = function (book, count, callback) {
        $http.get('index.php?' +
                'controller=Cart' +
                '&action=updateQuantity' +
                '&idBook='+book+
                '&quantity='+count
        ).success(callback);
    };
});