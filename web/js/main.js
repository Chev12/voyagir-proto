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
            /*$("#page").clearQueue().animate({
                "margin-left" : '290px'
            });*/
             
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
            /*$("#page").clearQueue().animate({
                "margin-left" : 'auto'
            });*/
             
            $(this).fadeOut(200);
            $(".menu-btn").fadeIn(300);
             
            isMenuOpen = false;
        }
    });
    
    // Registration
    function checkPassword(){
        var result = true;
        var password = $("#fos_user_registration_form_plainPassword_first").val();
        var reg = /(?=.*[a-z])/;
        hidePwdErrors();
        if (!reg.test(password)) {
            $("#pwd_error1").css("display", "block");
            result = false;
        }
        reg = /(?=.*[A-Z])/;
        if (!reg.test(password)) {
            $("#pwd_error2").css("display", "block");
            result = false;
        }
        reg = /.{6,}/;
        if (!reg.test(password)) {
            $("#pwd_error3").css("display", "block");
            result = false;
        }
        return result;
    }
    
    function hidePwdErrors(){
        $(".pwd_error").each(function(index, element) {
            $(element).css("display", "none");
        });
    }
    
    $(".fos_user_registration_register").submit(function() {
        return checkPassword(this);
    });
    $("#fos_user_registration_form_plainPassword_first").focusout(function() {
        checkPassword(this);
    });
    hidePwdErrors();
});
