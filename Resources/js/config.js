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
        .state('cart', {
            url: '/cart',
            templateUrl: '/book_shop/Resources/html/cart.html',
            controller: 'cartController'
        })
});