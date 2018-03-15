<?php
class Comment_goods_infoAction extends CAction
{
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
        $comment_id = Yii::app()->request->getParam('id');
        $state = Yii::app()->request->getParam('state');
        $is_delete = Yii::app()->request->getParam('is_delete');
        $floor_id = Yii::app()->request->getParam('floor_id');
        $reply = Yii::app()->request->getParam('reply');
        $sign = Yii::app()->request->getParam('sign');
        if($reply)
        {
            //添加回复
            $reply_res = CComment::add_reply($comment_id,$reply,$sign);
            if($reply_res)
            {
                CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'order_commentx','insert');
                echo $reply_res;die;
            }


        }
        if($state == 1 && $floor_id)
        {
            //评论不通过
            $res = CComment::editArticle_comment_floor_state($floor_id, $state);
            echo $res;die;
        }
        if($state == '0' && $floor_id)
        {
            //评论通过
            $res = CComment::editArticle_comment_floor_state($floor_id, $state);
            echo $res;die;
        }
        if($is_delete == 1 && $floor_id)
        {
            //删除评论
            $res = CComment::delArticle_comment_floor_state($floor_id, $is_delete);
            echo $res;die;
        }
        $floors_info = CComment::searchGoods_oneCommentid($comment_id);
        /*echo '<pre>';
        var_dump($floors_info);die;*/
        $this->controller->layout = false;
        $this->controller->render('comment_goods_info',array('floors_info'=>$floors_info));
    }
}