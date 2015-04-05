/**
 * Created by Developer on 02.04.2015.
 */
bookShop.controller('cartController', function (userService, cartService) {
    userService.isValidUser(function (isValid) {
        if('1' === isValid) {
            cartService.getCart(function (data) {
                console.log(data);
            });
        }
    });


});