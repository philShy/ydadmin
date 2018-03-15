<?php 

if (!empty($_REQUEST['rePId'])) {
	$rePId =$_REQUEST['rePId'];
}
?>
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
<form action="/images/addadv" method="post" enctype="multipart/form-data" id="commentsForm">
<!--添加广告样式-->
<div id="add_ads_style"  >
<div class="add_adverts">
<ul>
<li>
   
<label class="label_name" style="text-align: center">类型</label>
<span class="cont_style" style="margin-left: 10px;">

			<select name="down_cate" onchange="change_cate()" id="down_cate";>
				<option value="1">产品</option>
				<option value="2">技术文章</option>
				<option value="3">广告链接</option>
			</select>
		
</span>
  
  </li>
<li id="tr1" style="display:;">

<span class="cont_style">


<label class="label_name" style="float:left;">对应商品id</label>
<input style="margin-left: 10px;float:left" type="text" name="goods_id" id="goods_id" value="<?php echo $rePId?>"/><a href="/images/chooice?act=add&rePId=<?php echo $rePId?>" >请选择</a>
<input style="margin-left: 10px;float:left;display:none;" type="text" name="adressurl" value="<?php echo 'http://www.rdbuy.com.cn/product/productdetail?model_id='.$rePId?>"/>    
   
  </span>
  
  </li>
  <li id="tr2" style="display:none;">

<span class="cont_style">


<label class="label_name" style="float:left;">对应文章id</label>
<input style="margin-left: 10px;float:left" type="text" name="article_id" id="article_id" />
     
           
  </span>
  
  </li>
  <li  id="tr3" style="display:none;">

<span class="cont_style">


<label class="label_name" style="float:left; width: 90px;">对应广告链接</label>
<input style="margin-left: 10px;float:left" type="text" name="adversss" id="adversss"></input></a>
     
           
  </span>
  
  </li>
<li>
   
<label class="label_name" style="text-align: center">对应位置</label>
<span class="cont_style" style="width: 250px;">
<select class="form-control"  name="images_class_id" id="adr">
<option >选择分类</option>
		
      <?php foreach($result as $k=>$v): ?>
      
      <option value="<?php echo $v[id]?>"><?php echo $v[name]?></option>
    <?php endforeach;?>
  </select></span>
    <div style="color:red;" id="adres"></div>
  </li>
  
 <li>
   
<label class="label_name" style="text-align: center">广告名称</label>
<span class="cont_style">

  <input style="margin-left: 10px;float:left" type="text" name="names"  />
 </span>
  </li>
  
 <li>
   <label class="label_name" style="text-align: center">图片排序</label>
<input style="margin-left: 10px;float:left" type="text" name="sort"  />
          </li>
          <li><label class="label_name" style="text-align: center">状态</label>
      <span class="add_content"> &nbsp;&nbsp;<label><input name="is_delete" type="radio" checked="checked" value="0" class="ace"><span class="lbl">显示</span></label>&nbsp;&nbsp;&nbsp;
     <label><input name="is_delete" type="radio" value="1" class="ace"><span class="lbl">隐藏</span></label></span>
            </li>
           <li>
   <label class="label_name" style="text-align: center">商品图片</label>
 	<div class="col-sm-9 big-photo" style="position:relative;top:-20px;left:85px;">
                                <div id="preview" class="add_text" style="cursor:pointer;margin-top: 20px; margin-left: -87px;">
                                    <img id="imghead" border="0" src="../images/photo_icon.png" width="90" height="90" onclick="$('#previewImg').click();"/>
                                  
                                </div>
                                    <input type="file" name="file" onchange="previewImage(this)" style="display: none;" id="previewImg"/>
                                    
   </div>


          </li>
          
            <li><div class="button_brand"><input type="submit" id="btn" class="btn btn-warning" value="保存"/><input type="reset" value="取消" class="btn btn-warning"/></div></li>

        </ul>
    </div>
</div>

</form>
</body>
<script>
$("#adr").change(function(){
	var url="/images/addadv"
	var adr=$(this).val();
	
	$.post(url,{adr:adr},function(data){

		$('#adres').html('');
		jsonObj = eval('(' + data + ')');
		var small='';
		if(data){
			
				small+="最佳图片像素为："+jsonObj['introduce'];
		
		
			$('#adres').append(small) ;
		}
	})
})	
</script>
