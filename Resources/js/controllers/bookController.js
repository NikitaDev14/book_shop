/**
 * Created by Developer on 01.04.2015.
 */
bookShop.controller('bookController', function (bookService, bookFactory, $stateParams) {
    var self = this;

    bookService.getBooks(function (data) {
        bookFactory.init(data);

        if($stateParams.id !== undefined) {
            self.books = bookFactory.list[$stateParams.id];
        }
        else
        {
            self.books = bookFactory.list;
        }
    });
});