<?php
/**
 * 仓库接口
 * @author Phil
 */
class StockController extends Controller
{
	/*
	 * 商品出库
	 * @return string
	 */
    public function actionOut()
    {
    	$model = Yii::app()->request->getParam('model');//商品型号
    	$oldstock = Yii::app()->request->getParam('stock');//商品库存
    	$num = Yii::app()->request->getParam('num');	//出库数量
    	$stock = $oldstock-$num;
    	$arr['ip'] = CSystem::getip();
    	$arr['date'] = date('Y-m-d H:i:s' ,time());
    	$arr['model'] = $model;
    	$arr['oldstock'] = $oldstock;
    	$arr['num'] = $num;
    	$arr['type'] = 'out';
    	$store_model_arr = CProduct::searchmodel_Bymodel($model);
    	$jsonStr = json_encode($arr);
    	$file = Yii::getPathOfAlias('webroot').'/stocklog/log.txt'; 
    	if($store_model_arr['stock'] == $oldstock)
    	{
    		$arr['error'] = '商城该商品型号库存和仓库系统库存不一致';
    	}
    	$res=CProduct::updatastock($model,$stock);
    	if($res)
    	{ 
    		file_put_contents($file, $jsonStr.PHP_EOL, FILE_APPEND);
    	}else{
    		$arr1['date'] = date('Y-m-d H:i:s' ,time());
    		$arr1['message'] = '商品库存没有变化';
    		$arr1['type'] = 'out';
    		$arr1['ip'] = CSystem::getip();
    		$jsonStr1 = json_encode($arr1);
    		file_put_contents($file, $jsonStr1.PHP_EOL, FILE_APPEND);
    	}
		
    }
    /*
     * 商品入库
     * @return string
     */
    public function actionIn()
    {
    	$model = Yii::app()->request->getParam('model');//商品型号
    	$oldstock = Yii::app()->request->getParam('stock');//商品库存
    	$num = Yii::app()->request->getParam('num');	//入库数量
    	$stock = $oldstock+$num;
    	$arr['ip'] = CSystem::getip();
    	$arr['date'] = date('Y-m-d H:i:s' ,time());
    	$arr['model'] = $model;
    	$arr['oldstock'] = $oldstock;
    	$arr['num'] = $num;
    	$arr['type'] = 'in';
    	$store_model_arr = CProduct::searchmodel_Bymodel($model);
    	$jsonStr = json_encode($arr);
    	$file = Yii::getPathOfAlias('webroot').'/stocklog/log.txt'; 
    	if($store_model_arr['stock'] == $oldstock)
    	{
    		$arr['error'] = '商城该商品型号库存和仓库系统库存不一致';
    	}
    	$res=CProduct::updatastock($model,$stock);
    	if($res)
    	{ 
    		file_put_contents($file, $jsonStr.PHP_EOL, FILE_APPEND);
    	}else{
    		$arr1['ip'] = CSystem::getip();
    		$arr1['date'] = date('Y-m-d H:i:s' ,time());
    		$arr1['message'] = '商品库存没有变化';
    		$arr1['type'] = 'in';
    		$jsonStr1 = json_encode($arr1);
    		file_put_contents($file, $jsonStr1.PHP_EOL, FILE_APPEND);
    	}
    
    }
}




























