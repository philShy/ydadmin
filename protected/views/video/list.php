<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css"/>
    <link href="../assets/css/codemirror.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/colorbox.css">
    <!--图片相册-->
    <link rel="stylesheet" href="../assets/css/ace.min.css" />

    <link rel="stylesheet" href="../font/css/font-awesome.min.css" />
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="../assets/css/ace-ie.min.css" />
    <![endif]-->

    <script src="../js/jquery-1.9.1.min.js"></script>
    <script src="../assets/js/jquery.colorbox-min.js"></script>
    <script src="../assets/js/typeahead-bs2.min.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="../assets/layer/layer.js" type="text/javascript" ></script>
    <script type="text/javascript" src="../Widget/swfupload/swfupload.js"></script>
    <script type="text/javascript" src="../Widget/swfupload/swfupload.queue.js"></script>
    <script type="text/javascript" src="../Widget/swfupload/swfupload.speed.js"></script>
    <script type="text/javascript" src="../Widget/swfupload/handlers.js"></script>


    <title></title>
</head>

<body>

<div class="page-content clearfix">
    <div class="sort_adsadd_style">
        <div class="border clearfix">
       <span class="l_f">
        <a href="javascript:ovid()" style="display: none" id="ads_add" title="添加品牌" class="btn btn-warning Order_form"><i class="fa fa-plus"></i> 添加广告</a>
        <a href="javascript:ovid()" style="display: none" class="btn btn-danger"><i class="fa fa-trash"></i> 批量删除</a>
        <a href="javascript:ovid()" onClick="javascript :history.back(-1);" class="btn btn-info"><i class="fa fa-reply"></i> 返回上一步</a>
       </span>
            <span class="r_f">首页共：<b>8</b>个视频</span>
        </div>
        <!--列表样式-->
        <div class="sort_Ads_list">
            <table class="table table-striped table-bordered table-hover" id="sample-table">
                <thead>
                <tr>
                 <th width="50px">id</th>
                 <th width="80px">排序</th>
                 <th width="150px">商品名称</th>
                 <th width="100px">视频封面(点击播放)</th>
                 <th width="80px">播放次数</th>  
                 <th width="180">加入时间</th>
                 <th width="50">操作</th>
                </tr>
                </thead>
                <tbody>
              <?php foreach($video_home_arr as $key=>$value):?>
                    <tr>
                        <td style="display: none"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
       					<td class="adv_id"><?php echo $value['id']?></td>
                        <td>
                        <?php echo $value['sort']?>
                        </td>
                        <td>
                        <?php 
                        $model_name = CProduct::searchGoodsmodelbyid($value['goods_model_id'])['name'];    
                        $goods_name = CProduct::searchGoodsname_byid($value['goods_model_id'])['name'];
                        $goods_model_name = '【'.$goods_name.'】'.$model_name;
                        echo $goods_model_name;
                        ?>
                        </td>
                    	<td><a onclick="play('<?php echo $value['v_url']?>')" href='javascript:;'><?php echo "<image src='$value[img_url]'style='width:80px;'>";?></a></td>
                        <td><?php echo $value['plays']?></td>
                        <td><?php echo $value['create_time']?></td>
                        <td class="td-manage">
                            <a title="编辑"  href="/video/edit?id=<?php echo $value['id']?>&name=<?php echo base64_encode($goods_model_name) ?>"  class="btn btn-xs btn-info" ><i class="icon-edit bigger-120">编辑</i></a> 
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--添加广告样式-->
<div id="add_ads_style"  style="display:none">
    <div class="add_adverts">
        <ul>
            <li>
                <label class="label_name">所属分类</label>
  <span class="cont_style">
  <select class="form-control" id="form-field-select-1">
      <option value="">选择分类</option>
      <option value="AL">首页大幻灯片</option>
      <option value="AK">首页小幻灯片</option>
      <option value="AZ">单广告图</option>
      <option value="AR">其他广告</option>
      <option value="CA">板块栏目广告</option>
  </select></span>
            </li>
            <li><label class="label_name">图片尺寸</label><span class="cont_style">
  <input name="长" type="text" id="form-field-1" placeholder="0" class="col-xs-10 col-sm-5" style="width:80px">
  <span class="l_f" style="margin-left:10px;">x</span><input name="宽" type="text" id="form-field-1" placeholder="0" class="col-xs-10 col-sm-5" style="width:80px"></span></li>
            <li><label class="label_name">显示排序</label><span class="cont_style"><input name="排序" type="text" id="form-field-1" placeholder="0" class="col-xs-10 col-sm-5" style="width:50px"></span></li>
            <li><label class="label_name">链接地址</label><span class="cont_style"><input name="地址" type="text" id="form-field-1" placeholder="地址" class="col-xs-10 col-sm-5" style="width:450px"></span></li>
            <li><label class="label_name">状&nbsp;&nbsp;态：</label>
   <span class="cont_style">
     &nbsp;&nbsp;<label><input name="form-field-radio1" type="radio" checked="checked" class="ace"><span class="lbl">显示</span></label>&nbsp;&nbsp;&nbsp;
     <label><input name="form-field-radio1" type="radio" class="ace"><span class="lbl">隐藏</span></label></span><div class="prompt r_f"></div>
            </li>
            <li><label class="label_name">图片</label><span class="cont_style">
 <div class="demo">
     <div class="logobox"><div class="resizebox"><img src="../images/image.png" width="100px" alt="" height="100px"/></div></div>
     <div class="logoupload">
         <div class="btnbox"><a id="uploadBtnHolder" class="uploadbtn" href="javascript:;">上传替换</a></div>
         <div style="clear:both;height:0;overflow:hidden;"></div>
         <div class="progress-box" style="display:none;">
             <div class="progress-num">上传进度：<b>0%</b></div>
             <div class="progress-bar"><div style="width:0%;" class="bar-line"></div></div>
         </div>  <div class="prompt"><p>图片大小小于5MB,支持.jpg;.gif;.png;.jpeg格式的图片</p></div>
     </div>
 </div>
   </span>
            </li>


        </ul>
    </div>
</div>
</body>
</html>
<script type="text/javascript" src="//player.youku.com/jsapi"></script>
<script type="text/javascript">
function play(id){
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '460px',
		  shadeClose: true,
		  skin: 'yourclass',
		  content: "<div id='youkuplayer' style='width:460px;height:400px;'></div>"
		});
	
	var player = new YKU.Player('youkuplayer',{
		client_id: 'a2625d1b601d9ded',
		vid: id,
		newPlayer: true
	});
 }
	
</script>
<script>
     
    /*******添加广告*********/
    $('#ads_add').on('click', function(){
        layer.open({
            type: 1,
            title: '添加广告',
            maxmin: true,
            shadeClose: false, //点击遮罩关闭层
            area : ['800px' , ''],
            content:$('#add_ads_style'),
            btn:['提交','取消'],
            yes:function(index,layero){
                var num=0;
                var str="";
                $(".add_adverts input[type$='text']").each(function(n){
                    if($(this).val()=="")
                    {

                        layer.alert(str+=""+$(this).attr("name")+"不能为空！\r\n",{
                            title: '提示框',
                            icon:0,
                        });
                        num++;
                        return false;
                    }
                });
                if(num>0){  return false;}
                else{
                    layer.alert('添加成功！',{
                        title: '提示框',
                        icon:1,
                    });
                    layer.close(index);
                }
            }
        });
    })
</script>
<script type="text/javascript">
    function updateProgress(file) {
        $('.progress-box .progress-bar > div').css('width', parseInt(file.percentUploaded) + '%');
        $('.progress-box .progress-num > b').html(SWFUpload.speed.formatPercent(file.percentUploaded));
        if(parseInt(file.percentUploaded) == 100) {
            // 如果上传完成了
            $('.progress-box').hide();
        }
    }

    function initProgress() {
        $('.progress-box').show();
        $('.progress-box .progress-bar > div').css('width', '0%');
        $('.progress-box .progress-num > b').html('0%');
    }

    function successAction(fileInfo) {
        var up_path = fileInfo.path;
        var up_width = fileInfo.width;
        var up_height = fileInfo.height;
        var _up_width,_up_height;
        if(up_width > 120) {
            _up_width = 120;
            _up_height = _up_width*up_height/up_width;
        }
        $(".logobox .resizebox").css({width: _up_width, height: _up_height});
        $(".logobox .resizebox > img").attr('src', up_path);
        $(".logobox .resizebox > img").attr('width', _up_width);
        $(".logobox .resizebox > img").attr('height', _up_height);
    }

    var swfImageUpload;
    $(document).ready(function() {
        var settings = {
            flash_url : "Widget/swfupload/swfupload.swf",
            flash9_url : "Widget/swfupload/swfupload_fp9.swf",
            upload_url: "upload.php",// 接受上传的地址
            file_size_limit : "5MB",// 文件大小限制
            file_types : "*.jpg;*.gif;*.png;*.jpeg;",// 限制文件类型
            file_types_description : "图片",// 说明，自己定义
            file_upload_limit : 100,
            file_queue_limit : 0,
            custom_settings : {},
            debug: false,
            // Button settings
            button_image_url: "Widget/swfupload/upload-btn.png",
            button_width: "95",
            button_height: "30 ",
            button_placeholder_id: 'uploadBtnHolder',
            button_window_mode : SWFUpload.WINDOW_MODE.TRANSPARENT,
            button_cursor : SWFUpload.CURSOR.HAND,
            button_action: SWFUpload.BUTTON_ACTION.SELECT_FILE,

            moving_average_history_size: 40,

            // The event handler functions are defined in handlers.js
            swfupload_preload_handler : preLoad,
            swfupload_load_failed_handler : loadFailed,
            file_queued_handler : fileQueued,
            file_dialog_complete_handler: fileDialogComplete,
            upload_start_handler : function (file) {
                initProgress();
                updateProgress(file);
            },
            upload_progress_handler : function(file, bytesComplete, bytesTotal) {
                updateProgress(file);
            },
            upload_success_handler : function(file, data, response) {
                // 上传成功后处理函数
                var fileInfo = eval("(" + data + ")");
                successAction(fileInfo);
            },
            upload_error_handler : function(file, errorCode, message) {
                alert('上传发生了错误！');
            },
            file_queue_error_handler : function(file, errorCode, message) {
                if(errorCode == -110) {
                    alert('您选择的文件太大了。');
                }
            }
        };
        swfImageUpload = new SWFUpload(settings);
    });
    jQuery(function($) {
        var colorbox_params = {
            reposition:true,
            scalePhotos:true,
            scrolling:false,
            previous:'<i class="fa fa-chevron-left"></i>',
            next:'<i class="fa fa-chevron-right"></i>',
            close:'&times;',
            current:'{current} of {total}',
            maxWidth:'100%',
            maxHeight:'100%',
            onOpen:function(){
                document.body.style.overflow = 'hidden';
            },
            onClosed:function(){
                document.body.style.overflow = 'auto';
            },
            onComplete:function(){
                $.colorbox.resize();
            }
        };

        $('.table-striped [data-rel="colorbox"]').colorbox(colorbox_params);
        $("#cboxLoadingGraphic").append("<i class='icon-spinner orange'></i>");

    })
</script>
</script>
<script>
jQuery(function($) {
    var oTable1 = $('#sample-table').dataTable( {
        "aaSorting": [[ 1, "desc" ]],//默认第几个排序
        "bStateSave": true,//状态保存
        "aoColumnDefs": [
            //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
            {"orderable":false,"aTargets":[0,2,3,4,5,7,8,]}// 制定列不参与排序
        ] } );


    $('table th input:checkbox').on('click' , function(){
        var that = this;
        $(this).closest('table').find('tr > td:first-child input:checkbox')
            .each(function(){
                this.checked = that.checked;
                $(this).closest('tr').toggleClass('selected');
            });

    });


    $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
    function tooltip_placement(context, source) {
        var $source = $(source);
        var $parent = $source.closest('table')
        var off1 = $parent.offset();
        var w1 = $parent.width();

        var off2 = $source.offset();
        var w2 = $source.width();

        if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
        return 'left';
    }
})
</script>