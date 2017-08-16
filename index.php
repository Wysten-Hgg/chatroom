<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    <title>Chat Room</title>
    <link href="public/css/mdui.min.css" rel="stylesheet" type="text/css">
</head>
<body class="mdui-theme-primary-pink mdui-theme-accent-pink">
<div class="mdui-row">
    <div class="mdui-text-center" style="margin-top: 100px">
        <img src="public/img/logo.png"  class="mdui-img-circle" width="180px" height="180px" />
    </div>
</div>
<div class="mdui-row">
    <div class="mdui-col-xs-4"></div>
    <div class="mdui-col-xs-4" style="margin-top: 100px">
        <form action="room.php" method="post" id="form1">
            <div class="mdui-textfield mdui-textfield-floating-label">
                <label class="mdui-textfield-label">为自己起个牛逼的名字</label>
                <input class="mdui-textfield-input" type="text" id="username" name="username">
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="mdui-text-center" style="margin-top: 10px">
        <button class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent" id="start">开始</button>
    </div>
</div>

<script src="public/js/mdui.min.js"></script>


<script>
    var $$ = mdui.JQ;
    $$("#start").on('click',function(){
        var username= document.getElementById("username").value;
        if(username==""){
            mdui.alert('请输入名字!','错误');
            return false;
        }
        document.getElementById("form1").submit();

    })

</script>
</body>
</html>