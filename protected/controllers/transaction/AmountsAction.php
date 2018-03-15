<?php
class AmountsAction extends CAction{
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
        $where=Yii::app()->request->getParam('where');
        $code=Yii::app()->request->getParam('code');
        $starttime=Yii::app()->request->getParam('starttime');
        $endtime=Yii::app()->request->getParam('endtime');
        $now = date('Y-m-d H:i:s');
        $page = Yii::app()->request->getParam('page')?Yii::app()->request->getParam('page'):1;

    	if($where)
        {	
        	$where = base64_decode(str_replace(" ","+",$where));
            $pay_amount = CTransaction::search_pay_amount($page,$size=10,$where);
            $refund_amount = CTransaction::search_refund_amount($where);
            $refund_amount_all = self::calculate_ammount($refund_amount);
            $total_pay_amount = CTransaction::search_pay_amount_all($where);
            $pay_amount_all = self::calculate_ammount($total_pay_amount);
            $count = count($total_pay_amount);
        }else{
            /*
            * 按条件查询交易及退款金额信息
            */
            if(empty($code) && empty($starttime) && empty($endtime))
            {
                //echo "<pre>";
                $where='';
                $pay_amount = CTransaction::search_pay_amount($page,$size=10,$where);
                $refund_amount = CTransaction::search_refund_amount($where);
                $refund_amount_all = self::calculate_ammount($refund_amount);
                $total_pay_amount = CTransaction::search_pay_amount_all($where);
                $pay_amount_all = self::calculate_ammount($total_pay_amount);
                $count = count($total_pay_amount);
                //$sign=1;
            }

            elseif ($starttime && $endtime)
            {
                $where = "create_time>'$starttime' AND create_time<='$endtime' AND ";
                $pay_amount = CTransaction::search_pay_amount($page,$size=10,$where);
                $refund_amount = CTransaction::search_refund_amount($where);
                $refund_amount_all = self::calculate_ammount($refund_amount);
                $total_pay_amount = CTransaction::search_pay_amount_all($where);
                $pay_amount_all = self::calculate_ammount($total_pay_amount);
                $count = count($total_pay_amount);
            }elseif ($starttime && empty($endtime))
            {
                $where = "create_time>'$starttime' AND ";
                $pay_amount = CTransaction::search_pay_amount($page,$size=10,$where);
                $refund_amount = CTransaction::search_refund_amount($where);
                $refund_amount_all = self::calculate_ammount($refund_amount);
                $total_pay_amount = CTransaction::search_pay_amount_all($where);
                $pay_amount_all = self::calculate_ammount($total_pay_amount);
                $count = count($total_pay_amount);
            }elseif (empty($starttime) && $endtime)
            {
                $where = "create_time<='$endtime' AND ";
                $pay_amount = CTransaction::search_pay_amount($page,$size=10,$where);
                $refund_amount = CTransaction::search_refund_amount($where);
                $refund_amount_all = self::calculate_ammount($refund_amount);
                $total_pay_amount = CTransaction::search_pay_amount_all($where);
                $pay_amount_all = self::calculate_ammount($total_pay_amount);
                $count = count($total_pay_amount);
            }
            elseif ($code == 1)
            {
                $first = date("Y").'-1-1 00:00:00';
                $year = date('Y-m-d H:i:s',strtotime($first));
                $where = "create_time>'$year' AND create_time<='$now' AND ";
                $pay_amount = CTransaction::search_pay_amount($page,$size=10,$where);
                $refund_amount = CTransaction::search_refund_amount($where);
                $refund_amount_all = self::calculate_ammount($refund_amount);
                $total_pay_amount = CTransaction::search_pay_amount_all($where);
                $pay_amount_all = self::calculate_ammount($total_pay_amount);
                $count = count($total_pay_amount);
                $sign=2;
            }elseif ($code == 2)
            {
                $quarter = date('Y-m-d', mktime(0,0,0,date('n')-(date('n')-1)%3,1,date('Y'))).' 00:00:00';
                $quarter = strtotime($quarter);
                $quarter = date('Y-m-d H:i:s' ,$quarter);
                $where = "create_time>'$quarter' AND create_time<='$now' AND ";
                $pay_amount = CTransaction::search_pay_amount($page,$size=10,$where);
                $refund_amount = CTransaction::search_refund_amount($where);
                $refund_amount_all = self::calculate_ammount($refund_amount);
                $total_pay_amount = CTransaction::search_pay_amount_all($where);
                $pay_amount_all = self::calculate_ammount($total_pay_amount);
                $count = count($total_pay_amount);
                $sign=3;
            }elseif ($code == 3)
            {
                $month = date('Y-m-d', mktime(0,0,0,date('n'),1,date('Y'))).' 00:00:00';
                $month = strtotime($month);
                $month = date('Y-m-d H:i:s' ,$month);
                $where = "create_time>'$month' AND create_time<='$now' AND ";
                $pay_amount = CTransaction::search_pay_amount($page,$size=10,$where);
                $refund_amount = CTransaction::search_refund_amount($where);
                $refund_amount_all = self::calculate_ammount($refund_amount);
                $total_pay_amount = CTransaction::search_pay_amount_all($where);
                $pay_amount_all = self::calculate_ammount($total_pay_amount);
                $count = count($total_pay_amount);
                $sign=4;
            }elseif ($code == 4)
            {
                $week = date('Y-m-d', time()-86400*date('w'));
                $week = strtotime($week);
                $week = date('Y-m-d H:i:s' ,$week);
                $where = "create_time>'$week' AND create_time<='$now' AND ";
                $pay_amount = CTransaction::search_pay_amount($page,$size=10,$where);
                $refund_amount = CTransaction::search_refund_amount($where);
                $refund_amount_all = self::calculate_ammount($refund_amount);
                $total_pay_amount = CTransaction::search_pay_amount_all($where);
                $pay_amount_all = self::calculate_ammount($total_pay_amount);
                $count = count($total_pay_amount);
                $sign=5;
            }elseif ($code == 5)
            {
                $today_str = strtotime(date("Y-m-d"),time());
                $today = date('Y-m-d H:i:s',$today_str);
                $where = "create_time>'$today' AND create_time<='$now' AND ";
                $pay_amount = CTransaction::search_pay_amount($page,$size=10,$where);
                $refund_amount = CTransaction::search_refund_amount($where);
                $refund_amount_all = self::calculate_ammount($refund_amount);
                $total_pay_amount = CTransaction::search_pay_amount_all($where);
                $pay_amount_all = self::calculate_ammount($total_pay_amount);
                $count = count($total_pay_amount);
                $sign=6;
            }
        }
        $today_str = strtotime(date("Y-m-d"),time());
        $today = date('Y-m-d H:i:s',$today_str);
        $today_where = "create_time>'$today' AND create_time<='$now' AND ";
        $today_refund_amount = CTransaction::search_refund_amount($today_where);
        $today_refund_amount_all = self::calculate_ammount($today_refund_amount);
        $today_total_pay_amount = CTransaction::search_pay_amount_all($today_where);
        $today_pay_amount_all = self::calculate_ammount($today_total_pay_amount);

        $this->controller->layout = false;
        $this->controller->render('amounts',array(
            'pay_amount'=>$pay_amount,
            'pay_amount_all'=>$pay_amount_all,
            'refund_amount_all'=>$refund_amount_all,
            'today_pay_amount_all'=>$today_pay_amount_all,
            'today_refund_amount_all'=>$today_refund_amount_all,
            'count' => $count,
            'where'=>$where,
            'page'=>$page,
            'sign'=>$sign,
        ));
    }
    public static function calculate_ammount($arr)
    {
        if(!empty($arr))
        {
            foreach($arr as $k=>$v)
            {
                $pay_amount_all[$k] = $v['price'];
            }
        }else{
            $pay_amount_all = array();
        }

        return array_sum($pay_amount_all);
    }
}












