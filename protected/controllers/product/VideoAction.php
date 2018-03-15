<?php
class VideoAction extends CAction
{
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
        $model_id = Yii::app()->request->getParam('model_id');
        if($model_id)
        {
        	$res =CProduct::delvideo_Bymidelid($model_id);
        	echo $res;die;
        }
        $product = CProduct::search_videoModel();
        $this->controller->layout = false;
        $this->controller->render('video',array('product'=>$product));
    }
}