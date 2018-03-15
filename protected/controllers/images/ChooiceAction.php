<?php
class ChooiceAction extends CAction
{
	
    public function run()
    {   
    	
    	$href="";
    	if ($_REQUEST['act'] == "add") {
    		$href = "/images/addadv";
    	}elseif ($_REQUEST['act']=="edit"&&!empty($_REQUEST['id'])) {
    		$href = "../images/editadv?id={$_REQUEST['id']}";
    	}
    	$choice=CProduct::searchModelall();
    	$product= Yii::app()->request->getParam('pro');
		
    	if(!empty($product))
    	{	
    		
    		$search_pro=CProduct::searchlikegoods($product);
    	
    		echo json_encode($search_pro);die;
    	}
    	
    	
    	
    	
        $this->controller->layout = false;
        $this->controller->render('chooice',array('choice'=>$choice,'href'=>$href));
    }
}