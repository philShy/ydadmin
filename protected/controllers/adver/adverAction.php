<?php
class AdverAction extends CAction
{
	public function run()
	{

		$adver=CProduct::searchadveradvall();

		$this->controller->layout = false;
		$this->controller->render('adver',array('adver'=>$adver));
	}
}