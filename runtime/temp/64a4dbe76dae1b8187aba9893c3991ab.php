<?php if (!defined('THINK_PATH')) exit(); /*a:11:{s:72:"/home/wwwroot/default/epock/public/../app/admin/view/config/setting.html";i:1539083470;s:64:"/home/wwwroot/default/epock/public/../app/admin/view/layout.html";i:1538991594;s:68:"/home/wwwroot/default/epock/public/../app/admin/view/layout/top.html";i:1538991594;s:71:"/home/wwwroot/default/epock/public/../app/admin/view/layout/header.html";i:1538991594;s:34:"../app/common/view/fakeloader.html";i:1538991564;s:77:"/home/wwwroot/default/epock/public/../app/admin/view/layout/sidebar_left.html";i:1538991594;s:71:"/home/wwwroot/default/epock/public/../app/admin/view/layout/crumbs.html";i:1538991594;s:79:"/home/wwwroot/default/epock/public/../app/admin/view/layout/edit_btn_group.html";i:1539067551;s:71:"/home/wwwroot/default/epock/public/../app/admin/view/layout/footer.html";i:1538991594;s:78:"/home/wwwroot/default/epock/public/../app/admin/view/layout/sidebar_right.html";i:1538991594;s:71:"/home/wwwroot/default/epock/public/../app/admin/view/layout/bottom.html";i:1538991594;}*/ ?>
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
<body class="hold-transition skin-blue sidebar-mini">
<div class="fakeloader"></div>
<link href="__STATIC__/module/common/fakeloader/css/fakeLoader.css" rel="stylesheet">
<script src="__STATIC__/module/common/fakeloader/js/fakeLoader.min.js"></script>
<script type="text/javascript">
    
    $(".fakeloader").fakeLoader({
        timeToHide:99999,
        bgColor:"rgba(52, 52, 52, .0)",
        spinner:"spinner<?php echo $loading_icon; ?>"
    });
    
    $('.fakeloader').hide();
    
    var pjax_mode = "<?php echo $pjax_mode; ?>";
    
</script>
<script src="__STATIC__/module/admin/js/init_body.js"></script>
<style type="text/css">
h1{ font-size: 16px; }
</style>
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo url('index/Index/index'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>善策</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>善策</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">导航开关</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
              
<!--            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>-->
              
            <ul class="dropdown-menu">
              <li class="header">您有4个消息</li>
              
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="__STATIC__/module/admin/ext/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                         张三
                        <small><i class="fa fa-clock-o"></i> 5 分钟前</small>
                      </h4>
                      <p>吃饭了吗？</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="__STATIC__/module/admin/ext/adminlte/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        李四
                        <small><i class="fa fa-clock-o"></i> 2 小时前</small>
                      </h4>
                      <p>麻烦发下今天的文章哦。</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">查看所有消息</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
<!--            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>-->
            <ul class="dropdown-menu">
              <li class="header">您有10个通知</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 今天有5个新成员加入
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> 这是一条系统警告通知。
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 销售了25个产品喔
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> 用户名修改通知
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">查看所有通知</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="__STATIC__/module/admin/ext/adminlte/dist/img/avatar5.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $member_info['nickname']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="__STATIC__/module/admin/ext/adminlte/dist/img/avatar5.png" class="img-circle" alt="User Image">

                <p>
                    <?php echo $member_info['nickname']; ?>
                  <small>上次登录时间：<?php echo $member_info['update_time']; ?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat clear_cache" url="<?php echo url('Login/clearCache'); ?>">清理缓存</a>
                </div>
                <div class="pull-right">
                  <a class="btn btn-default btn-flat logout" url="<?php echo url('Login/logout'); ?>">安全退出</a>
                </div>
              </li>
            </ul>
          </li>
          
          <!-- 控制栏切换按钮 -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- 左侧导航栏 -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="__STATIC__/module/admin/ext/adminlte/dist/img/avatar5.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p><?php echo $member_info['nickname']; ?></p>
            <?php echo $member_info['update_time']; ?>
          <!--<a href="#"><i class="fa fa-circle text-success"></i> 在线状态</a>-->
        </div>
      </div>
      
      
      <!-- search form -->
<!--      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="请输入搜索内容...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>-->
      <!-- /.search form -->
      
      <!-- 左侧菜单 -->
      <ul class="sidebar-menu">
        <?php echo $menu_view; ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        
        <section class="content-header">
          <h1>
            <?php if(!(empty($ob_title) || (($ob_title instanceof \think\Collection || $ob_title instanceof \think\Paginator ) && $ob_title->isEmpty()))): ?><?php echo $ob_title; endif; if(!(empty($ob_describe) || (($ob_describe instanceof \think\Collection || $ob_describe instanceof \think\Paginator ) && $ob_describe->isEmpty()))): ?><small><?php echo $ob_describe; ?></small><?php endif; ?>
          </h1>
          <?php echo $crumbs_view; ?>
        </section>
<!--
case value
0:数字
1:字符
2:文本
3:数组
4:枚举
5:图片
6:文件
7:富文本
8:单选
9:多选
10:日期
11:时间
12:颜色
-->

<style type="text/css">


.form-control:not(select) {

    height: 35px;

}

</style>
<form action="<?php echo url(); ?>" method="post" class="form_single">
    
    <div class="box">
        
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <?php if(is_array($config_group_list) || $config_group_list instanceof \think\Collection || $config_group_list instanceof \think\Paginator): $i = 0; $__LIST__ = $config_group_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($group != $key): ?>
                     <li><a href="<?php echo url('setting',array('group' => $key)); ?>"><?php echo $vo; ?></a></li>
                         <?php else: ?>
                     <li class="active"><a><?php echo $vo; ?></a></li>
                  <?php endif; endforeach; endif; else: echo "" ;endif; ?>



            </ul>
            

            <div class="tab-content">
              <div class="active tab-pane">

                  
                <div class="box-body">
                  <div class="row">
                      
                    <?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>

                            <div class="col-md-6" style="width: 100%;">
                              <div class="form-group">
                                <label><?php echo $vo['title']; ?></label>

                                    <?php if(!(empty($vo['describe']) || (($vo['describe'] instanceof \think\Collection || $vo['describe'] instanceof \think\Paginator ) && $vo['describe']->isEmpty()))): ?>
                                        <span>（<?php echo $vo['describe']; ?>）</span>
                                    <?php endif; switch($vo['type']): case "0": ?>

                                            <input class="form-control" name="<?php echo $vo['name']; ?>" placeholder="请输入设置值" value="<?php echo $vo['value']; ?>" type="text">

                                        <?php break; case "1": ?>

                                            <input class="form-control" name="<?php echo $vo['name']; ?>" placeholder="请输入设置值" value="<?php echo $vo['value']; ?>" type="text">

                                        <?php break; case "2": ?>

                                            <textarea class="form-control" name="<?php echo $vo['name']; ?>" rows="3" placeholder="请输入设置值"><?php echo $vo['value']; ?></textarea>

                                        <?php break; case "3": ?>

                                            <textarea class="form-control" name="<?php echo $vo['name']; ?>" rows="3" placeholder="请输入设置值"><?php echo $vo['value']; ?></textarea>

                                        <?php break; case "4": ?>

                                            <select name="<?php echo $vo['name']; ?>" class="form-control">
                                                <?php $_result=parse_config_attr($vo['extra']);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?>
                                                    <option value="<?php echo $key; ?>" <?php if($vo['value'] == $key): ?> selected <?php endif; ?> ><?php echo $vv; ?></option>
                                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>

                                        <?php break; case "5": $case_img_var = (isset($vo['value']) && ($vo['value'] !== '')?$vo['value']:'0'); ?>

                                            <?php echo widget('file/index', ['name' => $vo['name'], 'value' => $case_img_var, 'type' => 'img']); if(!(empty($case_img_var) || (($case_img_var instanceof \think\Collection || $case_img_var instanceof \think\Paginator ) && $case_img_var->isEmpty()))): ?>
                                                <div class="upload-pre-item">
                                                    <?php $case_img_var_url = get_picture_url($case_img_var); ?>
                                                    <a target="_blank" href="<?php echo $case_img_var_url; ?>">
                                                        <img style="max-width: 150px;" src="<?php echo $case_img_var_url; ?>"/>
                                                    </a>
                                                </div>
                                            <?php endif; break; case "6": $case_file_var = (isset($vo['value']) && ($vo['value'] !== '')?$vo['value']:'0'); ?>

                                            <?php echo widget('file/index', ['name' => $vo['name'], 'value' => $case_file_var, 'type' => 'file']); if(!(empty($case_file_var) || (($case_file_var instanceof \think\Collection || $case_file_var instanceof \think\Paginator ) && $case_file_var->isEmpty()))): ?>
                                                <div class="upload-pre-file">
                                                    <?php $case_file_var_url = get_file_url($case_file_var); ?>
                                                    <a target="_blank" href="<?php echo $case_file_var_url; ?>">
                                                        <?php echo $case_file_var_url; ?>
                                                    </a>
                                                </div>
                                            <?php endif; break; case "7": ?>
                                            
                                            <textarea class="form-control textarea_editor" name="<?php echo $vo['name']; ?>" placeholder="请输入富文本内容"><?php echo html_entity_decode((isset($vo['value']) && ($vo['value'] !== '')?$vo['value']:'')); ?></textarea>
                                            
                                            <?php echo widget('editor/index', array('name'=> $vo['name'],'value'=> '')); break; case "8": $_result=parse_config_attr($vo['extra']);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?>
                                                <div class="radio">
                                                  <label>
                                                    <input name="<?php echo $vo['name']; ?>" id="<?php echo $vo['name']; ?>" value="<?php echo $key; ?>" <?php if($vo['value'] == $key): ?> checked="" <?php endif; ?>   type="radio">
                                                    <?php echo $vv; ?>
                                                  </label>
                                                </div>
                                            <?php endforeach; endif; else: echo "" ;endif; break; case "9": ?>
                                        
                                            <input type="hidden" name="<?php echo $vo['name']; ?>" id="<?php echo $vo['name']; ?>" value="<?php echo $vo['value']; ?>"/>
                                        
                                            <div>
                                                <?php $_result=parse_config_attr($vo['extra']);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?>

                                                    <div class="checkbox">
                                                        <label>
                                                          <input <?php if(in_array(($key), is_array($vo['value'])?$vo['value']:explode(',',$vo['value']))): ?> checked="checked" <?php endif; ?>  type="checkbox" value="<?php echo $key; ?>" onclick="selectCheckbox(this)">
                                                          <?php echo $vv; ?>
                                                        </label>
                                                    </div>

                                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                            </div>
                                        <?php break; case "10": ?>

                                            <input class="form-control date" name="<?php echo $vo['name']; ?>" placeholder="请选择或输入日期" value="<?php echo $vo['value']; ?>" type="text">

                                        <?php break; case "11": ?>

                                            <input class="form-control time" name="<?php echo $vo['name']; ?>" placeholder="请选择或输入时间" value="<?php echo $vo['value']; ?>" type="text">

                                        <?php break; case "12": ?>

                                            <input class="form-control" name="<?php echo $vo['name']; ?>" placeholder="请选择或输入颜色值" value="<?php echo $vo['value']; ?>" type="color">

                                        <?php break; case "13": ?>
                                        
                                          <a target="_blank" href="http://www.sansaas.com/admin/config/configedit/id/112.html">
                                        <br/> 
                                        <span class="">（点我去修改图片：）</span></a>
                                        <?php $case_img_var = (isset($vo['value']) && ($vo['value'] !== '')?$vo['value']:'0'); ?>
                                        <?php echo widget('file/index', ['name' =>$vo['name'], 'value' => $case_img_var, 'type' => 'imgs']); if(!(empty($case_img_var) || (($case_img_var instanceof \think\Collection || $case_img_var instanceof \think\Paginator ) && $case_img_var->isEmpty()))): ?>

                                                <div class="upload-pre-item"> 
                                                  <?php if(is_array($banner) || $banner instanceof \think\Collection || $banner instanceof \think\Paginator): $i = 0; $__LIST__ = $banner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                                <br>
                                                    <a target="_blank" href="<?php echo get_picture_url($vo); ?>">
                                                        <img style="max-width: 150px;" src="<?php echo get_picture_url($vo); ?>"/>
                                                    </a>图片id：<?php echo $vo; endforeach; endif; else: echo "" ;endif; ?>

                                                </div>
                                            <?php endif; break; endswitch; ?>
                               </div>
                            </div>

                        <?php endforeach; endif; else: echo "" ;endif; else: ?>
                            
                            <div class="col-md-6">
                                <tr class="odd"><td colspan="6" class="text-center" valign="top"><?php echo config('empty_list_describe'); ?></td></tr>
                            </div>
                    <?php endif; ?>
                     
                  </div>
              
                </div>
              </div>
            </div>
          </div>
        

      <div class="box-footer">
          
        <button  type="submit" class="btn ladda-button ajax-post" data-style="slide-up" target-form="form_single">
    <span class="ladda-label"><i class="fa fa-send"></i> 保 存</span>
</button>

<a class="btn" onclick="javascript:history.back(-1);return false;"><i class="fa fa-history"></i> 返 回</a>
        
      </div>
    </div>
</form>

<script type="text/javascript">


    $(function(){
        
        $('.date').datetimepicker({
            format: 'yyyy-mm-dd',
            language:"zh-CN",
            minView:2,
            autoclose:true
        });
        
        $('.time').datetimepicker({
            format: 'yyyy-mm-dd hh:ii:ss',
            language:"zh-CN",
            minView:0,
            autoclose:true
        });
    });
    
    function selectCheckbox(obj)
    {
        
        var checkbox_obj = $(obj).parent().parent().parent().prev();
        
        var checkbox_obj_ids = checkbox_obj.val();
        
        var add_id = $(obj).val();
            
        // 选中
        if ($(obj).is(':checked'))
        {
            
            if (checkbox_obj_ids == '') {
                
                checkbox_obj_ids = add_id;
            } else {
                checkbox_obj_ids = checkbox_obj_ids + ',' + add_id;
            }
            
            checkbox_obj.val(checkbox_obj_ids);
            
        } else {
            
            
            if(checkbox_obj_ids.indexOf(",") > 0)
            {
                
                checkbox_obj_ids.indexOf(add_id) == 0 ? checkbox_obj_ids = checkbox_obj_ids.replace(add_id + ',', '') : checkbox_obj_ids = checkbox_obj_ids.replace(',' + add_id, '');
                
                checkbox_obj.val(checkbox_obj_ids);
            } else {
                
                checkbox_obj.val('');
            }
        }
    }

</script>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>版本号</b> 1.0.0
    </div>
    <strong>
        版权©2014 - 2016  .
    </strong>
      保留所有权利。
  </footer>
  
  <script src="__STATIC__/module/admin/js/pjax_init.js"></script>
  
  <!-- 控制栏 -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
<!--    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-bell-o"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>-->
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
<!--        <h3 class="control-sidebar-heading">通知开关</h3>
        
          <div class="form-group">
            <label class="control-sidebar-subheading">
              异常登录是否通知
              <input type="checkbox" class="pull-right" checked>
            </label>
            <p>
              不在常用地区或常用IP登录是否通知用户，默认为是。
            </p>
          </div>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              行为异常是否限制
              <input type="checkbox" class="pull-right" checked>
            </label>
            <p>
              用户行为异常是否限制其操作，默认为是。
            </p>
          </div>-->
        
      </div>
      
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">系统开关</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              是否允许注册
              <input type="checkbox" class="pull-right" checked>
            </label>
            <p>
              若勾选后则不允许用户注册，默认为是。
            </p>
          </div>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              是否调试模式
              <input type="checkbox" class="pull-right" checked>
            </label>
            <p>
              若为调试模式页面将显示Trace信息，默认为是。
            </p>
          </div>
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
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