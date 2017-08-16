<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    <title>Chat Room</title>
    <link href="public/css/mdui.min.css" rel="stylesheet" type="text/css">
</head>
<?php

if(!$_POST['username']){
    exit("非法操作");
    return;
}

?>
<body class=" mdui-appbar-with-toolbar mdui-theme-primary-indigo mdui-theme-accent-pink">
<header class="mdui-appbar mdui-appbar-fixed">
    <div class="mdui-toolbar mdui-color-theme">
        <span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white" mdui-drawer="{target: '#main-drawer'}"><i class="mdui-icon material-icons">menu</i></span>
        <a href="./" class="mdui-typo-headline mdui-hidden-xs">Chat Room</a>
        <div class="mdui-toolbar-spacer"></div>
    </div>
</header>
<div class="mdui-container mdui-shadow-7" style="margin-top: 20px;">
    <div class="mdui-row" style="border-bottom: 1px solid #E0E0E0;">
        <div class="mdui-col-xs-3 " style="border-right: 1px solid #E0E0E0">
            <ul class="mdui-list" >

                <li class="mdui-subheader-inset">在线用户</li>
                <div id="user_list">

                </div>
            </ul>
        </div>
        <div class="mdui-col-xs-9">
            <div id="content">
            </div>
        </div>
    </div>
    <div class="mdui-row ">
        <div class="mdui-textfield mdui-textfield-floating-label mdui-textfield-has-counter">
            <label class="mdui-textfield-label">聊骚</label>
            <textarea class="mdui-textfield-input" id="message" maxlength="100"></textarea>
            <div class="mdui-textfield-counter"><span class="mdui-textfield-counter-inputed">0</span> / 100</div></div>
    </div>
    <div class="mdui-row mdui-container" style="margin-bottom: 15px">
        <button class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" onclick="sendMessage()">发送</button>
    </div>
</div>
<script src="public/js/mdui.min.js" type="application/javascript"></script>

<script type="text/javascript">
    var  $$ = mdui.JQ;
    if(window.WebSocket){
        <?php if($_POST){$username=$_POST['username'];}else{exit('非法访问');}?>
        var webSocket = new WebSocket("ws://182.61.46.229:9503?name=<?php echo $username; ?>");
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
</script>
</body>
</html>
