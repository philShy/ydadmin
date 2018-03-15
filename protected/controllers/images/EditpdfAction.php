<?php
class EditpdfAction extends CAction
{
    public function run()
    {
    	$file_url = Yii::app()->request->hostInfo.'/uploadsfile/';
    	$goods_id =Yii::app()->request->getParam('goods_id');
    	
        $id = Yii::app()->request->getParam('id');
        if(!empty($_FILES)){
        
        	$goods_pdf=CUploadimg::uploadDown();
        	if($goods_pdf){
        	foreach($goods_pdf as $key=>$value)
            		{
            			$result=CProduct::editPdf($goods_id,$file_url.$value['name'],$key);
            			if($result){Yii::success("修改成功",Yii::app()->createUrl('images/pdf'),"10");die;}
            		}
            	
        	}
        	else{
        		Yii::error("请添加pdf文档",Yii::app()->createUrl('images/pdf'),"10");die;
        	}
        }
     	$pdf =CImages::searchpdfById($id);
     	$pdf_id=Yii::app()->request->getParam('pdf_id');
     	$mark = Yii::app()->request->getParam('mark');
     	if($mark == 'del'){
     	
     		$result = CImages::delpdf($pdf_id);
     		echo $result; die;
     	}
        $this->controller->layout = false;
        $this->controller->render('editpdf',array('pdf'=>$pdf));
    }
}