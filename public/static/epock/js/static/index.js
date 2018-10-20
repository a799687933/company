define(function(require, exports, module) {
    var $ = require('jquery');
    var ZUtils = require('../tool/utils');
    var Common = require('../static/common');
    var Offline = require("../static/offline");
    var utils = new ZUtils();
    var common = new Common();
    var _this = this;
    var Index = function(now, max, seriesImgDiv) {
        _this = this;
        this.now = now;
        this.max = max;
        this.seriesImgDiv = $(seriesImgDiv);
        _this.user = {};
        
    }
    utils.extend(Index,Offline);
    var series = Index.prototype;
    series.setNow = function(now) {
        _this.now = now;
        _this.user.name="";
        _this.user.phone="";
        _this.user.email="";
        _this.user.ly="";
    }
    series.getNow = function() {
        return _this.now;
    }
    series.transform = function() {
        setInterval(function() {
            _this.autoTransform();
            var index = _this.now >= _this.max ? 0 : _this.now;
            if (_this.now >= _this.max - 1) {
                index = 0;
            } else {
                index = _this.now + 1;
            }
            _this.setNow(index);

        }, 1500);
    }
    series.autoTransform = function(){
        _this.seriesImgDiv.removeClass('active').eq(_this.now).addClass('active');
    }
    series.slider = function(){
        $(".main_visual").hover(function() {
            $("#btn_prev,#btn_next").fadeIn()
        }, function() {
            $("#btn_prev,#btn_next").fadeOut()
        });
        var $dragBln = false;
        $(".main_image").touchSlider({
            flexible: true,
            speed: 200,
            btn_prev: $("#btn_prev"),
            btn_next: $("#btn_next"),
            paging: $(".flicking_con a"),
            counter: function(e) {            	
                $(".flicking_con a").removeClass("on").eq(e.current - 1).addClass(" on ");
            }
        });
        $(".main_image").bind("mousedown", function() {
            $dragBln = false;
        });
        $(".main_image").bind("dragstart", function() {
            $dragBln = true;
        });
        $(".main_image a").click(function() {
            if ($dragBln) {
                return false;
            }
        });
        var timer = setInterval(function() {
            $("#btn_next").click();
        }, 2000);
        $(".main_visual").hover(function() {
            clearInterval(timer);
        }, function() {
            timer = setInterval(function() {
                $("#btn_next").click();
            }, 2000);
        });
        $(".main_image").bind("touchstart", function() {
            clearInterval(timer);
        }).bind("touchend", function() {
            timer = setInterval(function() {
                $("#btn_next").click();
            }, 2000);
        });
    }
    //头部页面跳转
    series.jump=function(){
    	
    };
    //图片载入效果
    series.loading=function(){
    	$(window).scroll(function (){
    		var winH = $(window).height();
    		var scrH = $(window).scrollTop();
    		var htmH = $(document).height() - 100;
    		//var himg = $(".indeximg").offset().top
    		//alert(winH)
    		//alert(htmH);
    		//alert($(".indeximg").offset().top);
    		var arr = $(".animationj");
    		for( var i=0; i<arr.length;i++){
    			var t=arr[i];
    			var himg = $(".animationj").eq(i).offset().top - $(window).scrollTop();
    			if(himg<800){
    				$(".animationj").eq(i).addClass("imgAnimationl")
    			}
    		}
		});
    }
    //提交页面
    series.submits=function(){
    	$("#sub").on('click', function() {
    		var name=$("#exampleInputname").val();
    		var phone=$("#exampleInputphone").val();
    		var email=$("#exampleInputEmail3").val();
    		var ly=$("#ly").val();
    		_this.user.name=name;
    		_this.user.phone=phone;
    		_this.user.email=email;
    		_this.user.ly=ly;
    		
    		if(phone && /^1[3|4|5|8]\d{9}$/.test(phone)){
    			utils.ajax.success = function(data) {
			          if (data.status == '200') {
							alert(成功)
			          } 			         
			      }
			      utils.ajax.error = function() {
			         utils.tip('服务器连接失败，登录失败！');
			      }
			      var nowUrl = '{:url(\'index\')}';
			      var type = 'get';
			      var data = _this.user;
			      utils.ajax.go(nowUrl, type, data, utils.ajax.success, utils.ajax.error);
    		}else{
    			//alert(2)
    		}
				

        });
    	
    	
    }
    //页面分页处理
    series.page=function(){
    			console.log($(".indeximg").length);
		    	var total = $(".indeximg").length,//数据总条数
		    pageNumber = 1,//当前页
		    pageSize = 2, //每页显示的条数
		    edges = 2,//两侧显示的页码数 大于1
		    playes = 1,//主页码区显示的页码数 大于3
		    pages = Math.ceil(total / pageSize);//总页数
		renderPageItem();
		function renderPageItem() {
		  $ul = $('<ul class="pagination"></ul>');
		  var start = 1;
		  var end = pages;
		  if (playes % 2) {
		    //playes是奇数
		    start = pageNumber - Math.floor(playes / 2);
		    end = pageNumber + Math.floor(playes / 2);
		  } else {
		    //playes是偶数
		    start = pageNumber - (playes / 2 - 1);
		    end = pageNumber + playes / 2;
		  }
		
		  if (start <= edges + 1) {
		    start = 1;
		    if (end < playes && playes<pages) {
		        end = playes;
		    }
		  } else {
		    for (var i = 1; i <= edges; i++) {
		      $ul.append(renderItem(i));
		    }
		    $ul.append('<li><span>...</span></li>')
		  }
		  if (end < pages - edges) {
		    for (var i = start; i <= end; i++) {
		      $ul.append(renderItem(i));
		    }
		    $ul.append('<li><span>...</span></li>');
		    for (var i = pages - edges + 1; i <= pages; i++) {
		      $ul.append(renderItem(i));
		    }
		  } else {
		    end = pages;
		    if(start>pages-playes+1){
		      start = pages-playes+1
		    }
		    for (var i = start; i <= end; i++) {
		      $ul.append(renderItem(i));
		    }
		  }
		  $ul.prepend(renderPrevItem());
		  $ul.append(renderNextItem());
		  $('#pageBox').empty().append($ul);
		}
		
		function renderItem(i) {
		  $item = $('<li><a href="#">' + i + '</a></li>');
		  if (i == pageNumber) {
		    $item.addClass('active');
		  }
		  $item.on('click', (function (num) {
		    return function () {
		      pageNumber = num;
		      renderPageItem();
		      console.log(pageNumber);
		    }
		  })(i));
		  return $item
		}
		
		function renderPrevItem() {
		  $prev = $('<li><a href="#">&laquo;</a></li>');
		  if (pageNumber == 1) {
		    $prev.addClass('disabled');
		  } else {
		    $prev.on('click', function () {
		      pageNumber = pageNumber - 1;
		      renderPageItem();
		      console.log(pageNumber);
		    })
		  }
		  return $prev;
		}
		
		function renderNextItem() {
		  $next = $('<li><a href="#">&raquo;</a></li>');
		  if (pageNumber == pages) {
		    $next.addClass('disabled');
		  } else {
		    $next.on('click', function () {
		      pageNumber = pageNumber + 1;
		      renderPageItem();
		      console.log(pageNumber);
		    })
		  }
		  return $next;
		}
    }
    return Index;    
});
