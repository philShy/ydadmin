<?php
class AddroleAction extends CAction
{
    public function run()
    {
        $auth_arr0 = CManage::searchAll_auth0();
        $role_name = Yii::app()->request->getParam('role-name');
        $role_introduce = Yii::app()->request->getParam('role-introduce');
        $checkAll = Yii::app()->request->getParam('checkAll');
        $subBox = Yii::app()->request->getParam('subBox');
        $label = Yii::app()->request->getParam('label');
        $auth_id_arr = array();
        $auth_join_arr = array();
        if($subBox)
        {
            if($label)
            {
                if(in_array(1,$label)&&in_array(2,$label)&&in_array(3,$label)||in_array(1,$label)&&in_array(3,$label)||in_array(2,$label)&&in_array(3,$label)||in_array(3,$label))
                {
                    $upload_goods_lable=3;
                }
                if(in_array(1,$label)&&in_array(2,$label)&&in_array(3,$label)==false||in_array(2,$label)&&in_array(3,$label)==false)
                {
                    $upload_goods_lable=2;
                }
                if(in_array(1,$label)&&in_array(2,$label)==false&&in_array(2,$label)==false)
                {
                    $upload_goods_lable=1;
                }
            }
            foreach($subBox as $key=>$value)
            {
                foreach($value as $k=>$v)
                {
                    $auth_id_arr[] = $v;
                    $auth = CManage::searchAction($v);
                    $auth_join_arr[] = $auth['contrl'].'/'.$auth['action'];
                }
            }
            $authAll_id_arr = array_merge($checkAll,$auth_id_arr);
            $auth_id = implode(',',$authAll_id_arr);
            $auth_join = 'admin/index,login/index,'.implode(',',$auth_join_arr);

            $result = CManage::insertRole($role_name,$auth_id,$auth_join,$role_introduce,$upload_goods_lable,$order_lable=1);
            if($result)
            {
                Yii::success("添加角色成功",Yii::app()->createUrl('manage/role'),"1");die;
            }
        }
        $this->controller->layout = false;
        $this->controller->render('addrole',array('auth_arr0'=>$auth_arr0));
    }
}