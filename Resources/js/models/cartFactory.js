/**
 * Created by Developer on 05.04.2015.
 */
bookShop.factory('cartFactory', function () {
    this.cart = {
        books: {}
    };

    this.cart.init = function(data) {

        var length = data.length || 1;

        for(var i = 0; i < length; i++) {
            //this.books[data[book].idBook] = data[book];
            this.books[data[i].idBook] = {
                'idBook': data[i].idBook,
                'Quantity': Number(data[i].Quantity || 0),
                'Price': Number(data[i].Price)
            }
        }
    };
    this.cart.save = function () {
        localStorage.setItem('cart', JSON.stringify(this.books));
    };
    this.cart.add = function(book, count) {

        if(undefined === this.books[book.idBook]) {
            this.init(book);
        }
        //book.Quantity = (count || 1) + ((this.books[book.idBook] === undefined)? 0 : this.books[book.idBook].Quantity);

        this.books[book.idBook].Quantity += count || 1;

        //this.books[book.idBook] = book;
        //this.save();
    };
    this.cart.getBookCount = function () {
        var result = 0;

        for(book in this.books) {
            result += this.books[book].Quantity;
        }

        return result;
    };
    this.cart.remove = function (product) {
        delete this.books[product.id];
        this.save();
    };
    this.cart.getTotalAmount = function () {
        var result = 0;

        for(book in this.books) {
            result += this.books[book].price * this.books[book].count;
        }

        return result;
    };
    this.cart.clean = function () {
        this.products = {};
        this.save();
    };

    return this.cart;
});