/**
 * Created by Developer on 07.04.2015.
 */
bookShop.service('langService', function ($http) {
    this.getBooks = function (lang, callback) {
        $http.get('Resources/langs/' + lang).success(callback);
    };
});