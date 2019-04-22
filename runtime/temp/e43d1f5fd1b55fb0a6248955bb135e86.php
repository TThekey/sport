<?php /*a:1:{s:55:"/var/www/web/sport/application/api/view/scan/watch.html";i:1555564799;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>index</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        .app {
            text-align: center;
            box-sizing: border-box;
            width: 100%;
            font-size: 18px;
            color: #888888;
            padding: 0 32px;
        }

        .app img {
            width: 150px;
            height: 152px;
            display: inline-block;
            margin-top: 66px;
        }
        .line2{
            font-size: 24px;
            color: #000000;
            line-height: 70px;
        }
        .modal, .drak{
            width: 100%;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .drak {
            width: 100%;
            height: 100vh;
            background-color: rgba(100, 100, 100, 0.88);
        }
        .box{
            z-index: 50000;
            width: 60%;
            text-align: center;
            padding: 0  22px;
            border-radius: 10px;
            background-color: white;
        }
        .box_t{
            font-size: 14px;
            line-height: 50px;
            border-bottom: 1px solid #ededed;
            box-sizing: border-box;
        }
        .box_c {
            padding: 10px 10px 0 10px;
        }
        .box_c>img{
            width: 100%;
            height: 100%;
        }
        .box_b{
            padding:10px;
        }
        .box_b>div{
            line-height: 36px;
            border-radius: 6px;
            color: #09BB07;
            border: 2px solid #09BB07;
        }
    </style>
    <!--<script src="axios.js"></script>-->
</head>
<body>
<div id="app" class="app">
    <div id="yes">
        <div><img src="http://sport.jiyichuancheng.com/static/api/img/yes.png" alt=""></div>
        <div class="line2">该产品是正版</div>
    </div>
    <div id="no">
        <div><img src="http://sport.jiyichuancheng.com/static/api/img/no.png" alt=""></div>
        <div class="line2">该产品可能是仿品</div>
        <div>
            <span>上次扫描时间<span class="scan"></span>, 您是第</span><span style="color:#F76260;"  class="nub"></span> 个扫描ID。 <span style="color: #576B95;">建议联系商家或品牌方处理</span>
        </div>
    </div>
    <div id="ok">
        <div><img src="http://sport.jiyichuancheng.com/static/api/img/ok.png" alt=""></div>
        <div class="line2">该产品是正版</div>
        <div>上次扫描时间<span class="scan"></span>, 您是第<span class="nub"></span>个扫描ID</div>
    </div>
</div>
<div class="modal" id="modal">
    <div class="drak"></div>
    <div class="box">
        <div class="box_t">关注公众号</div>
        <div class="box_c"><img src="http://sport.jiyichuancheng.com/static/api/img/no.png"></div>
        <div class="box_b"><a id="guan" href="https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzU2OTc0NTk0Nw==&scene=126&bizpsid=0&subscene=0#wechat_redirect">点击关注</a></div>
    </div>
</div>
<script type="text/javascript" src="http://sport.jiyichuancheng.com/static/api/js/jquery-2.2.3.min.js" ></script>
<script>
    var time = "<?php echo $req['time']; ?>";
    var scandate= "<?php echo $req['scandate']; ?>";
    var msgcode= "<?php echo $req['msgcode']; ?>";


    function UnixToDate(unixTime, isFull, timeZone) {
        if (typeof (timeZone) == 'number')
        {
            unixTime = parseInt(unixTime) + parseInt(timeZone) * 60 * 60;
        }
        var time = new Date(unixTime * 1000);
        var ymdhis = "";
        ymdhis += time.getUTCFullYear() + "-";
        ymdhis += (time.getUTCMonth()+1) + "-";
        ymdhis += time.getUTCDate();
        if (isFull === true)
        {
            // ymdhis = ymdhis/1000;

            ymdhis += " " + time.getUTCHours() + ":";
            ymdhis += time.getUTCMinutes() + ":";
            ymdhis += time.getUTCSeconds();
        }
        return ymdhis;
    }

    //转换时间戳
    scandate = UnixToDate(scandate,true);


    window.onload = function () {
        $("#ok").hide();
        $('#yes').hide();
        $('#no').hide();
        $("#guan").click(
            function () {
                $("#modal").hide();

                //第一次扫描和单用户多次扫描
                if (time == 0 || msgcode == 10000) {
                    $("#yes").show();
                }
                //正常扫描
                else if (msgcode == 10001) {
                    if (time > 1 && time < 10) {
                        //扫描次数在1到10次
                        $("#ok").show();
                        $('.nub').html(time);
                        $('.scan').html(scandate);
                    } else {
                        //扫描次数大于等于10次
                        $("#no").show();
                        $('.nub').html(time);
                        $('.scan').html(scandate);
                    }
                }
            }
        );
    }
</script>
<!--<script src="vue.js"></script>-->
<!--<script>-->

<!--var app = new Vue({-->
<!--el: '#app',-->
<!--data: {-->
<!--show:false,-->
<!--id: 11,-->
<!--arr: []-->
<!--},-->
<!--created: function () {-->
<!--let url = 'http://132.232.128.110:8080/bookStore/getBookList.php';-->
<!--let _this = this;-->
<!--axios.get(url, {-->
<!--params: {-->
<!--pIndex: 0,-->
<!--pSize: 100-->
<!--}-->
<!--}).then((res) => {-->
<!--console.log(res)-->
<!--_this.arr = res.data.data;-->
<!--}).catch(function (error) {-->
<!--console.log(err)-->
<!--});-->
<!--}-->
<!--})-->

<!--</script>-->
</body>
</html>