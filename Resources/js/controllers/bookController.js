/**
 * Created by Developer on 01.04.2015.
 */
bookShop.controller('bookController', function ($scope, bookService, bookFactory, $stateParams) {
    var self = this;

    bookService.getBooks(function (data) {
        bookFactory.init(data.books);

        self.authors = data.authors;
        self.genres = data.genres;

        if($stateParams.id !== undefined) {
            self.books = bookFactory.list[$stateParams.id];
        }
        else
        {
            self.books = bookFactory;
        }
    });
});