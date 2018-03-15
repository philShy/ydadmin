<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css"/>
    <link href="/assets/css/codemirror.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/font/css/font-awesome.min.css" />
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
    <![endif]-->
    <script src="/js/jquery-1.9.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <script src="/js/H-ui.js" type="text/javascript"></script>
    <script src="/ js/displayPart.js" type="text/javascript"></script>
    <title>商品类型</title>
</head>
<style>
    .yincang{display:none}
.error{color:red}
.btn{width:60px;height:30px;background:red;border:none;border-radius:3px;margin:20px;}
.aaa a{color:red; text-decoration: none;}
.aaa a:hover{color:#DE3163;}
	#attr span{display:inline-block;margin-left:40px;width:185px;}
	#attr input{width:110px}
	#attr a{color:red; text-decoration: none;}
	#attr a:hover{color:#DE3163;}
</style>
<body>
<!--添加文章分类图层-->
<div style='width:120px;background:#ffb752;border-radius:3px;padding:5px;margin:10px 20px;text-align:center;color:white;font-size:16px'>添加商品类型</div>
<form action="/product/addtype" method="post" id="iform">
<div id="addsort_style" style="display:" class="article_style">
    <div class="add_content" id="form-article-add" style='padding:0px;border:1px solid #ccc;width:80%;margin-left:20px'>
        <ul style='background:#eee;padding:10px;'>
            <li class="clearfix Mandatory"><label class="label_name"><i>*</i><b>类型名称</b></label>
                <span class="formControls w_txt"><input name="name" type="text" id="form-field-1" class="col-xs-7 col-sm-5  type-name"></span>
            </li>

            <li class="clearfix Mandatory"><label class="label_name">关联规格</label>&nbsp;&nbsp;&nbsp;
            	<div style="width:80%;position:relative;top:-33px;left:110px;">
                <?php foreach($property_arr as $k=>$v):?>
                <label>
                    <div <?php if($v['goods_type_id']){echo"class='yincang'";}?>>
	                <input name="property[]" type="checkbox"  value="<?php echo $v['id']?>" />
	                <?php echo $v['name']?>
                    </div>
                </label> &nbsp;
                <?php endforeach;?>
                </div>
            </li>
        </ul>
        <ul id="attr">
        	<li class="clearfix Mandatory"><label class="label_name"><i>*</i><b>属性名称</b></label>

            </li>
            <li class="clearfix Mandatory attr_head">
               <span>&nbsp;&nbsp;&nbsp;属性名称</span><span>&nbsp;&nbsp;&nbsp;属性值</span><span>操作</span>
            </li>

            <li class="clearfix Mandatory attr_body">

            </li>
            <li class="clearfix Mandatory attr_foot">
            	&nbsp;&nbsp;<span><a onclick="add_attr()" class='add_attr' href="javascript:void(0)">+添加一个属性</a></span>
            </li>
        </ul>
        <input class='btn' type='submit' value='提交'/>
    </div>

</div>
<div class="aaa" style="display:none;float:left" >
	<div class='aa_body'>
		<div class='aaa_body' style='margin-top:10px;float:left'>
	    	<div style='float:left'><input class='aaaa' type=text></div>
	    	<div style='text-align:right;float:left;width:200px'><a class='aaa_del_attr' onclick="aaa_del_attr()" href='javascript:void(0)'>删除</a></div>
    	</div>
	</div>
    <div style='text-align:right;float:left;'>&nbsp;&nbsp;<a class="aaa_add_attr" onclick="aaa_add_attr()" href='javascript:void(0)'>+添加一个值</a></div>
</div>

</form>

</body>
</html>
<script src="/assets/js/jquery.validate.js"></script>
<script>
	var l=0;
	$(function(){
		$('#attr').on('click','.del_attr',function()
		{
			$(this).parent().parent().remove();
		})
		$('.add_attr').click(function(){
			l++;
			$sss = $("<div class='attr_name"+l+"'>"+

			"<span><input type='text' name='attr[attr]["+l+"]'/><a class='edit_attr' href='javascript:void(0)'>编辑属性值</a></span>"+
			"<span><input class='attr_value' type='text' name='attr[attr_val]["+l+"]'/></span>"+
			"<span><a onclick='del_attr()' class='del_attr' href='javascript:void(0)'>删除</a></span>"+
			"</div>")
			$(this).parents('#attr').find('.attr_body').append($sss);

		})
		$('#attr').on('click','.edit_attr',function()
		{
			$('.aaa_body').remove();
			$aaa = $("<div class='aaa_body' style='margin-top:10px;float:left'>"+
			    	"<div style='float:left'><input class='aaaa' value='' type=text></div>"+
			    	"<div style='text-align:right;float:left;width:200px'><a class='aaa_del_attr' onclick='aaa_del_attr()' href='javascript:void(0)'>删除</a></div>"+
		    		"</div>")
			$('.aa_body').append( $aaa);
			var $p = $(this).parent().parent();
			layer.open({
				  type: 1,
				  skin: 'layui-layer-rim', //加上边框
				  area: ['420px', '300px'], //宽高
				  content: $('.aaa'),
				  btn:['提交','取消'],
				  yes:function(index){
					  var s = '';
					  var regu = "^[ ]+$";
					  var re = new RegExp(regu);
					  $('.aaaa').each(function(){
						  if(re.test($(this).val())==false&&$(this).val()!='')
						  {
							  s+=$(this).val()+',';
						  }
					  })
					  s=s.substring(0,s.length-1)
						//alert(s)
					  $p.find('.attr_value').val(s)
					  layer.close(index)
					  }
				});
		})
		$('.aaa').on('click','.aaa_del_attr',function()
		{
			$(this).parents('.aaa_body').remove();
		})
		$('.aaa_add_attr').click(function(){

			$aaa = $("<div class='aaa_body' style='margin-top:10px;float:left'>"+
			    	"<div style='float:left'><input class='aaaa' value='' type=text></div>"+
			    	"<div style='text-align:right;float:left;width:200px'><a class='aaa_del_attr' onclick='aaa_del_attr()' href='javascript:void(0)'>删除</a></div>"+
		    	"</div>")
			$('.aa_body').append($aaa);
		})
	})
	$(function() {
    $("#iform").validate({
        rules: {
        	'name': "required",
           // 'property[]': "required",
        },
        messages: {
        	'name': "必填",
        	//'property[]': "必填",
        }
    });
});
</script>












