<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:69:"/home/wwwroot/default/epock/public/../app/admin/view/login/login.html";i:1538991592;s:68:"/home/wwwroot/default/epock/public/../app/admin/view/layout/top.html";i:1538991594;s:71:"/home/wwwroot/default/epock/public/../app/admin/view/layout/bottom.html";i:1538991594;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  
     <title> <?php if(!(empty($ob_title) || (($ob_title instanceof \think\Collection || $ob_title instanceof \think\Paginator ) && $ob_title->isEmpty()))): ?> | <?php echo $ob_title; endif; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link href="__STATIC__/module/admin/ext/adminlte/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="__STATIC__/module/admin/ext/adminlte/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="__STATIC__/module/admin/ext/adminlte/dist/css/skins/_all-skins.css">
    <link rel="stylesheet" href="__STATIC__/module/common/toastr/toastr.min.css">
    <link rel="stylesheet" href="__STATIC__/module/admin/ext/btnloading/dist/ladda-themeless.min.css">
    <link rel="stylesheet" href="__STATIC__/module/admin/css/onebase.css">
    <link rel="stylesheet" type="text/css" href="__STATIC__/module/admin/ext/remodal/remodal.css" media="all">
    <link rel="stylesheet" type="text/css" href="__STATIC__/module/admin/ext/remodal/remodal-default-theme.css" media="all">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="__STATIC__/module/admin/ext/adminlte/plugins/iCheck/all.css">
    <!-- jQuery 2.2.3 -->
    <script type="text/javascript" src="__STATIC__/module/common/jquery/jquery-2.2.3.min.js"></script>
    <!-- Pjax -->
    <script src="__STATIC__/module/admin/ext/jquerypjax/jquery.pjax.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="__STATIC__/module/admin/ext/adminlte/bootstrap/js/bootstrap.min.js"></script>
    <script src="__STATIC__/module/admin/js/init.js"></script>
    <!-- <link rel="stylesheet" href="__STATIC__/ext/adminlte/dist/css/font-awesome.min.css">-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="__STATIC__/module/admin/ext/adminlte/dist/css/ionicons.min.css">
    
    <!-- Pjax Depend -->
    <link rel="stylesheet" href="__STATIC__/module/admin/ext/datetimepicker/css/datetimepicker.css" type="text/css">
    <link rel="stylesheet" href="__STATIC__/module/admin/ext/datetimepicker/css/dropdown.css" type="text/css">
    <link rel="stylesheet" href="__STATIC__/module/admin/ext/edittable/jquery.edittable.min.css">
    <script type="text/javascript" src="__STATIC__/module/admin/ext/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="__STATIC__/module/admin/ext/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
    <script src="__STATIC__/module/admin/ext/edittable/jquery.edittable.js"></script>
    <script charset="utf-8" src="__STATIC__/widget/admin/editor/kindeditor/kindeditor-min.js"></script>
    <script charset="utf-8" src="__STATIC__/widget/admin/editor/kindeditor/zh_CN.js"></script>
    <script src="__STATIC__/widget/admin/file/jquery.Huploadify.js"></script>
    <script src="__STATIC__/module/admin/ext/echarts/echarts.min.js"></script>
     <script type="text/javascript" src="__STATIC__/js/layer.js"></script>
</head>
<body class="hold-transition login-page admin-login-body-background">
    
<script src="__STATIC__/module/admin/ext/background/login_background.js"></script>
<style>
.admin-login-box{top: 5%;}
</style>
<canvas></canvas>

<div class="admin-login-box">
  <div class="login-logo">
      <a href="" class="login-logo-a"><b><img src="__STATIC__/epock/img/logo@2x.png" alt=""></b></a>
  </div>

  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">请输入您的登录信息</p>

    <form action="<?php echo url('loginHandle'); ?>" method="post" class="admin-login-form">
      <div class="form-group has-feedback">
          <input type="text" name="username" class="form-control" placeholder="请输入您的用户名">
           <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
           <input type="password" name="password" class="form-control" placeholder="请输入您的密码">
           <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
        
       <!--  <div>
            <img src="<?php echo captcha_src(); ?>" alt="captcha" class="admin-login-captcha-img captcha_change" id="captcha_img"/>
        </div> -->
        <br/>
      <div class="row">
        <div class="col-xs-8">
          <input type="text" name="verify" class="form-control verify" placeholder="请输入您的验证码">
          <!-- <span class="glyphicon glyphicon-open form-control-feedback admin-login-captcha-input-icon"></span> -->
        </div>
         <div>
            <img src="<?php echo captcha_src(); ?>" alt="captcha" class="admin-login-captcha-img captcha_change" id="captcha_img" style="margin-top: -6px;" />
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <!-- <button type="button" class="btn btn-primary btn-block btn-flat captcha_change">换一张</button> -->
        </div>
        <!-- /.col -->
      </div>
        <div style="text-align:left;margin: 10px auto;margin-left: 5px;"><input type="checkbox">记住我</div>
        <div class="social-auth-links text-center">
            
          <button  type="submit" class="btn btn-block btn-facebook ladda-button login-submit-button" data-style="slide-up" style="background-color: #0A83D6">
              <span class="ladda-label">登 录</span>
          </button>
      <!--  <button class="btn btn-block btn-google btn-flat" style="background-color: #0A83D6" >
              <span class="ladda-label"><a href="<?php echo url('index/index/member_add'); ?>" style="display: block; color: #fff">注册</a></span>
          </button> -->
         <!--  <button  type="button"  class="btn btn-block btn-google btn-flat">忘记密码</button> -->
        </div>
    </form>

    <!-- /.social-auth-links -->
    <!--<a href="#">找回密码</a><br>-->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<script src="__STATIC__/module/admin/ext/adminlte/dist/js/app.min.js"></script>
<script src="__STATIC__/module/admin/ext/adminlte/dist/js/init.js"></script>
<script src="__STATIC__/module/common/toastr/toastr.min.js"></script>
<script src="__STATIC__/module/admin/ext/btnloading/dist/spin.min.js"></script>
<script src="__STATIC__/module/admin/ext/btnloading/dist/ladda.min.js"></script>
<script src="__STATIC__/module/admin/ext/remodal/remodal.min.js"></script>
<script src="__STATIC__/module/admin/ext/adminlte/plugins/iCheck/icheck.min.js"></script>
<script src="__STATIC__/module/admin/js/onebase.js"></script>
<link rel="stylesheet" href="__STATIC__/module/admin/css/ob_skin.css">


<?php echo hook('hook_view_admin'); ?>
</body>
</html>