<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css"/>
    <link rel="stylesheet" href="/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/font/css/font-awesome.min.css" />
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
    <![endif]-->
    <script src="/js/jquery-1.9.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>

    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <script src="/assets/laydate/laydate.js" type="text/javascript"></script>
    <title>交易金额</title>
</head>
<style>
    #page .page_right a{text-decoration:none;display:inline-block;
        width:40px; height: 25px;font-size: 14px;color: #fff;background: #6fb3e0;
        margin-left: 3px;line-height: 25px;}
    #page .page_right a:hover{background: #438eb9}
</style>
<body>
<div class="margin clearfix">
    <div class="amounts_style">
        <div class="transaction_Money clearfix">
            <div class="Money" style="width:20%"><span >成交总额：<em>￥<?php echo $pay_amount_all?></em>元
                <p style="font-size: 10px;"><?php echo '最新统计时间：'.date('Y-m-d H:i:s',time())?></p></div>
            <div class="Money"><span ><em>￥<?php echo $today_pay_amount_all?></em>元</span><p style="font-size: 10px;">当天成交额</p></div>
        <div class="Money" style="width:20%"><span >退款总额：<em>￥<?php echo $refund_amount_all?></em>元
                <p style="font-size: 10px;"><?php echo '最新统计时间：'.date('Y-m-d H:i:s',time())?></p></div>
            <div class="Money"><span ><em>￥<?php echo $today_refund_amount_all?></em>元</span><p style="font-size: 10px;">当天退款额</p></div>
        </div>
        <div class="border clearfix">
      <span class="l_f">
      <a id="all_order" href="/transaction/amounts" class="btn <?php if($sign == 1){echo 'btn-danger';}else{echo 'btn-info';}?>">全部订单</a>
      <a id="year" href="/transaction/amounts?code=1" class="btn <?php if($sign == 2){echo 'btn-danger';}else{echo 'btn-info';}?>">最近一年</a>
      <a id="quarter" href="/transaction/amounts?code=2" class="btn <?php if($sign == 3){echo 'btn-danger';}else{echo 'btn-info';}?>">最近一季</a>
      <a id="month" href="/transaction/amounts?code=3" class="btn <?php if($sign == 4){echo 'btn-danger';}else{echo 'btn-info';}?>">最近一月</a>
      <a id="week" href="/transaction/amounts?code=4" class="btn <?php if($sign == 5){echo 'btn-danger';}else{echo 'btn-info';}?>">最近一周</a>
      <a id="today" href="/transaction/amounts?code=5" class="btn <?php if($sign == 6){echo 'btn-danger';}else{echo 'btn-info';}?>">当天订单</a>
      <form action="" method="post" id="choose_time" style="float: right">
          <input class="inline laydate-icon" placeholder=" 开始时间" id="startdata" name="starttime" style=" margin-left:10px;">
          <input class="inline laydate-icon" placeholder=" 结束时间" id="enddata" name="endtime" style=" margin-left:10px;">
          <input type="submit" value="提交" class="btn btn-danger" />
      </form>

       </span>
            <span class="r_f">共：<b><?php echo $count;?></b>笔</span>
        </div>
        <div class="Record_list">
            <table class="table table-striped table-bordered table-hover" id="sample-table">
                <thead>
                <tr>
                    <th width="100px">订单号</th>
                    <th width="180px">订单成交时间</th>
                    <th width="120px">支付金额(元)</th>
                    <th width="120px">退款金额(元)</th>
                    <th width="180px">退款时间</th>
                    <th width="120px">最终金额(元)</th>
                </tr>
                </thead>
                <tbody>
                <?php if($pay_amount):?>
                <?php foreach($pay_amount as $k=>$v):?>
                <tr>
                    <td><?php echo $v['order_id']?></td>
                    <td><?php echo $v['create_time']?></td>
                    <td><?php echo $v['price']?></td>
                    <td>
                        <?php
                            if(!empty($v['refund_arr']))
                            {
                                foreach($v['refund_arr'] as $kk=>$vv)
                                {
                                    echo $vv['price'].' ';
                                }
                            }
                        ?>
                    </td>
					<td>
                        <?php
                        if(!empty($v['refund_arr']))
                        {
                            foreach($v['refund_arr'] as $kk=>$vv)
                            {
                                echo $vv['create_time'].' ';
                            }
                        }
                        ?>
                    </td>
					<td>
                        <?php
                            unset($arr);
                            if(!empty($v['refund_arr']))
                            {
                                foreach($v['refund_arr'] as $kk=>$vv)
                                {
                                    $arr[$kk] = $vv['price'];
                                }
                            }
                            if($arr)
                            {
                                echo $v['price']- array_sum($arr);
                            }else{
                                echo $v['price'];
                            }
                            ?>
                    </td>
                </tr>
                <?php endforeach;?>
                <?php endif;?>
                <tr>
                    <td colspan="6">

                        <div id="page">
                            <div class=page_left style="float: left">当前第：<?php echo $page.'/'.ceil($count/10);?>页</div>
                            <div class=page_right style="float: right">
                                <?php
                                    echo CPage::newsPage($page,ceil($count/10),$where,$url);
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="Statistics" style="display:none">
    <div id="main" style="height:400px; overflow:hidden; width:1000px; overflow:auto" ></div>
</div>
</body>
</html>
<script>
    //时间选择
    laydate({
        elem: '#startdata',
        event: 'focus'
    });

    laydate({
        elem: '#enddata',
        event: 'focus'
    });
</script>
