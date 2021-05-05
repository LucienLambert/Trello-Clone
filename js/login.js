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
    $("input:first").focus();
});