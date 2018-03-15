<?php
class AddvideoAction extends CAction
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
        $video_url = Yii::app()->request->hostInfo.'/video/product/';
        $video_path = 'video/product';
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
        	$model_id = $_POST['model_id'];
        	$videoid = CYouku::uploadVideo($video_path);
        	if($videoid)
        	{
        		$res = CProduct::addvideo_Bymodelid($model_id,$videoid);
        		if($res)
        		{
        			Yii::success("添加成功",Yii::app()->createUrl('product/video'),"1");die;
        		}
        	}else{
        		Yii::error("添加失败",Yii::app()->createUrl('product/addvideo'),"1");die;
        	}
        	
        }
        //$product = CProduct::searchModelall();
        $catearr = CProduct::searchCateall();
        $this->controller->layout = false;
        $this->controller->render('addvideo',array('catearr'=>$catearr));
        //$this->controller->render('image_product',array('product'=>$product));
    }
}






















