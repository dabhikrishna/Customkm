jQuery(document).ready(function ($) {
    $('#store-name-form').submit(function (e) {
        e.preventDefault();
        var storeName = $('#store-name').val();
        $.ajax({
            type: 'POST',
            url: custom_ajax_plugin_ajax_object.ajax_url,
            data: {
                action: 'custom_ajax_plugin_update_store_name',
                store_name: storeName
            },
            success: function (response) {
                $('#store-name-result').html(response);
            }
        });
    });
});

$(document).on("click", ".delete-portfolio-post", function() {
    var postId = $(this).data("post-id");
    if ("Are you sure you want to delete this portfolio post?" == confirm("Are you sure you want to delete this portfolio post?")) {
        $.ajax({
            url: ajaxurl,
            method: "POST",
            data: {
                action: "delete_portfolio_post",
                post_id: postId,
                nonce: submenu_ajax_object.nonce, // Pass nonce here
            },
            success: function(response) {
                if ("success" === response) {
                    $("#portfolio-posts-message")
                        .text("Portfolio post deleted successfully.")
                        .show();
                    getPortfolioPosts(); // Refresh the list of portfolio posts after deletion
                } else {
                    alert("Error deleting portfolio post.");
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert("Error deleting portfolio post.");
            },
        });
    }
});


