<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
</head>
<style>
    #selectFileBtn{background: #438eb9;border-radius: 3px;color:white ;margin-left: 5px;}
    a{text-decoration: none}
    .btn{margin-left: 10px;display: inline-block;background: #438eb9;border-radius: 2px;width:43px;color:#fff}
    .attachItem{width:180px;background: #ccc;float: left;border-radius: 3px;margin-left: 5px;margin-top: 5px;}
    .left{float:left}
    .right{float:right}
    .right a{display:block;margin-top:3px;width:16px;height:16px;overflow: hidden;text-indent:-9999px; background:url(/images/delete.png); }
    table tr:nth-child(odd){background:#eee;}
    table tr:hover{background:#eee;}
    .smt{background: #ffb752;border:1px solid #ffb752;border-radius: 3px;width:50px;height:30px;color:#fff;cursor: pointer}
</style>
<body>
<h3>修改商品pdf</h3>
<form action="/images/edit_pdf" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $result['id'];?>">
    <table width="70%" cellpadding="5" rules="all" cellspacing="0" bgcolor="#fff" style="border:1px solid #ddd">
        <tr height="30px;">
            <td align="right">商品名称</td>
            <td><?php echo $result['name'];?></td>
        </tr>
        <tr>
            <td align="right">商品pdf操作</td>
            <td>
                <ul style="margin:0;padding:0;">
                    <?php foreach ( $result['pdf'] as $pdf ):?>
                        <li style="width:120px;height:130px;float:left;list-style:none;">
                            <div align="center" style="width:115px;height:80px;border:1px solid #ddd;margin-bottom:3px;"><img style="width:20px;margin: 10px 5px -10px 0" src="/images/pdf_logo.png"><div style="width:100px;overflow: hidden"><?php echo $pdf['pdf_name'];?></div></div>
                            <div>
                                <a href="javascript:void (0)" class="btn del" sort=<?php echo $pdf['sort'];?> pdfid = <?php echo $pdf['pdf_id'];?>>&nbsp;删除</a>
                                <?php if($pdf['sort']!=1):?>
                                    <a href='javascript:void (0)' class='btn moveup' sort=<?php echo $pdf['sort'];?> pdfid = <?php echo $pdf['pdf_id'];?>>&nbsp;上移</a>
                                <?php endif;?>
                            </div>
                        </li>
                    <?php endforeach;?>
                </ul>
            </td>
        </tr>
        <tr>
            <td align="right">商品pdf添加</td>
            <td>
                <a href="javascript:void(0)" id="selectFileBtn">添加pdf</a>
                <div id="attachList" class="clear"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input class="smt" type="submit"  value="提交"/></td>
        </tr>
    </table>
</form>
<script src="/js/jquery-1.9.1.min.js"></script>
<script src="/assets/layer/layer.js" type="text/javascript" ></script>
<script src="/assets/laydate/laydate.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function(){
        $('.del').click(function(){
            var url ='/images/edit_pdf';
            var id = <?php echo $result['id']?>;
            var pdfid  = $(this).attr('pdfid');
            var sort  = $(this).attr('sort');
            layer.confirm("您确认要删除吗？添加一次不容易",function(){
                $.post(url,{sign:'del',id:id,pdfid:pdfid,sort:sort},function(data){
                    if(data){
                        window.location.href = "/images/edit_pdf?id="+id;
                    }
                })
            })
        })
        $('.moveup').click(function(){
            var url ='/images/edit_pdf';
            var id = <?php echo $result['id']?>;
            var pdfid  = $(this).attr('pdfid');
            var sort  = $(this).attr('sort');
            layer.confirm("您确认要上移吗？",function(){
                $.post(url,{sign:'moveup',id:id,pdfid:pdfid,sort:sort},function(data){
                    if(data){
                        window.location.href = "/images/edit_pdf?id="+id;
                    }
                })
            })
        })
    })
    function moveUpImg(){
        window.location='doAdminAction.php?act=moveUpImg&id='+id+'&proId='+proId;
    }
    $(document).ready(function(){
        $("#selectFileBtn").click(function(){
            $fileField = $('<input type="file" name="proImg[]"/>');
            $fileField.hide();
            $("#attachList").append($fileField);
            $fileField.trigger("click");
            $fileField.change(function(){
                $path = $(this).val();
                $filename = $path.substring($path.lastIndexOf("\\")+1);
                $attachItem = $('<div class="attachItem"><div class="left">a.gif</div><div class="right"><a href="#" title="删除附件">删除</a></div></div>');
                $attachItem.find(".left").html($filename);
                $("#attachList").append($attachItem);
            });
        });
        $("#attachList").on('click','.attachItem a',function(obj,i){
            $(this).parents('.attachItem').prev('input').remove();
            $(this).parents('.attachItem').remove();
        });
    });
</script>
</body>
</html>