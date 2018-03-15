<?php
class AddmodelAction extends CAction{
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
        $catid = Yii::app()->request->getParam('catid');
        if($catid)
        {
        	$goods_arr = CProduct::searchGoods($catid);
        	echo json_encode($goods_arr);die;
        }
        $goods_id = Yii::app()->request->getParam('goods_id');
        $arr['title'] = Yii::app()->request->getParam('title');
        $arr['goods_list'] = Yii::app()->request->getParam('goods_list');
        $arr['model_number'] = Yii::app()->request->getParam('model_number');
        $arr['stock'] = Yii::app()->request->getParam('stock');
        $arr['price'] = Yii::app()->request->getParam('price');
        $arr['preferential_price'] = Yii::app()->request->getParam('preferential_price');
        $arr['jssn'] = Yii::app()->request->getParam('jssn');
        $arr['associated'] = Yii::app()->request->getParam('associated');
        $arr['after_sales'] = Yii::app()->request->getParam('after_sales');
        $arr['create_time'] = Yii::app()->request->getParam('create_time')?str_replace("/","-",Yii::app()->request->getParam('create_time')):date('Y-m-d H:i:s',time());
        $arr['weights'] = Yii::app()->request->getParam('weights');
        $arr['sizes'] = Yii::app()->request->getParam('sizes');
        $arr['colors'] = Yii::app()->request->getParam('colors');
        $arr['is_publish'] = Yii::app()->request->getParam('is_publish');
        $arr['is_preferential'] = Yii::app()->request->getParam('is_preferential');
        $arr['in_storage'] = Yii::app()->request->getParam('is_storage');
        $mod = array();
        //交换数组键值
        if (!empty($arr['model_number']))
        {
        	$length = count($arr['model_number']);
        	$key=0;
        	for ($i = 0; $i < $length; $i++)
        	{
	        	if (!empty($arr['model_number'][$i])&&!empty($arr['title'][$i]))
	        	{
	       
	        		$mod[$key]['title'] = $arr['title'][$i];
	        		$mod[$key]['goods_list'] = $arr['goods_list'][$i];
	        		$mod[$key]['model_number'] = $arr['model_number'][$i];
	        		$mod[$key]['stock'] = $arr['stock'][$i];
	        		$mod[$key]['price'] = $arr['price'][$i];
	        		$mod[$key]['preferential_price'] = $arr['preferential_price'][$i];
	        		$mod[$key]['jssn'] = $arr['jssn'][$i];
	        		$mod[$key]['associated'] = $arr['associated'][$i];
	        		$mod[$key]['after_sales'] = $arr['after_sales'][$i];
	        		$mod[$key]['weights'] = $arr['weights'][$i];
	        		$mod[$key]['sizes'] = $arr['sizes'][$i];
	        		$mod[$key]['colors'] = $arr['colors'][$i];
	        		$mod[$key]['is_publish'] = $arr['is_publish'][$i];
	        		$mod[$key]['is_preferential'] = $arr['is_preferential'][$i];
	        		$mod[$key]['in_storage'] = $arr['in_storage'][$i];

	        		$key++;
	        	}
        	}
      
        }
        if($goods_id)
        {
        	$ee=1;
        	$video_url = Yii::app()->request->hostInfo.'/video/product/';
        	$video_path = 'video/product';
        	$img_url = Yii::app()->request->hostInfo.'/images/product/';
        	$img_path = 'images/product';
        	$file_url = Yii::app()->request->hostInfo.'/images/uploadsfile/';
        	$path = CUploadimg::uploadFiles($img_path);
        	/* if(empty($path))
        	{
        		Yii::error("请选择图片",Yii::app()->request->urlReferrer,"3");die;
        	} */
        	$goods_pdf = CUploadimg::uploadDown();
        	foreach($mod as $key=>$value)
        	{
        	
        		$cateid = CProduct::foo($cate);
        		$json_arr = explode('`',$value['jssn']);
        		var_dump($json_arr);
        		$modelId = CProduct::addgoodsModel($goods_id,$value['title'],$value['goods_list'],$value['model_number'],$value['stock'],$value['price'],$value['preferential_price'],$value['weights'],$value['sizes'],$value['colors'],$value['is_publish'],$value['is_preferential'],$value['in_storage'],$value['associated'],$value['after_sales'],$cateid,$key);
        		 
        		if($modelId)
        		{
        			if(!empty($json_arr))
        			{
        				foreach($json_arr as $k1=>$v1)
        				{
        					$td_one = json_decode($v1,true)['type'];
        					$td_two = json_encode(json_decode($v1,true)['prop']);
        					/* echo 'td_one'.'------'.$td_one;
        					echo 'td_two'.'------'.$td_two;
        					echo '<br>'; */
        					if($v1)
        					{
        						$res1 = CProduct::addSpecification_packing($modelId,$td_one,$td_two);
        					}
        				}
        			}
        			if($path)
        			{
        				foreach( $path[$ee] as $k=>$v)
        				{
        					$sort=$k+1;
        					$res = CProduct::addImg($img_url.$v['name'],$modelId,$sort);
        				}
        			}
        			$ee++;
        		}
        	}
        }

        $modelarr = CProduct::searchModelall();
        $catearr = CProduct::searchCateall();
        $brandarr = CProduct::searchBrandall();
        $this->controller->layout = false;
        $this->controller->render('addmodel',array('catearr'=>$catearr,'brandarr'=>$brandarr,'modelarr'=>$modelarr));
    }
}