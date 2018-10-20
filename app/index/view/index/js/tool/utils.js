define(function(require, exports, module) {
    var $ = require('jquery');
    var _this;

    function ZUtils() {
        _this = this;
        _this.ajax = {};
        _this.ajax.go = function(nowUrl, type, data, _success_func, _error_func) {
            if (type == 'get') {
                //hu指包含: , =的参数值的字段
                if (data.hu) {
                    var temp = data.hu;
                    delete data.hu;
                    var str = JSON.stringify(data);
                    nowUrl += '?' + str.slice(1, str.length - 1).replace(/[\"|\']/g, '').replace(/\:/g, '=').replace(/\,/g, '&').replace(/http\=/g, 'http:').replace(/https\=/g, 'https:');
                    nowUrl += '&hu=' + temp;
                } else {
                    var str = JSON.stringify(data);
                    nowUrl += '?' + str.slice(1, str.length - 1).replace(/[\"|\']/g, '').replace(/\:/g, '=').replace(/\,/g, '&').replace(/http\=/g, 'http:').replace(/https\=/g, 'https:');
                }
                data = '';
            }
            if (_this.isIELt9()) {
                if (data.hu) {
                    var temp = data.hu;
                    delete data.hu;
                    var str = JSON.stringify(data);
                    var xhrData = str.slice(1, str.length - 1).replace(/[\"|\']/g, '').replace(/\:/g, '=').replace(/\,/g, '&').replace(/http\=/g, 'http:').replace(/https\=/g, 'https:');
                    xhrData += '&hu=' + temp;
                } else {
                    var str = JSON.stringify(data);
                    var xhrData = str.slice(1, str.length - 1).replace(/[\"|\']/g, '').replace(/\:/g, '=').replace(/\,/g, '&').replace(/http\=/g, 'http:').replace(/https\=/g, 'https:');
                }
                if (type == 'post') {
                    if (XDomainRequest) {
                        var xdr = new XDomainRequest();
                        if (xdr) {
                            xdr.onerror = function() {
                                _error_func();
                            };
                            xdr.onload = function() {
                                var data = eval('(' + xdr.responseText + ')');
                                _success_func(data);
                            };
                            xdr.open(type, nowUrl + '?' + xhrData);
                            xdr.send();
                        } else {
                            alert('当前浏览不支持post跨域请求，请更换Chrome、FireFox、IE10+，国内浏览器请开启极速模式，不要使用兼容模式！');
                        }
                    } else if (XMLHttpRequest) {
                        var xhr = new XMLHttpRequest();
                        if ("withCredentials" in xhr) {
                            xhr.open(type, nowUrl, true);
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState == 4) {
                                    var data = eval('(' + xhr.responseText + ')');
                                    _success_func(data);
                                }
                            };
                            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            xhr.send(xhrData);
                        }
                    } else {
                        alert('当前浏览不支持跨域请求，请更换Chrome、FireFox、IE10+，国内浏览器请开启极速模式，不要使用兼容模式！');
                    }
                } else {
                    var xhr = _this.createCORSRequest(type, nowUrl);
                    if (!xhr) {
                        tipInfo('浏览器限制了跨域请求，无法正常操作！');
                    } else {
                        xhr.onload = function() {
                            var data = eval('(' + xhr.responseText + ')');
                            _success_func(data);
                        }
                        xhr.onerror = function() {
                            _error_func();
                        };
                        xhr.send(xhrData);
                    }
                }

            } else {
                $.ajax({
                    type: type,
                    url: nowUrl,
                    data: data,
                    beforeSend: function(request) {
                        //request.setRequestHeader("Cookie", 'JSESSIONID='+utils.JSESSIONID);
                        // request.setRequestHeader("Keep-Alive", 'timeout=500000, max=1000000');
                    },
                    dataType: 'json',
                    success: function(data) {
                        _success_func(data);
                    },
                    error: function(data) {
                        _error_func(data);
                    }
                });
            }
        }
        _this.terminal = {
            platform: function() {
                var u = navigator.userAgent,
                    app = navigator.appVersion;
                return {
                    // android终端或者uc浏览器
                    android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1,
                    // 是否为iPhone或者QQHD浏览器
                    iPhone: u.indexOf('iPhone') > -1,
                    // 是否iPad
                    iPad: u.indexOf('iPad') > -1
                };
            }(),
            language: (navigator.browserLanguage || navigator.language).toLowerCase()
        }
    }

    ZUtils.prototype.isNull = function(obj, tip) {
        if (typeof obj == 'undefined' || obj == null || obj == 'null' || obj == '') {
            if (tip) {
                _this.tip(tip);
            }
            return true;
        } else {
            return false;
        }
    }
    ZUtils.prototype.isNum = function(num) {
        if (!isNaN(num)) {
            return true;
        } else {
            return false;
        }
    }
    ZUtils.prototype.checkMobile = function(obj) {
        var value = obj.val();
        var reg = /^(13[0-9]|14[7]|15[0-9]|17[0|1|7|8|9]|18[0-9])\d{8}$/;
        if (reg.exec(value)) {
            return true;
        } else {
            _this.tip('请输入正确的手机号码！');
            return false;
        }
    }
        ZUtils.prototype.checkMobile1 = function(obj) {
        var value = obj;
        var reg = /^(13[0-9]|14[7]|15[0-9]|17[0|1|7|8|9]|18[0-9])\d{8}$/;
        if (reg.exec(value)) {
            return true;
        } else {
            _this.tip('请输入正确的手机号码！');
            return false;
        }
    }
    
    ZUtils.prototype.checkPassword = function(obj) {
        var value = obj.val();
        var reg = /^[0-9a-zA-Z]{8,20}$/g;
        if (reg.exec(value)) {
            return true;
        } else {
            _this.tip('请输入8-20位由数字或字母组成的密码！');
            return false;
        }
    }
    ZUtils.prototype.checkSecondPwd = function(obj1, obj2) {
        if (obj1.val() == obj2.val()) {
            return true;
        } else {
            _this.tip('两次密码输入不一致！');
            return false;
        }
    }
    
        ZUtils.prototype.checkSecondPwd1 = function(obj1, obj2) {
        if (obj1 == obj2) {
            return true;
        } else {
            _this.tip('两次密码输入不一致！');
            return false;
        }
    }
    
    ZUtils.prototype.parseTime = function(time, fmt) {
        Date.prototype.Format = function(fmt) {
            var o = {
                "M+": this.getMonth() + 1, //月份
                "d+": this.getDate(), //日
                "h+": this.getHours(), //小时
                "m+": this.getMinutes(), //分
                "s+": this.getSeconds(), //秒
                "q+": Math.floor((this.getMonth() + 3) / 3), //季度
                "S": this.getMilliseconds() //毫秒
            };
            if (/(y+)/.test(fmt)) {
                fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
            }
            for (var k in o) {
                if (new RegExp("(" + k + ")").test(fmt)) {
                    fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
                }
            }
            return fmt;
        }
        time = new Date(time).Format(fmt);
        return time;
    }
    ZUtils.prototype.goBack = function() {
        history.go(-1);
    }
    ZUtils.prototype.goHref = function(href) {
        window.location.href = link;
    }
    ZUtils.prototype.setCookie = function(name, value, setTime, time) {
        var Days = 10;
        var exp = new Date();
        if (setTime) {
            exp.setTime(exp.getTime() + time);
        } else {
            exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
        }
        document.cookie = name + "=" + encodeURI(value) + ";expires=" + exp.toGMTString() + ";path=/";
    }
    ZUtils.prototype.getCookie = function(name) {
        var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
        if (arr = document.cookie.match(reg))
            return decodeURI(arr[2]);
        else
            return null;
    }
    ZUtils.prototype.delCookie = function(name) {
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval = utils.getCookie(name);
        if (cval != '') {
            utils.setCookie(name, '1');
        }
    }
    ZUtils.prototype.getSecurityCode = function(length) {
        var chars = 'ABCDEFGHJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var code = '';
        for (var i = 0; i < length; i++) {
            code += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return code;
    }
    ZUtils.prototype.trimAll = function(str, is_global) {
        var result;
        result = str.toString().replace(/(^\s+)|(\s+$)/g, "");
        if (is_global.toLowerCase() == "g") {
            result = result.replace(/\s/g, "");
        }
        return result;
    }
    ZUtils.prototype.tipInfo = function(info, closeByUser, closeWait, isNormal) {
        if (!isNormal) {
            $('#alert-div').prop('class', 'alert alert-danger cl-fix').show().find('.detail').html(info);
        } else {
            $('#alert-div').prop('class', 'alert alert-info cl-fix').show().find('.detail').html(info);
        }
        if (closeByUser) {
            $(".title-info").html('温馨提示');
            $(".close").show();
        } else if (closeWait) {
            $(".title-info").html('温馨提示');
            $(".close").hide();
        } else {
            $(".close").show();
            setTimeout(function() {
                $('#alert-div').hide();
            }, 2000);
        }
    }
    ZUtils.prototype.deleteZero = function(str) {
        return str.toString().charAt(str.length - 1) == '0' ? deleteZero(str.slice(0, str.length - 1)) : parseFloat(str);
    }
    ZUtils.prototype.arrIndexOf = function(val) {
        for (var i = 0; i < this.length; i++) {
            if (this[i] == val) {
                return i;
            }
        }
        return -1;
    }
    ZUtils.prototype.remove = function(arr, val) {
        var index = this.arrIndexOf(val);
        if (index > -1) {
            arr.splice(index, 1);
        }
    }
    ZUtils.prototype.isPC = function() {
        var userAgentInfo = navigator.userAgent;
        var Agents = ["Android", "iPhone",
            "SymbianOS", "Windows Phone",
            "iPad", "iPod"
        ];
        var flag = true;
        for (var v = 0; v < Agents.length; v++) {
            if (userAgentInfo.indexOf(Agents[v]) > 0) {
                flag = false;
                break;
            }
        }
        return flag;
    }
    ZUtils.prototype.isIELt8 = function() {
        var appVersion = navigator.userAgent.split(";")[1].replace(/\s/g, '');
        if (navigator.appName == "Microsoft Internet Explorer" && appVersion == "MSIE6.0") {
            return true;
        } else if (navigator.appName == "Microsoft Internet Explorer" && appVersion == "MSIE7.0") {
            return true;
        } else if (navigator.appName == "Microsoft Internet Explorer" && appVersion == "MSIE8.0") {
            return true;
        } else if (navigator.appName == "Microsoft Internet Explorer" && appVersion == "MSIE5.0") {
            return true;
        } else if (navigator.appName == "Microsoft Internet Explorer" && appVersion == "MSIE5.5") {
            return true;
        }
        return false;
    }
    ZUtils.prototype.isIELt7 = function() {
        var appVersion = navigator.userAgent.split(";")[1].replace(/\s/g, '');
        if (navigator.appName == "Microsoft Internet Explorer" && appVersion == "MSIE6.0") {
            return true;
        } else if (navigator.appName == "Microsoft Internet Explorer" && appVersion == "MSIE7.0") {
            return true;
        } else if (navigator.appName == "Microsoft Internet Explorer" && appVersion == "MSIE5.0") {
            return true;
        } else if (navigator.appName == "Microsoft Internet Explorer" && appVersion == "MSIE5.5") {
            return true;
        }
        return false;
    }
    ZUtils.prototype.tip = function(info) {
        var err = $(".error");
        err.show();
        err.html(info).animate({
            bottom: 80
        }, 200, function() {
            setTimeout(function() {
                err.fadeOut(200);
                err.animate({
                        bottom: 0
                    },
                    200,
                    function() {

                    });
            }, 1500);
        });
    }
    ZUtils.prototype.isIELt9 = function() {
        var appVersion = navigator.userAgent.split(";")[1].replace(/\s/g, '');
        if (navigator.appName == "Microsoft Internet Explorer" && appVersion == "MSIE6.0") {
            return true;
        } else if (navigator.appName == "Microsoft Internet Explorer" && appVersion == "MSIE7.0") {
            return true;
        } else if (navigator.appName == "Microsoft Internet Explorer" && appVersion == "MSIE8.0") {
            return true;
        } else if (navigator.appName == "Microsoft Internet Explorer" && appVersion == "MSIE9.0") {
            return true;
        } else if (navigator.appName == "Microsoft Internet Explorer" && appVersion == "MSIE5.0") {
            return true;
        } else if (navigator.appName == "Microsoft Internet Explorer" && appVersion == "MSIE5.5") {
            return true;
        }
        return false;
    }
    ZUtils.prototype.isActive = function(obj) {
        if (obj.prop('class').indexOf('active') > -1) {
            return true;
        } else {
            return false;
        }
    }
    ZUtils.prototype.createCORSRequest = function(method, url) {
        var xhr = new XMLHttpRequest();
        if ("withCredentials" in xhr) {
            xhr.open(method, url, true);
        } else if (typeof XDomainRequest != "undefined") {
            xhr = new XDomainRequest();
            xhr.open(method, url);
        } else {
            xhr = null;
        }
        return xhr;
    }
    ZUtils.prototype.object = function(old) {
        function F() {};
        F.prototype = old;
        return new F();
    }
    ZUtils.prototype.extend = function(Child, Parent) {
        var F = function() {};　　　　
        F.prototype = Parent.prototype;　　　　
        Child.prototype = new F();　　　　
        Child.prototype.constructor = Child;　 
        Child.uber = Parent.prototype;
    }
    return ZUtils;
});
