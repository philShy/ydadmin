<?php
class AddadvAction extends CAction{
	public function run()
	{	
		$result=CImages::searchimgsclassnames();
		$searchgood=CProduct::searchGoodsmodelall();
		$names = Yii::app()->request->getParam('names');
        $sort = Yii::app()->request->getParam('sort');
        $goods_id= Yii::app()->request->getParam('goods_id');
        $images_class_id= Yii::app()->request->getParam('images_class_id');
     	$is_delete=Yii::app()->request->getParam('is_delete');
     	$article_id= Yii::app()->request->getParam('article_id');
     	$advters= Yii::app()->request->getParam('adversss');
     	$adr = Yii::app()->request->getParam('adr');
	if(!empty($adr)&&$adr>0)
		{			echo 2;
			$aa =CImages::searchImage_byid($adr);
			echo json_encode($aa);die;
			
			
		}
   
     	$img_url = Yii::app()->request->hostInfo.'/images/adver/';
     	$img_path = 'images/adver/';
     	if($_FILES)
     	{
				
     		$img = CUploadadvpic::uploadadvpic($img_url, $img_path);
     					
     		
     			if($goods_id != null){
     				$adressurl= Yii::app()->request->hostInfo.'/product/productdetail?model_id='.$goods_id;
     				
     				$advid = CImages::addadv($names,$img,$sort,$goods_id,$images_class_id,$adressurl,$is_delete);
     			}
     			if($article_id !=null){
     				$addressurl=Yii::app()->request->hostInfo.'/article/articledetail?article_id='.$article_id;
     				$advid = CImages::addadvb($names,$img,$sort,$article_id,$images_class_id,$addressurl,$is_delete);
     			}
     			if($advters !=null){
     				$advid = CImages::addadva($names,$img,$sort,$advters,$images_class_id,$is_delete);
     			}
     			if($advid)
     			{
     				Yii::success("添加成功1",Yii::app()->createUrl('../images/image_adv'),"1");die;
     			}
     		
     	}
     	
     	
        

        if(Yii::app()->request->isAjaxRequest && $names){
        	if(empty($names))
        	{
        		echo 0;die;
        	}
        	$result =CImages::searchadvpic($names);
        	if(!empty($result))
        	{
        		echo 1;
        	}else if(empty($result))
        	{
        		echo 2;
        	}
        	die;
        }
        if(Yii::app()->request->isAjaxRequest && $goods_id){
        	if(empty($goods_id))
        	{
        		echo 0;die;
        	}
        	$result = CImages::searchadvgoodsid($goods_id);
        	if(!empty($result))
        	{
        		echo 1;
        	}else if(empty($result))
        	{
        		echo 2;
        	}
        	die;
        }
        if(Yii::app()->request->isAjaxRequest && $images_class_id){
        	if(empty($images_class_id))
        	{
        		echo 0;die;
        	}
        	$result = CImages::searchadvimagesclassid($images_class_id);
        	if(!empty($result))
        	{
        		echo 1;
        	}else if(empty($result))
        	{
        		echo 2;
        	}
        	die;
        }
        
        if(Yii::app()->request->isAjaxRequest && $sort){
        	if(empty($sort))
        	{
        		echo 0;die;
        	}
        	$result = CImages::searchadvsort($sort);
        	if(!empty($result))
        	{
        		echo 1;
        	}else if(empty($result))
        	{
        		echo 2;
        	}
        	die;
        }
        
        

		
		$this->controller->layout = false;
		$this->controller->render('addadv',array('result'=>$result,'searchgood'=>$searchgood));
	}
};