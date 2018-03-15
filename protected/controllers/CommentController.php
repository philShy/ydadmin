<?php
class CommentController extends Controller{

    public function actions(){
        return array(
            'comment_article'=>'application.controllers.comment.Comment_articleAction',
        	'comment_goods'=>'application.controllers.comment.Comment_goodsAction',
        	'comment_article_info'=>'application.controllers.comment.Comment_article_infoAction',
        	'comment_goods_info'=>'application.controllers.comment.Comment_goods_infoAction',
        );
    }
}