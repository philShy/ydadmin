<?php
class GiftController extends Controller{

  public function actionGift(){
  	$is_delete = Yii::app()->request->getParam('is_delete');
  	$gift_name = Yii::app()->request->getParam('gift-name');
  	$gift_score = Yii::app()->request->getParam('gift-score');
  	$gift_stock = Yii::app()->request->getParam('gift-stock');
  	$gift_id = Yii::app()->request->getParam('gift_id');
  	$id = Yii::app()->request->getParam('id');
  	$img_url = Yii::app()->request->hostInfo.'/images/gift/';
  	$img_path = 'images/gift/';
  	if($is_delete)
  	{
  		$result = CGift::remove_gift_by_id($gift_id);
  		echo $result;die;
  	}
  	if($gift_name && !empty($_FILES['portrait']['name']) && empty($id))
  	{
  		if ((($_FILES["portrait"]["type"] == "image/gif")
  				|| ($_FILES["portrait"]["type"] == "image/jpeg")
  				|| ($_FILES["portrait"]["type"] == "image/pjpeg")
  				|| ($_FILES["portrait"]["type"] == "image/png")
  				|| ($_FILES["portrait"]["type"] == "image/gif"))
  				&& ($_FILES["portrait"]["size"] < 2000000))
  		{
  			if ($_FILES["portrait"]["error"] > 0)
  			{
  				echo "Error: " . $_FILES["portrait"]["error"] . "<br />";
  			}
  			else
  			{
  				$gift_portrait = $img_url . $_FILES["portrait"]["name"];
  				$res = move_uploaded_file($_FILES["portrait"]["tmp_name"],$img_path.$_FILES["portrait"]["name"]);
  				if($res)
  				{
  					$result =CGift::add_gift($gift_name,$gift_portrait,$gift_score,$gift_stock);
  					if($result)
  					{
  						Yii::success("添加成功",Yii::app()->createUrl('gift/gift'),"1");die;
  					}
  				}
  			}
  		}
  		else
  		{
  			Yii::error("添加失败",Yii::app()->createUrl('gift/gift'),"1");die;
  		}
  	
  	
  	}
  	if($gift_id)
  	{
  		$result = CGift::search_gift_byid($gift_id);
  		echo json_encode($result,true);die;
  	
  	}
  	if($id)
  	{
  		$gift = CGift::search_gift_byid($id);
  		if(!empty($_FILES['portrait']['name']))
  		{
	  		if (is_file($img_path.strrchr($gift['img'],'/')))
	  		{
	  			
	  			unlink($img_path.strrchr($gift['img'],'/'));
	  		}
	  		if ((($_FILES["portrait"]["type"] == "image/gif")
	  				|| ($_FILES["portrait"]["type"] == "image/jpeg")
	  				|| ($_FILES["portrait"]["type"] == "image/pjpeg")
	  				|| ($_FILES["portrait"]["type"] == "image/png")
	  				|| ($_FILES["portrait"]["type"] == "image/gif"))
	  				&& ($_FILES["portrait"]["size"] < 2000000))
	  		{
	  			if ($_FILES["portrait"]["error"] > 0)
	  			{
	  				echo "Error: " . $_FILES["portrait"]["error"] . "<br />";
	  			}
	  			else
	  			{
	  				$gift_portrait = $img_url . $_FILES["portrait"]["name"];
	  				$res = move_uploaded_file($_FILES["portrait"]["tmp_name"],$img_path.$_FILES["portrait"]["name"]);
	  				if($res)
	  				{
	  					$result =CGift::edit_gift($gift['id'],$gift_name,$gift_portrait,$gift_score,$gift_stock);
	  					if($result)
	  					{
	  						Yii::success("编辑成功",Yii::app()->createUrl('gift/gift'),"1");die;
	  					}
	  				}
	  			}
	  		}
	  		else
	  		{
	  			Yii::error("编辑失败",Yii::app()->createUrl('gift/gift'),"1");die;
	  		}
  		}else{
  			$result =CGift::edit_gift($gift['id'],$gift_name,$gift['img'],$gift_score,$gift_stock);
  			if($result)
  			{
  				Yii::success("编辑成功",Yii::app()->createUrl('gift/gift'),"1");die;
  			}
  		}
  	}

  	$gift_arr = CGift::search_gift_all();
  	$count = count($gift_arr);
	$this->layout = false;
	$this->render('gift',array('gift_arr'=>$gift_arr,'count'=>$count));
  }
}