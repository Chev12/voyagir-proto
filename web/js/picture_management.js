$(document).ready(function() 
{
    $("#establishment_imageOffset").change(function(){
        var $offset = -1* $("#establishment_imageOffset").val(),
            $css = { 'background-position-y' : $offset };
        $("#etb-picture").animate($css);
    });
    
    $("textarea").focus(function(){
        $(this).animate({ 'height' : '200px' });
    });
    
    $("textarea").focusout(function(){
        $(this).animate({ 'height' : '50px' });
    });
});