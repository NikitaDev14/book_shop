/**
 * Created by Developer on 07.04.2015.
 */
bookShop.factory('langFactory', function () {
    this.lang = {};

    this.lang.set = function (lang) {
        localStorage.setItem('lang', lang);
    };
    this.lang.get = function () {
        return localStorage.getItem('lang') || 'ua';
    };


    return this.lang;
});