<?php
class ProductController extends Controller{

   /* public function filters()
    {
        return array('accessControl',);
    }
    public function accessRules(){
        return array(
            array('allow',
                'actions' => array('list','brand','category','add','categoryadd','package'),
                'users' => array('@'),
            ),

            array('deny',
                'actions' => array('list','brand','category','add','categoryadd','package'),
                'users' => array('222'),
            ),
        );
    }*/
    public function actions(){
        return array(
            'list'=>'application.controllers.product.ListAction',
            'brand'=>'application.controllers.product.BrandAction',
            'category'=>'application.controllers.product.CategoryAction',
            'add'=>'application.controllers.product.AddAction',
            'categoryadd'=>'application.controllers.product.CategoryaddAction',
            'addbrand'=>'application.controllers.product.AddbrandAction',
            'docategoryadd'=>'application.controllers.product.DocategoryaddAction',
            'package'=>'application.controllers.product.PackageAction',
            'addpackage'=>'application.controllers.product.AddpackageAction',
            'editbrand'=>'application.controllers.product.EditbrandAction',
            'edit'=>'application.controllers.product.EditAction',
            'editpackage'=>'application.controllers.product.EditpackageAction',
            'addone'=>'application.controllers.product.AddoneAction',
        	'addmodel'=>'application.controllers.product.AddmodelAction',
        	'addvideo'=>'application.controllers.product.AddvideoAction',
        	'video'=>'application.controllers.product.VideoAction',
            'type'=>'application.controllers.product.TypeAction',
            'addtype'=>'application.controllers.product.AddtypeAction',
            'edittype'=>'application.controllers.product.EdittypeAction',
            'editproperty'=>'application.controllers.product.EditpropertyAction',
            'addproperty'=>'application.controllers.product.AddpropertyAction',
            'property'=>'application.controllers.product.PropertyAction',
            'set_sales_time'=>'application.controllers.product.Set_sales_timeAction',
            'add_set_sales_time'=>'application.controllers.product.Add_set_sales_timeAction',
			'layout'=>'application.controllers.product.LayoutAction',
        		'addlayout'=>'application.controllers.product.AddlayoutAction',
        		'editlayout'=>'application.controllers.product.EditlayoutAction',
            'yulan'=>'application.controllers.product.YulanAction',
        );
    }
}

















