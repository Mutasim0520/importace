$(document).ready(function () {
    $.validator.setDefaults({
        errorClass: 'help-block',
        highlight:function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight:function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        }
    });
    $("#register-form").validate({
        rules: {
            password:{
                minlength:6,
            },
            password_confirmation:{
                    equalTo: "#password"
            },
            mobile:{
                number:true,
            }
        },
        messages:{
            password_confirmation:{
                equalTo:"Password did not match."
            }
        }
    });

});