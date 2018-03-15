<?php
class Publish_goods_authAction extends CAction
{
    public function run()
    {
        //echo '<pre>';
        $manageArr = CManage::searchAllmanager1();
        $this->controller->layout = false;
        $this->controller->render('publish_goods_auth',array(
            'manageArr'=>$manageArr,
        ));
    }
}