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
    <link rel="stylesheet" href="/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/font/css/font-awesome.min.css" />
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
    <![endif]-->
    <script src="/js/jquery-1.9.1.min.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script src="/js/lrtk.js" type="text/javascript" ></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <title>分类管理</title>
</head>
<style>
    #page .page_right a{text-decoration:none;display:inline-block;
        width:40px; height: 25px;font-size: 14px;color: #fff;background: #6fb3e0;
        margin-left: 3px;line-height: 25px;}
    #page .page_right a:hover{background: #2a8bcc}
</style>
<body>
<div class="page-content clearfix">
    <div class="sort_adsadd_style">
        <div class="border clearfix">
       <span class="l_f">
        <a href="javascript:void()" onClick="javascript :history.back(-1);" class="btn btn-info"><i class="fa fa-reply"></i> 返回上一步</a>
            <form action="/images/pdf" method="post" style="display:inline-block">
                <input name="goods_name" type="text" placeholder="请输入商品名">
                <input style="border-radius: 3px;line-height:28px;width:50px;height:28px;border: none;background: #6fb3e0;color:#fff" type="submit" value="查找"/>
            </form>

       </span>

        </div>
        <!--列表样式-->
        <div class="sort_Ads_list">
            <table class="table table-striped table-bordered table-hover" id="sample-table">

                <thead>
                <tr>
                    <th width="25"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
                    <th width="80px">ID</th>
                    <th width="200">商品名称</th>
                    <th  width="500px">文件名</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php  foreach($result as $key=>$value):?>
                <tr>
                    <td><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
                    <td class="pdf_id"><?php echo $value['id']?></td>
                    <td><?php echo $value['name']; ?></td>
                    <td>
                        <?php $result=CImages::searcPdf_byGoodsId($value['id']);
                        foreach ($result as $k=>$v)
                        {
                            //var_dump($v['pdf_name']);
                            echo "<a href='$v[url]' target='view_window'><img style='width:20px;' src='/images/pdf_logo.png'>{$v['pdf_name']}</a> &nbsp;";
                        }
                        ?>
                    </td>
                    <td class="td-manage">
                        <!--<a onClick="member_stop(this,'10001')"  href="javascript:;" title="停用"  class="btn btn-xs btn-success"><i class="fa fa-check  bigger-120"></i></a>-->

                        <a title="编辑"  href="/images/edit_pdf?id=<?php echo $value['id']?>"  class="btn btn-xs btn-info" ><i class="fa fa-edit bigger-120"></i></a>
                        <!--<a title="删除" href="javascript:;"  onclick="member_del(this,'1')" class="btn btn-xs btn-warning" ><i class="fa fa-trash  bigger-120"></i></a>-->
                    </td>
                </tr>
                <?php endforeach;?>
                <tr>
                    <td colspan="9">
                        <div id="page">
                            <div class=page_left style="float: left">当前第：<?php echo $page.'/'.ceil($count/10);?>页</div>
                            <div class=page_right style="float: right">
                                <?php
                                //echo $where;
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

</body>
</html>
<script type="text/javascript">

    jQuery(function($) {
    var colorbox_params = {
        reposition:true,
        scalePhotos:true,
        scrolling:false,
        previous:'<i class="fa fa-chevron-left"></i>',
        next:'<i class="fa fa-chevron-right"></i>',
        close:'&times;',
        current:'{current} of {total}',
        maxWidth:'100%',
        maxHeight:'100%',
        onOpen:function(){
            document.body.style.overflow = 'hidden';
        },
        onClosed:function(){
            document.body.style.overflow = 'auto';
        },
        onComplete:function(){
            $.colorbox.resize();
        }
    };

    $('.table-striped [data-rel="colorbox"]').colorbox(colorbox_params);
    $("#cboxLoadingGraphic").append("<i class='icon-spinner orange'></i>");

})
function member_del(obj,id){
        var pdf_id = $(obj).parents("tr").find(".pdf_id").text();

        var  url = "/images/editpdf";

        layer.confirm('确认要删除吗？',function(index){
            $.post(url,{pdf_id:pdf_id,mark:'del'},function(data){
                if(data==1){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                    window.location.href="/images/pdf";
                }
            })
        });
    }
</script>