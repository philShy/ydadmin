<?php
class AddtypeAction extends CAction{
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
        
       if($_POST)
	   {    
	   		/*echo '<pre>';
	   		var_dump($_POST);die;*/
	   		$length = count($_POST['attr']['attr']);
	   		$key=0;
	   		for ($i = 1; $i < $length+1; $i++)
	   		{
		   		if (!empty($_POST['attr']['attr'][$i])&&!empty($_POST['attr']['attr_val'][$i]))
		   		{
		   			$attr_arr[$key]['sort'] = $_POST['attr']['sort'][$i];
			   		$attr_arr[$key]['attr'] = $_POST['attr']['attr'][$i];
			   		$attr_arr[$key]['attr_val'] = $_POST['attr']['attr_val'][$i];
			   		$key++;
		   		}
	   		}


	   		if($_POST['property'])
            {
                $property = implode(',',$_POST['property']);
            }else{
                $property=1;
            }
      		/*添加商品类型*/
      		$type_id = CProduct::add_goods_type($_POST['name'],$property);
      		if($type_id)
      		{
      			//添加规格值
                if($property!=1)
                {
                    foreach($_POST['property'] as $k=>$v)
                    {
                        $res = CProduct::add_type_id_to_porperty($v,$type_id);
                    }
                }
      			if($attr_arr)
      			{
      				//添加商品属性
      				foreach ($attr_arr as $attr_arr_k=>$attr_arr_v)
      				{
      					$attr_id = CProduct::add_goods_attr_bytypeid($type_id,$attr_arr_v['attr'],$attr_arr_v['attr_val']);
      				
      					foreach (explode(',',$attr_arr_v['attr_val']) as $kk=>$vv)
      					{
      						$attr_val_id[$kk] =  CProduct::add_goods_attr_val_byattrid($attr_id,$vv);
      					}
      				}
      			}
      			Yii::success("添加商品类型成功",Yii::app()->createUrl('product/addtype'),"1");die;
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
        $this->controller->render('addtype',
        		array(
        				'property_arr'=>$property_arr,
        				'type_arr'=>$type_arr,
        				'one_type_arr'=>$one_type_arr,
        				'property_id_str'=>$property_id_str,
        		));
    }
}




















