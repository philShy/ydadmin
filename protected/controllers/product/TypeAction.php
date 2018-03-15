<?php
class TypeAction extends CAction{
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
        $type = Yii::app()->request->getParam('name');
        $property = Yii::app()->request->getParam('property');
        $is_delete = Yii::app()->request->getParam('is_delete');
        /*删除商品类型*/
        if($is_delete)
        {
        	$res = CProduct::del_type_byid($id);
        	{
        		echo $res;die;
        	}
        }
        /*编辑商品类型*/
        if($id)
        {
        	$one_type_arr = CProduct::search_type_byid($id);
        	echo json_encode($one_type_arr);die;
        	
        }
      	if($type && $property)
      	{
   			$property_id_arr = explode(',', rtrim($property,','));
      		/*添加商品类型*/
      		$res = CProduct::add_goods_type($type,$property);
      		
      		if($res){
      			
      			foreach($property_id_arr as $k=>$v)
      			{
      				$res = CProduct::add_type_id_to_porperty($v,$res);
      			}
      		}
      	}
        $type_arr = CProduct::search_type_all();
        $property_arr = CProduct::search_property_all();
        foreach($property_arr as $k=>$v)
        {
        	$arr .= $v['id'].',';
        }
        $property_id_str = rtrim($arr,',');
        $this->controller->layout = false;
        $this->controller->render('type',
        		array(
        				'property_arr'=>$property_arr,
        				'type_arr'=>$type_arr,
        				'one_type_arr'=>$one_type_arr,
        				'property_id_str'=>$property_id_str,
        		));
    }
}




















