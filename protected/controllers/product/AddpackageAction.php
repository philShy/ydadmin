<?php
class AddpackageAction extends CAction{
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
        $arr['goodsmodel'] = Yii::app()->request->getParam('goodsmodel');
        $arr['goodssku'] = Yii::app()->request->getParam('goodssku');
        $arr['goodsnum'] = Yii::app()->request->getParam('goodsnum');
        $arr['price'] = Yii::app()->request->getParam('price');//销售价
        $arr['unit_price'] = Yii::app()->request->getParam('unit_price');//套餐价
        $mod=array();
        if (!empty($arr['goodssku']))
        {
            $length = count($arr['goodssku']);
            $key=0;
            for ($i = 0; $i < $length; $i++)
            {
            	 $mod[$key]['goodsmodel'] = $arr['goodsmodel'][$i];
                 $mod[$key]['goodssku'] = $arr['goodssku'][$i];
                 $mod[$key]['goodsnum'] = $arr['goodsnum'][$i];
                 $mod[$key]['price'] = $arr['price'][$i];
                 $mod[$key]['unit_price'] = $arr['unit_price'][$i];
                 $key++;
            }
        }
		
        $packagename = Yii::app()->request->getParam('packagename');
        $endtime = str_replace("/","-",Yii::app()->request->getParam('endtime'));
        $introduce = Yii::app()->request->getParam('introduce');
        $status = Yii::app()->request->getParam('status');
        if(empty($endtime))
        {
        	$endtime = date('Y-m-d H:i:s',time());
        }

        if($packagename)
        {
        	$original_price = array_sum($arr['price']);
        	$package_price = array_sum($arr['unit_price']);
        	if($package_price == 0)
        	{
        		$discount='0';
        	}else{
        		$discount = round($package_price/$original_price, 2)*10;
        	}

            $tr = Yii::app()->db->beginTransaction();
            try {
                $packageid = CProduct::addPackage($packagename,$package_price,$original_price,$discount,$introduce,$endtime,$status);

                foreach($mod as $key=>$value)
                {
                	if($value['goodsnum']=='')
                	{
                		$value['goodsnum']='0';
                	}
                	if($value['unit_price']=='')
                	{
                		$value['unit_price']='0';
                	}
                	$difference = $value['price']*1-$value['unit_price']*1;
                    $result = CProduct::addPackage_goodsmodel($packageid,$value['goodssku'],$value['goodsmodel'],$value['goodsnum'],$value['unit_price'],$difference,$endtime,$status);
                }

                $tr->commit();
            } catch (Exception $e) {
                $tr->rollBack();
            } 
            if($result)
            {
                Yii::success("创建套餐成功",Yii::app()->createUrl('../product/package'),"3");die;
            }
        }
        $catid = Yii::app()->request->getParam('catid');
        if(Yii::app()->request->isAjaxRequest && $catid)
        {
            $goodsarr = CProduct::searchGoods($catid);
            echo json_encode($goodsarr);die;
        }
        $goodsid = Yii::app()->request->getParam('goodsid');
        if(Yii::app()->request->isAjaxRequest && $goodsid)
        {
            $modelarr = CProduct::searchModels($goodsid);
            echo json_encode($modelarr);die;
        }
        $modelid = Yii::app()->request->getParam('modelid');
        if(Yii::app()->request->isAjaxRequest && $modelid)
        {
            $skuarr = CProduct::searchskus_byid($modelid);
            echo json_encode($skuarr);die;
        }
        $skuid = Yii::app()->request->getParam('skuid');
        if(Yii::app()->request->isAjaxRequest && $skuid)
        {
        	$skuone = CProduct::searchsku_byid($skuid);
        	//echo json_encode($skuone);die;
        	echo $skuone['price1'];die;
        }
        $result = CProduct::getcategoryList();
        $this->controller->layout = false;
        $this->controller->render('addpackage',array('result'=>$result));
    }
}










