<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/js/html5.js"></script>
    <script type="text/javascript" src="/js/respond.min.js"></script>
    <script type="text/javascript" src="/js/PIE_IE678.js"></script>
    <![endif]-->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css"/>
    <link href="/assets/css/codemirror.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/Widget/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <link href="/Widget/icheck/icheck.css" rel="stylesheet" type="text/css" />
    <link href="/Widget/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />
    <title>修改商品</title>
</head>
<style>

    #contact_goods li{background:#ddd;margin-left:80px;padding-left:10px;width:65%}
    #multi-goods{margin-left:65px;display:none}
    #multi-goods-sku{margin-left:65px;display:none}
    #omulti-goods{z-index:999;}
    #jiji{width:500px;}
    .jij{margin-top:3px;}
    a {color:#0072D2; text-decoration:none !important;}
    .addrv{margin-left:10px;}
    #attr{float:left;width:80%;display:none;margin-top:10px;}
    .attr_all{width:100%;border:1px solid #ccc;border-top:none;}
    .attr_left{float:left;width:20%;}
    .attr_right{float:right;width:80%;border-left:1px solid #ccc;}
    .attr_right span {display:inline-block;margin-left:10px}
    #stock{width:100%;height:;}
    .table-sku-stock{border:1px solid #eee;text-align:center}
    .table-sku-stock tr  td{ border:1px #eee solid;height:40px}
    .table-sku-stock input{width:60px}
    .lhao{width:150px !important}
    .table-sku-stock th{text-align:center}
    .gui{
        display: inline-block;
        vertical-align: middle;
        /* background: #DBDBDB; */
        border: 1px solid #E3E3E3;
        border-radius: 3px;
        padding: 5px;
        margin-left:10px;
        cursor: pointer;
        font-size: 12px;
    }
    .selected {
        background: #1C8FEF;
        color: #ffffff;
    }
    .sign{color:red}
    * { padding: 0; margin: 0; }
    .demo { padding: 10px; }
    .demo table { border-collapse: collapse; }
    .demo table tr td { border: 1px solid #ccc; padding: 4px; }
    .error{color:red}
    #add_picture .page_right_style{left:0 !important;width:100% !important;}
    #down{width:60px;height:26px;text-decoration: none;text-align:center;
        line-height:26px;border-radius:3px;  background: #428bca;color:white;display:
            inline-block;margin-left:0px;margin-top:6px}
    .selectFileBtn{width:60px;height:26px;text-decoration: none;text-align:center;
        line-height:26px;border-radius:3px;  background: #428bca;color:white;display:
            inline-block;margin-left:0px;margin-top:6px}
    #butn{width:60px;height:26px;text-decoration: none;text-align:center;
        line-height:26px;border-radius:3px;  background: #428bca;color:white;display:
            inline-block;margin-left:-2px;margin-top:6px}
    .btn1{width:60px;height:26px;text-decoration: none;text-align:center;
        line-height:26px;border-radius:3px;  background: #428bca;color:white;display:
            inline-block;margin-left:-2px;margin-top:6px}

    .btn66{width:60px;height:26px;text-decoration: none;text-align:center;
        line-height:26px;border-radius:3px;  background: #428bca;color:white;display:
            inline-block;margin-left:-2px;margin-top:6px}
    .attachItem{width:171px;height:26px;background: #eee;float:left;border-radius: 3px;margin-left: 5px;margin-top: 5px}
    .attachItem .right a {display:block;width:16px;height:16px;overflow: hidden;text-indent:-9999px;background:url(/images/delete.png);  }
    .downItem{width:171px;height:26px;background: #eee;float:left;border-radius: 3px;margin-left: 5px;margin-top: 5px}
    .downItem .right a {display:block;width:16px;height:16px;overflow: hidden;text-indent:-9999px;background:url(/images/delete.png);  }

    .left{width:150px;height:24px;line-height:25px;float:left}
    .right{float:left;margin-top: 5px;}
    .model{border:1px solid #ddd;margin-top:5px;margin-left: 110px;float:left;}
    #models .modelchild{float:left;margin: 10px;}
    .allgoods{margin-left: 30px;width:100%;margin-bottom: 10px}
    .goodslist{width:18%;display: inline-block;margin-top:3px;}
    .specifications_input{margin-left: 3px; margin-bottom: 5px;}
    .specifications{margin-top:20px;}


</style>
<body>
<?php
function t($arr,$pid=0,$lev=0){
    static $list = array();
    foreach($arr as $v){
        if($v['pid']==$pid){
            $list[] = $v;
            t($arr,$v['id'],$lev+1);
        }
    }
    return $list;
}
$list = t($catearr);
?>

<div class="clearfix" id="add_picture">
    <div class="page_right_style">
        <div class="type_title">编辑商品</div>
        <div style="margin-left: 20px;margin-top: 10px"><a title="添加型号" href="/product/addone?goods_id=<?php echo $goodsmodelarr["goods_id"]?>&cate_id=<?php echo $goodsmodelarr["cate"]?>" class="addmodel" style="display:inline-block;width:70px;height:32px;line-height: 32px;background-color:#009ceb;border-radius: 3px;color:#fff;text-align: center">添加型号</a></div>
        <form action="/product/edit" method="post" class="form form-horizontal" id="form-article-add" enctype="multipart/form-data">
            <input type='hidden' id="one_json" name='one_json' value="">
            <input type='hidden' id="json" name='json' value=<?php echo $goodsmodelarr['zi_json']?> />
            <input type='hidden' id="old_model_sku" name='old_sku_json' value=<?php echo $goodsmodelarr['model_sku_json']?>>
            <input type='hidden' style="width:1600px;" id="model_sku" name='model_sku_json' value=<?php echo $goodsmodelarr['model_sku_json']?>>
            <input type='hidden' style="width:1500px" id="model_attr" name='model_attr_json' value=<?php echo $goodsmodelarr['model_attr_json']?>>
            <input type="hidden" value="<?php echo $goodsmodelarr['id']?>" name="goodsmodelid" class="goodsmodelid">
            <input type="hidden" value="<?php echo $goodsmodelarr['id']?>" name="id" class="goodsmodelid">
            <div class="allgoods">
                <div class="goodslist" style="width:90%">
                    <label class="col-2">产品名称：</label>
                    <input type="text" class="input-text toggle" value="<?php echo $goodsmodelarr['name']?>" name="name" style="width:20%; margin-left: 7px;">
                </div>
                <div class="goodslist" style="width:90%">
                    <label class="col-2">产品类别：</label>
                    <select name="cate" style="width:20%; margin-left: 7px;" class="toggle">
                        <option value="0">---选择类别---</option>
                        <?php foreach($list as $key=>$value): ?>
                            <?php $count = substr_count($value['pth'],',');$str = '&nbsp;';if($count):?>
                                <option <?php if($value['id'] == $goodsmodelarr['cate']){echo 'selected';}?> value=<?php echo $value['id']?>><?php echo str_repeat($str,($count)*4).$value['name'];?></option>
                            <?php endif?>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="goodslist" style="width:90%">
                    <label class="col-2">品&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;牌：</label>
                    <select name="brand" style="width:20%; margin-left: 10px;" class="toggle">
                        <option value="0">---选择品牌---</option>
                        <?php foreach($brandarr as $key=>$value):?>

                            <option <?php if($value['id'] == $goodsmodelarr['brand']){echo 'selected';}?> value=<?php echo $value['id']?>><?php echo $value['brandname']?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="goodslist" style="width:90%">
                    <label class="col-2">产&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;商：</label>
                    <input type="text" class="input-text toggle" value="<?php echo $goodsmodelarr['business_men']?>" name="business_men" style="width:20% ;margin-left: 10px;">
                </div>
                <div class="goodslist" style="width:90%">
                    <label class="col-2"> 发布时间：</label>
                    <input type="text" id="datetimepicker7" class="input-text toggle" value="<?php echo $goodsmodelarr['create_time']?>" name="create_time" style="width:20% ;margin-left: 7px;" >
                </div>
            </div>

            <div class="clearfix cl" id="models">
                <label class="form-label col-2">产品型号：</label>&nbsp;&nbsp;

                <div class="model" style="display:;width:90%;margin-top: -22px;" >
                    <div class="modelchild" style="width:90%;">
                        <span style="margin-right: 10px;">标&nbsp;&nbsp;&nbsp;题：</span><input class="toggle" type="text" value="<?php echo $goodsmodelarr['title']?>" name="title" style="width:60%">
                    </div>
                    <div class="modelchild" style="width:90%;">
                        <span style="margin-right: 10px;">关键词：</span><input class="toggle" type="text" value="<?php echo $goodsmodelarr['keywords']?>" name="keywords" style="width:60%">
                        <span class="sign">多个关键词以英文逗号隔开例：(a,b,c)</span>
                    </div>
                    <div class="modelchild" style="width:90%;">
                        <span style="font-size: 10px; ">包装清单：</span><input type="text" value="<?php echo $goodsmodelarr['goods_list']?>" name="goods_list" style="width:60%">
                    </div>

                    <div class="modelchild" style="width:90%;">
                        <span style="margin-right: 10px;">型&nbsp;&nbsp;&nbsp;号：</span><input class="toggle" id="model_number" type="text" value="<?php echo $goodsmodelarr['model_number']?>" name="model_number" style="width:150px">
                    </div>
                    <div class="modelchild" style="width:90%;">
                        <span style="margin-right: 10px;">销售价：</span><input <?php if($auth_arr['publish_goods_sign']=='0'){echo 'readonly';}?> class="toggle" type="number" value="<?php echo $goodsmodelarr['preferential_price']?>" name="preferential_price" style="width:150px">
                    </div>
                    <div class="modelchild" style="width:90%;">
                        <span style="margin-right: 10px;">市场价：</span><input <?php if($auth_arr['publish_goods_sign']=='0'){echo 'readonly';}?> class="toggle" id="price" type="number" value="<?php echo $goodsmodelarr['price']?>" name="price" style="width:150px">
                    </div>
                    <div class="modelchild" style="width:90%;;">
                        <span style="margin-right: 10px;">库&nbsp;&nbsp;&nbsp;存：</span><input <?php if($auth_arr['publish_goods_sign']=='0'){echo 'readonly';}?> type="number" value="<?php echo $goodsmodelarr['stock']?>" name="stock" style="width:150px">
                    </div>

                    <div class="modelchild" style="width:90%;">
                        <span style="margin-right: 10px;">销&nbsp;&nbsp;&nbsp;量：</span><input <?php if($auth_arr['publish_goods_sign']=='0'){echo 'readonly';}?> class="toggle" id="sales_volume" type="number" value="<?php echo $goodsmodelarr['sales_volume']?>" name="sales_volume" style="width:150px">
                    </div>

                    <div class="modelchild" style="width:90%;">
                        <span style="margin-right: 10px;">料&nbsp;&nbsp;&nbsp;号：</span><input type="text" value="<?php echo $goodsmodelarr['pn']?>" name="pn" style="width:150px">
                    </div>
                    <div class="modelchild" style="width:90%;">
                        <span style="font-size: 10px !important;margin-right: 6px;">到货时间：</span><input <?php if($auth_arr['publish_goods_sign']=='0'){echo 'readonly';}?> type="text" value="<?php echo $goodsmodelarr['model_delivery_time']?>" name="model_delivery_time" style="width:150px;margin-left:4px;">
                    </div>
                    <div class="modelchild xiaoshi" >
                        <span style="font-size: 10px !important;margin-right: 6px;display:inline-block">型号介绍：</span>
                        <div style='margin:-18px 0 0 80px;color:red;'><a class='add' href='javascript:void(0)'>+添加一个介绍</a></div>
                        <div id='jiji' style='display:inline-block;margin-left:64px;'>
                            <?php if($goodsmodelarr['zi_json']):$zi_json=json_decode($goodsmodelarr['zi_json'],true);?>
                                <?php foreach($zi_json as $k=>$v):?>
                                    <div class='jij' style='margin-left: -3px;'>
                                        <input type="text" class='key' value='<?php echo $v['key']?>' name="key-0" style="width: 150px">:<input class='val' type="text" value='<?php echo $v['val']?>' name="val-0" style="width: 150px"> <span><a class='del' href='javascript:void(0)'>删除</a></span>
                                    </div>
                                <?php endforeach;?>
                            <?php endif;?>
                        </div>
                    </div>
                    <div id='contact_goods' class="clearfix modelchild" style="width:90%"><span style="font-size: 10px !important;margin-right: 6px;display:inline-block">关联商品：</span>
                        <div id="odiv_goods" style='margin:-20px 0 0 57px;color:red;'>
                            <input class='contact_goods_str' type='text' name="associated" value="<?php echo $goodsmodelarr['associated']?>"/>
                            <input class='contact_goods' type='text' placeholder='请输入商品标题' name='contact_goods' />
                            <input id='goods_sure' style="height:28px;line-height:14px;" type='button' value='确定' />
                            <input id='goods_sure_sku' style="height:28px;line-height:14px;display:none" type='button' value='确定' />
                        </div>
                        <div id="omulti-goods">
                            <select id='multi-goods'>
                            </select>
                            <select id='multi-goods-sku' multiple='multiple'>
                            </select>
                        </div>

                    </div>
                    <div class="modelchild" style="width:90%;">
                        <span style="font-size: 10px; margin-right: 10px;width:">售后服务：</span>
                        <select class="toggle" name="after_sales" style="width:150px;margin-left:-3px;">
                            <?php foreach($time_limit_arr as $k=>$v):?>
                                <option <?php if($goodsmodelarr['after_sales'] == $v['id']){echo 'selected';}?> value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="modelchild" style="width:90%;">
                        <span style="font-size: 10px !important;">商品类型：</span>

                        <select class="toggle" id="choose_type" style="margin-left:7px;width: 150px;" name='type_id'>
                            <option value=0>选择类型</option>
                            <?php foreach($type_arr as $key=>$value): ?>
                                <option <?php if($value['id'] == $type_id){echo 'selected';}?> value=<?php echo $value['id']?>><?php echo $value['type'];?></option>
                            <?php endforeach;?>
                        </select>
                        <div id="type" style="display:none">
                        </div>
                        <div id="stock" style="display:">
                            <dl class="control-group js-spec-table" name="skuTable" style="display: ;">

                                <dd>
                                    <div class="controls">
                                        <div class="js-goods-stock control-group" style="font-size: 14px; margin-top: 10px;">
                                            <div id="stock-region" class="sku-group">
                                                <table class="table-sku-stock" cellpadding="4" cellspacing="0" border="0" style="border: 1; ">
                                                    <thead></thead>
                                                    <tbody></tbody>
                                                    <tfoot></tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        <div id='attr' >
                        </div>
                    </div>
                    <div class="modelchild xiaoshi" style="width:245px;margin-left: -20px;">
                        <label class="form-label col-2">是否上架：</label>
                        <div class="formControls col-2 skin-minimal">
                            <div class="check-box" style=" margin-top:5px;margin-left:-10px">
                                <label><input <?php if($auth_arr['publish_goods_sign']=='0' || $auth_arr['publish_goods_sign']==1){echo 'readonly';}?> <?php if($goodsmodelarr['is_publish'] == 0){echo 'checked';}?> value="0" name="is_publish" type="radio" class="ace" /><span class="lbl">是</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label><input <?php if($goodsmodelarr['is_publish'] == 1){echo 'checked';}?> value="1" name="is_publish" type="radio" class="ace" /><span class="lbl">否</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="modelchild xiaoshi" style="width:245px;margin-left: -20px;">
                        <label class="form-label col-2">是否询价：</label>
                        <div class="formControls col-2 skin-minimal">
                            <div class="check-box" style=" margin-top:5px;margin-left:-10px">
                                <label><input <?php if($goodsmodelarr['is_price_show'] == 1){echo 'checked';}?> value="1" name="is_price_show" type="radio" class="ace" /><span class="lbl">是</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label><input <?php if($goodsmodelarr['is_price_show'] == 0){echo 'checked';}?> value="0" name="is_price_show" type="radio" class="ace" /><span class="lbl">否</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="modelchild xiaoshi" style="width:245px;margin-left: -20px;">
                        <label class="form-label col-2">是否优惠：</label>
                        <div class="formControls col-2 skin-minimal">
                            <div class="check-box" style=" margin-top:5px;margin-left:-10px">
                                <label><input <?php if($goodsmodelarr['is_preferential'] == 0){echo 'checked';}?> value="0" name="is_preferential" type="radio" class="ace" /><span class="lbl">是</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label><input <?php if($goodsmodelarr['is_preferential'] == 1){echo 'checked';}?> value="1" name="is_preferential" type="radio" class="ace" /><span class="lbl">否</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="modelchild xiaoshi" style="width:300px;margin-left: -20px;">
                        <label class="form-label col-2">入库方式：</label>
                        <div class="formControls col-2 skin-minimal">
                            <div class="check-box" style=" margin-top:5px;margin-left:-10px">
                                <label><input <?php if($goodsmodelarr['in_storage'] == 0){echo 'checked';}?> name="in_storage" type="radio" class="ace" value=0 /><span class="lbl">正常</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label><input <?php if($goodsmodelarr['in_storage'] == 1){echo 'checked';}?> name="in_storage" type="radio" class="ace" value=1 /><span class="lbl">缺货</span></label>&nbsp;&nbsp;&nbsp;
                                <label><input <?php if($goodsmodelarr['in_storage'] == 2){echo 'checked';}?> name="in_storage" type="radio" class="ace" value=2 /><span class="lbl">待定</span></label>
                            </div>
                        </div>
                    </div>
                    <!--<div class="modelchild" id="specifications" style="width:90%;">
                        		规格参数：<a href="javascript:void(0)" class="btn1" data-val=" <?php echo count($specification)+1;?>">添加参数</a>
                        <a href="javascript:void(0)" class="btn66">参数提交</a>
                        <?php foreach($specification as $key=>$value):?>

                            <div class='specifications' style='width:90%;border:1px solid #ddd'>

                                <input value="<?php echo $value['td_one']?>" data_val="<?php echo $key+1;?>" name="0-<?php echo $key+1;?>" style='margin-top: 5px;' class='sssss specifications_input' type='text'  placeholder='&nbsp;分类' >
                                <button class='addbtn' data-val='<?php echo count($value['prop'])+1;?>' style='border:none;background: none'>+</button>
                                <?php foreach(($value['prop']) as $ke=>$val):?>
                                    <div class='sss'>
                                    <input value="<?php echo $val['att']?>" name='att0-<?php echo $key+1;?>-<?php echo $ke+1;?>' class='specifications_input' type=text  placeholder='&nbsp;属性' >&nbsp;
                                    <input value="<?php echo $val['val']?>" class='specifications_input' type=text name='val0-<?php echo $key+1;?>-<?php echo $ke+1;?>' placeholder='&nbsp;值'> </div>
                                <?php endforeach;?>
                            </div>
                        <?php endforeach;?>
                    </div>  -->

                    <div class="modelchild xiaoshi" style="width:90%;" >
                        上&nbsp;&nbsp;&nbsp;传：<a href="javascript:void(0)" class="selectFileBtn" style="margin-left: 10px">图片上传</a>
                        <div class="uploader-list-container" style="height:38px;display: none;width:1062px;margin-left:60px;">
                            <div class="attachList clear"></div>
                        </div>
                    </div>
                    <div class="modelchild xiaoshi" style="width:90%;" >
                        <span style="display: inline-block;float:left">详细内容：</span>
                        <div class="formControls col-10">
                            <textarea id="editor" name="detail_introduce" type="text/plain" style="width:100%;height:400px;"><?php echo $goodsmodelarr['detail_introduce'] ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix cl xiaoshi">
                <label class="form-label col-2">相关知识：</label>
                <div class="formControls col-10">
                    <textarea id="editor1" name="function" type="text/plain" style="width:100%;height:400px;"><?php echo $goodsmodelarr['function'] ?></textarea>
                </div>
            </div>
            <div class="clearfix cl xiaoshi">
                <label class="form-label col-2">使用手册：</label>
                <div class="formControls col-10">
                    <textarea id="editor2" name="manual" type="text/plain" style="width:100%;height:400px;"><?php echo $goodsmodelarr['manual'] ?></textarea>
                </div>
            </div>
            <div class="clearfix cl xiaoshi">
                <label class="form-label col-2">允许评论：</label>
                <div class="formControls col-2 skin-minimal">
                    <div class="check-box" style=" margin-top:9px;margin-left:-10px">
                        <label><input <?php if($goodsmodelarr['is_comments'] == 0){echo 'checked';}?> name="is_comments" type="radio" class="ace"  value=0 /><span class="lbl">是</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label><input <?php if($goodsmodelarr['is_comments'] == 1){echo 'checked';}?> name="is_comments" type="radio" class="ace"  value=1 /><span class="lbl">否</span></label>
                    </div>
                </div>
            </div>
            <?php if($auth_arr['publish_goods_sign'] != 0):?>
            <div class="clearfix cl xiaoshi">
                <label class="form-label col-2">商品审核：</label>
                <div class="formControls col-2 skin-minimal">
                    <div class="check-box" style=" margin-top:9px;margin-left:-10px">
                        <label><input class="ace is_through" name="is_through" checked type="radio" value=0 /><span class="lbl">通过</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label><input class="ace is_through" name="is_through" type="radio" value=1 /><span class="lbl">不通过</span></label>
                    </div>
                    <textarea name="n_reason" class="n_reason"  style="display: none; margin-top:9px;margin-left:-10px; "></textarea>
                </div>
            </div>
            <?php endif;?>
            <div class="modelchild xiaoshi" style="width:1200px;margin-left: 20px;;">
                <label class="form-label col-2">上传附件：</label><a href="javascript:void(0)" id="down" style="margin-left: 10px">上传附件</a>
                <div class="down-list-container" style="height:38px;display: none;width:1062px;margin-left:60px;">
                    <div class="downList clear"></div>
                </div>
            </div>

            <div style="width:100px;margin-left:600px">
                <input type="button" value="提&nbsp;&nbsp;&nbsp;&nbsp;交" class="btn btn-primary radius" style="width:100px;">
            </div>
        </form>
    </div>
</div>
</div>
<script src="/js/jquery-1.9.1.min.js"></script>
<script src="/assets/layer/layer.js" type="text/javascript" ></script>
<script src="/assets/laydate/laydate.js" type="text/javascript"></script>
<script type="text/javascript" src="/Widget/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="/Widget/ueditor/1.4.3/ueditor.all.min.js"> </script>
<script type="text/javascript" src="/Widget/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<script src="/assets/js/jquery.validate.js"></script>
<script src="/js/jquery.datetimepicker.full.js"></script>
<script>
    $(function(){
        $('.n_reason').val('未通过原因 ')
        $('.is_through').click(function(){
            if($(this).val() == 1){
                $('.n_reason').show()
            }else{
                $('.n_reason').hide()
            }
        })
    })
    var property_arr = new Array();
    property_arr=<?php echo json_encode($model_sku_json)?>;
    var attr_arr1 = <?php echo json_encode($model_attr_json)?>;
    if(attr_arr1 != null)
    {
        attr_arr = attr_arr1;
    }
    else
    {
        var attr_arr = new Array();
    }
    console.log(attr_arr);
    var arr = new Array();
    var $temp_Obj = new Object();
    var data_p_v=<?php echo $kkkk?>;
    var data_r_v=<?php echo $rrrr?>;
    attr_r_v=eval('('+data_r_v+')');
    /* console.log(data_p_v);*/
    //console.log(data_r_v);
    var data_p_info=<?php echo $info?>;
    var model_sku_json='';
    var model_attr_json ='';
    function dataPV(x,y){
        var d=[];
        for (var i in data_p_v){
            if((data_p_v[i].goods_property_id==x)&&(data_p_v[i].goods_property_value_id==y))
            {
                d['price1']=data_p_v[i].price1;
                d['stock1']=data_p_v[i].stock1;
                //console.log(d);
                return d;
            }
        }
        return false;
    }
    function dataattr(x,y){
        var r=[];
        for (var i in attr_r_v){
            if((attr_r_v[i].id==x)&&(attr_r_v[i].sid==y))
            {
                return true;
            }
        }
        return false;
    }
    function dataInfo(combination){
        var f=[];
        for (var g in data_p_info){
            if((data_p_info[g].combination==combination))
            {
                f['price1']=data_p_info[g].price1;
                f['market_price']=data_p_info[g].market_price;
                f['stock1']=data_p_info[g].stock1;
                f['sales']=data_p_info[g].sales;
                f['pn']=data_p_info[g].pn;
                f['delivery_time']=data_p_info[g].delivery_time;
                //console.log(data_p_info[g].combination);
                return f;
            }
        }
        return false;
    }

    $(function(){
        var type_id = '<?php echo $type_id?>';
        if(type_id)
        {
            $('#type').show();
            $('#attr').show();
            var url = '/product/addone';
            $.post(url,{type_id:type_id,ss:1},function(data){
                var parsedJson = jQuery.parseJSON(data).property
                var parsedJson_attr = jQuery.parseJSON(data).attr
                var spec_length = parsedJson.length;
                var attr_length = parsedJson_attr.length;
                var html ='';
                //console.log(parsedJson)
                if(parsedJson&&parsedJson!='')
                {
                    html += '<div class="oaddr" style="display:inline-block">'
                    for(i=0;i<spec_length;i++)
                    {
                        var curr_property = parsedJson[i];
                        html += '<div style="width:800px;" ddds='+parsedJson[i]['id']+' class="js-spec-item goods-sku-block-'+parsedJson[i]['id']+'">';
                        html += '<div class="property-name" style="width:100px;display:inline-block;margin-top:10px;">'+parsedJson[i]['name']+'</div>';
                        html +='<div style="margin-left:64px;margin-top: -25px;width:80%">'
                        html += '<div class="all_att" style="display:inline">'
                        for(j=0;j<curr_property.property.length;j++)
                        {
                            var curr_property_value = curr_property.property[j];
                            if(dataPV(curr_property_value.goods_property_id,curr_property_value.id)){
                                html += '<span class="gui selected"';
                            }else{
                                html += '<span class=gui';
                            }
                            html += ' this-property="' +curr_property.name+ '"';
                            html += ' this-property-id="' + curr_property_value.goods_property_id + '"';
                            html += ' this-property-name="'+curr_property_value.name_value+'"';
                            html += ' this-property-name-id="' + curr_property_value.id +'">';
                            html += curr_property_value.name_value+"</span>";
                        }
                        html += '</div>';
                        html += '<a class="addrv" href="javascript:void(0)">添加规格值</a>';
                        html += '</div>';
                        html += '</div>';
                    }
                    html += '</div>'
                    html += '<br/><a class="addr" href="javascript:void(0)">添加规格</a>';
                    $('#type').html(html);
                }

                if(parsedJson_attr)
                {
                    $('#attr').show();
                    attr_html = '<div style="float:left;border:1px solid #ccc;width:100%">商品属性</div>';
                    attr_html += '<div id="attr_attr">';
                    for(m=0;m<attr_length;m++)
                    {
                        var attr_property = parsedJson_attr[m];
                        attr_html += '<div class="attr_all" style="float:left">';
                        attr_html += '<div class="attr_left" attr_id='+attr_property.id+'><span>'+attr_property.attr+'</span></div>';
                        attr_html += '<div class="attr_right">';
                        attr_html += '<div class="attr_right_h" style="display: inline;">';
                        for(n=0;n<attr_property.attr_val_arr.length;n++)
                        {
                            var attr_value = attr_property.attr_val_arr[n];
                            //console.log(attr_value);
                            if(dataattr(attr_value.id,attr_property.id)){
                                attr_html += '<span><input type=checkbox checked';
                            }else{
                                attr_html += '<span><input type=checkbox';
                            }
                            attr_html += ' attr_id="'+attr_property.id+'"';
                            attr_html += ' attr_name="'+attr_property.attr+'"'
                            attr_html += ' attr_val="'+attr_value.attr_val+'"'
                            attr_html += ' value="'+attr_value.id+'"'
                            attr_html += ' />';
                            attr_html += attr_value.attr_val+"</span>";
                        }
                        attr_html += '</div>';
                        attr_html += '&nbsp;&nbsp;<a href="javascript:;" class="addr_v">添加属性值</a>';
                        attr_html += '</div>';
                        attr_html += '</div>';
                    }
                    attr_html += '</div>';
                    attr_html += '<a href="javascript:;" class="attr_n">添加属性名</a>';
                    $('#attr').html(attr_html);
                }
            })
        }
        $('#attr').on('click','.attr_n',function(){
            var url = '/product/addone'
            layer.open({
                type: 1,
                title: '填写属性',
                skin: 'layui-layer-rim', //加上边框
                area: ['300px', '220px'], //宽高
                btn:['确定','取消'],
                content: '<input class="addr_name" style="margin:40px 64px;">',
                yes:function(index)
                {
                    var val = $('.addr_name').val();
                    var regu = "^[ ]+$";
                    var re = new RegExp(regu);
                    if(val == '' || re.test(val))
                    {
                        layer.alert('不能为空！');
                        return false;
                    }
                    $.post(url,{type_id:type_id,attr:val,add_n:1},function(data){
                        if(data)
                        {
                            var append_attr= $('<div class="attr_all" style="float:left">'+
                                '<div class="attr_left" attr_id='+data+'><span>'+val+'</span></div>'+
                                '<div class="attr_right">'+
                                '<div class="attr_right_h" style="display: inline;">'+
                                '</div>'+
                                '&nbsp;&nbsp;<a href="javascript:;" class="addr_v">添加属性值</a>'+
                                '</div>')
                            $('#attr_attr').append(append_attr);
                        }
                    })
                    layer.close(index)
                }
            });
        })
        $('#attr').on('click','.addr_v',function(){
            var this_info = $(this).parents('.attr_all').find('.attr_left')
            var $_parents = $(this).parents('.attr_right').find('.attr_right_h');
            var this_info_attr_id = this_info.attr('attr_id');
            var this_info_attr_name = this_info.find('span').text();
            var url = '/product/addone'
            layer.open({
                type: 1,
                title: '填写属性值',
                skin: 'layui-layer-rim', //加上边框
                area: ['300px', '220px'], //宽高
                btn:['确定','取消'],
                content: '<input class="addr_val" style="margin:40px 64px;">',
                yes:function(index)
                {
                    var val = $('.addr_val').val();
                    var regu = "^[ ]+$";
                    var re = new RegExp(regu);
                    if(val == '' || re.test(val))
                    {
                        layer.alert('不能为空！');
                        return false;
                    }
                    $.post(url,{attr_name:this_info_attr_name,attr_id:this_info_attr_id,attr_value_name:val,add_r:1},function(data){
                        var data=$.parseJSON(data)
                        if(data.code==200)
                        {
                            $_parents.append('<span><input type="checkbox" attr_id='+this_info_attr_id+' attr_name='+this_info_attr_name+' attr_val='+val+' value='+data.id+' />'+val+'</span>');
                        }else{
                            layer.alert(data.message)
                        }
                    })
                    layer.close(index);
                }
            });
        })
        $('#type').on('click','.addrv',function(){
            var $_parents =  $(this).parents('.js-spec-item').find('.all_att');
            var olast = $(this).parents('.js-spec-item');
            var last_property = olast.find('.property-name').text();
            var last_property_id = olast.attr('ddds');
            var len = $_parents.find('span').length;
            var url = '/product/addone'
            layer.open({
                type: 1,
                title: '填写规格值',
                skin: 'layui-layer-rim', //加上边框
                area: ['300px', '220px'], //宽高
                btn:['确定','取消'],
                content: '<input class="dds" style="margin:40px 64px;">',
                yes:function(index)
                {
                    var val = $('.dds').val();
                    var regu = "^[ ]+$";
                    var re = new RegExp(regu);
                    if(val == '' || re.test(val))
                    {
                        layer.alert('不能为空！');
                        return false;
                    }
                    $.post(url,{property_id:last_property_id,name_value:val,addrv:1},function(data){
                        if(data)
                        {
                            $_parents.append('<span class="gui" this-property="'+last_property+'" this-property-id="'+last_property_id +'" this-property-name="'+val+'" this-property-name-id="'+data+'">'+val+'</span>');

                        }
                    })

                    layer.close(index);
                }

            });
        })
        $('#type').on('click','.addr',function(){
            var url = '/product/addone';
            layer.open({
                type: 1,
                title: '填写规格',
                skin: 'layui-layer-rim', //加上边框
                area: ['300px', '220px'], //宽高
                btn:['确定','取消'],
                content: '<input class="p_name" style="margin:40px 64px;">',
                yes:function(index)
                {
                    var p_name = $('.p_name').val();
                    var regu = "^[ ]+$";
                    var re = new RegExp(regu);
                    if(p_name == '' || re.test(p_name))
                    {
                        layer.alert('不能为空！');
                        return false;
                    }
                    $.post(url,{type_id:type_id,property:p_name,addr:1},function(data){
                        if(data)
                        {
                            $('.oaddr').append('<div style="position: relative;width:70%;display:inline-block" ddds='+data+' class="js-spec-item goods-sku-block-'+data+'">'+
                                '<div class="property-name" style="width:100px;display:inline-block;margin-top:10px;">'+p_name+'</div>'+
                                '<div style="margin-left:64px;margin-top: -25px;width:80%">'+
                                '<div class="all_att" style="display:inline">'+
                                '</div>'+
                                '<a class="addrv" href="javascript:void(0)">添加规格值</a>'+
                                '</div>'+
                                '</div>')
                        }
                    })

                    layer.close(index);
                }

            });
        })
        $('#attr').on('click','.attr_all input',function(){
            var xid = $(this).attr('attr_id');
            var xname = $(this).attr('attr_name');
            var yid = $(this).val();
            var yname = $(this).attr('attr_val');
            if($(this).is(':checked') == false)
            {
                for(var i in attr_arr){
                    if(attr_arr[i].id==xid){
                        for(var j in attr_arr[i].value){
                            if(attr_arr[i].value[j].id==yid){
                                if(attr_arr[i].value.length<2){
                                    attr_arr.splice(i,1);
                                }else{
                                    attr_arr[i].value.splice(j,1);
                                }
                            }
                        }
                    }
                }
            }else{
                if(!attr_arr[0]){
                    //console.log(attr_arr[0]);return false;
                    attr_arr.push({id:xid,name:xname,value:[{sid:xid,id:yid,name:yname}]});
                }else{
                    //console.log(attr_arr[0]);return false;
                    for(var i in attr_arr){
                        if(attr_arr[i].id==xid){
                            attr_arr[i].value.push({sid:xid,id:yid,name:yname}); break;
                        }
                        if(i==(attr_arr.length-1)){
                            attr_arr.push({id:xid,name:xname,value:[{sid:xid,id:yid,name:yname}]});break;
                        }
                    }
                }
            }
            createAttrData(attr_arr)
            function createAttrData($specArray){
                model_attr_json = JSON.stringify($specArray);
                //console.log(model_attr_json);
                var $length=$specArray.length;
                $sku_array=new Array();
                if($length>0){
                    var $spec_value_obj=$specArray[0]["value"];
                    $.each($spec_value_obj,function(i,v){
                        var $spec_id = v.sid;
                        var $spec_value_id=v.id;
                        var $spec_value=v.name;
                        var $sku_obj=new Object();
                        $sku_obj.id=$spec_id+":"+$spec_value_id;
                        $sku_obj.name=$spec_value;
                        $sku_array.push($sku_obj);
                    });

                }
                for($i=1;$i<$length;$i++){
                    $spec_val_obj=$specArray[$i]["value"];
                    $length_val=$spec_val_obj.length;

                    $sku_copy_array=new Array();
                    $.each($sku_array,function(i,v){
                        $old_id=v.id;
                        $old_name=v.name;
                        for($y=0;$y<$length_val;$y++){
                            var $spec_id=$spec_val_obj[$y].sid;
                            var $id=$spec_val_obj[$y].id;
                            var $name=$spec_val_obj[$y].name;
                            $copy_obj=new Object();
                            $copy_obj.id=$old_id+";"+$spec_id+":"+$id;
                            $copy_obj.name=$old_name+";"+$name;
                            $sku_copy_array.push($copy_obj);
                        }

                    });
                    $sku_array=$sku_copy_array;
                }
            }
            /*console.log(attr_arr);
            alert(xid);
            alert(xname);
            alert(yid);
            alert(yname);*/

        })
        $('#choose_type').change(function(){
            property_arr = new Array();
            property_arr.splice(0,property_arr.length)
            $('#stock').hide();
            $('#type').show();
            var url = '/product/addone';
            var type_id = $(this).val();

            $.post(url,{type_id:type_id,ss:1},function(data){
                var parsedJson = jQuery.parseJSON(data).property
                var parsedJson_attr = jQuery.parseJSON(data).attr
                var spec_length = parsedJson.length;
                var attr_length = parsedJson_attr.length;
                var html ='';
                var attr_html = '';
                if(parsedJson){
                    console.log(parsedJson)
                    for(i=0;i<spec_length;i++)
                    {
                        var curr_property = parsedJson[i];

                        html += '<div style="width:800px;"class="js-spec-item goods-sku-block-'+parsedJson[i]['id']+'">';
                        html += '<div class="property-name" style="width:100px;display:inline-block;margin-top:10px;">'+parsedJson[i]['name']+'</div>';

                        for(j=0;j<curr_property.property.length;j++)
                        {
                            var curr_property_value = curr_property.property[j];
                            html += '<span class=gui '
                            html += ' this-property="' +curr_property.name+ '"';
                            html += ' this-property-id="' + curr_property_value.goods_property_id + '"';
                            html += ' this-property-name="'+curr_property_value.name_value+'"';
                            html += ' this-property-name-id="' + curr_property_value.id +'">';
                            html += curr_property_value.name_value+"</span>";

                        }
                        html += '</div>';
                    }
                    $('#type').html(html);
                }
                if(parsedJson_attr)
                {
                    $('#attr').show();
                    attr_html = '<div style="float:left;border:1px solid #ccc;width:100%">商品属性</div>';
                    for(m=0;m<attr_length;m++)
                    {
                        var attr_property = parsedJson_attr[m];
                        attr_html += '<div class="attr_all" style="float:left">';
                        attr_html += '<div class="attr_left"><span>'+attr_property.attr+'</span></div>';
                        attr_html += '<div class="attr_right">';
                        for(n=0;n<attr_property.attr_val_arr.length;n++)
                        {
                            var attr_value = attr_property.attr_val_arr[n];
                            attr_html += '<span><input type="checkbox" attr_id='+attr_property.id+' attr_name='+attr_property.attr+' attr_val='+attr_value.attr_val+' value='+attr_value.id+' />'+attr_value.attr_val+'</span>'

                        }
                        attr_html += '</div>';
                        attr_html += '</div>';
                    }

                    $('#attr').html(attr_html);
                }
            })

        })
        if(attr_arr)
        {
            createAttrData(attr_arr)
            function createAttrData($specArray){
                model_attr_json = JSON.stringify($specArray)
                var $length=$specArray.length;
                $sku_array=new Array();
                if($length>0){
                    var $spec_value_obj=$specArray[0]["value"];
                    $.each($spec_value_obj,function(i,v){
                        var $spec_id = v.sid;
                        var $spec_value_id=v.id;
                        var $spec_value=v.name;
                        var $sku_obj=new Object();
                        $sku_obj.id=$spec_id+":"+$spec_value_id;
                        $sku_obj.name=$spec_value;
                        $sku_array.push($sku_obj);
                    });

                }
                for($i=1;$i<$length;$i++){
                    $spec_val_obj=$specArray[$i]["value"];
                    $length_val=$spec_val_obj.length;

                    $sku_copy_array=new Array();
                    $.each($sku_array,function(i,v){
                        $old_id=v.id;
                        $old_name=v.name;
                        for($y=0;$y<$length_val;$y++){
                            var $spec_id=$spec_val_obj[$y].sid;
                            var $id=$spec_val_obj[$y].id;
                            var $name=$spec_val_obj[$y].name;
                            $copy_obj=new Object();
                            $copy_obj.id=$old_id+";"+$spec_id+":"+$id;
                            $copy_obj.name=$old_name+";"+$name;
                            $sku_copy_array.push($copy_obj);
                        }

                    });
                    $sku_array=$sku_copy_array;
                }
            }
        }

        if(property_arr)
        {
            createSkuData(property_arr);
            var th_html = "<tr>";
            for(var q=0;q<property_arr.length;q++){
                //给表头添加所选规格
                th_html +="<th class='text-center'>"+ property_arr[q].name +"</th>";
            }
            //表格表头
            th_html += '<th class="th-price">销售价（元）</th>';
            th_html += '<th class="th-price">市场价（元）</th>';
            th_html += '<th class="th-stock">库存</th>';
            th_html += '<th class="text-right">销量</th>';
            th_html += '<th class="text-right">料号</th>';
            th_html += '<th class="text-right">到货时间（天）</th>';
            th_html += '</tr>';
            $(".js-spec-table thead").html(th_html);
            //////////////////建立表格////////////////////
            var html = "";

            for(var i = 0; i < $sku_array.length; i ++){
                var child_id_string = $sku_array[i]["id"].toString();
                var child_name_string = $sku_array[i]["name"].toString();
                //dataPV()
                if(child_id_string.indexOf(";")){
                    var child_id_array = child_id_string.split(";");
                }else{
                    var child_id_array = new Array(child_id_string);
                }
                if(child_name_string.indexOf(";")){
                    var child_name_array = child_name_string.split(";");

                }else{
                    var child_name_array = new Array(child_name_string);
                }

                //将规格,规格值处理成 spec_id,spec_value_id;spec_id,spec_value_id 格式
                if($temp_Obj[child_id_string] == undefined){

                    $temp_Obj[child_id_string] = new Object();
                    $temp_Obj[child_id_string]["sku_price"] =dataInfo(child_id_string).price1;
                    $temp_Obj[child_id_string]["market_price"] =dataInfo(child_id_string).market_price;
                    $temp_Obj[child_id_string]["stock_num"] =dataInfo(child_id_string).stock1;
                    $temp_Obj[child_id_string]["sales"] =dataInfo(child_id_string).sales;
                    $temp_Obj[child_id_string]["sku_pn"] =dataInfo(child_id_string).pn;
                    $temp_Obj[child_id_string]["delivery_time"] =dataInfo(child_id_string).delivery_time;
                }
                html +="<tr skuid='"+child_id_string+"'>";
                //循环属性
                $.each(child_name_array,function(m,t){
                    //为属性添加唯一值
                    var start_index = 0;
                    var substr_str = "";
                    while(start_index <= m){
                        if(child_id_array[start_index] != ''){
                            if(substr_str == ""){
                                substr_str = child_id_array[start_index];

                            }else{
                                substr_str +=";"+child_id_array[start_index]
                            }
                        }
                        start_index++;
                    }
                    html +='<td rowspan="1"  skuchild = "'+substr_str+'">'+t+'</td>';

                });
                html +='<td>';
                html +='<input <?php if($auth_arr["publish_goods_sign"]=="0"){echo "readonly";}?> type="text" name="sku_price['+child_id_string+']" class="js-stock-num toggle" value="'+$temp_Obj[child_id_string]["sku_price"]+'" >';
                html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">销售价最小为 0.01</span>';
                html +='</td>';
                html +='<td>';
                html +='<input <?php if($auth_arr["publish_goods_sign"]=="0"){echo "readonly";}?> type="text" name="market_price['+child_id_string+']" class="js-stock-num toggle" value="'+$temp_Obj[child_id_string]["market_price"]+'">';
                html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">市场价最小为 0.01</span>';
                html +='</td>';
                html +='<td>';
                html +='<input <?php if($auth_arr["publish_goods_sign"]=="0"){echo "readonly";}?> type="text" name="stock_num['+child_id_string+']" class="js-stock-num " value="'+$temp_Obj[child_id_string]["stock_num"]+'" onkeyup="inputKeyUpNumberValue(this);" onafterpaste="inputAfterPasteNumberValue(this);"/>';
                html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">库存不能为空</span>';
                html +='</td>';
                html +='<td>';
                html +='<input <?php if($auth_arr["publish_goods_sign"]=="0"){echo "readonly";}?> type="text" name="sales['+child_id_string+']" class="js-stock-num toggle" value="'+$temp_Obj[child_id_string]["sales"]+'" onkeyup="inputKeyUpNumberValue(this);" onafterpaste="inputAfterPasteNumberValue(this);"/>';
                html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">销量不能为空</span>';
                html +='</td>';
                html +='<td>';
                html +='<input type="text" name="sku_pn['+child_id_string+']" class="js-stock-num lhao " value="'+$temp_Obj[child_id_string]["sku_pn"]+'" onkeyup="inputKeyUpNumberValue(this);" onafterpaste="inputAfterPasteNumberValue(this);"/>';
                html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">料号不能为空</span>';
                html +='</td>';
                html +='<td>';
                html +='<input <?php if($auth_arr["publish_goods_sign"]=="0"){echo "readonly";}?> type="text" name="delivery_time['+child_id_string+']" class="js-stock-num " value="'+$temp_Obj[child_id_string]["delivery_time"]+'" onkeyup="inputKeyUpNumberValue(this);" onafterpaste="inputAfterPasteNumberValue(this);"/>';
                html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">时间不能为空</span>';
                html +='</td>';
                html +="</tr>"
            }
            var newArray = new Array();
            $.each(property_arr,function(z,x){
                newArray = newArray.concat(x.value);
            });

            var tdObj = $(".js-spec-table tbody").html(html);
            function createSkuData($specArray){
                model_sku_json = JSON.stringify($specArray)
                var $length=$specArray.length;
                $sku_array=new Array();
                if($length>0){
                    var $spec_value_obj=$specArray[0]["value"];
                    $.each($spec_value_obj,function(i,v){
                        var $spec_id = v.sid;
                        var $spec_value_id=v.id;
                        var $spec_value=v.name;
                        var $sku_obj=new Object();
                        $sku_obj.id=$spec_id+":"+$spec_value_id;
                        $sku_obj.name=$spec_value;
                        $sku_array.push($sku_obj);
                    });

                }
                for($i=1;$i<$length;$i++){
                    $spec_val_obj=$specArray[$i]["value"];
                    $length_val=$spec_val_obj.length;

                    $sku_copy_array=new Array();
                    $.each($sku_array,function(i,v){
                        $old_id=v.id;
                        $old_name=v.name;
                        for($y=0;$y<$length_val;$y++){
                            var $spec_id=$spec_val_obj[$y].sid;
                            var $id=$spec_val_obj[$y].id;
                            var $name=$spec_val_obj[$y].name;
                            $copy_obj=new Object();
                            $copy_obj.id=$old_id+";"+$spec_id+":"+$id;
                            $copy_obj.name=$old_name+";"+$name;
                            $sku_copy_array.push($copy_obj);
                        }

                    });
                    $sku_array=$sku_copy_array;
                    //console.log($sku_array);
                }
            }
            mergeTable()
            //合并单元格
            function mergeTable(){
                for(var i = 0; i < $sku_array.length; i ++){
                    var child_id_string = $sku_array[i]["id"].toString();
                    var child_id_array = child_id_string.split(";");
                    var sear_str = "";
                    $.each(child_id_array,function(w,q){
                        if(sear_str == ""){
                            sear_str += q;
                        }else{
                            sear_str += ";"+q;
                        }
                        if($("td[skuchild = '"+sear_str+"']").length > 1){
                            var check_array=$("td[skuchild = '"+sear_str+"']");
                            for( var $i=0; $i<check_array.length;$i++){
                                $check_obj=$(check_array[$i]);
                                if($i == 0){
                                    $check_obj.attr("rowspan",check_array.length);
                                }else{
                                    $check_obj.remove();
                                }

                            }
                        }
                    })
                }
            }
        }
        $('#type').on('click','.js-spec-item span',function(){
            $('#stock').show();
            var xid = $(this).attr('this-property-id');
            var xname = $(this).attr('this-property');
            var yid = $(this).attr('this-property-name-id');
            var yname = $(this).attr('this-property-name');
            if($(this).hasClass('selected')){
                $(this).removeClass('selected');
                for(var i in property_arr){
                    if(property_arr[i].id==xid){
                        for(var j in property_arr[i].value){
                            if(property_arr[i].value[j].id==yid){
                                if(property_arr[i].value.length<2){
                                    property_arr.splice(i,1);
                                }else{
                                    property_arr[i].value.splice(j,1);
                                }

                            }
                        }
                    }
                }
            }
            else{
                $(this).addClass('selected')
                if(!property_arr[0]){
                    property_arr.push({id:xid,name:xname,value:[{sid:xid,id:yid,name:yname}]});
                }else{
                    for(var i in property_arr){
                        if(property_arr[i].id==xid){
                            property_arr[i].value.push({sid:xid,id:yid,name:yname}); break;
                        }
                        if(i==(property_arr.length-1)){
                            property_arr.push({id:xid,name:xname,value:[{sid:xid,id:yid,name:yname}]});break;
                        }
                    }
                }
            }
            //console.log(property_arr)
            if(!property_arr[0]){
                $('#stock').hide();
            }
            createSkuData(property_arr);
            var th_html = "<tr>";
            for(var q=0;q<property_arr.length;q++){
                //给表头添加所选规格
                th_html +="<th class='text-center'>"+ property_arr[q].name +"</th>";
            }
            //表格表头
            th_html += '<th class="th-price">销售价（元）</th>';
            th_html += '<th class="th-price">市场价（元）</th>';
            th_html += '<th class="th-stock">库存</th>';
            th_html += '<th class="text-right">销量</th>';
            th_html += '<th class="text-right">料号</th>';
            th_html += '<th class="text-right">到货期限（天）</th>';
            th_html += '</tr>';
            $(".js-spec-table thead").html(th_html);
            //////////////////建立表格////////////////////
            var html = "";

            for(var i = 0; i < $sku_array.length; i ++){
                var child_id_string = $sku_array[i]["id"].toString();
                var child_name_string = $sku_array[i]["name"].toString();
                if(child_id_string.indexOf(";")){
                    var child_id_array = child_id_string.split(";");

                }else{
                    var child_id_array = new Array(child_id_string);
                }
                if(child_name_string.indexOf(";")){
                    var child_name_array = child_name_string.split(";");

                }else{
                    var child_name_array = new Array(child_name_string);
                }
                //将规格,规格值处理成 spec_id,spec_value_id;spec_id,spec_value_id 格式
                if($temp_Obj[child_id_string] == undefined){
                    $temp_Obj[child_id_string] = new Object();
                    $temp_Obj[child_id_string]["sku_price"] ="0";
                    $temp_Obj[child_id_string]["market_price"] ="0";
                    $temp_Obj[child_id_string]["stock_num"] ="0";
                    $temp_Obj[child_id_string]["sales"] ="0";
                    $temp_Obj[child_id_string]["sku_pn"] ="0";
                    $temp_Obj[child_id_string]["delivery_time"] ="0";
                }
                html +="<tr skuid='"+child_id_string+"'>";
                //循环属性
                $.each(child_name_array,function(m,t){
                    //为属性添加唯一值
                    var start_index = 0;
                    var substr_str = "";
                    while(start_index <= m){
                        if(child_id_array[start_index] != ''){
                            if(substr_str == ""){
                                substr_str = child_id_array[start_index];

                            }else{
                                substr_str +=";"+child_id_array[start_index]
                            }
                        }
                        start_index++;
                    }
                    html +='<td rowspan="1"  skuchild = "'+substr_str+'">'+t+'</td>';

                });
                html +='<td>';
                html +='<input <?php if($auth_arr["publish_goods_sign"]=="0"){echo "readonly";}?> type="text" name="sku_price['+child_id_string+']" class="toggle js-stock-num input-mini" value="'+$temp_Obj[child_id_string]["sku_price"]+'" >';
                html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">销售价最小为 0.01</span>';
                html +='</td>';
                html +='<td>';
                html +='<input <?php if($auth_arr["publish_goods_sign"]=="0"){echo "readonly";}?> type="text" name="market_price['+child_id_string+']" class="toggle js-stock-num input-mini" value="'+$temp_Obj[child_id_string]["market_price"]+'">';
                html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">市场价最小为 0.01</span>';
                html +='</td>';
                html +='<td>';
                html +='<input <?php if($auth_arr["publish_goods_sign"]=="0"){echo "readonly";}?> type="text" name="stock_num['+child_id_string+']" class="js-stock-num input-mini" value="'+$temp_Obj[child_id_string]["stock_num"]+'" onkeyup="inputKeyUpNumberValue(this);" onafterpaste="inputAfterPasteNumberValue(this);"/>';
                html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">库存不能为空</span>';
                html +='</td>';
                html +='<td>';
                html +='<input <?php if($auth_arr["publish_goods_sign"]=="0"){echo "readonly";}?> type="text" name="sales['+child_id_string+']" class="toggle js-stock-num input-mini" value="'+$temp_Obj[child_id_string]["sales"]+'" onkeyup="inputKeyUpNumberValue(this);" onafterpaste="inputAfterPasteNumberValue(this);"/>';
                html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">销量不能为空</span>';
                html +='</td>';
                html +='<td>';
                html +='<input type="text" name="sku_pn['+child_id_string+']" class="js-stock-num input-mini lhao" value="'+$temp_Obj[child_id_string]["sku_pn"]+'" onkeyup="inputKeyUpNumberValue(this);" onafterpaste="inputAfterPasteNumberValue(this);"/>';
                html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">料号不能为空</span>';
                html +='</td>';
                html +='<td>';
                html +='<input <?php if($auth_arr["publish_goods_sign"]=="0"){echo "readonly";}?> type="text" name="delivery_time['+child_id_string+']" class="js-stock-num input-mini" value="'+$temp_Obj[child_id_string]["delivery_time"]+'" onkeyup="inputKeyUpNumberValue(this);" onafterpaste="inputAfterPasteNumberValue(this);"/>';
                html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">时间不能为空</span>';
                html +='</td>';
                html +="</tr>"
            }
            var newArray = new Array();
            $.each(property_arr,function(z,x){
                newArray = newArray.concat(x.value);
            });

            var tdObj = $(".js-spec-table tbody").html(html);
            //将对象处理成表格数据
            function createSkuData($specArray){
                model_sku_json = JSON.stringify($specArray)
                var $length=$specArray.length;
                $sku_array=new Array();
                if($length>0){
                    var $spec_value_obj=$specArray[0]["value"];
                    $.each($spec_value_obj,function(i,v){
                        var $spec_id = v.sid;
                        var $spec_value_id=v.id;
                        var $spec_value=v.name;
                        var $sku_obj=new Object();
                        $sku_obj.id=$spec_id+":"+$spec_value_id;
                        $sku_obj.name=$spec_value;
                        $sku_array.push($sku_obj);
                    });

                }
                for($i=1;$i<$length;$i++){
                    $spec_val_obj=$specArray[$i]["value"];
                    $length_val=$spec_val_obj.length;

                    $sku_copy_array=new Array();
                    $.each($sku_array,function(i,v){
                        $old_id=v.id;
                        $old_name=v.name;
                        for($y=0;$y<$length_val;$y++){
                            var $spec_id=$spec_val_obj[$y].sid;
                            var $id=$spec_val_obj[$y].id;
                            var $name=$spec_val_obj[$y].name;
                            $copy_obj=new Object();
                            $copy_obj.id=$old_id+";"+$spec_id+":"+$id;
                            $copy_obj.name=$old_name+";"+$name;
                            $sku_copy_array.push($copy_obj);
                        }

                    });
                    $sku_array=$sku_copy_array;
                    //console.log($sku_array);
                }
            }
            mergeTable()
            //合并单元格
            function mergeTable(){
                for(var i = 0; i < $sku_array.length; i ++){
                    var child_id_string = $sku_array[i]["id"].toString();
                    var child_id_array = child_id_string.split(";");
                    var sear_str = "";
                    $.each(child_id_array,function(w,q){
                        if(sear_str == ""){
                            sear_str += q;
                        }else{
                            sear_str += ";"+q;
                        }
                        if($("td[skuchild = '"+sear_str+"']").length > 1){
                            var check_array=$("td[skuchild = '"+sear_str+"']");
                            for( var $i=0; $i<check_array.length;$i++){
                                $check_obj=$(check_array[$i]);
                                if($i == 0){
                                    $check_obj.attr("rowspan",check_array.length);
                                }else{
                                    $check_obj.remove();
                                }

                            }
                        }
                    })
                }
            }
        })

    })
    ////////////////////////////////////
    $(function(){
        var role = "<?php echo $auth_arr['role']?>";
        if(role == '仓管')
        {
            $('.toggle').attr("readonly","readonly");
            $('.xiaoshi').hide();
        }

        var dataformInit = $("#form-article-add").serializeArray();
        var jsonTextInit = JSON.stringify({ dataform: dataformInit });
        $(".btn-primary").click(function(){
            $("#model_sku").val(model_sku_json);
            $("#model_attr").val(model_attr_json);
            var len = $('.key').length;
            var jsn='';
            var key='';
            var val='';
            var json='';
            for(i=0;i<len;i++){
                key = $("#jiji").find(".key").eq(i).val();
                val = $("#jiji").find(".val").eq(i).val();
                if(key && val)
                {
                    jsn+= "{\"key\":\""+key+"\",\"val\":\""+val+"\"},";
                }
            }
            jsn=jsn.substring(0,jsn.length-1)
            json = '['+jsn+']';
            $("#json").val(json);

            var dataform = $("#form-article-add").serializeArray();
            var jsonText = JSON.stringify({ dataform: dataform });
            //console.log(jsonTextInit)
            //console.log(jsonText)
            if(jsonTextInit==jsonText)
            {
                layer.alert("表单值没有改变！");
                return false;
            }
            else{

                $("#form-article-add").submit();
            }
        })
    })

    $(function(){
        var ue = UE.getEditor('editor');
        var ue1 = UE.getEditor('editor1');
        var ue2 = UE.getEditor('editor2');
    });

    $(function(){
        var logic = function( currentDateTime ){
            if (currentDateTime && currentDateTime.getDay() == 6){
                this.setOptions({
                    minTime:'11:00'
                });
            }else
                this.setOptions({
                    minTime:'8:00'
                });
        };
        $('#datetimepicker7').datetimepicker({
            onChangeDateTime:logic,
            onShow:logic
        });
    })
    $(function(){
        $('#models').on('click','#associated',function(){

            $(this).parent().find('#choose').show();
            $(this).parent().find('#sure').show();
            $(this).hide();
        })

        $('#models').on('click','#sure',function(){
            var obj = $(this).parent().find('#choose');
            $(this).parent().find('#assoc').val(obj.val())
            $(this).parent().find('#choose').hide();
            $(this).parent().find('#associated').show();
            $(this).hide();

        })
    })
    var model_id=0;
    $(function() {
        $('#butn').click(function(){
            $("#models").append($(".model").eq(0).clone().show());
            var num = $('#models .model').length-1;
            //$("#models").find('.model').eq(num).append("<div class='mark' style='display:none'>"+num+"</div>")
            model_id++;
        })

        $("#models").on('click','.selectFileBtn',function(){
            $(this).parent().find('.uploader-list-container').show()
            $fileField = $("<input class='proImg' type='file' name='proImg[]'/>");
            $fileField.hide();
            $(this).parent().find(".attachList").append($fileField);
            $fileField.trigger("click");
            $(".proImg").on("propertychange input", function(){
                $path = $(this).val();
                $filename = $path.substring($path.lastIndexOf("\\")+1);
                $attachItem = $('<div class="attachItem"><div class="left">a.gif</div><div class="right"><a href="#" title="删除附件">删除</a></div></div>');
                $attachItem.find(".left").html($filename);
                $(this).parent().append($attachItem);
            });
            $fileField.change(function(){
                $path = $(this).val();
                $filename = $path.substring($path.lastIndexOf("\\")+1);
                $attachItem = $('<div class="attachItem"><div class="left">a.gif</div><div class="right"><a href="#" title="删除附件">删除</a></div></div>');
                $attachItem.find(".left").html($filename);
                $(this).parent().append($attachItem);
            });

        });
        $("#models").on('click','.attachItem a',function(obj,i){
            $(this).parents('.attachItem').prev('input').remove();
            $(this).parents('.attachItem').remove();
        });

        $("#form-article-add").on('click','#down',function(){
            $(this).parent().find('.down-list-container').show()
            $fileField = $("<input type='file' name='down[]'/>");
            $fileField.hide();
            $(this).parent().find(".downList").append($fileField);
            $fileField.trigger("click");
            $fileField.change(function(){
                $path = $(this).val();
                $filename = $path.substring($path.lastIndexOf("\\")+1);
                $downItem = $('<div class="downItem"><div class="left">a.gif</div><div class="right"><a href="#" title="删除附件">删除</a></div></div>');
                $downItem.find(".left").html($filename);
                $(this).parent().append($downItem);
            });
        });
        $("#form-article-add").on('click','.downItem a',function(obj,i){
            $(this).parents('.downItem').prev('input').remove();
            $(this).parents('.downItem').remove();
        });

        $("#form-article-add").on('click','.btn1',function(){
            var obj = $(this).parent();
            var mm=$(this).attr('data-val')-0;
            $specifications = $("<div class='specifications' style='width:1000px;border:1px solid #ddd'><input data_val='"+mm+"' name='"+model_id+"-"+mm+"' style='margin-top: 5px;' class='sssss specifications_input' type='text'  placeholder='&nbsp;分类' > <button class='addbtn' data-val='1' style='border:none;background: none'>+</button> </div>");
            obj.append($specifications);
            $(this).attr('data-val',$(this).attr('data-val')-0+1);
        })

        $("#form-article-add").on('click','.addbtn',function(){
            var xx=$(this).prev().attr('data_val')-0;
            var obj = $(this).parent();
            var nn=$(this).attr('data-val')-0;
            $specifications1 = $("<div class='sss'><input name='att"+model_id+"-"+xx+"-"+nn+"' class='specifications_input' type=text  placeholder='&nbsp;属性' >&nbsp;&nbsp;<input class='specifications_input' type=text name='val"+model_id+"-"+xx+"-"+nn+"' placeholder='&nbsp;值'> </div>");
            obj.append($specifications1);
            //$("button[class=addbtn]:last").show()
            $(this).attr('data-val',nn+1);
            return false;
        })
        $(".add").click(function(){
            $jij = $("<div class='jij' style='margin-left: -3px;'>"+
                "<input type='text' class='key' name='jiji[key][]' style='width: 150px'>"+
                ":<input type='text' class='val' name='jiji[val][]' style='width: 150px'>"+
                " <span><a class='del' href='javascript:void(0)'>删除</a></span>"+
                "</div>");
            $('#jiji').append($jij);
        })
        $('#jiji').on('click','.del',function(){
            $(this).parents('.jij').remove();
        })
    });


</script>
<script>

    $(function() {
        $("#form-article-add").validate({
            rules: {
                'name': {
                    required: true,
                    maxlength:30,
                },
                'model_number': "required",
                'stock':"required",
                'title':{
                    required: true,
                    maxlength:50,
                },
                'price':{
                    required: true,
                    min:0,
                },

            },
            messages: {
                'name':{
                    required: "输入商品名称",
                    maxlength: "商品名称不能超过30个中文字"
                },
                'model_number':"必填",
                'stock':"必填",
                'title':{
                    required: "输入商品标题",
                    maxlength: "标题不能超过50个中文字"
                },
                'price':{
                    required: "填写商品原价",
                    min:"价格大于0",
                },

            }
        });
    });
</script>
<script type="text/javascript" src="/assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    $(function(){
        //商品标题处理
        $('.contact_goods').keyup(function(){

            var contact_goods = $(this).val();
            if(contact_goods == '')
            {
                $(this).parents('#contact_goods').find('option').remove();
                $('#multi-goods').hide();
                return false;
            }
            var url = '/product/add';
            $_this = $(this)
            $.post(url,{contact_goods:contact_goods,mark:1},function(data){
                if(data){
                    $('#multi-goods').show();
                    $("#goods_sure_sku").hide();
                    $("#goods_sure").show();
                    $('#multi-goods-sku').hide();
                    var parsedJson = jQuery.parseJSON(data);
                    $_this.parents().find('#multi-goods option').remove();
                    $.each(parsedJson, function(i, item) {
                        $_this.parents().find('#multi-goods').append('<option value='+item.id+'>'+item.title+'</option>');

                    });
                }else if(data == ''){
                    $('#multi-goods').hide();
                }
            })
        })
        $("#goods_sure").click(function(){
            var url = '/product/add';
            var goods_model_id=$("#multi-goods").val();
            //console.log(goods_model_id);
            $("#multi-goods").hide();

            $.post(url,{goods_model_id:goods_model_id},function(data){
                //console.log(data);
                $('#multi-goods').html('');
                jsonObj = eval('(' + data + ')');
                var smalls='';
                if(data){
                    //console.log(data);
                    for(i=0;i<jsonObj.length;i++){
                        smalls+="<option value="+jsonObj[i]['aid']+">"+jsonObj[i]['guige']+"</option>"
                    }
                    $('#multi-goods-sku').empty();
                    $('#multi-goods-sku').show();
                    $("#goods_sure").hide();
                    $("#goods_sure_sku").show();
                    $('#multi-goods-sku').append(smalls) ;
                }

            })
        });
        $("#goods_sure_sku").click(function(){
            var strs= new Array();
            var contact_goods_str = $("#multi-goods-sku").val()+',';
            //alert(contact_goods_str);
            if($("#multi-goods-sku").val()==null)
            {
                contact_goods_str = '';
                if($('#odiv_goods span').length<1){
                    $('#odiv_goods').append("<span style='color:red'>关联商品不能为空</span>");
                }
            }
            var contact_goods_str_arr = $('#contact_goods').find('.contact_goods_str').val();
            strs=contact_goods_str.split(",");
            for (i=0;i<strs.length ;i++ )
            {
                if(contact_goods_str_arr.indexOf(strs[i])>=0 && strs[i]!='')
                {
                    strs.splice($.inArray(strs[i],strs),1);
                }
            }
            var new_contact_goods_str = strs.join(",");

            var n=(contact_goods_str_arr.split(',')).length;


            if(contact_goods_str_arr.indexOf(contact_goods_str)>=0)
            {
                if($('#odiv_goods span').length<1){
                    $('#odiv_goods').append("<span style='color:red'>关联商品不能重复</span>");
                }
                contact_goods_str = '';
            }else{
                $('#odiv_goods span').remove();
            }
            $('#contact_goods').find('.contact_goods_str').val(contact_goods_str_arr + new_contact_goods_str);

        })
    })
</script>
</body>
</html>