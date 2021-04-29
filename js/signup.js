$().ready(function() {
    $("#formSignUp").validate({
        rules: {
            mail: {
                required: true,
            },
            fullName: {
                required: true,
                minlength: 3,
                maxlength: 16,
            },
            password: {
                required: true,
                minlength: 8,
                maxlength: 16,
            },
            conf_password: {
                required: true,
                minlength: 8,
                maxlength: 16,
                equalTo: "#password",
            }
        },
        messages: {
            mail: {
                required: 'required',
            },
            fullName: {
                required: 'required',
                minlength: 'minimum 3 characters',
                maxlength: 'maximum 16 characters',
            },
            password: {
                required: 'required',
                minlength: 'minimum 8 characters',
                maxlength: 'maximum 16 characters',
            },
            conf_password: {
                required: 'required',
                minlength: 'minimum 8 characters',
                maxlength: 'maximum 16 characters',
                equalTo: 'must be identical to password above',
            }
        }

    });
    $("input:first").focus();
});