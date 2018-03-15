<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <link rel="stylesheet" href="/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/assets/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="/assets/css/ace-skins.min.css" />
    <link rel="stylesheet" href="/css/style.css"/>
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
    <![endif]-->
    <script src="/assets/js/ace-extra.min.js"></script>
    <!--[if lt IE 9]>
    <script src="/assets/js/html5shiv.js"></script>
    <script src="/assets/js/respond.min.js"></script>
    <![endif]-->
    <script src="/js/jquery-1.9.1.min.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript"></script>
    <title>研鼎商城后台</title>
</head>

<body class="login-layout Reg_log_style">
<div class="logintop">
    <span>欢迎后台管理界面平台</span>

</div>
<div class="loginbody">
    <div class="login-container">
        <div class="center">
            <img src="/images/login.png" />
        </div>

        <div class="space-6"></div>
        <div class="position-relative">
            <div id="login-box" class="login-box widget-box no-border visible">
                <div class="widget-body">
                    <div class="widget-main">
                        <h4 class="header blue lighter bigger">
                            <i class="icon-coffee green"></i>
                            管理员登陆
                        </h4>

                        <div class="login_icon"><img src="/images/user.png" /></div>

                        <form class="" action="/login/index" method="post">
                            <fieldset>
                                <ul>
                                    <li class="frame_style form_error"><label class="user_icon"></label><input placeholder="用户名" name="LoginForm[username]" type="text"  id="username"/></li>
                                    <li class="frame_style form_error"><label class="password_icon"></label><input autocomplete="off" placeholder="密码" name="LoginForm[password]" type="text" onfocus="this.type='password'" id="userpwd"/></li>
                                    <!--<li class="frame_style form_error"><label class="Codes_icon"></label><input name="code" type="text"   id="Codes_text"/><i>验证码</i>
                                        <div class="Codes_region control-group">
                                            <a href="#" title="点击刷新" class="change" onclick="changeVer()"><img id="code" style="margin-top:-1px;width:80px;height:40px" src="/login/code"></a>
                                        </div>
                                    </li>-->
                                </ul>
                                <div class="space"></div>

                                <div class="clearfix">
                                 

                                    <input type="submit" value="提交" class="width-35 pull-right btn btn-sm btn-primary">
                                    <!--<button type="button" class="width-35 pull-right btn btn-sm btn-primary" id="login_btn">
                                        <i class="icon-key"></i>
                                        登陆
                                    </button>-->
                                </div>

                                <div class="space-4"></div>
                            </fieldset>
                        </form>


                    </div><!-- /widget-main -->

                    <div class="toolbar clearfix">



                    </div>
                </div><!-- /widget-body -->
            </div><!-- /login-box -->
        </div><!-- /position-relative -->
    </div>
</div>
<div class="loginbm">版权所有  <a href="">上海研鼎信息技术有限公司</a> </div><strong></strong>
</body>
</html>
