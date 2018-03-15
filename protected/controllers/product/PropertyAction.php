<?php
class PropertyAction extends CAction{
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
        $arr['title'] = Yii::app()->request->getParam('title');
        $property_id = Yii::app()->request->getParam('property_id');
      	$property_arr = CProduct::search_property_all();
      	/*删除该规格*/
      	if($property_id)
      	{
      		$res = CProduct::del_property_byid($property_id);
      		{
      			echo 1;die;
      		}
      	}
       
        $this->controller->layout = false;
        $this->controller->render('property',array('property_arr'=>$property_arr));
    }
}