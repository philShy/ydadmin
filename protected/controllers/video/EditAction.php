<?php
class EditAction extends CAction
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
       
        $video_id = Yii::app()->request->getParam('id');   
        $goods_model_name = base64_decode(Yii::app()->request->getParam('name'));
        $video_arr = CVideo::search_videohome_byid($video_id);
        $goodsid = Yii::app()->request->getParam('goodsid');
        $sort = Yii::app()->request->getParam('sort');
        if($sort && $video_id)
        { 
        	//查找是否有排序号为$sort
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
        if($_POST)
        {
        	$video_arr = CVideo::search_videohome_byid($_POST['video_id']);
        	if(!empty($_FILES['video_cover']['name']))
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
	    			Yii::error("修改视频封面失败",Yii::app()->createUrl('video/edit'),"1");die;
	    		}
        	}else{
        		$author_portrait = $video_arr['img_url'];
        	}
        
        	if(!empty($_FILES['video']['name']))
        	{
        		//上传视频
        		$videoid = CYouku::uploadVideo($video_path);
        	}else{
        		$videoid = $video_arr['v_url'];
        	}
        	$plays = Yii::app()->request->getParam('plays');
        	$sort = Yii::app()->request->getParam('sort');
        	$res = CVideo::edithomevideo_Bymodelid($_POST['video_id'],$videoid,$author_portrait,$plays,$sort);
        	if($res)
        	{
        		Yii::success("修改成功",Yii::app()->createUrl('../video/list'),"1");die;
        	}else
        	{
        		Yii::error("修改失败啊啊啊",Yii::app()->createUrl('../video/list'),"1");die;
        	}
        }

        $catearr = CProduct::searchCateall();
        $this->controller->layout = false;
        $this->controller->render('edit',array('video_arr'=>$video_arr,'goods_model_name'=>$goods_model_name));
      
    }
}






















