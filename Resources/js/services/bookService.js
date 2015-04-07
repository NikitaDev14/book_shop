bookShop.service('bookService', function ($http) {
    this.getBooks = function (callback) {
        $http.get('index.php?controller=Book&action=getList').success(callback);
    };
});