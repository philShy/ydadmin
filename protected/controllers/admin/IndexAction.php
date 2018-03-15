<?php
class IndexAction extends CAction{
    public function run()
    {
        $action = $this->getId();
        $controller = Yii::app()->controller->id;
        $the_join = $controller.'/'.$action;
        $admin_id=$userid = Yii::app()->user->id;
        $auth_arr = CManage::searchAuth_Byadminid($userid);
        $auth_join = array_filter(explode(',',$auth_arr['auth_join']));
        if($auth_arr['role_id'] == 1)
        {
            $result0 = CManage::searchAdmin_auth();

        }
        elseif(!in_array($the_join,$auth_join))
        {
            Yii::error("没有访问权限",Yii::app()->createUrl('../login/index'),"1");die;
        }
        else{
            $authid_arr = trim($auth_arr['auth_id'],',');
            $result0 = CManage::searchAuth0_Byauthid($authid_arr);
        }
        $code = Yii::app()->request->getParam('code');
        $not_socre = CTransaction::searchOrderSubIsScore_byWhere($is_score=0,$time=6,$status=3);
        //2.用户添加积分详情 改变子订单表积分状态
        foreach ($not_socre as $k=>$v)
        {
            $res = CUser::insertScore($v['user_id'],floor($v['order_sub_price']/100),$reason="购物+(子订单号：$v[id])",$type=2);
            if($res)
            {
                CTransaction::editorder_sub_is_score($v['id'],$is_score=1);
                CSystem::opration_user_news($v['user_id'],$admin_id,'积分消息',"您的子订单：$v[order_id]-$v[id]赠送积分".floor($v['order_sub_price']/100),"/order/orderdetail?order_sub_id=$v[id]");
                CUser::updateInfo_score($v['user_id'],floor($v['order_sub_price']/100));
            }
        }
        if($code == 1)
        {
            $order_notice = CAdmin::searchOrder_notice();
            $order_notice_arr = array();
            foreach($order_notice as $key=>$value) {
                if (empty($value['order_sub_id'])&&$value['operat']!=0&&$value['operat']!=1&&$value['operat']!=2&&$value['operat']!=7)
                {
                    unset($order_notice[$key]);
                }
            }
            //var_dump($auth_arr['role']);die;
            foreach($order_notice as $key=>$value)
            {
                if($value['order_sub_id'])
                {
                    $order_all_id =$value['order_id'].'-'.$value['order_sub_id'];
                }else{
                    $order_all_id =$value['order_id'];
                }
                if($auth_arr['role'] == '销售'||$auth_arr['role'] == '超级管理员')
                {
                    if($value['operat'] == 0)
                    {
                        $order_notice_arr['pin'][] = '订单号：'.'【'.$order_all_id.'】'.'取消订单';
                        $order_notice_arr['order_id'][] = $value['order_id'];
                        $order_notice_arr['order_sub_id'][] = $value['order_sub_id'];
                        $order_notice_arr['create_time'][] = $value['create_time'];
                    }
                    if($value['operat'] == 1)
                    {
                        $order_notice_arr['pin'][] = '订单号：'.'【'.$order_all_id.'】'.'新下单';
                        $order_notice_arr['order_id'][] = $value['order_id'];
                        $order_notice_arr['order_sub_id'][] = $value['order_sub_id'];
                        $order_notice_arr['create_time'][] = $value['create_time'];
                    }
                    if($value['operat'] == 3)
                    {
                        $order_notice_arr['pin'][] = '订单号：'.'【'.$order_all_id.'】'.'支付成功，请接单';
                        $order_notice_arr['order_id'][] = $value['order_id'];
                        $order_notice_arr['order_sub_id'][] = $value['order_sub_id'];
                        $order_notice_arr['create_time'][] = $value['create_time'];
                    }
                    if($value['operat'] == 5)
                    {
                        $order_notice_arr['pin'][] = '订单号：'.'【'.$order_all_id.'】'.'发货成功！待收货';
                        $order_notice_arr['order_id'][] = $value['order_id'];
                        $order_notice_arr['order_sub_id'][] = $value['order_sub_id'];
                        $order_notice_arr['create_time'][] = $value['create_time'];
                    }
                    if($value['operat'] == 6)
                    {
                        $order_notice_arr['pin'][] = '订单号：'.'【'.$order_all_id.'】'.'已收货，交易成功';
                        $order_notice_arr['order_id'][] = $value['order_id'];
                        $order_notice_arr['order_sub_id'][] = $value['order_sub_id'];
                        $order_notice_arr['create_time'][] = $value['create_time'];
                    }
                    if($value['operat'] == 8)
                    {
                        $order_notice_arr['pin'][] = '订单号：'.'【'.$order_all_id.'】'.'退款成功';
                        $order_notice_arr['order_id'][] = $value['order_id'];
                        $order_notice_arr['order_sub_id'][] = $value['order_sub_id'];
                        $order_notice_arr['create_time'][] = $value['create_time'];
                    }
                    if($value['operat'] == 9)
                    {
                        $order_notice_arr['pin'][] = '订单号：'.'【'.$order_all_id.'】'.'取消成功';
                        $order_notice_arr['order_id'][] = $value['order_id'];
                        $order_notice_arr['order_sub_id'][] = $value['order_sub_id'];
                        $order_notice_arr['create_time'][] = $value['create_time'];
                    }
                }
                if($auth_arr['role'] == '财务'||$auth_arr['role'] == '超级管理员')
                {
                    if($value['operat'] == 0)
                    {
                        $order_notice_arr['pin'][] = '订单号：'.'【'.$order_all_id.'】'.'取消订单';
                        $order_notice_arr['order_id'][] = $value['order_id'];
                        $order_notice_arr['order_sub_id'][] = $value['order_sub_id'];
                        $order_notice_arr['create_time'][] = $value['create_time'];
                    }
                    if($value['operat'] == 2)
                    {
                        $order_notice_arr['pin'][] = '订单号：'.'【'.$order_all_id.'】'.'线下支付，请确认';
                        $order_notice_arr['order_id'][] = $value['order_id'];
                        $order_notice_arr['order_sub_id'][] = $value['order_sub_id'];
                        $order_notice_arr['create_time'][] = $value['create_time'];
                    }

                    if($value['operat'] == 7)
                    {
                        $order_notice_arr['pin'][] = '订单号：'.'【'.$order_all_id.'】'.'申请退款';
                        $order_notice_arr['order_id'][] = $value['order_id'];
                        $order_notice_arr['order_sub_id'][] = $value['order_sub_id'];
                        $order_notice_arr['create_time'][] = $value['create_time'];
                    }
                }
                if($auth_arr['role'] == '仓管'||$auth_arr['role'] == '超级管理员')
                {
                    if($value['operat'] == 4)
                    {
                        $order_notice_arr['pin'][] = '订单号：'.'【'.$order_all_id.'】'.'请发货';
                        $order_notice_arr['order_id'][] = $value['order_id'];
                        $order_notice_arr['order_sub_id'][] = $value['order_sub_id'];
                        $order_notice_arr['create_time'][] = $value['create_time'];
                    }
                }
            }

            echo json_encode($order_notice_arr);die;
        }
        /*elseif($code == 2 && $order_id)
        {
            $res = CAdmin::updateNotice($order_id,$state=1);
            echo $res;die;
        }*/


        $this->controller->layout = false;
        $this->controller->render("index",array('result0'=>$result0,'authid_arr'=>$authid_arr,'auth_arr'=>$auth_arr));
    }
}