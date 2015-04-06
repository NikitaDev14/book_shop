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

    this.book.filter = function (author, genre) {
        var result = {};

        author = author || '';
        genre = genre || '';

        for(item in this.list) {
            if(this.list[item].Authors.indexOf(author) !==
                -1 && this.list[item].Genres.indexOf(genre) !== -1) {

                result[this.list[item].idBook] = this.list[item];
            }
        }

        return result;
    };

    return this.book;
});