<?php
class EditarticalAction extends CAction
{
	public function run()
	{	
		
		$id = Yii::app()->request->getParam('id');
		$article_id = Yii::app()->request->getParam('article_id');
		$img_url = Yii::app()->request->hostInfo.'/images/articalss/';
		 
		$img_path = 'images/articalss/';
		$results =CImages::searcharticlebyid($id);
		if($_FILES){
		
			
			 
			$images_url = CUploadarticalimg::uploadarticleimg($article_id, $img_url);
			
			$sp = CImages::editarticlepic($article_id,$images_url);
			if($sp)
			{
			
				Yii::success("修改成功",Yii::app()->createUrl('../images/image_artical'),"1");die;
			
			}else{
				Yii::error("失败",Yii::app()->createUrl('../images/image_artical'),"1");die;
			}
		}
		
		$this->controller->layout = false;
		$this->controller->render('editarticle',array('results'=>$results));
	}
}