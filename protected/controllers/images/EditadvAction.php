<?php
class EditadvAction extends CAction{
	public function run()
	{	$id = Yii::app()->request->getParam('id');
		$sap =CImages::searchadvpivbyid($id);
		$searchgood=CProduct::searchGoodsmodelall();
        $advid = Yii::app()->request->getParam('adv_id');
        $names = Yii::app()->request->getParam('names');
        $goods_id = Yii::app()->request->getParam('goods_id');
      	$images_class_id =Yii::app()->request->getParam('images_class_id');
        $sort = Yii::app()->request->getParam('sort');
        $mark = Yii::app()->request->getParam('mark');
       	$is_delete = Yii::app()->request->getParam('is_delete');
    	$article_id =Yii::app()->request->getParam('is_delete');
        $mark = Yii::app()->request->getParam('mark');
        $aa =CImages::searchImage_byid($sap['images_class_id']);
        $file = $_FILES;
        $img_url = Yii::app()->request->hostInfo.'/images/adver/';
         
        $img_path = 'images/adver/';
        if($mark == 'del'){

            $result = CImages::deladvpic($advid);
            echo $result; die;
        }
     
           
            if($advid){
            	
            	$sap1 = CImages::editadvbyid($advid, $names, $sort,$is_delete);
            	if(!empty($file)){
            		
            		
            	
            		$images_url = CUploadadvpic::uploadadvpic($img_url, $img_path);
            		$sp = CImages::editadvpic($advid,$images_url);
            	}

           
            
            	
            	if($sap1||$sp)
            	{
            
            		Yii::success("修改成功",Yii::app()->createUrl('../images/image_adv'),"1");die;
            
            	}else{
            		Yii::error("失败",Yii::app()->createUrl('../images/image_adv'),"1");die;
            	}
            	 
            	$count = count($brandarr);
            }	 
		
		
		$this->controller->layout = false;
		$this->controller->render('editadv',array('sap'=>$sap,'aa'=>$aa));
	}
}