<?php
class ImagesController extends Controller{

    public function actions(){
        return array(
            'list'=>'application.controllers.images.ListAction',
            'imagesclass'=>'application.controllers.images.ImagesclassAction',
            'editimagesclass'=>'application.controllers.images.EditimagesclassAction',
            'image_product'=>'application.controllers.images.Image_productAction',
            'editproduct_images'=>'application.controllers.images.Editproduct_imagesAction',
            'image_brand'=>'application.controllers.images.Image_brandAction',
			'image_artical'=>'application.controllers.images.Image_articalAction',
        	'image_adv'=>'application.controllers.images.Image_advAction',
        	'editadv'=>'application.controllers.images.EditadvAction',
        	'addadv'=>'application.controllers.images.AddadvAction',
        	'chooice'=>'application.controllers.images.ChooiceAction',
        	'editarticle'=>'application.controllers.images.editarticleAction',
        	'image_article'=>'application.controllers.images.Image_articleAction',
        	'editarticle_images'=>'application.controllers.images.Editarticle_imagesAction',
			'artical'=>'application.controllers.images.Image_articalAction',
        	'editartical_images'=>'application.controllers.images.EditarticalAction',
			'editbrand'=>'application.controllers.images.EditbrandAction',
				'pdf'=>'application.controllers.images.PdfAction',
        		'editpdf'=>'application.controllers.images.EditpdfAction'
        );
    }
}