<?php
class AddAction extends CAction
{
    public function run()
    {
        $article_title = Yii::app()->request->getParam('title');
        $introduce = Yii::app()->request->getParam('introduce');
        $author = Yii::app()->request->getParam('author');
        $recommend = Yii::app()->request->getParam('recommend');
        $cate = Yii::app()->request->getParam('cate');
        $content = Yii::app()->request->getParam('content');
        $hit = Yii::app()->request->getParam('hit');
        $thumb = Yii::app()->request->getParam('thumb');
        $contact_goods_str = Yii::app()->request->getParam('contact_goods_str');
     	$contact_article_str = Yii::app()->request->getParam('contact_article_str');
        $g= explode(",", $contact_goods_str);  
        $a=explode(",",$contact_article_str);
        $g=array_filter($g);
        $a=array_filter($a);
        
        $contacts_goods_str=implode(",", $g) ;
        $contacts_article_str=implode(",", $a) ;
        $contact_article = Yii::app()->request->getParam('contact_article');
        
		$contact_goods = Yii::app()->request->getParam('contact_goods');
				$mark = Yii::app()->request->getParam('mark');
		/*如果有商品名传入*/
		if($contact_goods && $mark)
		{
			//模糊查询商品名称
			$result = CProduct::search_model_name_bylike($contact_goods);
			if(!empty($result))
			{
				echo json_encode($result);die;
			}else{
				echo '';die;
			}
			
		}
		

		$goods_model_id =Yii::app()->request->getParam('goods_model_id');
    	if(!empty($goods_model_id))
		{			
			//echo json_encode($goods_model_id);die;
			$goods_sku=CProduct::searchsku_bymodelid($goods_model_id);
			
			echo json_encode($goods_sku);die;

			
			
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		/*如果有文章名传入*/
		if($contact_article && $mark)
		{
			//模糊查询文章名称
			$result = CArticle::dimArticle($contact_article);
			if(!empty($result))
			{
				echo json_encode($result);die;
			}else{
				echo '';die;
			}
		}
        if($article_title && $author && $content && $cate)
        {
        	
        	//echo $cate.'-'.$article_title.'-'.$author.'-'.$article_img.'-'.$content.'-'.$contact_goods_str.'-'.$contact_article_str.'-'.$recommend.'-'.$hit.'-'.$thumb.'-'.$states.'-'.$is_delete;die;
            $articleId = CArticle::addArticle($cate,$article_title,$author,$article_img,$content,$contacts_goods_str,$contacts_article_str,$recommend,$hit,$thumb,$states=0,$is_delete=0);
            if($_FILES)
            {
			
                $img_url = Yii::app()->request->hostInfo.'/images/articalss/';
                $img_path = 'images/articalss/';
                /*$_FILES1['down'] = $_FILES['down'];
                $_FILES2['file'] = $_FILES['file'];
                var_dump($_FILES1);
                var_dump($_FILES2);*/
                $path = CUploadimg::uploadFile($img_path);
                $imgae_res = CArticle::addimage($articleId,$images_class_id=3);
                if($imgae_res && $path)
                {
                    foreach($path as $key=>$value)
                    {
                        $sort=$key+1;
						
                        $res = CArticle::addImg($img_url.$value['name'],$articleId,$sort);
                    }
                    $article_cover = CUploadarticleimg::uploadarticleimg($articleId,$img_url);
					var_dump($article_cover);die;
                    if($res&&$article_cover)
                    {
                        Yii::success("添加文章成功",Yii::app()->createUrl('../article/list'),"1");die;
                    } 
                }
            }
        }
        $goods_cate_arr = CProduct::searchCateall();
        $author_arr = CArticle::searchAuthor();
        $cate_arr = CArticle::searchArticle_cate();
        $this->controller->layout = false;
        $this->controller->render('add',array('cate_arr'=>$cate_arr,'author_arr'=>$author_arr,'goods_cate_arr'=>$goods_cate_arr));
    }
}