<?php
class Editproduct_imagesAction extends CAction
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
        $id = Yii::app()->request->getParam('id');
        $model_id = Yii::app()->request->getParam('model_id');
        $model_number = Yii::app()->request->getParam('model_number');
        $modelid = Yii::app()->request->getParam('modelid');
        $picid = Yii::app()->request->getParam('picid');
        $sort = Yii::app()->request->getParam('sort');
        $mark = Yii::app()->request->getParam('mark');
        if($id){
            if($_FILES['proImg'])
            {
                /* $img_url = 'http://randn.net/images/product/';
                $img_path = 'images/product'; */
                $img_url = Yii::app()->request->hostInfo.'/images/product/';
                $img_path = 'images/product';
                $path = CUploadimg::uploadFile($img_path);
                if($path)
                {
                    $imgid =  CProduct::searchImg($id);

                    if(!empty($imgid))
                    {
                        foreach($imgid as $k=>$v)
                        {
                            $arr[] = $v['sort'];
                        };
                        $max_id = array_search(max($arr), $arr);
                        foreach($path as $key=>$value)
                        {
                            $sort = $key+$arr[$max_id]+1;
                            $re[] = CProduct::addImg($img_url.$value['name'],$id,$sort);
                        }
                        if($re)
                        {
                            Yii::success("修改成功",Yii::app()->createUrl('../images/image_product'),"1");die;
                        }
                    }else{
                        foreach($path as $key=>$value)
                        {
                            $sort = $key+1;
                            $re[] = CProduct::addImg($img_url.$value['name'],$id,$sort);
                        }
                        if($re)
                        {
                            Yii::success("修改成功",Yii::app()->createUrl('../images/image_product'),"1");die;
                        }
                    }

                }
            }

        }
        if($model_id){
            $product_images = CImages::searchmodel_Imagecate($model_id);
        }
        if($mark=='del' && $modelid && $picid)
        {
            $img =  CImages::searchimages_modelBypicid($picid);
			$arr=explode("/", $img['image_url']);
			$last=$arr[count($arr)-1];
			//echo $last;die;
            CImages::delimages_modelBypicid($picid);
            if (file_exists("images/product/" .$last)) {
                unlink("images/product/" .$last);
            }
            if (file_exists("images/product_50/50" .$last)) {
                unlink("images/product_50/50" .$last);
            }
            $res = CImages::updateimages_Bymodelid($modelid,$img['sort']);
            echo $res;die;

        }
        if($mark=='moveup' && $modelid && $picid && $sort)
        {
            $upsort=$sort-1;
            $upid = CImages::searchupmodel_images($modelid,$upsort)['id'];
            $new1 = CImages::updatemodel_imagesSort($picid,$upsort);
            $new2 = CImages::updatemodel_imagesSort($upid,$sort);
            if($new1 && $new2)
            {
                 echo 1;die;
            }
        }
        $this->controller->layout = false;
        $this->controller->render('editproduct_images',array('model_id'=>$model_id,'model_number'=>$model_number,'product_images'=>$product_images));
    }
}