
<?php
class AddpdfAction extends CAction{
	public function run()
	{	$file_url ='http://ydadmin.rdbuy.com.cn/uploadsfile/' ;//Yii::app()->request->hostInfo.'/uploadsfile/';
		$contact_goods = Yii::app()->request->getParam('contact_goods');
		$mark = Yii::app()->request->getParam('mark');
		if($contact_goods && $mark)
		{
			//模糊查询商品名称
			$result = CProduct::search_model_name_bylike($contact_goods);
			if(!empty($result))
			{
				echo json_encode($result);die;
			}else{
				echo '';die;
			}
		}
		$contact_goods_str = Yii::app()->request->getParam('contact_goods_str');
		if($contact_goods_str && $_FILES){
			$pNum = implode(explode(",",$contact_goods_str));
			$goods_pdf=CUploadimg::uploadDown();
			foreach($goods_pdf as $key=>$value)
			{
				$result=CProduct::addPdf($pNum,$file_url.$value['name']);
				if($result){Yii::success("修改成功",Yii::app()->createUrl('images/pdf'),"10");die;}
			}

		}
	$this->controller->layout = false;
	$this->controller->render('addpdf'/*,array('article_id'=>$article_id,'title'=>$title,'article_images'=>$article_images)*/);
	}
}