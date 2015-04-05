/**
 * Created by Developer on 05.04.2015.
 */
bookShop.service('cartService', function ($http) {
    this.getCart = function (callback) {
        $http.post('index.php', {
            controller: 'Cart',
            action: 'getCart'
        }).success(callback);
    };

    this.addToCart = function (book, count, callback) {
        $http.post('index.php', {
            controller: 'Cart',
            action: 'add',
            book: book,
            quantity: count
        }).success(callback);
    }
});