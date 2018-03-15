<?php
class UserController extends Controller
{
    public function actions()
    {
        return array(
            'list'=>'application.controllers.user.ListAction',
            'edit'=>'application.controllers.user.EditAction',
        );
    }
}