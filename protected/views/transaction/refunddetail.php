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
    <script src="/js/H-ui.js" type="text/javascript"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <title></title>
</head>
<style>
    button{color:#fff;border:1px solid #2a8bcc;background: #2a8bcc;border-radius:2px; width:60px;height:30px;}
    .xx{color:#fff;border:1px solid #2a8bcc;background: #2a8bcc;border-radius:2px; width:65px;height:30px;}
</style>
<body>
<div class="margin clearfix">
    <div class="Refund_detailed">
        <div class="Numbering">订单编号:<b><?php echo $refundDetail['order_id']?></b></div>
        <div class="detailed_style">
            <!--退款信息-->
            <div class="Receiver_style">
                <div class="title_name">
                    <?php
                    if($refundDetail['apply_type'] ==1)
                    {
                        echo '退款信息';
                    }elseif ($refundDetail['apply_type'] ==2){
                        echo '换货信息';
                    }else{
                        echo '维修信息';
                    }
                    ?>

                </div>
                <div class="Info_style clearfix">
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 申请人姓名： </label>
                        <div class="o_content"><?php echo $user_info['receive_name']?></div>
                    </div>
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 申请人电话： </label>
                        <div class="o_content"><?php echo $user_info['receive_phone']?></div>
                    </div>
                    <?php if($refundDetail['apply_type'] ==1):?>
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 退款方式：</label>
                        <div class="o_content">
                            <?php
                                if($refundDetail['payment'] == 1)
                                {
                                    echo '微信退款';
                                }elseif($refundDetail['payment']==2){
                                    echo '支付宝退款';
                                }elseif ($refundDetail['payment']==3)
                                {
                                    echo '网银退款';
                                }else{
                                    echo '线下退款';
                                }
                            ?>
                        </div>
                    </div>
                    <?php endif;?>
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 商品数量：</label>
                        <div class="o_content"><?php echo $refundDetail['number']?></div>
                    </div>
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 商品金额：</label>
                        <div class="o_content"><?php echo $refundDetail['number']*$refundDetail['price']?>元</div>
                    </div>
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 快递名称：</label>
                        <?php if($refundDetail['apply_type']==4):?>
                        <div class="o_content"><?php echo $refundDetail['express_model_next']?></div>
                        <?php else:?>
                        <div class="o_content"><?php echo $refundDetail['express_model']?></div>
                        <?php endif;?>
                    </div>
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 快递单号：</label>
                        <?php if($refundDetail['apply_type']==4):?>
                            <div class="o_content"><?php echo $refundDetail['logistics_number_next']?></div>
                        <?php else:?>
                            <div class="o_content"><?php echo $refundDetail['logistics_number']?></div>
                        <?php endif;?>

                    </div>
                    <!--<div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 退款账户：</label>
                        <div class="o_content">招商储蓄卡</div>
                    </div>
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 退款账号：</label>
                        <div class="o_content">345678*****5678</div>
                    </div>-->
                    <?php if($refundDetail['apply_type'] ==1):?>
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 退款金额：</label>
                        <div class="o_content"><?php echo $refundDetail['number']*$refundDetail['price']?>元</div>
                    </div>
                    <?php endif;?>
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2">申请日期：</label>
                        <div class="o_content"><?php echo $refundDetail['create_time']?></div>
                    </div>
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 状态：</label>
                        <div class="o_content af_stu">
                            <?php if($refundDetail['apply_type'] ==1):?>
                                <?php if($refundDetail['status'] == 1):?>
                                    申请退款
                                <?php elseif($refundDetail['status'] == 2):?>
                                    买家填写单号中
                                <?php elseif($refundDetail['status'] == 3):?>
                                    等待商家确认
                                <?php elseif($refundDetail['status'] == 4):?>
                                    已收货
                                <?php elseif($refundDetail['status'] == 5):?>
                                    重新发货
                                <?php elseif($refundDetail['status'] == 6):?>
                                    已完成
                                <?php else:?>
                                    <span style="color:red">拒绝退款</span>
                                <?php endif?>
                            <?php elseif ($refundDetail['apply_type'] ==2):?>
                                <?php if($refundDetail['status'] == 1):?>
                                    申请换货
                                <?php elseif($refundDetail['status'] == 2):?>
                                    买家填写单号中
                                <?php elseif($refundDetail['status'] == 3):?>
                                    等待商家确认
                                <?php elseif($refundDetail['status'] == 4):?>
                                    已收货
                                <?php elseif($refundDetail['status'] == 5):?>
                                    重新发货
                                <?php elseif($refundDetail['status'] == 6):?>
                                    已完成
                                <?php else:?>
                                    <span style="color:red">拒绝换货</span>
                                <?php endif?>
                            <?php elseif ($refundDetail['apply_type'] ==3):?>
                                <?php if($refundDetail['status'] == 1):?>
                                    申请维修
                                <?php elseif($refundDetail['status'] == 2):?>
                                    买家填写单号中
                                <?php elseif($refundDetail['status'] == 3):?>
                                    等待商家确认
                                <?php elseif($refundDetail['status'] == 4):?>
                                    已收货
                                <?php elseif($refundDetail['status'] == 5):?>
                                    重新发货
                                <?php elseif($refundDetail['status'] == 6):?>
                                    已完成
                                <?php else:?>
                                    <span style="color:red">拒绝维修</span>
                                <?php endif?>
                            <?php else:?>
                                <?php if($refundDetail['status'] == 1):?>
                                    申请补发
                                <?php elseif($refundDetail['status'] == 5):?>
                                    重新发货
                                <?php elseif($refundDetail['status'] == 6):?>
                                    已完成
                                <?php else:?>
                                    <span style="color:red">拒绝补发</span>
                                <?php endif?>
                            <?php endif;?>

                        </div>
                    </div>
                </div>
            </div>
            <?php if($refundDetail['status'] == 0):?>
            <div class="Receiver_style">
                <div class="title_name"><span style="color:red">拒绝理由</span></div>
                <div class="reund_content">
                    <?php echo $refundDetail['refuse_reason']?>
                </div>
            </div>

            <?php endif;?>
            <div class="Receiver_style">
                <div class="title_name">申请凭据</div>
                <div class="reund_content">
                    <?php echo $refundDetail['apply_proof']?>
                </div>
            </div>
            <div class="Receiver_style">
                <div class="title_name">退款说明</div>
                <div class="reund_content">
                    <?php echo $refundDetail['returned_goods_reason']?>
                </div>
            </div>
			<div class="Receiver_style">
                <div class="title_name">问题描述</div>
                <div class="reund_content">
                    <?php echo $refundDetail['question_describe']?>
                </div>
            </div>
            <div class="Receiver_style">
                <div class="title_name">细节展示</div>
                <div class="reund_content">
                    <?php
                    	if($refundDetail['img_id'])
                    	{
                    		$res = CTransaction::search_upload_img($refundDetail['img_id']);
                    		foreach($res as $v)
                    		{
                    			echo "<div style='display:inline-block;margin-left:20px;border:1px solid #eee;padding:20px;' ><img src='http://www.rdbuy.com.cn$v[img_url]'></div>";
                    		}
                    	}
                    ?>
                </div>
            </div>
            <!--产品信息-->
            <?php if($refundDetail['meal_id'] != 0):?>
            <div class="product_style">
                <div class="title_name">产品信息</div>
                <div class="Info_style clearfix">
                    <div class="product_info clearfix">
                        <a href="#" class="img_link"><img src="/images/product/<?php echo $refundDetail['pic']?>"></a>
                          <span>
                          <p><?php echo $refundDetail['name'].'【'.$refundDetail['model_number'].'】'?></p>
                          <p>品牌：<?php echo $refundDetail['brand_id']?></p>
                          <p>数量：<?php echo $refundDetail['number']?></p>
                          <p>价格：<b class="price"><i>￥</i><?php echo $refundDetail['price']?></b></p>

                    </div>
                </div>
            </div>
            <?php elseif($refundDetail['brand_id'] != 0):?>
            <div class="product_style">
                <div class="title_name">产品信息</div>
                <div class="Info_style clearfix">
                    <div class="product_info clearfix">
                        <a href="http://rdbuy.com.cn/product/productdetail?model_id=<?php echo $refundDetail['goods_model_id']?>" class="img_link"><img src="<?php echo CImages::searchone($refundDetail['goods_model_id'])['image_url']?>"></a>
                          <span>
                          <p><?php echo $refundDetail['name'].'【'.$refundDetail['model_number'].'】'?></p>
                          <p>品牌：<?php echo CProduct::searchBrandbyid($refundDetail['brand_id'])['brandname']?></p>
                          <p>数量：<?php echo $refundDetail['number']?></p>
                          <p>价格：<b class="price"><i>￥</i><?php echo $refundDetail['price']?></b></p>
                          <span>
                              <?php if($refundDetail['apply_type'] ==1):?>
                                  <?php if($refundDetail['status'] == 1):?>
                                      <p class="status">申请退款</p>
                                  <?php elseif($refundDetail['status'] == 2):?>
                                      <p class="status" style="width:25%">买家填写单号中</p>
                                  <?php elseif($refundDetail['status'] == 3):?>
                                      <p class="status" style="width:25%">等待商家确认</p>
                                  <?php elseif($refundDetail['status'] == 4):?>
                                      <p class="status">同意退款</p>
                                  <?php elseif($refundDetail['status'] == 5):?>
                                      <p class="status">重新发货</p>
                                  <?php elseif($refundDetail['status'] == 6):?>
                                      <p class="status">已完成</p>
                                  <?php else:?>
                                      <p class="status">拒绝退款</p>
                                  <?php endif?>
                              <?php elseif ($refundDetail['apply_type'] ==2):?>
                                  <?php if($refundDetail['status'] == 1):?>
                                      <p class="status">申请换货</p>
                                  <?php elseif($refundDetail['status'] == 2):?>
                                      <p class="status" style="width:25%">买家填写单号中</p>
                                  <?php elseif($refundDetail['status'] == 3):?>
                                      <p class="status" style="width:25%">等待商家确认</p>
                                  <?php elseif($refundDetail['status'] == 4):?>
                                      <p class="status">同意换货</p>
                                  <?php elseif($refundDetail['status'] == 5):?>
                                      <p class="status">重新发货</p>
                                  <?php elseif($refundDetail['status'] == 6):?>
                                      <p class="status">已完成</p>
                                  <?php else:?>
                                      <p class="status">拒绝换货</p>
                                  <?php endif?>
                              <?php elseif ($refundDetail['apply_type'] ==3):?>
                                  <?php if($refundDetail['status'] == 1):?>
                                      <p class="status">申请维修</p>
                                  <?php elseif($refundDetail['status'] == 2):?>
                                      <p class="status" style="width:25%">买家填写单号中</p>
                                  <?php elseif($refundDetail['status'] == 3):?>
                                      <p class="status" style="width:25%">等待商家确认</p>
                                  <?php elseif($refundDetail['status'] == 4):?>
                                      <p class="status">同意维修</p>
                                  <?php elseif($refundDetail['status'] == 5):?>
                                      <p class="status">重新发货</p>
                                  <?php elseif($refundDetail['status'] == 6):?>
                                      <p class="status">已完成</p>
                                  <?php else:?>
                                      <p class="status">拒绝维修</p>
                                  <?php endif?>
                              <?php else:?>
                                  <?php if($refundDetail['status'] == 1):?>
                                      <p class="status">申请补发</p>

                                  <?php elseif($refundDetail['status'] == 5):?>
                                      <p class="status">重新发货</p>
                                  <?php elseif($refundDetail['status'] == 6):?>
                                      <p class="status">已完成</p>
                                  <?php else:?>
                                      <p class="status">拒绝维修</p>
                                  <?php endif?>
                              <?php endif?>
                          </span>
                    </div>
                </div>
            </div>
            <?php endif;?>
        </div>
    </div>
    <div>
        <div id="reply" style=" display:none">
            <textarea name="reject" id="reject" style="margin-left: 0px;width:37%;" class="reply"  rows="5" cols="0"><?php echo $refundDetail['reply']?></textarea>
            <div><span style="color:red"> *</span><span style="color:#ccc">如果不同意请填写理由</span></div>
        </div>
        <?php if($auth_arr['role'] == '财务'||$auth_arr['role'] == '超级管理员'):?>
        <div style="margin-top:10px;">
            <?php if($refundDetail['status'] == 1):?>
            <span>
                <?php if($refundDetail['apply_type'] ==1):?>
                    是否同意退款：
                <?php elseif($refundDetail['apply_type'] ==2):?>
                    是否同意换货：
                <?php elseif($refundDetail['apply_type'] ==3):?>
                    是否同意维修：
                <?php else:?>
                    是否同意补发：
                <?php endif;?>
            </span>
            <input type="radio" value="1" name="isagree" checked="checked">是
            <input type="radio" value="0" name="isagree">否<br/><br/>
	            <button id='noagree' style="width:5%">
                    <?php if($refundDetail['apply_type'] ==1):?>
                        拒绝退款
                    <?php elseif($refundDetail['apply_type'] ==2):?>
                        拒绝换货
                    <?php elseif($refundDetail['apply_type'] ==3):?>
                        拒绝维修
                    <?php elseif($refundDetail['apply_type'] ==4):?>
                        拒绝补发
                    <?php endif;?>
                </button>
                <?php if($refundDetail['apply_type'] ==4):?>
                    <input class="xx" id='fahuo' type="button" value="发货"/>
                <?php else:?>
                    <button  id="write_order" style="width:8%">请买家填写单号</button>
                <?php endif;?>
            <?php endif;?>
            <?php if($refundDetail['status'] == 2):?>
            	<input type="button" style="background:#ccc;width:10%" disabled="disabled" value="买家填写单号中..."/>
            <?php elseif($refundDetail['status'] == 3):?>
            	<button id='sureagree' style="width:5%">确认收货</button>
            <?php elseif($refundDetail['status'] == 4):?>
                <?php if($refundDetail['apply_type'] ==1):?>
                    <input id='complete' type="button" style="background:#ccc;width:5%" value="同意退款"/>
                <?php elseif($refundDetail['apply_type'] ==2):?>
                    <input id='fahuo' type="button" style="background:#ccc;width:5%" value="发货"/>
                <?php else:?>
                    <input id='fahuo' type="button" style="background:#ccc;width:5%" value="发货"/>
                <?php endif;?>

            <?php elseif($refundDetail['status'] == 5):?>
            	<input type="button" style="background:#ccc;width:5%" value="重新发货"/>
            <?php elseif($refundDetail['status'] == 6):?>
            	<input id="wanc" type="button" style="background:#ccc;width:5%" disabled="disabled" value="已完成"/>
            <?php elseif($refundDetail['status'] == 0):?>
            	<input type="button" style="background:#ccc;width:80px" disabled="disabled" value="拒绝退款"/>
            <?php endif;?>
            <input class="pid" type="hidden" value="<?php echo $refundDetail['refund_pid']?>">
            <input class="refund_id" type="hidden" value="<?php echo $refundDetail['id']?>">
        </div>
        <?php endif;?>
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
        </div>
    </div>
</div>
<!-- 退款-->
<div id="refund" style=" display:none">
    <div class="">
        <div class="content_style">

            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"><span style="color:red">*</span> 输入金额 </label>
                <div class="col-sm-9" style="margin-top:3px;">
                    <div class="col-sm-9"><input type="number" id="refund_money" name="refund_money" placeholder="退款金额" class="col-xs-10 col-sm-5" style="margin-left:0px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    $(function(){

        $('#fahuo').click(function(){
            var apply_type="<?php echo $refundDetail['apply_type']?>";
            var url = '/transaction/refunddetail';
            var refund_id = "<?php echo $refundDetail['id']?>";
            var goods_name = "<?php echo $refundDetail['name'].'【'.$refundDetail['model_number'].'】'?>";
            var order_id = "<?php echo $refundDetail['order_id']?>";
            layer.open({
                type: 1,
                title: '发货',
                maxmin: true,
                shadeClose:false,
                area : ['500px' , ''],
                content:$('#Delivery_stop'),
                btn:['确定','取消'],
                yes: function(index){
                    var logistics_num = $('#form-field-1').val();
                    var send_method = $('#form-field-select-1').val();
                    if($('#form-field-1').val()==""){
                        layer.alert('快递号不能为空！',{
                            title: '提示框',
                            icon:0,
                        })
                    }else{
                        layer.confirm('提交成功！',function(index){
                            $.post(url,{apply_type:apply_type,order_id:order_id,goods_name:goods_name,sign:1,refund_id:refund_id,logistics_num:logistics_num,send_method:send_method},function(data){
                                if(data){
                                    $('#fahuo').val('已完成')
                                    $('#fahuo').attr("disabled","disabled")
                                    layer.msg('已发货!',{icon: 6,time:1000});
                                }
                            })
                        });
                        layer.close(index);
                    }
                }
            })

        })
        $('input[type=radio][name=isagree]').change(function() {
            if (this.value == '0') {
                $('#reply').show();
            }else{
                $('#reply').hide();
            }
        });
        /*拒绝退款*/
        $('#noagree').click(function(){
            var af_stu = $('.af_stu').text();
            var isagree = $("input[name='isagree']:checked").val();
            var url = '/transaction/refunddetail';
            var refund_id = $('.refund_id').val();
            var goods_name = "<?php echo $refundDetail['name'].'【'.$refundDetail['model_number'].'】'?>";
            var order_id = "<?php echo $refundDetail['order_id']?>";
            var reject = $('#reject').val();
            if(reject == '')
            {
				layer.alert('请填写拒绝理由!')
				return false;
            }
            $.post(url,{af_stu:af_stu,goods_name:goods_name,order_id:order_id,isagree:isagree,refund_id:refund_id,reject:reject},function(data){
                if(data == 1) {
                    layer.alert('已拒绝退款！',function(){
                    	window.location.href='/transaction/refund'
                    });
                }else{
                	layer.alert('拒绝退款失败！')
                }
            })
        })
        /*填写单号*/
        $('#write_order').click(function(){
            var af_stu = $('.af_stu').text();
            var goods_name = "<?php echo $refundDetail['name'].'【'.$refundDetail['model_number'].'】'?>";
            var order_id = "<?php echo $refundDetail['order_id']?>";
        	var order_detail_id = "<?php echo $refundDetail['order_detail_id'];?>";
        	var number = "<?php echo $refundDetail['number'];?>";
        	var detail_number = "<?php echo $refundDetail['detail_number'];?>";
        	var url = '/transaction/refunddetail';
            var refund_id = $('.refund_id').val();
            $.post(url,{af_stu:af_stu,goods_name:goods_name,order_id:order_id,refund_id:refund_id,order_detail_id:order_detail_id,detail_number:detail_number,number:number},function(data){
                if(data == 1) {
                    layer.alert('审核成功！',function(){
                    	window.location.href='/transaction/refund'
                    });

                }else if(data == 2){
                	layer.alert('请检查退款商品数量！',function(){
                    	window.location.href='/transaction/refunddetail?id=<?php echo $refundDetail['id']?>'
                    });
                }
            })
        })
        /*确定收货*/
         $('#sureagree').click(function(){
             var af_stu = $('.af_stu').text();
             var goods_name = "<?php echo $refundDetail['name'].'【'.$refundDetail['model_number'].'】'?>";
             var order_id = "<?php echo $refundDetail['order_id']?>";
        	var url = '/transaction/refunddetail';
            var refund_id = $('.refund_id').val();
            $.post(url,{af_stu:af_stu,goods_name:goods_name,order_id:order_id,refund_id:refund_id,sureagree:1},function(data){
                if(data == 1) {
                    layer.alert('已收货！',function(){
                    	window.location.href='/transaction/refund'
                    });

                }else{
                	layer.alert('收货失败！')
                }
            })
        })
        /*订单完成*/
        $('#complete').click(function(){
        	var url = '/transaction/refunddetail';
            var goods_name = "<?php echo $refundDetail['name'].'【'.$refundDetail['model_number'].'】'?>";
            var manager = "<?php echo Yii::app()->user->manager;?>";
            var order_id = "<?php echo $refundDetail['order_id'];?>";
            var payment = "<?php echo $refundDetail['payment'];?>";
            //alert(payment);return false;
            var refund_money = "<?php echo $refundDetail['price']*$refundDetail['number'];?>";
            var refund_id = $('.refund_id').val();
            $('#refund_money').val(refund_money);
            //alert(refund_money);return false;
            layer.open({
                type: 1,
                title: '退款',
                maxmin: true,
                shadeClose:false,
                area : ['500px' , ''],
                content:$('#refund'),
                btn:['确定','取消'],
                yes: function(index){
                    var refund_money1 = $('#refund_money').val();
                    if(refund_money1>refund_money)
                    {
                        layer.alert('输入金额不能大于商品价格');
                        return false;
                    }
                    $.post(url,{goods_name:goods_name,refund_id:refund_id,manager:manager,refund_money:refund_money1,order_id:order_id,payment:payment,refund_status:'1'},function(data){
                        var data = eval('(' + data + ')');
                        if(data.code == 200) {
                            layer.alert(data.message,function(){
                                //window.location.href='/transaction/refund'
                            });
                        }else{
                            layer.alert('退款失败！')
                        }
                    })
                }
            })
            /*$.post(url,{refund_id:refund_id,manager:manager,refund_money:refund_money,order_id:order_id,payment:payment,refund_status:'1'},function(data){
                if(data == 1) {
                    layer.alert('退款成功！',function(){
                    	//window.location.href='/transaction/refund'
                    });

                }else{
                	layer.alert('退款失败！')
                }
            })*/
        })
    })

</script>



























