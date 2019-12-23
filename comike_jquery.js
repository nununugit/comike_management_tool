$(function() {
    var s1=$("#doujin1");
    var s2=$("#doujin2");
    var s3=$("#company1");
    var s4=$("#company2");

    
    s2.hide();
    s3.hide();
    s4.hide();

// 「#change-css」要素に対するclickイベントを作成してください
    $("#doujinres").click(
        function(){
            $(".current").removeClass("current");
            $(this).addClass("current");
            s1.show();
            s2.hide();
            s3.hide();
            s4.hide();
    })

    $("#doujinlist").click(
        function(){
            $(".current").removeClass("current");
            $(this).addClass("current");
            s1.hide();
            s2.show();
            s3.hide();
            s4.hide();
    })

    $("#companyres").click(
        function(){
            $(".current").removeClass("current");
            $(this).addClass("current");
            s1.hide();
            s2.hide();
            s3.show();
            s4.hide();
        })
    
    $("#companylist").click(
        function(){
            $(".current").removeClass("current");
            $(this).addClass("current");
            s1.hide();
            s2.hide();
            s3.hide();
            s4.show();
        })
});