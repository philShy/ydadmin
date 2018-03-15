<?php
class HomeController extends Controller
{
    public function actionIndex()
    {

    	$user = CUser::searchAlluser($where);
    	$count_user = count($user);

    	/*获取登录管理员个人信息*/
    	$userid = Yii::app()->user->id;
    	$order_all_count = CTransaction::countorder($where='');
        $refund_amount = CTransaction::search_refund_amount($where);
        $refund_amount_all = self::calculate_ammount($refund_amount);
        $total_pay_amount = CTransaction::search_pay_amount_all($where);
        $pay_amount_all = self::calculate_ammount($total_pay_amount);
        $amount = round($pay_amount_all-$refund_amount_all);
        /*未开发票订单*/
        $not_inv_where="is_invoice=0 AND invoice!=''AND status=2 AND";
        $not_inv_count = CTransaction::countorder($not_inv_where);
    	/*待结单订单*/
        $to_re_where = "a.`status`=2 AND b.`status`=1 AND a.is_delete=0";
        $untreated_order_count = CTransaction::countorder_wite($to_re_where);
    	/*未发货订单*/
        $to_send_where = "a.`status`=2 AND b.`status`=2 AND a.is_delete=0";
        $to_send_order_count = CTransaction::countorder_wite($to_send_where);
    	/*交易成功订单*/
        $success_where = "a.`status`=2 AND b.`status`>3 AND a.is_delete=0";
        $success_order_count = CTransaction::countorder_wite($success_where);
    	/*失败订单*/
        $fail_order_count = CTransaction::countorder($where='status=3 and');
    	/*商品总数*/
        $count_model = CProduct::searchGoodsmodelall_num();;
    	/*上架商品*/
    	$count_publish_model = CProduct::search_model_count_bywhere($where='is_publish=0 AND')['count(id)'];
    	/*下架商品*/
    	$count_no_publish_model = CProduct::search_model_count_bywhere($where='is_publish=1 AND')['count(id)'];
        /*待审核商品*/
        $wait_goods = CProduct::search_model_count_bywhere($where='wait_audit=-1 or wait_audit=1 AND')['count(id)'];
    	//商品评论数
        $goods_comment = CComment::searchGoods_comment();
        $goods_comment_count = count($goods_comment);
    	/*品牌数量*/
    	$brand = CProduct::searchBrandall();
    	$count_brand = count($brand);
    	/*文章数量*/
    	$article = CArticle::searchAll_article();
    	$count_article = count($article);
    	/*文章评论*/
    	$article_comment = CComment::searchArticle_comment();
    	$article_comment_count = count($article_comment);
    	$article_comment_floor_count = CComment::searchArticle_comment_user()['count'];
		$article_comment_count_all = $article_comment_count+$article_comment_floor_count;
    	/**/
    	
        $this->layout = false;
        $this->render("index",
          array(
          		'id'=>$userid,
          		'count_user'=>$count_user,
        		'success_order_count'=>$success_order_count,
        		'order_all_count'=>$order_all_count,
        		'amount'=>$amount,
        		'untreated_order_count'=>$untreated_order_count,
        		'to_send_order_count'=>$to_send_order_count,
        		'success_order_count'=>$success_order_count,
        		'fail_order_count'=>$fail_order_count,
        		'count_model'=>$count_model,
        		'count_publish_model'=>$count_publish_model,
        		'count_no_publish_model'=>$count_no_publish_model,
        		'count_brand'=>$count_brand,
        		'count_article'=>$count_article,
        		'article_comment_count_all'=>$article_comment_count_all,
                'goods_comment_count'=>$goods_comment_count,
                'not_inv_count'=>$not_inv_count,
              'wait_goods'=>$wait_goods,
        ));
    }
    public static function calculate_ammount($arr)
    {
        if(!empty($arr))
        {
            foreach($arr as $k=>$v)
            {
                $pay_amount_all[$k] = $v['price'];
            }
        }else{
            $pay_amount_all = array();
        }

        return array_sum($pay_amount_all);
    }
}