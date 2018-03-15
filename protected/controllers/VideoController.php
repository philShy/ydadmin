<?php
class VideoController extends Controller
{
    public function actions()
    {
        return array(
            'list'=>'application.controllers.video.ListAction',
            'add'=>'application.controllers.video.AddAction',
        	'edit'=>'application.controllers.video.EditAction',
        );
    }
}