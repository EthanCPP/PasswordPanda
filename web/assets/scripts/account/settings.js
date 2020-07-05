$(document).ready(function() {
    $('#settings-basics-form').on('submit', function(e) {
        e.preventDefault();

        const $form = $(this);
        const root = $form.find('[name="i_root"]').val();
        
        $.ajax({
            method: "POST",
            url: root + "/api/account-settings-basics.php",
            data: $form.serialize()
        }).done(function(response) {
            const result = JSON.parse(response);

            if (result.Result == 'Success') {
                window.location = root + "/account/settings.php?basics-success=1";
            } else if (result.Result == 'Error') {
                $('.panda-error-holder-basics').empty();
                $('.panda-error-holder-basics').append(`<div class="alert alert-danger">${result.Message}</div>`);
            }
        })
    });
    
    $('#settings-password-form').on('submit', function(e) {
        e.preventDefault();

        const $form = $(this);
        const root = $form.find('[name="i_root"]').val();
        
        $.ajax({
            method: "POST",
            url: root + "/api/account-settings-password.php",
            data: $form.serialize()
        }).done(function(response) {
            const result = JSON.parse(response);

            if (result.Result == 'Success') {
                window.location = root + "/account/settings.php?password-success=1";
            } else if (result.Result == 'Error') {
                $('.panda-error-holder-password').empty();
                $('.panda-error-holder-password').append(`<div class="alert alert-danger">${result.Message}</div>`);
            }
        })
    });
    
    $('#settings-delete-form').on('submit', function(e) {
        e.preventDefault();

        if (confirm('Are you sure you wish to delete your account? Everything will be lost FOREVER')) {

            const $form = $(this);
            const root = $form.find('[name="i_root"]').val();
            
            $.ajax({
                method: "POST",
                url: root + "/api/account-settings-delete.php",
                data: $form.serialize()
            }).done(function(response) {
                const result = JSON.parse(response);

                if (result.Result == 'Success') {
                    window.location = root + "/account/register.php";
                }
            });

        }
    });
});