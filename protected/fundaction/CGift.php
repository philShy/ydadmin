<?php
class CGift
{
	//查找礼品
	public static function search_gift_all()
	{
        $create_time = date('Y-m-d H:i:s',time());
		$result = Yii::app()->db->createCommand("SELECT * FROM `gift` WHERE is_delete=0 ORDER BY id DESC")
		->bindParam(':create_time',$create_time)->queryAll();
		return $result;
	}
	//添加礼品
	public static function add_gift($gift_name,$gift_portrait,$gift_score,$gift_stock)
	{
		$create_time = date('Y-m-d H:i:s',time());
		$result = Yii::app()->db->createCommand('INSERT INTO `gift` (`gift`,`img_url`,`score`,`stock`,`create_time`)VALUES (:gift,:img_url,:score,:stock,:create_time)')
		->bindValue(':gift',$gift_name)->bindValue(':img_url',$gift_portrait)->bindValue(':score',$gift_score)
		->bindValue(':stock',$gift_stock)->bindValue(':create_time',$create_time)->execute();
		CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article_category','insert');
		return $result;
	}
	//根据ID查询礼品
	public static function search_gift_byid($id)
	{
		$result = Yii::app()->db->createCommand("SELECT * FROM `gift` WHERE id=:id and is_delete=0 ORDER BY id DESC")
		->bindParam(':id',$id)->queryRow();
		return $result;
	}
	//根据礼品ID编辑礼品
	public static function edit_gift($id,$gift_name,$gift_portrait,$gift_score,$gift_stock)
	{
		//echo $gift_name.'---'.$gift_portrait.'---'.$gift_score.'---'.$gift_stock;die;
		$create_time = date('Y-m-d H:i:s',time());
		$result = Yii::app()->db->createCommand('UPDATE `gift` SET name=:name,img=:img,score=:score,stock=:stock,create_time=:create_time WHERE id=:id')
		->bindParam(':id',$id)->bindParam(':name',$gift_name)
		->bindParam(':img',$gift_portrait)->bindParam(':score',$gift_score)
		->bindParam(':stock',$gift_stock)->bindParam(':create_time',$create_time)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'gift','update');
		return $result;
	}
	
	//根据礼品id删除礼品
	public static function remove_gift_by_id($id)
	{
		$result = Yii::app()->db->createCommand("UPDATE `gift` SET is_delete=1 WHERE id=:id")->bindParam(':id',$id)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images_class','delete');
        return $result;
	}
}


















