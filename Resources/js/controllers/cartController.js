/**
 * Created by Developer on 02.04.2015.
 */
bookShop.controller('cartController', function (userService, cartService, cartFactory, langFactory, $location) {
    var self = this;

    this.lang = langFactory;

    this.countTemplate = '[0-9]+';

    userService.isValidUser(function (isValid) {
        self.isValidUser = Boolean(isValid);

        if('1' === isValid) {
            cartService.getCart(function (data) {

                self.cart = cartFactory;

                self.cart.init(data);
            });
        }
        else
        {
            //$location.path('/login');
        }
    });
});