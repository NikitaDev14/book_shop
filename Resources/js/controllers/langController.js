/**
 * Created by Developer on 07.04.2015.
 */
bookShop.controller('langController', function (langService, langFactory) {
    var self = this;

    this.lang = langFactory;

    this.changeLang = function (lang) {
        self.lang.set(lang);

        langService.getLang(self.lang.get(), function (data) {
            self.template = data;
        });
    };

    langService.getLang(self.lang.get(), function (data) {
        self.template = data;
    });
});