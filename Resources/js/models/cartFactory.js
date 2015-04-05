/**
 * Created by Developer on 05.04.2015.
 */
bookShop.factory('cartFactory', function (cartService) {
    this.cart = {
        books: {}
    };

    this.cart.init = function(data) {

        for(var book in data) {
            this.books[data[book].idBook] = {
                'idBook': data[book].idBook,
                'Name': data[book].Name,
                'Quantity': Number(data[book].Quantity || 0),
                'Price': Number(data[book].Price)
            }
        }

        /*
         var length = data.length || 1;

         for(var i = 0; i < length; i++) {
         this.books[data[i].idBook] = {
         'idBook': data[i].idBook,
         'Quantity': Number(data[i].Quantity || 0),
         'Price': Number(data[i].Price)
         }
         }
         */
    };
    this.cart.save = function (book, count) {
        //localStorage.setItem('cart', JSON.stringify(this.books));

        cartService.updateCount(book, count, function (data) {
            console.log(data);
        });
    };
    this.cart.add = function(book, count) {
        count = count || 1;

        if(undefined === this.books[book.idBook]) {
            this.books[book.idBook] = {
                'idBook': book.idBook,
                'Name': book.Name,
                'Quantity': Number(book.Quantity || 0),
                'Price': Number(book.Price)
            }
        }
        //book.Quantity = (count || 1) + ((this.books[book.idBook] === undefined)? 0 : this.books[book.idBook].Quantity);

        this.books[book.idBook].Quantity += count;

        cartService.addToCart(book.idBook, count, function (data) {
            console.log(data);
        });

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
    this.cart.remove = function (book) {
        delete this.books[book];

        cartService.deleteFromCart(book, function (data) {
            console.log(data);
        });
    };
    this.cart.getTotalAmount = function () {
        var result = 0;

        for(book in this.books) {
            result += this.books[book].Price * this.books[book].Quantity;
        }

        return result;
    };
    this.cart.clean = function () {
        this.books = {};
        this.save();
    };

    return this.cart;
});