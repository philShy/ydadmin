<?php
class EditroleAction extends CAction
{
    public function run()
    {
        $role_id = Yii::app()->request->getParam('id');
        $auth_one_str = CManage::searchAll_authOne($role_id);
        $auth_id_one_arr = explode(',',$auth_one_str['auth_id']);
        $auth_arr0 = CManage::searchAll_auth0();
        $role_name = Yii::app()->request->getParam('role-name');
        $role_introduce = Yii::app()->request->getParam('role-introduce');
        $checkAll = Yii::app()->request->getParam('checkAll');
        $subBox = Yii::app()->request->getParam('subBox');
        $auth_id_arr = array();
        $auth_join_arr = array();
        if($subBox)
        {
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
            $result = CManage::insert_oneRole($role_id,$role_name,$auth_id,$auth_join,$role_introduce);
            if($result)
            {
                Yii::success("编辑角色成功",Yii::app()->createUrl('manage/role'),"1");die;
            }
        }
        $this->controller->layout = false;
        $this->controller->render('editrole',
            array(
                'auth_arr0'=>$auth_arr0,
                'role_id'=>$role_id,
                'auth_id_one_arr'=>$auth_id_one_arr,
                'auth_one_str'=>$auth_one_str,
            ));
    }
}