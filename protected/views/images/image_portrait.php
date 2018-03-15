<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css"/>
    <link href="../assets/css/codemirror.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/colorbox.css">
    <!--图片相册-->
    <link rel="stylesheet" href="../assets/css/ace.min.css" />

    <link rel="stylesheet" href="../font/css/font-awesome.min.css" />
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="../assets/css/ace-ie.min.css" />
    <![endif]-->

    <script src="../js/jquery-1.9.1.min.js"></script>
    <script src="../assets/js/jquery.colorbox-min.js"></script>
    <script src="../assets/js/typeahead-bs2.min.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="../assets/layer/layer.js" type="text/javascript" ></script>
    <script type="text/javascript" src="../Widget/swfupload/swfupload.js"></script>
    <script type="text/javascript" src="../Widget/swfupload/swfupload.queue.js"></script>
    <script type="text/javascript" src="../Widget/swfupload/swfupload.speed.js"></script>
    <script type="text/javascript" src="../Widget/swfupload/handlers.js"></script>


    <title>列表 - 素材牛模板演示</title>
</head>

<body>
 <div class="sort_Ads_list">
            <table class="table table-striped table-bordered table-hover" id="sample-table">
                <thead>
                
                    <th width="80px">ID</th>
                    <th width="150">头像预览</th>
                   
                </tr>
                </thead>
                <tbody>
                <?php foreach($result as $key=>$value):?>
                    <tr>
                       
                        <td class="portrait_id"><?php echo $value['id']?></td>
                        <td><image src="<?php echo $value['image_url']?>"style="width:60px;height:60px;margin-left:15px;"></td>
                       
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
</body>