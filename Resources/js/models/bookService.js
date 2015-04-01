/**
 * Created by Developer on 01.04.2015.
 */
var bookShop = angular.module('bookShop', ['ui.router']);

bookShop.service('bookService', function ($http) {
    this.getBooks = function (callback) {
        $http.get('index.php?book=list').success(callback);
    };
});