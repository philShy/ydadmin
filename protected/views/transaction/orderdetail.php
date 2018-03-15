<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/css/style.css"/>
    <link href="/assets/css/codemirror.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/ace.min.css"/>
    <link rel="stylesheet" href="/font/css/font-awesome.min.css"/>
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/assets/css/ace-ie.min.css"/>
    <![endif]-->
    <script src="/js/jquery-1.9.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script type="text/javascript" src="/js/H-ui.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript"></script>
    <script src="/assets/laydate/laydate.js" type="text/javascript"></script>
    <script src="/assets/js/jquery.easy-pie-chart.min.js"></script>
    <script src="/js/lrtk.js" type="text/javascript"></script>
    <title>订单详细</title>
</head>
<style>
.detailed_style .Info_style .product_info a.img_link {
    width: 50px !important;
    height: 50px !important;
    border-right: 1px solid rgb(221, 221, 221);
    padding: 1px;
}
.img_link img{width:50px;height:50px}
.abtn{background:green;color:#fff !important;border-radius:2px;}
.col-xs-3{width:25%}
</style>
<script>
    var chars = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    function generateMixed(n) {
        var res = "";
        for(var i = 0; i < n ; i ++) {
            var id = Math.ceil(Math.random()*35);
            res += chars[id];
        }
        return res;
    }
    var url = '/transaction/orderdetail';
    var store_url = 'http://192.168.1.47:81/order/adminAddorder';
    var url3 = '/transaction/orderform';
    function message(obj,order_id,sub_id,state){
        if(state == 1)
        {
            $.post(url,{order_id:order_id,sub_id:sub_id,state:state},function(data){
                var data = JSON.parse(data);
                if(data.code == 200)
                {
                    $(obj).html('已接单请发货')
                    layer.msg(data.message, {icon: 1});
                }else{
                    layer.msg(data.message, {icon: 1});
                }
            })
        }else if(state == 2)
        {
            $.post(url3,{order_id:sub_id,type:1,detect:'detect'},function(data){

                if(data==2){
                    layer.open({
                        type: 1,
                        title: '发货',
                        maxmin: true,
                        shadeClose:false,
                        area : ['500px' , ''],
                        content:$('#Delivery_stop'),
                        btn:['确定','取消'],
                        yes: function(index, layero){
                            var logistics_num = $('#form-field-1').val();
                            var send_method = $('#form-field-select-1').val();
                            var shipper = $("input[ name='shipper']").val();
                            var boxNum = $("input[ name='boxNum']").val();
                            var remark = $("input[ name='remark']").val();
                            var isReceipt = $('input:radio:checked').val();
                            var consignee = $("input[ name='consignee']").val();
                            if($('#form-field-1').val()==""){
                                layer.alert('快递号不能为空！',{
                                    title: '提示框',
                                    icon:0,
                                })
                            }else if($('#form-field-1').val()!="")
                            {
                                if(send_method == '1'||send_method == '3')
                                {
                                    if(logistics_num.length==12)
                                    {
                                        layer.confirm('提交成功！',function(index){
                                            $.post(url3,{is_send:1,order_sub_id:orderid,logistics_num:logistics_num,send_method:send_method,shipper:shipper,boxNum:boxNum,remark:remark,consignee:consignee,isReceipt:isReceipt,type:type,order_id:order_fid},function(data){
                                                if(data){
                                                    $_this.parent().parent().find("span").text('已发货');
                                                    $_this.removeClass('btn-success')
                                                    layer.msg('已发货!',{icon: 6,time:1000});
                                                }
                                            })
                                        });
                                    }else{
                                        layer.alert('单号错误')
                                    }
                                }
                                else if(send_method == '2')
                                {
                                    if(logistics_num.length==11)
                                    {
                                        layer.confirm('提交成功！',function(index){
                                            $.post(url3,{is_send:1,order_sub_id:orderid,logistics_num:logistics_num,send_method:send_method,shipper:shipper,boxNum:boxNum,remark:remark,consignee:consignee,isReceipt:isReceipt,type:type,order_id:order_fid},function(data){
                                                if(data){
                                                    $_this.parent().parent().find("span").text('已发货');
                                                    $_this.removeClass('btn-success')
                                                    layer.msg('已发货!',{icon: 6,time:1000});
                                                }
                                            })
                                        });
                                        layer.close(index);
                                    }else{
                                        layer.alert('单号错误')
                                    }
                                }
                            }
                        }
                    })
                }else if(data == 1){
                    layer.alert('还未接单！')
                    return false;
                }else if(data > 2){
                    layer.alert('已经发货')
                    return false;
                }
            })
        }else if(state == 3)
        {
            $.post(url3,{order_id:order_id,order_sub_id:sub_id,is_receive:1},function(data){
                var data = JSON.parse(data);
                if(data.code == 200)
                {
                    layer,message('已收货')
                    $(obj).html('已收货')
                    layer.msg(data.message, {icon: 1});
                }else{
                    layer.msg(data.message, {icon: 1});
                }
            })
        }
    }
    function no_sub_message(obj,order_id,price){
        layer.open({
            type: 1,
            title: '确认转账',
            maxmin: true,
            shadeClose:false,
            area : ['500px' , ''],
            content:$('#zhz'),
            btn:['确定','取消'],
            yes: function(index){
                var phone = $('#phone').val();
                var password = $('#password').val();
                if(!phone||!password)
                {
                    layer.alert('手机号，密码必填');
                    return false;
                }
                $.ajax({
                    type: "post",
                    async: false,
                    url: store_url,
                    data:{order_id:generateMixed(12)+order_id,phone:phone,pwd:generateMixed(3)+password},
                    dataType: "jsonp",
                    jsonp:"callback",
                    success: function(data){
                        if(data.data == true)
                        {//xxjc:线下检测
                            dddd(order_id,price);
                            window.location.href='/transaction/orderform';
                        }
                    },
                    error: function(a,b,c){
                        console.log(c);
                        layer.msg('失败');
                    }
                });
                layer.close(index);
            }
        })
    }
    function dddd(orderid,price) {
        $.post('/transaction/orderform',{order_id:orderid,price:price,xxjc:1},function(data){
            var data = JSON.parse(data);
            if(data.code == 200)
            {
                layer.msg(data.message, {icon: 1});
            }else{
                layer.msg(data.message, {icon: 1});
            }
        })
    }

</script>
<body>
<?php $receive = CUser::searchReceiver($orderone['address_id']);?>
<!-- 确认转账-->
<div id="zhz" style=" display:none">
    <div class="">
        <div class="content_style">
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"><span style="color:red">*</span> 输入电话 </label>
                <div class="col-sm-9" style="margin-top:3px;">
                    <div class="col-sm-9"><input type="text" id="phone" name="refund_money" placeholder="电话" class="col-xs-10" style="margin-left:0px;"></div>
                </div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"><span style="color:red">*</span> 输入密码 </label>

                <div class="col-sm-9" style="margin-top:3px;">
                    <div class="col-sm-9"><input type="password" id="password" name="refund_money" placeholder="密码" class="col-xs-10" style="margin-left:0px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--发货-->
<div id="Delivery_stop" style=" display:none">
    <div class="">
        <div class="content_style">
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"><span style="color:red">*</span> 快递公司 </label>
                <div class="col-sm-9"><select class="form-control" id="form-field-select-1" name="logistics_company">
                        <option value="">--选择快递--</option>
                        <option value="1">顺风快递</option>
                        <option value="2">跨越快递</option>
                        <option value="3">联邦快递</option>

                    </select></div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"><span style="color:red">*</span> 快递号 </label>
                <div class="col-sm-9"><input type="text" id="form-field-1" name="logistics_num" placeholder="快递号" class="col-xs-10 col-sm-5" style="margin-left:0px;"></div>
            </div>

            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"><span style="color:red">*</span> 发货人 </label>
                <div class="col-sm-9"><input type="text" id="form-field-1" name="shipper" placeholder="发货人" class="col-xs-10 col-sm-5" style="margin-left:0px;"></div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 收货单位 </label>
                <div class="col-sm-9"><input type="text" id="form-field-1" name="consignee" placeholder="收货单位" class="col-xs-10 col-sm-5" style="margin-left:0px;"></div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"><span style="color:red">*</span> 包裹箱数 </label>
                <div class="col-sm-9"><input type="text" id="form-field-1" name="boxNum" placeholder="包裹箱数" class="col-xs-10 col-sm-5" style="margin-left:0px;"></div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"><span style="color:red">*</span> 备注 </label>
                <div class="col-sm-9"><input type="text" id="form-field-1" name="remark" placeholder="备注" class="col-xs-10 col-sm-5" style="margin-left:0px;"></div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 是否回单 </label>
                <div class="col-sm-9" style="margin-top:3px;">
                    是：<input type="radio" value="0" name="isReceipt">
                    否：<input type="radio" value="1" name="isReceipt">
                </div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1">货到付款 </label>
                <div class="col-sm-9"><label><input name="checkbox" type="checkbox" class="ace" id="checkbox"><span style="margin-top: 6px" class="lbl"></span></label></div>
            </div>
        </div>
    </div>
</div>
<div class="margin clearfix">
    <div class="Order_Details_style">
        <div class="Numbering">订单编号:<b>
        <?php 
        if($type == 1)
        {
        	echo $orderone['order_id'].'-'.$orderone['sub_id'];
        }elseif ($type == 0)
        {
        	echo $orderone['id'];
        }
          
        ?></b></div>
    </div>
    <div class="detailed_style">
        <!--收件人信息-->
        <div class="Receiver_style">
            <div class="title_name">
            <?php 
            if($type == 1)
            {
            	echo $orderone['order_id'].'-'.$orderone['sub_id'];
            }elseif ($type == 0)
            {
            	echo $orderone['id'];
            }
             ?></div>
            <div class="Info_style clearfix">
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 收件人姓名： </label>
                    <div class="o_content"><?php echo $receive['receive_name'] ?></div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 收件人电话： </label>
                    <div class="o_content"><?php echo $receive['receive_phone'] ?></div>
                </div>

                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 收件地址： </label>
                    <div style="width:100%;">
                        <?php echo $receive['receive_province'].$receive['receive_city'] .$receive['receive_county'].$receive['receive_detail']?>
                    </div>
                </div>
            </div>
        </div>
        <!--订单信息-->
        <div class="product_style">
            <div class="title_name">产品信息</div>
            <div class="Info_style clearfix">
         <?php if($type == 0):?>
				<?php
					$detail = $orderone['goods_details'];
					$brand_detail = $detail['brand'];
					$meal_detail = $detail['meal'];
				?>
               <?php if(count($brand_detail)!=0):?>
                <div class="product_info clearfix" style="width: 99%">
                    <div>品牌：</div>
                    <?php foreach ($brand_detail as $all_b_v):?>
                    <div style="padding-left:50px;float: left">
                      <?php
                      $one_detail = CProduct::searchGoodsmodelbyid($all_b_v['goods_model_id']);
                      $one_status = CProduct::searchGoodsmodelstatus_byid($all_b_v['goods_model_id'],$orderone['id']);
                      $img = CImages::searchOne($all_b_v['goods_model_id']);
                      ?>

                      <div ><a href="http://rdbuy.com.cn/product/productdetail?model_id=<?php echo $all_b_v['goods_model_id']?>" class="img_link"><img style="width:50px;height:50px"  src="<?php echo $img['image_url']?>"/></a></div>
                      <div>
                      <p style="width:300px;height:30px;overflow: hidden"><a href="http://rdbuy.com.cn/product/productdetail?model_id=<?php echo $all_b_v['goods_model_id']?>" style="text-decoration: none">名称：
                      <?php
	                      $sku_str = explode(';', $all_b_v['combination']);
	                      foreach($sku_str as $kk=>$vv)
	                      {
	                      	$propv_name = CProduct::search_prop_byid(explode(':', $vv)[0])['name'];
	                      	$propv_name = CProduct::search_propv_byid(explode(':', $vv)[1])['name_value'];
	                      	$aa[$kk]=$prop_name.':'.$propv_name.',';
	                      }
	                      $strr = implode('', $aa);
	                      if(substr( $strr, 0, 1 )==':')
	                      {
	                      	$rcombination = $all_b_v['model_number'];
	                      }else{
	                      	$rcombination = $all_b_v['model_number'].'('.implode('', $aa).')';
	                      }
	                      echo $rcombination;
                      ?>
                      </a></p>
                      <?php  $status =CTransaction::search_refundstatus_byorderdetaiid($all_b_v['id']);?>
                      <p>状态：
                      			<?php if(empty($status)):?>
                                <b style="color:green">正常</b>
                                <?php else:?>
                                <b style="color:red">申请售后</b>
                                <?php endif;?>
                      </p>
                      <p>数量：<b class="price" style="font-size: 14px;"><?php echo $all_b_v['model_num']; ?></b></p>
                      <p>价格：<b class="price" style="font-size: 14px;"><i>￥</i><?php echo $all_b_v['price1']; ?></b></p>
                      </div>
                    </div>
                    <?php endforeach;?>
                    <?php endif;?>
                </div>
                <?php if(count($meal_detail[0])!=0):?>
                    <div class="product_info clearfix" style="width: 99%">
                        <div>套餐：</div>
                        <?php foreach ($meal_detail[0] as $all_m_v):?>
                        <div style="padding-left:50px;float: left">
                              <?php
                              $one_detail = CProduct::searchGoodsmodelbyid($all_m_v['goods_model_id']);
                              $one_status = CProduct::searchGoodsmodelstatus_byid($all_m_v['goods_model_id'],$orderone['id']);
                              $img = CImages::searchOne($all_b_v['goods_model_id']);
                              ?>
                              <div ><a href="#" class="img_link"><img style="width:50px;height:50px"  src="<?php echo $img['image_url']?>"/></a></div>
                          <div>
                          <p style="width:300px;height:30px;overflow: hidden"><a href="#" style="text-decoration: none">名称：
                              <?php
                              $ss = CProduct::searchGoodsModelSku_name_byskuid2($all_m_v['goods_sku_id']);
                              $goods_name = CProduct::searchGoodsname_byid($all_m_v['goods_model_id'])['name'];
                              echo $ss;
                               ?></a></p>
                          <?php  $status =CTransaction::search_refundstatus_byorderdetaiid($all_b_v['id']);?>
                          <p>状态：
                                    <?php if(empty($status)):?>
                                    <b style="color:green">正常</b>
                                    <?php else:?>
                                    <b style="color:red">申请售后</b>
                                    <?php endif;?>
                          </p>
                          <p>数量：<b class="price" style="font-size: 14px;"><?php echo $all_b_v['model_num']; ?></b></p>
                          <p>价格：<b class="price" style="font-size: 14px;"><i>￥</i><?php echo $all_b_v['price1']; ?></b></p>
                          </div>
                        </div>
                        <?php endforeach;?>
                <?php endif;?>
          <?php elseif ($type == 1):?>
                <?php 

                	$sub_detail = CTransaction::search_sub_all_detail($id);

                	foreach($sub_detail as $val)
                	{
                		if($val['brand_id']!=0)
                		{
                			$sub_brand[]=$val['id'];
                		}else
                		{
                			$sub_meal[]=$val['id'];
                		}
                	}
                	
                	if($sub_brand)
                	{
                		$sub_brand_detail = CTransaction::search_sub_detail_bybrand($sub_brand);
                	}
                	if($sub_meal)
                	{
                		$sub_meal_detail = CTransaction::search_sub_meal_bymeal($sub_meal);
                	}
                ?>
                	<?php if($sub_brand_detail):?>
                    <div class="product_info clearfix" style="width: 99%">
                    <div>品牌商品</div>
                    <?php foreach($sub_brand_detail as $b_v):?>
                    <div class='aa' style="padding-left:50px;float: left;">
                      <?php 
                      $one_sub_detail = CProduct::searchGoodsmodelbyid($b_v['goods_model_id']);
                      $img = CImages::searchOne($b_v['goods_model_id']);
                      ?>
                      <div class='dd'><a href="http://rdbuy.com.cn/product/productdetail?model_id=<?php echo $b_v['goods_model_id']?>" class="img_link"><img style="width:50px;height:50px"  src="<?php echo $img['image_url']?>"/></a></div>
                      <div>
                      <p style="width:300px;height:30px;overflow: hidden"><a href="http://rdbuy.com.cn/product/productdetail?model_id=<?php echo $b_v['goods_model_id']?>" style="text-decoration: none">名称：
                      <?php
                       if($b_v['prop_value'])
                       {
                       		$ss = '('.$b_v['prop_value'].')';
                       }else{
                       	    $ss = '';
                       }
                       echo $one_sub_detail['model_number'].$ss; 
                       ?>
                      
                      </a></p>
                      <?php  $status =CTransaction::search_refundstatus_byorderdetaiid($b_v['id']);?>
                      <p>状态：
                                <?php if(empty($status)):?>
                                <b style="color:green">正常</b>
                                <?php else:?>
                                <b style="color:red">申请售后</b>
                                <?php endif;?>
                      </p>
                      <p>数量：<b class="price" style="font-size: 14px;"><?php echo $b_v['number']; ?></b></p>
                      <p>价格：<b class="price" style="font-size: 14px;"><i>￥</i><?php echo $b_v['price']; ?></b></p>
                      <?php 
                      $sub_brand_sum += $b_v['number']*$b_v['price'];
                      $sub_brand_num += $b_v['number'];
                      ?>
                      </div>
                    </div>
               	<?php endforeach;?>
                </div>
                <?php endif;?>
                <?php endif;?>
                <?php if($sub_meal_detail):?>
      			<div class="product_info clearfix" style="width: 99%">
                    <div>套餐商品</div>
                    <?php foreach($sub_meal_detail as $m_v):?>
                    <div class='aa' style="padding-left:50px;float: left;">
                    
                      <?php 
                      $one_sub_detail = CProduct::searchGoodsmodelbyid($m_v['goods_model_id']);
                      $img = CImages::searchOne($m_v['goods_model_id']);
                      ?>
                      <div class='dd'><a href="#" class="img_link"><img style="width:50px;height:50px"  src="<?php echo $img['image_url']?>"/></a></div>
                      <div>
                      <p style="width:300px;height:30px;overflow: hidden"><a href="#" style="text-decoration: none">名称：
                      <?php 
	                      if($m_v['prop_value'])
	                       {
	                       		$ss = '('.$m_v['prop_value'].')';
	                       }else{
	                       	    $ss = '';
	                       }
	                       echo $one_sub_detail['model_number'].$ss; 
	                  ?> 
                      </a></p>
                      <?php  $status =CTransaction::search_refundstatus_byorderdetaiid($one_sub_detail['id']);?>
                      <p>状态：
                                <?php if(empty($status)):?>
                                <b style="color:green">正常</b>
                                
                                <?php else:?>
                                <b style="color:red">申请售后</b>
                                <?php endif;?>
                      </p>
                      <p>数量：<b class="price" style="font-size: 14px;"><?php echo $m_v['number']; ?></b></p>
                      <p>价格：<b class="price" style="font-size: 14px;"><i>￥</i><?php echo $m_v['price']; ?></b></p>
                      
                      </div>
                    </div>
                    <?php 
                    $sub_meal_sum += $m_v['number']*$m_v['price'];
                    $sub_meal_num += $m_v['number'];
                    ?>
               	<?php endforeach;?>
                </div>
                <?php endif;?>
            </div>
        </div>
        <!--总价-->
        <div class="Total_style">
            <div>备注：&nbsp;&nbsp;<?php echo $orderone['beizhu']?></div>
        </div>
        <div class="Total_style">
        
            <div class="Info_style clearfix">
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 支付方式：</label>
                   
                    <div class="o_content"><?php if($orderone['payment']==1){echo '在线支付';}else{echo '公司转账';}?></div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 支付状态： </label>
                    <div class="o_content">
                    <?php if($type == 1):?>

                        <?php if($orderone['sub_status'] == 1):?>
                            <span onclick="message(this,<?php echo $orderone['order_id']?>,<?php echo $orderone['sub_id']?>,<?php echo $orderone['sub_status']?>)" style="color: white;background: #438eb9">已支付请接单</span>
                        <?php elseif($orderone['sub_status'] == 2):?>
                            <span onclick="message(this,<?php echo $orderone['order_id']?>,<?php echo $orderone['sub_id']?>,<?php echo $orderone['sub_status']?>)" style="color: white;background: #438eb9">已接单请发货</span>
                        <?php elseif($orderone['sub_status'] == 3):?>
                            <span onclick="message(this,<?php echo $orderone['order_id']?>,<?php echo $orderone['sub_id']?>,<?php echo $orderone['sub_status']?>)" style="color: white;background: #438eb9;cursor: pointer">已发货</span>&nbsp;<span style="font-size: 10px;color: #ccc">点击收货</span>
                        <?php elseif($orderone['sub_status'] == 4):?>
                            <span style="color: white;background: #438eb9">已收货</span>
                        <?php elseif($orderone['sub_status'] == 5):?>
                            <span style="color: white;background: #438eb9">已评价</span>
                        <?php endif;?>
                    <?php elseif($type == 0):?>

                    	<?php if($orderone['status'] == 3):?>
                            <span style="color: white;background: #438eb9">已取消</span>
                        <?php elseif($orderone['status'] == 1):?>
                            <span onclick="no_sub_message(this,<?php echo $orderone['id']?>,<?php echo $orderone['price']?>)" style="color: white;background: #438eb9">线下支付请确认</span>
                        <?php endif;?>
                    <?php endif;?>
                    </div>
                </div>
                 <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 发票类型： </label>
                    <div class="o_content">
                        <?php if($orderone['invoice']['invoice_type'] == 1):?>
                            个人发票
                        <?php elseif($orderone['invoice']['invoice_type'] == 2):?>
                           	 增值发票
                        <?php else:?>
                          	  电子发票
                        <?php endif;?>
                    </div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 物流公司： </label>
                    <div class="o_content">
                    <?php 
                    if($orderone['logistics_type']==1)
                    {
                    	echo "顺丰快递";
                    }elseif ($orderone['logistics_type']==2)
                    {
                    	echo "跨越快递";
                    }elseif ($orderone['logistics_type']==3)
                    {
                    	echo "联邦快递";
                    }
                    ?>
                    </div>
                    <?php if($orderone['logistics_type']):?>
                        <div class="editLogisticsType" style="display:inline-block;background: red;color:#fff;cursor: pointer">修改物流</div>
                    <?php endif;?>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 快递单号： </label>
                    <div class="o_content"><?php echo $orderone['logistics_num'] ?></div>
                    <?php if($orderone['logistics_num']):?>
                        <div class="editOrderNum" style="display:inline-block;background: red;color:#fff;cursor: pointer">修改单号</div>
                    <?php endif;?>
                </div>
                
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 订单生成日期： </label>
                    <div class="o_content" ><?php echo $orderone['create_time'] ?></div>
                </div>
                <div class="col-xs-3">
                    <label class="label_name" for="form-field-2"> 接单日期： </label>
                    <div class="o_content" ><?php echo $orderone['receive_time'] ?></div>
                </div>
                <div class="col-xs-3">
                	<label class="label_name" for="form-field-2"> 发货日期： </label>
                    <div class="o_content" ><?php echo $orderone['send_time'] ?></div>
                </div>
               
            </div>
            <?php if($type == 1):?>
            <div class="Total_m_style">
               
          <span class="Total_price">
                    总价：<b><?php echo $sub_meal_sum+$sub_brand_sum;?></b>元</span></div>
        </div>
        <?php elseif ($type == 0):?>
    	<div class="Total_m_style">
                
          <span class="Total_price">
                    总价：<b><?php echo $orderone['price'];?></b>元</span></div>
        </div>
        <?php endif;?>
        <!--物流信息-->
        <div class="Logistics_style clearfix">
            <div class="title_name">物流信息</div>
            <!--<div class="prompt"><img src="images/meiyou.png" /><p>暂无物流信息！</p></div>-->
           <?php
            $nu=$orderone['logistics_num'];
            if($orderone['logistics_type']==1){
            	$post_data = array();
            	$post_data["customer"] = '8186605F2FECB4187AAE01D1FA2CF993'; //快递100的东东
            	$key= 'JVuHtyMQ8221';
            	$post_data["param"] = json_encode(array(
            			'com'=>'shunfeng',
            			'num'=>$nu,
            	));
            	$url='http://poll.kuaidi100.com/poll/query.do';
            	$post_data["sign"] = md5($post_data["param"].$key.$post_data["customer"]);
            	$post_data["sign"] = strtoupper($post_data["sign"]);
            	$o="";
            	foreach ($post_data as $k=>$v)
            	{
            		$o.= "$k=".urlencode($v)."&";   //默认UTF-8编码格式
            	}
            	$post_data=substr($o,0,-1);
            	$urls= $url.'?'.$post_data;

            }else if($orderone['logistics_type']==2){
            	$com='kuayue';
            	$urls = "http://api.kuaidi100.com/api?id=c3e24078b3048b18&com=$com&nu=$nu&valicode=&show=0&muti=1&order=desc";

            }else if($orderone['logistics_type']==3){
            $com='lianbangkuaidi';
            $urls = "http://api.kuaidi100.com/api?id=c3e24078b3048b18&com=$com&nu=$nu&valicode=&show=0&muti=1&order=desc";

            }else if($orderone['logistics_type']==0){
				echo "暂无快递信息";$urls=null;die;
			}
             $contents= file_get_contents($urls);
           //var_dump($contents);
          $s=  json_decode($contents,true);

         $wuliu=array_column($s,$s['date'],index_key);
	?>
	<div data-mohe-type="kuaidi_new" class="g-mohe " id="mohe-kuaidi_new">
                <div id="mohe-kuaidi_new_nucom">
                    <div class="mohe-wrap mh-wrap">
                        <div class="mh-cont mh-list-wrap mh-unfold">
                            <div class="mh-list">
                                <ul>
											<?php foreach ($wuliu as $ke=>$va):?>
											<?php foreach ($va as $k=>$v):?>
                 										  <li class="first">
                              							  <p><?php echo $v['time']?></p>
							                              <p><?php echo $v['context']?></p>
							                              <span class="before"></span><span class="after"></span><?php if($k==0){echo "<i
							                              class='mh-icon mh-icon-new'></i>";}?></li>
   											<?php endforeach;?>
											<?php endforeach;?>
	 								</ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="Button_operation">
            <button onclick="article_save_submit();" class="btn btn-primary radius" type="submit"><i
                    class="icon-save "></i>返回上一步
            </button>

            <button onclick="layer_close();" class="btn btn-default radius" type="button">
                &nbsp;&nbsp;取消&nbsp;&nbsp;</button>
        </div>
    </div>
</div>
</body>
</html>
<script>
    $(function(){
        //修改物流类型
        $('.editLogisticsType').click(function(){
            var sub_id = "<?php echo $id?>";
            var url = "/transaction/orderdetail";
            layer.open({
                type: 1,
                title: '更改物流方式',
                area: ['300px', '150px'],
                skin: 'yourclass',
                btn:['提交','取消'],
                content: '<select class="newEdit" style="margin: 20px 0 0 95px" type="text"><option value=1>--选择物流--</option><option value=1>--顺丰快递--</option><option value=2>--跨越快递--</option><option value=3>--联邦快递--</option></select>',
                yes:function()
                {
                    var newEdit = $('.newEdit').val();
                    $.post(url,{sub_id:sub_id,send_method:newEdit,edit:'logistics_type'},function(data){
                        if(data){
                            window.location.reload(true);
                        }
                    })
                }
            })
        })
        //修改物流单号
        $('.editOrderNum').click(function(){
            var logistics_type = "<?php echo $orderone['logistics_type']?>";
            var sub_id = "<?php echo $id?>";
            var url = "/transaction/orderdetail";
            layer.open({
                type: 1,
                title: '更改快递单号',
                area: ['300px', '150px'],
                skin: 'yourclass',
                btn:['提交','取消'],
                content: '<input class="newEdit" style="margin: 20px 0 0 65px" type="number">',
                yes:function()
                {
                    var newEdit = $('.newEdit').val();
                    if(newEdit=='')
                    {
                        layer.alert('请输入单号');
                        return false;
                    }
                    else if(newEdit!="")
                    {
                        if(logistics_type == '1'||logistics_type == '3')
                        {
                            if(newEdit.length==12)
                            {
                                $.post(url,{sub_id:sub_id,logistics_num:newEdit,edit:'logistics_num'},function(data){
                                    if(data){
                                        window.location.reload(true);
                                    }
                                })
                            }else{
                                layer.alert('单号错误')
                            }
                        }
                        else if(logistics_type == '2')
                        {
                            if(newEdit.length==11)
                            {
                                $.post(url,{sub_id:sub_id,logistics_num:newEdit,edit:'logistics_num'},function(data){
                                    if(data){
                                        window.location.reload(true);
                                    }
                                })
                                layer.close(index);
                            }else{
                                layer.alert('单号错误')
                            }
                        }
                    }
                }
            })
        })
    })
</script>



























