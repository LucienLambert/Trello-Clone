/*$.validator.addMethod("regex", function(value, element, pattern) {
        if (pattern == null) {
            return null;
        }
        if (pattern instanceof Array) {
            for (p of pattern) {
                if (!p.test(value))
                    return false;
            }
            return true;
        } else {
            return pattern.test(value);
        }
    },
    "Please enter a valid input."
);
*/
$(function() {
    $("input:first").focus();
    validateSignup();
});

function validateSignup() {
    $('#formSignUp').validate({
        rules: {
            mail: {
                remote: {
                    url: 'user/mail_available_service',
                    type: 'post',
                    data: {
                        mail: function() {
                            return $("#mail").val();
                        }
                    }

                },
                required: true,
            },
            fullName: {
                required: true,
                minlength: 3,
                maxlength: 16,
                regex: /^[a-zA-Z]*$/,
            },
            password: {
                required: true,
                minlength: 8,
                maxlength: 16,
                regex: [/[A-Z]/, /\d/, /['";:,.\/?\\-]/],
            },
            conf_password: {
                required: true,
                minlength: 8,
                maxlength: 16,
                equalTo: "#password",
                regex: [/[A-Z]/, /\d/, /['";:,.\/?\\-]/],
            }
        },
        messages: {
            mail: {
                remote: 'this Email already exist',
                required: 'required',
            },
            fullName: {
                required: 'required',
                minlength: 'minimum 3 characters',
                maxlength: 'maximum 16 characters',
                regex: 'bad format for pseudo',
            },
            password: {
                required: 'required',
                minlength: 'minimum 8 characters',
                maxlength: 'maximum 16 characters',
                regex: 'bad password format',
            },
            conf_password: {
                required: 'required',
                minlength: 'minimum 8 characters',
                maxlength: 'maximum 16 characters',
                equalTo: 'must be identical to password above',
                regex: 'bad password format',
            }
        }
    });
}