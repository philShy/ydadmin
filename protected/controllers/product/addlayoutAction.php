<?php
class AddlayoutAction extends CAction{
	public function run(){
		
		$sbc=CProduct::searchBigCateall();
		$product=Yii::app()->request->getParam('product');
		$bland=Yii::app()->request->getParam('bland');
		$first_category=Yii::app()->request->getParam('first_category');
		$arr['model_new']=Yii::app()->request->getParam('model_new');
		$arr['choice']=Yii::app()->request->getParam('choice');
		$first_categorys=Yii::app()->request->getParam('first_categorys');
		$second_categorys=Yii::app()->request->getParam('second_categorys');
		
		$model_id=Yii::app()->request->getParam('model');
		
		$brand=Yii::app()->request->getParam('brand');
		$sort=Yii::app()->request->getParam('sort');
		$adver=Yii::app()->request->getParam('adver');
		if(Yii::app()->request->isAjaxRequest &&$first_categorys&&$second_categorys&&$model_id&&$brand&&$adver&&$arr['model_new'])
		
		{	
			
			$big_names=CProduct::searchcates_Byid($first_categorys);
			$small_names=CProduct::searchcates_Byids($second_categorys);
			
			$big_names['data']=$small_names;
		
			
			$models=CProduct::searchmodeladv_Byid($model_id);
			
			$model=json_encode($models);
			
			$bland_js=CProduct::searchbrandjs_Byid($brand);
			$brandjs=json_encode($bland_js);
			$advers=CProduct::searchjsadv_Byid($adver);
			$adverjs=json_encode($advers);
			$model_new = implode(',',$arr['model_new']);
			$i=0;
			$models_t = CProduct::searchmodeladvs_Byid($model_new);
			
			foreach ($models_t as $key =>$shoplist){
			
				$index = count($shoplist);
				$shoplist['is_new'] =$arr['choice'][$i];
				$models_t[$key]=$shoplist;
				$i++;
			}
			$models_news=json_encode($models_t);
			$category=json_encode($big_names);
			
			$result = CProduct::addindex($category,$model,$brandjs,$adverjs,$models_news,$sort);
			echo $result; die;	
			 	}
// 		if(){
			
			
			
// // 			$add=CProduct::addfloor($first_categorys,$second_categorys,$model_id,$model_id_t,$brand,$adv,$sort);
// // 			if($add){
// // 				Yii::success("上传成功",Yii::app()->createUrl('../product/layout'),"1");die;
// // 			}
// 		}
		
			 	$contact_goods = Yii::app()->request->getParam('contact_goods');
			 	$mark = Yii::app()->request->getParam('mark');
			 	/*如果有商品名传入*/
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
			 	
			 	
			 	$goods_model_id =Yii::app()->request->getParam('goods_model_id');
			 	if(!empty($goods_model_id))
			 	{
			 		//echo json_encode($goods_model_id);die;
			 		$goods_sku=CProduct::searchsku_bymodelid($goods_model_id);
			 	
			 		echo json_encode($goods_sku);die;
			 	
			 	
			 	
			 	}
		
		
		
		
		$adv=CImages::searchimgsclassnames();
		if(!empty($first_category))
		{			
			$second_category=CProduct::searchSmallCateByPid($first_category);
			echo json_encode($second_category);die;

			
			
		}
		
		if(!empty($product))
		{			$products=CProduct::searchproductByPid($product);
					
					echo json_encode($products);die;
		}
		if(!empty($bland))
		{			$blands=CProduct::searchblandByPid($bland);
			
		echo json_encode($blands);die;
		}
		
		
		$this->controller->layout = false;
		$this->controller->render('addlayout',array('sbc'=>$sbc,'adv'=>$adv));
	}
}