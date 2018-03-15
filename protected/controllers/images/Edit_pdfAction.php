<?php
class Edit_pdfAction extends CAction
{
    public function run()
    {
        $pdfid = Yii::app()->request->getParam('pdfid');
        $sort = Yii::app()->request->getParam('sort');
        $sign = Yii::app()->request->getParam('sign');
        $goods_id = Yii::app()->request->getParam('id');
        $result= CImages::searchPdfOne_byGoodsId($goods_id);
        if($sign=='del'&&$goods_id&&$pdfid&&$sort)
        {
            //删除pdf
            $pdf =  CImages::searchPdf_bypPdfId($pdfid);
            $url=substr(strrchr($pdf['url'], '/'), 1);
            $path = iconv('utf-8', 'gbk',$url);
            $url1="../public/uploadsfile/".$path;
            if ($url1){
                unlink($url1);
                CImages::updataPdfSort_byWhere($goods_id,$sort);
                $del_res = CImages::delpdf($pdfid);
                echo $del_res;die;
            }
        }
        if($sign=='moveup'&&$goods_id&&$pdfid&&$sort)
        {
            //sort调换位置
            $res = CImages::moveUpPdfSort_byWhere($goods_id,$pdfid,$sort);
            echo $res;die;
        }
        if($_FILES)
        {
            $maxPdfSort = CImages::searchMaxPdf_byGoodsId($goods_id);
            $file_url = Yii::app()->request->hostInfo.'/uploadsfile/';
            $goods_pdf = CUploadimg::uploadDown();
            foreach($goods_pdf as $key=>$value)
            {
                $key=$key+$maxPdfSort+1;
                $res = CProduct::addPdf($goods_id,$value['ch_name'],$file_url.$value['name'],$key);
            }
            if($res)
            {
                Yii::success("上传文件成功",Yii::app()->createUrl("images/edit_pdf?id=$goods_id"),"1");die;
            }
        }
        /*echo '<pre>';
        var_dump($result);die;*/
        $this->controller->layout = false;
        $this->controller->render('edit_pdf',array('result'=>$result));
    }
}