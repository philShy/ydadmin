<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/typeahead-bs2.min.js"></script>
        <script src="/assets/js/jquery.dataTables.min.js"></script>
        <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
        <script src="/assets/layer/layer.js" type="text/javascript" ></script>
        <script src="/js/H-ui.js" type="text/javascript"></script>
        <script src="/ js/displayPart.js" type="text/javascript"></script>
        <title>商品类型</title>
    </head>
</head>
<style>
    .attr_value{width:160px !important;}
    ul{list-style:none}
    .btn{width:60px;height:30px;background:red;border:none;border-radius:3px;margin-left:50px;}
    .attr_head {margin-left:33px !important;}
    .aaa a{color:red; text-decoration: none;}
    .aaa a:hover{color:#DE3163;}
    #attr span{display:inline-block;width:180px;}
    #attr input{width:80px}
    #attr a{color:red; text-decoration: none;}
    #attr a:hover{color:#DE3163;}
    .btn{margin-left:20px;width:60px;height:30px;background:#6fb3e0;border:none;color:#fff;border-radius:3px;cursor:pointer}
    table {border:1px solid #ccc}
    table tr:nth-child(odd){background:#F4F4F4;}
    table div{margin-left:20px;}
</style>
<body>
<div style='width:120px;background:#ffb752;border-radius:3px;padding:5px;margin-left:10px;text-align:center;color:white;font-size:16px'>编辑商品类型</div>
<div style='margin:10px 0 0 10px;'>
    <form action="/manage/edit_publish_goods_auth" method="post" id="iform">
        <input type="hidden" name="id" value="<?php echo $manageOneArr['id']?>">
        <table width=850px; height=500px cellspacing=0 cellpadding=0 rules="all" >
            <tr>
                <td width="20%"><div>商品上传人</div></td>
                <td width="80%"><div><input type='text' name="manager" value="<?php echo $manageOneArr['manager']?>"/></div></td>
            </tr>
            <tr>
                <td width="20%"><div>上传标识</div></td>
                <td width="80%">
                    <div>
                        <select name="publish_goods_sign">
                            <option value="">选择标识</option>
                            <option value="1" <?php if($manageOneArr['publish_goods_sign']=='1'){echo 'selected';}?>>初次审核</option>
                            <option value="2" <?php if($manageOneArr['publish_goods_sign']=='2'){echo 'selected';}?>>二次审核</option>
                            <option value="0" <?php if($manageOneArr['publish_goods_sign']=='0'){echo 'selected';}?>>仅上传</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td><div>操作品牌</div></td>
                <?php if(!empty($brandArr)):?>
                    <td><div>
                            <?php foreach($brandArr as $k=>$v):?>
                                    <label>
                                        <?php if($brand_id_arr):?>
                                        <input name="brand_id[]" type="checkbox" <?php if(in_array($v['id'],$brand_id_arr)){echo 'checked';}?> value="<?php echo $v['id']?>" />
                                        <?php echo $v['brandname']?>
                                        <?php endif;?>
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php endforeach;?>
                        </div>
                    </td>
                <?php endif;?>
            </tr>
            <tr>
                <td colspan='2'><input class='btn' type='button' onclick="getCheckAdIds()" value="提交"></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
<script type="text/javascript">
    function getCheckAdIds(){
        $('form').submit();
    }

</script>





















