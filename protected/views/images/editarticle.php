<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"/>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css"/>
    <link href="../assets/css/codemirror.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../assets/css/colorbox.css"/>
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

	<script type="text/javascript" src="../js/jquery.min.js"></script>
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
        		}else{
        			trInfo.style.display = 'none';
        		}
        	}}
    </script>
    
</head>
<body>
<form action="/images/editartical_images" method="post" enctype="multipart/form-data" id="commentsForm">
<input name="article_id" type="hidden" class="add_text" value="<?php echo $results['id']?>"/>


<div id="add_ads_style"  >
<div class="add_adverts">
<h1>修改文章图</h1>       
<ul>


<li id="tr1" >

<span class="cont_style">


<label class="label_name" style="float:left;">文章名称</label>
<input style="margin-left: 10px;float:left;width:250px;" readonly type="text" name="article" value="<?php echo $results['title']?>"/>
     
           
  </span>
  
  </li>
 
  
 
         
         
           <li>
   <label class="label_name" style="text-align: center">文章封面图片</label>
 	<div class="col-sm-9 big-photo" style="position:relative;top:-20px;left:85px;">
                                <div id="preview" class="add_text" style="cursor:pointer;margin-top: 20px; margin-left: -87px;">
                                    <img id="imghead" border="0" src="<?php  echo $results[article_img]?>" width="90" height="90" onclick="$('#previewImg').click();"/>
                                </div>
                                    <input type="file" name="file" onchange="previewImage(this)" style="display: none;" id="previewImg" />
   </div>


          </li>
       
            <li><div class="button_brand"><input type="submit" id="btn" class="btn btn-warning" value="保存"/><input type="reset" value="取消" class="btn btn-warning"/></div></li>

        </ul>
    </div>
</div>

</form>
</body>