<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css"/>
    <link href="/assets/css/codemirror.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/colorbox.css">
    <!--图片相册-->
    <link rel="stylesheet" href="/assets/css/ace.min.css" />

    <link rel="stylesheet" href="/font/css/font-awesome.min.css" />
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
    <![endif]-->

    <script src="/js/jquery-1.9.1.min.js"></script>
    <script src="/assets/js/jquery.colorbox-min.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <script type="text/javascript" src="/Widget/swfupload/swfupload.js"></script>
    <script type="text/javascript" src="/Widget/swfupload/swfupload.queue.js"></script>
    <script type="text/javascript" src="/Widget/swfupload/swfupload.speed.js"></script>
    <script type="text/javascript" src="/Widget/swfupload/handlers.js"></script>


    <title>期限列表</title>
</head>

<body>
<div class="page-content clearfix">
    <div class="sort_adsadd_style">
        <div class="border clearfix">
       <span class="l_f">
        <a href="javascript:void()" id="time_limit_add" title="添加" class="btn btn-warning Order_form"><i class="fa fa-plus"></i> 添加</a>
        <a href="javascript:void()" style="display: none" class="btn btn-danger"><i class="fa fa-trash"></i> 批量删除</a>
        <a href="javascript:void()" onClick="javascript :history.back(-1);" class="btn btn-info"><i class="fa fa-reply"></i> 返回上一步</a>
       </span>
            <span class="r_f">共：<b><?php echo $count?></b>条记录</span>
        </div>
        <!--列表样式-->
        <div class="sort_Ads_list">
            <table class="table table-striped table-bordered table-hover" id="sample-table">
                <thead>
                <tr>
                    <th style="display: none"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
                    <th width="80px">ID</th>
                    <th width="180">售后期限名称</th>
                    <th style="display: none">排序</th>
                    <th style="display: none">图片</th>
                    <th style="display: none">尺寸（大小）</th>
                    <th style="display: none">链接地址</th>
                    <th style="width:180px">退货期限(天)</th>
                    <th style="width:180px">换货期限(天)</th>
                    <th width="50">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($time_limit_arr as $key=>$value):?>
                    <tr>
                        <td style="display: none"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
                        <td class="model_id"><?php echo $value['id']?></td>
                        <td><?php echo $value['name']?></td>
                        <td style="display: none"></td>
                        <td style="display: none"></td>
                        <td style="display: none"></td>
                        <td style="display: none"></td>
                        <td><?php echo $value['returned_time']/3600/24?></td>
                        <td><?php echo $value['exchange_time']/3600/24?></td>
                        <td>
                            <a title="删除" href="javascript:;"  onclick="member_del(this,'<?php echo $value['id']?>')" class="btn btn-xs btn-warning" ><i class="fa fa-trash  bigger-120"></i></a>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<!--添加-->
<div id="Delivery_stop" style=" display:none">
    <div class="">
        <div class="content_style">
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"><span style="color:red">*</span> 期限名称 </label>
                <div class="col-sm-9"><input type="text" id="name" name="logistics_num" placeholder="售后期限名称" class="col-xs-10 col-sm-5" style="margin-left:0px;"></div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"><span style="color:red">*</span> 退货期限 </label>
                <div class="col-sm-9"><input type="text" id="returned_time" name="shipper" placeholder="退货期限" class="col-xs-10 col-sm-5" style="margin-left:0px;"><span>天</span></div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"><span style="color:red">*</span> 换货期限 </label>
                <div class="col-sm-9"><input type="text" id="exchange_time" name="consignee" placeholder="换货期限" class="col-xs-10 col-sm-5" style="margin-left:0px;"><span>天</span></div>
            </div>
        </div>
    </div>
</div>
</span>
</li>
</ul>
</div>
</div>
</body>
</html>

<script>
    /*删除*/
    function member_del(obj,id){
        var url = "/product/set_sales_time";
        var time_id = id;
        layer.confirm('确认要删除吗？',{icon:0,},function(index){
            $.ajax({
                type: "POST",
                url: url,
                data: {time_id:time_id},
                dataType: "json",
                success: function(data){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }
            });
        });
    }
    jQuery(function($) {
        $("#time_limit_add").click(function(){
            layer.open({
                type: 1,
                title: '添加',
                maxmin: true,
                shadeClose:false,
                area : ['500px' , ''],
                content:$('#Delivery_stop'),
                btn:['确定','取消'],
                yes: function(index, layero){
                    var url = '/product/set_sales_time';
                    var name = $('#name').val();
                    var exchange_time = $('#exchange_time').val();
                    var returned_time = $("#returned_time").val();
                    if($('#name').val()==""){
                        layer.alert('名称不能为空！',{
                            title: '提示框',
                            icon:0,
                        })
                    }else{
                        layer.confirm('提交成功！',function(index){
                            $.post(url,{name:name,exchange_time:exchange_time,returned_time:returned_time},function(data){
                                if(data){
                                    layer.msg('已添加!',{icon: 6,time:1000});
                                }
                            })
                        });
                        layer.close(index);
                    }
                }
            })
        })
        var oTable1 = $('#sample-table').dataTable( {
            "aaSorting": [[ 1, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[0,2,3,4,5,7,8,]}// 制定列不参与排序
            ] } );

        $('table th input:checkbox').on('click' , function(){
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function(){
                    this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
                });

        });
        
    })
</script>