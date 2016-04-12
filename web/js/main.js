$(document).ready(function() 
{
    $(".close").css("display", "none");
 
    var isMenuOpen = false;
 
    $('.menu_btn').click(function()
    {
        if (!isMenuOpen)
        {
            $("#menu").clearQueue().animate({
                left : '0'
            });
            $("#page").clearQueue().animate({
                "margin-left" : '290px'
            });
             
            $(this).fadeOut(200);
            $(".close").fadeIn(300);
             
            isMenuOpen = true;
        } 
    });
     
    $('.close').click(function()
    {
        if (isMenuOpen)
        {
            $("#menu").clearQueue().animate({
                left : '-240px'
            });
            $("#page").clearQueue().animate({
                "margin-left" : '60px'
            });
             
            $(this).fadeOut(200);
            $(".menu_btn").fadeIn(300);
             
            isMenuOpen = false;
        }
    });
});
