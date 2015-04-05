/**
 * Created by Developer on 04.04.2015.
 */
bookShop.controller('loginController', function ($scope, $http) {
    var self = this;

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
            }
        });
    };

    //this.location = $location;
});