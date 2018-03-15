<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
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
    <title>品牌管理 - 素材牛模板演示</title>
</head>

<body>
<div class="page-content clearfix">
    <div class="sort_adsadd_style">
    <div class="search_style">
            <form action="/images/image_adv" method="post">
            <ul class="search_content clearfix">
    	<li><label class="l_f" style="margin-left: 20px;">所属图片分类</label>&nbsp;
        <select name="imagesclass" style="width:255px">
                            <option value="0">---选择分别---</option>
                           <?php foreach($results as $k=>$v): ?>
      						<option value="<?php echo $v[id]?>"><?php echo $v[name]?></option>
    						<?php endforeach;?>
         </select></li>
         <li style="width:90px;"><input type="submit" value="查询" class="btn_search   "></li></ul>
         </form>
         </div>
        <div class="border clearfix">
       <span class="l_f">
      <a href="/images/addadv" title="添加广告" class="btn btn-warning Order_form"><i class="icon-plus"></i>添加广告</a>

       
       <a href="javascript:ovid()" onClick="javascript :history.back(-1);" class="btn btn-info"><i class="fa fa-reply"></i> 返回上一步</a>
       </span>
         
       <span class="r_f">共：<b><?php echo $count;?></b>个广告</span>
     
       </div>
       <!--列表样式-->
       <div class="sort_Ads_list">
       <table class="table table-striped table-bordered table-hover" id="sample-table">
       		<thead>
       				<tr>
       				<th style="width:70px"><label><input type="checkbox" class="ace">id</label></th>
       				
       			
       				<th >图片类型</th>
       				<th >广告名称</th>
       				<th width="200px">商品名称</th>
       				<th width="200px">文章名称</th>
       				<th width="200px">广告地址</th>
       				<th width="110px">图片</th>	 
       				<th>排序</th>

       				<th width="180">加入时间</th>
       				<th width="70">状态</th>
       				<th width="200">操作</th>
       								</tr>
       								</thead>
       								<tbody>
       		   <?php foreach($result as $key=>$value):?>
                    <tr>
                        <td style="display: none"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
       					<td class="adv_id"><?php echo $value['id']?></td>
                        <td><?php echo $value['name']?></td>
                        <td><?php echo $value['names']?></td>
                        <td><?php echo $value['title']?></td>
                        <td><?php echo $value['titles']?></td>
                        <td><a href="<?php echo $value['adressurl']?>"><?php echo $value['adressurl']?></td></a>
                        <td style="display: none"></td>
                        <td style="text-align: left">
                        <?php 
                        echo "<image src='$value[images_url]'style='width:60px;height:60px;margin-left:15px;'>"; ?></td>
                       <td ><?php echo $value['sort']?></td>
                        <td style="display: none"></td>
                        <td style="display: none"></td>
                        <td style="display: none"></td>
                        <td style="display: none"><span class="label label-success radius">显示</span></td>
                        <td><?php echo $value['create_time']?></td>
                        <td class="td-status" width='80px'><?php if($value['is_delete'] == 0){echo "<span width='80px' >已启用</span>";}else{echo "<span width='80px' >已停用</span>";} ?></td>
                        <td class="td-manage">
                            <?php if($value['is_delete'] == 0){echo "<a href='javascript:;' title='停用' class='btn btn-xs btn-success jia'><i class='icon-ok bigger-120'></i></a>";}else{echo "<a href='javascript:;' title='启用' class='btn btn-xs btn-default jia'><i class='icon-ok bigger-120'></i></a>";} ?>
                            
                            <a title="编辑"  href="../images/editadv?id=<?php echo $value['id']?>"  class="btn btn-xs btn-info" ><i class="icon-edit bigger-120"></i></a>
                            <a title="删除" href="javascript:;"  onclick="member_del(this,'1')" class="btn btn-xs btn-warning" ><i class="icon-trash  bigger-120"></i></a>
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

    jQuery(function($) {
        $('.btn_search').click(function(){
            $('#searchform').submit()
        })

        var oTable1 = $('#sample-table').dataTable( {
            "aaSorting": [[ 1, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[0,1,3,4,5,6,8,9]}// 制定列不参与排序
            ] } );


    });

    //面包屑返回值
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);
    $('.Order_form ,.brond_name').on('click', function(){
        var cname = $(this).attr("title");
        var cnames = parent.$('.Current_page').html();
        var herf = parent.$("#iframe").attr("src");
        parent.$('#parentIframe span').html(cname);
        parent.$('#parentIframe').css("display","inline-block");
        parent.$('.Current_page').attr("name",herf).css({"color":"#4c8fbd","cursor":"pointer"});
        //parent.$('.Current_page').html("<a href='javascript:void(0)' name="+herf+">" + cnames + "</a>");
        parent.layer.close(index);

    });
    function generateOrders(id){
        window.location.href = "Images_adv_detailed.html?="+id;
    };
    /*广告-查看*/
    function member_show(title,url,id,w,h){
        layer_show(title,url,w,h);
    }

    $('.td-manage .jia').click(function(){
        var title = $(this).parent("td").parent("tr").find(".td-status").text();
        var adv_id = $(this).parent("td").parent("tr").find(".adv_id").text();
        var  url = "/images/image_adv";
        var obj = $(this).parent('td');
        
        if(title == '已停用'){
            
            layer.confirm('确认要启用吗？',function(index){
                $.post(url,{is_delete:0,adv_id:adv_id},function(data){
                    if(data){
                        //$(obj).parent("tr").find(".td-status span").attr("class","label label-success radius");
                        $(obj).find('.jia').attr('class','btn btn-xs btn-success')
                        $(obj).parent("tr").find(".td-status").text('已启用');
                        layer.msg('已启用!',{icon: 6,time:1000});
                        window.location.href="/images/image_adv";
                    }
                })
            });
        }else if(title == '已启用'){
            layer.confirm('确认要停用吗？',function(index){
                $.post(url,{is_delete:1,adv_id:adv_id},function(data){
                    if(data){
                        //$(obj).parent("tr").find(".td-status span").attr("class","label label-default radius");
                        $(obj).find('.jia').attr('class','btn btn-xs ')
                        $(obj).parent("tr").find(".td-status").text('已停用');
                        layer.msg('已停用!',{icon: 5,time:1000});
                        window.location.href="/images/image_adv";
                    }
                })
            });
        }
    })

    /*广告-删除*/

    function member_del(obj,id){
        var adv_id = $(obj).parents("tr").find(".adv_id").text();
        var  url = "/images/editadv";
        layer.confirm('确认要删除吗？',function(index){
            $.post(url,{adv_id:adv_id,mark:'del'},function(data){
                if(data==1){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                    window.location.href="/images/image_adv";
                }
            })
        });
    }



</script>
<script type="text/javascript">
    require.config({
        paths: {
            echarts: './assets/dist'
        }
    });
    require(
        [
            'echarts',
            'echarts/chart/pie',   // 按需加载所需图表，如需动态类型切换功能，别忘了同时加载相应图表
            'echarts/chart/funnel'
        ],
        function (ec) {
            var myChart = ec.init(document.getElementById('main'));

            option = {
                title : {
                    text: '国内国外品牌比例',
                    subtext: '',
                    x:'center'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient : 'vertical',
                    x : 'left',
                    data:['国内品牌','国外品牌']
                },
                toolbox: {
                    show : false,
                    feature : {
                        mark : {show: false},
                        dataView : {show: false, readOnly: false},
                        magicType : {
                            show: true,
                            type: ['pie', 'funnel'],
                            option: {
                                funnel: {
                                    x: '25%',
                                    width: '50%',
                                    funnelAlign: 'left',
                                    max: 545
                                }
                            }
                        },
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                calculable : true,
                series : [
                    {
                        name:'品牌数量',
                        type:'pie',
                        radius : '55%',
                        center: ['50%', '60%'],
                        data:[
                            {value:335, name:'国内品牌'},
                            {value:210, name:'国外品牌'},

                        ]
                    }
                ]
            };
            myChart.setOption(option);
        }
    );
</script>
