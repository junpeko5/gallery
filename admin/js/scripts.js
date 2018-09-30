$(function() {

    $(".modal_thumbnails").on('click', function() {
        $("#set_user_image").prop('disabled', false);
    });

    tinymce.init({ selector:'textarea' });
});
