<?php
class AddpropertyAction extends CAction{
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
        $name = Yii::app()->request->getParam('name');
        $sort = Yii::app()->request->getParam('sort')?Yii::app()->request->getParam('sort'):1;
        $goods_property_value = Yii::app()->request->getParam('property');

        if(!empty($_POST))
        {
        	/*先向 goods_property 表插入商品规格名*/
        	$id = CProduct::insert_goods_property($name,$sort);
        	if($id && !empty($goods_property_value))
        	{
        		foreach($goods_property_value as $k=>$v)
        		{
        			CProduct::insert_goods_property_value($id,$v,$k);
        		}
        	}elseif($id && $goods_property_value)
            {
                CProduct::insert_goods_property_value($id,$name_value='',$sort='1');
            }
        }
        $this->controller->layout = false;
        $this->controller->render('addproperty');
    }
}














