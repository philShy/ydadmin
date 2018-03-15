<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css"/>
    <link href="/assets/css/codemirror.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/font/css/font-awesome.min.css" />
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
    <![endif]-->
    <script src="/js/jquery-1.9.1.min.js"></script>
    <script src="/js/H-ui.js" type="text/javascript"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <script src="/assets/laydate/laydate.js" type="text/javascript"></script>

    <script src="/js/lrtk.js" type="text/javascript" ></script>
    <title></title>
</head>

<body>
<div class="margin clearfix">
    <div id="refund_style">
        <div class="search_style">
        <form action='/transaction/refund' method='post' id='iform'>
            <ul class="search_content clearfix">
                <li><label class="l_f">订单号</label><input name="order_id" type="text" class="text_add" placeholder="输入订单号" style=" width:250px"></li>
                <li><label class="l_f">申请时间</label><input placeholder="开始时间" class="inline laydate-icon" name="start_date" id="startdate" style=" margin-left:10px;">
                <input placeholder="截止时间" class="inline laydate-icon" name="end_date" id="enddate" style=" margin-left:10px;"></li>
                <li style="width:90px;"><button type="button" class="btn_search"><i class="fa fa-search"></i>查询</button></li>
            </ul>
         </form>
        </div>
        <div class="border clearfix">
       <span class="l_f">
        <a href="javascript:ovid()" class="btn btn-success btnSuccess Order_form"><i class="fa fa-check-square-o"></i>&nbsp售后完成</a>
        <a href="javascript:ovid()" class="btn btn-warning btnWarning Order_form"><i class="fa fa-close"></i>&nbsp;申请售后</a>
         <a href='/transaction/orderform3' class="btn btn-success btnSuccess Order_form"><i class="fa fa-check-square-o"></i>&nbsp;已取消订单</a>
        <a href='/transaction/orderform7' class="btn btn-warning btnWarning Order_form"><i class="fa fa-close"></i>&nbsp;申请取消的订单</a>
       </span>
            <span class="r_f">共：<b><?php //echo $count?></b>笔</span>
        </div>
        <!--退款列表-->
        <div class="refund_list">
            <table class="table table-striped table-bordered table-hover" id="sample-table">
                <thead>
                <tr>
                    <th width="100px">ID</th>
                    <th width="120px">订单编号</th>
                    <th width="250px">产品名称</th>
                    <th width="100px">售后方式</th>
                    <th width="180px">申请时间</th>
                    <th width="100px">商品金额</th>
                    <th width="120px">退/换/修数量</th>
                    <th width="100px">状态</th>
                    <th width="200px">说明</th>
                    <th width="200px">操作</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach($refund_arr as $key=>$value):?>
                <tr>
                    <td><?php echo $value['id']?></td>
                    <td class="orderid"><?php echo $value['order_id']?></td>
                    <td class="order_product_name">
                        <a href="#"><?php echo $value['name'].'【'.$value['model_number'].'】'?></a>
                    </td>
                    <td>
                        <span>
                            <?php
                            if($value['apply_type'] ==1) {echo '退款';}
                            elseif($value['apply_type'] ==2){echo '换货';}
                            elseif($value['apply_type'] ==3){echo '维修';}
                            else{echo '补发';}
                            ?>
                        </span>
                    </td>
                    <td><?php echo $value['create_time']?></td>
                    <td><?php echo $value['price']?></td>
                    <td><?php echo $value['number']?></td>
                    <td class="td-status">
                        <span>
                            <?php
                            if($value['apply_type'] ==1)
                            {//tui
                                if($value['status'] ==0) {echo '拒绝退款';}
                                elseif($value['status'] ==1){echo '申请退款';}
                                elseif($value['status'] ==2){echo '未传单号';}
                                elseif($value['status'] ==3){echo '待收货';}
                                elseif($value['status'] ==4){echo '已收货';}
                                elseif($value['status'] ==5){echo '重新发货';}
                                elseif($value['status'] ==6){echo '退款成功';}
                            }elseif($value['apply_type'] ==2)
                            {//huan
                                if($value['status'] ==0) {echo '拒绝换货';}
                                elseif($value['status'] ==1){echo '申请换货';}
                                elseif($value['status'] ==2){echo '未传单号';}
                                elseif($value['status'] ==3){echo '待收货';}
                                elseif($value['status'] ==4){echo '已收货';}
                                elseif($value['status'] ==5){echo '重新发货';}
                                elseif($value['status'] ==6){echo '换货成功';}
                            }elseif ($value['apply_type'] ==3)
                            {//xiu
                                if($value['status'] ==0) {echo '拒绝维修';}
                                elseif($value['status'] ==1){echo '申请维修';}
                                elseif($value['status'] ==2){echo '未传单号';}
                                elseif($value['status'] ==3){echo '待收货';}
                                elseif($value['status'] ==4){echo '已收货';}
                                elseif($value['status'] ==5){echo '重新发货';}
                                elseif($value['status'] ==6){echo '维修成功';}
                            }elseif ($value['apply_type'] ==4)
                            {//bu
                                if($value['status'] ==0) {echo '拒绝维修';}
                                elseif($value['status'] ==1){echo '申请补发';}
                                elseif($value['status'] ==5){echo '重新发货';}
                                elseif($value['status'] ==6){echo '补发成功';}
                            }

                            ?>
                        </span></td>
                    <td><?php echo $value['returned_goods_reason']?></td>
                    <td>
                        <a title="退款订单详细"  href="/transaction/refunddetail?id=<?php echo $value['id']?>&order_id=<?php echo $value['order_id']?>&apply_type=<?php echo $value['apply_type']?>"  class="btn btn-xs btn-info Refund_detailed" >详细</a>
                        <a style='display:none' title="删除" href="javascript:;"  onclick="Order_form_del(this,'<?php echo $value['id']?>')" class="btn btn-xs btn-warning" >删除</a>
                    </td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
<script>

    function Order_form_del(obj,id)
    {
        var url = '/transaction/refund';
    	$.post(url,{orderid:id,del:1},function(data){
				alert(data)
        	})
    }                        
    $(function(){
		$('.btn_search').click(function(){
			$('#iform').submit()
		})
    })
     $(function(){
		$('.btnSuccess').click(function(){
			$('.search_content').append("<input type='text' name='success' value='1'>");
			$('#iform').submit();
		})
		$('.btnWarning').click(function(){
			$('.search_content').append("<input type='text' name='warning' value='1'>");
			$('#iform').submit();
		})
    })
    //订单列表
    jQuery(function($) {
        var oTable1 = $('#sample-table').dataTable( {
            "aaSorting": [[ 1, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[2,3,4,5,6,8,9]}// 制定列不参与排序
            ] } );
        //全选操作
        $('table th input:checkbox').on('click' , function(){
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function(){
                    this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
                });
        });
    });
    $(function(){
        $('.btn_ref').click(function(){
            $_this = $(this);
            var url = '/transaction/refund';
            var orderid = $(this).attr('orderid');
            var pid = $(this).attr('pid');
            layer.confirm('是否同意退款！',function(index){
                $.post(url,{state:1,orderid:orderid,pid:pid},function(data){
                    if(data == 1){
                        $_this.parents("tr").find(".td-manage").prepend('<a style=" display:none" class="btn btn-xs btn-success" onClick="member_stop(this,id)" href="javascript:;" title="已退款">退款</a>');
                        $_this.parents("tr").find(".td-status").html('<span>已退款</span>');
                        $_this.remove();
                    }
                })
                window.location.href='/transaction/refund';
            });
        })
    })
    //面包屑返回值
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);
    $('.Refund_detailed').on('click', function(){
        var cname = $(this).attr("title");
        var chref = $(this).attr("href");
        var cnames = parent.$('.Current_page').html();
        var herf = parent.$("#iframe").attr("src");
        parent.$('#parentIframe').html(cname);
        parent.$('#iframe').attr("src",chref).ready();;
        parent.$('#parentIframe').css("display","inline-block");
        parent.$('.Current_page').attr({"name":herf,"href":"javascript:void(0)"}).css({"color":"#4c8fbd","cursor":"pointer"});
        //parent.$('.Current_page').html("<a href='javascript:void(0)' name="+herf+" class='iframeurl'>" + cnames + "</a>");
        parent.layer.close(index);
    });
    laydate({
        elem: '#startdate',
        event: 'focus'
    });
    laydate({
        elem: '#enddate',
        event: 'focus'
    });
</script>