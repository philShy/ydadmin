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
    <script type="text/javascript" src="/js/H-ui.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <script src="/assets/laydate/laydate.js" type="text/javascript"></script>
    <script src="/assets/js/jquery.easy-pie-chart.min.js"></script>
    <script src="/js/lrtk.js" type="text/javascript" ></script>
    <title>商品订单信息</title>
</head>
<style>
	.no-padding-right{width:24.6666% !important}
    .table_order {border:1px; border-collapse:collapse; width:100%; height:100%;}
    .table_order td{border:solid 1px #ccc;text-align:center;height: }
    .table_order table td{ border:0;text-align:left;padding:2px 0;}
    ul li{float:left}
    .list_right_style{margin-left: 0 !important;}
    #page .page_right a{text-decoration:none;display:inline-block;
        width:40px; height: 25px;font-size: 14px;color: #fff;background: #6fb3e0;
        margin-left: 3px;line-height: 25px;}
    #page .page_right a:hover{background: #2a8bcc}
    .search_style button {background:#6fb3e0;border:none; border-radius:2px;height:35px;width:100px;color:#fff}
    /* #sub_table tr:nth-child(1){border-bottom:1px solid #ccc;}
    #tables tr:nth-child(1){border-bottom:none;} */
    .bgc{background: red;color:#fff}
</style>
<body>
<div class="margin clearfix">
    <div class="cover_style" id="cover_style">
        <div class="top_style Order_form" id="Order_form_style">
            <div class="type_title">商品订单信息
            </div>
            <!--<div class="hide_style clearfix">
                <?php /*foreach( $cate_array as $key=>$value):*/?>
                <div class="proportion"> <div class="easy-pie-chart percentage" data-percent="<?php /*echo $value['percentage']*/?>" data-color="#D15B47"><span class="percent"><?php /*echo $value['percentage']*/?></span>%</div><span class="name"><?php /*echo $value['name']*/?></span></div>
                <?php /*endforeach;*/?>
            </div>-->
        </div>
        <!--内容-->
        <div class="centent_style" id="centent_style">
            <div class="search_style">
                <form action="/transaction/orderform" method="post">
                    <ul class="search_content clearfix">
                        <li><label class="l_f">&nbsp;订单编号</label><input name="search_order" type="text" class="text_add" placeholder="订单订单编号" style=" width:50%"></li>
                        <li><label class="l_f">开始时间</label><input class="inline laydate-icon" name="starttime" id="starttime" style=" margin-left:10px;"></li>
                        <li><label class="l_f">结束时间</label><input class="inline laydate-icon" name="endtime" id="endtime" style=" margin-left:10px;"></li>
                        <li style="width:90px;"><input type="submit" class="btn_search"></li>
                    </ul>
                </form>
            </div>
            <div class="search_style">
                <a href='/transaction/orderform'><button style="background:#2a8bcc;">所有订单</button></a>
                <?php if($auth_arr['role'] != '仓管'):?>
                    <a href='/transaction/orderform1'><button>未支付订单</button></a>
                    <a href='/transaction/orderform2'><button>待接单订单</button></a>
                    <a href='/transaction/orderform5'><button>待收货订单</button></a>
                    <a href='/transaction/orderform6'><button>已完成订单</button></a>
                    <a href='/transaction/orderform7'><button style="width:120px;">申请取消的订单</button></a>
                    <a href='/transaction/orderform3'><button>已取消订单</button></a>
                    <a href='/transaction/orderform8'><button>未开发票订单</button></a>
                <?php endif;?>
                <a href='/transaction/orderform4'><button>待发货订单</button></a>
                <span class="r_f">共：<b style="color: red"><?php echo $count?></b>笔</span>
            </div>
            <!--订单列表展示-->
            <table class="table_order" width="100%">
                <thead>
                <tr>
                    <td width="8%">订单编号</td>
                    <td width="40%">
                        	<div>商品详情</div>
                        <ul>
                            <li style="width:55%;text-align:center;border-top:1px solid #eee">商品名</li>
                            <li style="width:15%;text-align:center ;border-top:1px solid #eee">单价</li>
                            <li style="width:15%;text-align:center; border-top:1px solid #eee">数量</li>
                            <li style="width:15%;text-align:center; border-top:1px solid #eee">状态</li>
                        </ul>
                    </td>
                    <td width="8%">总价</td>
                    <td width="10%">订单时间</td>
                    <td width="8%">发票类型</td>
                    <td width="8%">订单状态</td>
                    <td width="18%">操作</td>
                </tr>
                <tr></tr>
                </thead>
                <tbody>
                <?php foreach($order_arr as $key=>$value):?>
                <?php $is_cancel=CTransaction::is_cancel_order($value['id']);?>
                <tr class='ppp'>
                    <td>
	                    <?php if($value['status']==2):?>
						<table width=100% height=100%>
						<?php foreach($value['goods_detail'] as $c_k=>$c_id):?>
						<?php $count_all[$key]+= count($c_id)-5?>
						<?php endforeach;?>
						<tr style='height:0px;'>
							<td style='text-align:center;width:50%;border-right:1px solid #ccc' rowspan=<?php echo $count_all[$key]+1?>>
								<?php if($c_id['sub_status']==1 && !$is_cancel && ($auth_arr['role'] == '销售' || $auth_arr['role'] == '超级管理员')):?>
								<a style='display:inline-block;margin-bottom:5px;border:1px solid #ccc' class = 'receive bgc' href = 'javascript:void(0);' order_sub_id = '<?php echo $value['id']?>'>请接单</a>
								<?php elseif($is_cancel && ($auth_arr['role'] == '销售' || $auth_arr['role'] == '超级管理员')):?>
                                <a style='display:inline-block;margin-bottom:5px;border:1px solid #ccc' class = 'qx bgc' href = 'javascript:void(0);' order_sub_id = '<?php echo $value['id']?>'>申请取消</a>
								<?php endif;?>
                                <?php echo $value['id'];?>
							</td>
						</tr>
						<?php foreach($value['goods_detail'] as $sub_k=>$sub_v):?>
							<tr>
								<td rowspan=<?php echo count($sub_v)-5 ?> class='orderid' style="height:50px;<?php if(count($sub_v)-5)?>border-bottom:1px solid #ccc;text-align: center;"><?php echo $sub_k;?></td>
							</tr>
						<?php endforeach;?>
						</table>
	                	<?php else:?>
                            <?php if($value['payment']==2 && $value['status']!=3 && ($auth_arr['role'] == '财务' || $auth_arr['role'] == '超级管理员')):?>
                                <a style='display:inline-block;margin-bottom:5px;border:1px solid #ccc' class = 'zhz bgc' href = 'javascript:void(0);' price = '<?php echo $value['price']?>' order_id = '<?php echo $value['id']?>'>转账</a>
                            <?php endif;?>
	                    <?php echo $value['id']?>
	                    <?php endif;?>
                    </td>
                    <?php if($value['status']!=2):?>

                    <?php $no_order = json_decode($value['goods_details'],true)?>
                    <td style="border-right:none;border-left:none">
                    <?php if($no_order['brand']):?>
                    <?php foreach ($no_order['brand'] as $goods_key=>$goods_value):?>
                      <table width="100%" cellpadding="4" cellspacing="0" border="0" style="border: none; ">
                        <tr>
                        		<td style="width:55%; ">
                                    <div style="width:100%;height:20px;overflow: hidden;text-align:left;margin-left:3px;">
                                    <?php
                                    $sku_str = explode(';', $goods_value['combination']);

									foreach($sku_str as $kk=>$vv)
                                    {
                                    	$propv_name = CProduct::search_prop_byid(explode(':', $vv)[0])['name'];
                                    	$propv_name = CProduct::search_propv_byid(explode(':', $vv)[1])['name_value'];
                                    	$aa[$kk]=$prop_name.':'.$propv_name.',';
                                    }
                                    $strr = implode('', $aa);

                                    if(substr( $strr, 0, 1 )==':')
                                    {
                                    	$rcombination = $goods_value['model_number'];
                                    }else{
                                    	$rcombination = $goods_value['model_number'].'('.implode('', $aa).')';
                                    }
	                                $goods_name = CProduct::searchGoodsname_byid($goods_value['goods_model_id'])['name'];
	                                echo $rcombination;
                                	?>
                                    </div>
                                </td>
                                <td  style="width:15%;">
              	                  <div style="width:100%;text-align:center;"><?php echo $goods_value['price1']; ?></div>
                                </td>
                                <td  style="width:15%;">
                                <div style="width:100%;text-align:center;"><?php echo $goods_value['model_num']?></div>
                                </td>
                              	<td  style="width:15%;">
                                <div style="width:100%;text-align:center;">
                                <?php $status =CTransaction::search_refundstatus_byorderdetaiid($goods_value['id']);?>
                                <?php if(empty($status)):?>
							    <span style="color:green">正常</span>
							    <?php else:?>
							    <span style="color:red">申请售后</span>
							    <?php endif;?>
                                </div>
                                </td>
                        </tr>
                        </table>
                        <?php endforeach;?>
                        <?php endif;?>

                        <?php if($no_order['meal'][0]):?>
                        <?php foreach ($no_order['meal'][0] as $goods_key=>$goods_value):?>
                      <table width="100%" cellpadding="4" cellspacing="0" border="0" style="border: none; ">
                        <tr>
                        		<td style="width:55%; ">
                                    <div style="width:100%;height:20px;overflow: hidden;text-align:left;margin-left:3px;">
                                    <?php
									$ss = CProduct::searchGoodsModelSku_name_byskuid2($goods_value['goods_sku_id']);
	                                $goods_name = CProduct::searchGoodsname_byid($goods_value['goods_model_id'])['name'];
	                                echo $goods_name;
                                	?>
                                    </div>
                                </td>
                                <td  style="width:15%;">

              	                  <div style="width:100%;text-align:center;"><?php echo $goods_value['unit_price']; ?></div>
                                </td>
                                <td  style="width:15%;">
                                <div style="width:100%;text-align:center;"><?php echo $goods_value['quantity']?></div>
                                </td>
                              	<td  style="width:15%;">
                                <div style="width:100%;text-align:center;">
                                    <?php //var_dump($goods_value);die;?>
                                <?php $status =CTransaction::search_refundstatus_byorderdetaiid($goods_value['id']);?>
                                <?php if(empty($status)):?>
							    <span style="color:green">正常</span>
							    <?php else:?>
							    <span style="color:red">申请售后</span>
							    <?php endif;?>
                                </div>
                                </td>
                        </tr>
                        </table>
                        <?php endforeach;?>
                        <?php endif;?>
                    </td>
                    <td style="border-right:none;border-left:none"><?php echo $value['price']?></td>
                    <td style="border-right:none;border-left:none"><?php echo date('Y-m-d',strtotime($value['create_time']))?></td>
                    <td style="border-right:none;border-left:none">
				      <?php $invoice = json_decode($value['invoice'],true)['invoice_type'];?>
				      <?php if($invoice == 1):?>
                            	个人发票
                                <?php if($value['is_invoice'] == 1):?>
                                <span>已开</span>
                                <?php else:?>
                                <span style="border:1px solid #ccc;cursor: pointer;" onclick="is_inv(<?php echo $value['id']?>,this)">未开</span>
                                <?php endif;?>

                      <?php elseif($invoice == 2):?>
                            	电子发票
                                <?php if($value['is_invoice'] == 1):?>
                                <span>已开</span>
                                <?php else:?>
                              <span style="border:1px solid #ccc;cursor: pointer;" onclick="is_inv(<?php echo $value['id']?>,this)">未开</span>

                          <?php endif;?>
                      <?php elseif($invoice == 3):?>
                            	<a class='zeng' orderid='<?php echo $value['id']?>' style='color:#2b7dbc' href='javascript:void(0)'>增值发票</a>
                                <?php if($value['is_invoice'] == 1):?>
                                <span>已开</span>
                                <?php else:?>
                              <span style="border:1px solid #ccc;cursor: pointer;" onclick="is_inv(<?php echo $value['id']?>,this)">未开</span>
                                <?php endif;?>
                      <?php else:?>
                      			无发票
                      <?php endif;?>
                    </td>
                    <td style="border-right:none;border-left:none">
                            <?php if($value['status'] == 1):?>
                            <span style="color: white;background: #438eb9">未支付</span>
                            <?php elseif($value['status'] == 2):?>
                                <?php if($sub_id['sub_status'] == 1):?>
                                <span style='border:1px solid #ccc'>
                                    <span class='dddd' style="color: white;background: #438eb9">已支付</span><br/>
                                </span>
                                <?php elseif($sub_id['sub_status'] == 2):?>
                                <span style="color: white;background: #438eb9">已接单<?php var_dump($sub_id)?></span>
                                <?php elseif($sub_id['sub_status'] == 3):?>
                                <span style="color: white;background: #438eb9">已发货</span>
                                    <br><a href="javascript:void(0)" onclick="is_recive(<?php echo $sub_id['order_id']?>,<?php echo $sub_id['id']?>,this)" style="color: orange;">是否收货</a>
                                <?php elseif($sub_id['sub_status'] == 4):?>
                                <span style="color: white;background: #438eb9">已收货</span>
                                <?php elseif($sub_id['sub_status'] == 5):?>
                                <span style="color: white;background: #438eb9">已评价</span>
                                <?php endif;?>
                            <?php elseif($value['status'] == 3):?>
                            <span style="color: white;background: #438eb9">已取消</span>
                            <?php endif;?>
                    </td>
                    <td style="border-right:none;border-left:none;height:44px;">
                        <?php if($value['status'] != 0): ?>
                            <a href='javascript:;' type="0" orderid='<?php echo $value['id']?>' title='发货'  class='btn btn-xs Delivery_stop1'><i class='fa fa-cubes bigger-120'></i></a>
                        <?php endif;?>
                        <a title="订单详细"  href="/transaction/orderdetail?id=<?php echo $value['id']?>&type=0"  class="btn btn-xs btn-info order_detailed" ><i class="fa fa-list bigger-120"></i></a>
                        <a style='display:none' title="删除" href="javascript:;"  onclick="Order_form_del(this,'<?php echo $value['id']?>')" class="btn btn-xs btn-warning" ><i class="fa fa-trash  bigger-120"></i></a>
                    </td>
                    <?php else:?>
                    <!-- 已拆分 -->
                   	<td colspan=9 width=100% >
                   	<?php $sub_id_arr = CTransaction::search_ordersub_id($value['id'],$status='');?>

	                	<table id='sub_table' width=100%>
		                	<tr>
			                	<td style="vertical-align:middle; text-align:center;padding:0">

									<table width="100%" height=100% cellpadding="4" cellspacing="0" border="0" style="border: none; ">
									<?php foreach($sub_id_arr as $sub_id):?>
										<?php
										$sub_order=CTransaction::search_suborder($sub_id['id']);
										$have_detail = CTransaction::search_have_detail($sub_id['id']);
										?>

										<?php if($sub_id['is_advance_order']==1):?>

										<?php $sum=0?>
											<tr>
												<td class='subid' style="border-bottom: 1px solid #ccc;width:40%;height:50px;" >
													<table width=100%>
														<tr>
															<td width=55%;>
																<div style="width:100%;height:20px;overflow: hidden;text-align:left;margin-left:3px">

																	<?php
																	if($have_detail[0]['prop_value'])
																	{
																		echo $have_detail[0]['goods_model_name'].'('.$have_detail[0]['prop_value'].')';
																	}else{
																		echo $have_detail[0]['goods_model_name'];
																	}

																	?>
																<div>
															</td>
															<td style="width:15%;">
							                                <div style="width:100%;text-align:center;"><?php echo $have_detail[0]['price']?></div>
							                                </td>
							                                <td  style="width:15%;">
							                                <div style="width:100%;text-align:center;"><?php echo $have_detail[0]['number']?></div>
							                                </td>
							                              	<td  style="width:15%;">
							                                <div style="width:100%;text-align:center;">
							                       			<?php $status =CTransaction::search_refundstatus_byorderdetaiid($have_detail[0]['id']);?>
							                                <?php if(empty($status)):?>
									                        <span style="color:green">正常</span>
									                        <?php else:?>
									                        <span style="color:red">申请售后</span>
									                        <?php endif;?>
							                                </div>
							                                </td>

														</tr>
													</table>
												</td>
												<td style="width:8%;text-align:center;border-bottom:1px solid #ccc"><?php echo ($have_detail[0]['price'])*($have_detail[0]['number'])?></td>
												<td style="width:10.2%;text-align:center;border-bottom:1px solid #ccc"><?php echo date('Y-m-d',strtotime($value['create_time']))?></td>
												<td style="width:8%;text-align:center;border-bottom:1px solid #ccc">
												 <?php $invoice = json_decode($value['invoice'],true)['invoice_type'];?>
											      <?php if($invoice == 1):?>
                                                            个人发票
                                                            <?php if($value['is_invoice'] == 1):?>
                                                            <span>已开</span>
                                                            <?php else:?>
                                                          <span style="border:1px solid #ccc;cursor: pointer;" onclick="is_inv(<?php echo $value['id']?>,this)">未开</span>
                                                            <?php endif;?>
							                      <?php elseif($invoice == 2):?>
							                            	电子发票
                                                            <?php if($value['is_invoice'] == 1):?>
                                                            <span>已开</span>
                                                            <?php else:?>
                                                          <span style="border:1px solid #ccc;cursor: pointer;" onclick="is_inv(<?php echo $value['id']?>,this)">未开</span>
                                                            <?php endif;?>
							                      <?php elseif($invoice == 3):?>
							                            	<a class='zeng' orderid='<?php echo $value['id']?>' style='color:#2b7dbc' href='javascript:void(0)'>增值发票</a>
                                                            <?php if($value['is_invoice'] == 1):?>
                                                            <span>已开</span>
                                                            <?php else:?>
                                                          <span style="border:1px solid #ccc;cursor: pointer;" onclick="is_inv(<?php echo $value['id']?>,this)">未开</span>
                                                            <?php endif;?>
                                                  <?php else:?>
							                      			无发票
							                      <?php endif;?>
												</td>
												<td style="width:8%;text-align:center;border-bottom:1px solid #ccc">

                                                        <?php if($value['status'] == 1):?>
                                                        <span style="color: white;background: #438eb9">未支付</span>
                                                        <?php elseif($value['status'] == 2):?>
                                                            <?php if($sub_id['sub_status'] == 1):?>
                                                            <span style='border:1px solid #ccc'>
                                                                <span class='dddd' style="color: white;background: #438eb9">已支付</span><br/>

                                                            </span>
                                                            <?php elseif($sub_id['sub_status'] == 2):?>
                                                            <span style="color: white;background: #438eb9">已接单</span>
                                                            <?php elseif($sub_id['sub_status'] == 3):?>
                                                            <span style="color: white;background: #438eb9">已发货</span>
                                                                <br><a href="javascript:void(0)" onclick="is_recive(<?php echo $sub_id['order_id']?>,<?php echo $sub_id['id']?>,this)" style="color: orange;">是否收货</a>
                                                            <?php elseif($sub_id['sub_status'] == 4):?>
                                                            <span style="color: white;background: #438eb9">已收货</span>
                                                            <?php elseif($sub_id['sub_status'] == 5):?>
                                                            <span style="color: white;background: #438eb9">已评价</span>
                                                            <?php endif;?>
                                                            <?php elseif($value['status'] == 3):?>
                                                            <span style="color: white;background: #438eb9">已取消</span>
                                                            <?php endif;?>

												</td>
												<td style="width:17.8%;text-align:center;border-bottom:1px solid #ccc;height:44px;">
												<?php if($value['status'] != 0): ?>
						                            <a href='javascript:;' type="1" order_fid='<?php echo $value['id']?>' orderid='<?php echo $sub_id['id']?>' title='发货'  class='btn btn-xs <?php if($sub_id['sub_status']==2){echo 'btn-success';}?> Delivery_stop1'><i class='fa fa-cubes bigger-120'></i></a>
						                        <?php endif;?>
						                        <a title="订单详细"  href="/transaction/orderdetail?id=<?php echo $sub_id['id']?>&type=1"  class="btn btn-xs btn-info order_detailed" ><i class="fa fa-list bigger-120"></i></a>
						                        <a style='display:none' title="删除" href="javascript:;"  onclick="Order_form_del(this,'<?php echo $value['id']?>')" class="btn btn-xs btn-warning" ><i class="fa fa-trash  bigger-120"></i></a>

												</td>

											</tr>

										<?php else:?>
											<tr>
												<td width=40% >
												<?php foreach($have_detail as $have_detail_val):?>
												<table width=100%>
												<tr>
													<td width=55% >
														<div style="width:100%;height:20px;overflow: hidden;text-align:left;margin-left:3px">
															<?php
															$goods_name = CProduct::searchGoodsname_byid($have_detail_val['goods_model_id'])['name'];
															if($have_detail_val['prop_value']!=''){
																$sds = '('.$have_detail_val['prop_value'].')';
															}else{
																$sds='';
															}
															echo $have_detail_val['goods_model_name'].$sds;
															?>
														</div>
													</td>
													<td style="width:15%;">
							                        <div style="width:100%;text-align:center;"><?php echo($have_detail_val['price']) ?></div>
							                        </td>
							                        <td  style="width:15%;">
							                        <div style="width:100%;text-align:center;"><?php echo($have_detail_val['number']) ?></div>
							                        </td>
							                        <td  style="width:15%;">
							                        <div style="width:100%;text-align:center;">
							                        <?php $status =CTransaction::search_refundstatus_byorderdetaiid($have_detail_val['id']);?>
							         				<?php if(empty($status)):?>
							                        <span style="color:green">正常</span>
							                        <?php else:?>
							                        <span style="color:red">申请售后</span>
							                        <?php endif;?>
							                        </div>
							                        </td>
													</tr>
												</table>
												<?php $sum += ($have_detail_val['price']*$have_detail_val['number']) ?>
												<?php endforeach;?>
												</td>
												<td style="width:8%;text-align:center;"><?php echo $sum?></td>
												<td style="width:10.2%;text-align:center;"><?php echo date('Y-m-d',strtotime($value['create_time']))?></td>
												<td style="width:8%;text-align:center;">
												<?php $invoice = json_decode($value['invoice'],true)['invoice_type'];?>
											      <?php if($invoice == 1):?>
							                            	个人发票
                                                            <?php if($value['is_invoice'] == 1):?>
                                                            <span>已开</span>
                                                            <?php else:?>
                                                          <span style="border:1px solid #ccc;cursor: pointer;" onclick="is_inv(<?php echo $value['id']?>,this)">未开</span>
                                                            <?php endif;?>
							                      <?php elseif($invoice == 2):?>
                                                            <?php if($value['is_invoice'] == 1):?>
                                                            <span>已开</span>
                                                            <?php else:?>
                                                          <span style="border:1px solid #ccc;cursor: pointer;" onclick="is_inv(<?php echo $value['id']?>,this)">未开</span>
                                                            <?php endif;?>
							                      <?php elseif($invoice == 3):?>
							                            	<a class='zeng' orderid='<?php echo $value['id']?>' style='color:#2b7dbc' href='javascript:void(0)'>增值发票</a>
                                                            <?php if($value['is_invoice'] == 1):?>
                                                            <span>已开</span>
                                                            <?php else:?>
                                                          <span style="border:1px solid #ccc;cursor: pointer;" onclick="is_inv(<?php echo $value['id']?>,this)">未开</span>
                                                            <?php endif;?>
                                                  <?php else:?>
							                      			无发票
							                      <?php endif;?>
												</td>
												<td style="width:8%;text-align:center;">

                                                        <?php if($value['status'] == 1):?>
                                                        <span style="color: white;background: #438eb9">未支付</span>
                                                        <?php elseif($value['status'] == 2):?>
                                                            <?php if($sub_id['sub_status'] == 1):?>
                                                            <span style='border:1px solid #ccc'>
                                                                <span class='dddd' style="color: white;background: #438eb9">已支付</span><br/>

                                                            </span>
                                                            <?php elseif($sub_id['sub_status'] == 2):?>
                                                            <span style="color: white;background: #438eb9">已接单</span>
                                                            <?php elseif($sub_id['sub_status'] == 3):?>
                                                            <span style="color: white;background: #438eb9">已发货</span>
                                                                <br><a href="javascript:void(0)" onclick="is_recive(<?php echo $sub_id['order_id']?>,<?php echo $sub_id['id']?>,this)" style="color: orange;">是否收货</a>
                                                            <?php elseif($sub_id['sub_status'] == 4):?>
                                                            <span style="color: white;background: #438eb9">已收货</span>
                                                            <?php elseif($sub_id['sub_status'] == 5):?>
                                                            <span style="color: white;background: #438eb9">已评价</span>
                                                            <?php endif;?>
                                                        <?php elseif($value['status'] == 3):?>
                                                        <span style="color: white;background: #438eb9">已取消</span>
                                                        <?php endif;?>

												</td>
												<td style="width:17.8%;text-align:center;height:44px;">
												<?php if($value['status'] != 0): ?>
					                            <a href='javascript:;' type="1" order_fid='<?php echo $value['id']?>' orderid='<?php echo $sub_id['id']?>' title='发货'  class='btn btn-xs <?php if($sub_id['sub_status']==2){echo 'btn-success';}?> Delivery_stop1'><i class='fa fa-cubes bigger-120'></i></a>
						                        <?php endif;?>
						                        <a title="订单详细"  href="/transaction/orderdetail?id=<?php echo $sub_id['id']?>&type=1"  class="btn btn-xs btn-info order_detailed" ><i class="fa fa-list bigger-120"></i></a>
						                        <a style='display:none' title="删除" href="javascript:;"  onclick="Order_form_del(this,'<?php echo $value['id']?>')" class="btn btn-xs btn-warning" ><i class="fa fa-trash  bigger-120"></i></a>

												</td>
											</tr>
										<?php endif;?>
									<?php endforeach;?>
									</table>
			                	</td>
		                	</tr>
	                	</table>
                	</td>
                    <?php endif;?>
                </tr>
                <?php endforeach;?>
                        <tr>
                            <td colspan="8">
                                <div id="page">
                                    <div class=page_left style="float: left">当前第：<?php echo $page.'/'.ceil($count/10);?>页</div>
                                    <div class=page_right style="float: right">
                                        <?php
                                        //echo $dd;
                                        echo CPage::newsPage($page,ceil($count/10),$where,$url);
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                </tbody>
            </table>
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
                <div class="col-sm-9"><input type="number" id="form-field-1" name="logistics_num" placeholder="快递号" class="col-xs-10 col-sm-5" style="margin-left:0px;"></div>
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
<div id="Zeng_info" style=" display:none">
    <div class="">
        <div class="content_style">
			<div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1">单位名称 </label>
                <div class="col-sm-9"><input readonly type="text" id='dw' class="col-xs-10 col-sm-5" style="margin-left:0px;"></div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1">纳税人识别码 </label>
                <div class="col-sm-9"><input readonly type="text" id='ns' class="col-xs-10 col-sm-5" style="margin-left:0px;"></div>
            </div>

            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1">注册地址</label>
                <div class="col-sm-9"><input readonly type="text" id='zc' class="col-xs-10 col-sm-5" style="margin-left:0px;"></div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 注册电话</label>
                <div class="col-sm-9"><input readonly type="text" id='ph' class="col-xs-10 col-sm-5" style="margin-left:0px;"></div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1">开户银行</label>
                <div class="col-sm-9"><input readonly type="text" id='bk' class="col-xs-10 col-sm-5" style="margin-left:0px;"></div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1">银行账户 </label>
                <div class="col-sm-9"><input readonly type="text" id='zh' class="col-xs-10 col-sm-5" style="margin-left:0px;"></div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1">税务登记证副本 </label>
                <div class="col-sm-9"><img id='nsdj' style='width:45px;height:45px' src='' /></div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1">一般纳税人证书 </label>
                <div class="col-sm-9"><img id='nszs' style='width:45px;height:45px' src='' /></div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 是否有开票资质 </label>
                <div class="col-sm-9" style="margin-top:3px;">
               	 是：<input id='is_audit' type="radio" value="0" name="is_audit">
                 否：<input id='not_audit' type="radio" value="1" name="is_audit">
                </div>
            </div>
            <div class="audit form-group"style="display:none"><label class="col-sm-2 control-label no-padding-right" for="form-field-1">拒绝理由</label>
                <div class="col-sm-9"><select class="form-control" id="audit_cause" name="">
                        <option value="">--拒绝理由--</option>
                        <option value="单位名称错误">单位名称错误</option>
                        <option value="纳税人识别码错误">纳税人识别码错误</option>
                        <option value="注册地址错误">注册地址错误</option>
                       	<option value="注册电话错误">注册电话错误</option>
                       	<option value="开户银行错误">开户银行错误</option>
                       	<option value="银行账户错误">银行账户错误</option>
                       	<option value="税务登记证副本不清晰或者未上传">税务登记证副本不清晰或者未上传</option>
                       	<option value="一般纳税人证书不清晰或者未上传">一般纳税人证书不清晰或者未上传</option>
                    </select></div>
            </div>
        </div>
    </div>
</div>
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
</body>
</html>
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
    function is_recive(order_id,order_sub_id,obj) {
        var url = '/transaction/orderform';
        layer.confirm('是否确认收货',function () {
            $.post(url,{order_id:order_id,order_sub_id:order_sub_id,is_receive:1},function(data) {
                if(data)
                {
                    layer.alert('已收货');
                    obj.style.display="none";
                }
            })
        })
    }
    //Delivery_stop1
function is_inv(order_id,obj)
{
    var url = '/transaction/orderform';
    layer.confirm('是否开票',function () {
        $.post(url,{orderid:order_id,is_inv:1},function(data) {
            if(data)
            {
                layer.alert('开票成功');
                obj.innerHTML="已开";
                obj.style.border="none";
            }
        })
    })
}
$(function(){
    var role = "<?php echo $auth_arr['role']?>";
    if(role=='仓管' || role=='超级管理员')
    {
        $('.Delivery_stop1').show();
    }else{
        $('.Delivery_stop1').hide();
    }
    $('.zhz').click(function(){
        var orderid = $(this).attr('order_id');
        var price = $(this).attr('price');
        //var store_url = 'http://rdbuy.com.cn/order/adminAddorder';
        var store_url = 'http://192.168.1.55:81/order/adminAddorder';
        var url = '/transaction/orderform';
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
                    data:{order_id:generateMixed(12)+orderid,phone:phone,pwd:generateMixed(3)+password},
                    dataType: "jsonp",
                    jsonp:"callback",
                    success: function(data){
                        if(data.data == true)
                        {//xxjc:线下检测
                            dddd(orderid,price);
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
    })
    $('.qx').click(function(){
        $_this = $(this);
        var url = '/transaction/orderform7';
        var order_id = $(this).attr('order_sub_id');
        var payment = $(this).attr('payment');
        var pay_payment = $(this).attr('pay_payment');
        var order_status = $(this).attr('order_status');
        var pay_price = $(this).attr('pay_price');
        layer.confirm('是否取消',function(index){
            $.post(url,{pay_payment:pay_payment,order_id:order_id,order_status:order_status,qx:1,payment:payment,pay_price:pay_price},function(data){
                if(data){
                    $_this.parents('.ppp').remove();

                    layer.msg('已取消!',{icon: 6,time:1000});
                }
            })
        });
    })
    function dddd(orderid,price) {
        $.post('/transaction/orderform',{order_id:orderid,price:price,xxjc:1},function(data1){
            if(data1 == 1)
            {
                layer.msg('成功');
            }
        })
    }
	$('.zeng').click(function(){
		var url = '/transaction/orderform';
        $_this = $(this);
        var orderid = $(this).attr('orderid')
		$.post(url,{orderid:orderid,signs:2},function(data){
			var parsedJson = jQuery.parseJSON(data);
            //console.log(parsedJson);return false;
			var id = parsedJson.id;
			var not_audit_cause = parsedJson.not_audit_cause;
			var company_info = jQuery.parseJSON(parsedJson.company_info);
			//console.log(parsedJson)
			var person_info = jQuery.parseJSON(parsedJson.person_info);
			$('#dw').val(company_info.invoice3_company_name);
			$('#ns').val(company_info.invoice3_company_code);
			$("#zc").val(company_info.invoice3_company_address);
			$("#ph").val(company_info.invoice3_company_phone);
			$("#bk").val(company_info.invoice3_company_bank);
			$('#zh').val(company_info.invoice3_company_account);
			if(not_audit_cause)
			{
				var all_options = document.getElementById("audit_cause").options;
				for (i=0; i<all_options.length; i++){
				      if (all_options[i].value == not_audit_cause)  // 根据option标签的ID来进行判断  测试的代码这里是两个等号
				      {
				         all_options[i].selected = true;
				      }
				}
			}
			if(parsedJson.is_audit == '0'){
				$('#is_audit').prop('checked',true)
			}else if(parsedJson.is_audit == '1'){
                $('.audit').show();
				$('#not_audit').prop('checked',true)
			}
			$('#nsdj').attr('src','http://www.rdbuy.com.cn/'+parsedJson.img1);
			$('#nszs').attr('src','http://www.rdbuy.com.cn/'+parsedJson.img2);
			$('#nsdj').click(function(){
				var newurl1='http://www.rdbuy.com.cn/'+parsedJson.img1;
				layer.open({
					type: 1,
					title: false,
					closeBtn: 0,
					area: '500px',
					skin: 'layui-layer-nobg', //没有背景色
					shadeClose: true,
					content: '<img style=width:500px src='+newurl1+'>'
					});
			})
            $("#not_audit").click(function(){
                $('.audit').show();
            })
            $("#is_audit").click(function(){
                $('.audit').hide();
            })
			$('#nszs').click(function(){

				var newurl2='http://www.rdbuy.com.cn/'+parsedJson.img2;
				layer.open({
					type: 1,
					title: false,
					closeBtn: 0,
					area: '500px',
					skin: 'layui-layer-nobg', //没有背景色
					shadeClose: true,
					content: '<img style=width:500px src='+newurl2+'>'
					});
				})
			layer.open({
            type: 1,
            title: '审核',
            maxmin: true,
            shadeClose:false,
            area : ['500px' , ''],
            content:$('#Zeng_info'),
            btn:['确定','取消'],
            yes: function(index, layero){
            	var is_audit = $("input[name='is_audit']:checked").val();
                var audit_cause = $("#audit_cause").val();
                if(is_audit!=undefined){
	                if(is_audit == '1'){

	                	if($("#audit_cause").val()==""){
	                        layer.alert('请填写拒绝理由！',{
	                            title: '提示框',
	                            icon:0,
	                     	})
	                	}else{
	                		layer.confirm('提交成功！',function(index){
		                        $.post(url,{id:id,is_audit:is_audit,audit_cause:audit_cause},function(data){
		                            if(data){
		                                $_this.parents("tr").find(".zeng").text('已审核');
		                                layer.msg('已审核!',{icon: 6,time:1000});
		                            }
		                        })
		                        window.location.href='/transaction/orderform';
		                    });

		                }
	                }else if(is_audit == '0'){
	                    layer.confirm('提交成功！',function(index){
	                        $.post(url,{id:id,is_audit:is_audit},function(data){
	                            if(data){
                                    $_this.text('已开增值税发票');
	                                $_this.parents("tr").find("span").text('已审核');
	                                layer.msg('已审核!',{icon: 6,time:1000});
	                            }
	                        })
	                        //window.location.href='/transaction/orderform';
	                    });

	                }
                }else{
					layer.alert('请审核！')
                }
            }
        })
	})
	})
})
	$(function(){
		$('.receive').click(function(){
			$_this = $(this);
			var url = '/transaction/orderform';
			var order_id = $(this).attr('order_sub_id');
			layer.confirm('是否接单',function(index){
				$.post(url,{order_id:order_id,order_status:2,is_jiedan:1},function(data){
                    if(data){
                    	$_this.parents('.ppp').find('.dddd').text('已接单');
                    	$_this.parents('.ppp').find('.Delivery_stop1').addClass('btn-success');
                    	$_this.remove();
                        layer.msg('已接单!',{icon: 6,time:1000});
                    }
                })
            });
		})
	})
	$(function(){
	    $('.abtn').click(function(){
	        var url="http://www.rdbuy.com.cn/wechat/wechatrefund";
	        var price=80;
	        var unique_num = "49xsif8QW09lmm";
	        $.getJSON(url,{"price":80,"unique_num":unique_num},
	            function(result){
	        	if(result){
	        	  //alert(result)
	        	}
	        });
	    })
	})
    $(function(){
        $('.order_product_name').find('.fa-plus:last').hide()
        $('.order_product_catename').find('.catename:last').hide()
    })
    /**发货**/
    $(function () {
        $('.Delivery_stop1').click(function(){

        	var url = '/transaction/orderform';
            $_this = $(this);
            var orderid = $(this).attr('orderid');
            var type = $(this).attr('type');
            var order_fid = $(this).attr('order_fid');
            if(order_fid == undefined)
            {
            	order_fid = 0;
            }

            $.post(url,{order_id:orderid,type:type,detect:'detect'},function(data){
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
                            var url = '/transaction/orderform';
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
                                            $.post(url,{is_send:1,order_sub_id:orderid,logistics_num:logistics_num,send_method:send_method,shipper:shipper,boxNum:boxNum,remark:remark,consignee:consignee,isReceipt:isReceipt,type:type,order_id:order_fid},function(data){
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
                                            $.post(url,{is_send:1,order_sub_id:orderid,logistics_num:logistics_num,send_method:send_method,shipper:shipper,boxNum:boxNum,remark:remark,consignee:consignee,isReceipt:isReceipt,type:type,order_id:order_fid},function(data){
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

        })
    })

    //时间选择
    laydate({
        elem: '#starttime',
        event: 'focus'
    });
    laydate({
        elem: '#endtime',
        event: 'focus'
    });
    /*订单-删除*/
    function Order_form_del(obj,id){
        var url = '/transaction/orderform';
        var orderid = id;
        layer.confirm('确认要删除吗？',{icon:0,},function(index){
            $.ajax({
                type: "POST",
                url: url,
                data: {order_id:orderid,is_delete:1},
                dataType: "json",
                success: function(data){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }
            });
        });
    }

    var oldie = /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase());
    $('.easy-pie-chart.percentage').each(function(){
        $(this).easyPieChart({
            barColor: $(this).data('color'),
            trackColor: '#EEEEEE',
            scaleColor: false,
            lineCap: 'butt',
            lineWidth: 10,
            animate: oldie ? false : 1000,
            size:103
        }).css('color', $(this).data('color'));
    });

    $('[data-rel=tooltip]').tooltip();
    $('[data-rel=popover]').popover({html:true});
</script>
