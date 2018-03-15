
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta http-equiv="Cache-Control" content="no-siteapp" />
      <link rel="stylesheet" type="text/css" href="../css/jquery.datetimepicker.css"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="../js/html5.js"></script>
    <script type="text/javascript" src="../js/respond.min.js"></script>
    <script type="text/javascript" src="../js/PIE_IE678.js"></script>
    <![endif]-->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css"/>
    <link href="../assets/css/codemirror.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/ace.min.css" />
    <link rel="stylesheet" href="../Widget/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css"/>
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="../assets/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <link href="../Widget/icheck/icheck.css" rel="stylesheet" type="text/css" />
    <link href="../Widget/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />
 <script type="text/javascript" src="../js/jquery-1.6.4.js"></script>
    <title>修改展示商品</title>
    <style>
    div.box{width:100%;padding:3px;margin:10px;}
div.box>span{color:#FB78AC;font-style:italic;font-size: 15pt;}
div.content{width:100%;margin:5px;padding:3px;}
input[type='text']{width:50px;height:50px;padding:5px 10px;margin:5px;border:1px solid #ffe5e5;}
    </style>
</head>

<body>

<div class=" clearfix">
    <div id="add_brand" class="clearfix">
       <form action="/adver/editadvers" method="post" enctype="multipart/form-data" id="commentsForm">
        <div class="left_add" style="border:1px;width:1500px; margin-left: 150px; margin-top: 100px;">
            <ul class="add_conent" style="margin-top: 0;">
            	<input name="aid" type="hidden" class="add_text" value="<?php echo $result['id']?>">
                <li id="brandname" class=" clearfix">
                <label class="label_name" style="width: 100px"><i>*</i>产品名称1：</label>
			
                
                <select class="form-control" id="big"  name="first_category" style=" float:left;width: 190px; margin-left: 10px;display: none" >
						<option value="">选择分类</option>
      				<?php foreach($sbc as $k=>$v): ?>      
     				 	<option value="<?php echo $v[id]?>"><?php echo $v[name]?></option>
    				<?php endforeach;?>
			</select>
			<select style="display: none" name="small_cId"  id="small">
					<option value="0">请选择小类</option>
					
			</select>
			
			<select  name="pd[]"  id="product" >
					<?php $model= CProduct::searchGoodsmodelbyid($arr1[0]); echo "<option value=".$model[id].">".$model[model_number]."</option>"?> 
				
			</select>
			
			<select  name="sku_id[]"  id="sku" >
					<?php $sku= CProduct::searchskus_bymodelid($arrs1[0]); echo "<option value=".$sku[aid].">".$sku[guige]."</option>"?> 
				
			</select>
			<input type="button" value="修改" id="changev" ></input>
  				</li>
  				
  				
  				
  				
  				
  				
  				
  				
  				
  				
  				
  				
  				
  				
  				
  				   <li id="brandname" class=" clearfix">
                <label class="label_name" style="width: 100px" ><i>*</i>产品名称2：</label>
			
                
                <select class="form-control" id="bigs" name="first_category" style=" float:left;width: 190px; margin-left: 10px;display: none" >
						<option value="">选择分类</option>
      				<?php foreach($sbc as $k=>$v): ?>      
     				 	<option value="<?php echo $v[id]?>"><?php echo $v[name]?></option>
    				<?php endforeach;?>
			</select>
			<select style="display: none" name="small_cId"  id="smalls">
					<option value="0">请选择小类</option>
					
			</select>
			<select  name="pd[]"  id="products" >
					<?php $model= CProduct::searchGoodsmodelbyid($arr1[1]); echo "<option value=".$model[id].">".$model[model_number]."</option>"?> 
				
			</select>
			<select  name="sku_id[]"  id="skus" >
					<?php $sku= CProduct::searchskus_bymodelid($arrs1[1]); echo "<option value=".$sku[aid].">".$sku[guige]."</option>"?> 
				
			</select>
			<input type="button" value="修改" id="changeva" style=""></input>
  				</li>
  				
  				
  				
  				
  				
  				
  				
  				
  				
  				
  				
  				
  				
  				
  				
  				
  				
  				   <li id="brandname" class=" clearfix">
                <label class="label_name" style="width: 100px"><i>*</i>产品名称3：</label>
			
                
                <select class="form-control" id="bigss" name="first_category" style=" float:left;width: 190px; margin-left: 10px;display: none" >
						<option value="">选择分类</option>
      				<?php foreach($sbc as $k=>$v): ?>      
     				 	<option value="<?php echo $v[id]?>"><?php echo $v[name]?></option>
    				<?php endforeach;?>
			</select>
			<select style="display: none" name="small_cId"  id="smallss">
					<option value="0">请选择小类</option>
					
			</select>
			<select  name="pd[]"  id="productss" >
					<?php $model= CProduct::searchGoodsmodelbyid($arr1[2]); echo "<option value=".$model[id].">".$model[model_number]."</option>"?> 
				
			</select>
			<select  name="sku_id[]"  id="skuss" >
					<?php $sku= CProduct::searchskus_bymodelid($arrs1[2]); echo "<option value=".$sku[aid].">".$sku[guige]."</option>"?> 
				
			</select>
				<input type="button" value="修改" id="changeval"></input>
  				</li>
  				<li class=" clearfix">
  				 <label class="label_name" style="width: 100px"><i>*</i>开始时间：</label>
  				 <input type="datetime" value="<?php echo $result['start_time']?>"/>
  				</li>
              <li class=" clearfix">
  				 <label class="label_name" style="width: 100px"><i>*</i>结束时间：</label>
  				 <input type="datetime" value="<?php echo $result['end_time']?>"/>
  				</li>
               
                
                <li><div class="button_brand"><input type="submit" id="btn" class="btn btn-warning" value="保存"/><input type="reset" value="取消" class="btn btn-warning"/></div></li>
            </ul>
        </div>
        </form><!--<input id="uploaderInput" class="uploader__input" style="display: none;" type="file" accept="" multiple="">-->
    </div>
   </div>


			
 <div class="box">
    <span>距离活动结束还剩：</span>
    <div class="content">
     <input type="text" id="day_show">天<input type="text" id="hour_show">时<input type="text" id="minute_show">分<input type="text" id="second_show">秒
    </div>
</div>
   <script type="text/javascript">
 $(function(){ 
    show_time();
}); 

function show_time(){ 
    var time_start = new Date().getTime(); //设定当前时间

    var time_end =  new Date('<?php echo $result['end_time']?>').getTime(); //设定目标时间
    // 计算时间差 
    var time_distance = time_end - time_start; 
    /*判断活动是否结束*/
    if(time_distance<0){

        int_day=0;
        int_hour=0;
        int_minute=0;
        int_second=0;
        
    }else{
    // 天
    var int_day = Math.floor(time_distance/86400000) 
    time_distance -= int_day * 86400000; 
    // 时
    var int_hour = Math.floor(time_distance/3600000) 
    time_distance -= int_hour * 3600000; 
    // 分
    var int_minute = Math.floor(time_distance/60000) 
    time_distance -= int_minute * 60000; 
    // 秒 
    var int_second = Math.floor(time_distance/1000) 
    // 时分秒为单数时、前面加零 
    if(int_day < 10){ 
        int_day = "0" + int_day; 
    } 
    if(int_hour < 10){ 
        int_hour = "0" + int_hour; 
    } 
    if(int_minute < 10){ 
        int_minute = "0" + int_minute; 
    } 
    if(int_second < 10){
        int_second = "0" + int_second; 
    } 
    }

    // 显示时间 
    $("#day_show").val(int_day); 
    $("#hour_show").val(int_hour); 
    $("#minute_show").val(int_minute); 
    $("#second_show").val(int_second); 
    // 设置定时器
    setTimeout("show_time()",1000); 
}
</script>

<script>
 var option="<option value='0'>请选择小类</option>";
 var options="<option value='0'>请选择商品</option>";
$(function(){
	var url="/adver/editadvers"
	$("#big").change(function(){
		$('#small').empty();
		$('#small').append(option); 
		var first_category=$(this).val();
		$.post(url,{first_category:first_category},function(data){
			
			jsonObj = eval('(' + data + ')');
			var small='';
			
			if(data){
				for(i=0;i<jsonObj.length;i++){
					small+="<option value="+jsonObj[i]['id']+">"+jsonObj[i]['name']+"</option>"
				}
				$('#small').show();
				$('#small').append(small) 
			}
			
		})
	})	

	$("#small").change(function(){
		$('#product').empty();
		$('#product').append(options);
		var small_cId=$(this).val();
		$.post(url,{small_cId:small_cId},function(data){
			
			jsonObj = eval('(' + data + ')');
			var product='';
		
			if(data){
				for(i=0;i<jsonObj.length;i++){
					product+="<option value="+jsonObj[i]['aid']+">"+jsonObj[i]['model_number']+"</option>"
				}
			
				$('#product').append(product)
			}
			
		})
	})
	$("#product").change(function(){
		$('#sku').empty();
		$('#sku').append(options);
		var product_id=$(this).val();
		$.post(url,{product_id:product_id},function(data){
			
			jsonObj = eval('(' + data + ')');
			var sku='';
		
			if(data){
				for(i=0;i<jsonObj.length;i++){
					sku+="<option value="+jsonObj[i]['aid']+">"+jsonObj[i]['guige']+"</option>"
				}
			
				$('#sku').append(sku)
			}
			
		})
	})
	
	
	
	
	
	$("#bigs").change(function(){
		$('#smalls').empty();
		$('#smalls').append(option); 
		var first_category=$(this).val();
		$.post(url,{first_category:first_category},function(data){
			
			jsonObj = eval('(' + data + ')');
			var small='';
			
			if(data){
				for(i=0;i<jsonObj.length;i++){
					small+="<option value="+jsonObj[i]['id']+">"+jsonObj[i]['name']+"</option>"
				}
				$('#smalls').show();
				$('#smalls').append(small) 
			}
			
		})
	})	

	$("#smalls").change(function(){
		$('#products').empty();
		$('#products').append(options);
		var small_cId=$(this).val();
		$.post(url,{small_cId:small_cId},function(data){
			
			jsonObj = eval('(' + data + ')');
			var product='';
			
			if(data){
				for(i=0;i<jsonObj.length;i++){
					product+="<option value="+jsonObj[i]['aid']+">"+jsonObj[i]['model_number']+"</option>"
				}
			
				$('#products').append(product)
			}
			
		})
	})
	
	$("#products").change(function(){
		$('#skus').empty();
		$('#skus').append(options);
		var product_id=$(this).val();
		$.post(url,{product_id:product_id},function(data){
			
			jsonObj = eval('(' + data + ')');
			var sku='';
		
			if(data){
				for(i=0;i<jsonObj.length;i++){
					sku+="<option value="+jsonObj[i]['aid']+">"+jsonObj[i]['guige']+"</option>"
				}
			
				$('#skus').append(sku)
			}
			
		})
	})
	
	
	
	
	
	
	
	
	
	$("#bigss").change(function(){
		$('#smallss').empty();
		$('#smallss').append(option); 
		var first_category=$(this).val();
		$.post(url,{first_category:first_category},function(data){
		
			jsonObj = eval('(' + data + ')');
			var small='';
			
			if(data){
				for(i=0;i<jsonObj.length;i++){
					small+="<option value="+jsonObj[i]['id']+">"+jsonObj[i]['name']+"</option>"
				}
				$('#smallss').show();
				$('#smallss').append(small) 
			}
			
		})
	})	

	$("#smallss").change(function(){
		$('#productss').empty();
		$('#productss').append(options);
		var small_cId=$(this).val();
		$.post(url,{small_cId:small_cId},function(data){
		
			jsonObj = eval('(' + data + ')');
			var product='';
			
			if(data){
				for(i=0;i<jsonObj.length;i++){
					product+="<option value="+jsonObj[i]['aid']+">"+jsonObj[i]['model_number']+"</option>"
				}
			
				$('#productss').append(product)
			}
			
		})
	})
	$("#productss").change(function(){
		$('#skuss').empty();
		$('#skuss').append(options);
		var product_id=$(this).val();
		$.post(url,{product_id:product_id},function(data){
			
			jsonObj = eval('(' + data + ')');
			var sku='';
		
			if(data){
				for(i=0;i<jsonObj.length;i++){
					sku+="<option value="+jsonObj[i]['aid']+">"+jsonObj[i]['guige']+"</option>"
				}
			
				$('#skuss').append(sku)
			}
			
		})
	})
	
	
})
</script>
<script type="text/javascript">
$(function(){
  $('#changev').click(function(){
    if($('#big').is(':hidden')){
      $('#big').show();
      
    }
 
  })
  

  $('#changeva').click(function(){
    if($('#bigs').is(':hidden')){
      $('#bigs').show();
      
    }
   
  })

  $('#changeval').click(function(){
    if($('#bigss').is(':hidden')){
      $('#bigss').show();
      
    }
    
  })
})
</script>



</body>
</html>

