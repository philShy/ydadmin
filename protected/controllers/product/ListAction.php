<?php
class ListAction extends CAction{
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
        $page = Yii::app()->request->getParam('page');
        if(empty($page))
        {
            $page = 1;
        }
        $where = Yii::app()->request->getParam('where');
        $wait_audit = Yii::app()->request->getParam('wait_audit');
        $searchCate = Yii::app()->request->getParam('cate');
        $searchBrand = Yii::app()->request->getParam('brand');
        $searchName = Yii::app()->request->getParam('searchName');
        $searchDate = Yii::app()->request->getParam('searchDate');
        $is_publish =Yii::app()->request->getParam('is_publish');
        $is_delete =Yii::app()->request->getParam('is_delete');
        $id =Yii::app()->request->getParam('goods_id');
        $model_id =Yii::app()->request->getParam('model_id');
        if($id)
        {
            if($is_publish == 1)
            {
                $result = CProduct::edit_Goodsmodel($id,$is_publish);
                echo $result;
            }
            if($is_publish == 0)
            {
                $result = CProduct::edit_Goodsmodel($id,$is_publish);
                echo $result;
            }
            die;
        }
        if($model_id)
        {
        	$result = CProduct::del_Modelbyid($model_id,$is_delete);
        	echo $result;die;
        }
        if($where)
        {
            $where=base64_decode(str_replace(" ","+",$where));
            //$where = base64_decode($where);
            //echo $where;
            $searchArr = CProduct::search_Bywhere($where,$page,$size=10);
            $goods_num = CProduct::search_Bywhere_num($where);
        }else
        {
            if($searchCate && (!empty($searchBrand) ||!empty($wait_audit) || !empty($searchName) || !empty($searchDate)) )
            {
                $sql1 = "A.cate = $searchCate AND";
            }else if($searchCate && empty($wait_audit) && empty($searchBrand) && empty($searchName) && empty($searchDate)){
                $sql1 = "A.cate = $searchCate";
            }else{
                $sql1 = "";
            }
            if($searchBrand && (!empty($searchName) || !empty($wait_audit) || !empty($searchDate)))
            {
                $sql2 = "A.brand = $searchBrand AND";
            }else if($searchBrand && empty($wait_audit) && empty($searchName) && empty($searchDate)){
                $sql2 = "A.brand = $searchBrand";
            }else{
                $sql2 = '';
            }
            if($wait_audit && (!empty($searchName) || !empty($searchDate)))
            {
                $sql3 = "B.wait_audit = '$wait_audit' AND";
            }else if($wait_audit && empty($searchName) && empty($searchDate)){
                $sql3 = "B.wait_audit = '$wait_audit'";
            }else{
                $sql3 = '';
            }
            if($searchName && !empty($searchDate))
            {
                $sql4 = "B.model_number LIKE '%$searchName%' AND";
            }else if($searchName && empty($searchDate)){
                $sql4 = "B.model_number LIKE '%$searchName%'";
            }else{
                $sql4 = "";
            }
            if($searchDate)
            {
                $sql5 = "A.create_time >'$searchDate'";
            }else{
                $sql5 = '';
            }
            if($searchName || $searchCate || $searchBrand || $searchDate || $wait_audit)
            {
                $where = $sql1.$sql2.$sql3.$sql4.$sql5;
                $searchArr = CProduct::search_Bysql($sql1,$sql2,$sql3,$sql4,$sql5,$page,$size=10);
                $goods_num = CProduct::search_Bysql_num($sql1,$sql2,$sql3,$sql4,$sql5);

            }elseif(empty($searchCate)&&empty($searchBrand)&&empty($searchName)&&empty($searchDate)&&empty($wait_audit)){
                $searchArr = CProduct::searchGoodsmodelall($page,$size=10);
                $goods_num = CProduct::searchGoodsmodelall_num();
            }
        }

        $catearr = CProduct::searchCateall();
        $brandarr = CProduct::searchBrandall();
        $this->controller->layout = false;
        $this->controller->render('list',
            array('result'=>$searchArr,
                'goods_num' =>$goods_num ,
                'catearr'=>$catearr,
                'brandarr'=>$brandarr,
                'page'=>$page,
                'where'=>$where,
            )
        );
    }
}