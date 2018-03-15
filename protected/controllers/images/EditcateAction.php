<?php
class EditcateAction extends CAction{
    public function run()
    {
    	$id=Yii::app()->request->getParam('cate_id');
    	$img=Yii::app()->request->getParam('img');
    	$result=CProduct::searchcate_Byid($id);
    	$images=Yii::app()->request->getParam('images');
    	$img_url = Yii::app()->request->hostInfo.'/images/brand/';
    	$img_path = 'images/brand/';
    	$file = $_FILES['file'];
    	$cate_id=Yii::app()->request->getParam('cateid');
    	if(!empty($cate_id)){
    		
    		if(!empty($file['name'])&&$images=="1"){
    			
    			if(is_file($img_path.$img))
    			{
    				unlink($img_path.$img);
    			}
    			$new_img = CUploadcatelogo::uploadcatelogo($img_url, $img_path);
    			
    			$result = CImages::editcatelogobyid($cate_id,$new_img);
    			if($result)
    			{
    				Yii::success("修改成功",Yii::app()->createUrl('images/cate'),"1");die;
    			}
    		}else if(!empty($file['name'])&&$images=="2"){
    			 
    			if(is_file($img_path.$img))
    			{
    				unlink($img_path.$img);
    			}
    			$new_imgs = CUploadcatelogo::uploadcatelogo($img_url, $img_path);
    			 
    			$result = CImages::editcatelogobyids($cate_id,$new_imgs);
    			if($result)
    			{
    				Yii::success("修改成功",Yii::app()->createUrl('images/cate'),"1");die;
    			}
    		}else if(empty($file['name'])){
    			$cate=CProduct::searchcate_Byid($cate_id);
    			$result = CImages::editcatelogobyid($cate_id,$cate['image_url']);
    			if($result)
    			{
    				Yii::success("修改成功",Yii::app()->createUrl('images/cate'),"1");die;
    			}else{
    				Yii::success("修改失败1",Yii::app()->createUrl('images/cate'),"1");die;
    			}
    		}else{
    				Yii::success("修改失败2",Yii::app()->createUrl('images/cate'),"1");die;
    			}
    	}
    	$this->controller->layout = false;
    	$this->controller->render('editcate',array('result'=>$result,'img'=>$img));
    }
}