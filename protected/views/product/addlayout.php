<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="renderer" content="webkit|ie-comp|ie-stand"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" type="text/css" href="../css/jquery.datetimepicker.css"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="../js/html5.js"></script>
    <script type="text/javascript" src="../js/respond.min.js"></script>
    <script type="text/javascript" src="../js/PIE_IE678.js"></script>
    <![endif]-->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css"/>
    <link href="../assets/css/codemirror.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../assets/css/ace.min.css" />
    <link rel="stylesheet" href="../Widget/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css"/>
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="../assets/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <link href="../Widget/icheck/icheck.css" rel="stylesheet" type="text/css" />
    <link href="../Widget/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />
    <title>新增图片 - 素材牛模板演示</title>
    <style type="text/css">
		input{
			style='border-left:0px;border-top:0px;border-right:0px;border-bottom:1px '
			}
		#butn{width:60px;height:26px;text-decoration: none;text-align:center;
        line-height:26px;border-radius:3px;  background: #428bca;color:white;display:
        inline-block;}
         #contact_goods li{background:#ddd;margin-left:80px;padding-left:10px;width:65%}

    #multi-goods{margin-left:65px;display:none}
     #multi-goods-sku{margin-left:65px;display:none}

    #omulti-goods{z-index:999;}
</style>
</head>

<body>
<div class=" clearfix">
    	<div id="add_brand" class="clearfix">
        	<form action="" method="post" enctype="multipart/form-data" id="commentForm">
        			<div class="left_add" style="border:1px">
            				<ul class="add_conent" style="margin-top: 0;">
                					<li id="brandname" class=" clearfix">
               								<label class="label_name" style="width: 150px; margin-left: -20px;"><i>*</i>分类名称：</label>
                								<select class="form-control" id="big" name="first_categorys" style=" float:left;width: 190px; margin-left: 10px; required">
													<option value="">选择分类</option>
													<?php foreach($sbc as $k=>$v): ?>
      												<option value="<?php echo $v[id]?>"><?php echo $v[name]?></option>
    												<?php endforeach;?>
  												</select>
  									</li>

                					<li class="clearfix">
                    				<div id="addCommodityIndex">
                        				<!--input-group start-->
                        				<div class="input-group row">
                            				<label class="label_name"  style="width: 150px; margin-left: -20px;" ><i></i>二级分类（6个）：</label>
                            				<input id="assoc" type="text" placeholder="关联二级分类" name="associated" class="contact_article_str"  />
                           					<select id="choice" class="form-control"  multiple="multiple" name="second_category" style="display: none; float:left;width: 190px; margin-left: 10px;">
											<option >选择分类</option>
 							 				</select>
  											<a href="javascript:void (0)" id="associated" style="background: #ddd;">请选择</a>
  											<a href="javascript:void (0)" id="sure" style="background: #ddd;display: none;">确定</a>
                        					<span style="color:red">多选,ctrl</span>
                        				</div>
                        				<!--input-group end-->
                   					</div>
                					</li>
                					<li class="clearfix">

					                    <div id='contact_goods' class="clearfix modelchild">
					                    <label class="label_name" style="width: 150px; margin-left: -20px;"><i></i>商品推荐（3个）：</label>

                					<div id="odiv_goods">

					                    <input class='contact_goods_str' id="assocs" type="text" placeholder="关联商品" name="associateds"  required class="contact_article_strs"/>
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

				 				 </div>
               						 </li>

					                 <li class="clearfix">
					                	<label class="label_name" style="width: 150px; margin-left: -20px;"><i></i>新品推荐：</label>
					                	<table id='table1'>
					                	<tr>

					                   			<td><label class="label_name"><i></i>商品名称</label></td>
					                          	<td><label class="label_name" ><i></i>是否新品</label></td>

					                   	</tr>


					    				<tr>
					    				<td id="bsgoodss">
					    					<select  class="form-control bsgoods"  name="products[]"  style="float:left;width: 190px; margin-left: 10px;">
												<option >选择产品</option>
											</select>
										</td>
					        			<td style="padding:10px 20px">
					            			<label><input name="tr1" type="radio" class="ace"  value="0" /><span class="lbl">是</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					                        <label><input name="tr1" type="radio" class="ace" checked="checked" value="1" /><span class="lbl">否</span></label>
					        			</td>
					    				</tr>

										</table>
										<input type="button" onclick="addInput()" value="增加" id="butn" />
					                </li>

					                <li class="clearfix">
					                    <div id="addCommodityIndexa">
					                        <!--input-group start-->
					                        <div class="input-group row">
					                            <label class="label_name" style="width: 150px; margin-left: -20px;"><i></i>推荐品牌（5个）：</label>
					                            <input id="assoca" type="text" placeholder="关联品牌" name="associateda"   class="contact_article_strsss"/>
					                            <select id="choicea" class="form-control"  multiple="multiple" name="bland" style="display: none; float:left;width: 190px; margin-left: 10px;">
												<option >选择品牌</option>
					 							 </select>
					  				<a href="javascript:void (0)" id="associateda" style="background: #ddd;">请选择</a>
					  				<a href="javascript:void (0)" id="surea" style="background: #ddd;display: none;">确定</a>
					                        <span style="color:red">多选,ctrl</span>
					                        </div>
					                        <!--input-group end-->
					                    </div>
					                </li>
					                <li class="clearfix">
					                	  <label class="label_name" style="width: 150px; margin-left: -20px;"><i></i>广告id：</label>

					                            <select id="choiceas" class="form-control"   name="adv"  style="float:left;width: 190px; margin-left: 10px;">
												<option >选择广告组</option>
													<?php foreach($adv as $key=>$value): ?>

					     				 			<option value="<?php echo $value[id]?>"><?php echo $value[name]?></option>
					    							<?php endforeach;?>

					 							 </select>

					                </li>
					                 <li id="sort" class=" clearfix"><label class="label_name" style="width: 150px; margin-left: -20px;"><i>*</i>排列序号：</label> <input name="sort" type="text" class="add_text" /></li>
					                 <li><div><a class="btn btn-primary radius" href="javascript:void(0)" id="submit">提交</a><input type="reset" value="取消" class="btn btn-warning"/></div></li>
					            </ul>
					        </div>
        </form><!--<input id="uploaderInput" class="uploader__input" style="display: none;" type="file" accept="" multiple="">-->
    </div>

   </div>
<script src="../js/jquery-1.9.1.min.js"></script>
<script src="../assets/layer/layer.js" type="text/javascript" ></script>
<script src="../assets/laydate/laydate.js" type="text/javascript"></script>
<script type="text/javascript" src="../Widget/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="../Widget/ueditor/1.4.3/ueditor.all.min.js"> </script>
<script type="text/javascript" src="../Widget/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<script src="../assets/js/jquery.validate.js"></script>
<script src="../js/jquery.datetimepicker.full.js"></script>

<script>
function addInput() {
	var modelsl = document.getElementById("bsgoodss").innerHTML;
    var table = document.getElementById("table1");
    var id = (new Date()).valueOf();//为每行生成一个唯一name，radio是组的概念
    var tr = document.createElement("tr");

    tr.innerHTML ="<td>" + modelsl + "</td><td style=\"padding:10px 20px\"> <label><input name=\"tr" + id + "\" type=\"radio\" class=\"ace\"  value=\"1\"><span class=\"lbl\">是</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input name=\"tr" + id + "\" type=\"radio\" class=\"ace\" checked=\"checked\" value=\"0\"><span class=\"lbl\">否</span></label></td>";

    table.appendChild(tr);
}
$(function(){

	var url="/product/addlayout"
	$("#big").change(function(){

		var first_category=$(this).val();

		$.post(url,{first_category:first_category},function(data){

			$('#choice').html('');
			jsonObj = eval('(' + data + ')');
			var small='';
			if(data){
				for(i=0;i<jsonObj.length;i++){
					small+="<option  value="+jsonObj[i]['id']+">"+jsonObj[i]['name']+"</option>"
				}

				$('#choice').append(small) ;
			}

		})
	})
$("#big").change(function(){

		var product=$(this).val();

		$.post(url,{product:product},function(data){
			$('.bsgoods').html('');
			$('#choices').html('');
			jsonObj = eval('(' + data + ')');
			var smalls='';
			if(data){
				for(i=0;i<jsonObj.length;i++){
					smalls+="<option value="+jsonObj[i]['cid']+">"+jsonObj[i]['title']+"</option>"
				}

				$('.bsgoods').append(smalls) ;
				$('#choices').append(smalls) ;
			}

		})
	})

$("#big").change(function(){

		var bland=$(this).val();

		$.post(url,{bland:bland},function(data){

			$('#choicea').html('');
			jsonObj = eval('(' + data + ')');
			var smalla='';
			if(data){
				for(i=0;i<jsonObj.length;i++){
					smalla+="<option value="+jsonObj[i]['bid']+">"+jsonObj[i]['brandname']+"</option>"
				}

				$('#choicea').append(smalla) ;
			}

		})
	})




})

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
$(function(){
    $("#associated").click(function(){

        $(this).parent().find('#choice').show();
        $(this).parent().find('#sure').show();
        $(this).hide();
    })

     $("#sure").click(function(){
        var obj = $(this).parent().find('#choice');
        $(this).parent().find('#assoc').val(obj.val())
        $(this).parent().find('#choice').hide();
        $(this).parent().find('#associated').show();
        $(this).hide();
        var article_title_content = $(".contact_article_str").val();

 		var count = findCount(article_title_content,',')+1;
       		if(count != 6){
       		 $('#assoc').val("");
					alert('请上传6个二级分类');

           		}





    })

})
$(function(){
    $("#associateds").click(function(){

        $(this).parent().find('#choices').show();
        $(this).parent().find('#sures').show();
        $(this).hide();
    })

     $("#sures").click(function(){
        var obj = $(this).parent().find('#choices');
        $(this).parent().find('#assocs').val(obj.val())
        $(this).parent().find('#choices').hide();
        $(this).parent().find('#associateds').show();
        $(this).hide();
var article_title_content = $(".contact_article_strs").val();

 		var count = findCount(article_title_content,',')+1;
       		if(count != 3){
       		 $('#assocs').val("");
					alert('请上传3件商品');

           		}

    })

})
$(function(){
    $("#associatedsp").click(function(){

        $(this).parent().find('#choicese').show();
        $(this).parent().find('#suresp').show();
        $(this).hide();
    })

     $("#suresp").click(function(){
        var obj = $(this).parent().find('#choicese');
        $(this).parent().find('#assocsp').val(obj.val())
        $(this).parent().find('#choicese').hide();
        $(this).parent().find('#associatedsp').show();
        $(this).hide();
var article_title_content = $(".contact_article_strss").val();

 		var count = findCount(article_title_content,',')+1;
       		if(count != 3){
       		 $('#assocsp').val("");
					alert('请上传3件商品');

           		}

    })

})
$(function(){
    $("#associateda").click(function(){

        $(this).parent().find('#choicea').show();
        $(this).parent().find('#surea').show();
        $(this).hide();
    })

     $("#surea").click(function(){
        var obj = $(this).parent().find('#choicea');
        $(this).parent().find('#assoca').val(obj.val())
        $(this).parent().find('#choicea').hide();
        $(this).parent().find('#associateda').show();
        $(this).hide();
var article_title_content = $(".contact_article_strsss").val();

 		var count = findCount(article_title_content,',')+1;
       		if(count != 5){
       		 $('#assoca').val("");
					alert('请上传5个品牌');

           		}

    })

})
$("#submit").click(function(){
            var first_categorys = $('#big').val();
            var second_categorys =$("input[name='associated']").val();
            var model =$("input[name='associateds']").val();
           var brand=$("input[name='associateda']").val();
           var adver=$('#choiceas').val();
           var sort=$("input[name='sort']").val();
     		var choice= new Array();
     		 $("input[class='ace']").each(function(){
     			 if($(this).is(':checked')){
     				choice.push($(this).val());

     		    }
    　　
    });

//             array =$("select[name='products[]']");

//              for(var i=0;i<array.length;i++){
//             	 var value = $(array[i]).val();
//              }


			var model_new= new Array();

           $("select[name='products[]']").each(function(){
           　　			model_new.push($(this).val());
           });

           $.post("/product/addlayout",
          {first_categorys:first_categorys,second_categorys:second_categorys,model:model,brand:brand,adver:adver,model_new:model_new,sort:sort,choice:choice},
                   function(data)
                   {


                	  if(data==''){
                          layer.alert('添加失败');
                          return false;
                      }else{
      					layer.alert('添加成功',function(){window.location.href="/product/layout";});

                     }

                   })
                   return false;
});

</script>
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
		var url = '/product/add';
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
		var url = '/product/add';
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
		//alert(contact_goods_str);
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
})
</script>


</body>
</html>
