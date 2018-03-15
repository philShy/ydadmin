<?php
class AuthorAction extends CAction
{
    public function run()
    {
        $author_name = Yii::app()->request->getParam('author-name');
        $author_id = Yii::app()->request->getParam('author_id');
        $id = Yii::app()->request->getParam('id');
        $img_url = Yii::app()->request->hostInfo.'/images/portrait/';
        $img_path = 'images/portrait/';
    	if(!file_exists($img_path))
    	{
            mkdir($img_path,0777,true);
        }
    	if($author_name && !empty($_FILES['portrait']['name']) && empty($id))
    	{
    	
    		if ((($_FILES["portrait"]["type"] == "image/gif")
    				|| ($_FILES["portrait"]["type"] == "image/jpeg")
    				|| ($_FILES["portrait"]["type"] == "image/pjpeg")
    				|| ($_FILES["portrait"]["type"] == "image/png")
    				|| ($_FILES["portrait"]["type"] == "image/gif"))
    				&& ($_FILES["portrait"]["size"] < 2000000))
    		{
    			if ($_FILES["portrait"]["error"] > 0)
    			{
    				echo "Error: " . $_FILES["portrait"]["error"] . "<br />";
    			}
    			else
    			{
    				$author_portrait = $img_url . $_FILES["portrait"]["name"];
    				$res = move_uploaded_file($_FILES["portrait"]["tmp_name"],$img_path.$_FILES["portrait"]["name"]);
    				if($res)
    				{
    					$result =CArticle::addAuthor($author_name,$author_portrait);
    					if($result)
    					{
    						Yii::success("添加成功",Yii::app()->createUrl('article/author'),"1");die;
    					}
    				}
    			}
    		}
    		else
    		{
    			Yii::error("添加失败",Yii::app()->createUrl('article/author'),"1");die;
    		}
    		
    		
    	}
    	if($author_id)
    	{
    		$result = CArticle::searchauthor_byid($author_id);
    		echo json_encode($result,true);die;
    		
    	}
    	if($id && !empty($_FILES['portrait']['name']))
    	{
    		$author = CArticle::searchauthor_byid($id);
   
    		if (is_file($img_path.strrchr($author['author_portrait'],'/')))
    		{
    			unlink($img_path.strrchr($author['author_portrait'],'/'));
    		}
    		if ((($_FILES["portrait"]["type"] == "image/gif")
    				|| ($_FILES["portrait"]["type"] == "image/jpeg")
    				|| ($_FILES["portrait"]["type"] == "image/pjpeg")
    				|| ($_FILES["portrait"]["type"] == "image/png")
    				|| ($_FILES["portrait"]["type"] == "image/gif"))
    				&& ($_FILES["portrait"]["size"] < 2000000))
    		{
    			if ($_FILES["portrait"]["error"] > 0)
    			{
    				echo "Error: " . $_FILES["portrait"]["error"] . "<br />";
    			}
    			else
    			{
    				$author_portrait = $img_url . $_FILES["portrait"]["name"];
    				$res = move_uploaded_file($_FILES["portrait"]["tmp_name"],$img_path.$_FILES["portrait"]["name"]);
    				if($res)
    				{
    					$result =CArticle::editAuthor($author['id'],$author_name,$author_portrait);
    					if($result)
    					{
    						Yii::success("编辑成功",Yii::app()->createUrl('article/author'),"1");die;
    					}
    				}
    			}
    		}
    		else
    		{
    			Yii::error("编辑失败",Yii::app()->createUrl('article/author'),"1");die;
    		}
    		
    	}
        $author_arr = CArticle::searchAuthor(); 
        $count = count($author_arr);
        $this->controller->layout = false;
        $this->controller->render('author',array('author_arr'=>$author_arr,'count'=>$count));
    }
}




























