<?php
class EditAction extends CAction{
    public function run()
    {
        $page = Yii::app()->request->getParam('page');
        $where = Yii::app()->request->getParam('where');
        $user_id = Yii::app()->request->getParam('id');
        $user_info = CUser::seachOneuser($user_id);
        if(!$page)
        {
            $page=1;
        }
        if($where)
        {
            $where=base64_decode(str_replace(" ","+",$where));
            $arr =  explode('=',$where);
            $user_info = CUser::seachOneuser($arr[1]);
            $user_order = CTransaction::searchOrderSubDetail_byWhere($where,$page,$size=5);
            $count = CTransaction::searchOrderSubDetailCounty_byWhere($where);
        }else{
            $where = " b.user_id=$user_id ";
            $user_order = CTransaction::searchOrderSubDetail_byWhere($where,$page,$size=5);
            $count = CTransaction::searchOrderSubDetailCounty_byWhere($where);
        }



        $this->controller->layout = false;
        $this->controller->render('edit',array(
            'user_info'=>$user_info,
            'user_order'=>$user_order,
            'count'=>$count,
            'page'=>$page,
            'where'=>$where,
        ));
    }
}