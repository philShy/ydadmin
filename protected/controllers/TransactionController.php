<?php
/**
 * Specifies the access control rules.
 * This method is used by the 'accessControl' filter.
 * @return array access control rules
 */

class TransactionController extends Controller
{

    public function actions()
    {
        return array(
            'amounts'=>'application.controllers.transaction.AmountsAction',
            'orderform'=>'application.controllers.transaction.OrderformAction',
        		'orderform1'=>'application.controllers.transaction.OrderformAction1',
        		'orderform2'=>'application.controllers.transaction.OrderformAction2',
        		'orderform3'=>'application.controllers.transaction.OrderformAction3',
        		'orderform4'=>'application.controllers.transaction.OrderformAction4',
        		'orderform5'=>'application.controllers.transaction.OrderformAction5',
        		'orderform6'=>'application.controllers.transaction.OrderformAction6',
            'orderform7'=>'application.controllers.transaction.OrderformAction7',
            'orderform8'=>'application.controllers.transaction.OrderformAction8',
            'orderhandling'=>'application.controllers.transaction.OrderhandlingAction',
            'refund'=>'application.controllers.transaction.RefundAction',
            'orderdetail'=>'application.controllers.transaction.OrderdetailAction',
            'refunddetail'=>'application.controllers.transaction.RefunddetailAction',
        );
    }
}