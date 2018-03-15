已开启......
<?php
    ignore_user_abort(true);
    set_time_limit(0);
    date_default_timezone_set('PRC'); // 切换到中国的时间
    $run_time = strtotime('+1 day'); // 定时任务第一次执行的时间是明天的这个时候
    $interval = 24*3600; // 每12个小时执行一次

    if(!file_exists('./cron-run.txt')) exit(); // 在目录下存放一个cron-run文件，如果这个文件不存在，说明已经在执行过程中了，该任务就不能再激活，执行第二次，否则这个文件被多次访问的话，服务器就要崩溃掉了

    do {
        if(!file_exists('./cron-switch.txt')) break; // 如果不存在cron-switch这个文件，就停止执行，这是一个开关的作用
        $gmt_time = microtime(true); // 当前的运行时间，精确到0.0001秒
        $loop = isset($loop) && $loop ? $loop : $run_time - $gmt_time; // 这里处理是为了确定还要等多久才开始第一次执行任务，$loop就是要等多久才执行的时间间隔
        $loop = $loop > 0 ? $loop : 0;
        if(!$loop) break; // 如果循环的间隔为零，则停止
        sleep($loop);
        // ...
        // 执行某些代码
        // ...*/
        $t=time()-2592000;
        $send_time = date("Y-m-d H:i:s",$t);
        $order_num = CTransaction::searchOrderSub_byWhere($send_time);
        foreach($order_num as $val)
        {
            if($val['logistics_type']==1){
                $post_data = array();
                $post_data["customer"] = '8186605F2FECB4187AAE01D1FA2CF993'; //快递100的东东
                $key= 'JVuHtyMQ8221';
                $post_data["param"] = json_encode(array(
                    'com'=>'shunfeng',
                    'num'=>$val['logistics_num'],
                ));
                $url='http://poll.kuaidi100.com/poll/query.do';
                $post_data["sign"] = md5($post_data["param"].$key.$post_data["customer"]);
                $post_data["sign"] = strtoupper($post_data["sign"]);
                $o="";
                foreach ($post_data as $k=>$v)
                {
                    $o.= "$k=".urlencode($v)."&";   //默认UTF-8编码格式
                }
                $post_data=substr($o,0,-1);
                $urls= $url.'?'.$post_data;

            }else if($val['logistics_type']==2){
                $com='kuayue';
                $urls = "http://api.kuaidi100.com/api?id=c3e24078b3048b18&com=$com&nu=$val[logistics_num]&valicode=&show=0&muti=1&order=desc";

            }else if($val['logistics_type']==3){
                $com='lianbangkuaidi';
                $urls = "http://api.kuaidi100.com/api?id=c3e24078b3048b18&com=$com&nu=$val[logistics_num]&valicode=&show=0&muti=1&order=desc";

            }else if($val['logistics_type']==0){
                echo "暂无快递信息";$urls=null;die;
            }
            $contents= file_get_contents($urls);
            $con_arr = json_decode($contents,ture);
            if($con_arr && $con_arr['state']==3)
            {
                if(CTransaction::updateOrder_receive($val['id'])&&CAdmin::updateNotice($val['order_id']='',$val['id'],6)) {
                    CSystem::opration(Yii::app()->session['manager'], Yii::app()->session['rolr_id'], 'order_sub', 'receive');
                }
            }
        }
        $all_user = CUser::searchAlluser();
        $score = 0;
        foreach ($all_user as $k=>$v)
        {
            $user_order = CUser::search_user_order($v['id']);
            foreach ($user_order as $key=>$val)
            {
                $refund_detail = CUser::search_order_refund($v['id'],$val['detail_id_str']);//退款的商品
                if(!empty($refund_detail))
                {
                    $refund_detail_id = implode(',',$refund_detail['id']);
                    $refund = CUser::search_order_detail_price($refund_detail_id,$refund_detail['number']);//退款商品价格
                }else{
                    $refund=0;
                }
                //改变用户积分
                $score +=($val['sub_price']-$refund);
                CUser::updateInfo_score($v['id'],floor($score/100));
            }
            $score=0;
        }
        CGift::add_gift($gift_name=1,$gift_portrait=1,$gift_score=1,$gift_stock=1);
        if(file_exists('./cron-run.txt'))
        unlink('./cron-run.txt'); // 这里就是通过删除cron-run来告诉程序，这个定时任务已经在执行过程中，不能再执行一个新的同样的任务
        $loop = $interval;

    } while(true);
?>


















