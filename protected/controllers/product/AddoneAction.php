<?php
use GuzzleHttp\json_decode;
class AddoneAction extends CAction{
    public function run()
    {
        /*$action = $this->getId();
        $controller = Yii::app()->controller->id;
        $the_join = $controller.'/'.$action;
        $userid = Yii::app()->user->id;
        $auth_arr = CManage::searchAuth_Byadminid($userid);
        $auth_join = array_filter(explode(',',$auth_arr['auth_join']));
        if(!empty($auth_join))
        {
            if(!in_array($the_join,$auth_join))
            {

                Yii::error("没有访问权限",Yii::app()->createUrl('home/index'),"1");die;
            }
        }else{
            if($auth_arr['role_id'] != 1)
            {
                Yii::error("没有访问权限",Yii::app()->createUrl('home/index'),"1");die;
            }
        }*/
        $type_id = Yii::app()->request->getParam('type_id');
        $add_n = Yii::app()->request->getParam('add_n');//商品属性标志
        $attr = Yii::app()->request->getParam('attr');//商品属性标志
        $add_r = Yii::app()->request->getParam('add_r');//商品属性值标志
        $attr_name = Yii::app()->request->getParam('attr_name');//商品属性名
        $attr_id = Yii::app()->request->getParam('attr_id');//商品属性ID
        $attr_value_name=Yii::app()->request->getParam('attr_value_name');//商品属性值
        $addrv = Yii::app()->request->getParam('addrv');//商品规格名标志
        $addr = Yii::app()->request->getParam('addr');//商品规格标志
        $property = Yii::app()->request->getParam('property');//商品规格值
        $goods_property_id = Yii::app()->request->getParam('property_id');//商品规格ID
        $name_value = Yii::app()->request->getParam('name_value');
        $name_value_id = Yii::app()->request->getParam('name_value_id');
        $model_sku_json = Yii::app()->request->getParam('model_sku_json');
        $model_attr_json = Yii::app()->request->getParam('model_attr_json');
        if($add_n&&$attr&&$type_id)
        {
            //添加attr
            $attr_res=CProduct::add_goods_attr_bytypeid($type_id,$attr,$attr_v='');
            echo $attr_res;die;

        }
        if($add_r&&$attr_name&&$attr_id&&$attr_value_name)
        {
            $attr_arr = CProduct::search_attr_byattrid($attr_id);
            $old_attr_val_str=$attr_arr['attr_val_str'];
            if($old_attr_val_str)
            {
                $new_attr_val_str=$old_attr_val_str.','.$attr_value_name;
            }else{
                $new_attr_val_str=$attr_value_name;
            }

            //添加attr_val
            $res_attr_val = CProduct::add_goods_attr_val_byattrid($attr_id,$attr_value_name);
            //更新attr
            $res_attr = CProduct::uptateAttr_byAttrId($attr_id,$new_attr_val_str);
            if($res_attr_val&&$res_attr)
            {
                echo '{"id":"'.$res_attr_val.'","code":"200"}';die;
            }else{
                echo '{"message":"添加失败","code":"500"}';die;
            }
        }
        if($model_sku_json==''||$model_sku_json=='[]')
        {
            $model_sku_json='';
        }
        if($model_attr_json==''||$model_attr_json=='[]')
        {
            $model_attr_json='';
        }
        if($addrv)
        {
            //添加规格值
            $eid = CProduct::add_property_val($goods_property_id,$name_value);
            CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_property_value','insert');
            echo $eid;die;
        }
        if($addr)
        {
        	//添加规格
        	$eid = CProduct::add_property($type_id,$property);
        }
        $ss = Yii::app()->request->getParam('ss');
        $pn = Yii::app()->request->getParam('pn');
        if(is_array($pn))
        {
        	$pn='';
        }
        $zi_json = Yii::app()->request->getParam('json');
        $goods_id = Yii::app()->request->getParam('goods_id');
        $cate_id = Yii::app()->request->getParam('cate_id');
        $cateid = CProduct::foo($cate_id);
        $title = Yii::app()->request->getParam('title');
        $goods_list = Yii::app()->request->getParam('goods_list');
        $model_number = Yii::app()->request->getParam('model_number');
        $stock = Yii::app()->request->getParam('stock');
        $price = Yii::app()->request->getParam('price');
        $preferential_price = Yii::app()->request->getParam('preferential_price')?Yii::app()->request->getParam('preferential_price'):0;
        $sales_volume = Yii::app()->request->getParam('sales_volume')?Yii::app()->request->getParam('sales_volume'):0;
        $associated = Yii::app()->request->getParam('associated');
        $after_sales = Yii::app()->request->getParam('after_sales');
        $is_publish = Yii::app()->request->getParam('is_publish');
        $is_preferential = Yii::app()->request->getParam('is_preferential');
        $in_storage = Yii::app()->request->getParam('in_storage');
        $detail_introduce = Yii::app()->request->getParam('detail_introduce');//商品详情
        $delivery_time = Yii::app()->request->getParam('delivery_time');
        $model_delivery_time = Yii::app()->request->getParam('model_delivery_time')?Yii::app()->request->getParam('model_delivery_time'):0;
        if(is_array($delivery_time))
        {
            $model_delivery_time='';
        }
        if(is_array($pn))
        {
            $pn='';
        }
        /*查找该型号下规格和规格属性*/
		if($type_id && $ss)
		{
			$property_arr['property'] = CProduct::search_property_bytypeid($type_id);
			$property_arr['attr'] = CProduct::search_attr_arr_bytypeid($type_id);
			
			echo json_encode($property_arr);die; 
		}
        if($goods_id)
        {
            $sort = CProduct::countModel($goods_id)['sort'];
        }
        if($_POST)
        {//echo '<pre>';
        	//var_dump($_POST);die;
        	$arr['sku_price'] = $_POST['sku_price'];
        	$arr['market_price'] = $_POST['market_price'];
        	$arr['stock_num'] = $_POST['stock_num'];
        	$arr['sales'] = $_POST['sales'];
        	$arr['pn'] = $_POST['pn'];
            $arr['delivery_time'] = $_POST['delivery_time'];
        	if($arr['sku_price']!=null)
        	{
        		foreach ($arr as $k=>$v)
        		{
        			foreach ($v as $kk=>$vv)
        			{
        				$m[$kk][$k]=$vv;
                        $n[$kk][$k]=$vv;
        			}
        		}
                foreach ($n as $nk=>$nv)
                {
                    if(!$nv['sku_price'])
                    {
                        unset($n[$nk]);
                    }
                }
                /*echo '<pre>';
                var_dump(reset($n));die*/;
                $price =reset($n)['market_price']?reset($n)['market_price']:0;
                $preferential_price=reset($n)['sku_price'];
                $stock =reset($n)['stock_num']?reset($n)['stock_num']:0;
                $sales_volume=reset($n)['sales']?reset($n)['sales']:0;
                $pn=reset($n)['pn'];
                $model_delivery_time=reset($n)['delivery_time']?reset($n)['delivery_time']:0;
        	}
        	
        	
            $img_url = Yii::app()->request->hostInfo.'/images/product/';
            $img_path = 'images/product';
            $path = CUploadimg::uploadFile($img_path);
            if(empty($path))
            {
                Yii::error("请选择图片",Yii::app()->request->urlReferrer,"1");die;
            }
            $cateid = CProduct::foo($cate);
            if($model_sku_json&&$model_attr_json)
            {
                //var_dump($model_sku_json);die;
                $modelId = CProduct::addgoodsModel($type_id,$goods_id,$title,$goods_list,$model_number,$zi_json,$model_sku_json,$model_attr_json,$stock,$price,$preferential_price,$is_publish,$is_preferential,$sales_volume,$pn,$in_storage,$associated,$after_sales,$cateid,$key='0',$is_one='0',$detail_introduce,$model_delivery_time);
            }elseif(!$model_sku_json&&$model_attr_json)
            {
                $modelId = CProduct::addgoodsModel($type_id,$goods_id,$title,$goods_list,$model_number,$zi_json,$model_sku_json='[]',$model_attr_json,$stock,$price,$preferential_price,$is_publish,$is_preferential,$sales_volume,$pn,$in_storage,$associated,$after_sales,$cateid,$key='0',$is_one='1',$detail_introduce,$model_delivery_time);
            }elseif(!$model_sku_json&&!$model_attr_json)
            {
                $modelId = CProduct::addgoodsModel($type_id,$goods_id,$title,$goods_list,$model_number,$zi_json,$model_sku_json='[]',$model_attr_json='[]',$stock,$price,$preferential_price,$is_publish,$is_preferential,$sales_volume,$pn,$in_storage,$associated,$after_sales,$cateid,$key='0',$is_one='1',$detail_introduce,$model_delivery_time);
            }elseif($model_sku_json&&!$model_attr_json)
            {
                $modelId = CProduct::addgoodsModel($type_id,$goods_id,$title,$goods_list,$model_number,$zi_json,$model_sku_json,$model_attr_json='[]',$stock,$price,$preferential_price,$is_publish,$is_preferential,$sales_volume,$pn,$in_storage,$associated,$after_sales,$cateid,$key='0',$is_one='1',$detail_introduce,$model_delivery_time);
            }
            if($modelId&&$model_sku_json&&$model_sku_json!='[]')
            {
                foreach($m as $combination=>$v1)
                {
                    //echo $modelId.'-'.$combination.'-'.$v1['sku_price'].'-'.$v1['market_price'].'-'.$v1['stock_num'].'-'.$v1['sales'].'-'.$v1['pn'];die;
                    if($v1['sku_price']*1 <= 0)
                    {
                        CProduct::add_sku($modelId,$combination,$v1['sku_price'],$v1['market_price'],$v1['stock_num'],$v1['sales'],$v1['pn'],$v1['delivery_time'],$is_delete=1);
                    }else{
                        CProduct::add_sku($modelId,$combination,$v1['sku_price'],$v1['market_price'],$v1['stock_num'],$v1['sales'],$v1['pn'],$v1['delivery_time'],$is_delete=0);
                    }
                }
            }elseif($modelId && (!$model_sku_json||$model_sku_json=='[]'))
            {
                //echo $preferential_price.'-'.$price;die;
                //echo $sales_volume;die;
                $combination='1:1';
                //echo $modelId.'-'.$combination.'-'.$preferential_price.'-'.$price.'-'.$stock.'-'.$sales_volume.'-'.$pn.'-'.$model_delivery_time;die;
                CProduct::add_sku($modelId,$combination,$preferential_price,$price,$stock,$sales_volume,$pn,$model_delivery_time);
            }
            foreach( $path as $k=>$v)
            {
                $sort=$k+1;
                CProduct::addImg($img_url.$v['name'],$modelId,$sort);
            }
            Yii::success("添加商品成功",Yii::app()->createUrl('product/addone'),"1");die;
        }
        $time_limit_arr = CProduct::search_time_limit_all();
        $type_arr = CProduct::search_type_all();
        $modelarr = CProduct::searchModelall();
        $this->controller->layout = false;
        $this->controller->render('addone',array(
            'modelarr'=>$modelarr,
            'goods_id'=>$goods_id,
            'type_arr'=>$type_arr,
            'time_limit_arr'=>$time_limit_arr,
        ));
    }
}