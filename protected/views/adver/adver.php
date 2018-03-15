<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css"/>
    <link href="/assets/css/codemirror.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/font/css/font-awesome.min.css" />
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
    <![endif]-->
 
    <title>文章管理</title>
</head>

<body>
<div class="clearfix">
    <div class="article_style" id="article_style">
         <div class="border clearfix">
       <span class="l_f">
      
        <a href="javascript:ovid()" style="display: none" class="btn btn-danger"><i class="fa fa-trash"></i> 批量删除</a>
        <a href="javascript:ovid()" onClick="javascript :history.back(-1);" class="btn btn-info"><i class="fa fa-reply"></i> 返回上一步</a>
       </span>
          
        </div>
        <!--广告列表-->
        <div class="Ads_list">
              
            <div class="article_list">
                <table class="table table-striped table-bordered table-hover" id="sample-table">
                    <thead>
                    <tr>
                        <th style="display: none"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
                        <th width="80px">ID</th>
                        <th width="100px">位置</th>
                        <th>展示品1</th>
                         <th>展示品2</th>
                          <th>展示品3</th>
                        <th width="200px">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                   <?php foreach($adver as $key=>$value):?>
                    <tr>
                        <td style="display: none"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
                        <td><?php echo $value[id]?></td>
                        <td><?php echo $value[type]?></td>
                       <?php $arr =explode(",", $value[goods_model_id]); foreach ($arr as $a){
                       	  $model= CProduct::searchGoodsmodelbyid($a);
                       			
                       	  		echo '<td>'.$model['title'].'</td>';
                       	  
                      }?>

                       
                        <td class="td-manage">
                          	
                           <a title="编辑"  href="/adver/editadvers?id=<?php echo $value['id']?>"  class="btn btn-xs btn-info" ><i class="fa fa-edit bigger-120"></i></a>
                      </td>
                    </tr>
                   <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div>

</body>
</html>



