/**
 * Created by Developer on 06.04.2015.
 */
bookShop.controller('orderController', function ($scope, userService, orderService, cartFactory, langFactory, $location) {
    var self = this;

    this.lang = langFactory;

    this.location = $location;

    userService.isValidUser(function (isValid) {

        if('1' === isValid) {

            orderService.getPayMethods(function (data) {
                self.payMethods = data;
            });

            self.sendOrder = function (payMethod) {

                orderService.sendOrder(payMethod, function (isSent) {

                    if ('1' === isSent) {
                        cartFactory.clean();
                    }
                });
            };

            orderService.getOrders(function (orders) {
                self.orders = orders;
            });

            self.getOrderDetails = function (idOrder) {
                orderService.getOrderDetails(idOrder, function (data) {
                    self.orderDetails = data;
                });
            };
        }
        else
        {
            $location.path('/login');
        }
    });
});