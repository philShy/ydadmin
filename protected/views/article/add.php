<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <script src="/assets/laydate/laydate.js" type="text/javascript"></script>
    <script src="/js/H-ui.js" type="text/javascript"></script>
    <title>添加文章</title>
    <style>
    #down{display: inline-block;color:#fff;background:#438eb9;margin-left:20px !important;text-decoration: none;border-radius:3px;}
    .attachItem .right a {display:block;width:16px;height:16px;overflow: hidden;text-indent:-9999px;background:url(/images/delete.png);  }
    .downItem{width:130px;height:130px;background: #eee;float:left;border-radius: 3px;margin-left:5px;margin-top: 5px}
    .downItem .right a {display:block;width:15px;height:15px;overflow: hidden;text-indent:-9999px;background:url(/images/delete.png);  }
    .left{width:150px;height:24px;line-height:25px;float:left}
    .right{float:right;margin-top: -128px;}
    #pic{width:100px; height:100px; margin:15px;  cursor: pointer;}
    .error{color:red}
    #contact_goods li{background:#ddd;margin-left:80px;padding-left:10px;width:65%}
    #contact_article li{background:#ddd;margin-left:80px;padding-left:10px;width:65%}
    #multi-goods{margin-left:98px;display:none}
     #multi-goods-sku{margin-left:98px;display:none}
    #multi-article{margin-left:98px;display:none}
    #omulti-goods{z-index:999;}
</style>
</head>

<?php
function t($arr,$pid=0,$lev=0){
    static $list = array();
    foreach($arr as $v){
        if($v['pid']==$pid){
            $list[] = $v;
            t($arr,$v['id'],$lev+1);
        }
    }
    return $list;
}
$list = t($goods_cate_arr);
?>
<body>
<div class="margin clearfix">
    <div class="article_style">
        <form action="/article/add" method="post" id="add-article" enctype="multipart/form-data">
        <div class="add_content" id="form-article-add">
            <ul>
                <li class="clearfix Mandatory">
                    <label class="label_name"><i>*</i>文章标题</label><span class="formControls col-10"><input name="title" type="text" style="width:500px" ></input></span>
                </li>
             
                <li class="clearfix"><label class="label_name"><i>*</i>所属分类</label>
                   <span class="formControls col-4"><select name="cate" class="form-control" id="form-field-select-1">
                           <?php foreach($cate_arr as $key=>$value):?>
                               <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                           <?php endforeach;?>
                       </select>
                   </span>
                </li>
                <li class="clearfix"><label class="label_name"><i>*</i>文章作者</label>
                    <span class="formControls col-4"><select name="author" class="form-control" id="form-field-select-1">
                             <?php foreach($author_arr as $key=>$value):?>
                               <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                           <?php endforeach;?>
                        </select>
                    </span>
                </li>
                <li class="clearfix"><label class="label_name">点击量</label>
                    <span class="formControls col-10"><input name="hit" type="number" id="form-field-1" value="0"style="width:91px"></input></span>
                </li>
                <li class="clearfix"><label class="label_name">点赞数</label>
                    <span class="formControls col-10"><input name="thumb" type="number" id="form-field-1" value="0"style="width:91px"></input></span>
                </li>
                <li class="clearfix"><label class="label_name">是否推荐</label>
                    <span class="formControls col-4">
                        <select name="recommend" class="form-control" id="form-field-select-1" style="width:91px">
                            <option value="0">不推荐</option>
                            <option value="1">推荐</option>
                            <option value="2">主推</option>
                        </select>
                    </span></li>
                <li>
                    <div id="addCommodityIndex">
                        <div class="input-group row">
                            <label class="label_name" ><i></i>封面图片</label>
                            <div class="col-sm-9 big-photo" style="position:relative;top:-20px;left:85px;">
                                <div id="preview" class="add_text" style="cursor:pointer">
                                    <img id="imghead" border="0" src="/images/photo_icon.png" width="100" height="100" onclick="$('#previewImg').click();"/>
                                </div>
                                <input type="file" name="file" onchange="previewImage(this)" style="display: none;" id="previewImg"></input>
                            </div>
                        </div>
                    </div>
                </li>
                <li id='contact_goods' class="clearfix"><label class="label_name">关联商品</label>
                	<div id="odiv_goods">
	                    &nbsp;&nbsp;<input class='contact_goods_str' type='text' name='contact_goods_str' />
		                <input class='contact_goods' type='text' placeholder='请输入商品标题' name='contact_goods' />
		                <input id='goods_sure' style="height:28px;line-height:14px;" type='button' value='确定' />
		                <input id='goods_sure_sku' style="height:28px;line-height:14px;display:none" type='button' value='确定' />
	                </div>
	                <div id="omulti-goods">
	                	<select id='multi-goods'>
						</select>
						<select id='multi-goods-sku' multiple='multiple'>
						</select>
	                </div>
	                
 				</li>
 				<li id='contact_article' class="clearfix"><label class="label_name">关联文章</label>
 					<div id="odiv_article">
	                    &nbsp;&nbsp;<input class='contact_article_str' type='text' name='contact_article_str' />
		                <input class='contact_article' type='text' placeholder='请输入文章标题' name='contact_article' />
		                <input id='article_sure' style="height:28px;line-height:14px;" type='button' value='确定' />
	                </div>
	                <div>
	                	<select id='multi-article' multiple='multiple'>
						</select>
	                </div>
	               
 				</li>
                <li style="display:none" class="clearfix addimg" ><label class="label_name">文章图片</label>
                    <a href="javascript:void(0)" id="down" style="margin-left: 10px">上传附件</a>
                    <div class="down-list-container" style="display: none;width:1062px;margin-left:92px;">
                        <div class="downList clear"></div>
                    </div>
                </li>
                <li class="clearfix"><label class="label_name">文章内容</label>
                    <span class="formControls col-10"><script id="content" name="content" type="text/plain" style="width:100%;height:400px; margin-left:10px;"></script> </span>
                </li>
            </ul>
            <div class="Button_operation">
                <input type="submit" value="提交" class="btn btn-primary radius"></input>
            </div>
        </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="/Widget/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="/Widget/ueditor/1.4.3/ueditor.all.min.js"> </script>
<script type="text/javascript" src="/Widget/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="/assets/js/jquery.validate.js"></script>
<script type="text/javascript">
$(function(){
	//商品标题处理
		$('.contact_goods').keyup(function(){
			
		var contact_goods = $(this).val();
		if(contact_goods == '')
		{
			$(this).parents('#contact_goods').find('option').remove();
			$('#multi-goods').hide();
			return false;
		}
		var url = '/article/add';
		$_this = $(this)
		$.post(url,{contact_goods:contact_goods,mark:1},function(data){
			if(data){
				$('#multi-goods').show();
				$("#goods_sure_sku").hide();
				$("#goods_sure").show();
				$('#multi-goods-sku').hide();
				var parsedJson = jQuery.parseJSON(data);
				$_this.parents().find('#multi-goods option').remove();
	            $.each(parsedJson, function(i, item) {
	            	$_this.parents().find('#multi-goods').append('<option value='+item.id+'>'+item.title+'</option>');

	            });
			}else if(data == ''){
				$('#multi-goods').hide();
			}
		})
	})
	$("#goods_sure").click(function(){
		var url = '/article/add';
		var goods_model_id=$("#multi-goods").val();
		//console.log(goods_model_id);
		$("#multi-goods").hide();
		
		$.post(url,{goods_model_id:goods_model_id},function(data){
			//console.log(data);
			$('#multi-goods').html('');
			jsonObj = eval('(' + data + ')');
			var smalls='';
			if(data){
				//console.log(data);
				for(i=0;i<jsonObj.length;i++){
					smalls+="<option value="+jsonObj[i]['aid']+">"+jsonObj[i]['guige']+"</option>"
				}
				$('#multi-goods-sku').show();
				$("#goods_sure").hide();
				$("#goods_sure_sku").show();
				$('#multi-goods-sku').append(smalls) ;
			}
			
		})
	});
	$("#goods_sure_sku").click(function(){
		var strs= new Array();
		var contact_goods_str = $("#multi-goods-sku").val()+',';
		if($("#multi-goods-sku").val()==null)
	 		{
	 			contact_goods_str = '';
	 			if($('#odiv_goods span').length<1){
	 				$('#odiv_goods').append("<span style='color:red'>关联商品不能为空</span>");
	 			}
	 		}
	         var contact_goods_str_arr = $('#contact_goods').find('.contact_goods_str').val();
	         strs=contact_goods_str.split(",");
	         for (i=0;i<strs.length ;i++ ) 
	         { 
	         	if(contact_goods_str_arr.indexOf(strs[i])>=0 && strs[i]!='')
	         	{
	             	strs.splice($.inArray(strs[i],strs),1);
	             }
	         }
	         var new_contact_goods_str = strs.join(",");

	         var n=(contact_goods_str_arr.split(',')).length;
	        
	     	
	     	if(contact_goods_str_arr.indexOf(contact_goods_str)>=0)
	 		{
	 			if($('#odiv_goods span').length<1){
	 				$('#odiv_goods').append("<span style='color:red'>关联商品不能重复</span>");
	 			}
	 			contact_goods_str = '';
	 		}else{
	 			$('#odiv_goods span').remove();
	 		}
	 		$('#contact_goods').find('.contact_goods_str').val(contact_goods_str_arr + new_contact_goods_str);
		
		})
		//var strs= new Array();
		//var contact_goods_str = $("#multi-goods-").val()+',';
// 		if($("#multi-goods").val()==null)
// 		{
// 			contact_goods_str = '';
// 			if($('#odiv_goods span').length<1){
// 				$('#odiv_goods').append("<span style='color:red'>关联商品不能为空</span>");
// 			}
// 		}
//         var contact_goods_str_arr = $('#contact_goods').find('.contact_goods_str').val();
//         strs=contact_goods_str.split(",");
//         for (i=0;i<strs.length ;i++ ) 
//         { 
//         	if(contact_goods_str_arr.indexOf(strs[i])>=0 && strs[i]!='')
//         	{
//             	strs.splice($.inArray(strs[i],strs),1);
//             }
//         }
//         var new_contact_goods_str = strs.join(",");

//         var n=(contact_goods_str_arr.split(',')).length;
        
//     	if(n>3)
//         {
//     		layer.alert('关联商品不能超过3个！');
//     		return false;  
//         }
//     	if(contact_goods_str_arr.indexOf(contact_goods_str)>=0)
// 		{
// 			if($('#odiv_goods span').length<1){
// 				$('#odiv_goods').append("<span style='color:red'>关联商品不能重复</span>");
// 			}
// 			contact_goods_str = '';
// 		}else{
// 			$('#odiv_goods span').remove();
// 		}
// 		$('#contact_goods').find('.contact_goods_str').val(contact_goods_str_arr + new_contact_goods_str);
      
    
// 	function judge_goods(){
// 		var goods_title_content = $(".contact_goods_str").val();
// 		var position = getPosition(goods_title_content,',',3);
// 		var ss = goods_title_content.substr(0,position+1);
// 		var count = findCount(goods_title_content,',');
// 		if(count>3){
// 			$(".contact_goods_str").val(ss);
// 			layer.alert('关联商品不能超过3个！');
//     		return false;  
// 		}
// 	}






















































	
	//关联文章处理
	$('.contact_article').keyup(function(){
		var contact_article = $(this).val();
		if(contact_article == '')
		{
			$(this).parents().find('#multi-article option').remove();
			$('#multi-article').hide();
			return false;
		}
		var url = '/article/add';
		$_this = $(this)
		$.post(url,{contact_article:contact_article,mark:1},function(data){
			if(data){
				$('#multi-article').show();
				var parsedJson = jQuery.parseJSON(data);
				$_this.parents().find('#multi-article option').remove();
	            $.each(parsedJson, function(i, item) {
	            	$_this.parents().find('#multi-article').append('<option value='+item.id+'>'+item.title+'</option>');
	            });
			}else if(data == ''){
				//$('#multi-article).hide();
			}
		})
	})
	$("#article_sure").click(function() {
		var strs= new Array();
		var contact_article_str = $("#multi-article").val()+',';
		if($("#multi-article").val()==null)
		{
			contact_article_str = '';
			if($('#odiv_article span').length<1){
				$('#odiv_article').append("<span style='color:red'>关联文章不能为空</span>");
			}
		}
        var contact_article_str_arr = $('#contact_article').find('.contact_article_str').val();
        strs=contact_article_str.split(",");
        for (i=0;i<strs.length ;i++ ) 
        { 
        	if(contact_article_str_arr.indexOf(strs[i])>=0 && strs[i]!='')
        	{
            	strs.splice($.inArray(strs[i],strs),1);
            }
        }
        var new_contact_article_str = strs.join(",");

        var n=(contact_article_str_arr.split(',')).length;
        
    	if(n>3)
        {
    		layer.alert('关联文章不能超过3个！');
    		return false;  
        }
    	if(contact_article_str_arr.indexOf(contact_article_str)>=0)
		{
			if($('#odiv_article span').length<1){
				$('#odiv_article').append("<span style='color:red'>关联文章不能重复</span>");
			}
			contact_article_str = '';
		}else{
			$('#odiv_article span').remove();
		}
		$('#contact_article').find('.contact_article_str').val(contact_article_str_arr + new_contact_article_str);
        $("#multi-article").hide('slow',judge_article())
    }); 
	function judge_article(){
		var article_title_content = $(".contact_article_str").val();
		var position = getPosition(article_title_content,',',3);
		var ss = article_title_content.substr(0,position+1);
		var count = findCount(article_title_content,',');
		if(count>3){
			$(".contact_article_str").val(ss);
			layer.alert('关联文章不能超过3个！');
    		return false;  
		}
	} 
	/////////////////
	function getPosition(str,searchfor,count) 
	{ 
		for(var i=0;i<str.length;i++){
		    if(str.charAt(i)==searchfor)
		    	count--;
		    if(count==0){
		        return i;
		        break;
		    }
		}
	} 
	
	function findCount(targetStr, FindStr) {  
	    var start = 0;  
	    var aa = 0;  
	    var ss =targetStr.indexOf(FindStr, start);  
	    while (ss > -1) {  
	        start = ss + FindStr.length;  
	        aa++;  
	        ss = targetStr.indexOf(FindStr, start);  
	    }  
	    return aa;  
	}  
	/* $('.contact_goods').keyup(function(){
		var contact_goods = $(this).val();
		if(contact_goods == '')
		{
			$(this).parent().find('ul li').remove();
		}
		var url = '/article/add';
		$_this = $(this)
		$.post(url,{contact_goods:contact_goods},function(data){
			if(data){
				var parsedJson = jQuery.parseJSON(data);
				$_this.parent().find('ul li').remove();
	            $.each(parsedJson, function(i, item) {
	            	$_this.parent().find('ul').append('<a value='+item.id+'><li>'+item.title+'</li></a>');

	            });
			}
			
		})
	})

	$("#contact_goods").on("click","a",function(){
    	var contact_goods_str =  $(this).attr('value')+',';
    	var contact_goods_str_arr = $('#contact_goods').find('.contact_goods_str').val();
    	var n=(contact_goods_str_arr.split(',')).length;
    	if(n>3)
        {
    		layer.alert('关联商品不能超过3个！');
    		return false;  
        }
		if(contact_goods_str_arr.indexOf(contact_goods_str)>=0)
		{
			if($('#odiv_goods span').length<1){
				$('#odiv_goods').append("<span style='color:red'>关联商品不能重复</span>");
			}
			contact_goods_str = '';
		}else{
			$('#odiv_goods span').remove();
		}
    	$('#contact_goods').find('.contact_goods_str').val(contact_goods_str_arr + contact_goods_str);
    })

	$('#goods_sure').click(function(){
		$('#contact_goods').find('ul li').remove();	
	})

	//文章标题处理
	$('.contact_article').keyup(function(){
		var contact_article = $(this).val();
		if(contact_article == '')
		{
			$(this).parent().find('ul li').remove();
		}
		var url = '/article/add';
		$_this = $(this)
		$.post(url,{contact_article:contact_article},function(data){
			if(data){
				var parsedJson = jQuery.parseJSON(data);
				$_this.parent().find('ul li').remove();
	            $.each(parsedJson, function(i, item) {
	            	$_this.parent().find('ul').append('<a value='+item.id+'><li>'+item.title+'</li></a>');

	            });
			}
			
		})
	})

	$("#contact_article").on("click","a",function(){
    	var contact_article_str =  $(this).attr('value')+',';
    	var contact_article_str_arr = $('#contact_article').find('.contact_article_str').val();
    	var n=(contact_article_str_arr.split(',')).length;
    	if(n>3)
        {
    		layer.alert('关联文章不能超过3个！');
    		return false;  
        }
		if(contact_article_str_arr.indexOf(contact_article_str)>=0)
		{
			if($('#odiv_article span').length<1){
				$('#odiv_article').append("<span style='color:red'>关联文章不能重复</span>");
			}
			contact_article_str = '';
		}else{
			$('#odiv_article span').remove();
		}
    	$('#contact_article').find('.contact_article_str').val(contact_article_str_arr + contact_article_str);
    })

	$('#article_sure').click(function(){
		$('#contact_article').find('ul li').remove();	
	}) */
		
})
//////商品 文章 结束///////////
//图片上传预览    IE是用了滤镜。
    function previewImage(file)
    {
        var MAXWIDTH  = 90;
        var MAXHEIGHT = 90;
        var div = document.getElementById('preview');
        if (file.files && file.files[0])
        {
            div.innerHTML ='<img width=100px; id=imghead onclick=$("#previewImg").click()>';
            var img = document.getElementById('imghead');
            img.onload = function(){
                var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
                img.width  =  rect.width;
                img.height =  rect.height;
				//img.style.marginLeft = rect.left+'px';
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
    $(function() {
        $("#pic").click(function () {
            $("#upload").click(); //隐藏了input:file样式后，点击头像就可以本地上传
            $("#upload").on("change",function(){
                var objUrl = getObjectURL(this.files[0]) ; //获取图片的路径，该路径不是图片在本地的路径
                if (objUrl) {
                    $("#pic").attr("src", objUrl) ; //将图片路径存入src中，显示出图片
                }
            });
        });
    });

    $(function(){
        $("#add-article").on('click','#down',function(){
            $(this).parent().find('.down-list-container').show()
            $fileField = $("<input type='file' name='down[]'/>");
            $fileField.hide();
            $(this).parent().find(".downList").append($fileField);
            $fileField.trigger("click");
            $fileField.change(function(){
                var objUrl = getObjectURL(this.files[0]) ; //获取图片的路径，该路径不是图片在本地的路径
                $path = $(this).val();
                $filename = $path.substring($path.lastIndexOf("\\")+1);
                $downItem = $("<div class='downItem'><img id='pic' src="+objUrl+" ><div class='right'><a href='#' title='删除附件'>删除</a></div></div>");
                $downItem.find(".left").html($filename);
                $(this).parent().append($downItem);
            });
        });
        $("#add-article").on('click','.downItem a',function(obj,i){
            $(this).parents('.downItem').prev('input').remove();
            $(this).parents('.downItem').remove();
        });
    })

    //建立一個可存取到該file的url
    function getObjectURL(file){
        var url = null ;
        if (window.createObjectURL!=undefined) { // basic
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }
    $(function(){
        var ue = UE.getEditor('content');
    });
    $(function(){
        $("#add-article").validate({
            rules: {
                title: {
                    required: true,
                    rangelength:[0,30]
                },
                introduce: {
                    required: true,
                    rangelength:[0,50]
                }
            },
            messages: {
                title: {
                    required: "&nbsp;&nbsp;必填",
                    maxlength: "&nbsp;&nbsp;标题字数介于0-20之间"
                },
                introduce: {
                    required: "&nbsp;&nbsp;必填",
                    minlength:'&nbsp;&nbsp;简介字数介于0-50之间'
                }
            }
        })
    })
</script>
</body>
</html>

