<?php
class layoutAction extends CAction{
	public function run(){
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
	$layout = CProduct::searchlayoutall();
	$layout_id = Yii::app()->request->getParam('layout_id');
	$is_delete = Yii::app()->request->getParam('is_delete');
	$state = Yii::app()->request->getParam('state');

	if($is_delete)
	{
		if($is_delete == 'sure')
		{
			$is_delete = 0;
		}else{
			$is_delete = 1;
		}
		$code = CProduct::deladversbyid($layout_id,$is_delete);
		
		echo $code;die;
	}
	$this->controller->layout = false;
	$this->controller->render('layout',array('layout'=>$layout));
}
}