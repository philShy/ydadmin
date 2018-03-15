<?php
class AddAction extends CAction
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
        $catid = Yii::app()->request->getParam('catid');
        $goodsid = Yii::app()->request->getParam('goodsid');
        $sort = Yii::app()->request->getParam('sort');
        $mark = Yii::app()->request->getParam('mark');
        if($sort && $mark)
        {
        	$video_sort = CVideo::searchvideo_sort_bysort($video_id,$sort);
        	if($video_sort)
        	{
        		echo 1;die;
        	}else{
        		echo 2;die;
        	}
        }
        $img_url = Yii::app()->request->hostInfo.'/video/home_cover/';
        $img_path = 'video/home_cover/';
        $video_url = Yii::app()->request->hostInfo.'/video/home/';
        $video_path = 'video/home';
        if(!file_exists($img_path))
        {
        	mkdir($img_path,777,true);
        }
        if($catid)
        {
        	$goods_arr = CProduct::searchGoods($catid);
        	echo json_encode($goods_arr);die;
        }
        if($goodsid)
        {
        	$model_arr = CProduct::searchModels($goodsid);
        	echo json_encode($model_arr);die;
        }
        if($_POST && $_FILES)
        {
        	if($_FILES['video_cover'])
        	{
        		//上传封面
        	
	        	if ((($_FILES["video_cover"]["type"] == "image/gif")
	    				|| ($_FILES["video_cover"]["type"] == "image/jpeg")
	    				|| ($_FILES["video_cover"]["type"] == "image/pjpeg")
	    				|| ($_FILES["video_cover"]["type"] == "image/png")
	    				|| ($_FILES["video_cover"]["type"] == "image/gif"))
	    				&& ($_FILES["video_cover"]["size"] < 2000000))
	    		{
	    			if ($_FILES["video_cover"]["error"] > 0)
	    			{
	    				
	    				echo "Error: " . $_FILES["video_cover"]["error"] . "<br />";
	    				
	    			}
	    			else
	    			{
	    				$res = move_uploaded_file($_FILES["video_cover"]["tmp_name"],$img_path.$_FILES["video_cover"]["name"]);
	    				if($res)
	    				{
	    					$author_portrait = $img_url . $_FILES["video_cover"]["name"];
	    				}
	    			}
	    		}
	    		else
	    		{
	    			Yii::error("上传视频封面失败",Yii::app()->createUrl('video/add'),"1");die;
	    		}
        	}
        
        	if($_FILES['video'])
        	{
        		//上传视频
        		$videoid = CYouku::uploadVideo($video_path);
        	}
        	$model_id = $_POST['model_id'];
        	if($videoid && $author_portrait)
        	{
        		$res = CVideo::addhomevideo_Bymodelid($model_id,$videoid,$author_portrait,$_POST['plays'],$_POST['sort']);
        		if($res)
        		{
        			Yii::success("添加成功",Yii::app()->createUrl('video/add'),"1");die;
        		}
        	}else{
        		Yii::error("添加失败",Yii::app()->createUrl('video/add'),"1");die;
        	}
        	
        }
        //$product = CProduct::searchModelall();
        $catearr = CProduct::searchCateall();
        $this->controller->layout = false;
        $this->controller->render('add',array('catearr'=>$catearr));
        //$this->controller->render('image_product',array('product'=>$product));
    }
}






















