<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css"/>
    <link rel="stylesheet" href="../assets/css/ace.min.css" />
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css" />
    <link href="../Widget/icheck/icheck.css" rel="stylesheet" type="text/css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="../assets/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="../assets/css/ace-ie.min.css" />
    <![endif]-->
    <script src="../js/jquery-1.9.1.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/typeahead-bs2.min.js"></script>

    <!-- page specific plugin scripts -->
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/jquery.dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="../js/H-ui.js"></script>
    <script type="text/javascript" src="../js/H-ui.admin.js"></script>
    <script src="../assets/layer/layer.js" type="text/javascript" ></script>
    <script src="../assets/laydate/laydate.js" type="text/javascript"></script>
    <script src="../assets/dist/echarts.js"></script>
    <script src="../js/lrtk.js" type="text/javascript"></script>
    <title>首页管理 - 素材牛模板演示</title>
</head>

<body>
<span class="l_f">



       </span>
<!--楼层列表-->
      <div class="table_menu_list" style="width:95% !important;margin:0 auto">
             <div class="border clearfix">
			       <span class="l_f">
			       		<a href="/product/addlayout" title="添加首页分类" class="btn btn-warning Order_form"><i class="icon-plus"></i>添加首页分类</a>
			        	<a href="javascript:ovid()" style="display: none" class="btn btn-danger"><i class="fa fa-trash"></i> 批量删除</a>
			        	<a href="javascript:ovid()" onclick="javascript :history.back(-1);" class="btn btn-info"><i class="fa fa-reply"></i> 返回上一步</a>
			       </span>
            	   <span class="r_f">共：<b></b>楼</span>
        	 </div>
          <table class="table table-striped table-bordered table-hover" id="sample-table" style="margin: auto;width:1200px">
               <thead>
                    <tr>

                        <th width="1%">ID</th>
                        <th width="17%">一级分类</th>
                        <th width="17%">二级分类</th>
                        <th width="">推荐商品</th>
                        <th width="11%">推荐品牌</th>
                        <th width="%">新品</th>
                        <th width="11%">广告</th>
                        <th width="1%">排序</th>
                        <th width="11%">操作</th>

                    </tr>
              </thead>
                    <tbody>
                    	 <?php foreach($layout as $key=>$value):?>

                    <tr>

                        <td ><?php echo $value['id']?></td>
                        <td ><?php $aa= json_decode($value['category']); echo $aa->name;?></td>
                        <td ><?php $bb= json_decode($value['category'],true); $i=1;foreach ($bb['data'] as $keys=>$values){ echo $i.'.'.$values['name'].'</br>';$i++;}  ?></td>
                        <td ><?php $goods=json_decode($value['goods'],true) ;$a=1;foreach($goods as $k=>$v){echo $a.','.$v['name'].'</br>';$a++;}?></td>
                        <td ><?php $goods=json_decode($value['brand'],true) ;$a=1;foreach($goods as $kw=>$vw){echo $a.','.$vw['brandname'].'</br>';$a++;}?></td>
                        <td ><?php $goods=json_decode($value['goods_advert'],true) ;$a=1;foreach($goods as $kwt=>$vwt){echo $a.','.$vwt['name'].'</br>';$a++;}?></td>
                        <td ><?php $goods=json_decode($value['advert'],true) ;$a=1;foreach($goods as $kwt=>$vwt){echo "<img style='width:40px;height:40px;float:left'src='".$vwt['images_url']."'></img>";$a++;}?></td>
                        <td ><?php echo $value['sort']?></td>
                        <td	class="td-manage"><?php if($value['is_delete'] == 0):?>
                            <a onclick="member_stop(this,'<?php echo $value['id']?>')"  href="javascript:;" title="停用"  class="btn btn-xs btn-success"><i class="icon-ok bigger-120"></i></a>
                            <?php elseif($value['is_delete'] == 1):?>
                            <a style="text-decoration:none" class="btn btn-xs " onclick="member_start(this,'<?php echo $value['id']?>')" href="javascript:;" title="启用"><i class="icon-ok bigger-120"></i></a>
                            <?php endif;?>
                        	<a title="编辑" href="/product/editlayout?layoutid=<?php echo $value['id']?>"  class="btn btn-xs btn-info" ><i class="icon-edit bigger-120"></i></a>
                       <!-- <a title="删除" href="javascript:;"  onclick="member_del(this,'<?php echo $value['id']?>')" class="btn btn-xs btn-warning" ><i class="icon-trash  bigger-120"></i></a>-->
                        </td>
                   </tr>


                    	 <?php endforeach;?>

                    </tbody>
                </table>
            </div>
   <script>


    /*停用*/
    function member_stop(obj,id){
        var url = "/product/layout";
        var layout_id = id;
        $_id=id;
        layer.confirm('确认要停用吗？',function(index){
            $.ajax({
                type: "POST",
                url: url,
                data: {layout_id:layout_id,is_delete:1},
                dataType: "json",
                success: function(data){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs " onClick="member_start(this,$_id)" href="javascript:;" title="启用"><i class="icon-ok bigger-120"></i></a>');
                    $(obj).remove();

                    layer.msg('已停用!',{icon: 5,time:1000});

                }
            });
        });
    }

    /*启用*/
    function member_start(obj,id){
        var url = "/product/layout";
        var layout_id = id;
        $_id=id;
        layer.confirm('确认要启用吗？',function(index){
            $.ajax({
                type: "POST",
                url: url,
                data: {layout_id:layout_id,is_delete:'sure'},
                dataType: "json",
                success: function(data){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs btn-success" onClick="member_stop(this,$_id)" href="javascript:;" title="停用"><i class="icon-ok bigger-120"></i></a>');
                    $(obj).remove();

                    layer.msg('已启用!',{icon: 6,time:1000});
                }
            });
        });
    }


    /*删除*/
    function member_del(obj,id){
        var url = "/product/layout";
        var layout_id= id;
        $_id=id;
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: "POST",
                url: url,
                data: {layout_id:layout_id,state:1},
                dataType: "json",
                success: function(data){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }
            });
        });
    }

</script>

</body>
</html>
