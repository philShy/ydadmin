<?php
/**
 * Class CArticle
 * @auth phil
 */
class CArticle
{
    //查找所有文章类别
    public static function searchArticle_cate()
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `article_category` WHERE is_delete=0 ')->queryAll();
        return $result;
    }
    //添加文章类别
    public static function addArticle_cate($name,$cate_sort,$introduce)
    {
        $create_time = date('Y-m-d H:i:s',time());
        $result = Yii::app()->db->createCommand('INSERT INTO `article_category` (`name`,`sort`,`introduce`,`create_time`)VALUES (:name,:sort,:introduce,:create_time)')
        ->bindValue(':name',$name)->bindValue(':sort',$cate_sort)->bindValue(':introduce',$introduce)->bindValue(':create_time',$create_time)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article_category','insert');
        return $result;
    }
    //添加文章
    public static function addArticle($cate,$article_title,$author,$article_img='',$content,$contact_goods_str,$contact_article_str,$recommend=0,$hit=0,$thumb=0,$states=0,$is_delete=0)
    {
        $create_time = date('Y-m-d H:i:s',time());
        Yii::app()->db->createCommand('INSERT INTO `article` (`article_category_id`,`title`,`author`,`article_img`,`content`,`contact_goods`,`contact_article`,`is_recommend`,`hit`,`thumb`,`states`,`is_delete`,`create_time`)VALUES (:article_category_id,:title,:author,:article_img,:content,:contact_goods,:contact_article,:is_recommend,:hit,:thumb,:states,:is_delete,:create_time)')
        ->bindValue(':article_category_id',$cate)->bindValue(':title',$article_title)->bindValue(':author',$author)
        ->bindValue(':article_img',$article_img)->bindValue(':content',$content)->bindValue(':contact_goods',$contact_goods_str)
        ->bindValue(':contact_article',$contact_article_str)->bindValue(':is_recommend',$recommend)->bindValue(':hit',$hit)
        ->bindValue(':thumb',$thumb)->bindValue(':states',$states)->bindValue(':is_delete',$is_delete)
        ->bindValue(':create_time',$create_time)->execute();
        $eid = Yii::app()->db->getLastInsertID();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article','insert');
        return $eid;
    }
 
    //向图片表插入文章图片信息
    public static function addarticle_images($articleId,$images_class_id)
    {
    	$create_time = date('Y-m-d H:i:s',time());
    	$result = Yii::app()->db->createCommand('INSERT INTO `images` (`images_class_id`,`pid`,`create_time`)
		VALUES (:images_class_id,:pid,:create_time)')
    	->bindParam(':images_class_id',$images_class_id)->bindParam(':pid',$articleid)->bindParam(':create_time',$create_time)->execute();
    	if($result)
    	{
    		CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','insert');
    	}
    	return $result;
    }
    //添加文章图片
    public static function addImg($path,$articleId,$sort)
    {
    	$create_time = date('Y-m-d H:i:s',time());
    	$result = Yii::app()->db->createCommand('INSERT INTO `images_article` (`image_url`,`article_id`,`sort`,`create_time`) VALUES (:image_url,:article_id,:sort,:create_time)')
    	->bindParam(':sort',$sort)->bindParam(':image_url',$path)
    	->bindParam(':article_id',$articleId)->bindParam(':create_time',$create_time)->execute();
    	if($result)
    	{
    		 CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','insert');
    	}
    	return $result;
    }
    public static function addimage($model_id,$images_class_id)
    {
    	$create_time = date('Y-m-d H:i:s',time());
    	$result = Yii::app()->db->createCommand('INSERT INTO `images` (`images_class_id`,`pid`,`create_time`)
		VALUES (:images_class_id,:pid,:create_time)')
    	->bindParam(':images_class_id',$images_class_id)->bindParam(':pid',$model_id)->bindParam(':create_time',$create_time)->execute();
    	if($result)
    	{
    		CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','insert');
    	}
    	return $result;
    		
    }
    //添加文章封面图
    public static function addArticleimg($desFilePath,$article_id)
    {
    
        $result = Yii::app()->db->createCommand('UPDATE `article` SET article_img=:article_img WHERE id=:id')
            ->bindParam(':article_img',$desFilePath)->bindParam(':id',$article_id)->execute();
        if($result)
        {
           CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','insert');
        }
        return $result;
    }
    public static function addBrandlogo($desFilePath,$brand_id,$images_class_id=2)
    {

    }
    //查找所有文章
    public static function searchAll_article()
    {
        $result = Yii::app()->db->createCommand('SELECT a.*,b.name FROM `article` a left join article_author b on a.author=b.id WHERE is_delete=0')->queryAll();
        return $result;
    }
    public static function searchAllarticle_bycate($param)
    {
        $result = Yii::app()->db->createCommand('SELECT a.*,b.name FROM `article` a left join article_author b on a.author=b.id WHERE article_category_id=:article_category_id AND is_delete=0')
        ->bindValue(':article_category_id',$param)->queryAll();
        return $result;
    }

    //查找不同类别下的文章通过文章类别id
    public static function searchArticle_bycateid($cate_id)
    {
        $result = Yii::app()->db->createCommand('SELECT a.*,b.name FROM `article` a left join article_author b on a.author=b.id WHERE is_delete=0 AND article_category_id=:article_category_id')
        ->bindValue(':article_category_id',$cate_id)->queryAll();
        return $result;
    }
    //修改文章状态
    public static function editArticlestate($article_id,$state)
    {
        $result = Yii::app()->db->createCommand('UPDATE `article` SET states=:state WHERE id=:id')
        ->bindParam(':state',$state)->bindParam(':id',$article_id)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article','update');
        return $result;
    }
    //删除文章
    public static function deleteArticle($article_id,$is_delete)
    {
        $result = Yii::app()->db->createCommand('UPDATE `article` SET is_delete=:is_delete WHERE id=:id')
        ->bindParam(':is_delete',$is_delete)->bindParam(':id',$article_id)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article','update');
        return $result;
    }
    //通过ID查找文章信息
    public static function searchArticle_byid($article_id)
    {
        $result = Yii::app()->db->createCommand('SELECT a.*,b.name FROM `article` a LEFT JOIN article_author b on a.author=b.id WHERE a.id=:id AND a.is_delete=0')
        ->bindparam(':id',$article_id)->queryRow();
        return $result;
    }
    //通过文章类别ID删除文章类别
    public static function deleteArticle_category($category_id,$is_delete)
    {
        $result = Yii::app()->db->createCommand('UPDATE `article_category` SET is_delete=:is_delete WHERE id=:id')
        ->bindParam(':is_delete',$is_delete)->bindParam(':id',$category_id)->execute();
       CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article_category','delete');
        return $result;
    }
    public static function searchCategor_byid($article_cateid)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `article_category` WHERE id=:id AND is_delete=0')
        ->bindparam(':id',$article_cateid)->queryRow();
        return $result;
    }
    //修改文章类别
    public static function editcategory_byid($article_cate_id,$cate_name,$introduce,$cate_sort)
    {
        $result = Yii::app()->db->createCommand('UPDATE `article_category` SET name=:name,introduce=:introduce,sort=:sort WHERE id=:id')
        ->bindParam(':name',$cate_name)->bindParam(':introduce',$introduce)
        ->bindParam(':sort',$cate_sort)->bindParam(':id',$article_cate_id)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article_category','update');
        return $result;
    }
    //修改文章
    public static function editArticle($article_id,$article_title,$author,$recommend,$cate,$content,$contact_goods_str,$contact_article_str,$hit,$thumb)
    {
        $create_time = date('Y-m-d H:i:s',time());
        $result = Yii::app()->db->createCommand('UPDATE `article` SET title=:title,author=:author,is_recommend=:is_recommend,article_category_id=:article_category_id,content=:content,contact_goods=:contact_goods,contact_article=:contact_article,create_time=:create_time,hit=:hit,thumb=:thumb WHERE id=:id')
        ->bindParam(':title',$article_title)->bindParam(':author',$author)
        ->bindParam(':is_recommend',$recommend)->bindParam(':article_category_id',$cate)->bindParam(':content',$content)
        ->bindParam(':contact_goods',$contact_goods_str)->bindParam(':contact_article',$contact_article_str)
        ->bindParam(':create_time',$create_time)->bindParam(':id',$article_id)
        ->bindParam(':hit',$hit)->bindParam(':thumb',$thumb)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article','update');
        return $result;
    }
    //模糊查询文章标题id
    public static function dimArticle($article_title)
    {
        $result = Yii::app()->db->createCommand()->select('id,title')->from('article')->where(array('like','title',"%$article_title%"))->queryAll();
        return $result;
    }
    public static function searchAuthor()
    {
    	$result = Yii::app()->db->createCommand('SELECT * FROM `article_author`')
    	->queryAll();
    	return $result;
    }
    //添加文章作者
    public static function addAuthor($author_name,$author_portrait)
    {
    	$create_time = date('Y-m-d H:i:s',time());
    	$result = Yii::app()->db->createCommand('INSERT INTO `article_author` (`name`,`author_portrait`,`create_time`)VALUES (:name,:author_portrait,:create_time)')
    	->bindValue(':name',$author_name)->bindValue(':author_portrait',$author_portrait)->bindValue(':create_time',$create_time)->execute();
    	$eid = Yii::app()->db->getLastInsertID();
    	 CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article_category','insert');
    	return $eid;
    }
    //查找作者信息
    public static function searchAuthor_byid($author_id)
    {
    	$result = Yii::app()->db->createCommand('SELECT * FROM `article_author` WHERE id=:id')
    	->bindparam(':id',$author_id)->queryRow();
    	return $result;
    }
    //编辑作者
    public static function editAuthor($id,$author_name,$author_portrait)
    {
    	$create_time = date('Y-m-d H:i:s',time());
    	$result = Yii::app()->db->createCommand('UPDATE `article_author` SET name=:name,author_portrait=:author_portrait,create_time=:create_time WHERE id=:id')
    	->bindParam(':name',$author_name)->bindParam(':author_portrait',$author_portrait)
    	->bindParam(':create_time',$create_time)->bindParam(':id',$id)->execute();
    	CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article_category','update');
    	return $result;
    }

}


























