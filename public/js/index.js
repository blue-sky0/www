$(document).ready(function () {
    Infoheight = window.innerHeight;
    scrollHeight = Infoheight / 2;
    Height = $(window).scrollTop();
    console.log(Infoheight,Height)

    $(window).scroll(function(){
        if($(this).scrollTop() > scrollHeight){
            $('.up_top').fadeIn();
        }else{
            $('.up_top').fadeOut();
        }
    });
    $(".up_top").click(function () {
        $('html, body').animate({scrollTop:0}, 300);
        return false;
    });

    function updateTime() {
        var now = new Date();
        var year = now.getFullYear();
        var month = String(now.getMonth() + 1).padStart(2, '0'); // 月份从0开始，所以+1
        var day = String(now.getDate()).padStart(2, "0");
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds();
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        var timeString = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
        document.getElementById('UTC').textContent = timeString;
    }
    
    setInterval(updateTime, 1000); // 每秒更新一次时间
});