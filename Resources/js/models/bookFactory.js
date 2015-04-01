/**
 * Created by Developer on 01.04.2015.
 */
bookShop.factory('bookFactory', function () {
    this.book = {
        list: {}
    };

    this.book.init = function (data) {
        for(item in data) {
            this.list[data[item].idBook] = data[item];
        }
    };

    return this.book;
});