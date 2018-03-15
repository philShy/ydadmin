<?php
class OrderdetailAction extends CAction{
    public function run()
    {
        $action = $this->getId();
        $controller = Yii::app()->controller->id;
        $the_join = $controller.'/'.$action;
        $userid = Yii::app()->user->id;
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
        $id = Yii::app()->request->getParam('id');
        $type = Yii::app()->request->getParam('type');
        $order_id = Yii::app()->request->getParam('order_id');
        $sub_id = Yii::app()->request->getParam('sub_id');
        $state= Yii::app()->request->getParam('state');
        $status= Yii::app()->request->getParam('status');
        $logistics_num = Yii::app()->request->getParam('logistics_num');
        $logistics_company = Yii::app()->request->getParam('send_method');
        $shipper = Yii::app()->request->getParam('shipper');
        $boxNum = Yii::app()->request->getParam('boxNum');
        $isReceipt = Yii::app()->request->getParam('isReceipt');
        $remark = Yii::app()->request->getParam('remark');
        $consignee = Yii::app()->request->getParam('consignee');
        $edit = Yii::app()->request->getParam('edit');
        if($edit == 'logistics_type')
        {
            $res = CTransaction::editOrderLogisticsType($sub_id,$logistics_company);
            echo $res;
        }
        if($edit == 'logistics_num')
        {
            $res = CTransaction::editOrderLogisticsNum($sub_id,$logistics_num);
            echo $res;
        }
        if(empty($consignee)){$consignee = '无收货单位';}
        if($order_id&&$sub_id&&$state)
        {
            //echo $order_id.$sub_id;die;
            if ($state==1)
            {
                //已支付请接单=》销售操作
                if( CTransaction::editorder_sub_state($order_id, 2)&& CAdmin::updateNotice($order_id,$sub_id,4))
                {
                    echo '{"message":"接单成功","code":"200"}';die;
                }else{
                    echo '{"message":"接单失败","code":"500"}';die;
                }
            }
            else{
                //已接单请发货=》仓管操作
                /*查找此订单下所有商品的信息*/
                $orderone = CTransaction::searchsuborder_detail($sub_id);
                /*根据order_id 查找收货人信息*/
                $buyer_detail = CTransaction::searchbuyer_detail($order_id);
                foreach($orderone as $k=>$v)
                {
                    //减少库存
                    $sku_arr = CProduct::searchsku_byid($v['goods_sku_id']);
                    $res_reduce=CTransaction::reduceStock($sku_arr['id'],$v['number']);
                    $arr=array(
                        'code'=>2,
                        'source'=>'研鼎商城',
                        'operator'=>Yii::app()->user->manager,
                        'model'=>$sku_arr['pn'],
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
                    //$warehouse_stock = Yii::app()->curl->get('http://localhost/yandingwarehouse/interfaces/rdbuy.php',$arr);

                }
                $result = CTransaction::updateOrder_sub($sub_id,$logistics_company,$logistics_num,$status=3);
                /*if($warehouse_stock)
                {
                    $res=CTransaction::updateOrder_sub($order_id,$logistics_company,$logistics_num,$status=3);
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'order_sub','send_goods');
                    CAdmin::updateNotice($order_id,$sub_id,5);
                    echo $res;die;
                }*/

            }
        }
        if($order_id&&$status)
        {
            //确认线下支付成功
        }
        if($id)
        {
        	if($type == 0)
        	{
        	$orderone = CTransaction::searchOneorder($id);
            $orderone['goods_details'] = json_decode($orderone['goods_details'],true);
            $orderone['invoice'] = json_decode($orderone['invoice'],true);
        	}elseif ($type == 1)
        	{
        	
        	$orderone = CTransaction::searchOneorder_sub($id);
        	$orderone_all_detail = CTransaction::search_sub_all_detail($id);
            $orderone['invoice'] = json_decode($orderone['invoice'],true);
            $orderone['details'] = $orderone_all_detail;
        	}
        	/*echo '<pre>';
            var_dump($orderone);die;*/
        }

        $this->controller->layout = false;
        $this->controller->render('orderdetail',array('orderone'=>$orderone,'type'=>$type,'id'=>$id));
    }
}