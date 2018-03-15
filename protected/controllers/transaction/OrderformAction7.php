<?php
use GuzzleHttp\json_decode;
class OrderformAction7 extends CAction{
    public function run()
    {
        $action = $this->getId();
        $controller = Yii::app()->controller->id;
        $the_join = $controller.'/'.$action;
        $admin_id = $userid = Yii::app()->user->id;
        $auth_arr = CManage::searchAuth_Byadminid($userid);
        $auth_join = array_filter(explode(',',$auth_arr['auth_join']));
        if(!empty($auth_join))
        {
            if(!in_array($the_join,$auth_join))
            {

                Yii::error("没有访问权限",Yii::app()->createUrl('home/index'),"1");die;
            }
        }else{
            if($auth_arr['role_id'] != 1)
            {
                Yii::error("没有访问权限",Yii::app()->createUrl('home/index'),"1");die;
            }
        }
        $page = Yii::app()->request->getParam('page');
        if(empty($page))
        {
            $page = 1;
        }
        $size=10;
        $sign = Yii::app()->request->getParam('sign');
        $search_order = Yii::app()->request->getParam('search_order');
        $shipper = Yii::app()->request->getParam('shipper');
        $boxNum = Yii::app()->request->getParam('boxNum');
        $isReceipt = Yii::app()->request->getParam('isReceipt');
        $remark = Yii::app()->request->getParam('remark');
        $consignee = Yii::app()->request->getParam('consignee');
        if(empty($consignee)){$consignee = '无收货单位';}
        $start_time = Yii::app()->request->getParam('starttime');
        $end_time = Yii::app()->request->getParam('endtime');
        $where = Yii::app()->request->getParam('where');
        $order_id = Yii::app()->request->getParam('order_id');
        $is_delete = Yii::app()->request->getParam('is_delete');
        $logistics_num = Yii::app()->request->getParam('logistics_num');
        $logistics_company = Yii::app()->request->getParam('send_method');
        $type = Yii::app()->request->getParam('type');
        $order_fid = Yii::app()->request->getParam('order_fid');
        $detect = Yii::app()->request->getParam('detect');
        $payment = Yii::app()->request->getParam('payment');
        $is_send = Yii::app()->request->getParam('is_send');
        $order_status = Yii::app()->request->getParam('order_status');
        $pay_price = Yii::app()->request->getParam('pay_price');
        $pay_payment = Yii::app()->request->getParam('pay_payment');
        $qx = Yii::app()->request->getParam('qx');

        //同意取消订单
        if($qx==1)
        {
            if($order_status == 2)
            {
                $sku_arr = CTransaction::searchorder_detail($order_id);
                foreach ($sku_arr as $k=>$v)
                {
                    //增加库存
                    CTransaction::updata_stock($v['goods_sku_id'],$v['number']);
                }
                $refund_serial_number = uniqid();
                if($payment == 1)
                {
                    //买家已付款，需退款后改变状态
                    if($pay_payment == 1)
                    {
                        //微信退款
                        $weixin_id = CTransaction::search_wxid($order_id);
                        /*发送的数据*/
                        $data = [
                            'out_trade_no' => $weixin_id['out_trade_to'],
                            'refund_fee' => $pay_price*100,
                            'total_fee' => $pay_price*100,
                            'out_refund_no' => $refund_serial_number,
                        ];
                        $res = Yii::app()->curl->post('http://www.rdbuy.com.cn/wechat/wechatrefundquery',$data);
                        $refund_msg = json_decode($res,true);
                        if($refund_msg['result_code'] && $refund_msg['result_code'] == 'SUCCESS')
                        {
                            $result = CTransaction::qx_order($order_id,$status=3);
                            $user_id=CTransaction::searchOneorder($order_id)['user_id'];
                            CSystem::opration_user_news($user_id,$admin_id,'线下支付',"您的订单{$order_id}支付成功","/order/orderdetail?order_id=$order_id");
                            //退款信息写入退款表order_refundinfo
                            CTransaction::record_refund_info($refund_id='0',$order_id,$pay_payment,$pay_price,$refund_serial_number,$res,$is_success='0');
                            //
                            echo $result;die;
                        }else{
                            CTransaction::record_refund_info($refund_id='0',$order_id,$pay_payment,$pay_price,$refund_serial_number,$res,$is_success='1');
                            echo '退款失败';die;
                        }
                    }elseif($pay_payment == 2)
                    {
                        //支付宝退款
                        $data = [
                            'order_id' =>$order_id,
                            'num' => $pay_price,
                            'code' => $refund_serial_number,
                        ];
                        $res = Yii::app()->curl->post('http://192.168.1.42:81/flow/alipayrefund',$data);
                        $refund_msg = json_decode($res,true);
                        if($refund_msg['alipay_trade_refund_response']['code'] && $refund_msg['alipay_trade_refund_response']['code'] == '10000')
                        {
                            $result = CTransaction::qx_order($order_id,$status=3);
                            $user_id=CTransaction::searchOneorder($order_id)['user_id'];
                            CSystem::opration_user_news($user_id,$admin_id,'线下支付',"您的订单{$order_id}支付成功","/order/orderdetail?order_id=$order_id");
                            CTransaction::record_refund_info($refund_id='0',$order_id,$pay_payment,$pay_price,$refund_serial_number,$res,$is_success='0');
                            echo $result;die;
                        }else{
                            CTransaction::record_refund_info($refund_id='0',$order_id,$pay_payment,$pay_price,$refund_serial_number,$res,$is_success='1');
                            echo '退款失败';die;
                        }
                    }elseif ($pay_payment == 3)
                    {
                        //网银支付
                    }

                }else{
                    //线下支付
                    $refund_info = "{''return_code':'SUCCESS','return_msg':'OK','refund_operation':'$userid'}";
                    $res = CTransaction::record_refund_info($refund_id='0',$order_id,$pay_payment,$pay_price,$refund_serial_number,$refund_info,$is_success='0');
                    CTransaction::qx_order($order_id,$status=3);
                    $user_id=CTransaction::searchOneorder($order_id)['user_id'];
                    CSystem::opration_user_news($user_id,$admin_id,'线下支付',"您的订单{$order_id}支付成功","/order/orderdetail?order_id=$order_id");
                    echo $res;die;
                }
            }else{
                //买家未付款，直接改变状态
                $result = CTransaction::qx_order($order_id,$status=3);
                echo $result;die;
            }
        }
        //发货检测
        if($detect)
        {
            if($type == 0)
            {
                $detect_status = CTransaction::searchOneorder($order_id);
                echo $detect_status['status'];die;
            }elseif ($type == 1)
            {
                $detect_status = CTransaction::detect_order_sub($order_id);
                echo $detect_status['status'];die;
            }
        }
        /*根据条件查找订单*/
        if($where)
        {
            $order_arr = CTransaction::searchAllorder4($page,$size,$where='status=4 or status=8 and')['results'];
            $count = CTransaction::searchAllorder4($page,$size,$where='status=4 or status=8 and')['count'];
        }else if($search_order)
        {
            $where = "id=$search_order and";
            $order_arr = CTransaction::searchAllorder($page,$size,$where);

        }else if($start_time && $end_time)
        {
            $where = "'$start_time'<create_time and create_time<'$end_time' and";
            $order_arr = CTransaction::searchAllorder($page,$size,$where);
            $count = CTransaction::countorder($where);
        }
        else{
            $order_arr = CTransaction::searchAllorder_qx($page,$size);
        }
        /*echo '<pre>';
        var_dump($order_arr);die;*/
        foreach($order_arr as $key=>$value)
        {
            $order_detail_arr = CTransaction::search_order_sub_id($value['id'],$status='');

            if(!empty($order_detail_arr))
            {
                foreach ($order_detail_arr as $k=>$v)
                {
                    $sub_id = $v['order_sub_id'];
                    unset($order_detail_arr[$k]);
                    $order_detail_arr[$sub_id] = CTransaction::search_sub_one($v['order_sub_id']);
                    $order_detail_arr[$sub_id]['logistics_type'] = $v['logistics_type'];
                    $order_detail_arr[$sub_id]['logistics_num'] = $v['logistics_num'];
                    $order_detail_arr[$sub_id]['send_time'] = $v['send_time'];
                    $order_detail_arr[$sub_id]['is_advance_order'] = $v['is_advance_order'];
                    $order_detail_arr[$sub_id]['sub_status'] = $v['sub_status'];
                }
                $order_arr[$key]['goods_detail'] = $order_detail_arr;
                json_decode($order_arr[$key]['goods_details'],true);
            }else {
                unset($order_arr[$key]);
            }

        }
        $count = count($order_arr);
        /*echo '<pre>';
 		var_dump($order_arr);die; */
        //发货
        if($logistics_num && $order_id && $is_send)
        {
            /*如果为0 则无子订单*/
            if($type == 0)
            {
                /*查找此订单下所有商品的信息*/
                $orderone = CTransaction::searchorder_detail($order_id);
                /*根据order_id 查找收货人信息*/
                $buyer_detail = CTransaction::searchbuyer_detail($order_id);
                foreach($orderone as $k=>$v)
                {
                    //减少库存
                    $res_reduce=CTransaction::reduceStock($v['goods_model_id'],$v['number']);
                    $arr=array(
                        'code'=>2,
                        'source'=>'研鼎商城',
                        'operator'=>Yii::app()->user->manager,
                        'model'=>$v['goods_model_name'],
                        'type'=>'卖出货物',
                        'num'=>$v['number'],
                        'unit'=>'个',
                        'logisticsId'=>$logistics_company,
                        'logisticsNum'=>$logistics_num,
                        'isReceipt'=>$isReceipt,
                        'shipper'=>$shipper,
                        'boxNum'=>$boxNum,
                        'consignee'=>$consignee,
                        'clientContactor'=>$buyer_detail['receive_name'],
                        'receiveAddress'=>$buyer_detail['receive_province'].$buyer_detail['receive_city'].$buyer_detail['receive_county'].$buyer_detail['receive_detail'],
                        'receiveTele'=>$buyer_detail['receive_phone'],
                        'remark'=>$remark,

                    );
                    if($res_reduce){
                        echo Yii::app()->curl->get('http://localhost/yandingwarehouse/interfaces/rdbuy.php',$arr);
                    }
                }
                $result = CTransaction::updateOrder($order_id,$logistics_company,$logistics_num,$is_send=1,$status=5);
                /*type如果为1 则无子订单*/
            }elseif ($type == 1)
            {
                /*查找此订单下所有商品的信息*/
                $orderone = CTransaction::searchsuborder_detail($order_id);
                /*根据order_id 查找收货人信息*/
                $buyer_detail = CTransaction::searchbuyer_detail($order_fid);
                foreach($orderone as $k=>$v)
                {
                    //减少库存
                    $res_reduce=CTransaction::reduceStock($v['goods_model_id'],$v['number']);
                    $arr=array(
                        'code'=>2,
                        'source'=>'研鼎商城',
                        'operator'=>Yii::app()->user->manager,
                        'model'=>$v['goods_model_name'],
                        'type'=>'卖出货物',
                        'num'=>$v['number'],
                        'unit'=>'个',
                        'logisticsId'=>$logistics_company,
                        'logisticsNum'=>$logistics_num,
                        'isReceipt'=>$isReceipt,
                        'shipper'=>$shipper,
                        'boxNum'=>$boxNum,
                        'consignee'=>$consignee,
                        'clientContactor'=>$buyer_detail['receive_name'],
                        'receiveAddress'=>$buyer_detail['receive_province'].$buyer_detail['receive_city'].$buyer_detail['receive_county'].$buyer_detail['receive_detail'],
                        'receiveTele'=>$buyer_detail['receive_phone'],
                        'remark'=>$remark,

                    );
                    if($res_reduce){
                        echo Yii::app()->curl->get('http://localhost/yandingwarehouse/interfaces/rdbuy.php',$arr);
                    }
                }
                $result = CTransaction::updateOrder_sub($order_id,$logistics_company,$logistics_num,$is_send=1,$status=5);
                CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'order_sub','send_goods');
            }

            echo $result;die;
        }
        if($is_delete && $order_id)
        {
            $result = CTransaction::deleteOrder_byid($order_id,$is_delete);
            echo $result;
            die;
        }

        $this->controller->layout = false;
        $this->controller->render(
            'orderform7',
            array(
                'order_arr'=>$order_arr,
                'count'=>$count,
                'page'=>$page,
                'where'=>$where,
                'sign'=>$sign,
            ));
    }
}