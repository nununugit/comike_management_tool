$(function() {
    // 「#change-css」要素に対するclickイベントを作成してください
    $("#doujinres").click(
        function(){
        $(".doujin1").removeClass("inactive")
        $(".doujin1").addClass("active")
    })

    $("#doujinlist").click(
        function(){
        $(".doujin2").removeClass("inactive")
        $(".doujin2").addClass("active")
    })

    $("#companyres").click(
        function(){
        $(".company1").removeClass("inactive")
        $(".company1").addClass("active")
    })
    
    $("#companylist").click(
        function(){
        $(".company2").removeClass("inactive")
        $(".company2").addClass("active")
    })
});