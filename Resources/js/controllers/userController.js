/**
 * Created by Developer on 05.04.2015.
 */
bookShop.controller('userController', function ($scope, $http, userService, $location) {
    this.template = {
        email: '[0-9a-z_]+@[0-9a-z_]+\\.[a-z]{1,3}',
        password: '.{4,}'
    };

    var self = this;

    userService.isValidUser(function (data) {
        self.isValidUser = data;
    });

    this.login = function () {
        userService.login($scope.email, $scope.password, function (data) {
            if('' === data) {
                self.response = 'Wrong data';
            }
            else {
                //$scope.email = $scope.password = '';

                //self.response = 'Hello';

                $location.path('/');
            }
        });
    };
    /*
    this.login = function () {
        $http.post('index.php', {
            action: 'Login',
            email: $scope.email,
            password: $scope.password
        }).success(function (response) {
            if('' === response) {
                self.response = 'Wrong data';
            }
            else {
                $scope.email = $scope.password = '';

                self.response = 'Hello';

                $location.path('/');
            }
        });
    };
    */
    this.logout = function () {
        userService.logout();
    };
    this.signup = function () {
        userService.signup($scope.email, $scope.password, $scope.passwordRepeat, function (data) {
            if('1' === data) {
                //$scope.email = $scope.password = $scope.passwordRepeat = '';

                //self.message = 'You are registered successfully.';

                $location.path('/');
            }
            else
            {
                self.message = 'This email has already registered.';
            }
        });
    };
    /*
    this.signup = function () {
        $http.post('index.php', {
            action: 'Signup',
            email: $scope.email,
            password: $scope.password,
            passwordRepeat: $scope.passwordRepeat
        }).success(function (response) {
            if('1' === response) {
                $scope.email = $scope.password = $scope.passwordRepeat = '';

                self.message = 'You are registered successfully.';

                $location.path('/');
            }
            else
            {
                self.message = 'This email has already registered.';
            }
        });
    };
    */

    //this.location = $location;
});