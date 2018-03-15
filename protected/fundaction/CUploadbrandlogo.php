<?php
class CUploadbrandlogo
{
    public static function uploadbrandlogo($img_url,$img_path)
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
    			$author_portrait = $img_url . $_FILES["file"]["name"];
    			$res = move_uploaded_file($_FILES["file"]["tmp_name"],$img_path.$_FILES["file"]["name"]);
    			if($res)
    			{
    				return $img_url.$_FILES["file"]["name"];
    		
    			}
    		}
    	}
    	else
    	{
    		Yii::error("添加失败",Yii::app()->createUrl('product/brand'),"1");die;
    	}
    }

        /* $isSuc = false;
        $root = YiiBase::getPathOfAlias('webroot').Yii::app()->getBaseUrl();
        $folder = $root.'/images/brand/';
        $desFilePath = '';
        $tmpFilePath = '';
        self::mkDirIfNotExist($folder);
        if ((($_FILES["file"]["type"] == "image/gif")
            || ($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/png")
            || ($_FILES["file"]["type"] == "image/jpg")
            || ($_FILES["file"]["type"] == "image/pjpeg")))
            //&& ($_FILES["file"]["size"] < 2000000))
        {
            if ($_FILES["file"]["error"] > 0)
            {
                $isSuc = false;
            }
            else
            {
                $tmpFilePath = $_FILES["file"]["tmp_name"];
                $desFilePath = $folder.$_FILES["file"]["name"];
                $ressult_brand = CProduct::searchBrandbyid($brandid);
                if($ressult_brand){
                    if (is_file($folder.strrchr($ressult_brand['images_url'],'/'))) {

                        unlink($folder.strrchr($ressult_brand['images_url'],'/'));
                    }
			
                    move_uploaded_file($tmpFilePath, $desFilePath);
                    $res = CProduct::editBrandlogo($folder1.$_FILES["file"]["name"],$brandid);
                    if($res){

                        //Yii::success("品牌logo替换成功",Yii::app()->request->urlReferrer,"3");die;
                        Yii::success("修改成功",Yii::app()->createUrl('../product/brand'),"1");die;
                    }

                    else
                    {
                        Yii::error("品牌logo替换失败",Yii::app()->request->urlReferrer,"1");die;
                    }
                }else{
					move_uploaded_file($tmpFilePath, $desFilePath);
                    $res = CProduct::addBrandlogo($folder1.$_FILES["file"]["name"],$brandid,$images_class_id);
                    
                    if($res){
                        Yii::success("上传成功",Yii::app()->createUrl('../product/brand'),"1");die;
                    }
                    else
                    {
                        Yii::error("品牌logo上传失败",Yii::app()->request->urlReferrer,"1");die;
                    }
                }

            }
        }
        else
        {
            Yii::error("品牌logo上传失败",Yii::app()->request->urlReferrer,"3");die;
        }

    } */
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