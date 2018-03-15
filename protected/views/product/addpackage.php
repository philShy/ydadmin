<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>添加套餐</title>
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

</head>
<style>
    .error{color: red}
    i{color:red}
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
        <form action="/product/addpackage" method="post" enctype="multipart/form-data" id="commentForm">
                <ul class="add_conent" style="margin-top: 0;">
                    <li id="sort" class=" clearfix"><label class="label_name"><i>*</i>套餐名称：</label> <input name="packagename" type="text" class="add_text" /></li>
                    <li id="brandname1" class=" clearfix">
                    <div style='margin-left:5px;' ><i>*</i>选择商品：</div>
	                    <div class='info' style='margin:-25px 0 0 84px;'>
	                    	
		                    <div class='info-ss info-s-0'>
		                        <select name='selected' class='selected' onchange='chgc(0)' style='width:163px'>
		                            <option value=''>----选择类别----</option>
		                            <?php foreach($list as $key=>$value): ?>
		                                <?php $count = substr_count($value['pth'],',');$str = '&nbsp;';if($count):?>
		                                    <option value=<?php echo $value['id']?>><?php echo str_repeat($str,($count)*4).$value['name'];?></option>
		                                <?php endif?>
		                            <?php endforeach;?>
		                        </select>
		                        <select name='goodsname' class='child' onchange='chgg(0)' style='width:123px;display:none'>
		                            <option value=''>----选择商品----</option>
		                        </select>
		                        <select name='goodsmodel[]' class='childs' onchange='chgm(0)' style='width:123px;display:none'>
		                            <option value='' >----选择型号----</option>
		                        </select>
		                        <select name='goodssku[]' class='childsku' onchange='chgs(0)' style='width:123px;display:none'>
		                            <option value='' >----选择sku----</option>
		                        </select>
		                        <div class='price' style='width:30%;display: none;margin-left: 28px;margin-top: 10px;'>原&nbsp;&nbsp;&nbsp;价：<input required='required' name='price[]' type='text' placeholder='原价' readonly style='margin-left: 16px'></div>
		                        <div class='goodsnum'  style='width:30%;display: none;margin-left: 28px;margin-top: 10px;' >数&nbsp;&nbsp;&nbsp;量：<input placeholder='0' name='goodsnum[]' type='text' placeholder='输入数量' style='margin-left: 16px'></div>
		                        <div class='unit_price' style='width:30%;display: none;margin-left: 28px;margin-top: 10px;'><span style='font-size: 10px;'>套餐价：</span><input placeholder='0' name='unit_price[]' type='text' placeholder='套餐价' style='margin-left: 19px'></div>
		                   </div>
		                   
	                   </div>
	                   <div style='margin-left:90px;'><a id='addpa' href='javascript:void(0)'>+添加</a></div>
                    </li>
					
                    <li id="address" class=" clearfix"><label class="label_name"><i></i>结束时间：</label> <input id="datetimepicker7" name="endtime" type="text" class="add_text" type="text"/></li>
                    <li id="describe" class=" clearfix"><label class="label_name">套餐描述：</label> <textarea id="describe" name="introduce" cols="" rows="" class="textarea"></textarea>
                    <li class=" clearfix"><label class="label_name"><i></i>是否启用：</label>
                        <label><input name="status" type="radio" class="ace" checked="checked" value="0" /><span class="lbl">是</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label><input name="status" type="radio" class="ace" value="1" /><span class="lbl">否</span></label>
                    </li>
                    <li><div class=""><input type="button" id="btnn" class="btn btn-warning" value="保存"/><input type="reset" value="取消" class="btn btn-warning"/></div></li>
                </ul>
        </form>
    </div>
</div>
</body>
</html>
<script src="/assets/js/jquery.validate.js"></script>
<script src="/js/jquery.datetimepicker.full.js"></script>
<script src="/assets/js/jquery.validate.js"></script>
<script type="text/javascript">
$(function(){
	var m=1;
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
				    	"<div class='price' style='width:30%;display: none;margin-left: 28px;margin-top: 10px;'>原&nbsp;&nbsp;&nbsp;价：<input required='required' name='price[]' type='text' placeholder='原价' readonly style='margin-left: 16px'></div>"+
				    	"<div class='goodsnum'  style='width:30%;display: none;margin-left: 28px;margin-top: 10px;' >数&nbsp;&nbsp;&nbsp;量：<input placeholder='0' name='goodsnum[]' type='text' placeholder='输入数量' style='margin-left: 16px'></div>"+
				    	"<div class='unit_price' style='width:30%;display: none;margin-left: 28px;margin-top: 10px;'><span style='font-size: 10px;'>套餐价：</span><input placeholder='0' name='unit_price[]' type='text' placeholder='套餐价' style='margin-left: 19px'></div>"+
						
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
        $("#commentForm").validate({
            rules: {
            	'packagename':'required',
            	/* 'unit_price[]':'required',
            	'goodsnum[]':'required',  */
            },
            messages: {
            	'packagename':'必填',
            	/* 'unit_price[]':'必填',
            	'goodsnum[]':'必填',  */
            }
        });
    });
</script>


