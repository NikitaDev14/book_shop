/**
 * Created by Developer on 01.04.2015.
 */
bookShop.config(function($stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise('/');

    $stateProvider
        .state('index', {
            url: '/',
            templateUrl: '/book_shop/Resources/html/bookList.html',
            controller: 'bookController'
        })
        .state('bookDetails', {
            url: '/book/:id',
            templateUrl: '/book_shop/Resources/html/bookDetails.html',
            controller: 'bookController'
        })
        .state('signup', {
            url: '/signup',
            templateUrl: '/book_shop/Resources/html/signup.html',
            controller: 'userController'
        })
        .state('cart', {
            url: '/cart',
            templateUrl: '/book_shop/Resources/html/cart.html',
            controller: 'cartController'
        })
        .state('login', {
            url: '/login',
            templateUrl: '/book_shop/Resources/html/login.html',
            controller: 'userController'
        })
        .state('order', {
            url: '/order',
            templateUrl: '/book_shop/Resources/html/order.html',
            controller: 'orderController'
        })
});