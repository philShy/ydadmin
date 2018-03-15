<?php
class CUploadcatepic
{
    public static function uploadcatepic($img_url,$img_path)
    {
    	if ((($_FILES["file"]["type"] == "image/gif")
    			|| ($_FILES["file"]["type"] == "image/jpeg")
    			|| ($_FILES["file"]["type"] == "image/pjpeg")
    			|| ($_FILES["file"]["type"] == "image/png")
    			|| ($_FILES["file"]["type"] == "image/gif"))
    			&& ($_FILES["file"]["size"] < 5000000))
    	{
    		if ($_FILES["file"]["error"] > 0)
    		{
    			echo "Error: " . $_FILES["file"]["error"] . "<br />";
    		}
    		else
    		{
    			$author_portrait = $img_url.$_FILES["file"]["name"];
				
    			$res = move_uploaded_file($_FILES["file"]["tmp_name"],"products/category/".$_FILES["file"]["name"]);
				
    			if($res)
    			{
    				return $author_portrait;
    		
    			}
    		}
    	}
    	else
    	{
    		Yii::error("未添加图片",Yii::app()->createUrl('../product/category'),"1");die;
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