<?php 
class CVideo
{
	public static function search_videohome_all()
	{
		$result = Yii::app()->db->createCommand('SELECT * FROM `video`')
        ->queryAll();
        return $result;
	}
	public static function addhomevideo_Bymodelid($model_id,$v_url,$img_url,$plays,$sort)
	{
		$create_time = date("Y-m-d H:i:s",time());
        $sql = 'insert into video (`goods_model_id`,`v_url`,`img_url`,`plays`,`sort`,`create_time`) VALUES (:goods_model_id,:v_url,:img_url,:plays,:sort,:create_time) ';
        Yii::app()->db->createCommand($sql)->bindValue(':goods_model_id',$model_id)->bindValue(':v_url',$v_url)
        ->bindValue(':img_url',$img_url)->bindValue(':plays',$plays)->bindValue(':sort',$sort)
        ->bindValue(':create_time',$create_time)->execute();
        $eid = Yii::app()->db->getLastInsertID();
        return $eid;
	}
	//
	public static function search_videohome_byid($video_id)
	{
		$result = Yii::app()->db->createCommand('SELECT * FROM `video` WHERE id = :id')
		->bindValue(':id',$video_id)->queryRow();
		return $result;
	}
	//
	public static function edithomevideo_Bymodelid($video_id,$videoid,$author_portrait,$plays,$sort)
	{
		$create_time = date("Y-m-d H:i:s",time());
		$result = Yii::app()->db->createCommand('UPDATE video SET v_url=:v_url,img_url=:img_url,plays=:plays,sort=:sort,create_time=:create_time WHERE id=:id')
		->bindParam(':v_url',$videoid)->bindParam(':img_url',$author_portrait)->bindParam(':plays',$plays)
		->bindParam(':sort',$sort)->bindParam(':create_time',$create_time)->bindParam(':id',$video_id)->execute();
		return $result;
	}
	//
	public static function searchvideo_sort_bysort($video_id,$sort)
	{
		if($video_id)
		{		
			$result = Yii::app()->db->createCommand('SELECT * FROM `video` WHERE sort = :sort AND id<>:id')
			->bindValue(':sort',$sort)->bindValue(':id',$video_id)->queryRow();
			return $result['sort'];
		}else{
			$result = Yii::app()->db->createCommand('SELECT * FROM `video` WHERE sort = :sort')
			->bindValue(':sort',$sort)->queryRow();
			return $result['sort'];
		}
		
	}

}



























