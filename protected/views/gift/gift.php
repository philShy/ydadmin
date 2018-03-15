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
    <title>积分礼品</title>
</head>

<body>
<div class="margin clearfix">
    <div class="sort_style">
        <div class="border clearfix">
       <span class="l_f">
        <a href="javascript:ovid()"id="add_page" class="btn btn-warning" onclick="add_article_sort()"><i class="fa fa-plus"></i> 添加礼品</a>
       </span>
            <span class="r_f">共：<b><?php echo $count;?></b>个礼品</span>
        </div>
        <!--分类类表-->
        <div class="article_sort_list">
            <table class="table table-striped table-bordered table-hover" id="sample-table">
                <thead>
                <tr>
                    <th style="display: none" width="25"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
                    <th width="80px">ID</th>
                    <th width="150px">礼品名称</th>
                    <th style="display: " width="150px">礼品图片</th>
                    <th style="display: " width="150px">礼品积分</th>
                    <th style="display: " width="150px">礼品库存</th>
                    <th style="display: none" width="150px">作者头像</th>
                    <th width="150px">添加时间</th>
                    <th width="150px">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($gift_arr as $key=>$value):?>
                <tr>
                    <td style="display: none"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
                    <td><?php echo $value['id']?></td>
                    <td style="display: "><?php echo $value['gift']?></td>
                    <td><img src="<?php echo $value['img_url']?>" width=100px></td>
                   
                    <td style="display: "><?php echo $value['score']?></td>
                    <td style="display: "><?php echo $value['stock']?></td>
                     <td style="display: none"><?php echo $value['img']?></td>
                    <td><?php echo $value['create_time']?></td>
                    <td class="td-manage">
                        <a title="编辑" onclick="member_edit('<?php echo $value['id']?>')" href="javascript:;"  class="btn btn-xs btn-info" ><i class="fa fa-edit bigger-120"></i></a>
                        <a title="删除" href="javascript:;"  onclick="member_del(this,'<?php echo $value['id']?>')" class="btn btn-xs btn-danger" ><i class="fa fa-trash  bigger-120"></i></a>
                    </td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--添加文章分类图层-->
<div id="addsort_style" style="display:none" class="article_style">
    <div class="add_content" id="form-article-add">
    <form id="iform" method="post" action="/gift/gift" enctype="multipart/form-data">
        <ul> 
            <input name="id" type="hidden" class="gift-id">
            <li class="clearfix Mandatory"><label class="label_name"><i>*</i>礼品名称</label>
                <span class="formControls w_txt"><input name="gift-name" type="text" id="form-field-1" class="col-xs-7 col-sm-5  gift-name"></span>
            </li>
            <li class="clearfix Mandatory"><label class="label_name"><i>*</i>礼品积分</label>
                <span class="formControls w_txt"><input name="gift-score" type="text" id="form-field-1" class="col-xs-7 col-sm-5  gift-score"></span>
            </li>
            <li class="clearfix Mandatory"><label class="label_name"><i>*</i>礼品库存</label>
                <span class="formControls w_txt"><input name="gift-stock" type="text" id="form-field-1" class="col-xs-7 col-sm-5  gift-stock"></span>
            </li>
            <li class="clearfix"><label class="label_name"><i>*</i>上传头像</label>
                <span><input style="margin-left:110px;" name="portrait" type="file"></span>
            </li>
            
        </ul>
        </form>
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
                {"orderable":false,"aTargets":[0,2,3,4,5,6,8,]}// 制定列不参与排序
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
    /**添加礼品**/
    function add_article_sort(index){
        layer.open({
            type: 1,
            title: '添加礼品',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['600px' , ''],
            content:$('#addsort_style'),
            btn:['提交','取消'],
            yes:function(index,layero){
                var num=0;
                var str="";
                $(".Mandatory input[type$='text']").each(function(n){
                    if($(this).val()=="")
                    {
                        layer.alert(str+=""+$(this).attr("name")+"不能为空！\r\n",{
                            title: '提示框',
                            icon:0,
                        });
                        num++;
                        return false;
                    }
                });
                if(num>0){  return false;}
                else{
                    $("#iform").submit();
                   
                }
            }
        })
    }
    //编辑礼品
    function member_edit(iid){
        var url = '/gift/gift';
        if(iid){
            $.post(url,{gift_id:iid},function(data){
                var dataObj=eval("("+data+")");
                if(data){
                	$('.gift-id').val(dataObj['id']);
                    $('.gift-name').val(dataObj['name']);
                    $('.gift-score').val(dataObj['score']);
                    $('.gift-stock').val(dataObj['stock']);
                }
            })
        }
        layer.open({
            type: 1,
            title: '编辑礼品',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['600px' , ''],
            content:$('#addsort_style'),
            btn:['提交','取消'],
            yes:function(index,layero){
                var num=0;
                var str="";
                $(".Mandatory input[type$='text']").each(function(n){
                    if($(this).val()=="")
                    {
                        layer.alert(str+=""+$(this).attr("name")+"不能为空！\r\n",{
                            title: '提示框',
                            icon:0,
                        });
                        num++;
                        return false;
                    }
                });
                if(num>0){  return false;}
                else{
                    
                	$("#iform").submit();
                  
                }
            }
        })
    }
    /*文章-删除*/
    function member_del(obj,id){
        var url='/gift/gift'
        layer.confirm('确认要删除吗？',{icon:0,},function(index){
            $.ajax({
                type:'POST',
                url:url,
                data:{gift_id:id,is_delete:1},
                dataType: "json",
                success:function(data){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }
            })
        });
    }
</script>
