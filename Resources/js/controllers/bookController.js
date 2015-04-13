bookShop.controller('bookController',
    function ($scope, bookService, userService, bookFactory,
              langFactory, $stateParams) {

    var self = this;

        this.lang = langFactory;

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