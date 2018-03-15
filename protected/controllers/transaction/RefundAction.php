<?php
class RefundAction extends CAction{
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
        
        $order_id=Yii::app()->request->getParam('order_id');
        $start_date=Yii::app()->request->getParam('start_date');
        $end_date=Yii::app()->request->getParam('end_date');
        $success=Yii::app()->request->getParam('success');
        $warning=Yii::app()->request->getParam('warning');
        $state = Yii::app()->request->getParam('state');
        $orderid=Yii::app()->request->getParam('orderid');
        $pid=Yii::app()->request->getParam('pid');
        $del=Yii::app()->request->getParam('del');
        $refund_id=Yii::app()->request->getParam('refund_id');
        $sign=Yii::app()->request->getParam('sign');
        if($sign==1)
        {

        }elseif($sign==2)
        {

        }elseif($sign==3)
        {

        }elseif($sign==4)
        {

        }elseif($sign==5)
        {

        }else{

        }
        /*删除退款订单*/
        if($del)
        {
        	$res = CTransaction::del_refund_byrefundid($refund_id);
        	echo $res;
        	die;
        	
        }
        /*查询未发货订单*/
        //按订单号查询
        if(($order_id && empty($start_date) && empty($end_date)) || ($order_id && empty($start_date) && !empty($end_date)) || ($order_id && !empty($start_date) && empty($end_date)) || ($order_id && $start_date && $end_date))
        {
        	$sql_str = "WHERE b.order_id = $order_id ";
        	$refund_arr = CTransaction::search_refund_bycondition($sql_str);
        	
        }elseif ($start_date && empty($end_date))//按开始时间
        {
        	$sql_str = "WHERE a.create_time >= '$start_date' ";
        	$refund_arr = CTransaction::search_refund_bycondition($sql_str);
        }elseif (empty($start_date) && $end_date)//按结束时间
        {
        	$sql_str = "WHERE a.create_time <= '$end_date' ";
        	$refund_arr = CTransaction::search_refund_bycondition($sql_str);
        }elseif (empty($order_id) && $start_date && $end_date)//按时间段
        {
        	$sql_str = "WHERE a.create_time >= '$start_date' AND a.create_time <= '$end_date' ";
        	$refund_arr = CTransaction::search_refund_bycondition($sql_str);
        }elseif($success)
        {
        	$sql_str = "WHERE a.status = 6 ";
        	$refund_arr = CTransaction::search_refund_bycondition($sql_str);
        }elseif($warning)
        {
        	$sql_str = "WHERE a.status < 6 ";
        	$refund_arr = CTransaction::search_refund_bycondition($sql_str);
        }elseif(empty($order_id) && empty($start_date) && empty($end_date)){
        	$refund_arr = CTransaction::refund();
        }
        
        if($state ==1 && $pid)
        {
            $detail_state=5;
            $res_refund = CTransaction::editRefund_state($state,$orderid,$pid);
            $res_detail = CTransaction::editDetail_state($detail_state,$orderid,$pid);
            if($res_detail && $res_refund)
            {
                echo 1;
            }else{
                echo 2;
            }
            die;
        }

        /*echo '<pre>';
       var_dump($result);die;*/
        $this->controller->layout = false;
        $this->controller->render('refund',array('refund_arr'=>$refund_arr));
    }
}