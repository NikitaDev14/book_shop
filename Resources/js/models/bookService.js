var bookShop = angular.module('bookShop', ['ui.router']);

bookShop.service('bookService', function ($http) {
    this.getBooks = function (callback) {
        $http.get('index.php?client=books').success(callback);
    };
});