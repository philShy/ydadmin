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
    <script src="/js/H-ui.js" type="text/javascript"></script>
    <title>商品类型</title>
</head>
<style>
.aaa a{color:red; text-decoration: none;}
.aaa a:hover{color:#DE3163;}
	#attr span{display:inline-block;margin-left:40px;width:150px;}
	#attr input{width:110px}
	#attr a{color:red; text-decoration: none;}
	#attr a:hover{color:#DE3163;}
</style>
<body>
<div class="margin clearfix">
    <div class="sort_style">
        <div class="border clearfix">
       <span class="l_f">
        <a href="/product/addtype" id="add_page" class="btn btn-warning" "><i class="fa fa-plus"></i> 添加商品类型</a>
       </span>
            <span class="r_f">共：<b>5</b>分类</span>
        <!--分类类表-->
        <div class="article_sort_list">
            <table class="table table-striped table-bordered table-hover" id="sample-table">
                <thead>
                <tr>
                    <th style="display: none" width="25"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
                    <th width="80px">ID</th>
                    <th width="80px">排序</th>
                    <th width="150px">商品类型名称</th>
                    <th width="">规格</th>
                    <th width="150px">添加时间</th>
                    <th width="80px">状态</th>
                    <th width="150px">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($type_arr as $key=>$value):?>
                <tr>
                    <td style="display: none"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
                    <td><?php echo $value['id']?></td>
                    <td><?php echo $value['sort']?></td>
                    <td><?php echo $value['type']?></td>
                    <td class="displayPart" displayLength="60"><?php echo $value['property']?></td>
                    <td><?php echo $value['create_time']?></td>
                    <td><?php echo $value['is_delete']?></td>
                    <td class="td-manage">
                        <a title="编辑" href="/product/edittype?id=<?php echo $value['id']?>"  class="btn btn-xs btn-info" ><i class="fa fa-edit bigger-120"></i></a>
                        <a title="删除" href="javascript:;"  onclick="member_del(this,'<?php echo $value['id']?>')" class="btn btn-xs btn-danger" ><i class="fa fa-trash  bigger-120"></i></a>
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
	
    $(function() {
        var oTable1 = $('#sample-table').dataTable( {
            "aaSorting": [[ 1, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[0,2,3,4,6,7,]}// 制定列不参与排序
            ]});
        $('table th input:checkbox').on('click' , function(){
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function(){
                    this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
                });
        });
    })
    
    /*文章-删除*/
    function member_del(obj,id){
        var url='/product/type'
        layer.confirm('确认要删除吗？',{icon:0,},function(index){
            $.ajax({
                type:'POST',
                url:url,
                data:{id:id,is_delete:1},
                dataType: "json",
                success:function(data){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }
            })
        });
    }
</script>
