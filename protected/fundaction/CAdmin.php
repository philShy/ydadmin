<?php
class CAdmin
{
    //查询订单消息表
    public static function searchOrder_notice()
    {
        /*switch ($role)
        {
            case '超级管理员':
                where='WHERE ';
                break;
            case '仓管':
                $where='WHERE operat in(4) AND';
                break;
            case '财务':
                $where='WHERE operat in(0,1,3,4,5,6,8,9) AND';
                break;
            case '销售':
                $where='WHERE operat in(0,2,7) AND';
                break;
            default:
                $where='WHERE ';
        }*/
        $time = -3600*24*30;
        $create_time = date('Y-m-d H:i:s',strtotime("$time seconds"));
        $result = Yii::app()->db->createCommand("SELECT order_id,order_sub_id,operat,create_time FROM `order_notice` WHERE create_time>:create_time AND is_complete=0 ORDER BY create_time DESC ")
            ->bindParam(':create_time',$create_time)->queryAll();
        return $result;
    }
    //改变订单消息通知的状态
    public static function updateNotice($order_id,$order_sub_id,$state)
    {
        //echo $order_sub_id;die;
        $create_time = date('Y-m-d H:i:s',time());
        if($order_sub_id&&$state!=4)
        {
            $result = Yii::app()->db->createCommand('UPDATE `order_notice` SET operat=:operat,create_time=:create_time WHERE order_sub_id=:order_sub_id')
                ->bindParam(':order_sub_id',$order_sub_id) ->bindParam(':create_time',$create_time)->bindParam(':operat',$state)->execute();
            return $result;
        }else{
            $result = Yii::app()->db->createCommand('UPDATE `order_notice` SET operat=:operat,create_time=:create_time WHERE order_id=:order_id')
                ->bindParam(':order_id',$order_id)->bindParam(':create_time',$create_time)->bindParam(':operat',$state)->execute();
            return $result;
        }

    }
}