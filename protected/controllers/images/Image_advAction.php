<?php
class Image_advAction extends CAction
{
	public function run()
	{	
		$results = CImages::searchimgsclassnames();
		$result= CImages::searchadver();
		$images_class_id =Yii::app()->request->getParam('imagesclass');
		$adv_id = Yii::app()->request->getParam('adv_id');
        $is_delete = Yii::app()->request->getParam('is_delete');
        if($adv_id && $is_delete==1)
        {
        	
        	$code = CImages::editadverstatebyid($adv_id,$is_delete);
        	echo $code;
        }
        if($adv_id && $is_delete==0)
        {
        	$code = CImages::editadverstatebyid($adv_id,$is_delete);
        	echo $code;
        }
        if($images_class_id && !empty($images_class_id)){
        	$advp = "images_class_id LIKE '%$images_class_id%'";
        	$result = CImages::search_Bywhere($advp);
        	
        }
        
		
    	$count =count($result);
        $this->controller->layout = false;
        $this->controller->render('image_adv',array('result'=>$result,'count'=>$count,'results'=>$results));
        	}
}