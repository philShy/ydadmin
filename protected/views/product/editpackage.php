<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>编辑套餐</title>
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
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/>
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
    select{width:162px;margin-left: 10px;}
    .info-ss{margin-top:3px;}
</style>
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
$list = t($result);
?>
<body>
<div class=" clearfix">
    <div id="add_brand" class="clearfix">
        <form action="/product/editpackage" method="post" enctype="multipart/form-data" id="commentForm">
            <input type="hidden" value="<?php echo $packagearr['id']?>" name="package_id">
                <ul class="add_conent" style="margin-top: 0;">
                    <li id="sort" class=" clearfix"><label class="label_name"><i>*</i>套餐名称：</label> <input name="packagename" type="text" value="<?php echo $packagearr['name']?>" class="add_text" /></li>
                     <li id="brandname1" class=" clearfix">
                    	<div style='margin-left:5px;' ><i>*</i>选择商品：</div>
		                    <div class='info' style='margin:-25px 0 0 84px;'>
								<?php foreach($meal_arr as $k=>$v):?>
			                    <div class='info-ss info-s-<?php echo $k?>'>
			                        <select name='selected' class='selected' onchange='chgc(<?php echo $k?>)' style='width:163px'>
			                            <option value=''>----选择类别----</option>
			                            <?php foreach($list as $key=>$value):?>
			                                <?php $count = substr_count($value['pth'],',');$str = '&nbsp;';if($count):?>
			                                    <option <?php if($v['cate_id']==$value['id']){echo 'selected';}?> value=<?php echo $value['id']?>><?php echo str_repeat($str,($count)*4).$value['name'];?></option>
			                                <?php endif?>
			                            <?php endforeach;?>
			                        </select>
			                        <select name='goodsname' class='child' onchange='chgg(<?php echo $k?>)' style='width:123px;'>
			                            <option value=''>----选择商品----</option>
			                            <?php $goodsarr = CProduct::searchGoods($v['cate_id']);?>
			                            <?php foreach($goodsarr as $gk=>$gv):?>
			                            <option <?php if($v['goods_id']==$gv['id']){echo 'selected';}?> value='<?php echo $gv['id']?>'><?php echo $gv['name']?></option>
			                            <?php endforeach;?>
			                            
			                        </select>
			                        <select name='goodsmodel[]' class='childs' onchange='chgm(<?php echo $k?>)' style='width:123px;'>
			                            <option value='' >----选择型号----</option>
			                            <?php $modelarr = CProduct::searchModels($v['goods_id']);?>
			                            <?php foreach($modelarr as $mk=>$mv):?>
			                            <option <?php if($v['goods_model_id']==$mv['id']){echo 'selected';}?> value='<?php echo $mv['id']?>'><?php echo $mv['model_number']?></option>
			                            <?php endforeach;?>
			                        </select>
			                        <select name='goodssku[]' class='childsku' onchange='chgs(<?php echo $k?>)' style='width:123px;'>
			                            <option value='' >----选择sku----</option>
			                            <?php $skuarr = CProduct::searchskus_byid($v['goods_model_id']);?>
			                            <?php foreach($skuarr as $sk=>$sv):?>
			                            <option <?php if($v['goods_sku_id']==$sv['id']){echo 'selected';}?> value='<?php echo $sv['id']?>'><?php echo $sv['combination']?></option>
			                            <?php endforeach;?>
			                        </select>
			                        <span class='jianshao' style='font-size:22px'> -</span>
			                        <input  name='meal_goods_id[]' value=<?php echo $v['id']?> type='hidden'>
			                        <div class='price' style='width:30%;margin-left: 28px;margin-top: 10px;'>原&nbsp;&nbsp;&nbsp;价：<input  name='price[]' value=<?php echo $v['unit_price']+$v['difference']?> type='text' placeholder='原价' readonly style='margin-left: 16px'></div>
			                        <div class='goodsnum'  style='width:30%;margin-left: 28px;margin-top: 10px;' >数&nbsp;&nbsp;&nbsp;量：<input  name='goodsnum[]' value=<?php echo $v['quantity']?> type='text' placeholder='输入数量' style='margin-left: 16px'></div>
			                        <div class='unit_price' style='width:30%;margin-left: 28px;margin-top: 10px;'><span style='font-size: 10px;'>套餐价：</span><input name='unit_price[]' value=<?php echo $v['unit_price']?> type='text' placeholder='套餐价' style='margin-left: 19px'></div>

			                   </div>
			                   <?php endforeach;?>
		                   </div>
	                   <div style='margin-left:90px;'><a id='addpa' href='javascript:void(0)'>+添加</a></div>
                    </li>
                    <input  name='meal_id_arr' value=<?php echo json_encode($meal_id_arr)?> type='hidden'>
                    <li id="address" class=" clearfix"><label class="label_name"><i>*</i>结束时间：</label> <input id="datetimepicker7" value="<?php echo $packagearr['create_time']?>" name="endtime" type="text" class="add_text" type="text"/></li>
                    <li id="describe" class=" clearfix"><label class="label_name">套餐描述：</label> <textarea id="describe" name="introduce" cols="" rows="" class="textarea"><?php echo $packagearr['introduce']?></textarea>
                    <li class=" clearfix"><label class="label_name"><i>*</i>是否启用：</label>
                        <label><input name="status" <?php if($packagearr['is_delete']==0){echo 'checked';} ?> type="radio" class="ace"  value="0" /><span class="lbl">是</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label><input name="status" <?php if($packagearr['is_delete']==1){echo 'checked';} ?> type="radio" class="ace"  value="1"/><span class="lbl">否</span></label>
                    </li>
                    <li><input type="button" id="btnn" class="btn btn-warning" value="保存"/><input type="reset" value="取消" class="btn btn-warning"/></li>
                </ul>
        </form>
    </div>
    </div>
</body>
</html>
<script src="/assets/js/jquery.validate.js"></script>
<script src="/js/jquery.datetimepicker.full.js"></script>
<script type="text/javascript">
$(function(){
	var m=<?php echo $counts?>;
	var info_s = $('.info-s');
    var logic = function( currentDateTime ){
        if (currentDateTime && currentDateTime.getDay() == 6){
            this.setOptions({
                minTime:'11:00'
            });
        }else
            this.setOptions({
                minTime:'8:00'
            });
    };
    $('#datetimepicker7').datetimepicker({
        onChangeDateTime:logic,
        onShow:logic
    });
    $('#addpa').click(function(){
		$('.info').append("<div class='info-ss info-s-"+m+"'>"+
				        "<select name='selected' class='selected' onchange=chgc("+m+") style='width:163px'>"+
				        "<option value=''>----选择类别----</option>"+
				        <?php foreach($list as $key=>$value): ?>
				            <?php $count = substr_count($value['pth'],',');$str = '&nbsp;';if($count):?>
				                "<option value=<?php echo $value['id']?>><?php echo str_repeat($str,($count)*4).$value['name'];?></option>"+
				            <?php endif?>
				        <?php endforeach;?>
				    	"</select>"+
				    	"<select name='goodsname' class='child' onchange=chgg("+m+") style='width:123px;display:none'>"+
				        "<option value=''>----选择商品----</option>"+
				    	"</select>"+
				    	"<select name='goodsmodel[]' class='childs' onchange=chgm("+m+") style='width:123px;display:none'>"+
				        "<option value='' >----选择型号----</option>"+
				    	"</select>"+
				    	"<select name='goodssku[]' class='childsku' onchange=chgs("+m+") style='width:123px;display:none'>"+
				        "<option value='' >----选择sku----</option>"+
				    	"</select>"+
				    	"<span class='jianshao' style='font-size:22px'> -</span>"+
				    	"<div class='price' style='width:30%;display: none;margin-left: 28px;margin-top: 10px;'>原&nbsp;&nbsp;&nbsp;价：<input  name='price[]' type='text' placeholder='原价' readonly style='margin-left: 16px'></div>"+
				    	"<div class='goodsnum'  style='width:30%;display: none;margin-left: 28px;margin-top: 10px;' >数&nbsp;&nbsp;&nbsp;量：<input  name='goodsnum[]' type='text' placeholder='输入数量' style='margin-left: 16px'></div>"+
				    	"<div class='unit_price' style='width:30%;display: none;margin-left: 28px;margin-top: 10px;'><span style='font-size: 10px;'>套餐价：</span><input name='unit_price[]' type='text' placeholder='套餐价' style='margin-left: 19px'></div>"+
						
						"</div>");
		m++;
	})
	$('.info').on('click','.jianshao',function(){
		$(this).parents('.info-ss').remove();
	})
	$('#btnn').click(function(){
		var len = $('.price').length;
		for(i=0;i<len;i++){
			if($('.price input').eq(1).val()=='' || $('.price input').eq(1).val()==undefined){
				layer.alert('套餐商品必须大于两个')
				return false
			}else{
				$('#commentForm').submit();
				return false
			}
		}  
		
	})
	
})
function chgc(m){
	var url = '/product/addpackage';
	var catid =$('.info-s-'+m+' .selected').val();
	$.post(url,{catid:catid},function(data){
        var parsedJson = jQuery.parseJSON(data);
        $('.info-s-'+m+' .child').find("option").not(":first").remove();
        $.each(parsedJson, function(i, item) {
            $('.info-s-'+m+' .child').append('<option value='+item.id+'>'+item.name+'</option>');

        });
    })
    $('.info-s-'+m+' .child').show();
}
function chgg(m){
    var goodsid = $('.info-s-'+m+' .child').val();
    var url = '/product/addpackage';
    $.post(url,{goodsid:goodsid},function(data){
	    var parsedJson = jQuery.parseJSON(data);
	    $('.info-s-'+m+' .childs').find("option").not(":first").remove();
	    $.each(parsedJson, function(i, item) {
	         $('.info-s-'+m+' .childs').append('<option value='+item.id+'>'+item.model_number+'</option>');
	    });
    });
    $('.info-s-'+m+' .childs').show();
}
function chgm(m){
    var modelid = $('.info-s-'+m+' .childs').val();
    var url = '/product/addpackage';
    $.post(url,{modelid:modelid},function(data){
        //console.log(data)
	    var parsedJson = jQuery.parseJSON(data);
	    $('.info-s-'+m+' .childsku').find("option").not(":first").remove();
	    $.each(parsedJson, function(i, item) {
	         $('.info-s-'+m+' .childsku').append('<option value='+item.id+'>'+item.combination+'</option>');
	    });
    });
    $('.info-s-'+m+' .childsku').show();
}
function chgs(m){
    var skuid = $('.info-s-'+m+' .childsku').val();
    var url = '/product/addpackage';
    $('.info-s-'+m+' .price').show();
    $('.info-s-'+m+' .goodsnum').show();
    $('.info-s-'+m+' .unit_price').show();
    $.post(url,{skuid:skuid},function(data){
    	console.log(data)
    	if(data)
        {
            $('.info-s-'+m+' .price input').val(data);
        }
    });
    
}
</script>
<script>

    $(function() {
// 在键盘按下并释放及提交后验证提交表单
        $("#commentForm").validate({
            rules: {
                selected: {
                    required: true,
                },
                selected2: {
                    required: true,
                },
                goodsname1:{
                    required:true,
                },
                goodsname2:{
                    required:true,
                },
                discount:{
                    required: true,
                    min:0,
                },
                packagename: {
                    required: true,
                    minlength: 2
                },
            },
            messages: {
                selected:{
                    required:"必选",
                },
                selected2:{
                    required:"必选",
                },
                goodsname1:{
                    required:"必选",
                },
                goodsname2:{
                    required:"必选",
                },
                packagename: {
                    required: "请输入商品名称",
                    minlength: "名称大于两个字"
                },
                discount:{
                    required: "商品价格必须输入",
                    min: "价格不能小于0",
                },
            }
        });
    });
</script>


