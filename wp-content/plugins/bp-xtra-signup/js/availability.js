jQuery(document).ready(function(){
    jQuery("input#signup_username").wrap("<div id='username_checker'></div> ");
    jQuery("#username_checker").append("<span class='loading' style='display:none'></span>")
    jQuery("#username_checker").append("<span id='name-info'></span> ");

    jQuery("input#signup_username").bind("blur",function(){
        jQuery("#username_checker #name-info").css({display:'none'});
        jQuery("#username_checker span.loading").css({display:'block'});

        var user_name = jQuery("input#signup_username").val();

        console.log("Ajax URL: " + ajaxurl);
        //myURL = '/custom-ajax/index.php';
        //console.log("myURL: " + myURL);

        jQuery.post( ajaxurl, {
                action: 'check_username',
                'cookie': encodeURIComponent(document.cookie),
                'user_name':user_name,
            },
            function(response){
                var resp = jQuery.parseJSON(response);

                if(resp.code == 'success')
                    show_message(resp.message,0);
                else
                    //console.log("Response message: " + resp.message);
                    show_message(resp.message,1);
            });
    });

    function show_message(msg,is_error)	{
        jQuery("#username_checker #name-info").removeClass().css({display:'block'});
        jQuery("#username_checker span.loading").css({display:'none'});
        jQuery("#username_checker #name-info").empty().html(msg);

        if(is_error) {
            jQuery("#username_checker #name-info").addClass("error");
            jQuery("#username_checker #name-info").empty().html(msg);
        } else {
            jQuery("#username_checker #name-info").addClass("available");
        }

    }
});