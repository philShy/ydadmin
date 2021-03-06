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
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <script src="/assets/laydate/laydate.js" type="text/javascript"></script>
    <title>管理权限 - 素材牛模板演示</title>
</head>
<style>
    #page .page_right a{text-decoration:none;display:inline-block;
        width:40px; height: 25px;font-size: 14px;color: #fff;background: #6fb3e0;
        margin-left: 3px;line-height: 25px;}
    #page .page_right a:hover{background: #2a8bcc}
</style>
<body>
<div class="margin clearfix">
    <div class="border clearfix">
       <span class="l_f">
        <a href="JavaScript:void(0)" id="Competence_add" class="btn btn-warning" > 商品上传权限</a>
       </span>

    </div>
    <div class="compete_list">
        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>管理员</th>
                <th>上传标识</th>
                <th>操作品牌</th>
                <th class="hidden-480">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($manageArr as $key=>$value):?>
                <tr>
                    <td><?php echo $value['id']?></td>
                    <td><?php echo $value['manager']?></td>
                    <td>
                        <?php
                            if($value['publish_goods_sign'] == 1)
                            {
                                echo '初次审核';
                            }elseif($value['publish_goods_sign'] == 2)
                            {
                                echo '二次审核';
                            }elseif($value['publish_goods_sign'] == '0')
                            {
                                echo '仅上传';
                            }
                        ?>
                    </td>
                    <td><?php echo $value['brand_id_str']?></td>
                    <td>
                        <a title="编辑"  href="/manage/edit_publish_goods_auth?id=<?php echo $value['id']?>"  class="btn btn-xs btn-info" ><i class="fa fa-edit bigger-120"></i></a>
                        <!-- <a title="删除" href="javascript:;"  onclick="Competence_del(this,'1')" class="btn btn-xs btn-warning" ><i class="fa fa-trash  bigger-120"></i></a>
                    -->
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
<script type="text/javascript">
    /*字数限制*/
    function checkLength(which) {
        var maxChars = 200; //
        if(which.value.length > maxChars){
            layer.open({
                icon:2,
                title:'提示框',
                content:'您出入的字数超多限制!',
            });
            // 超过限制的字数了就将 文本框中的内容按规定的字数 截取
            which.value = which.value.substring(0,maxChars);
            return false;
        }else{
            var curr = maxChars - which.value.length; //250 减去 当前输入的
            document.getElementById("sy").innerHTML = curr.toString();
            return true;
        }
    };
    //面包屑返回值
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);
    $('.Order_form ,#Competence_add').on('click', function(){
        var cname = $(this).attr("title");
        var cnames = parent.$('.Current_page').html();
        var herf = parent.$("#iframe").attr("src");
        parent.$('#parentIframe span').html(cname);
        parent.$('#parentIframe').css("display","inline-block");
        parent.$('.Current_page').attr("name",herf).css({"color":"#4c8fbd","cursor":"pointer"});
        //parent.$('.Current_page').html("<a href='javascript:void(0)' name="+herf+">" + cnames + "</a>");
        parent.layer.close(index);

    });
</script>