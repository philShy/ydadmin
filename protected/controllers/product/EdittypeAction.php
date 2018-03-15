<?php
class EdittypeAction extends CAction{
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
        $attr_v_id = Yii::app()->request->getParam('attr_v_id');
        $attr_v = Yii::app()->request->getParam('attr_v');
        $del = Yii::app()->request->getParam('del');
        $s = Yii::app()->request->getParam('s');
        $all = Yii::app()->request->getParam('all');
        $attr_id = Yii::app()->request->getParam('attr_id');
        $type = Yii::app()->request->getParam('name');
        $property = Yii::app()->request->getParam('property');
        if($del && $attr_id)
        {
        	//删除attr和attr_val
        	$del_attr_res = CProduct::del_attr_byid($attr_id);
        	$del_attr_val_res = CProduct::del_attr_val_byattrid($attr_id);
        	if($del_attr_res && $del_attr_val_res)
        	{
        		echo 1;die;
        	}
        }
        if($attr_v_id && $attr_v)
        {
           echo $attr_v_id.'-'.$attr_v;die;
        	//删除attr和attr_val
        	$attr_id = CProduct::search_attr_val_byid($attr_v_id)['attr_id'];
        	$attr_arr = CProduct::search_attr_byattrid($attr_id);
        	$attr_val_id_arr = explode(',', $attr_arr['attr_val_str']);
        	foreach($attr_val_id_arr as $k=>$v)
        	{
        		if($v == $attr_v)
        		{
        			unset($attr_val_id_arr[$k]);
        		}
        	}
        	$attr_val_str = implode(',', $attr_val_id_arr);
        	$ress = CProduct::edit_attr_byid($attr_id, $attr_val_str);
        	$res = CProduct::del_attr_val_byid($attr_id,$attr_v);
        	echo $res;die;
        }
        if($s)
        {
        	$attr_arr = explode(',', $s);
        	$ress = CProduct::edit_attr_byid($attr_id,$all);
        	foreach($attr_arr as $attr_key=>$attr_val)
        	{
        		$res = CProduct::add_goods_attr_val_byattrid($attr_id, $attr_val);
        	}
        	echo $res;die;
        }
        if($attr_id)
        {
        	$attr_val_res = CProduct::search_attr_val_byattrid($attr_id);
        	echo json_encode($attr_val_res);die;
        }
        /*编辑商品类型*/
        $one_type_arr = CProduct::search_type_byid($id);
        $type_arr = CProduct::search_type_all();
        $attr_arr = CProduct::search_attr_bytypeid($id);
        $count = count($attr_arr);
        $property_arr = CProduct::search_property_all();
        foreach($property_arr as $k=>$v)
        {
        	$arr .= $v['id'].',';
        }
        $property_id_str = rtrim($arr,',');
        if($_POST)
        {
            /*echo '<pre>';
            var_dump($_POST);die;*/
        	if(!empty($_POST['attr']))
        	{
        		$length = count($_POST['attr']['attr']);
        		$key=0;
        		for ($i = 0; $i < $length; $i++)
        		{
		        		if (!empty($_POST['attr']['attr'][$i])&&!empty($_POST['attr']['attr_val'][$i]))
		        		{
	        				$attr_arra[$key]['attr'] = $_POST['attr']['attr'][$i];
	        				$attr_arra[$key]['attr_val'] = $_POST['attr']['attr_val'][$i];
	        				$key++;
        				}
        		}
        		foreach ($attr_arra as $attr_arr_k=>$attr_arr_v)
        		{
        			$attra_id = CProduct::add_goods_attr_bytypeid($_POST['id'],$attr_arr_v['attr'],$attr_arr_v['attr_val']);
        		
        			foreach (explode(',',$attr_arr_v['attr_val']) as $kk=>$vv)
        			{
        				$attr_val_id[$kk] =  CProduct::add_goods_attr_val_byattrid($attra_id,$vv);
        			} 
        		}
        		
        	}
        	if($_POST['porerty_post_id_str']=='')
            {
                $_POST['porerty_post_id_str']=1;
            }
        	$res = CProduct::edittype_byid($_POST['type'],$_POST['id'],$_POST['porerty_post_id_str']);
        	if($res)
        	{
	        	$porerty_post_id_arr = explode(',',$_POST['porerty_post_id_str']);
	        	$one_property_id = explode(',',$one_type_arr['property_id']);
	        	$del_property_value = array_diff($one_property_id,$porerty_post_id_arr);//要删除的属性
		 		$add_property_value = array_diff($porerty_post_id_arr,$one_property_id);//要增加的属性
		 		
		 		if(!empty($del_property_value) && !empty($add_property_value))
		 		{
		 			foreach($add_property_value as $k=>$v)
		 			{
		 				$resadd = CProduct::edit_property_by_propertyid($_POST['id'],$v);
		 			}
		 			foreach($del_property_value as $k=>$v)
		 			{
		 				$resdel = CProduct::edit_property_by_propertyid($goods_type_id=Null,$v);
		 			}
		 			if($resadd&&$resdel){
		 				Yii::success("修改成功",Yii::app()->createUrl('product/type'),"1");die;
		 			}

		 		}elseif(!empty($del_property_value) && empty($add_property_value))
		 		{
		 			
		 			foreach($del_property_value as $k=>$v)
		 			{
		 				
		 				$resdel = CProduct::edit_property_by_propertyid($goods_type_id=Null,$v);
		 			}
		 			if($resdel){
		 				Yii::success("修改成功",Yii::app()->createUrl('product/type'),"1");die;
		 			}
		 		}elseif (empty($del_property_value) && !empty($add_property_value))
		 		{
		 			foreach($add_property_value as $k=>$v)
		 			{
		 				$resadd = CProduct::edit_property_by_propertyid($_POST['id'],$v);
		 			}
		 			if($resadd){
		 				Yii::success("修改成功",Yii::app()->createUrl('product/type'),"1");die;
		 			}
		 		}else{
		 			Yii::success("修改成功",Yii::app()->createUrl('product/type'),"1");die;
		 		} 
        	}
        	
        }
        /*echo '<pre>';
        var_dump($one_type_arr);*/
        $this->controller->layout = false;
        $this->controller->render('edittype',
        		array(
        				'property_arr'=>$property_arr,
        				'type_arr'=>$type_arr,
        				'one_type_arr'=>$one_type_arr,
        				'type_id'=>$one_type_arr['id'],
        				'property_id_str'=>$property_id_str,
        				'attr_arr'=>$attr_arr,
        				'count'=>$count,
        		));
    }
}




















