<?php
class CategoryAction extends CAction{
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

        $result = CProduct::getcategoryList();
        /*foreach($result as $key=>$value)
        {
            $count = substr_count($value['pth'],',');
            $str = '&nbsp;';
            if($count)
            {
                $catname[] = str_repeat($str,($count-1)*4).$value['name'];

            }
            if($count>1)
            {
                for($i=0;$i<$count-1;$i++)
                {
                    echo str_repeat($str,6);
                }
            }
            echo $value['name'].'<br>';
        }*/

        $this->controller->layout = false;
        $this->controller->render('category',array('result'=>$result));
    }
}