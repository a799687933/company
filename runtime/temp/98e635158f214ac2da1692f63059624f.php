<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"/home/wwwroot/default/epock/public/../app/admin/view/widget/editor/index.html";i:1539089434;}*/ ?>
<link rel="stylesheet" href="__STATIC__/widget/admin/editor/kindeditor/default/default.css" />
<script type="text/javascript">

    $(function(){
        
    var editor_<?php echo $widget_data['name']; ?>;
        editor_<?php echo $widget_data['name']; ?> = KindEditor.create('textarea[name="<?php echo $widget_data['name']; ?>"]', {
                allowFileManager : false,
                themesPath: KindEditor.basePath,
                width: '100%',
                height: '<?php echo $widget_config['editor_height']; ?>',
                resizeType: <?php if($widget_config['editor_resize_type'] == '1'): ?>1 <?php else: ?> 0 <?php endif; ?>,
                pasteType : 2,
                urlType : 'absolute',
                fileManagerJson : '<?php echo url('fileManagerJson'); ?>',
                uploadJson : "<?php echo url('file/editorPictureUpload'); ?>",
                items : [
                'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
        'anchor', 'link', 'unlink', '|', 'about'
                ],
                extraFileUploadParams: { session_id : '<?php echo session_id(); ?>'}
            });
        
        //ajax提交之前同步
        $('button[type="submit"],#submit,.ajax-post,#autoSave').click(function(){
                editor_<?php echo $widget_data['name']; ?>.sync();
        });
    });
</script>
