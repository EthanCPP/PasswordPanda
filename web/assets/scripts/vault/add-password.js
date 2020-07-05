function randomPassword(length) {
    var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
    var pass = "";
    for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    return pass;
}

$(document).ready(function() {
    $('#add-password-form').on('submit', function(e) {
        e.preventDefault();

        const $form = $(this);
        const root = $form.find('[name="i_root"]').val();
        
        $.ajax({
            method: "POST",
            url: root + "/api/add-password.php",
            data: $form.serialize()
        }).done(function(response) {
            const result = JSON.parse(response);

            if (result.Result == 'Success') {
                window.location = root + "/vault";
            } else if (result.Result == 'Error') {
                $('.panda-error-holder').empty();
                $('.panda-error-holder').append(`<div class="alert alert-danger">${result.Message}</div>`);
            }
        })
    });

    $('.generate-password').on('click', function(e) {
        e.preventDefault();

        const password = randomPassword(Math.floor(Math.random() * (18 - 10 + 1)) + 10);

        $('[name="i_password"]').val(password);

        navigator.clipboard.writeText(password);

        $(this).html('[ Copied! ]');
        const $this = $(this);

        setTimeout(function() {
            $this.html('[ Generate Random ]');
        }, 1000);
    });
});