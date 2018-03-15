<?php
class AddAction extends CAction{
    public function run()
    {
        $action = $this->getId();
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
        }
        //echo Yii::app()->session['rolr_id'].'-';
        //echo Yii::app()->session['manager'];
        $type_id = Yii::app()->request->getParam('type_id');
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
        		echo '没有该商品';die;
        	}
        }
        $goods_model_id =Yii::app()->request->getParam('goods_model_id');
        if(!empty($goods_model_id))
        {
        	//echo json_encode($goods_model_id);die;
        	$goods_sku=CProduct::searchsku_bymodelid($goods_model_id);
        	echo json_encode($goods_sku);die;
        }
        $zi_json = Yii::app()->request->getParam('json');
        $model_sku_json = Yii::app()->request->getParam('model_sku_json');
        $model_attr_json = Yii::app()->request->getParam('model_attr_json');
        if($model_sku_json==''||$model_sku_json=='[]')
        {
            $model_sku_json='';
        }
        if($model_attr_json==''||$model_attr_json=='[]')
        {
            $model_attr_json='';
        }
        $title= Yii::app()->request->getParam('title');
        $goods_list = Yii::app()->request->getParam('goods_list');
        $model_number = Yii::app()->request->getParam('model_number');
        $stock = Yii::app()->request->getParam('stock')?Yii::app()->request->getParam('stock'):0;
        $price = Yii::app()->request->getParam('price')?Yii::app()->request->getParam('price'):0;
        $preferential_price = Yii::app()->request->getParam('preferential_price')?Yii::app()->request->getParam('preferential_price'):0;
        $associated = Yii::app()->request->getParam('associated');
        $after_sales = Yii::app()->request->getParam('after_sales');
        $pn = Yii::app()->request->getParam('pn');
        if(is_array($pn))
        {
        	$pn='';
        }
        $sales_volume = Yii::app()->request->getParam('sales_volume');
		if($sales_volume=='')
        {
        	$sales_volume='0';
        }
        $is_price_show = Yii::app()->request->getParam('is_price_show')?Yii::app()->request->getParam('is_price_show'):0;
        $keywords = Yii::app()->request->getParam('keywords');
        $is_publish = Yii::app()->request->getParam('is_publish');
        $is_preferential = Yii::app()->request->getParam('is_preferential');
        $in_storage = Yii::app()->request->getParam('in_storage');
        $name = Yii::app()->request->getParam('name');
        $cate = Yii::app()->request->getParam('cate');
        $brand = Yii::app()->request->getParam('brand');
        $business_men = Yii::app()->request->getParam('business_men');
        $create_time = Yii::app()->request->getParam('create_time')?str_replace("/","-",Yii::app()->request->getParam('create_time')):date('Y-m-d H:i:s',time());
        $manual = Yii::app()->request->getParam('manual');//使用手册
        $function = Yii::app()->request->getParam('function');//相关知识
        $detail_introduce = Yii::app()->request->getParam('detail_introduce');//商品详情
        $model_delivery_time = Yii::app()->request->getParam('model_delivery_time')?Yii::app()->request->getParam('model_delivery_time'):0;
        $is_comments = Yii::app()->request->getParam('is_comments');

        /*查找该型号下规格和规格属性*/
        /*if($type_id)
        {
        	$property_arr = CProduct::search_property_bytypeid($type_id);
        	echo json_encode($property_arr);die;
        }*/
        if($name && $cate && $brand)
        {
        	$arra['sku_price'] = $_POST['sku_price'];
        	$arra['market_price'] = $_POST['market_price'];
        	$arra['stock_num'] = $_POST['stock_num'];
        	$arra['sales'] = $_POST['sales'];
        	$arra['pn'] = $_POST['pn'];
            $arra['delivery_time'] = $_POST['delivery_time'];
        	if($arra['sku_price']&&$arra['pn'])
        	{
        		foreach ($arra as $k=>$v)
        		{
        			foreach ($v as $kk=>$vv)
        			{
        			    $m[$kk][$k]=$vv;
                        $n[$kk][$k]=$vv;
        			}
        		}
                //$stock,$price,$preferential_price,$sales_volume,$model_delivery_time
                //echo '<pre>';
                //var_dump($model_sku_json);die;
                foreach ($n as $nk=>$nv)
                {
                    if(!$nv['sku_price'])
                    {
                        unset($n[$nk]);
                    }
                }
                /*echo '<pre>';
                var_dump(reset($n));die*/;
                $price =reset($n)['market_price']?reset($n)['market_price']:'0';
                $preferential_price=reset($n)['sku_price']?reset($n)['sku_price']:'0';
                $stock =reset($n)['stock_num']?reset($n)['stock_num']:'0';
                $sales_volume=reset($n)['sales']?reset($n)['sales']:'0';
                $pn=reset($n)['pn'];
                $model_delivery_time=reset($n)['delivery_time']?reset($n)['delivery_time']:'0';
        	}
            /*echo '<pre>';
            var_dump(reset($n));*/
            //类型表插入商品类型
            /*$transaction= Yii::app()->db->beginTransaction();//创建事务
            try{  */
            $video_url = Yii::app()->request->hostInfo.'/video/product/';
            $video_path = 'images/product';

            $img_url = Yii::app()->request->hostInfo.'/images/product/';
            $img_path = 'images/product';
            $file_url = Yii::app()->request->hostInfo.'/uploadsfile/';
            $path = CUploadimg::uploadFiles($img_path);
            $goods_pdf = CUploadimg::uploadDown();

            if(empty($path))
            {
                Yii::error("请选择图片",Yii::app()->request->urlReferrer,"3");die;
            }
            $goodsId = CProduct::addGoods($name,$cate,$business_men,$brand,$create_time,$manual,$function,$is_comments);
            if($goodsId)
            {
            	if($goods_pdf)
            	{
            		foreach($goods_pdf as $key=>$value)
            		{
            			CProduct::addPdf($goodsId,$value['ch_name'],$file_url.$value['name'],$key);
            		}
            	}
            	//echo $model_sku_json.'-'.$model_attr_json;die;
                //类型表插入商品类型
                    $cateid = CProduct::foo($cate);
                    if($model_sku_json&&$model_attr_json)
                    {
                    	//var_dump($model_sku_json);die;
                    	$modelId = CProduct::addgoodsModel($type_id,$goodsId,$title,$goods_list,$model_number,$zi_json,$model_sku_json,$model_attr_json,$stock,$price,$preferential_price,$is_publish,$is_preferential,$sales_volume,$pn,$in_storage,$associated,$after_sales,$cateid,$key='0',$is_one='0',$detail_introduce,$model_delivery_time,$is_price_show,$keywords);
                    }elseif(!$model_sku_json&&$model_attr_json)
					{
						$modelId = CProduct::addgoodsModel($type_id,$goodsId,$title,$goods_list,$model_number,$zi_json,$model_sku_json='[]',$model_attr_json,$stock,$price,$preferential_price,$is_publish,$is_preferential,$sales_volume,$pn,$in_storage,$associated,$after_sales,$cateid,$key='0',$is_one='1',$detail_introduce,$model_delivery_time,$is_price_show,$keywords);
					}elseif(!$model_sku_json&&!$model_attr_json)
                    {
                        $modelId = CProduct::addgoodsModel($type_id,$goodsId,$title,$goods_list,$model_number,$zi_json,$model_sku_json='[]',$model_attr_json='[]',$stock,$price,$preferential_price,$is_publish,$is_preferential,$sales_volume,$pn,$in_storage,$associated,$after_sales,$cateid,$key='0',$is_one='1',$detail_introduce,$model_delivery_time,$is_price_show,$keywords);
                    }elseif($model_sku_json&&!$model_attr_json)
                    {
                        $modelId = CProduct::addgoodsModel($type_id,$goodsId,$title,$goods_list,$model_number,$zi_json,$model_sku_json,$model_attr_json='[]',$stock,$price,$preferential_price,$is_publish,$is_preferential,$sales_volume,$pn,$in_storage,$associated,$after_sales,$cateid,$key='0',$is_one='1',$detail_introduce,$model_delivery_time,$is_price_show,$keywords);
                    }

					if($modelId&&$model_sku_json&&$model_sku_json!='[]')
					{
						foreach($m as $combination=>$v1)
						{
                            if($v1['delivery_time']==0)
                            {
                                $v1['delivery_time']=1;
                            }
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
                        if($model_delivery_time==0)
                        {
                            $model_delivery_time=1;
                        }
                        //echo $preferential_price.'-'.$price;die;
						//echo $sales_volume;die;
						$combination='1:1';
						//echo $modelId.'-'.$combination.'-'.$preferential_price.'-'.$price.'-'.$stock.'-'.$sales_volume.'-'.$pn.'-'.$model_delivery_time;die;
						CProduct::add_sku($modelId,$combination,$preferential_price,$price,$stock,$sales_volume,$pn,$model_delivery_time);
					}
					$imgae_res = CProduct::addimage($modelId,$images_class_id=1);
					if($imgae_res)
					{
						foreach( $path[0] as $k=>$v)
						{
							$sort=$k+1;
							CProduct::addImg($img_url.$v['name'],$modelId,$sort);
						}
					}
                $goods_model_name = CProduct::searchModels_byid($modelId)['model_number'];

                $con = "<div><a href='http://ydadmin.rdbuy.com.cn'>点击链接对商品<span style='color: red'>$goods_model_name</span>进行审核</a></div><div>上传人：$auth_arr[manager]</div>";
                $shen_arr = CManage::searchManager_bySign($sign=1);
                foreach ($shen_arr as $sk=>$sv)
                {
                    $flag = CEmail::sendMail($sv['email'],'商品审核',$con);
                }
                if($flag){

                    Yii::success("添加成功",Yii::app()->createUrl('../product/list'),"1");die;
                }else{

                    Yii::error("添加失败",Yii::app()->createUrl('../product/list'),"1");die;
                }

            }
            /*        $transaction->commit();//提交事务会真正的执行数据库操作
            }catch (Exception $e) {
                    $transaction->rollback();//如果操作失败, 数据回滚

            }*/
        }

        $time_limit_arr = CProduct::search_time_limit_all();
        $type_arr = CProduct::search_type_all();
        $modelarr = CProduct::searchModelall();
        $catearr = CProduct::searchCateall();
        $brandarr = CProduct::searchBrandall();
        $this->controller->layout = false;
        $this->controller->render('add',array(
            'catearr'=>$catearr,
            'brandarr'=>$brandarr,
            'modelarr'=>$modelarr,
            'type_arr'=>$type_arr,
            'time_limit_arr'=>$time_limit_arr,
            'auth_arr'=>$auth_arr,
        ));
    }
}