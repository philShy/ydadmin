<?php
class RefunddetailAction extends CAction{
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
        $apply_type=Yii::app()->request->getParam('apply_type');
        //var_dump($apply_type);
        $order_id=Yii::app()->request->getParam('order_id');
        $af_stu = trim(Yii::app()->request->getParam('af_stu'));
        $goods_name=Yii::app()->request->getParam('goods_name');
        $id=Yii::app()->request->getParam('id');
        $refund_id = Yii::app()->request->getParam('refund_id');
        $isagree = Yii::app()->request->getParam('isagree');
        $sureagree = Yii::app()->request->getParam('sureagree');
        $reject = Yii::app()->request->getParam('reject');
        $payment = Yii::app()->request->getParam('payment');
        $manager = Yii::app()->request->getParam('manager');
        $number = Yii::app()->request->getParam('number');
        $detail_number = Yii::app()->request->getParam('detail_number');
        $order_detail_id = Yii::app()->request->getParam('order_detail_id');
        $refund_money = Yii::app()->request->getParam('refund_money');
        $refund_status = Yii::app()->request->getParam('refund_status');
        $sign = Yii::app()->request->getParam('sign');
        $logistics_num = Yii::app()->request->getParam('logistics_num');
        $send_method = Yii::app()->request->getParam('send_method');
        $apply_type = Yii::app()->request->getParam('apply_type');
        if($apply_type == 4)
        {
            $apply_type == '已补发';
        }
        else{
            $apply_type == '维修完成已发货';
        }
        switch ($send_method)
        {
            case 1:
                $send_method = '顺丰快递';
                break;
            case 2:
                $send_method = '跨越快递';
                break;
            case 3:
                $send_method = '联邦快递';
                break;
        }
        if($sign&&$refund_id)
        {
            if(CTransaction::updata_refund($refund_id,$logistics_num,$send_method))
            {
                $user_id=CTransaction::searchOneorder($order_id)['user_id'];
                $res = CSystem::opration_user_news($user_id,$admin_id,'售后消息',"您的订单：{$order_id}，商品：{$goods_name}{$apply_type}，物流：{$send_method}，单号：{$logistics_num}。如有疑问请联系客服人员","/afterservice/afterservice1?order_refund_id=$refund_id");
                echo $res;die;
            };
        }
        /*拒绝退款 改变退款状态，填写退款理由*/
        if($refund_id && empty($isagree) && $reject)
        {
            $user_id=CTransaction::searchOneorder($order_id)['user_id'];
            CSystem::opration_user_news($user_id,$admin_id,'售后消息',"您的订单：{$order_id}商品：{$goods_name}不能{$af_stu}，如有疑问请联系客服人员","/afterservice/afterservice1?order_refund_id=$refund_id");
        	$res = CTransaction::reject($refund_id,$status='0',$reject);
        	echo $res;die;
        }
        /*请买家填写物流单号*/
        if($refund_id && $order_detail_id && $detail_number && $number)
        {
        	/*
        	 * 检测该商品是否已经申请退款
        	 * 如果未申请退款则进行退款流程
        	 * 如果已经申请退款则检测此次退款的商品数量加上以往商品的退款数量是否大于订单内该商品的总数量
        	 * 如果大于则此次退款失败
        	 */
        	$detect_refund = CTransaction::search_detect_refund($order_detail_id);
        	$sum = 0;
        	foreach($detect_refund as $v)
        	{
        		$sum+=$v['number'];
        	}
        	if($detail_number*1<($sum+$number)*1)
        	{
        		$reject = '请核对商品退款数量后 再申请退款！';
                $user_id=CTransaction::searchOneorder($order_id)['user_id'];
                CSystem::opration_user_news($user_id,$admin_id,'售后消息',"您的订单：{$order_id}商品：{$goods_name}由于申请数量大于购买数量，不能再{$af_stu}","/afterservice/afterservice1?order_refund_id=$refund_id");
        		CTransaction::reject($refund_id,$status='0',$reject);
        		echo 2;die;
        	}else{
                $user_id=CTransaction::searchOneorder($order_id)['user_id'];
                CSystem::opration_user_news($user_id,$admin_id,'售后消息',"您的订单：{$order_id}商品：{$goods_name}同意{$af_stu}请填写单号","/afterservice/afterservice1?order_refund_id=$refund_id");
        		$res = CTransaction::updata_refund_state($refund_id,$status=2);
        		echo $res;die;
        	}
        }
        /*同意收货*/
        if($refund_id && $sureagree)
        {
            $user_id=CTransaction::searchOneorder($order_id)['user_id'];
            CSystem::opration_user_news($user_id,$admin_id,'售后消息',"您的订单：{$order_id}商品：{$goods_name}商家已收货，带检查后处理","/afterservice/afterservice1?order_refund_id=$refund_id");
        	$res = CTransaction::updata_refund_state($refund_id,$status=4);
        	echo $res;die;
        }
        /**
         * 同意退款
         * 根据支付方式 金额原路返回
         */
        ////////////////退款开始///////////////////
        if($refund_id && $order_id && $manager && $refund_money && $payment && $refund_status)
        {
            $sku_arr = CTransaction::search_detail_id_byRefund($refund_id);
            //增加商城库存
            CTransaction::updata_stock($sku_arr['id'],$sku_arr['number']);
            //增加仓库库存
            $arr=array(
                'code'=>1,
                'source'=>'研鼎商城',
                'operator'=>Yii::app()->user->manager,
                //'model'=>$sku_arr['pn'],
                'model'=>'LE7-2x',
                'type'=>'商城退货',
                'num'=>$sku_arr['number'],
                'unit'=>'个',
                'approve'=>1,
                'remark'=>'商城退货',);
            $res = Yii::app()->curl->get('http://localhost/yandingwarehouse/interfaces/rdbuy.php',$arr);
            if($res==1)
            {
                $refund_serial_number = uniqid();
                /*
                 * 发送数据到url
                 * 1:微信支付，2：支付宝支付，3：网银支付，4：线下支付
                 */
                if($payment == 1)//微信退款
                {
                    $weixin_id = CTransaction::search_wxid($order_id);
                    /*发送的数据*/
                    $data = [
                        'out_trade_no' => $weixin_id['out_trade_to'],
                        'refund_fee' => 1,
                        'total_fee' => 1,
                        'out_refund_no' => $refund_serial_number,
                    ];
                    $res = Yii::app()->curl->post('http://www.rdbuy.com.cn/wechat/wechatrefundquery',$data);
                    $refund_msg = json_decode($res,true);
                    if($refund_msg['result_code'] && $refund_msg['result_code'] == 'SUCCESS')
                    {
                        $user_id=CTransaction::searchOneorder($order_id)['user_id'];
                        CSystem::opration_user_news($user_id,$admin_id,'售后消息',"您的订单：{$order_id}商品：{$goods_name},退款完成，如有疑问请联系客服人员","/afterservice/afterservice1?order_refund_id=$refund_id");
                        CTransaction::record_refund_info($refund_id,$order_id,$payment,$refund_money=0.01,$refund_serial_number,$res,$is_success='1');
                        $res = CTransaction::updata_refund_state($refund_id,$status=6);
                        CAdmin::updateNotice($order_fid='',$order_id,5);
                        echo $res;die;
                    }else{
                        /*退款信息写入order_refundinfo表*/
                        CTransaction::record_refund_info($refund_id,$order_id,$payment,$refund_money=0.01,$refund_serial_number,$res,$is_success='0');
                        $res = CTransaction::updata_refund_state($refund_id,$status=3);
                        echo 2;die;
                    }

                }elseif ($payment == 2)//支付宝退款
                {
                    //支付宝退款
                    $data = [
                        'order_id' =>$order_id,
                        'num' => 0.09,
                        'code' => $refund_serial_number,
                    ];
                    $res = Yii::app()->curl->post('http://192.168.1.42:81/flow/alipayrefund',$data);
                    $refund_msg = json_decode($res,true);
                    if($refund_msg['alipay_trade_refund_response']['code'] && $refund_msg['alipay_trade_refund_response']['code'] == '10000')
                    {
                        $user_id=CTransaction::searchOneorder($order_id)['user_id'];
                        CSystem::opration_user_news($user_id,$admin_id,'售后消息',"您的订单：{$order_id}商品：{$goods_name},退款完成，如有疑问请联系客服人员","/afterservice/afterservice1?order_refund_id=$refund_id");
                        CTransaction::record_refund_info($refund_id,$order_id,$payment,$refund_money=0.09,$refund_serial_number,$res,$refund_msg['result_code']);
                        CTransaction::updata_refund_state($refund_id,$status=6);
                    }else{
                        CTransaction::record_refund_info($refund_id,$order_id,$payment,$refund_money=0.09,$refund_serial_number,$res,$refund_msg['result_code']);
                        CTransaction::updata_refund_state($refund_id,$status=4);
                    }
                }elseif ($payment == 3)//银联退款
                {
                    //echo Yii::app()->curl->get('http://www.rdbuy.com.cn/wechat/wechatrefund',$arr);die;
                }
                elseif ($payment == 4)//线下支付
                {
                    $res_info=CTransaction::record_refund_info($refund_id,$order_id,$payment,$refund_money,'rd'.$order_id,'线下支付','0');
                    $res_state=CTransaction::updata_refund_state($refund_id,$status=6);
                    if($res_info&&$res_state)
                    {
                        $user_id=CTransaction::searchOneorder($order_id)['user_id'];
                        CSystem::opration_user_news($user_id,$admin_id,'售后消息',"您的订单：{$order_id}商品：{$goods_name},退款完成，如有疑问请联系客服人员","/afterservice/afterservice1?order_refund_id=$refund_id");

                        echo '{"code":"200","message":"退款成功"}';die;
                    }
                }
            }
        }
        ////////////////退款结束//////////////////
        $refundDetail = CTransaction::refundDetail($id);
        $user_info = CTransaction::search_user_info($refundDetail['address_id']);
        $this->controller->layout = false;
        $this->controller->render('refunddetail',array('refundDetail'=>$refundDetail,'user_info'=>$user_info,'auth_arr'=>$auth_arr));
    }
}

















