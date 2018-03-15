<?php

class EditAction extends CAction{
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
        if($auth_arr['publish_goods_sign'] == 0){
            $wait_audit = 0;
        }elseif($auth_arr['publish_goods_sign'] == 1)
        {
            $wait_audit = 1;
        }elseif($auth_arr['publish_goods_sign'] == 2){
            $wait_audit = 2;
        }else{
            $wait_audit = 0;
        }
        $type_id = Yii::app()->request->getParam('type_id');
        $zi_json = Yii::app()->request->getParam('json');
        $model_sku_json = Yii::app()->request->getParam('model_sku_json');
        $model_attr_json = Yii::app()->request->getParam('model_attr_json');
        if($model_sku_json==''||$model_sku_json=='[]')
        {
            $model_sku_json='[]';
        }
        if($model_attr_json==''||$model_attr_json=='[]')
        {
            $model_attr_json='[]';
        }
        $id = Yii::app()->request->getParam('id');
        $n_reason = Yii::app()->request->getParam('n_reason');
        $is_through = Yii::app()->request->getParam('is_through');
        if($n_reason)
        {
            if($n_reason == '未通过原因 ')
            {
                $n_reason='请认真核对商品信息';
            }
        }
        $mark = Yii::app()->request->getParam('mark');
        $delmodeid = Yii::app()->request->getParam('delmodeid');
        $goodsmodelarr = CProduct::searchGoodsmodelbyid($id);
        $goodsmodelid = Yii::app()->request->getParam('goodsmodelid');
        $name = Yii::app()->request->getParam('name');
        $cate = Yii::app()->request->getParam('cate');
        $cateid = CProduct::foo($cate);
        $brand = Yii::app()->request->getParam('brand');
        $business_men = Yii::app()->request->getParam('business_men');
        //$create_time = Yii::app()->request->getParam('create_time');
        $create_time = date("Y-m-d ", time());
        $title = Yii::app()->request->getParam('title');
        $goods_list = Yii::app()->request->getParam('goods_list');
        $model_number = Yii::app()->request->getParam('model_number');
        $stock = Yii::app()->request->getParam('stock')?Yii::app()->request->getParam('stock'):'0';
        $price = Yii::app()->request->getParam('price')?$price = Yii::app()->request->getParam('price'):'0';
        $preferential_price = Yii::app()->request->getParam('preferential_price')?Yii::app()->request->getParam('preferential_price'):'0';

        $sales_volume = Yii::app()->request->getParam('sales_volume')?Yii::app()->request->getParam('sales_volume'):'0';
        $pn = Yii::app()->request->getParam('pn')?Yii::app()->request->getParam('pn'):'0';
        if(is_array($pn)){
        	$pn='';
        }
        $is_price_show = Yii::app()->request->getParam('is_price_show');
        $keywords = Yii::app()->request->getParam('keywords');
        $is_publish = Yii::app()->request->getParam('is_publish')?Yii::app()->request->getParam('is_publish'):0;
        $is_preferential = Yii::app()->request->getParam('is_preferential');
        $in_storage = Yii::app()->request->getParam('in_storage');
        $is_comments = Yii::app()->request->getParam('is_comments');
        $manual = Yii::app()->request->getParam('manual');
        $detail_introduce = Yii::app()->request->getParam('detail_introduce');
        $function = Yii::app()->request->getParam('function');//相关知识
        $model_id = Yii::app()->request->getParam('model_id');
        $associated = Yii::app()->request->getParam('associated');
        $after_sales = Yii::app()->request->getParam('after_sales');
        $model_delivery_time = Yii::app()->request->getParam('model_delivery_time')?Yii::app()->request->getParam('model_delivery_time'):'0';
        if($delmodeid)
        {
            $del = CProduct::delSpecification_packing($delmodeid);
            echo $del;die;
        }
        if($goodsmodelarr['id']){
            $specification = CProduct::searchSpecification_packing($goodsmodelarr['id']);
            foreach($specification as $k=>$v)
            {
                $aa = json_decode($v['td_two'],true);
                $specification[$k]['prop'] = $aa;
            }
        }
        if($mark)
        {
            $imgs_url = CImages::searchimgs_Bymodelid($model_id);
            $result_pic = CImages::delimages_Bymodelid($model_id);//删除商品图片
            $result = CProduct::delModelbyid($model_id);//删除商品类型*/
            if($result || $result_pic)
            {
                if($imgs_url)
                {
                    foreach($imgs_url as $img)
                    {
                        if (file_exists("images/product/" .$img['images_url'])) {
                            unlink("images/product/" .$img['images_url']);
                        }
                        if (file_exists("images/product_50/50" .$img['images_url'])) {
                            unlink("images/product_50/50" .$img['images_url']);
                        }
                    }
                }
                $data = array('message'=>'删除成功！','code'=>1);
                echo json_encode($data);die;
            }
        }
        if($goodsmodelid)
        {

        	$sarr['sku_price'] = $_POST['sku_price'];
        	$sarr['market_price'] = $_POST['market_price'];
        	$sarr['stock_num'] = $_POST['stock_num'];
        	$sarr['sales'] = $_POST['sales'];
        	$sarr['sku_pn'] = $_POST['sku_pn'];
            $sarr['delivery_time'] = $_POST['delivery_time'];

        	if($sarr['sku_price']!=null)
        	{
        		foreach ($sarr as $sk=>$sv)
        		{
        			foreach ($sv as $skk=>$svv)
        			{
        				$m[$skk][$sk]=$svv;
                        $mm[$skk][$sk]=$svv;
                        $n[$skk][$sk]=$svv;
        			}
        		}
                foreach ($n as $nk=>$nv)
                {
                    if(!$nv['sku_price'])
                    {
                        unset($n[$nk]);
                    }
                }
                $price =reset($n)['market_price']?reset($n)['market_price']:'0';
                $preferential_price=reset($n)['sku_price']?reset($n)['sku_price']:'1';
                $stock =reset($n)['stock_num']?reset($n)['stock_num']:'0';
                $sales_volume=reset($n)['sales']?reset($n)['sales']:'0';
                $pn=reset($n)['pn']?reset($n)['pn']:'0';
                $model_delivery_time=reset($n)['delivery_time']?reset($n)['delivery_time']:'1';
        	}
        	/*echo '<pre>';
            var_dump($sarr);die;*/
        	//echo $preferential_price;die;
            $img_url = Yii::app()->request->hostInfo.'/images/product/';
            $file_url = Yii::app()->request->hostInfo.'/uploadsfile/';
            if($_FILES['proImg'])
            {
                $img_path = 'images/product';
                $path = CUploadimg::uploadFile($img_path);
            }
            if($_FILES['down'])
            {
                $goods_pdf = CUploadimg::uploadDown();
            }
            $goodsid = CProduct::searchGoodsbyid($goodsmodelid)['goods_id'];
            if($path)
            {
                $imgid =  CProduct::searchImg($goodsmodelid);
                if(!empty($imgid))
                {
                    foreach($imgid as $k=>$v)
                    {
                        $arr[] = $v['sort'];
                    };
                    $max_id = array_search(max($arr), $arr);
                    foreach($path as $key=>$value)
                    {
                        $sort = $key+$arr[$max_id]+1;
                        CProduct::addImg($img_url.$value['name'],$goodsmodelid,$sort);
                    }
                }else
                {
                    foreach($path as $key=>$value)
                    {
                        $sort = $key+1;
                        CProduct::addImg($img_url.$value['name'],$goodsmodelid,$sort);
                    }
                }
            }

            if($goods_pdf)
            {
                $pdfid =  CProduct::searchPdf($goodsid);
                foreach($pdfid as $k=>$v){
                    $arr[] = $v['sort'];
                };
                $max_id = array_search(max($arr),$arr);
                foreach($goods_pdf as $key=>$value)
                {
                    $sort = $key+$arr[$max_id]+1;
                    CProduct::addPdf($goodsid,$value['ch_name'],$file_url.$value['name'],$sort);
                }
            }
            $w2 = CProduct::editGoodsbyid($goodsid,$name,$cate,$brand,$business_men,$create_time,$manual,$create_time, $is_comments,$function);
            if($model_sku_json!='[]')
            {
            	$w3 = CProduct::editGoodsmodelbyid($type_id,$goodsmodelid, $title,$goods_list,$model_number,$zi_json,$model_sku_json,$model_attr_json,$stock,$price,$preferential_price,$associated,$sales_volume,$after_sales,$is_publish,$is_preferential,$create_time,$cateid,$in_storage,$pn,$is_one='0',$detail_introduce,$model_delivery_time,$wait_audit,$is_price_show,$keywords);
            }else{
            	$w3 = CProduct::editGoodsmodelbyid($type_id,$goodsmodelid, $title,$goods_list,$model_number,$zi_json,$model_sku_json,$model_attr_json,$stock,$price,$preferential_price,$associated,$sales_volume,$after_sales,$is_publish,$is_preferential,$create_time,$cateid,$in_storage,$pn,$is_one='1',$detail_introduce,$model_delivery_time,$wait_audit,$is_price_show,$keywords);
            }
			if($w3 && $model_sku_json!='[]')
			{
				//重新添加商品sku,sku_group
				$skuid_arr = CProduct::search_skuid_bymodelid($goodsmodelid);

                if($skuid_arr){
                    foreach ($sarr['sku_price'] as $k=>$v)
                    {
                        $newkarr[] = $k;
                    }
                    foreach($skuid_arr as $skuk=>$skuv)
                    {
                        $oldkarr[] = $skuv['combination'];
                    }
                    ////////////////////////////////
                    $addSkuArr = array_diff($newkarr,$oldkarr);
                    $reduceSkuArr = array_diff($oldkarr,$newkarr);
                    /*var_dump($addSkuArr);
                    echo '<hr>';
                    var_dump($addSkuArr);die;*/
                    if(!empty($addSkuArr))
                    {
                        foreach ($m as $mk=>$nv)
                        {
                            if(!in_array($mk,$addSkuArr))
                            {
                                unset($m[$mk]);
                            }
                        }

                        foreach ($m as $combination=>$v1)
                        {
                            CProduct::add_sku($goodsmodelid,$combination,$v1['sku_price'],$v1['market_price'],$v1['stock_num'],$v1['sales'],$v1['sku_pn'],$v1['delivery_time']);
                        }
                        //添加
                    }
                    if(!empty($reduceSkuArr))
                    {
                        //查找删除sku,group
                        foreach ($reduceSkuArr as $k=>$v)
                        {
                            CProduct::searchSkuId_byCombination($v,$goodsmodelid);
                        }
                    }
                    foreach ($mm as $k=>$v)
                    {
                        //更新
                        $ee[] = CProduct::saveSku($goodsmodelid,$k,$v);
                    }

                }else{
                    foreach($m as $combination=>$v1)
                    {
                        CProduct::add_sku($goodsmodelid,$combination,$v1['sku_price'],$v1['market_price'],$v1['stock_num'],$v1['sales'],$v1['sku_pn'],$v1['delivery_time']);
                    }
                }
                $flag = CProduct::shenhe($auth_arr['publish_goods_sign'],$is_through,$goodsmodelarr['name'],$n_reason,$auth_arr['manager']);
                if($flag)
                {
                    Yii::success("修改成功",Yii::app()->createUrl('../product/list'),"1");die;
                }else{
                    Yii::error("修改失败",Yii::app()->createUrl('../product/list'),"1");die;
                }

			}elseif($w3 && $model_sku_json='[]')
            {
                $skuid_arr = CProduct::search_skuid_bymodelid($goodsmodelid);
                if($skuid_arr &&$skuid_arr[0]['combination']!='1:1'){
                    foreach($skuid_arr as $skuk=>$skuv){
                        $skuid_arr[$skuk] = $skuv['id'];
                    }
                    $skuid_str = implode(',', $skuid_arr);
                    $sku_group_arr = CProduct::search_skugroupid_bymodelid($skuid_str);

                    foreach($sku_group_arr as $sku_group_k=>$sku_group_v)
                    {
                        //var_dump($sku_group_v['id']);
                        $del_sku_group_res = CProduct::del_sku_group_byskuid($sku_group_v['id']);
                    }
                    //var_dump($del_sku_group_res);die;
                    $del_sku_res = CProduct::del_sku_bymodelid($goodsmodelid);
                    if($del_sku_res)
                    {
                        foreach($m as $combination=>$v1)
                        {
                            CProduct::add_sku($goodsmodelid,$combination,$v1['sku_price'],$v1['market_price'],$v1['stock_num'],$v1['sales'],$v1['sku_pn'],$v1['delivery_time']);
                        }
                    }
                }elseif($skuid_arr &&$skuid_arr[0]['combination']=='1:1'){
                    CProduct::saveSku1($skuid_arr[0]['id'],$preferential_price,$price,$stock,$sales_volume,$pn,$model_delivery_time);
                    $flag = CProduct::shenhe($auth_arr['publish_goods_sign'],$is_through,$goodsmodelarr['name'],$n_reason,$auth_arr['manager']);
                    if($flag)
                    {
                        Yii::success("修改成功",Yii::app()->createUrl('../product/list'),"1");die;
                    }else{
                        Yii::error("修改失败",Yii::app()->createUrl('../product/list'),"1");die;
                    }

                }else{
                    $combination='1:1';
                    CProduct::add_sku($goodsmodelid,$combination,$preferential_price,$price,$stock,$sales_volume,$pn,$model_delivery_time);
                    $flag = CProduct::shenhe($auth_arr['publish_goods_sign'],$is_through,$goodsmodelarr['name'],$n_reason,$auth_arr['manager']);
                    if($flag)
                    {
                        Yii::success("修改成功",Yii::app()->createUrl('../product/list'),"1");die;
                    }else{
                        Yii::error("修改失败",Yii::app()->createUrl('../product/list'),"1");die;
                    }
                }
            }
        }
       //echo '<pre>';
        //var_dump(json_decode($goodsmodelarr['model_attr_json'],true));
        //var_dump(CProduct::choose_prop_v(1,2));die;
        $attr_old = json_decode($goodsmodelarr['model_attr_json'],true);
        foreach($attr_old as $k=>$v)
        {
            //var_dump($v['id']);
            $attr_arr = CProduct::search_attr_val_byattrid($v['id']);
            if(empty($attr_arr)){
                unset($attr_old[$k]);
            }
            //var_dump($attr_arr);
        }//die;
        $new_attr_arr = json_encode($attr_old);
        unset($goodsmodelarr['model_attr_json']);
        $goodsmodelarr['model_attr_json'] = $new_attr_arr;
        //var_dump($goodsmodelarr);
        //var_dump($attr_old);
        //die;
        $time_limit_arr = CProduct::search_time_limit_all();
        $type_arr = CProduct::search_type_all();
        $modelarr = CProduct::searchModelall();
        /*echo '<pre>';
        var_dump($modelarr);*/
        $catearr = CProduct::searchCateall();
        $brandarr = CProduct::searchBrandall();
        $type['name'] = CProduct::search_type_byid($goodsmodelarr['type_id']);
        $this->controller->layout = false;
        $this->controller->render('edit',array('catearr'=>$catearr,
        		'brandarr'=>$brandarr,
        		'goodsmodelarr'=>$goodsmodelarr,
        		'modelarr'=>$modelarr,
        		'specification'=>$specification,
        		'type_arr'=>$type_arr,
        		'type_id'=>$goodsmodelarr['type_id'],
        		'type_name'=>$type['name'],
        		'model_sku_json'=>json_decode($goodsmodelarr['model_sku_json'],true),
        		'model_attr_json'=>json_decode($goodsmodelarr['model_attr_json'],true),
        		'kkkk'=>json_encode(CProduct::choose_prop_v($id)),
        		'rrrr'=>json_encode(CProduct::choose_attr_v($id)),
        		'info'=>json_encode(CProduct::choose_prop_info($id)),
                'auth_arr'=>$auth_arr,
                'time_limit_arr'=>$time_limit_arr,
        ));
    }
}