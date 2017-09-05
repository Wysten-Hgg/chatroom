
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>视频直播</title>
    <link rel="stylesheet" href="public/css/mdui.min.css?v=0.3.0"/>
    <link rel="stylesheet" href="//mdui-org.b0.upaiyun.com/docs/assets/highlight-9.12.0/styles/github-gist.css"/>
    <link rel="stylesheet" href="//mdui-org.b0.upaiyun.com/docs/assets/highlight-9.12.0/styles/railscasts.css"/>

    <link href="http://vjs.zencdn.net/5.5.3/video-js.css" rel="stylesheet">

    <!-- If you'd like to support IE8 -->
    <script src="http://vjs.zencdn.net/ie8/1.1.1/videojs-ie8.min.js"></script>
    <script src="http://vjs.zencdn.net/5.5.3/video.js"></script>
    <script src="https://cdn.bootcss.com/jquery/2.2.2/jquery.min.js"></script>


</head>
<body class="mdui-drawer-body-left mdui-appbar-with-toolbar  mdui-theme-primary-indigo mdui-theme-accent-pink">
<header class="mdui-appbar mdui-appbar-fixed">
    <div class="mdui-toolbar mdui-color-theme">
        <span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white" mdui-drawer="{target: '#main-drawer'}"><i class="mdui-icon material-icons">menu</i></span>
        <a href="./" class="mdui-typo-headline mdui-hidden-xs">Chat Room</a>
        <div class="mdui-toolbar-spacer"></div>
    </div>
</header>



<a id="anchor-top"></a>

<div class="doc-container doc-no-cover mdui-col-md-4" style="margin-top:30px;" id="video">
    <video id="my-video" class="video-js mdui-shadow-10 " controls preload="auto" width="750" height="350"
           poster="http://wx2.sinaimg.cn/mw1024/9d52c073gy1fj233hj5ymj20k80pawqt.jpg" data-setup="{}">
        <source src="rtmp://your ip" type="rtmp/mp4">
        <!-- 如果上面的rtmp流无法播放，就播放hls流 -->
        <source src="http://your ip" type='application/x-mpegURL'>
        <p class="vjs-no-js">播放视频需要启用 JavaScript，推荐使用支持HTML5的浏览器访问。
            To view this video please enable JavaScript, and consider upgrading to a web browser that
            <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
        </p>
    </video>

</div>
<div class="mdui-row" style="">

<div class="mdui-drawer mdui-drawer-right" id="main-drawer"
     style="width: 338px;margin-bottom: 15%;margin-top: 30px;">
    <div class="mdui-list" mdui-collapse="{accordion: true}"  >
        <div style="margin-left: 20px;" id="content">

        </div>
    </div>
</div>

</div>


<div class="mdui-row mdui-col-md-6;" >
    <div class="mdui-textfield mdui-textfield-floating-label mdui-textfield-has-counter">
        <label class="mdui-textfield-label">聊骚</label>
        <textarea class="mdui-textfield-input" id="message" maxlength="100"></textarea>
        <div class="mdui-textfield-counter"><span class="mdui-textfield-counter-inputed">0</span> / 100</div>
    </div>
    <button id="submit" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" onclick="sendMessage()">发送</button>
</div>

<script src="//mdui-org.b0.upaiyun.com/docs/assets/smooth-scroll-11.1.0/smooth-scroll.min.js"></script>
<script src="//mdui-org.b0.upaiyun.com/docs/assets/holder-2.9.4/holder.min.js"></script>
<script src="//mdui-org.b0.upaiyun.com/docs/assets/highlight-9.12.0/highlight.pack.js"></script>
<script src="//mdui-org.b0.upaiyun.com/source/dist/js/mdui.min.js?v=0.3.0"></script>

<script src="//mdui-org.b0.upaiyun.com/docs/assets/docs/js/docs.js?v=20170815"></script>

<script type="text/javascript">
    var  $$ = mdui.JQ;
    if(window.WebSocket){
    <?php if($_POST['username']){$username=$_POST['username'];}else{exit('非法访问');return;}?>
        var webSocket = new WebSocket("ws://you ip?name=<?php echo $username; ?>");
        webSocket.onopen = function (event) {

        };
        webSocket.onmessage = function (event) {
            var content = document.getElementById('content');
            var obj=JSON.parse(event.data);
            if(obj.type==0){
                var html="";
                console.log(obj);
                for(var i in obj.user_list){
                    html+=' <li class="mdui-list-item mdui-ripple">'+
                    '<div class="mdui-list-item-avatar"><i class="mdui-icon material-icons mdui-icon-dark"></i></div>'+
                    '<div class="mdui-list-item-content">'+obj.user_list[i].name+'</div>'+
                    '</li>'
                }
                $$('#user_list').empty();
                $$('#user_list').append(html);
                content.innerHTML = content.innerHTML.concat('<p style="margin-left:20px;height:20px;line-height:20px;">'+obj.msg+'</p>');

            }else if(obj.type==1){
                var html="";
                console.log(obj);
                for(var i in obj.user_list){
                    html+=' <li class="mdui-list-item mdui-ripple">'+
                    '<div class="mdui-list-item-avatar"><i class="mdui-icon material-icons mdui-icon-dark"></i></div>'+
                    '<div class="mdui-list-item-content">'+obj.user_list[i].name+'</div>'+
                    '</li>'
                }
                $$('#user_list').empty();
                $$('#user_list').append(html);
                content.innerHTML = content.innerHTML.concat('<p style="margin-left:20px;height:20px;line-height:20px;">'+obj.msg+'</p>');
            } if(obj.type==2){
                console.log(obj);
                content.innerHTML = content.innerHTML.concat('<p style="margin-left:20px;height:20px;line-height:20px;">'+obj.msg+'</p>');
            }

        }

        var sendMessage = function(){
            var data = document.getElementById('message').value;
            if(data.trim()==""){
                mdui.alert('不能发送空消息','错误');
                return false;
            }
            webSocket.send(data);
            $$('#message').val('');
        }


    }else{
        console.log("您的浏览器不支持WebSocket");
    }

    $(document).keyup(function(event){
        if(event.keyCode ==13){
            $("#submit").trigger("click");
        }
    });
</script>
