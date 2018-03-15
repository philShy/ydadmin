<?php
/**
 * Class CComment
 * auth @phil
 */
class CComment
{
    //查询所有文章评论
    public static function searchArticle_comment($where='')
    {
    	$result = Yii::app()->db->createCommand("SELECT a.*,b.name,c.title
    			FROM `article_comment` a
    			LEFT JOIN `user` b ON a.user_id=b.id
    			LEFT JOIN `article` c ON a.article_id = c.id
    			WHERE $where a.is_delete=0 AND c.is_delete=0")->queryAll();

        return $result;
    }
    //查询楼层评论信息
    public static function select_floors_bycommentid($comment_id)
    {
    	$result = Yii::app()->db->createCommand("SELECT a.comment,a.create_time,b.name,b.portrait
    			FROM `article_comment` a LEFT JOIN `user` b ON a.user_id = b.id WHERE a.id=:id")
    	->bindParam(':id',$comment_id)->queryRow();
    	return $result;
    }
    //查询所有楼层评论
    public static function searchArticle_comment_user()
    {
    	$result = Yii::app()->db->createCommand("SELECT count(id) as count FROM `article_comment_user` WHERE is_delete=0")
    	->queryRow();
    	return $result;
    }
    //查询用户信息
    public static function search_user_info_byuserid($user_id)
    {
    	$result = Yii::app()->db->createCommand("SELECT * FROM `user` WHERE id=:id")
    	->bindParam(':id',$user_id)->queryRow();
    	return $result;
    }
    //查询楼层下的所有评论
    public static function select_comment_info_all_bycommentid($comment_id)
    {
    	$result = Yii::app()->db->createCommand("SELECT * FROM `article_comment_user` WHERE article_comment_id=:article_comment_id and is_delete=0")
    	->bindParam(':article_comment_id',$comment_id)->queryAll();
    	return $result;
    }
    
    //更改文章评论状态
    public static function editArticle_commentstate($comment_id,$state)
    {
        $result = Yii::app()->db->createCommand('UPDATE `article_comment` SET state=:state WHERE id=:id')
        ->bindParam(':state',$state)->bindParam(':id',$comment_id)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article_comment','update');
        return $result;
    }
    //改变楼层内评论状态
    public static function editArticle_comment_floor_state($floor_id, $state)
    {
    	$result = Yii::app()->db->createCommand('UPDATE `article_comment_user` SET state=:state WHERE id=:id')
    	->bindParam(':state',$state)->bindParam(':id',$floor_id)->execute();
    	return $result;
    }
    //删除文章评论
    public static function deleteArticle_comment($comment_id,$is_delete)
    {

        $result = Yii::app()->db->createCommand('UPDATE `article_comment` SET is_delete=:is_delete WHERE id=:id')
        ->bindParam(':is_delete',$is_delete)->bindParam(':id',$comment_id)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article_comment','delete');
        return $result;
    }
    //删除楼层内评论
    public static function delArticle_comment_floor_state($floor_id,$is_delete)
    {
    
    	$result = Yii::app()->db->createCommand('UPDATE `article_comment_user` SET is_delete=:is_delete WHERE id=:id')
    	->bindParam(':is_delete',$is_delete)->bindParam(':id',$floor_id)->execute();
    	return $result;
    }
    //查询单个用户信息
    public static function seachOneuser($id)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `user` WHERE id=:id")->bindParam(':id',$id)->queryRow();
        return $result;
    }

    //查询收件人信息
    public static function searchReceiver($user_id)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `user_address` WHERE user_id=:user_id AND is_default=1")
            ->bindParam(':user_id',$user_id)->queryRow();
        return $result;
    }
    //查询符合条件的评论
    public static function Articlecomment_where($article_arr,$datetime)
    {
        $result = Yii::app()->getDb()->createCommand();
        $result->select('a.*,b.name,c.title');
        $result->from('article_comment a');
        $result->join('user b','a.user_id=b.id');
        $result->join('article c','a.article_id=c.id');
        if($article_arr)
        {
            $result->andWhere(array('in','a.article_id', $article_arr));
        }
        if($datetime)
        {
            $result->andWhere("a.create_time<'$datetime'");
        }
        $result ->andWhere('c.is_delete=0');
        $list =$result ->queryAll();
        return $list;
    }
    //查询所有评论
    public static function searchGoods_comment()
    {
        $result = Yii::app()->db->createCommand("SELECT a.*,b.name,c.title
    			FROM `order_commentx` a
    			LEFT JOIN `user` b ON a.user_id=b.id
    			LEFT JOIN `goods_model` c ON a.goods_model_id = c.id
    			WHERE a.is_delete=0 AND c.is_delete=0")->queryAll();
        return $result;
    }
    //查询所有评论
    public static function searchGoods_oneCommentid($comment_id)
    {
        $result = Yii::app()->db->createCommand("SELECT a.*,b.name,b.portrait
    		FROM `order_commentx` a LEFT JOIN `user` b ON a.user_id = b.id WHERE a.id=:id")
            ->bindParam(':id',$comment_id)->queryRow();
        return $result;
    }
    //添加商家评论
    public static function add_reply($id,$reply,$sign)
    {
        $create_time = date('Y-m-d H:i:s',time());
        if($sign == '1')
        {
            $result = Yii::app()->db->createCommand('UPDATE `order_commentx` SET one_reply=:one_reply,one_reply_time=:one_reply_time WHERE id=:id')
                ->bindValue(':one_reply',$reply)->bindValue(':one_reply_time',$create_time)->bindValue(':id',$id)->execute();
            Yii::app()->db->getLastInsertID();
        }else{
            $result = Yii::app()->db->createCommand('UPDATE `order_commentx` SET two_reply=:two_reply,two_reply_time=:two_reply_time WHERE id=:id')
                ->bindValue(':two_reply',$reply)->bindValue(':two_reply_time',$create_time)->bindValue(':id',$id)->execute();
            Yii::app()->db->getLastInsertID();
        }

        return $result;
    }
    //删除商品评论
    public static function deleteGoods_comment($comment_id,$is_delete)
    {

        $result = Yii::app()->db->createCommand('UPDATE `order_commentx` SET is_delete=:is_delete WHERE id=:id')
            ->bindParam(':is_delete',$is_delete)->bindParam(':id',$comment_id)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article_comment','delete');
        return $result;
    }
}