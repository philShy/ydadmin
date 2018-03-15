<?php
class EditAction extends CAction
{
    public function run()
    {
        $article_id = Yii::app()->request->getParam('id');
        $article_title = Yii::app()->request->getParam('title');
        //$introduce = Yii::app()->request->getParam('introduce');
        $author = Yii::app()->request->getParam('author');
        $recommend = Yii::app()->request->getParam('recommend');
        $cate = Yii::app()->request->getParam('cate');
        $content = Yii::app()->request->getParam('content');
        $hit = Yii::app()->request->getParam('hit');
        $thumb = Yii::app()->request->getParam('thumb');
        $contact_goods_str = Yii::app()->request->getParam('contact_goods_str');
        $contact_article_str = Yii::app()->request->getParam('contact_article_str');
        $contact_goods = Yii::app()->request->getParam('contact_goods');
        $contact_article = Yii::app()->request->getParam('contact_article');
         $g= explode(",", $contact_goods_str);  
        $a=explode(",",$contact_article_str);
        $g=array_filter($g);
        $a=array_filter($a);
        
        $contacts_goods_str=implode(",", $g) ;
        $contacts_article_str=implode(",", $a) ;
        if($article_id)
        {
            $article_one = CArticle::searchArticle_byid($article_id);
        }
        if($_POST)
        {
        	//var_dump($_POST);die;
            $res=$articleId = CArticle::editArticle($article_id,$article_title,$author,$recommend,$cate,$content,$contacts_goods_str,$contacts_article_str,$hit,$thumb);
            if($res)
            {
                  Yii::success("修改文章成功",Yii::app()->createUrl('../article/list'),"1");die;
            }
        }
        $cate_arr = CArticle::searchArticle_cate();
        $author_arr = CArticle::searchAuthor();
        $this->controller->layout = false;
        $this->controller->render('edit',array('article_one'=>$article_one,'cate_arr'=>$cate_arr,'author_arr'=>$author_arr));
    }
}