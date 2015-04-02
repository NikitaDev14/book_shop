/**
 * Created by Developer on 02.04.2015.
 */
bookShop.controller('signupController', function ($scope, $location, $http) {
    var self = this;

    this.template = {
        email: '[0-9a-z_]+@[0-9a-z_]+\\.[a-z]{1,5}',
        password: '.{4,}'
    };

    this.signup = function () {
        $http.post('index.php', {action: 'Signup', email: $scope.email, password: $scope.password}).success(function (response) {
            self.response = response;
        });
    };

    this.location = $location;
});