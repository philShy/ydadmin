<?php
class InfoAction extends CAction
{
    public function run()
    {
        $this->controller->layout = false;
        $this->controller->render('info');
    }
}