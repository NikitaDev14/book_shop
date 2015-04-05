/**
 * Created by Developer on 05.04.2015.
 */
bookShop.factory('cartFactory', function () {
    this.cart = {
        books: {}
    };

    this.cart.load = function() {
        this.books = JSON.parse(localStorage.getItem('cart')) || {};
    };
    this.cart.save = function () {
        localStorage.setItem('cart', JSON.stringify(this.books));
    };
    this.cart.add = function(product, count) {
        product.count = (count || 1) + ((this.books[product.id] === undefined)? 0 : Number(this.books[product.id].count));

        this.books[product.id] = product;
        this.save();
    };
    this.cart.getProductCount = function () {
        var result = 0;

        for(book in this.books) {
            result += this.books[book].count;
        }

        //return Object.keys(this.products).length;

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