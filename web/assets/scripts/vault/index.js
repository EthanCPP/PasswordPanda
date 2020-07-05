$(document).ready(function() {
    $('.password-toggle').on('click', function() {
        const targetId = $(this).data('show-id');
        $(`[data-id="${targetId}"]`).toggleClass('show');
    });

    new ClipboardJS('.password-copy');

    $('.password-copy').on('click', function() {
        const $this = $(this);
        $(this).html('Copied!');

        setTimeout(function() {
            $this.html('[Copy]');
        }, 1000);
    });

    $('.password-delete').on('click', function() {
        const targetId = $(this).data('delete-id');

        if (confirm("Are you sure? This password will be lost FOREVER")) {
            const root = $('[name="i_root"]').val();
            
            $.ajax({
                method: "POST",
                url: root + "/api/delete-password.php",
                data: { 'ID': targetId }
            }).done(function(response) {
                console.log(response);
                const result = JSON.parse(response);

                if (result.Result == 'Success') {
                    window.location = root + "/vault";
                }
            })
        }
    });

    // Search
    var siteCards = [];

    $('.passwords-list .card').each(function() {
        var siteCard = [
            $(this).data('site-name'),
            $(this)
        ];

        siteCards.push(siteCard);
    });


    $('#search-q').on('input', function() {
        const searchVal = $(this).val();

        siteCards.forEach(function(item) {
            if (searchVal == '') {
                item[1].parent().removeClass('d-none');
            } else {
                if (!item[0].toUpperCase().includes(searchVal.toUpperCase())) {
                    item[1].parent().addClass('d-none');
                } else {
                    item[1].parent().removeClass('d-none');
                }
            }
        });
    });
});