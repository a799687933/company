<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"/home/wwwroot/default/epock/public/../app/index/view/index/case_detail.html";i:1539742975;}*/ ?>
﻿<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<!--<base href="http://www.juiceepoch.com/juice/epock/" />-->
	<base href="__STATIC__/epock/" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="expires" content="0">
    <link href="css/tool/bootstrap.min.css" rel="stylesheet">
    <link href="css/static/slider.css" rel="stylesheet">
    <link href="css/static/case.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/help/html5shiv.min.js"></script>
    <![endif]-->
    <title>深圳善策品牌策略有限公司  saas数字化服务</title>
    <!-- <link href="img/favicon.ico" rel="shortcut icon"> -->
    <script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="http://www.sansaas.com/favicon.ico" type="image/x-icon" />
    <script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?bf2638a062d24a6d7ca3b4c27906973c";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</head>
<style type="text/css">
body, html{
  font-family: "Arial", "PingFang SC", "microsoft yahei"
}
.text-foothearder,.text-footercon,.case-nav-btn{
  font-family: "Arial", "PingFang SC", "microsoft yahei"
}
 @media (min-width: 2000px){
    .content-img {
    width: 50%!important;
    float: left!important;
}
  }
.content-img p{
    font-size: 22px;
    color: #3D3E46;
    margin-top: 24px;
  }
 @media (min-width: 1350px){
    .footer{
      height: 268px;
    }
    .row-footer{
      padding-top: 100px
    }
    .row-footer{
      width: 1200px;
      margin: 0 auto;
    }
    .container-fluid{
      padding: 0;
    }
    .navbar-img img{
      margin-left: 0;
    }
  }
   @media (min-width: 800px){
    .footer-pc {
    padding-left: 0px !important;
	}

  }
  .navbar-default{
    background-color: #fff;
   }
	.pagination>.active>span{
		border: 0px;
		margin-top: 10px;
	}
	.pagination>.disabled>span{
		width: 46px;
		height: 46px;
		line-height: 46px;
		margin: 10px;
		padding: 0px;
	}
	.pagination>.active>span{
		margin-left: 10px;
		margin-right: 10px;
	}
	.bui img{
    width: 8px;
    height: 12px;
    float: right;
    margin-top: 14px;
    margin-right: 10px;
   }
   .bui p{
    margin-left: 12px;
    float: left;
    font-size: 16px;
    line-height: 38px;
   }
   .nav>li>a{
   	padding: 0;
   	margin-left: 56px;
   }
   .nav-top{
   	margin: 49px 0 0 0;
   }
   .navbar-collapse{
   	padding: 0;
   }
   .nav>li>a:focus, .nav>li>a:hover{
    border-bottom: 0;
   }
    @media (min-width: 760px){
   .navi{
    width: 10px;
    height: 2px;
    background: #3D3E46;
    margin-left: 68px;
    margin-top: 5px;}
}
    #btn_prev, #btn_next, #ibtn_prev, #ibtn_next{
      width: 47px!important;
      height: 12px!important;
    }
  
</style>
<body>
	<div class="container">
		<nav class="navbar navbar-default" role="navigation">
		    <div class="container-fluid"> 
		    <div class="navbar-header">
		        <button type="button" class="navbar-toggle navbar-t" data-toggle="collapse"
		                data-target="#example-navbar-collapse">
		            <span class="sr-only">切换导航</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		        </button>
		        <a class="navbar-brand navbar-img" href="#"><img src="img/logo@2x.png"/></a>
		    </div>
		    <div class="collapse navbar-collapse" id="example-navbar-collapse">
		       <ul class="nav navbar-nav navbar-right nav-top">
		            <li class="active"><a href="<?php echo url('index'); ?>">首页</a></li>
		            <li class="active"><a href="<?php echo url('case_detail'); ?>">案例</a><div class="navi"></div></li>
		            <li class="active"><a href="<?php echo url('service'); ?>">服务</a></li>
		            <li class="active"><a href="<?php echo url('about'); ?>">关于</a></li>
		        </ul>
		    </div>
		    </div>
		</nav>
    <div class="aboutindexTop ">
        <div class="hidden-xs1"><img   src="<?php echo get_picture_url($case_banner); ?>"></div>
        <div class="hidden-xs2"><img  src="<?php echo get_picture_url($mobile_case_banner); ?>"></div>
    </div>
    <div class="yidongliubai">
   <div class="nav case-nav">
   	<a class="btn btn-default case-nav-btn" href="<?php echo url('case_detail'); ?>" role="button">全部</a>
   <?php if(is_array($category) || $category instanceof \think\Collection || $category instanceof \think\Paginator): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
      	<a class="btn btn-default case-nav-btn" href="<?php echo url('case_detail', ['category_id'=>$vo[id]]); ?>" value="<?php echo $vo['id']; ?>" role="button"><?php echo $vo['name']; ?></a>  
    <?php endforeach; endif; else: echo "" ;endif; ?>
   </div>
	<div class="content" style="overflow: hidden" >
		<div class="content-imgs">

			 <?php if(is_array($lis) || $lis instanceof \think\Collection || $lis instanceof \think\Paginator): $i = 0; $__LIST__ = $lis;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if($key%2 == 1): ?>
			  <div class="content-img content-img-r">
			  	<div class=" indeximg animationj" id="0"><a href="<?php echo url('details', ['id' => $v[id]]); ?>"><img src="<?php echo get_picture_url($v['cover_id']); ?>"></a></div>
			  	<p><?php echo $v['name']; ?></p>
			  </div>
			  <?php else: ?>
            <div class="content-img content-img-l">
			  	<div class=" indeximg animationj" id="0"><a href="<?php echo url('details', ['id' => $v[id]]); ?>"><img src="<?php echo get_picture_url($v['cover_id']); ?>"></a></div>
			  	<p><?php echo $v['name']; ?></p>
			  </div>
			  <?php endif; endforeach; endif; else: echo "" ;endif; ?>
		  </div>

	<div class="hidden-xs case-pagination">
	<?php echo $list->render(); ?>
		</div>
		<button type="button" class="btn btn-load bui"><p>了解善策案例</p>  <img src="img/按钮箭头@2x.png"/></button>
    </div>
	</div>
		

    <div class="footer">
    	<div class="row row-footer">
		  <div class="col-xs-12 col-md-6 footer-top footer-pc">
		  	<p class="text-left text-hearder"><img src="img/底部logo@3x.png"></p>
			<p class="text-left text-footercon">Copyright © 2018 SAAS All Rights Reserved 粤ICP备18111903号-1</p>
		  </div>
		  <div class="col-xs-12 col-md-2 footer-top">
		  	<p class="text-left text-foothearder">善策数字化咨询</p>
			<p class="text-left text-footercon">15815591966</p>
		  </div>
		  <div class="col-xs-12 col-md-2 footer-top fr">
		  	<p class="text-left text-foothearder">服务邮箱</p>
			<p class="text-left text-footercon">gleichner@hotmail.com</p>
		  </div>
		</div>
    </div>
    <div class="error">手机号码不正确</div>
    <script src="__STATIC__/epock/js/tool/sea.js"></script>
    <script>
        seajs.config({
            base: "__STATIC__/epock/../epock/js/",
            alias: {
                "jquery": "tool/jquery.js",
                "json": "tool/json2.js",
                "drag": "tool/jquery.event.drag-1.5.min.js",
                "slider": "tool/jquery.touchSlider.js"
            },
            preload: [
                'jquery',
                this.JSON.stringify({
                    id: 1
                }) ? '' : 'json',
                "drag",
                "slider"
            ]
        });
        seajs.use('config/index');
        
    </script>
    </div>
</body>
</html>
