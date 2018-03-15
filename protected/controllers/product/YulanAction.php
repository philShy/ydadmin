<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/1
 * Time: 16:57
 */
class YulanAction extends CAction
{
    public function run()
    {
        //echo '<pre>';
        $model_id = Yii::app()->request->getParam('model_id');
        $model_pic = CProduct::searchModelPic($model_id);
        $modelOneArr = CProduct::searchGoodsmodelbyid($model_id);
        $skuArr = CProduct::searchskus_byid1($model_id);
        $goodsSkuArr = CProduct::searchSkuArr_byModelId($model_id);
        $skuArrCombination = json_decode($modelOneArr['model_sku_json'],true);
        $attrArr = json_decode($modelOneArr['model_attr_json'],true);
        //var_dump($skuArr);die;
        if($skuArr)
        {
            foreach ($skuArr as $k=>$v)
            {
                if($v['price1'])
                {
                    $newSkuArr[] = $skuArr[$k];
                }
            }
            $firstSkuArr = reset($newSkuArr);
        }


        foreach ($goodsSkuArr as $k=>$v)
        {
            $str_s='';
            $combination = explode(';',$v['combination']);
            foreach ($combination as $kk=>$vv)
            {
                $str_s .= explode(':',$vv)[1].'_';
            }
            $model_sku_arr['market_price'] = $firstSkuArr['market_price'];
            $model_sku_arr['price1'] = $firstSkuArr['price1'];
            $model_sku_arr['stock1'] = $firstSkuArr['stock1'];
            $model_sku_arr['sales'] = $firstSkuArr['pn'];
            $model_sku_arr['pn'] = $firstSkuArr[''];
            $model_sku_arr['sales_volume'] = $firstSkuArr['sales_volume'];
            $model_sku_arr['delivery_time'] = $firstSkuArr['delivery_time'];

            $model_sku_arr['sys_attrprice'][rtrim($str_s,'_')]['price1'] = $goodsSkuArr[$k]['price1'];
            $model_sku_arr['sys_attrprice'][rtrim($str_s,'_')]['market_price'] = $goodsSkuArr[$k]['market_price'];
            $model_sku_arr['sys_attrprice'][rtrim($str_s,'_')]['stock1'] = $goodsSkuArr[$k]['stock1'];
            $model_sku_arr['sys_attrprice'][rtrim($str_s,'_')]['sales'] = $goodsSkuArr[$k]['sales'];
            $model_sku_arr['sys_attrprice'][rtrim($str_s,'_')]['pn'] = $goodsSkuArr[$k]['pn'];
            $model_sku_arr['sys_attrprice'][rtrim($str_s,'_')]['sales_volume'] = $goodsSkuArr[$k]['sales_volume'];
            $model_sku_arr['sys_attrprice'][rtrim($str_s,'_')]['delivery_time'] = $goodsSkuArr[$k]['delivery_time'];
        }
        //var_dump(json_encode($model_sku_arr));die;
        $combinationArr = explode(';',$firstSkuArr['combination']);
        foreach ($combinationArr as $k=>$v)
        {
            $vv1[] = explode(':',$v)[1];
        }
        $firstV = json_encode($vv1);
        $this->controller->layout = false;
        $this->controller->render('yulan',array(
            'modelOneArr'=>$modelOneArr,
            'model_pic'=>$model_pic,
            'firstSkuArr'=>$firstSkuArr,
            'skuArrCombination'=>$skuArrCombination,
            'firstV'=>$firstV,
            'model_sku_json'=>json_encode($model_sku_arr),
            'attrArr'=>$attrArr,
        ));
    }
}