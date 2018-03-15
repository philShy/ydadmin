<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>研鼎商城后台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="/images/yd.png" type="image/x-icon">
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
    <!--[if !IE]> -->
    <script src="/js/jquery-1.9.1.min.js"></script>
    <!-- <![endif]-->
    <!--[if IE]>
    <script type="text/javascript">window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"script>");</script>
    <![endif]-->
    <script type="text/javascript">
        if("ontouchend" in document) document.write("<script src='/assets/js/jquery.mobile.custom.min.js'>"+"<"+"script>");
    </script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <!--[if lte IE 8]>
    <script src="/assets/js/excanvas.min.js"></script>
    <![endif]-->
    <script src="/assets/js/ace-elements.min.js"></script>
    <script src="/assets/js/ace.min.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript"></script>
    <script src="/assets/laydate/laydate.js" type="text/javascript"></script>
    <script src="/js/jquery.nicescroll.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(function(){
            var cid = $('#nav_list> li>.submenu');
            cid.each(function(i){
                $(this).attr('id',"Sort_link_"+i);

            })
        })
        jQuery(document).ready(function(){
            $.each($(".submenu"),function(){
                var $aobjs=$(this).children("li");
                var rowCount=$aobjs.size();
                var divHeigth=$(this).height();
                $aobjs.height(divHeigth/rowCount);
            });
            //初始化宽度、高度

            $("#main-container").height($(window).height()-76);
            $("#iframe").height($(window).height()-140);

            $(".sidebar").height($(window).height()-99);
            var thisHeight = $("#nav_list").height($(window).outerHeight()-173);
            $(".submenu").height();
            $("#nav_list").children(".submenu").css("height",thisHeight);

            //当文档窗口发生改变时 触发
            $(window).resize(function(){
                $("#main-container").height($(window).height()-76);
                $("#iframe").height($(window).height()-140);
                $(".sidebar").height($(window).height()-99);

                var thisHeight = $("#nav_list").height($(window).outerHeight()-173);
                $(".submenu").height();
                $("#nav_list").children(".submenu").css("height",thisHeight);
            });
            $(document).on('click','.iframeurl',function(){
                var cid = $(this).attr("name");
                var cname = $(this).attr("title");

                $("#iframe").attr("src",cid).ready();
            });
        });
        /******/
        $(document).on('click','.link_cz > li',function(){
            $('.link_cz > li').removeClass('active');
            $(this).addClass('active');
        });

        $( document).ready(function(){
            $('#nav_list,.link_cz').find('li.home').on('click',function(){
                $('#nav_list,.link_cz').find('li.home').removeClass('active');
                $(this).addClass('active');
            });
//时间设置
            function currentTime(){
                var d=new Date(),str='';
                str+=d.getFullYear()+'年';
                str+=d.getMonth() + 1+'月';
                str+=d.getDate()+'日';
                str+=d.getHours()+'时';
                str+=d.getMinutes()+'分';
                str+= d.getSeconds()+'秒';
                return str;
            }

            setInterval(function(){$('#time').html(currentTime)},1000);
//修改密码
            $('.change_Password').on('click', function(){
                layer.open({
                    type: 1,
                    title:'修改密码',
                    area: ['300px','300px'],
                    shadeClose: true,
                    content: $('#change_Pass'),
                    btn:['确认修改'],
                    yes:function(index, layero){
                        if ($("#password").val()==""){
                            layer.alert('原密码不能为空!',{
                                title: '提示框',
                                icon:0,

                            });
                            return false;
                        }
                        if ($("#Nes_pas").val()==""){
                            layer.alert('新密码不能为空!',{
                                title: '提示框',
                                icon:0,

                            });
                            return false;
                        }

                        if ($("#c_mew_pas").val()==""){
                            layer.alert('确认新密码不能为空!',{
                                title: '提示框',
                                icon:0,

                            });
                            return false;
                        }
                        if(!$("#c_mew_pas").val || $("#c_mew_pas").val() != $("#Nes_pas").val() )
                        {
                            layer.alert('密码不一致!',{
                                title: '提示框',
                                icon:0,

                            });
                            return false;
                        }
                        else{
                            layer.alert('修改成功！',{
                                title: '提示框',
                                icon:1,
                            });
                            layer.close(index);
                        }
                    }
                });
            });
            $('#Exit_system').on('click', function(){
                layer.confirm('是否确定退出系统？', {
                        btn: ['是','否'] ,//按钮
                        icon:2,
                    },
                    function(){
                        location.href="/login/index?del=1";
                    });
            });
        });
        function link_operating(name,title){
            var cid = $(this).name;
            var cname = $(this).title;
            $("#iframe").attr("src",cid).ready();
            $("#Bcrumbs").attr("href",cid).ready();
            $(".Current_page a").attr('href',cid).ready();
            $(".Current_page").attr('name',cid);
            $(".Current_page").html(cname).css({"color":"#333333","cursor":"default"}).ready();
            $("#parentIframe").html('<span class="parentIframe iframeurl"> </span>').css("display","none").ready();
            $("#parentIfour").html(''). css("display","none").ready();


        }
    </script>
</head>
<body>

<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>
    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="#" class="navbar-brand">
                <small>
                    <img src="/images/logo.jpg" style="height:54px;margin:10px 5px;">
                </small>
            </a><!-- /.brand -->
        </div><!-- /.navbar-header -->
        <div class="navbar-header operating pull-left">

        </div>
        <div class="navbar-header pull-right" role="navigation">

            <ul class="nav ace-nav">
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <span class="time"><em id="time"></em></span><span class="user-info"><small>欢迎光临,</small><?php echo Yii::app()->user->manager;?></span>
                        <i class="icon-caret-down"></i>
                    </a>
                    <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li><a href="javascript:void(0" name="Systems.html" title="系统设置" class="iframeurl"><i class="icon-cog"></i>网站设置</a></li>
                        <li><a href="javascript:void(0)" name="/transaction/orderform" title="个人信息" class="iframeurl"><i class="icon-user"></i>个人资料</a></li>
                        <li class="divider"></li>
                        <li><a href="javascript:ovid(0)" id="Exit_system"><i class="icon-off"></i>退出</a></li>
                    </ul>
                </li>
                <li class="purple">
                    <a id="aaaa" href="javascript:void (0)" style="height:45px;width:70px;margin-left: 165px">
                        <i class="icon-bell-alt" style="margin-top: 15px"></i>
                        <span class="badge badge-important">0</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
    </script>
    <div class="main-container-inner">
        <a class="menu-toggler" id="menu-toggler" href="#">
            <span class="menu-text"></span>
        </a>
        <div class="sidebar" id="sidebar">
            <script type="text/javascript">
                try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
            </script>
            <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large" style="display:none">
                    <a class="btn btn-success">
                        <i class="icon-signal"></i>
                    </a>

                    <a class="btn btn-info">
                        <i class="icon-pencil"></i>
                    </a>

                    <a class="btn btn-warning">
                        <i class="icon-group"></i>
                    </a>

                    <a class="btn btn-danger">
                        <i class="icon-cogs"></i>
                    </a>
                </div>

                <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini" style="display:none">
                    <span class="btn btn-success"></span>

                    <span class="btn btn-info"></span>

                    <span class="btn btn-warning"></span>

                    <span class="btn btn-danger"></span>
                </div>
            </div>
            <div id="menu_style" class="menu_style">
                <ul class="nav nav-list" id="nav_list">
                
                    <li class="home"><a href="/admin/index" class="iframeurl" title=""><i class="icon-home"></i><span class="menu-text"> 系统首页 </span></a></li>
                    <?php foreach($result0 as $key0=>$value0):?>
                        <?php $result1 = CManage::searchAuth1_Byauthid($authid_arr,$value0['id'])?>
                        <li><a href="#" class="dropdown-toggle"><i class="icon-desktop"></i><span class="menu-text"> <?php echo $value0['auth_name']?> </span><b class="arrow icon-angle-down"></b></a>
                            <ul class="submenu">
                            <?php foreach($result1 as $key1=>$value1):?>
                                <li class="home"><a  href="javascript:void(0)" name="<?php if($value1['pid']==$value0['id']){echo '/'.$value1['contrl'].'/'.$value1['action'];}?> "  title="<?php if($value1['pid']==$value0['id']){echo $value1['auth_name'];}?>" class="iframeurl"><i class="icon-double-angle-right"></i> <?php if($value1['pid']==$value0['id']){echo $value1['auth_name'];}?></a></li>
                            <?php endforeach;?>
                            </ul>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
            <script type="text/javascript">
                $("#menu_style").niceScroll({
                    cursorcolor:"#888888",
                    cursoropacitymax:1,
                    touchbehavior:false,
                    cursorwidth:"5px",
                    cursorborder:"0",
                    cursorborderradius:"5px"
                });
            </script>
            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
            </div>
            <script type="text/javascript">
                try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
            </script>
        </div>

        <div class="main-content">
            <script type="text/javascript">
                try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>
            <div class="breadcrumbs" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home home-icon"></i>
                        <a href="/admin/index">首页</a>
                    </li>
                    <li style='display:none' class="active"><span class="Current_page iframeurl"></span></li>
                    <li style='display:none' class="active" id="parentIframe"><span class="parentIframe iframeurl"></span></li>
                    <li style='display:none' class="active" id="parentIfour"><span class="parentIfour iframeurl"></span></li>
                </ul>
            </div>

            <iframe id="iframe" style="border:0; width:100%; background-color:#FFF;"name="iframe" frameborder="0" src="/home/index">  </iframe>


            <!-- /.page-content -->
        </div><!-- /.main-content -->

        <div class="ace-settings-container" id="ace-settings-container">
            <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn" style="display:none">
                <i class="icon-cog bigger-150"></i>
            </div>

            <div class="ace-settings-box" id="ace-settings-box">
                <div>
                    <div class="pull-left">
                        <select id="skin-colorpicker" class="hide">
                            <option data-skin="default" value="#438EB9">#438EB9</option>
                            <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                            <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                            <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                        </select>
                    </div>
                    <span>&nbsp; 选择皮肤</span>
                </div>

                <div>
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                    <label class="lbl" for="ace-settings-sidebar"> 固定滑动条</label>
                </div>

                <div>
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                    <label class="lbl" for="ace-settings-rtl">切换到左边</label>
                </div>

                <div>
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                    <label class="lbl" for="ace-settings-add-container">
                        切换窄屏
                        <b></b>
                    </label>
                </div>
            </div>
        </div><!-- /#ace-settings-container -->
    </div><!-- /.main-container-inner -->

</div>
<!--底部样式-->

<div class="footer_style" id="footerstyle">
    <script type="text/javascript">try{ace.settings.check('footerstyle' , 'fixed')}catch(e){}</script>
    <p class="l_f">版权所有：</p>
    <p class="r_f">地址： <a href="http://www.sucainiu.com/templates" target="_blank"></a></p>
</div>
<!--修改密码样式-->
<div class="change_Pass_style" id="change_Pass">
    <ul class="xg_style">
        <li><label class="label_name">原&nbsp;&nbsp;密&nbsp;码</label><input name="原密码" type="password" class="" id="password"></li>
        <li><label class="label_name">新&nbsp;&nbsp;密&nbsp;码</label><input name="新密码" type="password" class="" id="Nes_pas"></li>
        <li><label class="label_name">确认密码</label><input name="再次确认密码" type="password" class="" id="c_mew_pas"></li>
    </ul>
</div>
<!-- /.main-container -->
<!-- basic scripts -->
</body>
</html>
<script>

    $(function(){
        var sign = 1; //
        var page = 1; //当前页
        var pageAll = 1;//总页数
        var pageSize = 10;//每页显示条数
        var role = "<?php echo $auth_arr['role']?>";
        var url ='/admin/index'
        var $_this = $('#aaaa');
        $notice = $("<div id='notice' style='width:235px;background: #fff;position: relative;left: 165px;top:7px;border-radius: 3px'></div>");
        $_this.parents('.purple').append($notice);
        var icont = setInterval(message());
        $('#aaaa').click(function(){
            clearInterval(icont)
            $('.anotice').show()
            $('.anotice666').show()

        })
        $(".purple").on('click','.anotice666',function(){
            sign=1;
            page=1
            icont = setInterval(function(){ message(page,sign)},5000);
            $('.anotice').hide()
            $('.anotice666').hide()
        });
        $(".purple").on('click','.anotice',function(){
            var order_id = $(this).find('a').attr('order_id');
            $.post(url,{code:2,order_id:order_id,time:show()},function(data){})
        });
        function show(){
            var timestamp=new Date().getTime();
            return timestamp;
        }
        function message(){
            $.post(url,{code:1},function(data){
                //console.log(data)
                var jj = jQuery.parseJSON(data)
                //console.log(jj.pin)
                if(jj.pin!='')
                {
                    $_this.parents('.purple').find('.badge').html(jj.pin.length);
                    $_this.parents('.purple').find('#notice').show();
                    showPage(jj,page,sign);//显示分页
                }
            })
        }
        //分页方法
        function showPage(message,now,sign){
            var total = message.pin.length;
            var _LENGTH = 5;//最大页数5
            var pageArr = [];//
            //整页
            if(total%pageSize==0){
                pageAll = total/pageSize;
            }else{//非整页
                pageAll = (total - total%pageSize)/pageSize + 1;
            }
            //总页数小于5页
            if(pageAll<=_LENGTH){
                for(var i = 0 ;i < pageAll; i++){
                    pageArr[i] = i+1;
                }
            }else{//总页数大于5页
                if(now+2 <= pageAll&&now-2 > 0){//当前页没有超过总页数
                    for(var i = 0 ;i < _LENGTH; i++){
                        pageArr[i] = now-2 + i;
                    }
                }else if(now<=2){
                    pageArr = [1,2,3,4,5] ;
                }else{
                    for(var i = 0 ;i < _LENGTH; i++){
                        pageArr[i] = pageAll-4+i;
                    }
                }
            }
            //绘制页面
            drawPage(message,pageArr,now,pageAll,sign);
        }
        //绘制分页dom方法
        function drawPage(message,pageArr,now,pageAll,sign){
            var _html = "";
            if(sign==1)
            {
                _html+="<div class='anotice' style='display:none'>";
            }else{
                _html+="<div class='anotice' style='display:'>";
            }

            for(var i = now*10-10; i<now*10; i++){
                var order_id = message.order_id[i];
                var order_sub_id = message.order_sub_id[i];
                var pin = message.pin[i];
                if(order_sub_id!=null)
                {
                    var name="/transaction/orderdetail?id="+order_sub_id+"&type=1";
                }else{
                    var name="/transaction/orderdetail?id="+order_id+"&type=0";
                }
                if(pin == undefined)
                {
                    pin='';
                }
                _html += "<div style='height:25px;margin-left:5px' class='message'><a order_id="+order_id+" order_sub_id="+order_sub_id+" class=iframeurl href=javascript:void(0) name="+name+">"+pin+"</a></div>";
            }
            _html += "<span style='margin:0 50px 0 10px;color:red' class='pagenow'></span>";
            _html += "<span class='pagelist'><a style='margin-left: 15px;' class='fff' href='javascript:void(0);'>上一页</a>";
            /*for(var i = 0; i<pageArr.length; i++){
                _html += "<a style='margin-left: 10px;' class='fff ffff' href='javascript:void(0);'>"+pageArr[i]+"</a>";
            }*/
            _html += "<a style='margin-left: 15px;' class='fff' href='javascript:void(0);'>下一页</a></span>";
            _html+="</div>";
            if(sign==1)
            {
                $notice.html("<a style='display:none;color:red;text-decoration:none;cursor:pointer;width:20px;height:20px;position: absolute;top:-18px;left: 225px;font-size:16px' class='anotice666'>x</a>"+_html);
            }else{
                $notice.html("<a style='display:;color:red;text-decoration:none;cursor:pointer;width:20px;height:20px;position: absolute;top:-18px;left: 225px;font-size:16px' class='anotice666'>x</a>"+_html);
            }

            var index = getIndex(pageArr,now);
            $(".pagelist .ffff").eq(index).css({"background":"#CCC"});
            $(".pagenow").text(now+"/"+pageAll);
        }
        //获取点击当前页坐标
        function getIndex(pageArr,now){
            var index = 0;
            for (var i = 0 ; i < pageArr.length; i++){
                if(pageArr[i] == now ){
                    index = i;
                }
            }
            return index;
        }
        //点击分页
        $("#notice").on("click",".fff",function(){
            $('.anotice').show()
            $('.anotice666').show()
            var text = $(this).text();//获取当前点击页数
            if(text == "上一页"){ //如果是点击的上一页
                if(page>1){
                    page--;
                }else{
                    //alert("已经是第一页");
                }
            }else if(text == "下一页"){//如果是点击的下一页
                if(page<pageAll){
                    page++;
                }else{
                    //alert("已经是最后一页");
                }
            }else{
                page = parseInt(text);//将获取的页数转化成数字
            }
            sign = 2;
            message(page,sign);
        });
    })

</script>

