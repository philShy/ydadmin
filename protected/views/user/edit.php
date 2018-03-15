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
</head>
<style>
    .all{margin:20px 0 0 50px}
    table tr td input{margin-top:10px;}
    table,table tr th, table tr td { border:1px solid #ccc;height:30px }
    table td{text-align: center}

</style>
<body>
<div class="all">
    <h3>个人信息</h3>
    <div style="margin-top: 20px;">
        <table width="50%">
            <tr>
                <td>头像：</td>
                <td><img style="width:80px;height:80px;margin-left: 10px;" src="<?php echo $user_info['portrait']?>"></td>
            </tr>
            <tr>
                <td>名称：</td>
                <td><?php echo $user_info['name']?></td>
            </tr>
            <tr>
                <td>性别：</td>
                <td><?php echo $user_info['sex']?></td>
            </tr>
            <tr>
                <td>积分：</td>
                <td><?php echo $user_info['score']?></td>
            </tr>
            <tr>
                <td>生日：</td>
                <td><?php echo $user_info['born']?></td>
            </tr>
            <tr>
                <td>手机号：</td>
                <td><?php echo $user_info['phone']?></td>
            </tr>
            <tr>
                <td>邮箱：</td>
                <td><?php echo $user_info['email']?></td>
            </tr>
            <tr>
                <td>单位：</td>
                <td><?php echo $user_info['units']?></td>
            </tr>
        </table>
    </div>
    <hr>
    <h3>消费记录</h3>
    <div style="margin-top: 20px;">
        <div class="table_menu_list" style="width:80% !important;">
            <table class="table table-striped table-bordered table-hover" id="sample-table">
                <thead>
                <tr>
                    <th style="display: none" width="25"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
                    <th width="50">订单号</th>
                    <th width="50">交易金额</th>
                    <th width="50">状态</th>
                    <th width="50">积分</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($user_order as $k=>$v):?>
                    <tr>
                        <td style="display: none"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
                        <td><?php echo $v['order_id'].'-'.$v['id']?></td>
                        <td><?php echo $v['order_sub_price']?></td>
                        <td><?php
                                if($v['status'] == 1)
                                {
                                    echo '已支付';
                                }elseif($v['status'] == 2){
                                    echo '已接单';
                                }elseif($v['status'] == 3)
                                {
                                    echo '已发货';
                                }elseif($v['status'] == 4){
                                    echo '已收货';
                                }
                            ?>
                        </td>
                        <td><?php
                            if($v['status'] == 4){
                                echo floor($v['order_sub_price']/100);
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach;?>
                <tr>
                    <td colspan="8">
                        <div id="page">
                            <div class=page_left style="float: left">当前第：<?php echo $page.'/'.ceil($count/5);?>页</div>
                            <div class=page_right style="float: right">
                                <?php
                                echo CPage::newsPage($page,ceil($count/5),$where,$url);
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="font-size: 18px"><b>总积分：<span style="color:red"><?php echo $user_info['score']?></span></b></div>
    </div>
</div>
</body>
</html>
<script>
    jQuery(function($) {
        var oTable1 = $('#sample-table').dataTable( {
            "aaSorting": [[ 1, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[0,1,2,3,4,5,6,8,9,10]}// 制定列不参与排序
            ] } );
        $('table th input:checkbox').on('click' , function(){
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function(){
                    this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
                });
        });
        $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            var off1 = $parent.offset();
            var w1 = $parent.width();
            var off2 = $source.offset();
            var w2 = $source.width();
            if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
            return 'left';
        }
    })
</script>