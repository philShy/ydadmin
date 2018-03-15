<?php
class Editarticle_imagesAction extends CAction
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

        $id = Yii::app()->request->getParam('id');
        $title = Yii::app()->request->getParam('title');
        $article_id = Yii::app()->request->getParam('article_id');
        $articleid = Yii::app()->request->getParam('articleid');
        $picid = Yii::app()->request->getParam('picid');
        $sort = Yii::app()->request->getParam('sort');
        $mark = Yii::app()->request->getParam('mark');
        if($id){
            if($_FILES['proImg'])
            {
                $img_url = Yii::app()->request->hostInfo.'/images/article/';
                $img_path = 'images/article';
                $path = CUploadimg::uploadFile($img_path);
                if($path)
                {
                	
                    $imgid =  CImages::searchImg($id);
                    if(!empty($imgid))
                    {
                        foreach($imgid as $k=>$v)
                        {
                            $arr[] = $v['sort'];
                        };
                        $max_id = array_search(max($arr), $arr);
                        foreach($path as $key=>$value)
                        {
                            $sort = $key+$arr[$max_id]+1;
                            $re[] = CImages::addImg($img_url.$value['name'],$id,$sort);
                        }
                        if($re)
                        {
                            Yii::success("修改成功",Yii::app()->createUrl('../images/image_article'),"1");die;
                        }
                    }else{
                	
                        foreach($path as $key=>$value)
                        {
                            $sort = $key+1;
                            $re[] = CImages::addImg($img_url.$value['name'],$id,$sort);
                        }
                        if($re)
                        {
                            Yii::success("修改成功",Yii::app()->createUrl('../images/image_article'),"1");die;
                        }
                    }

                }
            }

        }
        if($article_id){
            $article_images = CImages::searchArticle_Byid($article_id);
            
        }
        if($mark=='del' && $articleid && $picid)
        {
            $img =  CImages::searchimages_articleBypicid($picid);
           	
			$arr=explode("/", $img['image_url']);
			$last=$arr[count($arr)-1];
			
            $result = CImages::delimages_articleBypicid($picid);
            if (file_exists("images/article/" .$last)) {
                unlink("images/article/" .$last);
            }
            if($result)
            {
                $maxArr = CImages::searchimages_articleByarticleid($articleid);
  
                if($img['sort']<$maxArr)
                {
                	//如果删掉的图片顺序小于最大的图片顺序，则比删掉图片顺序大的图片顺序全部向前移一位
                	//1.查找比删掉图片顺序大的所有图片
                    $imgs = CImages::searcharticleimages_Bywhere($articleid,$img['sort']);
                    foreach ($imgs as $_img)
                    {//2.顺序前进1位
                        $re[] = CImages::updateimages_Byarticleid($_img['id'],$_img['sort']-1);
                    }
                    echo 1;die;
                }
            }
        }
        if($mark=='moveup' && $articleid && $picid && $sort)
        {
            $upsort=$sort-1;
            $upid = CImages::searchuparticle_images($articleid,$upsort)['id'];
            $new1 = CImages::updatearticle_imagesSort($picid,$upsort);
            $new2 = CImages::updatearticle_imagesSort($upid,$sort);
            if($new1 && $new2)
            {
                 echo 1;die;
            }
        } 
        $this->controller->layout = false;
        $this->controller->render('editarticle_images',array('article_id'=>$article_id,'title'=>$title,'article_images'=>$article_images));
    }
}