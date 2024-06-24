jQuery(document).ready(function ($) {
    $.ajax({
        url: rest_object.rest_url + 'custom/v1/portfolio',
        success: (response) => {
            const templ = wp.template('portfolio');
            $('#page-content').html(templ(response.data))
            console.log($('#page-content'));
        }
    })

    $(document).on('click', '.delete-post', function () {
        console.log( 'click' );
        const $button = $(this);
        var postId = $button.attr("data-post-id");
        jQuery.ajax({
            url: rest_object.rest_url + 'custom/v1/delete-post/' + postId,
            method: 'GET',
            success: function (response) {
                console.log("Post deleted successfully.");
                $button.closest('tr').remove();
            },
            error: function (xhr, status, error) {
                console.error("Error deleting post:", error);
            }
        });
    })

});
