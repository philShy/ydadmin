<?php
use GuzzleHttp\json_decode;
class OrderformAction extends CAction{
    public function run()
    {
        $action = $this->getId();
        $controller = Yii::app()->controller->id;
        $the_join = $controller.'/'.$action;
        $admin_id = $userid = Yii::app()->user->id;
        //$user_arr = CManage::searchManager_one($userid);

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
        $id = Yii::app()->request->getParam('id');
        $is_audit = Yii::app()->request->getParam('is_audit');
        $audit_cause = Yii::app()->request->getParam('audit_cause');
        $sign = Yii::app()->request->getParam('sign');
        $signs = Yii::app()->request->getParam('signs');
        $order_sub_id = Yii::app()->request->getParam('order_sub_id');
        $orderid = Yii::app()->request->getParam('orderid');
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
        $detect = Yii::app()->request->getParam('detect');
        $is_jiedan = Yii::app()->request->getParam('is_jiedan');
        $is_send = Yii::app()->request->getParam('is_send');
        $order_status = Yii::app()->request->getParam('order_status');
        $is_receive = Yii::app()->request->getParam('is_receive');
        $is_inv = Yii::app()->request->getParam('is_inv');
        $xxjc = Yii::app()->request->getParam('xxjc');
        $price = Yii::app()->request->getParam('price');
        //线下支付检测
        if($xxjc)
        {

            $code = 'RD'.$order_id;
            $payinfo = "{order_id:$order_id,code:$code,payment:4}";
            if(CTransaction::insert_payinfo($order_id,$payment=4,$code,$price,$payinfo)&&CAdmin::updateNotice($order_id,$sub_id='',3))
            {
                //CSystem::opration_user_news(Yii::app()->session['manager']);
                $user_id=CTransaction::searchOneorder($order_id)['user_id'];
                CSystem::opration_user_news($user_id,$admin_id,'线下支付',"您的订单{$order_id}支付成功","/user/myorder");
                CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'order_payinfo','sure_transfer');
                echo '{"message":"转账成功","code":"200"}';die;
            }else{
                echo '{"message":"转账失败","code":"500"}';die;
            }

        }
        //收货
        if($is_receive&&$order_sub_id)
        {
            if(CTransaction::updateOrder_receive($order_sub_id)&&CAdmin::updateNotice($order_id,$order_sub_id,6))
            {
                $user_id=CTransaction::searchOneorder($order_id)['user_id'];
                CSystem::opration_user_news($user_id,$admin_id,'订单消息',"您的订单{$order_sub_id}系统自动收货","/order/orderdetail?order_sub_id=$order_sub_id");
                CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'order_sub','receive');
                echo '{"message":"收货成功","code":"200"}';die;
            }else{
                echo '{"message":"收货失败","code":"500"}';die;
            }
        }
        //开票
        if($is_inv)
        {
            $res = CProduct::updateOrder_inv($orderid);
            echo $res;die;
        }
        //查询是否具有开增值税发票资质
        if($orderid && $signs==2)
        {
            $userid = CProduct::search_userid($orderid)['user_id'];
            $invoice3_info = CProduct::search_invoice3_info($userid);
            echo json_encode($invoice3_info);die;
        }
        if($is_audit=='1' && $audit_cause)
        {
            $result = CTransaction::updata_invoice3($id,$is_audit,$audit_cause);
            echo $result;die;
        }
        else if($is_audit=='0')
        {
            $result = CTransaction::updata_invoice3($id,$is_audit,$audit_cause='');
            echo $result;die;
        }
        //是否接单
        if($is_jiedan)
        {
            if(CTransaction::editorder_sub_state($order_id,$order_status=2)&&CAdmin::updateNotice($order_id,$order_sub_id,4))
            {
                $user_id=CTransaction::searchOneorder($order_id)['user_id'];
                CSystem::opration_user_news($user_id,$admin_id,'订单消息',"您的订单{$order_id}已接单","/user/myorder");
                CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'order_sub','order_taking');
                echo '{"message":"接单成功","code":"200"}';die;
            }else{
                echo '{"message":"接单失败","code":"500"}';die;
            }
        }
        //发货检测
        if($detect)
        {
            if($type == 0)
            {
                $detect_status = CTransaction::searchOneorder($order_id);
                if($detect_status['status'] == 3)
                {
                    echo '已取消！';die;
                }elseif($detect_status['status'] == 2)
                {
                    echo '未支付！';die;
                }
            }elseif ($type == 1)
            {
                $detect_status = CTransaction::detect_order_sub($order_id);
                if($detect_status['status'] == 1)
                {
                    echo '未接单!';die;
                }elseif($detect_status['status'] >2){
                    echo '已发货!';die;
                }else{
                    echo $detect_status['status'];die;
                }
            }
        }
        /*根据条件查找订单*/
        if($where)
        {
            $where = base64_decode($where);
            $order_arr = CTransaction::searchAllorder($page,$size=10,$where);
            $count = CTransaction::countorder($where);
        }else if($search_order)
        {
            $where = "id=$search_order and";
            $order_arr = CTransaction::searchAllorder($page,$size=10,$where);

        }else if($start_time && $end_time)
        {
            $where = "'$start_time'<create_time and create_time<'$end_time' and";
            $order_arr = CTransaction::searchAllorder($page,$size=10,$where);
            $count = CTransaction::countorder($where);
        }
        else{
            if($sign == 2)
            {
                $where = "status=2 or status=8 and";
                $order_arr = CTransaction::searchAllorder($page,$size=10,$where);
                $count = CTransaction::countorder($where);
            }
            elseif($sign == 4)
            {
                $where = "status=4 or status=8 and";
                $order_arr = CTransaction::searchAllorder($page,$size=10,$where);
                $count = CTransaction::countorder($where);
            }
            elseif($sign == 5)
            {
                $where = "status=6 or status=8 and";
                $order_arr = CTransaction::searchAllorder($page,$size=10,$where);
                $count = CTransaction::countorder($where);
            }
            elseif($sign == 6)
            {
                $where = "status=6 or status=8 and";
                $order_arr = CTransaction::searchAllorder($page,$size=10,$where);
                $count = CTransaction::countorder($where);
            }elseif($sign == 3)
            {
                $where = "status=3 or status=8 and";
                $order_arr = CTransaction::searchAllorder($page,$size=10,$where);
                $count = CTransaction::countorder($where);
            }else{
                $order_arr = CTransaction::searchAllorder($page,$size=10,$where='');
                $count = CTransaction::countorder($where='');
            }
        }

        foreach($order_arr as $key=>$value)
        {
            $order_detail_arr = CTransaction::search_order_sub_id($value['id'],$status='');
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
            /* $order_arr[$key]['brand_order'] = $brand_order;
            $order_arr[$key]['meal_order'] = $meal_order; */
            json_decode($order_arr[$key]['goods_details'],true);
        }
        /*echo '<pre>';
    	var_dump($order_arr);die;*/
        //发货
        if($logistics_num && $order_sub_id && $is_send)
        {
            /*如果为0 则无子订单*/
            if($type == 0)
            {
                /*查找此订单下所有商品的信息*/
                $orderone = CTransaction::searchorder_detail($order_sub_id);
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
                        'model'=>'LE7-2x',
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
                $result = CTransaction::updateOrder($order_sub_id,$logistics_company,$logistics_num,$is_send=1,$status=5);
                /*type如果为1 则有子订单*/
            }elseif ($type == 1)
            {
                /*查找此订单下所有商品的信息*/
                $orderone = CTransaction::searchsuborder_detail($order_sub_id);
                /*根据order_id 查找收货人信息*/
                $buyer_detail = CTransaction::searchbuyer_detail($order_id);
                foreach($orderone as $k=>$v)
                {

                    $sku_arr = CProduct::searchsku_byid($v['goods_sku_id']);
                    //减少库存
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
                $user_id=CTransaction::searchOneorder($order_id)['user_id'];
                CSystem::opration_user_news($user_id,$admin_id,'订单消息',"您的订单{$order_sub_id}已发货","/order/orderdetail?order_sub_id=$order_sub_id");
                $result = CTransaction::updateOrder_sub($order_sub_id,$logistics_company,$logistics_num,$status=3);
                /*if($warehouse_stock)
                {
                    $result = CTransaction::updateOrder_sub($order_id,$logistics_company,$logistics_num,$status=3);
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'order_sub','send_goods');
                    CAdmin::updateNotice($order_id,$order_sub_id,5);
                    echo $result;die;
                }*/
            }


        }
        if($is_delete && $order_id)
        {
            $result = CTransaction::deleteOrder_byid($order_id,$is_delete);
            echo $result;
            die;
        }
        //var_dump($order_arr);die;
        $this->controller->layout = false;
        $this->controller->render(
            'orderform',
            array(
                'order_arr'=>$order_arr,
                'count'=>$count,
                'page'=>$page,
                'where'=>$where,
                'sign'=>$sign,
                'auth_arr'=>$auth_arr,
                //'user_arr'=>$user_arr,
            ));
    }
}