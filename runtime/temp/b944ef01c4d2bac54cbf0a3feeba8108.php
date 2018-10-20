<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"/home/wwwroot/default/epock/public/../app/admin/view/widget/file/file.html";i:1538991594;}*/ ?>
<link rel="stylesheet" href="__STATIC__/widget/admin/file/Huploadify.css">

<div id="upload_file_<?php echo $widget_data['name']; ?>"></div>

<input type="hidden" name="<?php echo $widget_data['name']; ?>" id="<?php echo $widget_data['name']; ?>" value="<?php echo $widget_data['value']; ?>"/>

<div class="upload-img-box<?php echo $widget_data['name']; ?>">
    <?php if(!(empty($info[$widget_data['name']]) || (($info[$widget_data['name']] instanceof \think\Collection || $info[$widget_data['name']] instanceof \think\Paginator ) && $info[$widget_data['name']]->isEmpty()))): ?>
    <div class="upload-pre-file">
        <div style="cursor:pointer;" class="file_del"  onclick="fileDel<?php echo $widget_data['name']; ?>(this)" ><img src="__STATIC__/widget/admin/file/uploadify-cancel.png" /></div> 
        <span class="upload_icon_all"></span><a target="_blank" href="<?php echo get_file_url((isset($info[$widget_data['name']]) && ($info[$widget_data['name']] !== '')?$info[$widget_data['name']]:'')); ?>"><?php echo get_file_url((isset($info[$widget_data['name']]) && ($info[$widget_data['name']] !== '')?$info[$widget_data['name']]:'')); ?></a></div>
    <?php endif; ?>
</div>

<script type="text/javascript">

    $("#upload_file_<?php echo $widget_data['name']; ?>").Huploadify({
        auto: true,
        height: 30,
        fileObjName: "file",
        buttonText: "上传文件",
        uploader: "<?php echo url('File/fileUpload',array('session_id'=>session_id())); ?>",
        width: 120,
        removeTimeout: 1,
        fileSizeLimit:"<?php echo $widget_config['max_size']; ?>",
        fileTypeExts: "<?php echo $widget_config['allow_postfix']; ?>",
        onUploadComplete: uploadFile<?php echo $widget_data['name']; ?>
    });
    
    function uploadFile<?php echo $widget_data['name']; ?>(file, data){
        
        var data = $.parseJSON(data);
        
        $("#<?php echo $widget_data['name']; ?>").val(data.id);

        var src = !data['url'] ? "__ROOT__/upload/picture/" + data.path : data.url;
        
        $(".upload-img-box<?php echo $widget_data['name']; ?>").html('<div class="upload-pre-file">    <div style="cursor:pointer;" class="file_del"  onclick="fileDel<?php echo $widget_data['name']; ?>(this)" ><img src="__STATIC__/widget/admin/file/uploadify-cancel.png" /></div>      <span class="upload_icon_all"></span><a target="_blank" href="'+src+'"> ' + src + ' <a></div>');
    }
    
    function fileDel<?php echo $widget_data['name']; ?>(obj)
    {
        
        var widget_name = "<?php echo $widget_data['name']; ?>";
        
        $("#" + widget_name).val(0);
        
        $(obj).parent().remove();
    }
</script>