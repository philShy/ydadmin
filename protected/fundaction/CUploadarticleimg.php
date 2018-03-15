<?php
class CUploadarticleimg
{
    public static function uploadarticleimg($id,$folder1)
    {
        $_FILES2['file'] = $_FILES['file'];
        $isSuc = false;
        $root = YiiBase::getPathOfAlias('webroot').Yii::app()->getBaseUrl();
        $folder = $root.'/images/article/';
        $desFilePath = '';
        $tmpFilePath = '';
        self::mkDirIfNotExist($folder);
        if ((($_FILES2["file"]["type"] == "image/gif")
            || ($_FILES2["file"]["type"] == "image/jpeg")
            || ($_FILES2["file"]["type"] == "image/png")
            || ($_FILES2["file"]["type"] == "image/jpg")
            || ($_FILES2["file"]["type"] == "image/pjpeg")))
        {
            if ($_FILES2["file"]["error"] > 0)
            {
                $isSuc = false;
            }
            else
            {
                $tmpFilePath = $_FILES2["file"]["tmp_name"];
                $desFilePath = $folder.$_FILES2["file"]["name"];
                $ressult_brand = CProduct::searchBrandbyid($id);
                if($ressult_brand){
                    if (is_file($folder.strrchr($ressult_brand['images_url'],'/'))) {

                        unlink($folder.strrchr($ressult_brand['images_url'],'/'));
                    }
                    move_uploaded_file($tmpFilePath, $desFilePath);
                    $res = CProduct::editBrandlogo($folder1.$_FILES2["file"]["name"],$id);
                    if($res){

                        //Yii::success("品牌logo替换成功",Yii::app()->request->urlReferrer,"3");die;
                        Yii::success("修改成功",Yii::app()->createUrl('../product/brand'),"1");die;
                    }

                    else
                    {
                        Yii::error("品牌logo替换失败",Yii::app()->request->urlReferrer,"1");die;
                    }
                }else{

                    $res = CArticle::addArticleimg($folder1.$_FILES2["file"]["name"],$id);
                    if($res){
                        return true;
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