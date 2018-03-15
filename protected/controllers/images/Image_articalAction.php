<?php
class Image_articalAction extends CAction
{
    public function run()
    {
        $result=CImages::searcharticle();
        $this->controller->layout = false;
        $this->controller->render('image_artical',array('result'=>$result));
    }
}