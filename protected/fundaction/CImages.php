<?php
/**
 * Class CImages
 * @auto phil
 */
class CImages
{
    //查找所有图片类
    public static function searchImages()
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `images_class` where is_delete=0 ORDER BY id DESC ')->queryAll();
        return $result;
    }

    //添加图片类别
    public static function addImages($name,$introduce,$is_delete)
    {
        $create_time = date('Y-m-d H:i:s',time());
        $result = Yii::app()->db->createCommand('INSERT INTO `images_class` (`name`,`introduce`,`is_delete`,`create_time`)VALUES (:name,:introduce,:is_delete,:create_time)')
        ->bindValue(':name',$name)->bindValue(':introduce',$introduce)->bindValue(':is_delete',$is_delete)->bindValue(':create_time',$create_time)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images_class','insert');
        return $result;
    }

    //通过ID查找类别
    public static function searchImage_byid($id)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `images_class` WHERE id=:id and is_delete=0')->bindParam(':id',$id)->queryRow();
        return $result;
    }

    //通过ID修改类别
    public static function editImage($class_id,$name,$introduce,$is_delete)
    {
        $sql = "UPDATE `images_class` SET name=:name,introduce=:introduce,is_delete=:is_delete WHERE id=:id";
        $result = Yii::app()->db->createCommand($sql)->bindParam(':name',$name)->bindParam(':introduce',$introduce)
        ->bindParam(':is_delete',$is_delete)->bindParam(':id',$class_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images_class','update');
        return $result;
    }
    //通过ID修改类别状态
    public static function editImagestate($image_id,$is_delete)
    {
        $sql = "UPDATE `images_class` SET is_delete=:is_delete WHERE id=:id";
        $result = Yii::app()->db->createCommand($sql)
        ->bindParam(':is_delete',$is_delete)->bindParam(':id',$image_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images_class','update');
        return $result;
    }

    //通过ID删除类别
    public static function delImageclass($image_id)
    {
        $result = Yii::app()->db->createCommand("UPDATE `images_class` SET is_delete=0 WHERE id=:id")->bindParam(':id',$image_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images_class','delete');
        return $result;
    }

    
   
    //根据类型查询商品型号图片表中的图片
    public static function searchmodel_Imagecate($model_id)
    {
    	$result = Yii::app()->db->createCommand('SELECT * FROM `images_model` WHERE model_id=:model_id and is_delete=0 ORDER BY sort ASC ')->bindParam(':model_id',$model_id)->queryAll();
    	return $result;
    }
    //
    public static function searchImagebrand($brandid)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `brand` WHERE id=:brand_id ')->bindParam(':brand_id',$brandid)->queryRow();
        return $result;
    }
    //根据图片id查询图片详情
    public static function searchimages_Bypicid($picid)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `images_model` WHERE id=:id and is_delete=0 ')->bindParam(':id',$picid)->queryRow();
        return $result;
    }
    //根据图片id查询图片详情
    public static function searchimages_modelBypicid($picid)
    {
    	$result = Yii::app()->db->createCommand('SELECT * FROM `images_model` WHERE id=:id and is_delete=0 ')->bindParam(':id',$picid)->queryRow();
    	return $result;
    }
    //根据model_id查询该类型排序最大的图片
    public static function searchimages_Bymodelid($modelid)
    {
        $result = Yii::app()->db->createCommand("SELECT max(sort) maxArr FROM images WHERE model_id=:model_id and is_delete=0 ")->bindParam(':model_id',$modelid)->queryRow();
        return $result;
    }
    //根据model_id查询该类型排序最大的图片
    public static function searchimages_modelBymodelid($modelid)
    {
    	$result = Yii::app()->db->createCommand("SELECT max(sort) maxArr FROM images_model WHERE model_id=:model_id and is_delete=0 ")->bindParam(':model_id',$modelid)->queryRow();
    	return $result;
    }
    //根据model_id查询图片
    public static function searchimgs_Bymodelid($modelid)
    {
        $result = Yii::app()->db->createCommand("SELECT images_url FROM images WHERE model_id=:model_id and is_delete=0 ")->bindParam(':model_id',$modelid)->queryAll();
        return $result;
    }
    //
    public static function searchOne($modelid)
    {
        $result = Yii::app()->db->createCommand("SELECT image_url FROM images_model WHERE model_id=:model_id order by sort limit 1")->bindParam(':model_id',$modelid)->queryRow();
        return $result;
    }
    //根据条件查询符合图片
    public static function searchimages_Bywhere($modelid)
    {
        $result = Yii::app()->db->createCommand("SELECT id FROM images WHERE model_id=:model_id AND is_delete=0 ")
        ->bindParam(':model_id',$modelid)->queryAll();
        return $result;
    }
    //根据条件查询符合图片
    public static function searchimages_modelBywhere($modelid,$sort)
    {
    	$result = Yii::app()->db->createCommand("SELECT id,sort FROM images_model WHERE model_id=:model_id AND sort>:sort ")
    	->bindParam(':model_id',$modelid)->bindParam(':sort',$sort)->queryAll();
    	return $result;	
    }
    //更新图片顺序
    public static function updateimagesSort($picid,$sort)
    {
        $result = Yii::app()->db->createCommand("UPDATE `images` SET sort=:sort WHERE id=:id ")
        ->bindParam(':id',$picid)->bindParam(':sort',$sort)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','up');
        return $result;
    }
    //更新图片顺序
    public static function updatemodel_imagesSort($picid,$sort)
    {
    	$result = Yii::app()->db->createCommand("UPDATE `images_model` SET sort=:sort WHERE id=:id ")
    	->bindParam(':id',$picid)->bindParam(':sort',$sort)->execute();
    	$log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','up');
    	return $result;
    }
    //根据商品类型model_id 删除图片
    public static function delimages_Bymodelid($id)
    {
        $result = Yii::app()->db->createCommand("UPDATE images SET is_delete=1 WHERE model_id=:model_id ")
        ->bindParam(':model_id',$id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','delete');
        return $result;
    }
    //根据图片id 删除图片
    public static function delimages_Bypicid($id)
    {
        $result = Yii::app()->db->createCommand("UPDATE `images` SET is_delete=0 WHERE id=:id ")
        ->bindParam(':id',$id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','delete');
        return $result;
    }
    //根据图片id 删除图片
    public static function delimages_modelBypicid($id)
    {
    	$result = Yii::app()->db->createCommand("delete from `images_model` WHERE id=:id ")
    	->bindParam(':id',$id)->execute();
    	CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','delete');
    	return $result;
    }
    //根据商品类型id，商品类型图片顺序查找他上一个图片
    public static function searchupimages($model_id,$sort)
    {
        $result = Yii::app()->db->createCommand("SELECT id FROM images WHERE model_id=:model_id AND sort=:sort and is_delete=0 ")
        ->bindParam(':model_id',$model_id)->bindParam(':sort',$sort)->queryRow();
        return $result;
    }
    //根据商品类型id，商品类型图片顺序查找他上一个图片
    public static function searchupmodel_images($model_id,$sort)
    {
    	$result = Yii::app()->db->createCommand("SELECT id FROM images_model WHERE model_id=:model_id AND sort=:sort and is_delete=0 ")
    	->bindParam(':model_id',$model_id)->bindParam(':sort',$sort)->queryRow();
    	return $result;
    }
    public static function img_create_small($destination, $width, $height, $product_small)//原始大图地址，缩略图宽度，高度，缩略图地址
    {
        $imgage = getimagesize($destination); //得到原始大图片
        switch ($imgage[2]) {            // 图像类型判断
            case 1:
                $im = imagecreatefromgif($destination);
                break;
            case 2:
                $im = imagecreatefromjpeg($destination);
                break;
            case 3:
                $im = imagecreatefrompng($destination);
                break;
        }
        $src_W = $imgage[0]; //获取大图片宽度
        $src_H = $imgage[1]; //获取大图片高度

        $tn = imagecreatetruecolor($width, $height); //创建缩略图
        imagecopyresampled($tn, $im, 0, 0, 0, 0, 50, 50, $src_W, $src_H); //复制图像并改变大小
        imagejpeg($tn, $product_small); //输出图像
    }
    
    /**
     * 文章图片部分
     */
  	//查找比删掉图片顺序大的所有图片
  	public static function searcharticleimages_Bywhere($article_id,$sort)
  	{

  		$result = Yii::app()->db->createCommand('SELECT * FROM `images_article` WHERE article_id=:article_id and is_delete=0 and sort>:sort ORDER BY sort ASC ')
  		->bindParam(':article_id',$article_id)->bindParam(':sort',$sort)->queryAll();
  		return $result;
  	}
    //根据文章id查找所有文章图片
    public static function searchArticle_Byid($article_id)
    {
    	$result = Yii::app()->db->createCommand('SELECT * FROM `images_article` WHERE article_id=:article_id and is_delete=0 ORDER BY sort ASC ')->bindParam(':article_id',$article_id)->queryAll();
    	return $result;
    }
    
    //查找文章图片
    public static function searchImg($article_id)
    {
    	$result = Yii::app()->db->createCommand('SELECT sort FROM images_article WHERE article_id=:article_id AND is_delete=0')->bindParam(':article_id',$article_id)->queryAll();
    	return $result;
    }
    //添加文章图片
    public static function addImg($path,$article_id,$sort)
    {
    	$create_time = date('Y-m-d H:i:s',time());
    	$result = Yii::app()->db->createCommand('INSERT INTO `images_article` (`image_url`,`article_id`,`sort`,`create_time`) VALUES (:image_url,:article_id,:sort,:create_time)')
    	->bindParam(':sort',$sort)->bindParam(':image_url',$path)
    	->bindParam(':article_id',$article_id)->bindParam(':create_time',$create_time)->execute();
    	if($result)
    	{
    	     CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','insert');
    	}
    	return $result;
    }
    //根据图片id查询图片详情
    public static function searchimages_articleBypicid($picid)
    {
    	$result = Yii::app()->db->createCommand('SELECT * FROM `images_article` WHERE id=:id and is_delete=0 ')->bindParam(':id',$picid)->queryRow();
    	return $result;
    }
    //根据图片id 删除图片
    public static function delimages_articleBypicid($id)
    {
    	$result = Yii::app()->db->createCommand("delete from `images_article` WHERE id=:id ")
    	->bindParam(':id',$id)->execute();
    	CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','delete');
    	return $result;
    }
    //根据article_id查询该类型排序最大的图片
    public static function searchimages_articleByarticleid($article_id)
    {
    	$result = Yii::app()->db->createCommand("SELECT max(sort) maxArr FROM images_article WHERE article_id=:article_id and is_delete=0 ")->bindParam(':article_id',$article_id)->queryRow();
    	return $result;
    }
 
    //改变文章图片位置
    public static function updateimages_Byarticleid($id,$sort)
    {
    	$result = Yii::app()->db->createCommand("UPDATE `images_article` SET sort=:sort WHERE id=:id ")
    	->bindParam(':sort',$sort)->bindParam(':id',$id)->execute();
    	 CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','delete');
    	return $result;
    }
    //根据文章id，文章图片顺序查找他上一个图片
    public static function searchuparticle_images($article_id,$sort)
    {
    	$result = Yii::app()->db->createCommand("SELECT id FROM images_article WHERE article_id=:article_id AND sort=:sort and is_delete=0 ")
    	->bindParam(':article_id',$article_id)->bindParam(':sort',$sort)->queryRow();
    	return $result;
    }
    //更新文章图片顺序
    public static function updatearticle_imagesSort($picid,$sort)
    {
    	$result = Yii::app()->db->createCommand("UPDATE `images_article` SET sort=:sort WHERE id=:id ")
    	->bindParam(':id',$picid)->bindParam(':sort',$sort)->execute();
    	CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','up');
    	return $result;
    }

    /**
     * 文章图片部分结束
     */
    //改变商品图片位置
    public static function updateimages_Bymodelid($id,$sort)
    {
    	$result = Yii::app()->db->createCommand("UPDATE `images_model` SET sort=(sort-1) WHERE model_id=:model_id AND sort>:sort")
    	->bindParam(':sort',$sort)->bindParam(':model_id',$id)->execute();
    	CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','delete');
    	return $result;
    }
	 //查询商品轮播图
    public static function searchadver()
    {
    	$result = Yii::app()->db->createCommand("SELECT adver.*,goods_model.title,images_class.name,article.title AS titles FROM adver LEFT JOIN goods_model ON adver.model_id =goods_model.id LEFT JOIN images_class ON images_class.id = adver.images_class_id  LEFT JOIN article ON adver.article_id = article.id WHERE adver.images_class_id > 3;")->queryAll();
    	return $result;
    }
    
    //查找大于2的图片类型
    public static function searchimgsclassnames()
    {
    	$result = Yii::app()->db->createCommand("SELECT * FROM images_class WHERE id > 3")->queryAll();
    	return $result;
    }
    //添加轮播图信息
    public static function addadv($names,$img,$sort,$goods_id,$images_class_id,$adressurl,$is_delete)
    {
    	
    	/*$resultsort = CProduct::searchSort($sort);
    	 var_dump($resultsort);
    	 $resultname = CProduct::searchBrand($brandname);
    	 var_dump($resultname);die;*/
    	$data = date("Y-m-d H:i:s");
    	$result = Yii::app()->db->createCommand('INSERT INTO `adver` (`names`,`images_url`,`sort`,`model_id`,`images_class_id`,`adressurl`,`create_time`,`is_delete`) VALUES (:names,:images_url,:sort,:model_id,:images_class_id,:adressurl,:create_time,:is_delete)')->bindParam(':images_url',$img)->bindParam(':create_time',$data)->bindParam(':names',$names)->bindParam(':adressurl',$adressurl)->bindParam(':sort',$sort)->bindParam(':model_id',$goods_id)->bindParam(':images_class_id',$images_class_id)->bindParam(':is_delete',$is_delete)->execute();
    	$eid = Yii::app()->db->getLastInsertID();
    	return $eid;
    }
    public static function addadvb($names,$img,$sort,$article_id,$images_class_id,$addressurl,$is_delete)
    {
    	 
    	/*$resultsort = CProduct::searchSort($sort);
    	 var_dump($resultsort);
    	 $resultname = CProduct::searchBrand($brandname);
    	 var_dump($resultname);die;*/
    	$data = date("Y-m-d H:i:s");
    	$result = Yii::app()->db->createCommand('INSERT INTO `adver` (`names`,`sort`,`sort`,`article_id`,`images_class_id`,`adressurl`,`create_time`,`is_delete`) VALUES (:names,:images_url,:sort,:article_id,:images_class_id,:adressurl,:create_time,:is_delete)')->bindParam(':images_url',$img)->bindParam(':create_time',$data)->bindParam(':names',$names)->bindParam(':adressurl',$addressurl)->bindParam(':sort',$sort)->bindParam(':article_id',$article_id)->bindParam(':images_class_id',$images_class_id)->bindParam(':is_delete',$is_delete)->execute();
    	$eid = Yii::app()->db->getLastInsertID();
    	return $eid;
    }
    public static function addadva($names,$img,$sort,$advters,$images_class_id,$is_delete)
    {
    
    	/*$resultsort = CProduct::searchSort($sort);
    	 var_dump($resultsort);
    	 $resultname = CProduct::searchBrand($brandname);
    	 var_dump($resultname);die;*/
    	$data = date("Y-m-d H:i:s");
    	$result = Yii::app()->db->createCommand('INSERT INTO `adver` (`names`,`images_url`,`sort`,`adressurl`,`images_class_id`,`create_time`,`is_delete`) VALUES (:names,:images_url,:sort,:adressurl,:images_class_id,:create_time,:is_delete)')->bindParam(':images_url',$img)->bindParam(':create_time',$data)->bindParam(':names',$names)->bindParam(':sort',$sort)->bindParam(':adressurl',$advters)->bindParam(':images_class_id',$images_class_id)->bindParam(':is_delete',$is_delete)->execute();
    	$eid = Yii::app()->db->getLastInsertID();
    	return $eid;
    }
    
    //按条件查找轮播图
    public static function searchadvnames($names)
    {
    	$result = Yii::app()->db->createCommand('SELECT  FROM `adver` WHERE names=:names')->bindParam(':names',$names)->queryRow();
    	return $result;
    }
    
    public static function searchadvisdelete($is_delete)
    {
    	$result = Yii::app()->db->createCommand('SELECT  FROM `adver` WHERE is_delete=:is_delete')->bindParam(':is_delete',$is_delete)->queryRow();
    	return $result;
    }
    public static function searchadvsort($sort)
    {
    	$result = Yii::app()->db->createCommand('SELECT  FROM `adver` WHERE sort=:sort')->bindParam(':sort',$sort)->queryRow();
    	return $result;
    }
    public static function searchadvgoodsid($goods_id)
    {
    	$result = Yii::app()->db->createCommand('SELECT  FROM `adver` WHERE goods_id=:goods_id')->bindParam(':goods_id',$goods_id)->queryRow();
    	return $result;
    }
    public static function searchadvimagesclassid($images_class_id)
    {
    	$result = Yii::app()->db->createCommand('SELECT  FROM `adver` WHERE images_class_id=:images_class_id')->bindParam(':images_class_id',$images_class_id)->queryRow();
    	return $result;
    }
    
    //根据id查找轮播图
    public static function searchadvpivbyid($id)
    {
    	$result = Yii::app()->db->createCommand('SELECT * FROM `adver` WHERE id=:id')->bindParam(':id',$id)->queryRow();
    	return $result;
    }
    
    //添加轮播图片
    public static function addadvpic($desFilePath,$advid,$images_class_id)
    {
    	$result = Yii::app()->db->createCommand('INSERT INTO `images` (`images_url`,`adv_id`,`images_class_id`) VALUES (:images_url,:adv_id,:images_class_id)')->bindParam(':images_url',$desFilePath)->bindParam(':adv_id',$advid)->bindParam(':images_class_id',$images_class_id)->execute();
    	return $result;
    }
    
    //修改轮播图片
    public static function editadvpic($advid,$images_url)
    {
    	$result = Yii::app()->db->createCommand('UPDATE adver SET images_url = :images_url WHERE id = :adv_id')->bindParam(':images_url',$images_url)->bindParam(':adv_id',$advid)->execute();
    	return $result;
    }
    
    //修改轮播图详情
    public static function editadvbyid($advid,$names,$sort,$is_delete)
    {
    	$sql = "UPDATE adver SET names=:names,sort=:sort,is_delete=:is_delete WHERE id=:id";
    	$result = Yii::app()->db->createCommand($sql)->bindParam(':id',$advid)->bindParam(':names',$names)->bindParam(':sort',$sort)->bindParam(':is_delete',$is_delete)->execute();
    	return $result;
    		
    }
    //删除轮播图
    public static function deladvpic($adv_id)
    {
    	$result = Yii::app()->db->createCommand("DELETE FROM `adver` WHERE id=:id")->bindParam(':id',$adv_id)->execute();
    	return $result;
    }
    
    
    
    //修改广告状态
    public static function editadverstatebyid($adv_id,$is_delete)
    {
    	$sql = "UPDATE adver SET is_delete=:is_delete WHERE id=:id";
    	$result = Yii::app()->db->createCommand($sql)->bindParam(':id',$adv_id)->bindParam(':is_delete',$is_delete)->execute();
    	return $result;
    }
  
    //按图片类型查询adver图片
    public static function search_Bywhere($advp)
    {
    	
    	$sql = "SELECT adver.*,goods_model.title,images_class.name FROM adver LEFT JOIN goods_model ON adver.model_id =goods_model.id LEFT JOIN images_class ON images_class.id = adver.images_class_id  WHERE adver.$advp";
    	$result = Yii::app()->db->createCommand($sql)->queryAll();
    	return $result;
    }
    
    
    //查询文章
    public static function searcharticle()
    {
    	$result = Yii::app()->db->createCommand('SELECT * FROM article ')->queryAll();
    	return $result;
    }
    //按id查文章图
    
    public static function searchatticlecate($article_id)
    {
    	$result = Yii::app()->db->createCommand('SELECT * FROM `images` WHERE article_id=:article_id && sort IS NOT NULL ORDER BY sort ASC ')->bindParam(':article_id',$article_id)->queryAll();
    	return $result;
    }
    //按id查文章封面图
    
    public static function searchatticlecates($article_id)
    {
    	$result = Yii::app()->db->createCommand('SELECT * FROM `images` WHERE article_cover=1 && article_id = :article_id;')->bindParam(':article_id',$article_id)->queryAll();
    	return $result;
    }
    //根据id查找轮播图
    public static function searcharticlebyid($id)
    {
    	$result = Yii::app()->db->createCommand('SELECT * FROM `article` WHERE id=:article_id')->bindParam(':article_id',$id)->queryRow();
    	return $result;
    }
    
   public static function searchpdfById($id){
   	$result = Yii::app()->db->createCommand('SELECT * FROM pdf where id=:id')->bindParam(':id',$id)->queryRow();
   	return $result;
   }
    
    ///////////////////////////////////////////////////////////////
   //修改，添加分类logo
   public static function editcatelogobyid($cate_id,$new_img){
   	$result = Yii::app()->db->createCommand('UPDATE `goods_classfiy` SET image_url=:image_url WHERE id=:id')->bindParam(':image_url',$new_img)->bindParam(':id',$cate_id)->execute();
   	return $result;
   }
     public static function editcatelogobyids($cate_id,$new_img){
   	$result = Yii::app()->db->createCommand('UPDATE `goods_classfiy` SET image_url1=:image_url WHERE id=:id')->bindParam(':image_url',$new_img)->bindParam(':id',$cate_id)->execute();
   	return $result;
   }

    public static function editarticalpic($images_url,$id)
    {
    	$result = Yii::app()->db->createCommand('UPDATE article SET article_img = :images_url WHERE id = :adv_id')->bindParam(':images_url',$images_url)->bindParam(':adv_id',$id)->execute();
    	return $result;
    }
    public static function pdflist($page,$size)
    {
        $result = Yii::app()->db->createCommand('SELECT name,id FROM `goods` ORDER BY id DESC LIMIT :page,:size')
            ->bindValue(':page',(int)($page-1)*$size)->bindValue(':size',(int)$size)->queryAll();
        return $result;
    }
    public static function pdflist_num()
    {
        $result = Yii::app()->db->createCommand('SELECT count(id) as num FROM `goods`')->queryRow();
        return $result['num'];
    }
    public static function searcPdf_byGoodsId($goods_id)
    {
        $result = Yii::app()->db->createCommand('SELECT pdf_name,url FROM `pdf` where goods_id=:goods_id ORDER BY sort')
            ->bindParam(':goods_id',$goods_id)->queryAll();
        return $result;
    }
    public static function searcPdf_byGoodsId1($goods_id)
    {
        $result = Yii::app()->db->createCommand('SELECT pdf_name,id as pdf_id,url,sort FROM `pdf` where goods_id=:goods_id ORDER BY sort')
            ->bindParam(':goods_id',$goods_id)->queryAll();
        return $result;
    }
    public static function searchPdfOne_byGoodsId($goods_id)
    {
        $result = Yii::app()->db->createCommand('SELECT id,name FROM `goods` where id=:goods_id;')
            ->bindParam(':goods_id',$goods_id)->queryRow();
        $result['pdf'] = self::searcPdf_byGoodsId1($goods_id);
        return $result;
    }

    public static function searchPdf_bypPdfId($pdf_id)
    {
        $result = Yii::app()->db->createCommand('SELECT url FROM `pdf` where id=:pdf_id;')
            ->bindParam(':pdf_id',$pdf_id)->queryRow();
        return $result;
    }
    //删除pdf
    public static function delpdf($pdf_id)
    {
        $result = Yii::app()->db->createCommand("DELETE FROM `pdf` WHERE id=:id")->bindParam(':id',$pdf_id)->execute();
        return $result;
    }
	//通过cateid 查找类别名称
        public static function searchcate_Byid($id)
        {
                $result = Yii::app()->db->createCommand('SELECT id,name,image_url,image_url1 FROM `goods_classfiy` WHERE id=:id AND is_delete=0')->bindParam(':id',$id)->queryRow();
                return $result;
        }
    //根据goods_id查询最大的pdf
    public static function searchMaxPdf_byGoodsId($goods_id)
    {
        $result = Yii::app()->db->createCommand('SELECT max(sort) maxSort FROM `pdf` where goods_id=:goods_id;')
            ->bindParam(':goods_id',$goods_id)->queryRow();
        return $result['maxSort'];
    }
    //改变pdf sort
    public static function updataPdfSort_byWhere($goods_id,$sort)
    {
        $res = Yii::app()->db->createCommand('UPDATE pdf SET sort=(sort-1) WHERE goods_id=:goods_id AND sort>:sort')
            ->bindParam(':sort',$sort)->bindParam(':goods_id',$goods_id)->execute();
        return $res;
    }
    public static function searchPdf_byWhere($goods_id,$sort)
    {
        $sort=$sort-1;
        $result = Yii::app()->db->createCommand('SELECT id FROM `pdf` where goods_id=:goods_id AND sort=:sort')
            ->bindParam(':goods_id',$goods_id)->bindParam(':sort',$sort)->queryRow();
        return $result['id'];
    }
    public static function moveUpPdfSort_byWhere($goods_id,$pdfid,$sort)
    {
        $sort_up=$sort-1;
        $dwon_id = self::searchPdf_byWhere($goods_id,$sort);//下移的pdf_id
        $res_dwon = Yii::app()->db->createCommand('UPDATE pdf SET sort=:sort WHERE id=:id')
            ->bindParam(':sort',$sort)->bindParam(':id',$dwon_id)->execute();
        $res_up = Yii::app()->db->createCommand('UPDATE pdf SET sort=:sort WHERE id=:id')
            ->bindParam(':sort',$sort_up)->bindParam(':id',$pdfid)->execute();
        return $res_up;
    }
    public static function searchGoodsPdf_likeGoodsName($goods_name,$page,$size)
    {
        $sql = "SELECT name,id FROM goods WHERE name LIKE '%$goods_name%' ORDER BY id DESC LIMIT :page,:size";
        $result = Yii::app()->db->createCommand($sql)->bindValue(':page',(int)($page-1)*$size)->bindValue(':size',(int)$size)->queryAll();
        return $result;
    }
    public static function searchGoodsPdfNum_likeGoodsName($goods_name)
    {
        $sql = "SELECT count(id) as num FROM goods WHERE name LIKE '%$goods_name%'";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        return $result['num'];
    }
}