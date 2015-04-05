/**
 * Created by Developer on 02.04.2015.
 */
bookShop.controller('cartController', function (userService, cartService, cartFactory) {
    var self = this;

    userService.isValidUser(function (isValid) {
        if('1' === isValid) {
            cartService.getCart(function (data) {

                self.cart = cartFactory;

                self.cart.init(data);
            });
        }
    });
});