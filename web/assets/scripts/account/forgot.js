$(document).ready(function() {
    $('#forgot-form').on('submit', function(e) {
        e.preventDefault();

        const $form = $(this);
        const root = $form.find('[name="i_root"]').val();
        
        $.ajax({
            method: "POST",
            url: root + "/api/forgot-password.php",
            data: $form.serialize()
        }).done(function(response) {
            console.log(response);
            const result = JSON.parse(response);

            if (result.Result == 'Success') {
                window.location = root + "/account/forgot.php?sent=true";
            } else if (result.Result == 'Error') {
                $('.panda-error-holder').empty();
                $('.panda-error-holder').append(`<div class="alert alert-danger">${result.Message}</div>`);
            }
        })
    });
});