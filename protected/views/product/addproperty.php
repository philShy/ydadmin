<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>添加规格属性</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css"/>
    <link rel="stylesheet" href="/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css" />
    <link href="/assets/css/iconfont.css" rel="stylesheet" />
    <link href="/assets/css/fileUpload.css" rel="stylesheet" />
    <link href="/Widget/icheck/icheck.css" rel="stylesheet" type="text/css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
    <![endif]-->

    <script src="/assets/js/jquery.validate.min.js"></script>
    <!--   <script src="/assets/js/jquery-1.9.1.min.js"></script>-->
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript"></script>
    <script type="text/javascript" src="/Widget/swfupload/swfupload.js"></script>
    <script type="text/javascript" src="/Widget/swfupload/swfupload.queue.js"></script>
    <script type="text/javascript" src="/Widget/swfupload/swfupload.speed.js"></script>
    <script type="text/javascript" src="/Widget/swfupload/handlers.js"></script>
</head>
<style>
    .error{color: red}
    .sign{color:red}
  
</style>
<body>
<div class=" clearfix">
    <div id="add_brand" class="clearfix">
        <form action="/product/addproperty" method="post" enctype="multipart/form-data" id="commentForm">
            <ul class="add_conent" style="margin-top: 0; att='aa'">
                <li id="brandname" class=" clearfix"><label class="label_name" ><i class='sign'>*</i>规格名称：</label> <input name="name" type="text" class="add_text" value="" type="text" /></li>
                <li style="display: none" id="sort" class=" clearfix"><label class="label_name"><i class='sign'>*</i>规格序号：</label> <input name="sort" type="number" class="add_text" /></li>
                <!-- <li class=" clearfix"><label class="label_name">显示状态：</label>
                    <label><input name="state" type="radio" class="ace" checked="checked" value="0" /><span class="lbl">显示</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label><input name="state" type="radio" class="ace"  value="1" /><span class="lbl">不显示</span></label>
                </li> -->
                <li class=" clearfix sssss" ><a href='javascript:;' class='addattr' style="color:green;text-decoration:none"><img style='margin-top:-3px;' src='/images/add.png'>&nbsp;添加一个属性</a></li>
                <li><input onclick="return checkNull()" type="submit" id="btn" class="btn btn-warning" value="保存"/><input type="reset" value="取消" class="btn btn-warning"/></li>
            </ul>
        </form>
    </div>
</body>
</html>
<script src="/assets/js/jquery.validate.js"></script>
<script type="text/javascript">
function checkNull()  
{  
    /* var num=0;
     var str="";  
     $("input[type='text']").each(function(n){  
          if($(this).val()=="")  
          {  
               num++;  
               //str+="?"+$(this).attr("msg")+"不能为空！\r\n";  
          }  
     });  
     if(num>0)  
     {  
          layer.alert('属性名称不能为空');  
          return false;  
     }  
     else  
     {  
          return true;  
     }  */
} 
$(function(){
    $('.addattr').click(function(){
		$_this = $(this);
		$_this.parent().append("<div style='margin-top:5px;'><input type='text' name='property[]'>&nbsp;&nbsp;<a class='delattr' href='javascript:;' style='color:#1C8FEF;'>删除</a></div>");
	})
	$('.sssss').on('click','.delattr',function(){
		$(this).parent().remove();
	})
})
$(function() {
    $("#commentForm").validate({
        rules: {
            'property[]':true,
            'name':{
                required: true,
                maxlength:4,
            },
           
        },
        messages: {
            'property[]':"必填",
            'name':{
                required: "必填",
                maxlength:"不能超过4个字",
            },
           
        }
    });
});
    
</script>
