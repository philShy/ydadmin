<?php
use GuzzleHttp\json_decode;
class OrderformAction1 extends CAction{
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
        $page = Yii::app()->request->getParam('page');
        if(empty($page))
        {
        	$page = 1;
        }
        $size=10;
        $sign = Yii::app()->request->getParam('sign');
        $search_order = Yii::app()->request->getParam('search_order');
        $shipper = Yii::app()->request->getParam('shipper');
        $boxNum = Yii::app()->request->getParam('boxNum');
        $isReceipt = Yii::app()->request->getParam('isReceipt');
        $remark = Yii::app()->request->getParam('remark');
        $consignee = Yii::app()->request->getParam('consignee');
        if(empty($consignee)){$consignee = '无收货单位';}
        $start_time = Yii::app()->request->getParam('starttime');
        $end_time = Yii::app()->request->getParam('endtime');
        $where = Yii::app()->request->getParam('where');
        $order_id = Yii::app()->request->getParam('order_id');
        $is_delete = Yii::app()->request->getParam('is_delete');
        $logistics_num = Yii::app()->request->getParam('logistics_num');
        $logistics_company = Yii::app()->request->getParam('send_method');
        $type = Yii::app()->request->getParam('type');
        $order_fid = Yii::app()->request->getParam('order_fid');
        $is_send = Yii::app()->request->getParam('is_send');

        /*根据条件查找订单*/
    	if($where)
        {
        	$where = base64_decode($where);
        	$order_arr = CTransaction::searchAllorder($page,$size,$where);
        	$count = CTransaction::countorder($where);
        }else if($search_order)
        {
        	$where = "id=$search_order and";
        	$order_arr = CTransaction::searchAllorder($page,$size,$where);
        	
        }else if($start_time && $end_time)
        {	
        	$where = "'$start_time'<create_time and create_time<'$end_time' and";
        	$order_arr = CTransaction::searchAllorder($page,$size,$where);
        	$count = CTransaction::countorder($where);
        }
        else{
        	
        	$order_arr = CTransaction::searchAllorder1($page,$size,$where='status=1 and');
        	$count = CTransaction::countorder($where='status=1 and');
        	//var_dump($count);
        }
        
    	foreach($order_arr as $key=>$value)
        {
        	$order_detail_arr = CTransaction::search_order_sub_id($value['id'],$status='');
        	foreach ($order_detail_arr as $k=>$v)
        	{
        		$sub_id = $v['order_sub_id'];
				unset($order_detail_arr[$k]);
        		$order_detail_arr[$sub_id] = CTransaction::search_sub_one($v['order_sub_id']); 
        		$order_detail_arr[$sub_id]['logistics_type'] = $v['logistics_type'];
        		$order_detail_arr[$sub_id]['logistics_num'] = $v['logistics_num'];
        		$order_detail_arr[$sub_id]['send_time'] = $v['send_time'];
        		$order_detail_arr[$sub_id]['is_advance_order'] = $v['is_advance_order'];
        		$order_detail_arr[$sub_id]['sub_status'] = $v['sub_status'];
        	} 
        	$order_arr[$key]['goods_detail'] = $order_detail_arr;
            /* $order_arr[$key]['brand_order'] = $brand_order;
            $order_arr[$key]['meal_order'] = $meal_order; */
            json_decode($order_arr[$key]['goods_details'],true); 
        }
        
		//发货
        if($logistics_num && $order_id && $is_send)
        {
        	/*如果为0 则无子订单*/
        	if($type == 0)
        	{
        		/*查找此订单下所有商品的信息*/
        		$orderone = CTransaction::searchorder_detail($order_id);
        		/*根据order_id 查找收货人信息*/
        		$buyer_detail = CTransaction::searchbuyer_detail($order_id);
        		foreach($orderone as $k=>$v)
        		{
        			//减少库存
        			$res_reduce=CTransaction::reduceStock($v['goods_model_id'],$v['number']);
        			$arr=array(
        					'code'=>2,
        					'source'=>'研鼎商城',
        					'operator'=>Yii::app()->user->manager,
        					'model'=>$v['goods_model_name'],
        					'type'=>'卖出货物',
        					'num'=>$v['number'],
        					'unit'=>'个',
        					'logisticsId'=>$logistics_company,
        					'logisticsNum'=>$logistics_num,
        					'isReceipt'=>$isReceipt,
        					'shipper'=>$shipper,
        					'boxNum'=>$boxNum,
        					'consignee'=>$consignee,
        					'clientContactor'=>$buyer_detail['receive_name'],
        					'receiveAddress'=>$buyer_detail['receive_province'].$buyer_detail['receive_city'].$buyer_detail['receive_county'].$buyer_detail['receive_detail'],
        					'receiveTele'=>$buyer_detail['receive_phone'],
        					'remark'=>$remark,
        		
        			);
        			if($res_reduce){
        				echo Yii::app()->curl->get('http://localhost/yandingwarehouse/interfaces/rdbuy.php',$arr);
        			}
        		}
        		$result = CTransaction::updateOrder($order_id,$logistics_company,$logistics_num,$is_send=1,$status=5);
        	/*type如果为1 则无子订单*/
        	}elseif ($type == 1)
        	{
        		/*查找此订单下所有商品的信息*/
        		$orderone = CTransaction::searchsuborder_detail($order_id);
        		/*根据order_id 查找收货人信息*/
        		$buyer_detail = CTransaction::searchbuyer_detail($order_fid);
        		foreach($orderone as $k=>$v)
        		{
        			//减少库存
        			$res_reduce=CTransaction::reduceStock($v['goods_model_id'],$v['number']);
        			$arr=array(
        					'code'=>2,
        					'source'=>'研鼎商城',
        					'operator'=>Yii::app()->user->manager,
        					'model'=>$v['goods_model_name'],
        					'type'=>'卖出货物',
        					'num'=>$v['number'],
        					'unit'=>'个',
        					'logisticsId'=>$logistics_company,
        					'logisticsNum'=>$logistics_num,
        					'isReceipt'=>$isReceipt,
        					'shipper'=>$shipper,
        					'boxNum'=>$boxNum,
        					'consignee'=>$consignee,
        					'clientContactor'=>$buyer_detail['receive_name'],
        					'receiveAddress'=>$buyer_detail['receive_province'].$buyer_detail['receive_city'].$buyer_detail['receive_county'].$buyer_detail['receive_detail'],
        					'receiveTele'=>$buyer_detail['receive_phone'],
        					'remark'=>$remark,
        		
        			);
        			if($res_reduce){
        				echo Yii::app()->curl->get('http://localhost/yandingwarehouse/interfaces/rdbuy.php',$arr);
        			}
        		}
        		$result = CTransaction::updateOrder_sub($order_id,$logistics_company,$logistics_num,$is_send=1,$status=5);
        	}

            echo $result;die;
        }
        if($is_delete && $order_id)
        {
            $result = CTransaction::deleteOrder_byid($order_id,$is_delete);
            echo $result;
            die;
        }
      	
        $this->controller->layout = false;
        $this->controller->render(
        		'orderform1',
        		array(
        				'order_arr'=>$order_arr,
        				'count'=>$count,
        				'page'=>$page,
        				'where'=>$where,
        				'sign'=>$sign,
        		));
    }
}