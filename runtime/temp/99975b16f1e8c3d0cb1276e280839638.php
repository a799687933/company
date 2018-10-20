<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"/home/wwwroot/default/epock/public/../app/index/view/index/details.html";i:1539742988;}*/ ?>
﻿<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	 <base href="__STATIC__/epock/" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="expires" content="0">
    <link href="css/tool/bootstrap.min.css" rel="stylesheet">
    <link href="css/static/slider.css" rel="stylesheet">
    <link href="css/static/details.css" rel="stylesheet">
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
.details-content-p,.text-foothearder,.text-footercon,.case-nav-btn{
	font-family: "Arial", "PingFang SC", "microsoft yahei"
}
.navbar-default{
  background-color: #fff;
}
	 @media (min-width: 1350px){
    .from-cust {
        width: 1200px!important;
        margin: 0 auto!important;
    }
    .details-content{
    	 width: 1200px!important;
        margin: 60px auto!important;
    }
     }
      @media (max-width: 1350px){
    .from-cust {
        width: 100%!important;
        margin: 0 auto!important;
    }
     }
    @media (min-width: 700px){
    .details-content-p {
        width: 520px!important;
    }
    .details-content-p{
      font-size: 42px;
    }    
    .container-fluid{
      padding: 0;
    }
    .navbar-img img{
      margin-left: 0;
    }
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
  }
  @media (min-width: 800px){
    .footer-pc {
    padding-left: 0px !important;
}
  }
  .nav>li>a:focus, .nav>li>a:hover{
    border-bottom: 0;
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
   .details-content img{
  width: 100% !important;
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
    .details-text-head{
      font-weight:700;
    }
    .details-text-det{
    	font-size: 16px
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
		        <a class="navbar-brand navbar-img" href="#"><img src="img/logo@2x.png"></a>
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
          <img src="<?php echo get_picture_url($info['img_ids']); ?>">
    </div>
	<div class="details-content">
		<div class="row">
			  <div class="col-md-8">		  	
			  	<p class="details-content-p"><b><?php echo $info['name']; ?></b></p>
			  </div>
			  <div class="col-md-4">
					<div class="nav case-nav">
					   	<a class="btn btn-default case-nav-btn" href="<?php echo url('case_detail'); ?>" role="button">全部</a>
					   	<?php if(is_array($category) || $category instanceof \think\Collection || $category instanceof \think\Paginator): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo[id] == $info[category_id]): ?>
					      	<a class="btn btn-default case-nav-btn" href="<?php echo url('case_detail', ['category_id'=>$vo[id]]); ?>" value="<?php echo $vo['id']; ?>" role="button"><?php echo $vo['name']; ?></a>  
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
					   </div>
			  </div>
		</div>
    </div>

         


 <div class="details-content">

 	 <div class="row">
			  <div class="col-md-8">		  	
			  	<p class="details-text-head">项目背景</p>
	    		<p class="details-text-det"><?php echo $info['cost']; ?></p>
			  </div>
			  <div class="col-md-4">				
			  </div>
		</div>
			<br /><br />
		<div class="row">
			  <div class="col-md-8">		  	
			  	<p class="details-text-head">最终收获</p>
	    		<p class="details-text-det"><?php echo $info['describe']; ?></p>
			  </div>
			  <div class="col-md-4">				
			  </div>
		</div>	
 <?php echo htmlspecialchars_decode($info['content']); ?>
</div>

     <div class="footer">
    	<div class="row row-footer">
		  <div class="col-xs-12 col-md-6 footer-top footer-pc ">
		  	<p class="text-left text-foothearder"><img src="img/底部logo@3x.png"></p>
			<p class="text-left text-footercon">Copyright © 2018 SAAS All Rights Reserved 粤ICP备18111903号-1</p>
		  </div>
		  <div class="col-xs-12 col-md-3 footer-top">
		  	<p class="text-left text-foothearder">善策数字化咨询</p>
			<p class="text-left text-footercon">15815591966</p>
		  </div>
		  <div class="col-xs-12 col-md-3 footer-top fr">
		  	<p class="text-left text-foothearder">服务邮箱</p>
			<p class="text-left text-footercon">gleichner@hotmail.com</p>
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
