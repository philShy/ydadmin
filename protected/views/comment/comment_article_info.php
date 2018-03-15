<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css"/>
    <link href="/assets/css/codemirror.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
    <![endif]-->
    <script src="/assets/js/jquery.min.js"></script>
    <!-- <![endif]-->
    <!--[if IE]>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <![endif]-->
    <!--[if !IE]> -->
    <script type="text/javascript">
        window.jQuery || document.write("<script src='/assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
    </script>
    <!-- <![endif]-->
    <!--[if IE]>
    <script type="text/javascript">
        window.jQuery || document.write("<script src='/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
    </script>
    <![endif]-->
    <script type="text/javascript">
        if("ontouchend" in document) document.write("<script src='/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <!-- page specific plugin scripts -->
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="/js/H-ui.js"></script>
    <script type="text/javascript" src="/js/H-ui.admin.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <script src="/assets/laydate/laydate.js" type="text/javascript"></script>
    <title>用户列表</title>
    <style>
    	img{cursor:pointer;transition:all 0.6s;}  
        .floors_portrait:hover{transform: scale(2.0);}
        .floors_info_portrait:hover{transform: scale(2.5);}  
        .del{position:relative;top:3px;display:inline-block;width:19px;height:19px;background:url('/images/del.png') no-repeat 0px 0px;}
        /*.shenhe{display:inline-block;width:19px;height:19px;background:url('/images/shenhe.png') no-repeat 0px 0px;}*/
        .yes{position:relative;top:4px;display:inline-block;width:19px;height:19px;background:url('/images/icon_right_s.png') no-repeat 0px 0px;}
        .no{position:relative;top:4px;display:inline-block;width:19px;height:19px;background:url('/images/icon_error_s.png') no-repeat 0px 0px;}
        .zanwu{position:relative;top:12px;left:5px;display:inline-block;width:40px;height:40px;background:url('/images/cry.png') no-repeat 0px 0px;}
    </style>
</head>
<body>
<div class="page-content clearfix">
	<div class='floors' style='margin:30px auto;width:100%'>
		<div class='info'style="text-align:center; width:70px; border:1px solid #eee ;padding:5px; float:left">
			<div class='portrait'><img class='floors_portrait' style="width:50px;" src='<?php echo $floors_info['portrait']?>'></div>
			<div class='name'><?php echo $floors_info['name']?></div>
		</div>
		<div class='comment' style='margin-left:30px;float:left;width:85%;'><b><?php echo $floors_info['comment']?></b></div>
	</div>
	<table width=92% style="float:left;margin-top:50px;margin-left:50px; ">
		<?php foreach($comment_info_all as $val):?>
		<?php if($val['is_delete'] == '0'):?>
		<tr>
			<td valign="top" align='left' width=25%>
			<?php $info = CComment::search_user_info_byuserid($val['user_id']);?>
			<div style="width:25px;padding:1px;display:inline-block;border:1px solid #ddd">
			<img class='floors_info_portrait' style='width:20px;' src='<?php echo $info['portrait']?>'>
			</div>
			
			<?php echo $info['name']?>:
			<?php if($val['to_user_id']):?>
			<?php $to_info = CComment::search_user_info_byuserid($val['to_user_id']);?>
			回复&nbsp;<?php echo $to_info['name']?>:
			<?php endif;?>
			</td>
			
			<td align='left' width=80%><?php echo $val['comment']?></td>
			<td valign="bottom" align='center' style='font-size:10px;'>
			<div style="width:140px;">
			<?php echo $val['create_time']?>
			</div>
			</td>
			<td valign="bottom" class='ssss' style='text-align:center'>
			<div style="width:50px;">
			<?php if($val['state'] == '0'):?>
				<a class='yes' title='通过' floor_id='<?php echo $val['id']?>' href='javascript:;'></a>&nbsp;
			<?php else:?>
				<a class='no' title='不通过' floor_id='<?php echo $val['id']?>' href='javascript:;'></a>&nbsp;
			<?php endif;?>
				<a class='del' title='删除' floor_id='<?php echo $val['id']?>' href='javascript:;'></a>
			</div>
			</td>
		</tr>
		
		<tr>
			<td colspan=4 valign="middle" width=100% height=20px>
			<div style="display:inline-block;width:100%;border:1px dotted #ddd;">
			</div>
			</td>
		</tr>
		<?php endif;?>
		<?php endforeach;?>
	</table>
</div>

</body>
</html>
<script>
    $(function(){
        var num = $('tr').length;
        if(num == 0)
        {
			$('table').append("<tr><td colspan=4 align='center'>暂无讨论内容<i class='zanwu'></i></td></tr>")
        }
        var url = '/comment/comment_article_info'; 
        //审核
		$('.ssss').on('click','.yes',function(){
			$_this = $(this);
			var floor_id = $_this.attr('floor_id');
			$.post(url,{state:1,floor_id:floor_id},function(data){
				if(data == 1)
				{
					$_this.removeClass("yes")
					$_this.addClass("no")
					$_this.attr('title','未通过')
				}
			})
		})
		$('.ssss').on('click','.no',function(){
			$_this = $(this);
			var floor_id = $_this.attr('floor_id');
			$.post(url,{state:'0',floor_id:floor_id},function(data){
				if(data == 1)
				{
					$_this.removeClass("no")
					$_this.addClass("yes")
					$_this.attr('title','通过')
				}
			}) 
		})
		
		//删除
		$('.ssss').on('click','.del',function(){
			$_this = $(this);
			var floor_id = $_this.attr('floor_id');
			layer.confirm('确认要删除吗？',function(index){
				$.post(url,{is_delete:1,floor_id:floor_id},function(data){
					if(data == 1)
					{
						$_this.parents('tr').next('tr').remove();
						$_this.parents('tr').remove();
						layer.msg('已删除!',{icon:1,time:1000}); 
						var num = $('table tr').length;
						if(num == 0)
				        {
							$('table').append("<tr><td colspan=4 align='center'>暂无讨论内容<i class='zanwu'></i></td></tr>")
				        }
						
					}
				}) 
	        });
		})
	
    })
</script>



















