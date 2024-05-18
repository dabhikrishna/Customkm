// delete-post.js

jQuery(document).ready(function($) {
    $('.delete-post-button').on('click', function() {
        console.log('Delete button clicked');
        var postId = $(this).data('post-id');
        var deleteButton = $(this); // Store a reference to the clicked button

        var confirmation = confirm('Are you sure you want to delete this post?');

        if (confirmation) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'delete_post_action',
                    post_id: postId,
                },
                success: function(response) {
                    // If the deletion was successful, remove the row from the table
                    if (response === 'success') {
                        deleteButton.closest('tr').remove();
                    } else {
                        alert('An error occurred while deleting the post.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('An error occurred while deleting the post.');
                }
            });
        }

        return false;
    });
});


  