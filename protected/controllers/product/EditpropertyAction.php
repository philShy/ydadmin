<?php
class EditpropertyAction extends CAction{
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
        $property_id = Yii::app()->request->getParam('property_id');
        $property_name_val = Yii::app()->request->getParam('property_name_val');
        if($property_id&&$property_name_val)
        {
            //删除商品规格值
            $res = CProduct::del_propertyName_byPropertyId($property_id,$property_name_val);
            if($res)
            {
                CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_property_value','delete');
                echo $res;
            }
        }
        if(!empty($id))
        {
            /*通过商品规格ID查询规格和属性*/
            $property_arr = CProduct::search_property_by_propertyid($id);
        }
        if($_POST)
        {
            /*$property_name_res = CProduct::edit_property_name_byid($_POST['id'],$_POST['name']);
            if($property_name_res)
            {
                $del_res = CProduct::del_all_property_name($_POST['id']);
                foreach($_POST['property'] as $k=>$v)
                {

                    $add_res = CProduct::add_all_property_name($_POST['id'],$v);
                }
                if($add_res)
                {
                    Yii::success("修改成功",Yii::app()->createUrl('product/property'),"1");die;
                }
            }*/
            $name_value_arr = CProduct::search_property_name_byid($_POST['id']);
            if(empty($_POST['property']))
            {
                $del_res = CProduct::del_all_name_value($_POST['id']);
                if($del_res)
                {
                    Yii::success("修改成功",Yii::app()->createUrl('product/property'),"1");die;
                }
            }else{
                $del_name_value = array_diff($name_value_arr,$_POST['property']);//要删除的属性
                $add_name_value = array_diff($_POST['property'],$name_value_arr);//要增加的属性
                if(!empty($del_name_value) && !empty($add_name_value))
                {
                    $flip_arr = array_flip($del_name_value);
                    $i = 0;
                    foreach($flip_arr as $k=>$v)
                    {
                        $del_name_value_id_arr[$i] = $v;
                        $i++;
                    }
                    $del_name_value_id_str = implode(',',$del_name_value_id_arr);
                    $del_res = CProduct::del_name_value($del_name_value_id_str);
                    foreach($add_name_value as $k=>$v)
                    {
                        $add_res = CProduct::add_name_value($_POST['id'],$v);
                    }

                    if ($add_res)
                    {
                        Yii::success("修改成功",Yii::app()->createUrl('product/property'),"1");die;
                    }
                }
                else if(!empty($del_name_value) && empty($add_name_value))
                {
                    $flip_arr = array_flip($del_name_value);
                    $i = 0;
                    foreach($flip_arr as $k=>$v)
                    {
                        $del_name_value_id_arr[$i] = $v;
                        $i++;
                    }
                    $del_name_value_id_str = implode(',',$del_name_value_id_arr);
                    $del_res = CProduct::del_name_value($del_name_value_id_str);
                    if ($del_res)
                    {
                        Yii::success("修改成功",Yii::app()->createUrl('product/property'),"1");die;
                    }
                }
                else if(empty($del_name_value) && !empty($add_name_value))
                {

                    foreach($add_name_value as $k=>$v)
                    {
                        $add_res = CProduct::add_name_value($_POST['id'],$v);
                    }
                    if ($add_res)
                    {
                        Yii::success("修改成功",Yii::app()->createUrl('product/property'),"1");die;
                    }
                }else{
                    Yii::success("修改成功",Yii::app()->createUrl('product/property'),"1");die;
                }
            }

        }
        /*echo '<pre>';
        var_dump($property_arr);*/
        $this->controller->layout = false;
        $this->controller->render('editproperty',array('property_arr'=>$property_arr));
    }
}














