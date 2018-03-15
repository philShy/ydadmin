<?php
class CUploadcatelogo
{
	public static function uploadcatelogo($img_url,$img_path)
	{
		if ((($_FILES["file"]["type"] == "image/gif")
				|| ($_FILES["file"]["type"] == "image/jpeg")
				|| ($_FILES["file"]["type"] == "image/pjpeg")
				|| ($_FILES["file"]["type"] == "image/png")
				|| ($_FILES["file"]["type"] == "image/gif"))
				&& ($_FILES["file"]["size"] < 2000000))
		{
			if ($_FILES["file"]["error"] > 0)
			{
				echo "Error: " . $_FILES["file"]["error"] . "<br />";
			}
			else
			{	
				$fils=md5($_FILES["file"]["name"]);
				$author_portrait = $img_url .$fils ;
				$res = move_uploaded_file($_FILES["file"]["tmp_name"],$img_path.$fils);
				if($res)
				{
					return $author_portrait;

				}
			}
		}
		else
		{
			Yii::error("添加失败",Yii::app()->createUrl('product/cate'),"1");die;
		}
	}


	 public static function mkDirIfNotExist($dir)
	 {
	 	if(!is_dir($dir))
	 	{
	 		if(!mkdir($dir, 0, true))
	 		{
	 			throw new Exception('create folder fail');
	 			//return false;
	 		}
	 		else
	 		{
	 			return true;
	 		}
	 	}
	 	return false;
	 }
}