<?php
use GuzzleHttp\json_decode;
class EditpackageAction extends CAction{
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
        $meal_id_arr=array();
        $packageid = Yii::app()->request->getParam('id');
        $packagearr = CProduct::searchPackage_byid($packageid);
        $packagemodelarr = CProduct::searchPackagemodel_byid($packageid);
        //echo '<pre>';
        foreach($packagemodelarr as $key=>$value)
        {
        	$meal_id_arr[$key] = $value['id'];
            $meal_arr[$key] = CProduct::searchMealDetail_bySkuid($value['goods_sku_id'],$packageid);
        }
        $count = count($meal_arr);
        $package_id = Yii::app()->request->getParam('package_id');
        $arr['goodsmodel'] = Yii::app()->request->getParam('goodsmodel');
        $arr['goodssku'] = Yii::app()->request->getParam('goodssku');
        $arr['goodsnum'] = Yii::app()->request->getParam('goodsnum');
        $arr['meal_goods_id'] = Yii::app()->request->getParam('meal_goods_id');
        $arr['meal_id_arr'] = Yii::app()->request->getParam('meal_id_arr');
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
                 $mod[$key]['meal_goods_id'] = $arr['meal_goods_id'][$i];
                 $mod[$key]['price'] = $arr['price'][$i];
                 $mod[$key]['unit_price'] = $arr['unit_price'][$i];
                 $key++;
            }
        }
        $packagename = Yii::app()->request->getParam('packagename');
        $endtime = str_replace("/","-",Yii::app()->request->getParam('endtime'));
        if(empty($endtime))
        {
        	$endtime = date('Y-m-d H:i:s',time());
        }
        $introduce = Yii::app()->request->getParam('introduce');
        $status = Yii::app()->request->getParam('status');
        
        if($package_id)
        {
        	$meal_id_arr = json_decode($arr['meal_id_arr'],true);
        	/* var_dump($meal_id_arr);	
        	var_dump($arr['meal_goods_id']);die; */
        	$del_meal_arr = array_diff($meal_id_arr,$arr['meal_goods_id']);
            $package_price = array_sum($arr['unit_price']);
            $original_price = array_sum($arr['price']);
            $discount = round($package_price/$original_price, 2)*10;
            $tr = Yii::app()->db->beginTransaction();
            try {
            	 CProduct::editPackage($package_id,$packagename,$package_price,$original_price,$discount,$introduce,$endtime,$status);
            	 foreach($mod as $key=>$value)
            	 {
            	     $difference = $value['price']*1-$value['unit_price']*1;
            		 $result = CProduct::editPackage_goodsmodel($value['meal_goods_id'],$value['goodssku'],$value['goodsmodel'],$value['goodsnum'],$value['unit_price'],$difference,$endtime,$status);
            		 if($value['meal_goods_id'])
            		 {
            			$result = CProduct::editPackage_goodsmodel($value['meal_id'],$value['goodssku'],$value['goodsmodel'],$value['goodsnum'],$value['unit_price'],$difference,$endtime,$status);
            		
            		 }else{
            			$result = CProduct::addPackage_goodsmodel($package_id,$value['goodssku'],$value['goodsmodel'],$value['goodsnum'],$value['unit_price'],$difference,$endtime,$status);
            		 }
            	}
             	$tr->commit();
            } catch (Exception $e) {
            	$tr->rollBack();
            }
            if(!empty($del_meal_arr))
            {
                foreach($del_meal_arr as $v)
                {
                    CProduct::delMeal_byMealId($v);
                }
            }
            Yii::success("修改套餐成功",Yii::app()->createUrl('../product/package'),"3");die;
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
        $result = CProduct::getcategoryList();
        $this->controller->layout = false;
        $this->controller->render('editpackage',array('counts'=>$count,'result'=>$result,'packagearr'=>$packagearr,'meal_arr'=>$meal_arr,'meal_id_arr'=>$meal_id_arr));
    }
}