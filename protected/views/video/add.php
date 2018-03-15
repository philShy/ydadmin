<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
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
$list = t($catearr);
?>
<style>
    #selectFileBtn{background: #438eb9;border-radius: 3px;color:white ;margin-left: 5px;}
    a{text-decoration: none}
    .btn{margin-left: 10px;display: inline-block;background: #438eb9;border-radius: 2px;width:43px;color:#fff}
    .attachItem{width:180px;background: #ccc;float: left;border-radius: 3px;margin-left: 5px;margin-top: 5px;}
    .left{float:left}
    .right{float:right}
    .right a{display:block;margin-top:3px;width:16px;height:16px;overflow: hidden;text-indent:-9999px; background:url(/images/delete.png); }
    table tr:nth-child(odd){background:#eee;}
    table tr:hover{background:#eee;}
    .smt{background: #ffb752;border:1px solid #ffb752;border-radius: 3px;width:50px;height:30px;color:#fff;cursor: pointer}
	.spans{color:red}
	.spanss{color:green}
</style>
<body>
<h3>添加首页视频</h3>
<form action="/video/add" method="post" enctype="multipart/form-data">
    <table width="70%" cellpadding="5" rules="all" cellspacing="0" bgcolor="#fff" style="border:1px solid #ddd">
        <tr height="30px;">
            <td align="right">商品名称</td>
            <td>
            	<select id="category">
            		<option>--选择类别--</option>
            		<?php foreach($list as $key=>$value): ?>
                            <?php $count = substr_count($value['pth'],',');$str = '&nbsp;';if($count):?>
                                <option <?php if($count==1) echo 'disabled '?> value=<?php echo $value['id']?>><?php echo str_repeat($str,($count)*4).$value['name'];?></option>
                            <?php endif?>
                        <?php endforeach;?>
            	</select>
            	<select id="goods" style="display:none">
            		<option>--选择商品--</option>
            	</select>
            	<select id="model" style="display:none" name="model_id">
            		<option>--选择型号--</option>
            	</select>
            </td>
        </tr>
		<tr>
            <td align="right">添加视频封面</td>
            <td>
                <input type="file" name="video_cover">
            </td>
        </tr>
        <tr>
            <td align="right">添加商品视频</td>
            <td>
                <input type="file" name="video">
            </td>
        </tr>
        <tr>
            <td align="right">设置顺序</td>
            <td>
                <input type="number" min="1" name="sort">
            </td>
        </tr>
        <tr>
            <td align="right">播放次数</td>
            <td>
                <input type="text" name="plays">
            </td>
        </tr>
        <tr>
            <td colspan="2"><input class="smt" type="button"  value="提交"/></td>
        </tr>
    </table>
</form>
<script src="/js/jquery-1.9.1.min.js"></script>
<script src="/assets/layer/layer.js" type="text/javascript" ></script>
<script src="/assets/laydate/laydate.js" type="text/javascript"></script>
<script type="text/javascript">
$("input[name='sort']").blur(function(){
	$_this = $(this);
	var sort = $_this.val();
	if(sort == '')
	{
		$_this.siblings().remove();
		if($('.spansss').length == 0)
		{
			$_this.parent().append("<span class='spansss' style='color:red'>排序不能为空</span>");
			return false;
		}
	}
	var url = "/video/add";
	$.post(url,{sort:sort,mark:1},function(data){
		if(data == 1){
			$_this.siblings().remove();
			if($('.spans').length == 0)
			{
				$_this.parent().append("<span class='spans'>排序不能重复</span>");

			}
		}else{
			$_this.siblings().remove();
			if($('.spanss').length == 0)
			{
				$_this.parent().append("<span class='spanss'>排序可以</span>")
			}
		}	
	})
	 
});
$('.smt').click(function(){
	var url = "/video/add";
	var sort = $("input[name='sort']").val();
	if(sort == '')
	{
		$("input[name='sort']").siblings().remove();
		if($('.spansss').length == 0)
		{
			$("input[name='sort']").parent().append("<span class='spansss' style='color:red'>排序不能为空</span>");
			return false;
		}
	}
	$.post(url,{sort:sort,mark:1},function(data){
		if(data == 1){
			return false;
		}else{
			$('form').submit();
		}	
	})
})
$(function(){
	$('#category').change(function(){
		var catid = $(this).val();
        var url = '/video/add';
       
        $.post(url,{catid:catid},function(data){
            var parsedJson = jQuery.parseJSON(data);
            $("#goods").find("option").not(":first").remove();
            $.each(parsedJson, function(i, item) {
                $('#goods').append('<option value='+item.id+'>'+item.name+'</option>');

            });
        }) 
        $('#goods').show();
	})

	$('#goods').change(function(){
		
		var goodsid = $(this).val();
        var url = '/video/add';
        $.post(url,{goodsid:goodsid},function(data){
            var parsedJson = jQuery.parseJSON(data);
            $("#model").find("option").not(":first").remove();
            $.each(parsedJson, function(i, item) {
                $('#model').append('<option value='+item.id+'>'+item.model_number+'</option>');

            });
        }) 
        $('#model').show();
	})

})

</script>
</body>
</html>