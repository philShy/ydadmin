<?php
/**
 * Class CUser
 * auth @phil
 */
class CUser
{
    public static function insertScore($id,$score,$reason,$type)
    {
        $create_time = date("Y-m-d H:i:s");
        $result = Yii::app()->db->createCommand('INSERT INTO `user_integration_detail` (`user_id`,`number`,`reason`,`create_time`,`type`) VALUES (:user_id,:number,:reason,:create_time,:type)')
        ->bindParam(':user_id',$id)->bindParam(':number',$score)->bindParam(':reason',$reason)
        ->bindParam(':create_time',$create_time)->bindParam(':type',$type)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'user_integration_detail','update');
        return $result;
    }
    //查询所有会员
    public static function searchTest()
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `test`")->queryAll();
        return $result;
    }
    public static function searchAlluser($where='')
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `user`  WHERE $where is_delete=0")->queryAll();
        //$result['address'] = self::searchUserAddress($result['id']);
        foreach($result as $k=>$v)
        {
            //var_dump($v['id']);
            $result[$k]['address']=self::searchUserAddress($v['id']);
        }
        /*echo '<pre>';
        var_dump($result);*/
        return $result;
    }
    //查找用户地址
    public static function searchUserAddress($user_id)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `user_address` WHERE user_id=:user_id AND is_default=1 AND is_delete=0")
        ->bindParam(':user_id',$user_id)->queryRow();
        return $result;
    }
    //更改用户状态
    public static function editUserstate($user_id,$state)
    {
        $result = Yii::app()->db->createCommand('UPDATE `user` SET state=:state WHERE id=:id')
        ->bindParam(':state',$state)->bindParam(':id',$user_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'user','update');
        return $result;
    }
    //更改用户积分
    public static function updateInfo_score($user_id,$score)
    {
        $result = Yii::app()->db->createCommand('UPDATE `user` SET score=score+:score WHERE id=:id')
            ->bindParam(':score',$score)->bindParam(':id',$user_id)->execute();
        //$log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'user','update');
        return $result;
    }
    //删除用户
    public static function deleteUser($user_id,$is_delete)
    {
        $result = Yii::app()->db->createCommand('UPDATE `user` SET is_delete=:is_delete WHERE id=:id')
        ->bindParam(':is_delete',$is_delete)->bindParam(':id',$user_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'user','delete');
        return $result;
    }
    //查询单个用户信息
    public static function seachOneuser($id)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `user` WHERE id=:id")->bindParam(':id',$id)->queryRow();
        return $result;
    }

    //查询收件人信息
    public static function searchReceiver($address_id)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `user_address` WHERE id=:address_id")
            ->bindParam(':address_id',$address_id)->queryRow();
        return $result;
    }
    //查询退款订单记录
    public static function search_refund_byOrderId($order_id)
    {
        $result = Yii::app()->db->createCommand("SELECT sum(price) as refund FROM `order_refundinfo` WHERE order_id=:order_id AND is_success=1 GROUP BY order_id")
            ->bindParam(':order_id',$order_id)->queryRow();
        return $result;
    }
    //查询退款订单详情
    public static function search_refundDetail_byOrderId($sub_id,$user_id)
    {
        $result = Yii::app()->db->createCommand("SELECT sum(b.price*b.number) as refund FROM `order_refund` a LEFT JOIN `order_detail` b ON a.order_detail_id=b.id LEFT JOIN `order_sub` c ON b.order_sub_id=c.id WHERE a.user_id=:user_id AND c.id=:id AND a.apply_type=1 AND a.status=4 OR a.status=6 GROUP BY c.id")
            ->bindParam(':id',$sub_id)->bindParam(':user_id',$user_id)->queryRow();
        return $result;
    }
    //根据子订单id查询改订单下商品
    public static function search_order_detail_byOrderSubId($sub_id)
    {
        $result = Yii::app()->db->createCommand("SELECT GROUP_CONCAT(DISTINCT id) as detail_id_str,sum(price*number) as sub_price FROM `order_detail` WHERE order_sub_id=:order_sub_id GROUP BY order_sub_id")
            ->bindParam(':order_sub_id',$sub_id)->queryRow();
        //var_dump($result);
        return $result;
    }
    //查询该用户的所有订单
    public static function search_user_order($user_id)
    {
        $receive_time = date("Y-m-d H:i:s",time()-3600*24);
        $result = Yii::app()->db->createCommand("SELECT b.id,b.order_id FROM `order` a LEFT JOIN `order_sub` b ON a.id=b.order_id WHERE a.user_id=:user_id AND a.is_delete=0 AND b.status>3 AND b.receive_time<'$receive_time'")
            ->bindParam(':user_id',$user_id)
            ->queryAll();
        foreach($result as $k=>$v)
        {
            $result[$k]['sub_price'] = self::search_order_detail_byOrderSubId($v['id'])['sub_price'];
            $result[$k]['detail_id_str'] = self::search_order_detail_byOrderSubId($v['id'])['detail_id_str'];
        }
        return $result;
    }
    //
    public static function search_order_detailId($sub_id)
    {
        $result = Yii::app()->db->createCommand("SELECT id FROM `order_detail` WHERE order_sub_id=:order_sub_id")
            ->bindParam(':order_sub_id',$sub_id)->queryAll();
        foreach($result as $k=>$v)
        {
            $detail_id[] = $v['id'];
        }
        return $detail_id;
    }
    //
    public static function search_order_refund($user_id,$detail_id_str)
    {
        $result = Yii::app()->db->createCommand("SELECT order_detail_id,number FROM `order_refund` WHERE user_id=$user_id AND apply_type=1 AND status in (4,6) AND order_detail_id in ($detail_id_str)")
          ->queryAll();
        foreach($result as $k=>$v)
        {
            $detail['id'][] = $v['order_detail_id'];
            $detail['number'][] = $v['number'];
        }
        return $detail;
    }
    //
    public static function search_order_detail_price($refund_detail_id,$refund_detail_number)
    {
        $num=0;
        $result = Yii::app()->db->createCommand("SELECT price FROM `order_detail` WHERE id in ($refund_detail_id)")
        ->queryAll();

        foreach ($result as $k=>$v)
        {
            $refund_detail_price[]=$v['price'];
        }

        for($i=0;$i<count($refund_detail_price);$i++)
        {
            $num+=$refund_detail_price[$i]*$refund_detail_number[$i];
        }
        return $num;
    }
}