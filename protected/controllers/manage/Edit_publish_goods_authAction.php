<?php
class Edit_publish_goods_authAction extends CAction
{
    public function run()
    {
        //echo '<pre>';
        $manager_id = Yii::app()->request->getParam('id');
        $manageOneArr = CManage::searchManager_one($manager_id);
        $brandArr = CProduct::searchBrandall();
        $brand_id_str = $manageOneArr['brand_id_str'];
        $brand_id_arr = explode(',',$brand_id_str);
        if($_POST)
        {
            if($_POST['brand_id'])
            {
                $brand_id_str = implode($_POST['brand_id'],',');

            }else{
                $brand_id_str='';
            }

            $res = CManage::editManager_byId($_POST['id'],$_POST['manager'],$_POST['publish_goods_sign'],$brand_id_str);
            if($res)
            {
                Yii::success("更新成功",Yii::app()->createUrl('manage/publish_goods_auth'),"1");die;
            }
        }
        $this->controller->layout = false;
        $this->controller->render('edit_publish_goods_auth',array(
            'brandArr'=>$brandArr,
            'manageOneArr'=>$manageOneArr,
            'brand_id_arr'=>$brand_id_arr,
        ));
    }
}