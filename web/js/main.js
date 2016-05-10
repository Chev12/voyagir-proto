
$(document).ready(function() 
{
    // Menu
    $(".close").css("display", "none");
 
    var isMenuOpen = false;
 
    $('.menu-btn').click(function()
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
                "margin-left" : 'auto'
            });
             
            $(this).fadeOut(200);
            $(".menu-btn").fadeIn(300);
             
            isMenuOpen = false;
        }
    });
    
    // <h1> 
    $('h1').each(function() {
        $(this).prepend("<i class=\"fa fa-envira\" aria-hidden=\"true\"></i>&nbsp;");
    });
});
