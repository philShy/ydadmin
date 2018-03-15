<?php
/**
 * @auth Phil
 * @class CTransaction
 */
class CTransaction
{
	//根据条件查找无子订单的订单数量
	public static function search_no_have_order($status='')
	{
		if(empty($status))
		{
			$where = '';
		}else{
			$where = "status=$status AND";
		}
		$result = Yii::app()->db->createCommand("SELECT count(id) as count FROM `order` WHERE $where is_delete=0")
		->queryRow();
		return $result;
	}
	//根据条件查找子订单数量
	public static function search_sub_order_count($status='')
	{
		if(empty($status))
		{
			$where = '';
		}else{
			$where = "status=$status AND";
		}
		$result = Yii::app()->db->createCommand("SELECT count(id) as count FROM `order_sub` WHERE $where is_delete=0")
		->queryRow();
		return $result;
	}
	//减少库存
	public static function reduceStock($id,$reduce)
	{
		$sql = "UPDATE goods_sku SET stock1=stock1-{$reduce} WHERE id={$id}";
		$result = Yii::app()->db->createCommand($sql)->execute();
		return $result;
	}
    //订单查询
    public static function searchAllorder($page=1,$size,$where)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `order` WHERE $where is_delete=0 ORDER BY id desc LIMIT :start,:size")
        ->bindValue(':start',(int)($page-1)*$size)
        ->bindValue(':size',(int)$size)->queryAll();
        return $result;
    }
    //查询申请取消的订单
    //订单查询
    public static function searchAllorder_qx($page=1,$size=10)
    {
        $result = Yii::app()->db->createCommand("SELECT distinct b.*,b.status as order_status,c.price as pay_price,c.payment as pay_payment FROM `order_cancel_apply` a LEFT JOIN `order` b ON a.order_id=b.id LEFT JOIN order_payinfo c ON c.order_id=b.id WHERE a.is_delete=0 AND b.status<3")
            ->bindValue(':start',(int)($page-1)*$size)
            ->bindValue(':size',(int)$size)->queryAll();
        return $result;
    }
    //申请取消的订单
    public static function is_cancel_order($order_id)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `order_cancel_apply` WHERE order_id=:order_id AND is_delete=0")
        ->bindValue(':order_id',$order_id)->queryRow();
        return $result;
    }
    //未支付订单查询
    public static function searchAllorder1($page=1,$size=2,$where)
    {
    	$result = Yii::app()->db->createCommand("SELECT * FROM `order` WHERE $where is_delete=0 ORDER BY id desc LIMIT :start,:size")
    	->bindValue(':start',(int)($page-1)*$size)
    	->bindValue(':size',(int)$size)->queryAll();
    	return $result;
    }
    //待接单订单查询
    public static function searchAllorder2($page=1,$size=2,$where)
    {
    	$result = Yii::app()->db->createCommand("SELECT id FROM `order` WHERE $where is_delete=0")
    	->queryAll();
    	foreach($result as $key=>$val)
    	{
    		$screening_sub_id=self::screening_sub_order($val['id'],$status=1);
    		if(!empty($screening_sub_id))
    		{
    			foreach($screening_sub_id as $kk=>$vv)
    			{
    			
    				$result[$key] = $screening_sub_id;
    			}
    		}
    		
    	}
    	/* if(!empty($arr))
    	{
    		$count = count($arr);
    		$arr_str = implode($arr, ',');
    		$results = Yii::app()->db->createCommand("SELECT * FROM `order` WHERE id in ($arr_str)  ORDER BY id desc LIMIT :start,:size")
    		->bindValue(':start',(int)($page-1)*$size)
    		->bindValue(':size',(int)$size)
    		->queryAll();
    		 
    		$result_arr['results'] = $results;
    		$result_arr['count'] = $count;
    	}else{
    		$result_arr['results']=array();
    		$result_arr['count'] = '';
    	}
    	var_dump($result_arr);
    	return $result_arr; */
    	
    }
    public static function searchAllorder2_num($page=1,$size=2,$where)
    {
    	$result = Yii::app()->db->createCommand("SELECT id FROM `order` WHERE $where is_delete=0 ORDER BY id desc LIMIT :start,:size")
    	->bindValue(':start',(int)($page-1)*$size)
    	->bindValue(':size',(int)$size)->queryAll();
    	foreach($result as $key=>$val)
    	{
    
    		if($val['status']==2)
    		{
    			$arr[] = $val['id'];
    		}
    		$screening_sub_id=self::screening_sub_order($val['id'],$status=2);
    
    		if(!empty($screening_sub_id[0]['order_id']))
    		{
    			$arr[]=$screening_sub_id[0]['order_id'];
    		}
    	}
    	$count = count($arr);
    	$arr_str = implode($arr, ',');
    	$results = Yii::app()->db->createCommand("SELECT * FROM `order` WHERE id in ($arr_str) order by id desc")
    	->queryAll();
    	$result_arr['results'] = $results;
    	$result_arr['count'] = $count;
    	return $result_arr;
    }
    //待发货订单查询
    public static function searchAllorder4($page,$size,$where)
    {
    	 $result = Yii::app()->db->createCommand("SELECT * FROM `order` WHERE $where is_delete=0 ORDER BY id desc LIMIT :start,:size")
        ->bindValue(':start',(int)($page-1)*$size)
        ->bindValue(':size',(int)$size)->queryAll();
        return $result;
    }
    public static function searchAllorder55($where,$page,$size)
    {
        $result = Yii::app()->db->createCommand("SELECT a.*,GROUP_CONCAT(DISTINCT b.id) as order_sub_id_str
        FROM `order` as a LEFT JOIN order_sub as b on a.id=b.order_id 
        LEFT JOIN order_detail as c on b.id=c.order_sub_id
        WHERE $where GROUP BY a.id ORDER BY id desc LIMIT :start,:size")
            ->bindValue(':start',(int)($page-1)*$size)
            ->bindValue(':size',(int)$size)->queryAll();
        return $result;
    }
    //待收货订单查询
    public static function searchAllorder5($page=1,$size=2,$where)
    {
    	$result = Yii::app()->db->createCommand("SELECT id FROM `order` WHERE $where is_delete=0 ")
    	->queryAll();
    	foreach($result as $key=>$val)
    	{
    
    		if($val['status']==5)
    		{
    			$arr[] = $val['id'];
    		}
    		$screening_sub_id=self::screening_sub_order($val['id'],$status=5);
    
    		if(!empty($screening_sub_id[0]['order_id']))
    		{
    			$arr[]=$screening_sub_id[0]['order_id'];
    		}
    	}
    	$count = count($arr);
    	$arr_str = implode($arr, ',');
    	$results = Yii::app()->db->createCommand("SELECT * FROM `order` WHERE id in ($arr_str) ORDER BY id desc LIMIT :start,:size")
    	->bindValue(':start',(int)($page-1)*$size)
    	->bindValue(':size',(int)$size)
    	->queryAll();
    	$result_arr['results'] = $results;
    	$result_arr['count'] = $count;
    	return $result_arr;
    }
    //已完成订单查询
    public static function searchAllorder6($page=1,$size=2,$where)
    {
    	$result = Yii::app()->db->createCommand("SELECT id FROM `order` WHERE $where is_delete=0 ")
    	->queryAll();
    	foreach($result as $key=>$val)
    	{
    
    		if($val['status']==6)
    		{
    			$arr[] = $val['id'];
    		}
    		$screening_sub_id=self::screening_sub_order($val['id'],$status=6);
    
    		if(!empty($screening_sub_id[0]['order_id']))
    		{
    			$arr[]=$screening_sub_id[0]['order_id'];
    		}
    	}
    	$count = count($arr);
    	$arr_str = implode($arr, ',');
    	$results = Yii::app()->db->createCommand("SELECT * FROM `order` WHERE id in ($arr_str) ORDER BY id desc LIMIT :start,:size")
    	->bindValue(':start',(int)($page-1)*$size)
    	->bindValue(':size',(int)$size)
    	->queryAll();
    	$result_arr['results'] = $results;
    	$result_arr['count'] = $count;
    	return $result_arr;
    }
    //已取消订单查询
    public static function searchAllorder3($page=1,$size=2,$where)
    {
    	$result = Yii::app()->db->createCommand("SELECT * FROM `order` WHERE $where is_delete=0 ORDER BY id desc LIMIT :start,:size")
    	->bindValue(':start',(int)($page-1)*$size)
    	->bindValue(':size',(int)$size)->queryAll();
    	return $result;
    }
    //按条件筛选子订单
    public static function screening_sub_order($order_id,$status)
    {
    	$result = Yii::app()->db->createCommand("SELECT id FROM `order_sub` WHERE order_id=$order_id and status=$status")
    	->queryAll();
    	return $result;
    }
    //按条件查询交易金额
    public static function search_amount_bywhere($page=1,$size=2,$where)
    {
    	$result = Yii::app()->db->createCommand("SELECT id,price,update_time FROM `order` WHERE $where is_delete=0 AND status=6 ORDER BY id desc LIMIT :start,:size")
    	->bindValue(':start',(int)($page-1)*$size)
    	->bindValue(':size',(int)$size)->queryAll();
    	return $result;

    }
    //订单查询
    public static function search_success_order($page=1,$size=2,$where)
    {
    	$result = Yii::app()->db->createCommand("SELECT a.id,b.create_time,b.price FROM `order` a LEFT JOIN `order_payinfo` b ON a.id=b.order_id WHERE a.is_delete=0 AND a.status=2 ORDER BY a.id desc LIMIT :start,:size")
    	->bindValue(':start',(int)($page-1)*$size)
    	->bindValue(':size',(int)$size)->queryAll();
    	return $result;
    }
    public static function search_success_count($where)
    {
    	
    	$result = Yii::app()->db->createCommand("SELECT count(id) as count FROM `order` WHERE $where is_delete=0 AND status=6")
    	->queryRow();
    	return $result;
    }
    //通过order_detail_id 查询退款
    public static function search_refund_byorderdetaiid($order_detail_id)
    {
    	$result = Yii::app()->db->createCommand("SELECT a.create_time,a.number as refund_num,b.price as refund_price FROM `order_refund` a LEFT JOIN `order_detail` b ON a.order_detail_id =b.id WHERE a.order_detail_id=:order_detail_id AND a.status=6")
    	->bindValue(':order_detail_id',$order_detail_id)->queryAll();
    	return $result;
    }
    //通过order_detail_id 查询退款订单状态
    public static function search_refundstatus_byorderdetaiid($order_detail_id)
    {
    	$result = Yii::app()->db->createCommand("SELECT status FROM `order_refund` WHERE order_detail_id=:order_detail_id")
    	->bindValue(':order_detail_id',$order_detail_id)->queryAll();
    	return $result;
    }
    //查询订单成交金额
    public static function search_amount_all($where_refund='')
    {
    	//ECHO $where_refund;
    	$result = Yii::app()->db->createCommand("SELECT sum(a.price) as total_price FROM `order_payinfo` a LEFT JOIN `order` b ON a.order_id = b.id WHERE $where_refund b.status=6 ")
    	->queryRow();
    	var_dump($result);die;
    	return $result;
    }
    //查询已支付订单
    public static function search_pay_amount_all($where)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `order_payinfo` WHERE $where status=1")
          ->queryAll();
        foreach($result as $k=>$v)
        {   //查找该order_id下退款情况
            $result[$k]['refund_arr'] = self::search_refund($v['order_id'],$where);
        }
        return $result;
    }
    public static function search_pay_amount($page,$size,$where)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `order_payinfo` WHERE $where status=1 ORDER BY id desc LIMIT :start,:size")
            ->bindValue(':start',(int)($page-1)*$size)->bindValue(':size',(int)$size)->queryAll();
        foreach($result as $k=>$v)
        {   //查找该order_id下退款情况
            $result[$k]['refund_arr'] = self::search_refund($v['order_id'],$where);
        }
        return $result;
    }
    //查询退款订单信息
    public static function search_refund_amount($where)
    {
        $result = Yii::app()->db->createCommand("SELECT sum(price) as price FROM `order_refundinfo` WHERE $where is_success=0 GROUP BY order_id")->queryAll();
        return $result;
    }
    //查询成功退款
    public static function search_refund($order_id,$where)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `order_refundinfo` WHERE $where order_id=$order_id AND is_success=0")->queryAll();
        return $result;
    }
    //查询退款总金额
    public static function search_refund_all($where_refund_info='')
    {
    	$result = Yii::app()->db->createCommand("SELECT sum(price) as total_price FROM `order_refundinfo` WHERE $where_refund_info is_success='SUCCESS' ")
    	->queryRow();
    	return $result;
    }
    //查询订单成交金额(当天)
    public static function search_amount_today()
    {
    	$begintime=date("Y-m-d H:i:s",mktime(0,0,0,date('m'),date('d'),date('Y')));
    	$nowtime = date("Y-m-d H:i:s");
    	$result = Yii::app()->db->createCommand("SELECT sum(price) as today_price FROM `order_payinfo` WHERE create_time>:begintime AND create_time<:nowtime")
    	->bindValue(':begintime',$begintime)->bindValue('nowtime',$nowtime)->queryRow();
    	return $result;
    }
/*     //查询订单退款金额
    public static function search_refund_all($where_refund='')
    {
    	$result = Yii::app()->db->createCommand("SELECT sum(price) as total_price FROM `order_refundinfo` WHERE is_success='SUCCESS'")
    	->queryRow();
    	return $result;
    } */
    //查询订单退款金额(当天)
    public static function search_refund_today()
    {
    	$begintime=date("Y-m-d H:i:s",mktime(0,0,0,date('m'),date('d'),date('Y')));
    	$nowtime = date("Y-m-d H:i:s");
    	$result = Yii::app()->db->createCommand("SELECT sum(price) as total_price FROM `order_refundinfo`  WHERE is_success='SUCCESS' AND create_time>:begintime AND create_time<:nowtime")
    	->bindValue(':begintime',$begintime)->bindValue('nowtime',$nowtime)->queryRow();
    	return $result;
    }
    //订单查询
    public static function search_sub_one($id)
    {
    	$result = Yii::app()->db->createCommand("SELECT * FROM `order_detail` WHERE order_sub_id=:order_sub_id AND is_delete=0")
    	->bindParam(':order_sub_id',$id)->queryAll();
    	return $result;
    }
    //查询订单详情
    public static function search_order_sub_id($order_id,$status)
    {
    	if($status == '')
    	{
    		$where = '';
    	}elseif ($status == '>3')
        {
            $where = "AND status $status ";
        }
    	else{
    		$where = "AND status = $status ";
    	}
    	$result = Yii::app()->db->createCommand("SELECT id as order_sub_id,is_advance_order,logistics_type,logistics_num,receive_time,status as sub_status FROM `order_sub` WHERE order_id=:order_id $where AND is_delete=0")
    	->bindParam(':order_id',$order_id)->queryAll();
    	//var_dump($result);
    	return $result;
    }
    //取消订单
    public static function qx_order($order_id,$status)
    {
        $result = Yii::app()->db->createCommand('UPDATE `order` SET status=:status WHERE id=:id')
            ->bindParam(':id',$order_id)->bindParam(':status',$status)->execute();
        if($result)
        {
            $result1 = Yii::app()->db->createCommand('UPDATE `order_cancel_apply` SET is_delete=1 WHERE order_id=:id')
                ->bindParam(':id',$order_id)->execute();
            CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'order','cancel_order');
            CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'order_cancel_apply','cancel_order');
            return $result1;
        }
    }
    public static function search_ordersub_id($order_id,$status)
    {
        //var_dump($status);
    	if($status == '')
    	{
    		$where = '';
    	}elseif($status=='>3')
        {
            $where = "AND status $status ";
        }
    	else{
    		$where = "AND status = $status ";
    	}
    	$result = Yii::app()->db->createCommand("SELECT *,status as sub_status FROM `order_sub` WHERE order_id=:order_id $where AND is_delete=0")
    	->bindParam(':order_id',$order_id)->queryAll();
    	//unset($result['status']);

    	return $result;
    }
    //根据子订单ID查找订单详情
    public static function search_have_detail($order_sub_id)
    {
    	$result = Yii::app()->db->createCommand("SELECT * FROM `order_detail` WHERE order_sub_id=:order_sub_id AND is_delete=0")
    	->bindParam(':order_sub_id',$order_sub_id)->queryAll();
    	return $result;
    }
    //查询总数
    public static function countorder($where)
    {
    	$result = Yii::app()->db->createCommand("SELECT * FROM `order` WHERE $where is_delete=0")->queryAll();
    	return count($result);
    }
    //按条件查询待结单数量
    public static function countorder_wite($where)
    {
        $result = Yii::app()->db->createCommand("SELECT a.id 
        FROM `order` as a LEFT JOIN order_sub as b on a.id=b.order_id 
        WHERE $where GROUP BY a.id")
        ->queryAll();
        $count = count($result);
        return $count;
    }
    public static function searchdDetail_cate($cateid)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `order_detail` WHERE cateid=:cateid")
        ->bindParam(':cateid',$cateid)->queryAll();
        return $result;
    }
    public static function searchAlldetail()
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `order_detail`")->queryAll();
        return $result;
    }
    //单个订单查询
    public static function searchOneorder_detail($order_id)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `order` a LEFT JOIN `user_address` b ON a.user_id=b.user_id WHERE a.id=:order_id AND b.is_default=1' )
        ->bindParam(':order_id',$order_id)->queryRow();
        return $result;
    }
    //查找此订单下所有商品的信息
    public static function searchorder_detail($order_id)
    {
    	$result = Yii::app()->db->createCommand('SELECT * FROM `order_detail` WHERE order_id=:order_id' )
    	->bindParam(':order_id',$order_id)->queryAll();
    	return $result;
    }
    //查询该子订单下所有商品信息
    public static function searchsuborder_detail($order_sub_id)
    {
    	$result = Yii::app()->db->createCommand('SELECT * FROM `order_detail` WHERE order_sub_id=:order_sub_id' )
    	->bindParam(':order_sub_id',$order_sub_id)->queryAll();
    	return $result;
    }
    //查找买家id
    public static function searchbuyer_detail($order_id)
    {
    	$result = Yii::app()->db->createCommand('SELECT b.* FROM `order` a LEFT JOIN `user_address` b ON a.address_id=b.id WHERE a.id=:order_id')
    	->bindParam(':order_id',$order_id)->queryRow();
    	return $result;
    }
    //查询子订单
    public static function search_suborder($id)
    {
    	$result = Yii::app()->db->createCommand('SELECT * FROM `order_sub` WHERE id=:id AND is_delete=0' )
    	->bindParam(':id',$id)->queryRow();
    	return $result;
    }
    //按条件筛选查询子订单
    public static function search_suborder2($id)
    {
    	$result = Yii::app()->db->createCommand('SELECT * FROM `order_sub` WHERE id=:id AND status=2 AND is_delete=0' )
    	->bindParam(':id',$id)->queryRow();
    	return $result;
    }
    //查询缺货订单商品个数
    public static function seacrh_order_notnum($order_sub_id)
    {
    	$result = Yii::app()->db->createCommand('SELECT count(id) as num FROM `order_detail` WHERE order_sub_id=:order_sub_id AND is_delete=0' )
    	->bindParam(':order_sub_id',$order_sub_id)->queryRow();
    	return $result['num'];
    }
    //查询订单商品个数
    public static function seacrh_order_num($order_id,$sign='')
    {
    	if($sign == '')
    	{
    		$where = '';
    	}
    	else{
    		$where = "AND status = $sign ";
    	}
    	$result = Yii::app()->db->createCommand("SELECT count(id) as num FROM `order_detail` WHERE order_id=:order_id $where AND is_delete=0" )
    	->bindParam(':order_id',$order_id)->queryRow();
    	return $result['num'];
    }
    //查询子订单详情
    public static function search_suborder_detail($id)
    {
    	$result = Yii::app()->db->createCommand('SELECT * FROM `order_detail` WHERE order_sub_id=:order_sub_id AND is_delete=0' )
    	->bindParam(':order_sub_id',$id)->queryRow();
    	return $result;
    }
    //交易成功订单查询
    public static function success_order($page,$size,$where)
    {
        $result = Yii::app()->db->createCommand("SELECT a.*, b.end_time FROM `order_detail` a LEFT JOIN `order` b ON a.order_id=b.order_id WHERE
        a.state=4 $where ORDER BY a.id DESC LIMIT :start,:size")
        ->bindValue(':start',(int)($page-1)*$size)->bindValue(':size',(int)$size)->queryAll();
        return $result;
    }
    //统计交易金额
    public static function searchAmount($where)
    {
        $result = Yii::app()->db->createCommand("SELECT sum(a.price*a.num) FROM `order_detail` a LEFT JOIN `order` b ON a.order_id=b.order_id WHERE
        a.state=4 $where")->queryRow();
        return $result;
    }
    //统计交易订单数
    public static function searchorderCount($where)
    {
        $result = Yii::app()->db->createCommand("SELECT count(*) FROM `order` $where")->queryRow();
        return $result;
    }
    //统计交易订单(商品)数
    public static function searchCount($where)
    {
        $result = Yii::app()->db->createCommand("SELECT count(a.id) FROM `order_detail` a LEFT JOIN `order` b ON a.order_id=b.order_id WHERE
        a.state=4 $where")->queryRow();
        return $result;
    }
    //订单详情查询
    public static function searchOrderdetail($order_id)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `order_detail` WHERE order_id=:order_id')->bindParam(':order_id',$order_id)->queryAll();
        return $result;
    }
    //单个订单查询
    public static function searchOneorder($id)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `order` WHERE id=:id')->bindParam(':id',$id)->queryRow();
        return $result;
    }

    //单个子订单查询
    public static function searchOneorder_sub($id)
    {
    
    	$result = Yii::app()->db->createCommand('SELECT c.beizhu,a.id as sub_id,a.status as sub_status, a.*,b.*,c.user_id,c.address_id,c.invoice,c.payment,c.status as order_status FROM `order_sub` a 
         LEFT JOIN `order_detail` b ON a.id = b.order_sub_id 
         LEFT JOIN `order` c ON a.order_id = c.id
         WHERE a.id=:id')
         ->bindParam(':id',$id)->queryRow();
    	return $result;
    }
    public static function search_sub_all_detail($id)
    {
    
    	$result = Yii::app()->db->createCommand('SELECT * FROM `order_detail` WHERE order_sub_id=:order_sub_id')
    	->bindParam(':order_sub_id',$id)->queryAll();
    	return $result;
    }
    
    public static function search_sub_detail_bybrand($arr)
    {
    	$brand_str = implode($arr, ',');
    	$sql = "SELECT * FROM `order_detail` WHERE id in ($brand_str)";
    	$result = Yii::app()->db->createCommand($sql)->queryAll();
    	return $result;
    }
    public static function search_sub_meal_bymeal($arr)
    {
    	$meal_str = implode($arr, ',');
    	$sql = "SELECT * FROM `order_detail` WHERE id in ($meal_str)";
    	$result = Yii::app()->db->createCommand($sql)->queryAll();
    	return $result;
    }
    ///////////////////////////////////
    public static function search_all_detail_bybrand($arr)
    {
    	$brand_str = implode($arr, ',');
    	$sql = "SELECT * FROM `order_detail` WHERE id in ($brand_str)";
    	$result = Yii::app()->db->createCommand($sql)->queryAll();
    	return $result;
    }
    public static function search_all_meal_bymeal($arr)
    {
    	$meal_str = implode($arr, ',');
    	$sql = "SELECT * FROM `order_detail` WHERE id in ($meal_str)";
    	$result = Yii::app()->db->createCommand($sql)->queryAll();
    	return $result;
    }
   //////////////////////////////////
   //订单插入配送方式，物流单号
    public static function updateOrder($orderid,$logistics_company,$logistics_num,$is_send=1,$status=5)
    {
    	$send_time = date('Y-m-d H:i:s',time());
        $result = Yii::app()->db->createCommand('UPDATE `order` SET logistics_type=:logistics_company,logistics_num=:logistics_num,is_send=:is_send,status=:status,send_time=:send_time WHERE id=:id')
        ->bindParam(':logistics_company',$logistics_company)->bindParam(':logistics_num',$logistics_num)->bindParam(':is_send',$is_send)
        ->bindParam(':status',$status)->bindParam(':send_time',$send_time)->bindParam(':id',$orderid)->execute();

        return $result;
    }
 	//子订单插入配送方式，物流单号，更改订单状态
    public static function updateOrder_sub($orderid,$logistics_company,$logistics_num,$status=3)
    {
    	$send_time = date('Y-m-d H:i:s',time());
        $result = Yii::app()->db->createCommand('UPDATE `order_sub` SET logistics_type=:logistics_company,logistics_num=:logistics_num,status=:status,send_time=:send_time WHERE id=:id')
        ->bindParam(':logistics_company',$logistics_company)->bindParam(':logistics_num',$logistics_num)
        ->bindParam(':status',$status)->bindParam(':send_time',$send_time)->bindParam(':id',$orderid)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'order_sub','send_goods');
        return $result;
    }
    //退款订单查询
    public static function refund()
    {
        $sql = "SELECT a.*,b.order_id,b.order_sub_id,b.price,b.meal_id,b.brand_id,c.model_number,d.payment,e.name FROM `order_refund` a
        LEFT JOIN `order_detail` b ON a.order_detail_id=b.id
        LEFT JOIN `goods_model` c ON a.goods_model_id=c.id
        LEFT JOIN `order_payinfo` d ON b.order_id =d.order_id
        LEFT JOIN `goods` e ON e.id =c.goods_id";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        /*echo '<pre>';
        var_dump($result);die;*/
        return $result;
    }
    //删除退款订单
    public static function del_refund_byrefundid($refund_id)
    {
    	$result = Yii::app()->db->createCommand('UPDATE `order_refund` SET is_delete=1 WHERE id=:id')
    	->bindParam(':id',$refund_id)->execute();
    	return $result;
    }
    //退款订单查询 (按条件)
    public static function search_refund_bycondition($sql_str)
    {
    	$sql = "SELECT a.*,b.order_id,b.order_sub_id,b.price,b.meal_id,b.brand_id,c.model_number,d.payment,e.name FROM `order_refund` a
        LEFT JOIN `order_detail` b ON a.order_detail_id=b.id
        LEFT JOIN `goods_model` c ON a.goods_model_id=c.id
        LEFT JOIN `order_payinfo` d ON b.order_id =d.order_id
        LEFT JOIN `goods` e ON e.id =c.goods_id $sql_str";
    	$result = Yii::app()->db->createCommand($sql)->queryAll();
    	return $result;
    }
    //修改退款订单回复
    public static function insertRefund_reply($reply,$orderid,$refund_pid)
    {
        $sql = "INSERT INTO refund (reply) VALUES (:reply) WHERE order_id=:order_id AND refund_pid=:refund_pid";
        $result = Yii::app()->db->createCommand($sql)
        ->bindParam(':reply',$reply)->bindParam(':order_id',$orderid)->bindParam(':refund_pid',$refund_pid)->execute();

        return $result;
    }
    //维修 换货物流号填写
    public static function updata_refund($refund_id,$logistics_num,$send_method)
    {
        $result = Yii::app()->db->createCommand('UPDATE `order_refund` SET express_model_next=:express_model_next,logistics_number_next=:logistics_number_next,status=6 WHERE id=:id')
            ->bindParam(':express_model_next',$send_method)->bindParam(':logistics_number_next',$logistics_num)->bindParam(':id',$refund_id)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'order_sub','send_goods');
        return $result;
    }
    //修改退款订单状态
    public static function editRefund_state($state,$reply='',$orderid,$pid)
    {
        $result = Yii::app()->db->createCommand('UPDATE `refund` SET state=:state,reply=:reply WHERE order_id=:order_id AND refund_pid=:pid')
        ->bindParam(':state',$state)->bindParam(':reply',$reply)->bindParam(':order_id',$orderid)->bindParam(':pid',$pid)->execute();

        return $result;
    }
    //修改订单详情状态
    public static function editDetail_state($detail_state,$orderid,$pid)
    {
        $result = Yii::app()->db->createCommand('UPDATE `order_detail` SET state=:state WHERE order_id=:order_id AND pid=:pid')
            ->bindParam(':state',$detail_state)->bindParam(':order_id',$orderid)->bindParam(':pid',$pid)->execute();
        return $result;
    }
    //修改子订单状态
    public static function editorder_sub_state($order_id, $order_status)
    {
        $order_taking_time = date('Y-m-d H:i:s',time());
        $result = Yii::app()->db->createCommand('UPDATE `order_sub` SET status=:status,order_taking_time=:order_taking_time WHERE order_id=:id')
        ->bindParam(':status',$order_status)->bindParam(':order_taking_time',$order_taking_time)->bindParam(':id',$order_id)->execute();
    	return $result;
    }
    public static function editorder_sub_is_score($id,$is_score)
    {
        $result = Yii::app()->db->createCommand('UPDATE `order_sub` SET is_score=:is_score WHERE id=:id')
            ->bindParam(':is_score',$is_score)->bindParam(':id',$id)->execute();
        return $result;
    }
    //确认收货
    public static function updateOrder_receive($order_sub_id)
    {
        $receive_time = date('Y-m-d H:i:s',time());
        $res = Yii::app()->db->createCommand('UPDATE `order_sub` SET status=4,receive_time=:receive_time WHERE id=:id')
            ->bindParam(':id',$order_sub_id)->bindParam(':receive_time',$receive_time)->execute();
        return $res;
    }

  	//修改订单状态
    public static function editorder_state($order_id,$order_status)
    {
    	$create_time = date('Y-m-d H:i:s',time());
    	$result = Yii::app()->db->createCommand('UPDATE `order` SET status=:status,create_time=:create_time WHERE id=:id')
    	->bindParam(':status',$order_status)->bindParam(':create_time',$create_time)->bindParam(':id',$order_id)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'order','update');
    	return $result;
    }
    //检测子订单状态
    public static function detect_order_sub($order_id)
    {
    	$result = Yii::app()->db->createCommand('SELECT status FROM `order_sub` WHERE id=:id')
    	->bindParam(':id',$order_id)->queryRow();
    	return $result;
    }
    //退款订单详情
    public static function refundDetail($id)
    { 
    	$sql = "SELECT a.*,f.payment as payment_status,b.order_id,b.order_sub_id,b.price,b.meal_id,b.brand_id,b.number as detail_number,c.model_number,d.payment,d.price as totle_fee,e.name,f.address_id FROM `order_refund` a
        LEFT JOIN `order_detail` b ON a.order_detail_id=b.id
        LEFT JOIN `goods_model` c ON a.goods_model_id=c.id
        LEFT JOIN `order_payinfo` d ON b.order_id =d.order_id
        LEFT JOIN `goods` e ON e.id =c.goods_id 
    	LEFT JOIN `order` f ON b.order_id =f.id
    	WHERE a.id=$id";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        return $result;
    }
    //改变退款订单状态 成功！
    public static function updata_refund_state($refund_id,$status)
    {
    	$result = Yii::app()->db->createCommand('UPDATE `order_refund` SET status=:status WHERE id=:id')
    	->bindParam(':status',$status)->bindParam(':id',$refund_id)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'order_refund','update');
    	return $result;
    }

    //添加退款详情
    public static function record_refund_info($refund_id,$order_id,$payment,$price,$refund_serial_number,$refund_info,$is_success)
    {
    	$create_time = date('Y-m-d H:i:s',time());
    	$sql = "INSERT INTO order_refundinfo (refund_id,order_id,payment,price,refund_serial_number,refund_info,create_time,is_success) VALUES (:refund_id,:order_id,:payment,:price,:refund_serial_number,:refund_info,:create_time,:is_success)";
    	$result = Yii::app()->db->createCommand($sql)
    	->bindParam(':refund_id',$refund_id)->bindParam(':order_id',$order_id)->bindParam(':payment',$payment)
    	->bindParam(':price',$price)->bindParam(':refund_serial_number',$refund_serial_number)->bindParam(':refund_info',$refund_info)
    	->bindParam(':create_time',$create_time)->bindParam(':is_success',$is_success)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'order_refund','update');
    	return $result;
    }
    //拒绝退款
    public static function reject($refund_id,$status=0,$reject)
    {
    	$status=0;
    	$result = Yii::app()->db->createCommand('UPDATE `order_refund` SET status=:status,refuse_reason=:refuse_reason WHERE id=:id')
    	->bindParam(':status',$status)->bindParam(':refuse_reason',$reject)->bindParam(':id',$refund_id)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'order_refund','update');
    	return $result;
    }
    //查找微信支付id
    public static function search_wxid($order_id)
    {
    	$result = Yii::app()->db->createCommand('SELECT out_trade_to from `wechat_out_trade_to` WHERE order_id=:order_id order by id desc')
    	->bindParam(':order_id',$order_id)->queryRow();
    	return $result;
    }
    //根据订单详情id查询退款单的该商品数量
    public static function search_detect_refund($order_detail_id)
    {
    	//var_dump($order_detail_id);die;
    	$result = Yii::app()->db->createCommand('SELECT number FROM `order_refund` WHERE order_detail_id=:order_detail_id AND status>1')
    	->bindParam(':order_detail_id',$order_detail_id)->queryAll();
    	return $result;
    }
	//退款人信息
    public static function search_user_info($address_id)
    {
    	$result = Yii::app()->db->createCommand('SELECT * FROM `user_address` WHERE id=:id')
    	->bindParam(':id',$address_id)->queryRow();
    	return $result;
    }
	//查找上传的图片
    public static function search_upload_img($upload_img_str)
    {
    	$sql = "SELECT * FROM `images_user_upload` WHERE id in ($upload_img_str)";
    	$result = Yii::app()->db->createCommand($sql)
    	->bindParam(':id',$address_id)->queryAll();
    	return $result;
    }
    //删除订单
    public static function deleteOrder_byid($orderid,$is_delete)
    {
        $result = Yii::app()->db->createCommand('UPDATE `order` SET is_delete=:is_delete WHERE id=:id')
        ->bindParam(':is_delete',$is_delete)->bindParam(':id',$orderid)->execute();
        return $result;
    }
    //审核增值税发票资质
    public static function updata_invoice3($id,$is_audit,$audit_cause='')
    {
    	$result = Yii::app()->db->createCommand('UPDATE `invoice3` SET is_audit=:is_audit,not_audit_cause=:not_audit_cause WHERE id=:id')
    	->bindParam(':id',$id)->bindParam(':is_audit',$is_audit)->bindParam(':not_audit_cause',$audit_cause)->execute();
    	return $result;
    }
    //查询收货大于3天的订单
    public static function search_order_byWhere()
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `order_sub` a LEFT JOIN `order` b ON a.order_id=b.id LEFT JOIN `order_detail` c ON a.id=c.order_sub_id')
        ->queryRow();
        return $result;
    }
    
    public static function insert_payinfo($order_id,$payment,$code,$price,$payinfo)
    {
        //echo $order_id.'-'.$payment.'-'.$code.'-'.$price.'-'.$payinfo;die;
        $create_time = date('Y-m-d H:i:s',time());
        $result = Yii::app()->db->createCommand("INSERT INTO `order_payinfo` (order_id,payment,code,price,payinfo,create_time) VALUES (:order_id,:payment,:code,:price,:payinfo,:create_time)")
         ->bindParam(':order_id',$order_id)->bindParam(':payment',$payment)->bindParam(':code',$code)
        ->bindParam(':price',$price)->bindParam(':payinfo',$payinfo)->bindParam(':create_time',$create_time)->execute();
        return $result;
    }
    
    public static function updata_stock($sku_id,$number)
    {
        $sql = "UPDATE goods_sku SET stock1=stock1+{$number} WHERE id={$sku_id}";
        $result = Yii::app()->db->createCommand($sql)->execute();
        return $result;
    }
    public static function search_detail_id_byRefund($id)
    {
        $result = Yii::app()->db->createCommand('SELECT a.number,c.id,c.pn FROM `order_refund` a LEFT JOIN `order_detail` b ON a.order_detail_id=b.id LEFT JOIN `goods_sku` c ON b.goods_sku_id=c.id WHERE a.id=:id')
            ->bindParam(':id',$id)->queryRow();
        return $result;
    }
    //改变物流方式
    public static function editOrderLogisticsType($sub_id,$logistics_company)
    {
        $result = Yii::app()->db->createCommand("UPDATE order_sub SET logistics_type=:logistics_type WHERE id=:id")
            ->bindParam(':id',$sub_id)->bindParam(':logistics_type',$logistics_company)->execute();
        return $result;
    }
    public static function editOrderLogisticsNum($sub_id,$logistics_num)
    {
        $result = Yii::app()->db->createCommand("UPDATE order_sub SET logistics_num=:logistics_num WHERE id=:id")
            ->bindParam(':id',$sub_id)->bindParam(':logistics_num',$logistics_num)->execute();
        return $result;
    }

    public static function searchOrderSub_byWhere($send_time)
    {
        $result = Yii::app()->db->createCommand('SELECT id,order_id,logistics_num,logistics_type FROM `order_sub` WHERE send_time>:send_time AND status=3')
            ->bindParam(':send_time',$send_time)->queryAll();
        return $result;
    }
    public static function searchOrderSubIsScore_byWhere($is_score,$time,$status)
    {
        $receive_time = date("Y-m-d H:i:s",time()-3600*24*$time);
        $result = Yii::app()->db->createCommand('select a.*,b.user_id,group_concat(c.id) order_sub_id,group_concat(c.goods_sku_id) order_sub_sku_id ,sum(c.price*c.number) order_sub_price from `order_sub` a left join `order` b on a.order_id=b.id left join `order_detail` c on a.id=c.order_sub_id WHERE a.is_score=:is_score AND a.receive_time>:receive_time AND a.status>:status group by a.id  ')
            ->bindParam(':is_score',$is_score)->bindParam(':receive_time',$receive_time)->bindParam(':status',$status)->queryAll();
        return $result;
    }
    public static function searchOrderSubDetail_byWhere($where,$page,$size)
    {
        $result = Yii::app()->db->createCommand("select a.*,b.user_id,group_concat(c.id) order_sub_id,group_concat(c.goods_sku_id) order_sub_sku_id ,sum(c.price*c.number) order_sub_price from `order_sub` a left join `order` b on a.order_id=b.id left join `order_detail` c on a.id=c.order_sub_id WHERE $where group by a.id ORDER BY a.id LIMIT :start,:size ")
            ->bindValue(':start',(int)($page-1)*$size)->bindValue(':size',(int)$size)->queryAll();
        return $result;
    }
    public static function searchOrderSubDetailCounty_byWhere($where)
    {
        $result = Yii::app()->db->createCommand("select a.*,b.user_id,group_concat(c.id) order_sub_id,group_concat(c.goods_sku_id) order_sub_sku_id ,sum(c.price*c.number) order_sub_price from `order_sub` a left join `order` b on a.order_id=b.id left join `order_detail` c on a.id=c.order_sub_id WHERE $where group by a.id")
            ->queryAll();
        return count($result);
    }
    
    
    
    
    
    
    
    
    
}