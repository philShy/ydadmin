<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="./styles/global.css"  rel="stylesheet"  type="text/css" media="all" />
    <script type="text/javascript" src="./scripts/jquery-1.6.4.js"></script>
    <title>Insert title here</title>
</head>

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
<h3>编辑首页视频</h3>
<form action="/video/edit" method="post" enctype="multipart/form-data" id="iform">
<input name='video_id' type='hidden' value='<?php echo $video_arr['id']?>'>
    <table width="70%" cellpadding="5" rules="all" cellspacing="0" bgcolor="#fff" style="border:1px solid #ddd">
        <tr height="30px;">
            <td align="right">商品名称</td>
            <td>
            	<?php echo $goods_model_name?>
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
                <input type="text" name="sort" value="<?php echo $video_arr['sort']?>">
            </td>
        </tr>
        <tr>
            <td align="right">播放次数</td>
            <td>
                <input type="text" name="plays" value="<?php echo $video_arr['plays']?>">
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
	var video_id = $("input[name='video_id']").val();
	var url = "/video/edit";
	$.post(url,{sort:sort,id:video_id},function(data){
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
	var url = "/video/edit";
	var sort = $("input[name='sort']").val();
	var video_id = $("input[name='video_id']").val();
	$.post(url,{sort:sort,id:video_id},function(data){
		if(data == 1){
			return false;
		}else{
			$('#iform').submit();
		}	
	})
	
})
</script>
</body>
</html>




















