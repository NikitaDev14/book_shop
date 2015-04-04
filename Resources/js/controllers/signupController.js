/**
 * Created by Developer on 02.04.2015.
 */
bookShop.controller('signupController', function ($scope, $http) {
    var self = this;

    this.template = {
        email: '[0-9a-z_]+@[0-9a-z_]+\\.[a-z]{1,5}',
        password: '.{4,}'
    };

    this.signup = function () {
        $http.post('index.php', {
            action: 'Signup', email: $scope.email,
            password: $scope.password,
            passwordRepeat: $scope.passwordRepeat
        }).success(function (response) {
            if(response === "1") {
                self.message = 'You are registered successfully.';
            }
            else
            {
                self.message = 'This email has already registered.';
            }
        });
    };

    //this.location = $location;
});