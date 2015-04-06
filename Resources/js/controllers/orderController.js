/**
 * Created by Developer on 06.04.2015.
 */
bookShop.controller('orderController', function ($scope, userService, orderService, cartFactory, $location) {
    var self = this;

    self.location = $location;

    userService.isValidUser(function (isValid) {

        if('1' === isValid) {

            if(0 < cartFactory.getBookCount()) {

                orderService.getPayMethods(function (data) {
                    self.payMethods = data;
                });

                self.sendOrder = function (payMethod) {

                    orderService.sendOrder(payMethod, function (isSent) {

                        if('1' === isSent) {
                            cartFactory.clean();
                        }
                    });
                };
            }
            else{
                $location.path('/');
            }
        }
        else
        {
            $location.path('/login');
        }
    });
});