define(function(require, exports, module) {
    var $ = require('jquery');

    function Common() {
        this.url = 'http://www.juiceepoch.com/juice/rest/api/member';
        this.imgUrl = 'http://www.juiceepoch.com/juice/rest/api/member';
    }
    var common = Common.prototype;
    common.isLogin = function() {
        var user = localStorage.getItem('user');
        if (!!user) {
            return true;
        } else {
            return false;
        }
    }

    return Common;
});
