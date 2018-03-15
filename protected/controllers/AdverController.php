<?php
class AdverController extends Controller{

	public function actions(){
		return array(
				'advers'=>'application.controllers.adver.adverAction',
				'editadvers'=>'application.controllers.adver.editadverAction',
				);
				}
				}