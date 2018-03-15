<?php
class LogAction extends CAction{
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
        $where = Yii::app()->request->getParam('where');
        $page = Yii::app()->request->getParam('page');
        $manager = Yii::app()->request->getParam('manager');
        $operation = Yii::app()->request->getParam('operation');
        $datetime = Yii::app()->request->getParam('datetime');
        if(empty($page))
        {
            $page = 1;
        }
        $size=10;
        if($where)
        {
            $where=base64_decode(str_replace(" ","+",$where));
            $log_arr = CSystem::log_where($where,$page,$size);
            $count=CSystem::log_where_num($where);
        }else{
            if($manager && $datetime)
            {
                $sql1="a.login_user='$manager' AND ";
            }elseif($manager && !$datetime)
            {
                $sql1="a.login_user='$manager'";
            }
            else
            {
                $sql1="";
            }
            if($datetime)
            {
                $sql2="a.operate_time>'$datetime'";
            }
            else{
                $sql2="";
            }
            if($manager||$datetime)
            {
                $where=$sql1.$sql2;
                $where=$where?"WHERE $where":'';
                $log_arr = CSystem::log_where($where,$page,$size);
                $count=CSystem::log_where_num($where);
            }else{
                //echo $page;
                $log_arr = CSystem::searchSystem_log($page,$size);
                $count=CSystem::searchSystem_log_num();
            }
        }

        $manager_arr = CManage::searchAllmanager();
        $operation_arr = CSystem::search_curl();
        $this->controller->layout = false;
        $this->controller->render('log',
            array(
                'log_arr'=>$log_arr,
                'manager_arr'=>$manager_arr,
                'operation_arr'=>$operation_arr,
                'page'=>$page,
                'where'=>$where,
                'count'=>$count,
                )
        );
    }
}