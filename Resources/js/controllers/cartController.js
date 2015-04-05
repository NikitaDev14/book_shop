/**
 * Created by Developer on 02.04.2015.
 */
bookShop.controller('cartController', function (userService, cartService, cartFactory) {
    var self = this;

    userService.isValidUser(function (isValid) {
        if('1' === isValid) {
            cartService.getCart(function (data) {
                console.log(data);

                cartFactory.init(data);

                self.bookCount = function () {
                    return cartFactory.getBookCount();
                };
                self.addToCart = function (book, count) {
                    cartFactory.add(book, count);
                };
            });
        }
    });
});