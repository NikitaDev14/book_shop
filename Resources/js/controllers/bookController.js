/**
 * Created by Developer on 01.04.2015.
 */
bookShop.controller('bookController',
    function ($scope, bookService, userService, bookFactory, $stateParams) {

    var self = this;

    userService.isValidUser(function (data) {
        self.isValidUser = Boolean(data);
    });

    bookService.getBooks(function (data) {
        bookFactory.init(data.books);

        self.authors = data.authors;
        self.genres = data.genres;

        if(undefined !== $stateParams.id) {
            self.books = bookFactory.list[$stateParams.id];
        }
        else
        {
            self.books = bookFactory;
        }
    });
});