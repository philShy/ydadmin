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
    <title>商品评论</title>
    <style>
        img{cursor:pointer;transition:all 0.6s;}
        .floors_portrait:hover{transform: scale(2.0);}
        .floors_info_portrait:hover{transform: scale(2.5);}
        .del{position:relative;top:3px;display:inline-block;width:19px;height:19px;background:url('/images/del.png') no-repeat 0px 0px;}
        /*.shenhe{display:inline-block;width:19px;height:19px;background:url('/images/shenhe.png') no-repeat 0px 0px;}*/
        .yes{position:relative;top:4px;display:inline-block;width:19px;height:19px;background:url('/images/icon_right_s.png') no-repeat 0px 0px;}
        .no{position:relative;top:4px;display:inline-block;width:19px;height:19px;background:url('/images/icon_error_s.png') no-repeat 0px 0px;}
        .zanwu{position:relative;top:12px;left:5px;display:inline-block;width:40px;height:40px;background:url('/images/cry.png') no-repeat 0px 0px;}
    </style>
</head>
<body>
<div class="page-content clearfix">
    <div class='floors' style='margin:30px auto;width:100%'>
        <div class='info'style="text-align:center; width:70px; border:1px solid #eee ;padding:5px; float:left">
            <div class='portrait'><img class='floors_portrait' style="width:50px;" src='<?php echo $floors_info['portrait']?>'?></div>
            <div class='name'></div>
        </div>
        <div class='comment' style='margin-left:30px;float:left;width:87%;'><b><?php echo $floors_info['buyer_message_one']?></b>

        </div>
        <div style="margin-right:30px;float:right;width:150px;"><?php echo $floors_info['create_time']?></div>
    </div>
    <table width=92% style="float:left;margin-top:50px;margin-left:50px; ">
        <!-- 1-->
        <?php if($floors_info['one_reply']):?>
                <tr>
                    <td valign="center" align='left' width=15%>
                        <div style="width:25px;padding:1px;display:inline-block;border:1px solid #ddd">
                            <img class='floors_info_portrait' style='width:20px;' src='<?php echo Yii::app()->request->hostInfo?>/images/yd.png'>
                        </div> <span style="color:#ccc">[商家回复]:</span>
                    </td>

                    <td align='left' width=80%>
                        <?php echo $floors_info['one_reply']?>
                    </td>

                    <td valign="bottom" align='center' style='font-size:10px;'>
                        <div style="width:140px;">
                            <?php echo $floors_info['one_reply_time']?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan=4 valign="middle" width=100% height=20px>
                        <div style="display:inline-block;width:100%;border:1px dotted #ddd;">
                        </div>
                    </td>
                </tr>
        <?php endif;?>
        <!-- 1结束-->
        <!-- 2-->
        <?php if($floors_info['buyer_message_two']):?>
                <tr>
                    <td valign="center" align='left' width=15%>
                        <div style="width:25px;padding:1px;display:inline-block;border:1px solid #ddd">
                            <img class='floors_info_portrait' style='width:20px;' src='<?php echo $floors_info['portrait']?>'>
                        </div> <span style="color:#ccc"><?php echo $floors_info['name']?>[追评]:</span>
                    </td>
                    <td align='left' width=80%><?php echo $floors_info['buyer_message_two']?></td>
                    <td valign="bottom" align='center' style='font-size:10px;'>
                        <div style="width:140px;">
                            <?php echo $floors_info['two_comment_time']?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan=4 valign="middle" width=100% height=20px>
                        <div style="display:inline-block;width:100%;border:1px dotted #ddd;">
                        </div>
                    </td>
                </tr>
        <?php endif;?>
        <!-- 2结束-->
        <!-- 3-->
        <?php if($floors_info['two_reply']):?>
                <tr>
                    <td valign="center" align='left' width=15%>
                        <div style="width:25px;padding:1px;display:inline-block;border:1px solid #ddd">
                            <img class='floors_info_portrait' style='width:20px;' src='<?php echo Yii::app()->request->hostInfo?>/images/yd.png'>
                        </div> <span style="color:#ccc">[商家回复]:</span>
                    </td>
                    <td align='left' width=80%><?php echo $floors_info['two_reply']?></td>
                    <td valign="bottom" align='center' style='font-size:10px;'>
                        <div style="width:140px;">
                            <?php echo $floors_info['two_comment_time']?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan=4 valign="middle" width=100% height=20px>
                        <div style="display:inline-block;width:100%;border:1px dotted #ddd;">
                        </div>
                    </td>
                </tr>
        <?php endif;?>
        <?php if(!$floors_info['one_reply']&&!$floors_info['two_reply']&&$floors_info['buyer_message_one']&&!$floors_info['buyer_message_two']):?>
            <tr>
                <td colspan=4 valign="middle" width=100% height=20px>
                    <textarea rows="4" style="width:99%"></textarea>
                    <p><input sign="1" class="tj" style="margin-top:10px;margin-left:10px" type="button" value="回复"></p>
                </td>

            </tr>
        <?php elseif(!$floors_info['one_reply']&&!$floors_info['two_reply']&&$floors_info['buyer_message_one']&&$floors_info['buyer_message_two']):?>
            <tr>
                <td colspan=4 valign="middle" width=100% height=20px>
                    <textarea rows="4" style="width:99%"></textarea>
                    <p><input sign="2" class="tj" style="margin-top:10px;margin-left:10px" type="button" value="回复"></p>
                </td>
            </tr>
        <?php elseif($floors_info['one_reply']&&$floors_info['buyer_message_two']&&$floors_info['buyer_message_one']):?>
            <?php if(!$floors_info['two_reply']):?>
            <tr>
                <td colspan=4 valign="middle" width=100% height=20px>
                    <textarea rows="4" style="width:99%"></textarea>
                    <p><input sign="2" class="tj" style="margin-top:10px;margin-left:10px" type="button" value="回复"></p>
                </td>
            </tr>
            <?php endif;?>
        <?php endif;?>
        <!-- 3结束-->
    </table>
</div>

</body>
</html>
<script>
    $(function(){
        var url = '/comment/comment_goods_info';
        $('.tj').click(function(){
            var sign = $(this).attr('sign');
            var $_this = $(this);
            var reply = $(this).parents('tr').find('textarea').val();
        $.post(url,{reply:reply,sign:sign,id:"<?php echo $floors_info['id']?>"},function (data){
                if(data == 1)
                {
                    layer.alert('回复成功！')
                    $_this.parents('table').append("<tr>\n" +
                        "                <td valign='center' align='left' width=15%>\n" +
                        "                <div style='width:25px;padding:1px;display:inline-block;border:1px solid #ddd'>\n" +
                        "                <img class='floors_info_portrait' style='width:20px;' src='<?php echo Yii::app()->request->hostInfo?>/images/yd.png'>\n" +
                        "                </div> <span style='color:#ccc'>[商家回复]:</span>\n" +
                        "                </td>\n" +
                        "                <td align='left' width=80%>"+reply+"</td>\n" +
                        "                <td valign='bottom' align='center' style='font-size:10px;'>\n" +
                        "                <div style='width:140px;'>刚刚</div>\n" +
                        "                </td>\n" +
                        "                </tr>\n" +
                        "                <tr>\n" +
                        "                <td colspan=4 valign='middle' width=100% height=20px>\n" +
                        "                <div style='display:inline-block;width:100%;border:1px dotted #ddd;'>\n" +
                        "                </div>\n" +
                        "                </td>\n" +
                        "                </tr>")
                    $_this.parents('tr').remove();
                }
            })
        })
    })

</script>



















