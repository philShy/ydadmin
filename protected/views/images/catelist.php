<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>列表 - 素材牛模板演示</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css"/>
    <link href="/assets/css/codemirror.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/font/css/font-awesome.min.css" />
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
    <![endif]-->
    <script src="/js/jquery-1.9.1.min.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script src="/js/lrtk.js" type="text/javascript" ></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>

<script>
      //图片上传预览    IE是用了滤镜。
        function previewImage(file)
        {
          var MAXWIDTH  = 90; 
          var MAXHEIGHT = 90;
          var div = document.getElementById('preview');
          if (file.files && file.files[0])
          {
              div.innerHTML ='<img id=imghead onclick=$("#previewImg").click()>';
              var img = document.getElementById('imghead');
              img.onload = function(){
                var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
                img.width  =  rect.width;
                img.height =  rect.height;
//                 img.style.marginLeft = rect.left+'px';
                img.style.marginTop = rect.top+'px';
              }
              var reader = new FileReader();
              reader.onload = function(evt){img.src = evt.target.result;}
              reader.readAsDataURL(file.files[0]);
          }
          else //兼容IE
          {
            var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
            file.select();
            var src = document.selection.createRange().text;
            div.innerHTML = '<img id=imghead>';
            var img = document.getElementById('imghead');
            img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
            var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
            status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
            div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
          }
        }
        function clacImgZoomParam( maxWidth, maxHeight, width, height ){
            var param = {top:0, left:0, width:width, height:height};
            if( width>maxWidth || height>maxHeight ){
                rateWidth = width / maxWidth;
                rateHeight = height / maxHeight;
                
                if( rateWidth > rateHeight ){
                    param.width =  maxWidth;
                    param.height = Math.round(height / rateWidth);
                }else{
                    param.width = Math.round(width / rateHeight);
                    param.height = maxHeight;
                }
            }
            param.left = Math.round((maxWidth - param.width) / 2);
            param.top = Math.round((maxHeight - param.height) / 2);
            return param;
        }
        function change_cate(){
        	var cate = $("#down_cate").val();
        	for(i=1;i<=3;i++){
        		var trInfo = document.getElementById('tr' + (i));
        		if(i==cate){
        			trInfo.style.display = '';
        			$('#goods_id').html('');
        			$('#article_id').html('');
        			$('#adversss').html('');
        		}else{
        			trInfo.style.display = 'none';
        			$('#goods_id').val('');
        			$('#article_id').val('');
        			$('#adversss').val('');
        		}
        	}}
    </script>
   
</head>

<body>
<div class="page-content clearfix">
    <div class="sort_adsadd_style">
        <div class="border clearfix">
       <span class="l_f">
        <a href="javascript:ovid()" style="display: none" id="ads_add" title="添加品牌" class="btn btn-warning Order_form"><i class="fa fa-plus"></i> 添加广告</a>
        <a href="javascript:ovid()" style="display: none" class="btn btn-danger"><i class="fa fa-trash"></i> 批量删除</a>
        <a href="javascript:ovid()" onclick="javascript :history.back(-1);" class="btn btn-info"><i class="fa fa-reply"></i> 返回上一步</a>
       </span>
            <span class="r_f">共：<b></b>个一级分类</span>
        </div>
        <!--列表样式-->
        <div class="sort_Ads_list">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th style="display: none"><label><input type="checkbox" class="ace"/><span class="lbl"></span></label></th>
                    <th width="5%">ID</th>
                    <th width="30%">分类名称</th>
                    <th width=20%">LoGo</th>
                   	<th width="15%">LoGo2</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($cate as $key=>$value):?>
                    <tr>
                        <td style="display: none"><label><input type="checkbox" class="ace"/><span class="lbl"></span></label></td>
                        <td class="model_id"><?php echo $value['id']?></td>
                        <td><?php echo $value['name']?></td>
                        <td> <a title="编辑" href="/images/editcate?cate_id=<?php echo $value['id']?>&img=1"  ><img  style="height:50px;width:50px"src="<?php echo $value['image_url']?>"></img></a></td>   
                        <td>
                            <a title="编辑" href="/images/editcate?cate_id=<?php echo $value['id']?>&img=2"  ><img  style="height:50px;width:50px"src="<?php echo $value['image_url1']?>"></img></a>
                        </td>  
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<!--添加分类-->
<div class="sort_style_add margin" id="sort_style_add" style="display:none">
    <div class="">
        <ul>
    
            <li style="margin: 0 auto">
            
            <label class="label_name">分类图片</label>
            <div id="preview" class="add_text" style="cursor:pointer;margin-top: 20px;">
            
                                    <img id="imghead" border="0" src="../images/photo_icon.png" width="90" height="90" style="margin-left:50px;" onclick="$('#previewImg').click();"/>
                                  
                                </div>
                                    <input type="file" name="file" onchange="previewImage(this)" style="display: none;" id="previewImg"/>
            </li>
          
           
        </ul>
    </div>
</div>
<script type="text/javascript">
    $('.cate_add').on('click', function(){
 		var id = $(this).attr("id"); //获取点击的id
 		var img = $("img").attr("src");
        layer.open({
            type: 1,
            title: '添加分类LOGO',
            maxmin: true,
            shadeClose: false, //点击遮罩关闭层
            area : ['750px' , ''],
 
            content:$('#sort_style_add'),
            btn:['提交','取消'],
            yes:function(index,layero){
               
                var url = "/images/cate";

                   $.post(url,{pid:id},function(data){
                   		
                        if(data == 1){
                            layer.alert('修改成功！',{
                                title: '提示框',
                                icon:1,
                            });
                            layer.close(index,2);
                            setInterval(function(){window.location.href = '/images/cate'},1000)

                        }
                    });
                
            }
        });
    })
    </script>
</body>
</html>