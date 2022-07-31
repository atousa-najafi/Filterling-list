
$ = jQuery;
$('#range-slider-value').html( "$" + $('.range-slider').val());
$(document).on('input', '.range-slider', function() {
    $('#range-slider-value').html( "$" + $(this).val());
});

$("#clear-list").click(function(){
    window.location.href = window.location.href.split('?')[0];
});

$("#submit-filter").click(function(event){
    event.preventDefault();
    var resolvedUrl = $.fn.allOption();
    var ajaxContent = "";
    $.ajax({
        type: 'GET',
        url: resolvedUrl,
        contentType: "application/json",
        dataType: 'json',
        beforeSend: function (xhr) {
           // xhr.setRequestHeader('X-WP-Nounce', myobj.test_nounce);
            $(".show-post").addClass("show");
        },
        success: function (response) {
            $(".show-post").removeClass("show");
            if (!$.trim(response)){
                $('.show-post').html("<div style='margin-top:10px;'>Sorry, but there is no content matches the filters!</div>");
            }else{
                for (let i in response) {
                    ajaxContent += response[i].content;
                  }
               $('.show-post').html(ajaxContent);
            }
                
        }
        
    });

});


$.fn.allOption = function(){
   
var customURL = myobj.home_url+"/wp-json/my-route/v2/"+site.post_type_slug+"?";
    $.each($(".affiliate-opt option:checked"), function(){
        optName = $(this).parent().attr('name');
        optSelected = $(this).val();  
        customURL += optName+"="+optSelected+"&";
    });   

    $.each($("input[name='online_account_types[]']:checked"),function(){
        optName = $(this).attr('name');
        checkboxes= $(this).val();
        customURL += optName+"="+checkboxes+"&";
    });

    $.each($("input[type='range']"), function(){
        optName = $(this).attr('name');
         var currentRange = $('.range-slider').val();
        customURL += optName+"="+currentRange+"&";
    });  
    return customURL;  
};
