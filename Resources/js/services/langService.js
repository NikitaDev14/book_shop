/**
 * Created by Developer on 07.04.2015.
 */
bookShop.service('langService', function ($http) {
    this.getLang = function (lang, callback) {
        $http.get('Resources/langs/' + lang + '.json').success(callback);
    };
});