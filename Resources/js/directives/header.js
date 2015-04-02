/**
 * Created by Developer on 02.04.2015.
 */
bookShop.directive('header', function () {
    return {
        restrict: 'A',
        replace: true,
        template:
        '<div>'
            +'<a class="btn btn-success" href="#/" role="button">Main page</a>'
            +'<a class="btn btn-info" href="#/cart" role="button">'
                +'Cart <span class="badge"></span>'
            +'</a>'
        +'</div>'
    }
});