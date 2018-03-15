<?php
class ListcateAction extends CAction{
    public function run()
    {
    	
      if(Yii::app()->request->isAjaxRequest && $_FILES && !empty($id)){
      	$img_url = Yii::app()->request->hostInfo.'/images/adver/';
      	$img_path = 'images/adver/';
      	$pid= Yii::app()->request->getParam('pid');
      	if(!empty($pid)){
      		echo $pid;die;
      	}
      }
		$cate=CProduct::searchCatealls();
        $this->controller->layout = false;
        $this->controller->render('catelist',array('cate'=>$cate));
    }
}