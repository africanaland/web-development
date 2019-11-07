/* show password in login page */
function ShowPassword(){
    var value = document.getElementById('password').getAttribute('type');
    if(value == 'password'){
        var value = document.getElementById('password').setAttribute('type','text');
        var value = document.getElementById('pwsBtn').innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
    }
    else{
        var value = document.getElementById('password').setAttribute('type','password');
        var value = document.getElementById('pwsBtn').innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
    }
}


/* calculations page height size */
$(document).ready(function(){
    winH = $('.wrapper ').height();
    var height = winH;
    if(winH < 400){
        $('.footerHomePage2').css({ 'bottom': '0' , 'top' : 'unset'});
    }
    else{
        $('.footerHomePage2').css('top',height);
    }
})



/* chat nav link */
$(document).ready(function(){
    $('.chat-nav').on('click',function(){
        if($('.nav-panel').hasClass('active')){
            $('.nav-panel').removeClass('active');
            $('.chat-nav').addClass('border');
            $('.chat-nav > .icon1').removeClass('d-none');
            $('.chat-nav > .icon2').addClass('d-none');
        }
        else{
            $('.nav-panel').addClass('active');
            $('.chat-nav').removeClass('border');
            $('.chat-nav > .icon1').addClass('d-none');
            $('.chat-nav > .icon2').removeClass('d-none');
        }
    });
});





/* user profile gender select */
$(document).on('click','.btn-user', function(){
    $('.btn-user' ).removeClass('active');
    $(this).addClass('active');
    var value = $(this).data('value');
    // $('.checkDiv input').attr('checked','checked');
    if($('.checkDiv input').is(":checked")){
        $('.checkDiv input').removeAttr('checked');
    }
    $('#'+value).attr('checked','checked');

});


/* select payment method on booking */
$(document).on('click','.selectPayment',function(){
        $('.selectPayment').removeClass('radio-control-fill');
        var id = $(this).data('value');
        $(this).addClass('radio-control-fill');
        if($('.selectPayment input').is(":checked")){
            $('.selectPayment input').removeAttr('checked');
        }
        $('#'+id).attr('checked','checked');
        if(id == 'paypal'){
            $('#paymentBtn').hide();
            $('#paypalBtn').show();
        }
        else{
            $('#paypalBtn').hide();
            $('#paymentBtn').show();
        }
});




/* image upload btn */
$(document).ready(function(){
    $(".chat-upload-image").click(function(){
        $(".chat-upload-image-tag").click();
        $('.chat-upload-image-tag').change(function(e){
            $('.chat-upload-image').addClass('active');
            $('.upload-file-name').html(e.target.files[0].name);
        });
       });

});


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

    if($('.loginPopup').length > 0)
    {
       //$(".loginPopup").colorbox({iframe:true, width:"35%", height:"80%",closeButton: false});
    }

    if($('.radio-control-checkbox').length > 0)
    {
        $(".radio-control-checkbox").click(function () {
            var checkboxId = $(this).data('value');
            if($('.data-'+checkboxId).is(":checked")){
                $(this).removeClass("radio-control-active");
                $('.data-'+checkboxId).removeAttr('checked');
                if(checkboxId == 'other'){
                    $("#service_other").addClass("d-none");
                }
            }
            else{
                $('.data-'+checkboxId).attr('checked','checked');
                $(this).addClass("radio-control-active");
                if(checkboxId == 'other'){
                    $("#service_other").removeClass("d-none");
                }

            }
        });
    }

    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

    if($('.datepicker-input').length > 0)
    {
        $('.datepicker-input').datepicker({ startDate: today,format: 'dd-mm-yyyy' });
    }


});

function openPopup(popupUrl,frmData = '',modalWidth = '')
{
    $("#afModal").find(".modal-loader").show();
    $("#afModal").find(".modal-dialog modal-dialog-centered").removeClass().addClass("modal-dialog");
    if(modalWidth)
    {
        $("#afModal").find(".modal-dialog").removeClass('modal-lg');
        $("#afModal").find(".modal-dialog").addClass(modalWidth);
    }
    var token  = $('#site_csrf_token').val();
    var formData = { _token : token};
    if(frmData)
    {
        formData = $("#"+frmData).serialize();
    }
    $.ajax({
        method: frmData ? 'post' :'get',
        url: popupUrl,
        data: formData,
        success: function(data){
            $("#afModal").find(".modal-loader").hide();
            $("#afModal").modal('show').find(".modal-content").html(data);
        },
    });
}

function showLogin(){
    $("#modal .close").click();
    $('#homeLogin').click();

}

function checkoffer(url)
{
    $("#afModal").find(".modal-loader").show();
    $("#afModal").find(".modal-error").html("");
    var paid_amount = $("#paid_amount").val();
    var coupon_code = $("#coupon_code").val();
    var token  = $('#site_csrf_token').val();
    $.ajax({
        method: 'post',
        url: url,
        data:  { _token : token, paid_amount : paid_amount, coupon_code : coupon_code},
        success: function(data){

            var json_array = JSON.parse( data );
            if(json_array.status == "success")
            {
                html = '<div class="alert alert-success">'+ json_array.message +'</div>';
                $("#afModal").find(".modal-error").html(html);
                paid_amount = $("#paid_amount").val(json_array.vals.paid_amount);
                $("#total_price_span").html(json_array.vals.paid_amount+"$");
                $("#offer_span").html("-"+json_array.vals.offer+"$");
            }
            else
            {
                html = '<div class="alert alert-danger">'+ json_array.message +'</div>';
                $("#afModal").find(".modal-error").html(html);
            }
            $("#afModal").find(".modal-loader").hide();

        }

    });
    return false;
}

function submitFrm(frmObj,redirectUrl = "")
{
	$("#afModal").find(".modal-loader").show();
    $("#afModal").find(".modal-error").html("");
    frmUrl = $(frmObj).attr('action');
	var frmData = $(frmObj).serialize();
    var frmId = $(frmObj).attr('id');
	$.ajax({
        method: 'post',
        url: frmUrl,
        data: frmData,
        success: function(data){
            if(frmId == "frmRegister")
            {
                html = '<div class="alert alert-success">Thank you for registration Check your Mail</div>';
                $("#afModal").find(".modal-error").html(html);
                $("#afModal").find(".modal-loader").hide();
            }
            else
            {
                if(redirectUrl)
                {
                   window.location = redirectUrl;
                }
                else
                {
                    var json_array = JSON.parse( data );
                    if(json_array.status == "success")
                    {
                        if(json_array.action == "redirect")
                        {
                            window.location == json_array.url;
                        }
                        if(json_array.action == "popup")
                        {
                            openPopup(json_array.url);
                        }
                        if(json_array.action == "showpopup")
                        {
                            $("#afModal").find(".modal-loader").show();
                            $("#afModal").find(".modal-loader").hide();
                            $("#afModal").modal('show').find(".modal-content").html(json_array.message);
                            setTimeout(function() {
                                location.reload();
                            }, 5000);
                        }
                        if(json_array.action == "showError")
                        {
                            $("#afModal").find(".modal-loader").hide();
                            var json_array = JSON.parse(data);
                            var errors = json_array['errors'];
                            var html = "";
                            if(errors)
                            {
                                $.each( errors, function( key, value ) {
                                    if(value)
                                    {
                                        html += '<div class="alert alert-danger">'+value+'</div>';
                                    }
                                });
                                $("#afModal").find(".modal-error").html(html);
                
                            }
                
                        }
                        if(json_array.action == "reload")
                        {
                            window.reload();
                        }
                    }
                    else
                    {
                        window.reload();
                    }
                }

            }

        },
        error: function (data) {
            $("#afModal").find(".modal-loader").hide();
        	var json_array = JSON.parse( data.responseText );
        	var errors = json_array['errors'];
        	var html = "";
        	if(errors)
        	{
        		$.each( errors, function( key, value ) {
        			if(value)
        			{
        				html += '<div class="alert alert-danger">'+value+'</div>';
        			}
				});
				$("#afModal").find(".modal-error").html(html);

        	}
        }
    });
    return false;
}

function bookingssummary(obj,url)
{
    if($(obj).hasClass('btn-afland-disable'))
    {
        alert('Please select booking dates first')
    }
    else
    {
        openPopup(url,'frmViewPorperty','modal-lg');
    }

}

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

function show_service_other(obj)
{
    if($(obj).prop("checked") == true){
        $("#service_other").removeClass("d-none");
    }
    else{
        $("#service_other").addClass("d-none");
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


function getcity(obj)
{
	var token  = $('#site_csrf_token').val();
    var country = $(obj).val();
	$.ajax({
        method: 'post',
        url: getcityurl,
        data: { _token : token, country : country },
        success: function(data){
             $(".citywrap").html(data);
        },
    })
    return false;
}

function getcityForHost(obj)
{
    var html = '';
	var token  = $('#site_csrf_token').val();
    var country = $(obj).val();
	$.ajax({
        method: 'post',
        url: getcityurl,
        data: { _token : token, country : country },
        success: function(data){
            for (var key in data) {
                var id = data[key].id;
                var name = data[key].name;
                html += '<option value=' + id + '>' + name + '</option>'
            }
             $(".cityList").html(html);
        },
    })
    return false;
}




function getprotype(obj)
{
    $(".radio-control").removeClass("radio-control-active");
    $(obj).parents(".radio-control").addClass("radio-control-active");
    var token  = $('#site_csrf_token').val();
    var host = $(obj).val();
    $.ajax({
        method: 'post',
        url: getpropertytypeurl,
        data: { _token : token, host : host },
        success: function(data){
             $(".protypewrap").html(data);
        },
    })
    return false;
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

