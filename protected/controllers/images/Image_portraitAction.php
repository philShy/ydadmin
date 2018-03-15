<?php
class Image_portraitAction extends CAction
{
	
    public function run()
    {   
    	
    $result=CImages::searchuser_original_portrait();
    	
    	
    	
        $this->controller->layout = false;
        $this->controller->render('image_portrait',array('result'=>$result));
    }
}