$(function() {
    $("input:first").focus();
    validateSignIn();
});

function validateSignIn() {
    $(function() {
        $('#formLogin').validate({
            rules: {
                mail: "required",
                password: "required"
            },
            messages: {
                mail: {
                    required: 'required',
                },
                password: {
                    required: 'required',
                },
            }
        });
    });
}