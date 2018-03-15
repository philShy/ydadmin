<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
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
</head>
<style>
.attr_value{width:160px !important;}
ul{list-style:none}
.btn{width:60px;height:30px;background:red;border:none;border-radius:3px;margin-left:50px;}
.attr_head {margin-left:33px !important;}
.aaa a{color:red; text-decoration: none;}
.aaa a:hover{color:#DE3163;}
	#attr span{display:inline-block;width:180px;}
	#attr input{width:80px}
	#attr a{color:red; text-decoration: none;}
	#attr a:hover{color:#DE3163;}
.btn{margin-left:20px;width:60px;height:30px;background:#6fb3e0;border:none;color:#fff;border-radius:3px;cursor:pointer}
table {border:1px solid #ccc}
table tr:nth-child(odd){background:#F4F4F4;}
table div{margin-left:20px;}
</style>
<body>
<div style='width:120px;background:#ffb752;border-radius:3px;padding:5px;margin-left:10px;text-align:center;color:white;font-size:16px'>编辑商品类型</div>
<div style='margin:10px 0 0 10px;'>
	<form action="/product/edittype" method="post" id="iform">
	<input type="hidden" name="porerty_post_id_str" id="porerty_id_str">
	<input type="hidden" name="id" value="<?php echo $one_type_arr['id']?>" id="porerty_id_str">
	<table width=850px; height=500px cellspacing=0 cellpadding=0 rules="all" >
		<tr>
			<td width="20%"><div>商品类型名称</div></td>
			<td width="80%"><div><input type='text' name="type" value="<?php echo $one_type_arr['type']?>"/></div></td>
		</tr>
		<tr>
			<td><div>关联规格</div></td>
			<?php if(!empty($property_arr)):?>
			<td><div>
                    <?php foreach($property_arr as $k=>$v):?>
                        <?php if($v['goods_type_id']&&$v['goods_type_id']==$one_type_arr['id']):?>
                            <label>
                                <input name="property" type="checkbox" value="<?php echo $v['id']?>" />
                                <?php echo $v['name']?>
                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
            </td>
            <?php endif;?>
		</tr>
		
		<tr>
			<td><div>商品属性</div></td>
			
			<td>
				<div>
	                <ul id="attr">

			            <li class="clearfix Mandatory attr_head">
			               <span>属性名称</span><span>属性值</span><span style="width:40px;margin-left:-12px">操作</span>
			            </li>
			            
			            <li class="clearfix Mandatory attr_body">
			            <?php foreach($attr_arr as $k=>$v):?>
			            	<div style='margin-top:5px;' attrid='<?php echo $v['id']?>' class="attr_name">
				            	<span>
				            		<input type='text' disabled='disabled' name='attr[attr][<?php echo $v['id']?>]' value='<?php echo $v['attr']?>'/>
				            		<a class='edit_attr' attr_id=<?php echo $v['id']?> href='javascript:void(0)'>编辑属性值</a>
				            	</span>
				            	<span>
				            		<input class='attr_value' disabled='disabled' type='text' name='attr[attr_val][<?php echo $v['id']?>]' value='<?php echo $v['attr_val_str']?>'/>
				            	</span>
				            	<span style='width:40px;'>
				            		<a onclick="del_attr()" class='del_attr' href='javascript:void(0)'>删除</a>
				            	</span>
				            	
			            	</div>
			            	<?php endforeach;?>
			            </li>
			            <li class="clearfix Mandatory attr_foot">
			            	<span style='margin-left:25px;'><a onclick="add_attr()" class='add_attr' href="javascript:void(0)">+添加一个属性</a></span>
			            </li>
			        </ul>
                </div>
            </td>
           
		</tr>
		<tr>
			<td colspan='2'><input class='btn' type='button' onclick="getCheckAdIds()" value="提交"></td>
			
		</tr>
	</table>

	</form>
</div>
<div class="aaa" style="display:none;float:left" >
	<div class='aa_body' style='margin-left:10px'>
		<div class='aaa_body' style='margin-left:10px;float:left'>
	    	<div style='float:left'><input class='aaaa' attr_v_id ='' type=text></div>
	    	<div style='text-align:right;float:left;width:200px'><a class='aaa_del_attr' onclick="aaa_del_attr()" href='javascript:void(0)'>删除</a></div>	
    	</div>
	</div>
    <div style='text-align:right;float:left;'>&nbsp;&nbsp;<a class="aaa_add_attr" onclick="aaa_add_attr()" href='javascript:void(0)'>+添加一个值</a></div>
</div>
</body>
</html>
<script type="text/javascript">

function vail(){
	var sum = 0;
	$("#attr input[type=text]").each(function(i){
	    var text = $(this).val();
	    if(text ==""){
	    	sum++;
	    }
	});
	return sum;
}

var l=<?php echo $count?>;
$(function(){

	$('#attr').on('click','.del_attr',function()
	{
		var attr_id = $(this).parents('.attr_name').attr('attrid');
		if(attr_id!=undefined)
		{
			var type_id = '<?php echo $type_id?>';
			var url = "/product/edittype";
				layer.alert('确定删除？',function(index){
				$.post(url,{attr_id:attr_id,del:1},function(data){
					if(data)
					{
						window.location.href='/product/edittype?id='+type_id;
					}
				})

			})
		}else{
			$(this).parent().parent().remove();
		}
	})
	$('.add_attr').click(function(){
		l++;
		$sss = $("<div style='margin-top:5px;' attr_id='' class='attr_name'>"+
		"<span><input type='text' name='attr[attr][]'/><a class='edit_attr' href='javascript:void(0)'>编辑属性值</a></span>"+
		"<span><input readonly='readonly' class='attr_value' type='text' name='attr[attr_val][]'/></span>"+
		"<span style='width:40px;'><a onclick='del_attr()' class='del_attr' href='javascript:void(0)'>删除</a></span>"+
		"</div>")
		$(this).parents('#attr').find('.attr_body').append($sss);
		
	})
	$('#attr').on('click','.edit_attr',function()
	{
		var url = "/product/edittype";
		var attr_id = $(this).attr('attr_id');
		if(attr_id !=undefined)
		{
			$('.aaa_body').remove();
			$.post(url,{attr_id,attr_id},function(data){
				if(data)
				{
					var parsedJson = jQuery.parseJSON(data);
					$.each(parsedJson, function(i, item) {
						$('.aa_body').append("<div class='aaa_body' style='margin-top:10px;float:left'>"+
						    	"<div style='float:left'><input attr_v_id ="+item.id+" disabled='disabled' class='aaaa' value='"+item.attr_val+"' type=text></div>"+
						    	"<div style='text-align:right;float:left;width:200px'><a class='aaa_del_attr' onclick='aaa_del_attr()' href='javascript:void(0)'>删除</a></div>"+	
					    	"</div>");

	                });
				}
			})
		}else{
			$('.aaa_body').remove();
			$aaa = $("<div class='aaa_body' style='margin-top:10px;float:left'>"+
			    	"<div style='float:left'><input attr_v_id ='' class='aaaa' value='' type=text></div>"+
			    	"<div style='text-align:right;float:left;width:200px'><a class='aaa_del_attr' onclick='aaa_del_attr()' href='javascript:void(0)'>删除</a></div>"+	
		    	"</div>")
			$('.aa_body').append( $aaa);
		}
		var $p = $(this).parent().parent();
		var old_attr_str = $p.find('.attr_value').val()
		var old_len = old_attr_str.length;

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
				  if(old_len>0){
					  all = s.substring(0,s.length-1);
					  s=s.substring(old_len+1,s.length-1);
					  if(s==',')
					  {
						  layer.alert('不能为空！')
						  return false;
					  }
                      //return false;
					  $.post(url,{all:all,s:s,attr_id:attr_id},function(data)
					  {
							if(data)
							{
								$p.find('.attr_value').val(all);
								  layer.close(index);
							}
					  })
					 }else{
						  s=s.substring(0,s.length-1);
						  $p.find('.attr_value').val(s);
						  layer.close(index);
					  }
				  }
			});
	}) 
	$('.aaa').on('click','.aaa_del_attr',function()
	{
		var type_id = '<?php echo $type_id?>';
		var url = "/product/edittype";
		$_this=$(this).parents('.aaa_body');
		var attr_v_id = $(this).parents('.aaa_body').find('.aaaa').attr('attr_v_id');
		var attr_v = $(this).parents('.aaa_body').find('.aaaa').val();
		if(attr_v_id)
		{
			$.post(url,{attr_v_id:attr_v_id,attr_v:attr_v},function(data){
				if(data){
					layer.alert('确定删除？',function(index){
						window.location.href='/product/edittype?id='+type_id;
					});
					//$_this.remove();
				}
			})

		}else{
			$(this).parents('.aaa_body').remove();
		}

	})
	$('.aaa_add_attr').click(function(){
		
		$aaa = $("<div class='aaa_body' style='margin-top:10px;float:left'>"+
		    	"<div style='float:left'><input class='aaaa' attr_v_id ='' value='' type=text></div>"+
		    	"<div style='text-align:right;float:left;width:200px'><a class='aaa_del_attr' onclick='aaa_del_attr()' href='javascript:void(0)'>删除</a></div>"+	
	    	"</div>")
		$('.aa_body').append($aaa);
	})

})
//////////////////////////////////////////

$(function() {
	var property_all_id_str = "<?php echo $property_id_str?>";
	var property_all_id_arr = property_all_id_str.split(',');
	var property_id_str = "<?php echo $one_type_arr['property_id']?>";
	var property_id_arr = property_id_str.split(',');

	$("input[name='property']").each(function(){
	    if(property_id_arr.indexOf($(this).val())>=0)
	    {
	        $(this).attr("checked",true);
	    }
	});   
})


function getCheckAdIds() {

	var spCodesTemp = "";
	$('input:checkbox[name=property]:checked').each(function(i){
	if(0==i){
		spCodesTemp = $(this).val();
	}else{
		spCodesTemp += (","+$(this).val());
		}
	});
	/*if(spCodesTemp == '')
	{
		layer.alert('还没有关联规格')
		return false;
	}else if(vail()>0)
	{
		layer.alert('属性必填')
		return false;
	}
	else{

		$('#porerty_id_str').val(spCodesTemp);
		$('form').submit();
	} */
    $('#porerty_id_str').val(spCodesTemp);
    $('form').submit();
}  
</script>





















