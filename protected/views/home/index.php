<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css"/>
    <link rel="stylesheet" href="/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css" />
    <link href="/assets/css/codemirror.css" rel="stylesheet">
    <!--[if IE 7]>
    <link rel="stylesheet" href="/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
    <![endif]-->
    <script src="/assets/js/ace-extra.min.js"></script>
    <!--[if lt IE 9]>
    <script src="/assets/js/html5shiv.js"></script>
    <script src="/assets/js/respond.min.js"></script>
    <![endif]-->
    <!--[if !IE]> -->
    <script src="/assets/js/jquery.min.js"></script>
    <!-- <![endif]-->
    <script src="/assets/dist/echarts.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <title></title>
</head>
<style>
    .Order_Statistics{width: 30% !important;margin-left: 8px !important;}
    .col-sm-6{width: 33.3% !important;}
</style>
<body>
<div class="page-content clearfix" >
    <div class="alert alert-block alert-success" style="width:98% !important;">
        <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
        <i class="icon-ok green"></i>欢迎进入<strong class="green">后台管理系统<small>(v1.0)</small></strong>,你本次登陆时间为<?php echo date('Y年m月d日 H时i分s秒')?>，登陆IP:<?php echo CSystem::getip()?>.
    </div>
    <div class="state-overview clearfix" >
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <a href="#" title="商城会员">
                    <div class="symbol terques">
                        <i class="icon-user"></i>
                    </div>
                    <div class="value">
                        <h1><?php echo $count_user?></h1>
                        <p>商城会员</p>
                    </div>
                </a>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol yellow">
                    <i class="icon-shopping-cart"></i>
                </div>
                <div class="value">
                    <h1><?php echo $order_all_count;?></h1>
                    <p>商城订单</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol blue">
                    <i class="icon-bar-chart"></i>
                </div>
                <div class="value">
                    <h1><?php echo '￥'.$amount?></h1>
                    <p>交易金额</p>
                </div>
            </section>
        </div>
    </div>
    <!--实时交易记录-->
    <div class="clearfix" style="width:104% !important; margin-left: 5px;">
        <div class="Order_Statistics ">
            <div class="title_name">订单统计信息</div>
            <table class="table table-bordered">
                <tbody>
                <tr><td class="name">未开发票订单：</td><td class="munber"><span style='color:red'><?php echo $not_inv_count;?></span>&nbsp;个</td></tr>
                <tr><td class="name">待接单订单：</td><td class="munber"><span style='color:red'><?php echo $untreated_order_count;?></span>&nbsp;个</td></tr>
                <tr><td class="name">待发货订单：</td><td class="munber"><span style='color:red'><?php echo $to_send_order_count;?></span>&nbsp;个</td></tr>
                <tr><td class="name">已成交订单数：</td><td class="munber"><span style='color:red'><?php echo $success_order_count;?></span>&nbsp;个</td></tr>
                </tbody>
            </table>
        </div>
        <div class="Order_Statistics">
            <div class="title_name">商品统计信息</div>
            <table class="table table-bordered">
                <tbody>
                <tr><td class="name">商品总数：</td><td class="munber"><span style='color:red'><?php echo $count_model?></span>&nbsp;个</td></tr>
                <tr><td class="name">上架商品：</td><td class="munber"><span style='color:red'><?php echo $count_publish_model?></span>&nbsp;个</td></tr>
                <tr><td class="name">下架商品：</td><td class="munber"><span style='color:red'><?php echo $count_no_publish_model?></span>&nbsp;个</td></tr>
                <tr><td class="name">待审核商品：</td><td class="munber"><span style='color:red'><?php echo $wait_goods?></span>&nbsp;个</td></tr>
                </tbody>
            </table>
        </div>
        <div class="Order_Statistics">
            <div class="title_name">品牌文章信息</div>
            <table class="table table-bordered">
                <tbody>
                <tr><td class="name">品牌数量：</td><td class="munber"><span style='color:red'><?php echo $count_brand?></span>&nbsp;个</td></tr>
                <tr><td class="name">文章数量：</td><td class="munber"><span style='color:red'><?php echo $count_article?></span>&nbsp;篇</td></tr>
                <tr><td class="name">文章评论：</td><td class="munber"><span style='color:red'><?php echo $article_comment_count_all?></span>&nbsp;条</td></tr>

                </tbody>
            </table>
        </div>
        <!--<div class="t_Record">
          <div id="main" style="height:300px; overflow:hidden; width:100%; overflow:auto" ></div>
         </div> -->
    </div>
    <!--记录-->
    <div class="clearfix" style="width: 98.5% !important;">
        <div class="home_btn" style="width: 99.5% !important;">
            <div>
                <a href="<?php echo Yii::app()->request->hostInfo.'/product/add'; ?>"  title="添加商品" class="btn  btn-info btn-sm no-radius">
                    <i class="bigger-200"><img src="/images/icon-addp.png" /></i>
                    <h5 class="margin-top">添加商品</h5>
                </a>
                <a href="<?php echo Yii::app()->request->hostInfo.'/product/category'; ?>"  title="产品分类" class="btn  btn-primary btn-sm no-radius">
                    <i class="bigger-200"><img src="/images/icon-cpgl.png" /></i>
                    <h5 class="margin-top">产品分类</h5>
                </a>
                <a href='<?php echo Yii::app()->request->hostInfo."/manage/editmanager?id=$id;" ?>'  title="个人信息" class="btn  btn-success btn-sm no-radius">
                    <i class="bigger-200"><img src="/images/icon-grxx.png" /></i>
                    <h5 class="margin-top">个人信息</h5>
                </a>
                <a href="<?php echo Yii::app()->request->hostInfo.'/system/log'; ?>"  title="系统设置" class="btn  btn-info btn-sm no-radius">
                    <i class="bigger-200"><img src="/images/xtsz.png" /></i>
                    <h5 class="margin-top">系统设置</h5>
                </a>
                <a href="<?php echo Yii::app()->request->hostInfo.'/transaction/orderform'; ?>"  title="商品订单" class="btn  btn-purple btn-sm no-radius">
                    <i class="bigger-200"><img src="/images/icon-gwcc.png" /></i>
                    <h5 class="margin-top">商品订单</h5>
                </a>

                <a href="<?php echo Yii::app()->request->hostInfo.'/article/add'; ?>"  title="添加文章" class="btn  btn-info btn-sm no-radius">
                    <i class="bigger-200"><img src="/images/icon-addwz.png" /></i>
                    <h5 class="margin-top">添加文章</h5>
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
    //alert(5555)
    //面包屑返回值
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);
    $('.no-radius').on('click', function(){
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
    $(document).ready(function(){

        $(".t_Record").width($(window).width()-640);
        //当文档窗口发生改变时 触发
        $(window).resize(function(){
            $(".t_Record").width($(window).width()-640);
        });
    });
</script>