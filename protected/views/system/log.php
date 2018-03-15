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
    <script src="/js/jquery-1.9.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <script src="/js/H-ui.js" type="text/javascript"></script>
    <script src="/js/displayPart.js" type="text/javascript"></script>
    <script src="/assets/laydate/laydate.js" type="text/javascript"></script>
    <title>系统日志</title>
</head>
<style>
    #page .page_right a{text-decoration:none;display:inline-block;
        width:40px; height: 25px;font-size: 14px;color: #fff;background: #6fb3e0;
        margin-left: 3px;line-height: 25px;}
    #page .page_right a:hover{background: #2a8bcc}
</style>
<body>
<div class="margin clearfix">
    <div id="system_style">
        <div class="search_style">
        <form action="/system/log" method="post">
            <ul class="search_content clearfix">
                <li><label class="l_f">管理员 &nbsp;</label>
                    <select name="manager">
                        <option value="0">--选择--</option>
                        <?php foreach($manager_arr as $k=>$v):?>
                            <option value="<?php echo $v['manager']?>"><?php echo $v['manager']?></option>
                        <?php endforeach;?>
                    </select>
                </li>
                <li style="display: none"><label class="l_f">操作</label>
                    <select name="operation">
                        <option value="0">--选择--</option>
                        <?php foreach($operation_arr as $k=>$v):?>
                            <option value="<?php echo $v['curd_cname']?>"><?php echo $v['curd_cname']?></option>
                        <?php endforeach;?>
                    </select>
                </li>
                <li><label class="l_f">时间</label><input name="datetime" class="inline laydate-icon" id="start" style=" margin-left:10px;"></li>
                <li style="width:90px;"><input type="submit" class="btn_search" value="查询"></li>
            </ul>
        </form>
        </div>
        <!--系统日志-->
        <div style="float:right"><span>共：<b><?php echo $count?></b>条记录</span></div>
        <div class="system_logs">
            <table class="table table-striped table-bordered table-hover" id="sample-table">
                <thead>
                <tr>
                    <th width="80px">ID</th>
                    <th width="120px">登录用户</th>
                    <th width="120px">角色</th>
                    <th width="120px">数据表</th>
                    <th width="120px">操作</th>
                    <th width="120px">登录ip</th>
                    <th width="150px">操作时间</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($log_arr as $key=>$value):?>
                <tr>
                    <td><?php echo $value['id']?></td>
                    <td><?php echo $value['login_user']?></td>
                    <td><?php echo $value['role']?></td>
                    <td><?php echo $value['table_cname']?></td>
                    <td><?php echo $value['curd_cname']?></td>
                    <td><?php echo $value['login_ip']?></td>
                    <td><?php echo $value['operate_time']?></td>
                </tr>
                <?php endforeach;?>
                </tbody>
                <tr>
                    <td colspan="8">
                        <div id="page">
                            <div class=page_left style="float: left">当前第：<?php echo $page.'/'.ceil($count/10);?>页</div>
                            <div class=page_right style="float: right">
                                <?php
                                //echo $dd;
                                echo CPage::newsPage($page,ceil($count/10),$where,$url);
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</body>
</html>
<script>
    laydate({
        elem: '#start',
        event: 'focus'
    });

</script>
