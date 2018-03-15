<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <script src="/js/jquery-1.9.1.min.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <title></title>
</head>
<style>
    *{font-size:14px;}
    a{ color:black; text-decoration:none;}
    a:hover{ color:#c00; text-decoration:underline;}
    li{list-style: none}
    #main{width:960px; float: left;}
    #top{width:960px;float: left;}
    #top_left{width:302px;float: left;}
    #top_left_zhu{float: left;width:300px;height:300px;border:1px solid #ddd;}
    #top_left_zhu img{width:300px;height:300px;float:left;}
    #top_left_fu{width:306px;height:65px;clear: left;overflow: hidden}
    #top_left_fu li{width:54px;height:54px;border:1px solid #ddd;float: left;margin-top: 5px;margin-left: 5px}
    #top_left_fu img{width:50px;height:50px;margin-left:2px;margin-top: 2px;}
    #top_right{float: left;width:600px;margin-left: 20px;}
    .top_right{height:30px;}
    #floor{width:920px;clear: both}
    #floor h4{background: #eee;height:35px;line-height: 35px;}
    #floor .ins{width:880px;padding-left:20px;}
    .bf{display:inline-block;width:100px;}
    dl ul{position: relative;top:-40px;}
    .clearfix{height: 25px;}
    .val{display:inline-block;border: 1px solid #ccc;padding: 3px;margin-left: 3px;margin-bottom: 3px;}
    .sys_spec_text li.selected a{ border:2px solid #e4393c; padding:0 5px;}
    .sys_spec_text li.selected i{ display:block;}
    .selecte a{border:2px solid #e4393c; padding:0 5px;}
    .ll{border-bottom: 1px solid #ccc;}
    .l_l{display: inline-block;width: 220px}
    .l_r{display: inline-block;width: 600px}
</style>
<body>
<div id="main">
    <div id="top">
        <div id="top_left">
            <div id="top_left_zhu">
                <img style="" src=<?php echo $model_pic[0]['image_url']?>>
            </div>
            <ul id="top_left_fu" style="margin-left: -45px;">
                <?php foreach ($model_pic as $v):?>
                    <li><img src="<?php echo $v['image_url']?>"></li>
                <?php endforeach;?>
            </ul>
        </div>
        <div id="top_right">
            <div class="top_right"><span class="bf">标题</span><?php echo $modelOneArr['title']?></div>
            <div class="top_right"><span class="bf">品牌</span><span><?php echo (CProduct::searchBrandbyid($modelOneArr['brand'])['brandname'])?></span></div>
            <div class="top_right"><span class="bf">商品型号</span><?php echo $modelOneArr['name']?></div>
            <div class="top_right"><span class="bf">商品类别</span><span><?php echo (CProduct::search_type_byid($modelOneArr['type_id'])['type'])?></span></div>
            <div class="top_right"><span class="bf">商品价格</span><b class="sys_item_price1"><?php echo $firstSkuArr['price1']?></b></div>
            <div class="top_right"><span class="bf">商品库存</span><b class="sys_item_stock1"><?php echo $firstSkuArr['stock1']?></b></div>
            <div class="top_right"><span class="bf">商品子型号</span><?php echo $modelOneArr['model_number']?></div>

            <?php foreach ($skuArrCombination as $k=>$v):?>
                <dl class="clearfix iteminfo_parameter sys_item_specpara" data-sid="<?php echo $k?>">
                    <dt><?php echo $v['name']?></dt>
                    <dd>
                        <ul class="sys_spec_text">
                            <?php foreach ($v['value'] as $kk=>$vv):?>
                                <li class="val" data-aid="<?php echo $vv['id']?>"><a href="javascript:;" title="<?php echo $vv['name']?>"><?php echo $vv['name']?></a><i></i></li>
                            <?php endforeach;?>
                        </ul>
                    </dd>
                </dl>
            <?php endforeach;?>
        </div>
    </div>
    <div id="floor">
        <div class="floor introduce">
            <h4>&nbsp;&nbsp;商品介绍</h4>
            <div class="ins"><?php echo $modelOneArr['detail_introduce'] ?></div>
        </div>
        <div class="floor gui">
            <h4>&nbsp;&nbsp;规格与包装</h4>
            <div class="ins">
                <?php foreach ($attrArr as $k=>$v):?>
                <div class="ll">
                    <div class="l_l">
                        <?php echo $v['name']?>
                    </div>
                    <div class="l_r">
                        <ul>
                            <?php foreach ($v['value'] as $kk=>$vv):?>
                            <li><?php echo $vv['name']?></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        <div class="floor manual">
            <h4>&nbsp;&nbsp;使用手册</h4>
            <div class="ins"><?php echo $modelOneArr['manual'] ?></div>
        </div>
        <div class="floor function">
            <h4>&nbsp;&nbsp;相关知识</h4>
            <div class="ins"><?php echo $modelOneArr['function'] ?></div>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
    var model_sku_json = <?php echo $model_sku_json?>;
    var firstSkuArr = <?php echo $firstV?>;
    $(function(){
//商品规格选择
        $(function(){
           $('.val').each(function(){
                var attr_v_id = String($(this).attr('data-aid'));
                var result = $.inArray(attr_v_id, firstSkuArr)
                if(result>-1)
                {
                    $(this).addClass('selecte')
                }
            })
            $(".sys_item_specpara").each(function(){
                var i=$(this);
                var p=i.find("ul>li");
                p.click(function(){
                    $('.val').removeClass("selecte")
                    if(!!$(this).hasClass("selected")){
                        $(this).removeClass("selected");
                        i.removeAttr("data-attrval");
                    }else{
                        $(this).addClass("selected").siblings("li").removeClass("selected");
                        i.attr("data-attrval",$(this).attr("data-aid"))
                    }
                    getattrprice() //输出价格
                })
            })

            //获取对应属性的价格
            function getattrprice(){
                var defaultstats=true;
                var _val='';
                var _resp={
                    stock1:".sys_item_stock1",
                    price:".sys_item_price1"
                }  //输出对应的class
                $(".sys_item_specpara").each(function(){
                    var i=$(this);
                    var v=i.attr("data-attrval");
                    if(!v){
                        defaultstats=false;
                    }else{
                        _val+=_val!=""?"_":"";
                        _val+=v;
                    }
                })
                if(!!defaultstats){
                    _stock1=model_sku_json['sys_attrprice'][_val]['stock1'];
                    _price=model_sku_json['sys_attrprice'][_val]['price1'];
                }else{
                    _stock1=model_sku_json['stock1'];
                    _price=model_sku_json['price1'];
                }
                //输出价格
                console.log(_price);
                $(_resp.stock1).text(_stock1);  ///其中的math.round为截取小数点位数
                $(_resp.price).text(_price);
            }
        })
    })
</script>
