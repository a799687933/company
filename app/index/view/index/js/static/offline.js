define(function(require, exports, module) {
    var $ = require('jquery');
    var _this;

    function Offline() {
        _this = this;
    }
    var offline = Offline.prototype;
    offline.loadOfflineInfo = function() {
        offline.afterLoadInfo();
    }
    offline.afterLoadInfo = function() {
        offline.carousel();
        offline.goShowInfo();
    }
    offline.carousel = function() {
        $(".off-main_visual").hover(function() {
            $("#ibtn_prev,#ibtn_next").fadeIn()
        }, function() {
            $("#ibtn_prev,#ibtn_next").fadeOut()
        });
        var $dragBln = false;
        $(".off-main_image").touchSlider({
            flexible: true,
            speed: 200,
            btn_prev: $("#ibtn_prev"),
            btn_next: $("#ibtn_next"),
            paging: $(".flicking_icon a"),
            counter: function(e) {
                $(".flicking_icon a").removeClass("on").eq(e.current - 1).addClass("on");
            }
        });
        $(".off-main_image").bind("mousedown", function() {
            $dragBln = false;
        });
        $(".off-main_image").bind("dragstart", function() {
            $dragBln = true;
        });
        $(".off-main_image a").click(function() {
            if ($dragBln) {
                return false;
            }
        });
        var timer = setInterval(function() {
            $("#ibtn_next").click();
        }, 2000);
        $(".off-main_visual").hover(function() {
            clearInterval(timer);
        }, function() {
            timer = setInterval(function() {
                $("#ibtn_next").click();
            }, 2000);
        });
        $(".off-main_image").bind("touchstart", function() {
            clearInterval(timer);
        }).bind("touchend", function() {
            timer = setInterval(function() {
                $("#ibtn_next").click();
            }, 2000);
        });
    }
    offline.goShowInfo = function() {
        var showBtn = $(".showInfo");
        $(".offInfo").on('mouseout', function(event) {
            $(this).removeClass('active').prev().removeClass('active');
            showBtn.show();
        })
        $(".offInfo").on('mouseover', function() {
            $(this).addClass('active').prev().addClass('active');
            showBtn.hide();
        });
        var offImg = $(".offImg");
        var span = $(".offlineTop span");
        span.each(function(index,ele){
            $(this).on('click',function(){
                if($(this).prop('class').indexOf('active')>-1 || index==1){
                    return ;
                }
                span.removeClass('active').eq(index).addClass('active');
                if(index==0){
                    offImg.fadeOut(500);
                }else if(index==2){
                    offImg.show(500);
                }
            });
        });
        $(".goCheckDetail").on('click',function(){
            offImg.fadeIn(500);
            if(span.length>0){
                span.eq(0).removeClass('active');
                span.eq(2).addClass('active');
            }
        });
        offImg.on('mouseout',function(){
            $(this).hide(500);
            if(span.length>0){
                span.eq(2).removeClass('active');
                span.eq(0).addClass('active');
            }
        });
    }
    module.exports = Offline;
    return Offline;
});
