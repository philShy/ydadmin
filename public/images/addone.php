<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/js/html5.js"></script>
    <script type="text/javascript" src="/js/respond.min.js"></script>
    <script type="text/javascript" src="/js/PIE_IE678.js"></script>
    <![endif]-->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css"/>
    <link href="/assets/css/codemirror.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/Widget/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <link href="/Widget/icheck/icheck.css" rel="stylesheet" type="text/css" />
    <link href="/Widget/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />

    <title>添加商品型号</title>
</head>
<style>

	a {color:#0072D2; text-decoration:none !important;}
	.addrv{margin-left:10px;}
	#attr{float:left;width:65.5%;display:none;margin-top:10px;}
	.attr_all{width:100%;border:1px solid #ccc;border-top:none;}
	.attr_left{float:left;width:15%;}
	.attr_right{float:right;width:85%;border-left:1px solid #ccc;}
	.attr_right span {display:inline-block;margin-left:10px}
    .error{color:red}
    #add_picture .page_right_style{left:0 !important;}
    #down{width:60px;height:26px;text-decoration: none;text-align:center;
        line-height:26px;border-radius:3px;  background: #428bca;color:white;display:
        inline-block;margin-left:0px;margin-top:6px}
    .selectFileBtn{width:60px;height:26px;text-decoration: none;text-align:center;
        line-height:26px;border-radius:3px;  background: #428bca;color:white;display:
        inline-block;margin-left:0px;margin-top:6px}
    #butn{width:60px;height:26px;text-decoration: none;text-align:center;
        line-height:26px;border-radius:3px;  background: #428bca;color:white;display:
        inline-block;margin-left:-2px;margin-top:6px}
    .btn1{width:60px;height:26px;text-decoration: none;text-align:center;
        line-height:26px;border-radius:3px;  background: #428bca;color:white;display:
        inline-block;margin-left:-2px;margin-top:6px}
    .btn66{width:60px;height:26px;text-decoration: none;text-align:center;
        line-height:26px;border-radius:3px;  background: #428bca;color:white;display:
        inline-block;margin-left:-2px;margin-top:6px}
    .attachItem{width:15%;height:26px;background: #eee;float:left;border-radius: 3px;margin-left: 5px;margin-top: 5px}
    .attachItem .right a {display:block;width:16px;height:16px;overflow: hidden;text-indent:-9999px;background:url(/images/delete.png);  }

    .downItem{width:15%;height:26px;background: #eee;float:left;border-radius: 3px;margin-left: 5px;margin-top: 5px}
    .downItem .right a {display:block;width:16px;height:16px;overflow: hidden;text-indent:-9999px;background:url(/images/delete.png);  }

    .left{width:80%;height:24px;line-height:25px;float:left}
    .right{float:left;margin-top: 5px;}
    .model{border:1px solid #ddd;margin-top:5px;margin-left: 110px;float:left;}
    #models .modelchild{float:left;margin: 10px;}
    .allgoods{margin-left: 30px;width:100%;margin-bottom: 10px}
    .goodslist{width:256px;display: inline-block}
    .specifications_input{margin-left: 3px; margin-bottom: 5px;}
    .specifications{margin-top:20px;}
    .is_publish{margin-top:3px;display:inline-block; width:18px; height:18px;
        background-color:#fff; border-radius:9px;border:1px solid #ccc}
    .is_preferential{margin-top:3px;display:inline-block; width:18px; height:18px;
        background-color:#fff; border-radius:9px;border:1px solid #ccc}
    .is_storage{margin-top:3px;display:inline-block; width:18px; height:18px;
        background-color:#fff; border-radius:9px;border:1px solid #ccc}
    .currntyes_publish{display:inline-block;margin:2px;width:12px; height:12px; background-color:#2e87af; border-radius:6px}
    .currntno_publish{display:inline-block;margin:2px;width:12px; height:12px; background-color:#fff; border-radius:6px}
    .currntyes_preferential{display:inline-block;margin:2px;width:12px; height:12px; background-color:#2e87af; border-radius:6px}
    .currntno_preferential{display:inline-block;margin:2px;width:12px; height:12px; background-color:#fff; border-radius:6px}
    .currntyes_storage{display:inline-block;margin:2px;width:12px; height:12px; background-color:#2e87af; border-radius:6px}
    .currntno_storage{display:inline-block;margin:2px;width:12px; height:12px; background-color:#fff; border-radius:6px}
    .ll{margin-left: 5px;}
    /* .gui{display:inline-block;margin-left:20px;text-align:left} */
    #stock{width:100%;height:;}
    .table-sku-stock{border:1px solid #eee;text-align:center}
    .table-sku-stock tr  td{ border:1px #eee solid;height:40px}
    .table-sku-stock input{width:100px}
    .table-sku-stock th{text-align:center}
    .gui{
    	display: inline-block;
	    vertical-align: middle;
	    /* background: #DBDBDB; */
	    border: 1px solid #E3E3E3;
	    border-radius: 3px;
	    padding: 5px;
	    margin-left:10px;
	    cursor: pointer;
	    font-size: 12px;
    }
   .selected {
	    background: #1C8FEF;
	    color: #ffffff;
	}
    .sign{color:red}
    * { padding: 0; margin: 0; }  
        .demo { padding: 10px; }  
        .demo table { border-collapse: collapse; }  
        .demo table tr td { border: 1px solid #ccc; padding: 4px; }  
</style>
<body>
<div class="clearfix" id="add_picture">
    <div class="page_right_style" style="width:100%">
        <div class="type_title">添加商品</div>
        <form action="/product/addone" method="post" class="form form-horizontal" id="form-article-add" enctype="multipart/form-data">
            <input type='hidden' id="model_sku" name='model_sku_json' value="">
            <input type='hidden' id="model_attr" name='model_attr_json' value="">
            <input type="hidden" value="<?php echo $goods_id?>" name="goods_id">
            <input type="hidden" value="<?php echo $cate_id?>" name="cate_id">
            <div class="clearfix cl" id="models">
                <div class="model" style="display:;width:90%">
                    <div class="modelchild" style="width:1300px;">
                        <span style="margin-right: 6px;">标&nbsp;&nbsp;&nbsp;&nbsp;题：</span><input type="text" value="" name="title" style="width:60%">
                    <span class="sign">*</span>
                    </div>
                    <div class="modelchild" style="width:1300px;">
                        <span style="font-size: 10px !important;">包装清单：</span><input type="text" value="" name="goods_list" style="width:60%">
                    </div>
                    <div class="modelchild" style="width:1300px;">
                        <span style="font-size: 10px !important;">商品类型：</span>
                  
                        <select id="choose_type" style="margin-left:6px;" name='type_id'>
                        <option value='0'>--选择类型--</option>
                            <?php foreach($type_arr as $key=>$value): ?>
                                <option value=<?php echo $value['id']?>><?php echo $value['type'];?></option>
                            <?php endforeach;?>
                        </select>
               
                        <div id="type" style="display:none">
                        
                        </div>
                        <div id="stock" style="display:">
	                         <dl class="control-group js-spec-table" name="skuTable" style="display: ;">
							
								<dd>
									<div class="controls">
										<div class="js-goods-stock control-group" style="font-size: 14px; margin-top: 10px;">
											<div id="stock-region" class="sku-group"> 
												<table class="table-sku-stock" width="70%" cellpadding="4" cellspacing="0" border="0" style="border: 1; ">
													<thead></thead>
													<tbody></tbody>
													<tfoot></tfoot>
												</table>
											</div>
										</div>
									</div>
								</dd>
							</dl>
                        </div>
                       <div id='attr' >
                       		
                       </div>
                    </div>
                    
                    <div class="modelchild" style="width:300px;">
                        <span style="margin-right: 6px;">型&nbsp;&nbsp;&nbsp;&nbsp;号：</span><input id="model_number" type="text" value="" name="model_number" style="width: 100px">
                    <span class="sign">*</span>
                    </div>

                    <div class="modelchild" style="width:300px;">
                        <span style="margin-right: 6px;">库&nbsp;&nbsp;&nbsp;&nbsp;存：</span><input type="number" value="" name="stock" style="width: 100px">
                    <span class="sign">*</span>
                    </div>

                    <div class="modelchild" style="width:300px;">
                        <span style="margin-right: 6px;">原&nbsp;&nbsp;&nbsp;&nbsp;价：</span><input id="price" type="number" value="" name="price" style="width: 100px">
                    <span class="sign">*</span>
                    </div>
                    <div class="modelchild" style="width:300px;">
                        <span style="margin-right: 6px;">优&nbsp;&nbsp;&nbsp;&nbsp;惠：</span><input type="text" value="" name="preferential_price" style="width: 100px">
                    </div>
                    <div class="modelchild" style="width:300px;">
                        <span style="margin-right: 6px;">重&nbsp;&nbsp;&nbsp;&nbsp;量：</span><input type="text" value="" name="weights" style="width: 100px">
                    </div>
                    <div class="modelchild" style="width:300px;">
                        <span style="margin-right: 6px;">尺&nbsp;&nbsp;&nbsp;&nbsp;寸：</span><input type="text" value="" name="sizes" style="width: 100px">
                    </div>
                    <div class="modelchild" style="width:300px;">
                        <span style="margin-right: 6px;">颜&nbsp;&nbsp;&nbsp;&nbsp;色：</span><input type="text" value="" name="colors" style="width: 100px">
                    </div>
                    <div class="modelchild" style="width:25%; position: relative">
                         <span style="margin-right: 10px;font-size: 10px !important;">商&nbsp;品&nbsp;ID：&nbsp;<input id="assoc" type="text" placeholder="关联商品ID" name="associated" style="width: 100px">
                        <select id="choose" multiple="multiple" style="display: none;width: 100px;height:300px;position: absolute;left:63px;top:28px;z-index: 9999">
                            <?php foreach($modelarr as $key=>$value): ?>
                                <option value=<?php echo $value['id']?>><?php echo $value['model_number'];?></option>
                            <?php endforeach;?>
                        </select>
                             <!--<input type="button" value="确定" onclick="fun()" />-->
                        <a href="javascript:void (0)" id="associated" style="background: #ddd;">请选择</a>
                        <a href="javascript:void (0)" id="sure" style="background: #ddd;display: none;">确定</a>
                        <span style="color:red">ID用英文,隔开</span>
                    </div>
                    <div class="modelchild" style="width:80%; position: relative">
                        售后服务：
                        <select name="after_sales">
                            <option value="0">七天无理由退换</option>
                            <option value="1">七天可换</option>
                            <option value="2">不能退换</option>
                        </select>
                    </div>
                    
                    <div class="modelchild" style="width:300px;margin-left: -20px;">
                        <label class="form-label col-2">是否上架：</label>
                        <div class="formControls col-2 skin-minimal">
                            <div class="check-box" style=" margin-top:5px;margin-left:-10px">
                                <label><input value='0' name='is_publish' checked='checked' type='radio' class='ace is_publish' /><span class='lbl'>是</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label><input value='1' name='is_publish' type='radio' class='ace is_publish'/><span class='lbl'>否</span></label>
                            </div>
                        </div>
                    </div>
                    <div class='modelchild' style='width:300px;margin-left: -20px;'>
                        <label class='form-label col-2'>是否优惠：</label>
                        <div class='formControls col-2 skin-minimal'>
                            <div class='check-box' style='margin-top:5px;margin-left:-10px'>
                                <label><input value='0' name='is_preferential' checked='checked' type='radio' class='ace is_publish' /><span class='lbl'>是</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label><input value='1' name='is_preferential' type='radio' class='ace is_publish'/><span class='lbl'>否</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="modelchild" style="width:300px;margin-left: -20px;">
                        <label class="form-label col-2">入库方式：</label>
                        <div class="formControls col-2 skin-minimal">
                            <div class="check-box" style=" margin-top:5px;margin-left:-10px">
                                <label><input name="in_storage" type="radio" class="ace" checked="checked" value="0" /><span class="lbl">正常</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label><input name="in_storage" type="radio" class="ace" value="1" /><span class="lbl">缺货</span></label>&nbsp;&nbsp;&nbsp;
                                <label><input name="in_storage" type="radio" class="ace" value="2" /><span class="lbl">待定</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="modelchild" style="width:80%;float: left" >
                        上&nbsp;&nbsp;&nbsp;传：<a href="javascript:void(0)" class="selectFileBtn" style="margin-left: 10px">图片上传</a>
                        <div class="uploader-list-container" style=";display: none;height:80px;width:100%;margin-left:60px;">
                            <div class="attachList clear"></div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div style="width:100px;margin-left:600px">
                <input id="bton" type="button" value="提&nbsp;&nbsp;&nbsp;&nbsp;交" class="btn btn-primary radius" style="width:100px;">
            </div>
        </form>
    </div>
</div>
</div>
<script src="/js/jquery-1.9.1.min.js"></script>
<script src="/assets/layer/layer.js" type="text/javascript" ></script>
<script src="/assets/laydate/laydate.js" type="text/javascript"></script>
<script type="text/javascript" src="/Widget/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="/Widget/ueditor/1.4.3/ueditor.all.min.js"> </script>
<script type="text/javascript" src="/Widget/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<script src="/assets/js/jquery.validate.js"></script>
<script src="/js/jquery.datetimepicker.full.js"></script>
<script>

$(function(){
	var model_sku_json='';
	$('#choose_type').change(function(){
		$('#type').show();
		var url = '/product/addone';
		var type_id = $(this).val();
		
		$.post(url,{type_id:type_id,ss:1},function(data){
			var parsedJson = jQuery.parseJSON(data).property;
			var parsedJson_attr = jQuery.parseJSON(data).attr;
			var spec_length = parsedJson.length;
			var attr_length = parsedJson_attr.length;
			var html ='';
			var attr_html = '';
			if(parsedJson){
				html += '<div class="oaddr" style="display:inline-block">'
				for(i=0;i<spec_length;i++)
				{
					var curr_property = parsedJson[i];
					
					html += '<div style="width:800px;" ddds='+parsedJson[i]['id']+' class="js-spec-item goods-sku-block-'+parsedJson[i]['id']+'">';
					html += '<div class="property-name" style="width:100px;display:inline-block;margin-top:10px;">'+parsedJson[i]['name']+'</div>';
					html += '<div class="all_att" style="display:inline">'
					for(j=0;j<curr_property.property.length;j++)
					{
						var curr_property_value = curr_property.property[j];
						html += '<span class=gui ' 
						html += ' this-property="' +curr_property.name+ '"';
						html += ' this-property-id="' + curr_property_value.goods_property_id + '"';
						html += ' this-property-name="'+curr_property_value.name_value+'"';
						html += ' this-property-name-id="' + curr_property_value.id +'">';  
						html += curr_property_value.name_value+"</span>";
						
					} 
					html += '</div>';
					html += '<a class="addrv" href="javascript:void(0)">添加规格值</a>';
					html += '</div>';
				}
				html += '</div>'
				html += '<br/><a class="addr" href="javascript:void(0)">添加规格</a>';
		       $('#type').html(html); 
			}
			
			if(parsedJson_attr)
			{
				$('#attr').show();
				attr_html = '<div style="float:left;border:1px solid #ccc;width:100%">商品属性</div>';
				for(m=0;m<attr_length;m++)
				{
					var attr_property = parsedJson_attr[m];
					attr_html += '<div class="attr_all" style="float:left">';
					attr_html += '<div class="attr_left"><span>'+attr_property.attr+'</span></div>';
					attr_html += '<div class="attr_right">';
					for(n=0;n<attr_property.attr_val_arr.length;n++)
					{
						var attr_value = attr_property.attr_val_arr[n];
						attr_html += '<span><input type="checkbox" attr_id='+attr_property.id+' attr_name='+attr_property.attr+' attr_val='+attr_value.attr_val+' value='+attr_value.id+' />'+attr_value.attr_val+'</span>'
						
					}  
					attr_html += '</div>'; 
					attr_html += '</div>'; 
				}
				
				$('#attr').html(attr_html); 
			}
	       
		})
		$('#type').on('click','.addrv',function(){
				var $_parents =  $(this).parents('.js-spec-item').find('.all_att');
				var olast = $(this).parents('.js-spec-item');
				var last_property = olast.find('.property-name').text();
				var last_property_id = olast.attr('ddds');
				var len = $_parents.find('span').length;
				var url = '/product/addone'
				layer.open({
					  type: 1,
					  title: '填写规格值',
					  skin: 'layui-layer-rim', //加上边框
					  area: ['300px', '220px'], //宽高
					  btn:['确定','取消'],
					  content: '<input class="dds" style="margin:40px 64px;">',
					  yes:function(index)
					  {
						  var val = $('.dds').val();
						  $.post(url,{property_id:last_property_id,name_value:val,addrv:1},function(data){
								if(data)
								{
									$_parents.append('<span class="gui" this-property="'+last_property+'" this-property-id="'+last_property_id +'" this-property-name="'+val+'" this-property-name-id="'+data+'">'+val+'</span>');
								}
						  })  
						  layer.close(index);
					  } 
						  
					});
			})
		$('#type').on('click','.addr',function(){
				var url = '/product/addone';
				layer.open({
						type: 1,
						title: '填写规格',
						skin: 'layui-layer-rim', //加上边框
						area: ['300px', '220px'], //宽高
						btn:['确定','取消'],
						content: '<input class="p_name" style="margin:40px 64px;">',
						yes:function(index)
						{
							var p_name = $('.p_name').val();
							$.post(url,{type_id:type_id,property:p_name,addr:1},function(data){
							if(data)
							{
								$('.oaddr').append('<div style="width:800px;" ddds='+data+' class="js-spec-item goods-sku-block-'+data+'">'+
										'<div class="property-name" style="width:100px;display:inline-block;margin-top:10px;">'+p_name+'</div>'+
										'<div class="all_att" style="display:inline">'+	
										'</div>'+
										'<a class="addrv" href="javascript:void(0)">添加规格值</a>'+
										'</div>'
										)	
									}
							  })  
							  layer.close(index);
						  } 	  
					});
			})
	})
	
	var attr_arr = new Array();
	var arra = new Array();
	$('#attr').on('click','.attr_all input',function(){
		var xid = $(this).attr('attr_id');
        var xname = $(this).attr('attr_name');  
        var yid = $(this).val();
        var yname = $(this).attr('attr_val');
        if($(this).is(':checked') == false)
        {
        	for(var i in attr_arr){
				if(attr_arr[i].id==xid){
					for(var j in attr_arr[i].value){
						if(attr_arr[i].value[j].id==yid){
							if(attr_arr[i].value.length<2){
								attr_arr.splice(i,1);
							}else{
								attr_arr[i].value.splice(j,1);
							}
							
						}
					}
				}
			}
        }else{
        	if(!attr_arr[0]){
        		attr_arr.push({id:xid,name:xname,value:[{sid:xid,id:yid,name:yname}]});
			}else{
		        for(var i in attr_arr){
					if(attr_arr[i].id==xid){
						attr_arr[i].value.push({sid:xid,id:yid,name:yname}); break;
					}
					if(i==(attr_arr.length-1)){
						attr_arr.push({id:xid,name:xname,value:[{sid:xid,id:yid,name:yname}]});break;
					} 	 
				}
			}
        }
        createAttrData(attr_arr)
        function createAttrData($specArray){
        	model_attr_json = JSON.stringify($specArray)
        	var $length=$specArray.length;
        	$sku_array=new Array();
        	if($length>0){
        		var $spec_value_obj=$specArray[0]["value"];
        		$.each($spec_value_obj,function(i,v){
        			var $spec_id = v.sid;
        			var $spec_value_id=v.id;
        			var $spec_value=v.name;
        			var $sku_obj=new Object();
        			$sku_obj.id=$spec_id+":"+$spec_value_id;
        			$sku_obj.name=$spec_value;
        			$sku_array.push($sku_obj);
        		});
        		
        	}
        	for($i=1;$i<$length;$i++){
        		$spec_val_obj=$specArray[$i]["value"];
        		$length_val=$spec_val_obj.length;
        
        		$sku_copy_array=new Array();
        		$.each($sku_array,function(i,v){
        			$old_id=v.id;
        			$old_name=v.name;
        			for($y=0;$y<$length_val;$y++){
        				var $spec_id=$spec_val_obj[$y].sid;
        				var $id=$spec_val_obj[$y].id;
        				var $name=$spec_val_obj[$y].name;
        				$copy_obj=new Object();
        				$copy_obj.id=$old_id+";"+$spec_id+":"+$id;
        				$copy_obj.name=$old_name+";"+$name;
        				$sku_copy_array.push($copy_obj);
        			}
        			
        		});
        		$sku_array=$sku_copy_array;
        	}
        }
        //console.log(attr_arr);
		/* alert(xid);
		alert(xname);
		alert(yid);
		alert(yname); */
		
	})
 	var property_arr = new Array();
	var arr = new Array();
	var $temp_Obj = new Object();
	$('#type').on('click','.js-spec-item span',function(){
		$('#stock').show();
        var xid = $(this).attr('this-property-id');
        var xname = $(this).attr('this-property');  
        var yid = $(this).attr('this-property-name-id');
        var yname = $(this).attr('this-property-name');
        if($(this).hasClass('selected')){
        	$(this).removeClass('selected');
        	for(var i in property_arr){
				if(property_arr[i].id==xid){
					for(var j in property_arr[i].value){
						if(property_arr[i].value[j].id==yid){
							if(property_arr[i].value.length<2){
								property_arr.splice(i,1);
							}else{
								property_arr[i].value.splice(j,1);
							}
							
						}
					}
				}
			}
        }
        else{
        	$(this).addClass('selected')
	        if(!property_arr[0]){
	        	property_arr.push({id:xid,name:xname,value:[{sid:xid,id:yid,name:yname}]});
			}else{
		        for(var i in property_arr){
					if(property_arr[i].id==xid){
						property_arr[i].value.push({sid:xid,id:yid,name:yname}); break;
					}
					if(i==(property_arr.length-1)){
						property_arr.push({id:xid,name:xname,value:[{sid:xid,id:yid,name:yname}]});break;
					} 	 
				}
			}
        }
        if(!property_arr[0]){
        	$('#stock').hide();
            }
        createSkuData(property_arr)
        
        var th_html = "<tr>";
    	for(var q=0;q<property_arr.length;q++){
    		//给表头添加所选规格
    		th_html +="<th class='text-center'>"+ property_arr[q].name +"</th>";
    	} 
    	//表格表头
    	th_html += '<th class="th-price">销售价（元）</th>';
    	th_html += '<th class="th-price">市场价（元）</th>';
    	th_html += '<th class="th-stock">库存</th>';
    	th_html += '<th class="text-right">销量</th>';
    	th_html += '<th class="text-right">料号</th>';
    	th_html += '</tr>';  
    	$(".js-spec-table thead").html(th_html);
    	//////////////////建立表格////////////////////
    	var html = "";
    	for(var i = 0; i < $sku_array.length; i ++){
    		var child_id_string = $sku_array[i]["id"].toString();
    		var child_name_string = $sku_array[i]["name"].toString();
    		//alert(child_id_string)
    		//alert(child_name_string)
    		if(child_id_string.indexOf(";")){
    			var child_id_array = child_id_string.split(";");
    			
    		}else{
    			var child_id_array = new Array(child_id_string);
    		}
    		if(child_name_string.indexOf(";")){
    			var child_name_array = child_name_string.split(";");
    			
    		}else{
    			var child_name_array = new Array(child_name_string);
    		}
    		//将规格,规格值处理成 spec_id,spec_value_id;spec_id,spec_value_id 格式
    		if($temp_Obj[child_id_string] == undefined){
        		
    			$temp_Obj[child_id_string] = new Object();
    			$temp_Obj[child_id_string]["sku_price"] ="0";
    			$temp_Obj[child_id_string]["market_price"] ="0";
    			$temp_Obj[child_id_string]["stock_num"] ="0";
    			$temp_Obj[child_id_string]["sales"] ="0";
    			$temp_Obj[child_id_string]["pn"] ="0";
    		}
    		html +="<tr skuid='"+child_id_string+"'>";
    		//循环属性
    		$.each(child_name_array,function(m,t){
    			//为属性添加唯一值
    			var start_index = 0;
    			var substr_str = "";
    			while(start_index <= m){
    				if(child_id_array[start_index] != ''){
    					if(substr_str == ""){
    						substr_str = child_id_array[start_index]; 
    						
    					}else{
    						substr_str +=";"+child_id_array[start_index]
    					}
    				}
    				start_index++;
    			} 
    			html +='<td rowspan="1"  skuchild = "'+substr_str+'">'+t+'</td>';
    			
    		});
    		html +='<td>';
    		html +='<input type="text" name="sku_price['+child_id_string+']" class="xs input-mini" maxlength="10" value="'+$temp_Obj[child_id_string]["sku_price"]+'" >';
    		html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">销售价最小为 0.01</span>';
    		html +='</td>';
    		html +='<td>';
    		html +='<input type="text" name="market_price['+child_id_string+']" class="sc input-mini" maxlength="10" value="'+$temp_Obj[child_id_string]["market_price"]+'">';
    		html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">市场价最小为 0.01</span>';
    		html +='</td>';
    		html +='<td>';
    		html +='<input type="text" name="stock_num['+child_id_string+']" class="kc input-mini" maxlength="9" value="'+$temp_Obj[child_id_string]["stock_num"]+'" onkeyup="inputKeyUpNumberValue(this);" onafterpaste="inputAfterPasteNumberValue(this);"/>';
    		html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">库存不能为空</span>';
    		html +='</td>';
    		html +='<td>';
    		html +='<input type="text" name="sales['+child_id_string+']" class="xl input-mini" maxlength="9" value="'+$temp_Obj[child_id_string]["sales"]+'" onkeyup="inputKeyUpNumberValue(this);" onafterpaste="inputAfterPasteNumberValue(this);"/>';
    		html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">销量不能为空</span>';
    		html +='</td>';
    		html +='<td>';
    		html +='<input type="text" name="pn['+child_id_string+']" class="lh input-mini" maxlength="9" value="'+$temp_Obj[child_id_string]["pn"]+'" onkeyup="inputKeyUpNumberValue(this);" onafterpaste="inputAfterPasteNumberValue(this);"/>';
    		html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">料号不能为空</span>';
    		html +='</td>';
    		html +="</tr>"
    	}
    	html+='<tr id="batch"><td style="text-align:left" colspan=6>批量设置：<span id="lcc"><a class="xs" href="javascript:void (0)">销售价</a><a class="sc" href="javascript:void (0)">市场价</a><a class="kc" href="javascript:void (0)">库存</a><a class="xl" href="javascript:void (0)">销量</a><a class="lh" href="javascript:void (0)">料号</a></span><span id="ipp" style="display:none;margin-left:14px;"><input><a class="qd" href="javascript:void (0)">确定</a><a class="qx" href="javascript:void (0)">取消</a></span></td></tr>';
    	var newArray = new Array();
    	$.each(property_arr,function(z,x){
    		newArray = newArray.concat(x.value);
    	});
    	/*批量处理开始*/
    	var daiti = '';
    	//1.
    	$('#stock').on('click','#batch .xs',function(){
    		daiti = 'xs';
        	$(this).parent().hide()
        	$('#ipp').show();
        	$('#ipp').find('input').attr('placeholder', '请输入销售价');
        	aa()
        	
        })
		//2.
        $('#stock').on('click','#batch .sc',function(){
        	daiti = 'sc';
        	$(this).parent().hide()
        	$('#ipp').show();
        	$('#ipp').find('input').attr('placeholder', '请输入市场价');
        	aa()
        })
        //3.
        $('#stock').on('click','#batch .kc',function(){
        	daiti = 'kc';
        	$(this).parent().hide()
        	$('#ipp').show();
        	$('#ipp').find('input').attr('placeholder', '请输入库存');
        	aa()
        })
        //4.
        $('#stock').on('click','#batch .xl',function(){
        	daiti = 'xl';
        	$(this).parent().hide()
        	$('#ipp').show();
        	$('#ipp').find('input').attr('placeholder', '请输入销量');
        	aa()
        })
        //5.
        $('#stock').on('click','#batch .lh',function(){
        	daiti = 'lh';
        	$(this).parent().hide()
        	$('#ipp').show();
        	$('#ipp').find('input').attr('placeholder', '请输入料号');
        	aa()
        })
        $('#stock').on('click','#batch .qd',function(){
        	var val=$(this).parent().find('input').val();
            if(daiti == 'xs')
            {
            	$("tr .xs").each(function(){
    			    $(this).val(val);
    			   
    			}); 
            	
            }else if(daiti == 'sc')
            {
            	$("tr .sc").each(function(){
    			    $(this).val(val);
    			    
    			}); 
            	
            }else if(daiti == 'kc')
            {
            	$("tr .kc").each(function(){
    			    $(this).val(val);
    			    
    			}); 
            	
            }else if(daiti == 'xl')
            {
            	$("tr .xl").each(function(){
    			    $(this).val(val);
    			    
    			}); 
            	
            }
            else if(daiti == 'lh')
            {
            	$("tr .lh").each(function(){
    			    $(this).val(val);
    			    
    			}); 
            	
            }
            $('#ipp').hide();
        	$('#lcc').show();
        	
        })
        $('#stock').on('click','#batch .qx',function(){
       	 	$('#ipp').find('input').val('');
        	$('#ipp').hide();
        	$('#lcc').show();
        })
        function aa()
        {
    		$('#ipp').find('input').val('');
		} 
        /*批量处理结束*/

    	var tdObj = $(".js-spec-table tbody").html(html);
      //将对象处理成表格数据
      
        function createSkuData($specArray){
        	model_sku_json = JSON.stringify($specArray)
        	var $length=$specArray.length;
        	$sku_array=new Array();
        	if($length>0){
        		var $spec_value_obj=$specArray[0]["value"];
        		$.each($spec_value_obj,function(i,v){
        			var $spec_id = v.sid;
        			var $spec_value_id=v.id;
        			var $spec_value=v.name;
        			var $sku_obj=new Object();
        			$sku_obj.id=$spec_id+":"+$spec_value_id;
        			$sku_obj.name=$spec_value;
        			$sku_array.push($sku_obj);
        		});
        		
        	}
        	for($i=1;$i<$length;$i++){
        		$spec_val_obj=$specArray[$i]["value"];
        		$length_val=$spec_val_obj.length;
        
        		$sku_copy_array=new Array();
        		$.each($sku_array,function(i,v){
        			$old_id=v.id;
        			$old_name=v.name;
        			for($y=0;$y<$length_val;$y++){
        				var $spec_id=$spec_val_obj[$y].sid;
        				var $id=$spec_val_obj[$y].id;
        				var $name=$spec_val_obj[$y].name;
        				$copy_obj=new Object();
        				$copy_obj.id=$old_id+";"+$spec_id+":"+$id;
        				$copy_obj.name=$old_name+";"+$name;
        				$sku_copy_array.push($copy_obj);
        			}
        			
        		});
        		$sku_array=$sku_copy_array;
        	}
        }
    	mergeTable()
        //合并单元格
        function mergeTable(){
        	for(var i = 0; i < $sku_array.length; i ++){
        		var child_id_string = $sku_array[i]["id"].toString();
        		var child_id_array = child_id_string.split(";");
        		var sear_str = "";
        		$.each(child_id_array,function(w,q){
        			if(sear_str == ""){
        				sear_str += q;
        			}else{
        				sear_str += ";"+q;
        			}
        			if($("td[skuchild = '"+sear_str+"']").length > 1){
        				var check_array=$("td[skuchild = '"+sear_str+"']");
        				for( var $i=0; $i<check_array.length;$i++){
        					$check_obj=$(check_array[$i]);
        					if($i == 0){
        						$check_obj.attr("rowspan",check_array.length);
        					}else{
        						$check_obj.remove();
        					}
        					
        				}
        			}
        		})
        	}
        } 
	})
	$("#bton").click(function(){
			console.log(model_sku_json)
			$("#model_attr").val(model_attr_json);
			$("#model_sku").val(model_sku_json); 
			$('#form-article-add').submit();
		})
})

    $(function(){
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
    })
</script>
<script>

$(function() {
    $("#form-article-add").validate({
        rules: {
            'title': "required",
            'model_number': "required",
            'stock':"required",
            
            'price':{
                required: true,
                min:0,
            },
           
        },
        messages: {
        	'title': "必填",
            'model_number':"必填",
            'stock':"必填",
            'price':{
                required: "填写商品原价",
                min:"价格大于0",
            },
           
        }
    });
}); 
</script>
</body>
</html>