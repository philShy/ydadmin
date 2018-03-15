<?php
class PdfAction extends CAction
{
    public function run()
    {
        $goods_name = Yii::app()->request->getParam('goods_name');
        $where = Yii::app()->request->getParam('where');
        $page = Yii::app()->request->getParam('page');
        $size=10;
        if(empty($page))
        {
            $page = 1;
        }
        if($where)
        {
            $where=base64_decode(str_replace(" ","+",$where));
            $result = CImages::searchGoodsPdf_likeGoodsName($where,$page,$size);
            $count = CImages::searchGoodsPdfNum_likeGoodsName($where);
        }else{
            if($goods_name)
            {
                $where = $goods_name;
                $result = CImages::searchGoodsPdf_likeGoodsName($where,$page,$size);
                $count = CImages::searchGoodsPdfNum_likeGoodsName($where);
            }else{
                $result= CImages::pdflist($page,$size);
                $count= CImages::pdflist_num();
            }
        }

        $this->controller->layout = false;
        $this->controller->render('pdf',
            array('result'=>$result,
                    'where'=>$where,
                    'page'=>$page,
                    'count'=>$count,
            ));
    }
}