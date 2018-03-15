<?php
class Set_sales_timeAction extends CAction{
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
        $time_id = Yii::app()->request->getParam('time_id');
        $name = Yii::app()->request->getParam('name');
        $returned_time = Yii::app()->request->getParam('returned_time')*24*3600;
        $exchange_time = Yii::app()->request->getParam('exchange_time')*24*3600;
        if($name)
        {//添加售后期限
            if(CProduct::add_sales_time($name,$returned_time,$exchange_time))
            {
                echo 1;die;
            }
        }
        if($time_id)
        {//删除售后期限
            if(CProduct::del_sales_time($time_id))
            {
                echo 1;die;
            }
        }
        $time_limit_arr = CProduct::search_time_limit_all();
        $count = count($time_limit_arr);
        $this->controller->layout = false;
        $this->controller->render('set_sales_time',array('time_limit_arr'=>$time_limit_arr,'count'=>$count));
    }
}