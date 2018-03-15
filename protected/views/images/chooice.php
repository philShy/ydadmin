<?
$href="";
if ($_REQUEST['act'] == "add") {
	$href = "/images/addadv?1=1";
}elseif ($_REQUEST['act']=="edit"&&!empty($_REQUEST['id'])) {
	$href = "../images/editadv?id={$_REQUEST['id']}";
}
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<script src="../js/jquery-1.9.1.min.js"></script>

<script type="text/javascript" src="../js/jquery-2.1.1.js"></script>
<style type="text/css">
body{
	margin-left:10px;
}
.proLis_input{
	width:200px;
	height:30px;
}
.proLis_input input{
	border:1px solid #333333;
	height:20px;
}

</style>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css"/>
    <link rel="stylesheet" href="../assets/css/ace.min.css" />
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css" />
    <link href="../Widget/icheck/icheck.css" rel="stylesheet" type="text/css" />
   
</head>
<body>
<h4>商品列表</h4>
<div class="proLis_input" style="height: 50px;">
<input type="text" name="search"  style="height: 30px; margin-top: 10px;" placeholder="请输入商品名称" id="searchPro"/>
</div>



	<table class="table table-striped table-bordered table-hover" id="sample-table">
       		<thead id="biaotii">
       				<tr>
       				<th style="width:70px"><label>商品id</label></th>
       				<th>商品标题</th>
       				<th>商品型号</th>
       				</tr>
       		</thead>
       		<tbody id="reqbef" >
       		   <?php foreach ($choice as $key=>$value):?>
				<tr>
				<td><?php echo $value['id']?> </td>
				<td><a href="<?php echo $href?>?1=1&rePId=<?php echo $value['id']?>"><?php echo $value['title'] ;?></a></td>
				<td><?php echo $value['model_number']?></td>
				</tr>
			  <?php endforeach;?>
                </tbody>
                 <tbody id="reqbefs" >
       		   <?php foreach ($choice as $key=>$value):?>
				<tr>
				<td><?php echo $value['id']?> </td>
				<td><a href="<?php echo $href?>?1=1&rePId=<?php echo $value['id']?>"><?php echo $value['title'] ;?></a></td>
				<td><?php echo $value['model_number']?></td>
				</tr>
			  <?php endforeach;?>
                </tbody>
                
                
            </table>

<div id="norequest"></div>

<script type="text/javascript">
	
	$(function(){
      	var bind_name = 'input';
      	//火狐浏览器
      	if(navigator.userAgent.indexOf("Firefox") != -1){
      		var bind_name = 'keyup';
        }
      	//IE浏览器
      	if (navigator.userAgent.indexOf("MSIE") != -1){
        	bind_name = 'propertychange';
      	}	
      $("#searchPro").bind(bind_name, function () {
          $.ajax({
              url:"/images/chooice",
              data: { pro: $("#searchPro").val() },
              dataType:"json",
              type:"post",
              async:false,
              error:function(data){
            		$("#reqbef").css('display','none'); 
                	$("#reqbefs").css('display','block'); 
              },
              success: function (data) {
              	$("#reqbef").css('display','block'); 
            	$("#reqbefs").css('display','none'); 
             	 	$("#norequest").html('');
             	 	$('#reqbef').html('');
             	 	
                    if($("#searchPro").val()==''){
                    	 
                    	$("#reqbef").append("1234"); //返回的data是字符串类型
                   }else{
	                     if(data) { 
		                     
	                    	 $("#biaotii").css('display','none'); 
	     					$.each(data,function(index,term){
	     						$("#reqbef").append("<tr><td>"+term.id+"</td><td><a href='<?php echo $href?>?1=1&rePId="+term.id+"'>"+term.title+"</a></td><td>"+term.model_number+"</td></tr>"); //返回的data是字符串类型
	     					})
	                     }else{
	                    	$("#reqbef").css('display','none'); 
							$("#norequest").html("没有找到相应内容");
	                     }
	                }
              }
          });
      })
	});
	</script>

</body>

</html>