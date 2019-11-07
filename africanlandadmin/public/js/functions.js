$(document).ready(function(){
    $('#clickShow').on('change',function(){
        $('#castDate').toggle()
    })
})


$(document).ready(function () {

    if($('.datetimepicker').length > 0)
    {
        $('.datetimepicker').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD',
            clearButton: true,
            weekStart: 1,
            time: false,
            minDate:new Date()
        });
    }
    if($('.ckeditor').length > 0)
    {
        CKEDITOR.replace('ckeditor');
        CKEDITOR.config.height = 300;
    }

    $('.searchlist select').change(function(){
        $('.searchlist').submit();
    });

});




function show_services(chk)
{
    if(chk == 1)
    {
        $('.additional_services').show();
    }
    else
    {
        $('.additional_services').hide();
    }
}

function show_tax_rate(obj)
{
   $(".taxrate_box").addClass('d-none');
   if($(obj).val() == 1)
   {
        $(".taxrate_box").removeClass('d-none');
   }
}

function makeFavorite(property_id,action)
{
    var token  = $('#site_csrf_token').val();
    $.ajax({
        method: 'post',
        url: makefavoriteurl,
        data: { _token : token, property_id : property_id, action : action },
        success: function(data){
             alert(data);
             location.reload();
        },

    });
}

$(document).ready(function(){
    $('#getData').change(function(){
        var targetId = $('#getData').data('value');
        var value = $('#getData').val();
        $.ajax({
            method : 'get',
            url: getDataUrl,
            data: { roleId : value },
            success: function(data){
                $('#'+targetId).html(data)
            }
        })
    })
})


function getcity(obj)
{
	var token  = $('input[name=_token]').val();
	var country = $(obj).val();
	$.ajax({
        method: 'post',
        url: getcityurl,
        data: { _token : token, country : country },
        success: function(data){
             $(".citywrap").html(data);
        },

    })
}

function gethostlists(obj)
{
    var token  = $('input[name=_token]').val();
    var city = $(obj).val();
    $.ajax({
        method: 'post',
        url: gethostlistsurl,
        data: { _token : token, city : city },
        success: function(data){
            $(".hostlistwrap").html(data);

            if($('.hosttypewrap').length > 0)
            {
                $(".hosttypewrap").html('<option value="">Please Select</option>');
            }
            if($('.subtypewrap').length > 0)
            {
                $(".subtypewrap").html('<option value="">Please Select</option>');
            }

        },

    })
}

function gethosttype(obj)
{
    var token  = $('input[name=_token]').val();
    var host_name = $(obj).val();
    $.ajax({
        method: 'post',
        url: gethosttypeurl,
        data: { _token : token, host_name : host_name },
        success: function(data){
            $(".hosttypewrap").html(data);
            if($('.subtypewrap').length > 0)
            {
                $(".subtypewrap").html('<option value="">Please Select</option>');
                getsubtype($(".hosttypewrap"))
            }
        },

    })
}

function getsubtype(obj)
{
    var token  = $('input[name=_token]').val();
    var type = $(obj).val();
    $.ajax({
        method: 'post',
        url: getsubtypeurl,
        data: { _token : token, type : type },
        success: function(data){
             $(".subtypewrap").html(data);
        },

    })
}


//facbook login



window.fbAsyncInit = function() {
    FB.init({
        appId : '326542041394048',
        cookie : true,
        xfbml : true,
        version : 'v2.8'
    });
};

(function(d, s, id)
{
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function fbLoginFunction()
{
    FB.login(function(response)
    {
        if (response.authResponse)
        {
            FB.api('/me', 'get', { fields: 'id,name,gender,hometown,email' }, function(response)
            {
                var token  = $('#site_csrf_token').val();
                $.ajax({
                    method: 'post',
                    url: sociallogin,
                    data: { _token : token, email : response.email , name : response.name},
                    success: function(data){
                        location.reload();
                    },

                });
            });
        }
        else
        {
            alert("Login attempt failed!");
        }
    }, { scope: 'email,public_profile' });
}
// end facebook login
