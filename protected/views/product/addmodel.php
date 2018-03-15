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
    <title>新增图片 - 素材牛模板演示</title>
</head>
<style>
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
    .sign{color:red}
</style>
<body>
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
<div class="clearfix" id="add_picture">
    <div class="page_right_style" style="width:100%">
        <div class="type_title">添加商品型号</div>
        <form action="/product/addmodel" method="post" class="form form-horizontal" id="form-article-add" enctype="multipart/form-data">

            <div class="clearfix cl" id="models" >
            	<div>
            	<label style="margin-left:30px;">选择商品：</label>&nbsp;&nbsp;
                <select class="category">
                	<option>选择类别</option>
                	<?php foreach($list as $key=>$value): ?>
                       <?php $count = substr_count($value['pth'],',');$str = '&nbsp;';if($count):?>
                            <option <?php if($count==1) echo 'disabled '?> value=<?php echo $value['id']?>><?php echo str_repeat($str,($count)*4).$value['name'];?></option>
                       <?php endif?>
                    <?php endforeach;?>
                </select>
                <select class="goods" style="display:none" name='goods_id'>
                	<option>选择商品</option>
            		
                </select>
                </div>
          
                <div class="model" style="width:90%">
                    <div class="modelchild" style="width:1300px;">
                        <span style="margin-right: 6px;">标&nbsp;&nbsp;&nbsp;&nbsp;题：</span><input type="text" value="" name="title[]" style="width:60%">
                    <span class="sign">*</span>
                    </div>
                    <div class="modelchild" style="width:1300px;">
                        <span style="font-size: 10px !important;">包装清单：</span><input type="text" value="" name="goods_list[]" style="width:60%">
                    </div>
                    <div class="modelchild" style="width:300px;">
                        <span style="margin-right: 6px;">型&nbsp;&nbsp;&nbsp;&nbsp;号：</span><input id="model_number" type="text" value="" name="model_number[]" style="width: 100px">
                    <span class="sign">*</span>
                    </div>

                    <div class="modelchild" style="width:300px;">
                        <span style="margin-right: 6px;">库&nbsp;&nbsp;&nbsp;&nbsp;存：</span><input type="number" value="" name="stock[]" style="width: 100px">
                    <span class="sign">*</span>
                    </div>

                    <div class="modelchild" style="width:300px;">
                        <span style="margin-right: 6px;">原&nbsp;&nbsp;&nbsp;&nbsp;价：</span><input id="price" type="number" value="" name="price[]" style="width: 100px">
                    <span class="sign">*</span>
                    </div>
                    <div class="modelchild" style="width:300px;">
                        <span style="margin-right: 6px;">优&nbsp;&nbsp;&nbsp;&nbsp;惠：</span><input type="text" value="" name="preferential_price[]" style="width: 100px">
                    </div>
                    <div class="modelchild" style="width:300px;">
                        <span style="margin-right: 6px;">重&nbsp;&nbsp;&nbsp;&nbsp;量：</span><input type="text" value="" name="weights[]" style="width: 100px">
                    </div>
                    <div class="modelchild" style="width:300px;">
                        <span style="margin-right: 6px;">尺&nbsp;&nbsp;&nbsp;&nbsp;寸：</span><input type="text" value="" name="sizes[]" style="width: 100px">
                    </div>
                    <div class="modelchild" style="width:300px;">
                        <span style="margin-right: 6px;">颜&nbsp;&nbsp;&nbsp;&nbsp;色：</span><input type="text" value="" name="colors[]" style="width: 100px">
                    </div>
                    <div class="modelchild" style="width:300px; position: relative">
                         <span style="margin-right: 10px;font-size: 10px !important;">商&nbsp;品&nbsp;ID：&nbsp;<input id="assoc" type="text" placeholder="关联商品ID" name="associated[]" style="width: 100px">
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
					<div class="modelchild" style="width:100%; position: relative">
                        	售后服务：
                        <select name="after_sales[]">
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
                    <div class="modelchild" id="specifications" style="width:100%;">
                        	规格参数：<a href="javascript:void(0)" class="btn1" data-val="1">添加参数</a>
                        <a href="javascript:void(0)" class="btn66">参数提交</a><span class="sign">*</span>
                    </div>
                    <div class="modelchild" style="width:80%;float: left" >
                        	图片上传：<a href="javascript:void(0)" class="selectFileBtn" >图片上传</a>
                        <div class="uploader-list-container" style=";display: none;height:80px;width:100%;margin-left:60px;">
                            <div class="attachList clear"></div>
                        </div>
                    </div>
                    <!-- 视频上传 -->
                    <div class="modelchild" style="width:80%;float: left" >
                        	视频上传：<input type="file" name="video[]" style="display:inline-block;">
                        	<span class="sign" style="margin-left:-50px;">视频大小不超过1G</span>
                    </div>
                    <input class='jssn' type='hidden' name='jssn[]' />
                </div>
            </div>

            
            
            <div style="width:100px;margin-left:600px">
                <input type="submit" value="提&nbsp;&nbsp;&nbsp;&nbsp;交" class="btn btn-primary radius" style="width:100px;">
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
		$('.category').change(function(){
			var catid = $(this).val();
	        var url = '/product/addmodel';
	       
	        $.post(url,{catid:catid},function(data){
	            var parsedJson = jQuery.parseJSON(data);
	            $(".goods").find("option").not(":first").remove();
	            $.each(parsedJson, function(i, item) {
	                $('.goods').append('<option value='+item.id+'>'+item.name+'</option>');

	            });
	        }) 
	        $('.goods').show();
		})

		$('.goods').change(function(){
			
	        $('.guige').show();
		})
	
	})
    $(function(){
        var ue = UE.getEditor('editor');
        var ue1 = UE.getEditor('editor1');

    });
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
    $(function(){
        $('#models').on('click','#associated',function(){

            $(this).parent().find('#choose').show();
            $(this).parent().find('#sure').show();
            $(this).hide();
        })

        $('#models').on('click','#sure',function(){
            var obj = $(this).parent().find('#choose');
            $(this).parent().find('#assoc').val(obj.val())
            $(this).parent().find('#choose').hide();
            $(this).parent().find('#associated').show();
            $(this).hide();

        })
    })
    var model_id=0;
    $(function() {
        $('#butn').click(function(){
            $(".btn-primary").show();
            $("#models").append($(".model").eq(0).clone().show());
            var num = $('#models .model').length-1;
            //$("#models").find('.model').eq(num).append("<div class='mark' style='display:'>"+num+"</div>")

            model_id++;
        })

        $("#models").on('click','.selectFileBtn',function(){
            $(this).parent().find('.uploader-list-container').show()
            $fileField = $("<input type='file' name='proImg["+model_id+"][]'/>");
            $fileField.hide();
            $(this).parent().find(".attachList").append($fileField);
            $fileField.trigger("click");
            $fileField.change(function(){
                $path = $(this).val();
                $filename = $path.substring($path.lastIndexOf("\\")+1);
                $attachItem = $('<div class="attachItem"><div class="left">a.gif</div><div class="right"><a href="#" title="删除附件">删除</a></div></div>');
                $attachItem.find(".left").html($filename);
                $(this).parent().append($attachItem);
            });

        });
        $("#models").on('click','.attachItem a',function(obj,i){
            $(this).parents('.attachItem').prev('input').remove();
            $(this).parents('.attachItem').remove();
        });

        $("#form-article-add").on('click','#down',function(){
            $(this).parent().find('.down-list-container').show()
            $fileField = $("<input type='file' name='down[]'/>");
            $fileField.hide();
            $(this).parent().find(".downList").append($fileField);
            $fileField.trigger("click");
            $fileField.change(function(){
                $path = $(this).val();
                $filename = $path.substring($path.lastIndexOf("\\")+1);
                $downItem = $('<div class="downItem"><div class="left">a.gif</div><div class="right"><a href="#" title="删除附件">删除</a></div></div>');
                $downItem.find(".left").html($filename);
                $(this).parent().append($downItem);
            });
        });
        $("#form-article-add").on('click','.downItem a',function(obj,i){
            $(this).parents('.downItem').prev('input').remove();
            $(this).parents('.downItem').remove();
        });

        $("#form-article-add").on('click','.btn1',function(){
            var obj = $(this).parent();
            var mm=$(this).attr('data-val')-0;
            $specifications = $("<div class='specifications' style='width:1000px;border:1px solid #ddd'><input data_val='"+mm+"' name='"+model_id+"-"+mm+"' style='margin-top: 5px;' class='sssss specifications_input' type='text'  placeholder='&nbsp;分类' > <button class='addbtn' data-val='1' style='border:none;background: none'>+</button> </div>");
            obj.append($specifications);
            $(this).attr('data-val',$(this).attr('data-val')-0+1);
        })

        $("#form-article-add").on('click','.addbtn',function(){
            var xx=$(this).prev().attr('data_val');
            var obj = $(this).parent();
            var nn=$(this).attr('data-val')-0;
            $specifications1 = $("<div class='sss'><input name='att"+model_id+"-"+xx+"-"+nn+"' class='specifications_input' type=text  placeholder='&nbsp;属性' >&nbsp;<input class='specifications_input' type=text name='val"+model_id+"-"+xx+"-"+nn+"' placeholder='&nbsp;值'></div>");
            obj.append($specifications1);
            //$("button[class=addbtn]:last").show()
            $(this).attr('data-val',$(this).attr('data-val')-0+1);
            return false;
        })

        $("#form-article-add").on('click','.btn66',function(){
          
            var pp=$(this).parents('#specifications').find('.addbtn');
            var yy=0;
            var qq=$('.sssss:last').attr('data_val')-0+1;
            var jsn2 = '';
            var date = '';
            var zz='';
            for(a=1;a<qq;a++){
                var jsn1 = '';
                var ww = '';
                jsn2 = $(this).parent().find('.sssss')[a-1].value;
                if(jsn2 != '')
                {
                	for(b=1;b<pp[yy].getAttribute('data-val');b++){
                        var str1 = 'att'+model_id+'-'+a+'-'+b;
                        var str2 = 'val'+model_id+'-'+a+'-'+b;
                        var hh1=pp.parents('#specifications').find('input[name='+str1+']').val();
                        var hh2=pp.parents('#specifications').find('input[name='+str2+']').val();

                        if(hh1 && hh2)
                        {
                        	jsn1+= "{\"att\":\""+hh1+"\",\"val\":\""+hh2+"\"},";
                        
                        }

                    }
                    ww=(jsn1.substring(jsn1.length-1)==',')?jsn1.substring(0,jsn1.length-1):jsn1;
                    if(ww !='')
                    {
                    	date += "{\"type\":\""+jsn2+"\",\"prop\":["+ww+"]}`"
                    }
                    
                    zz=(date.substring(date.length-1)=='`')?date.substring(0,date.length-1):date;
                    yy++;
              
                }

            }
            
            $jssn = $("<input class='jssn' type='hidden' name='jssn[]' />");
            if($(this).parents('.model').find('.jssn').length && $(this).parents('.model').find('.jssn').length>0){
                $(this).parents('.model').find('.jssn').val(zz)
            }else{
                $(this).parents('.model').append($jssn);
                $(this).parents('.model').find('.jssn').val(zz)
            }
        })
    });

</script>
<script>
   /* $(function() {
        $("#form-article-add").validate({
            rules: {
                name: "required",
                address: "required",
                'model_number[]': "required",
                'title[]': "required",
                'material_number[]': "required",
                goodscateid: {
                    min:1
                },
                brandid: {
                    min:1
                },
                'price':{
                    required: true,
                    min:0,
                },
                'cate':{
                    
                    min:1,
                },
                'brand':{
                   
                    min:1,
                },
                'preferential_price':{
                    min:0,
                },
                'price[]':{
                    required: true,
                    min:0,
                },
                'stock[]':{
                    required: true,
                    min:0,
                },
                'weight[]':{
                    min:0,
                },
                goodsname: {
                    required: true,
                    minlength: 2
                },
            },
            messages: {
                name: "必填",
                address:"必填",
                'model_number[]':"必填",
                'title[]':"必填",
                'material_number[]':"必填",
                'price[]':"必填",
                goodscateid:{
                    min:"必选",
                },
                brandid:{
                    min:"必选",
                },
                'price':{
                    required: "填写商品原价",
                    min:"价格大于0",
                },
				'cate':{
                    
                    min:"必选",
                },
                'brand':{
                   
                	min:"必选",
                },
                'preferential_price':{
                    min:"优惠价大于0",
                },
                goodsname: {
                    required: "输入商品名",
                    minlength: "名称大于两个字"
                },
                'price[]':{
                    required: "输入商品价格",
                    min: "价格不能小于0",
                },
                'stock[]':{
                    required: "输入商品库存",
                    min: "库存不能小于0",
                },
                'weight[]':{
                    min: "商品重量不能小于0",
                },
            }
        });
    }); */
</script>
</body>
</html>