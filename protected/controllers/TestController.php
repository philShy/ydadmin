<?php
class TestController extends Controller{
  public function actionTest(){
      $admin_id = Yii::app()->user->id;
      //查询符合条件的用户
      //$redis = Yii::app()->redis;
      //1.查询已成交的未送积分的子订单=》送积分
      $not_socre = CTransaction::searchOrderSubIsScore_byWhere($is_score=0,$time=6,$status=3);
      //2.用户添加积分详情 改变子订单表积分状态
      foreach ($not_socre as $k=>$v)
      {
          $res = CUser::insertScore($v['user_id'],floor($v['order_sub_price']/100),$reason="购物+(子订单号：$v[id])",$type=2);
          if($res)
          {
              CTransaction::editorder_sub_is_score($v['id'],$is_score=1);
              CSystem::opration_user_news($v['user_id'],$admin_id,'积分消息',"您的子订单：$v[order_id]-$v[id]赠送积分".floor($v['order_sub_price']/100),"http://rdbuy.com.cn/order/orderdetail?order_sub_id=$v[id]");
              CUser::updateInfo_score($v['user_id'],floor($v['order_sub_price']/100));
          }
      }
      die;
	 $this->layout = false;
	 $this->render('test');
  }
}