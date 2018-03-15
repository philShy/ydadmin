<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 15:09
 */
class SettingAction extends CAction{
    public function run()
    {
        $state = Yii::app()->request->getParam('state');
        if($state==1)
        {
            if(unlink('./cron-switch.txt')||unlink('./cron-run.txt'))
            {
                echo 1;die;
            }
        }
        if($state==2)
        {
            if(!file_exists('./cron-run.txt')&&!file_exists('./cron-switch.txt'))
            {
                if(fopen("./cron-switch.txt", "w")&&fopen("./cron-run.txt", "w"))
                {
                    echo 1;die;
                }
            }else{
                echo 2;die;
            }
        }
        $this->controller->layout = false;
        $this->controller->render('setting');
    }
}
