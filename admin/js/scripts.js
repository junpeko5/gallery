$(document).ready(function() {

    var user_href;
    var user_href_split;
    var user_id;

    $(".modal_thumbnails").on('click', function() {
        $("#set_user_image").prop('disabled', false);
    });

    user_href = $("#user-id").prop('href');
    user_href_split = user_href.split("=");
    user_id = user_href_split[user_href_split.length - 1];


    tinymce.init({ selector:'textarea' });
});