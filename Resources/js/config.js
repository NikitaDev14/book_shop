/**
 * Created by Developer on 01.04.2015.
 */
bookShop.config(function($stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise('/');

    $stateProvider
        .state('index', {
            url: '/',
            templateUrl: 'Resources/html/bookList.html',
            controller: 'bookController'
        })
        .state('bookDetails', {
            url: '/book/:id',
            templateUrl: 'Resources/html/bookDetails.html',
            controller: 'bookController'
        })
        .state('signup', {
            url: '/signup',
            templateUrl: 'Resources/html/signup.html',
            controller: 'userController'
        })
        .state('cart', {
            url: '/cart',
            templateUrl: 'Resources/html/cart.html',
            controller: 'cartController'
        })
        .state('login', {
            url: '/login',
            templateUrl: 'Resources/html/login.html',
            controller: 'userController'
        })
        .state('order', {
            url: '/order',
            templateUrl: 'Resources/html/order.html',
            controller: 'orderController'
        })
        .state('orderList', {
            url: '/my_orders',
            templateUrl: 'Resources/html/orderList.html',
            controller: 'orderController'
        })
});