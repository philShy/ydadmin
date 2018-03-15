<?php
class editadverAction extends CAction
{
	public function run()
	{
		
		$id=Yii::app()->request->getParam('id');
		$result=CProduct::searchadverbyid($id);
		$aid=Yii::app()->request->getParam('aid');
		$delimiter=",";
		$string=$result['goods_model_id'];
		$strings=$result['goods_sku'];
	
		$first_category=Yii::app()->request->getParam('first_category');
		
		$small_cId=Yii::app()->request->getParam('small_cId');
		$arr1=explode($delimiter,$string);
		$arrs1=explode($delimiter,$strings);
		
		$sbc=CProduct::searchBigCateall();
		$model= CProduct::searchGoodsmodelbyid($arr1);
		$product_id=Yii::app()->request->getParam('product_id');
		
// 		if($product_id||$product_ids||$product_idss){
// 			$goods_model_id="$product_id,$product_ids,$product_idss";
		
			
// 				$success=CProduct::editadvers($aid, $goods_model_id);
				
// 				if($success){Yii::success("上传成功",Yii::app()->createUrl('../adver/advers'),"1");die;}
				
			
// 		}
		if(Yii::app()->request->isAjaxRequest &&!empty($small_cId))
		{
				
			$goods_model=CProduct::searchmodelsbycalsid($small_cId);
			echo json_encode($goods_model);die;
		
		
		
		}
		if(Yii::app()->request->isAjaxRequest &&!empty($first_category))
		{
			$second_category=CProduct::searchSmallCateByPid($first_category);
			echo json_encode($second_category);die;
		
				
				
		}
		
		if(Yii::app()->request->isAjaxRequest &&!empty($product_id))
		{
			$sku=CProduct::searchsku_bymodelid($product_id);
			echo json_encode($sku);die;
		
				
				
		}
		
		
		 $arr['pd'] = Yii::app()->request->getParam('pd');
		
		 $arr['sku_id'] = Yii::app()->request->getParam('sku_id');
		
		if(!empty($arr['pd'])||!empty($arr['sku_id'])){
			$goods_model_id=implode(',', $arr['pd']);
			$sku_id=implode(',', $arr['sku_id']);
			$success=CProduct::editadvers($aid, $goods_model_id,$sku_id);
			if($success){Yii::success("上传成功",Yii::app()->createUrl('../adver/advers'),"1");die;}
		}
		
		$this->controller->layout = false;
		$this->controller->render('editadvers',array('arr1'=>$arr1,'arrs1'=>$arrs1,'sbc'=>$sbc,'model'=>$model,'result'=>$result));
	}
}