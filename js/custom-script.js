jQuery(document).ready(function ($) {
    $('#submit_btn').on('click', function () {
           // Get form data
           var name = $('#name').val().trim();
           var company = $('#company_name').val().trim();
           var email = $('#email').val().trim();
           var phone = $('#phone').val().trim();
           var address = $('#address').val().trim();
   
           // Regular expressions for validation
           var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
           var phoneRegex = /^[0-9()-\s]+$/;
   
           // Validate fields
           if (name === '' || company === '' || email === '' || phone === '' || address === '') {
               $('#response_msg').html('<span style="color: red;">Please fill out all required fields.</span>');
               return;
           }
           if (!emailRegex.test(email)) {
               $('#response_msg').html('<span style="color: red;">Please enter a valid email address.</span>');
               return;
           }
           if (!phoneRegex.test(phone)) {
               $('#response_msg').html('<span style="color: red;">Please enter a valid phone number.</span>');
               return;
           }
   
        // Validate form fields
        var formData = $('#portfolio_submission_form').serialize();
        $.ajax({
            type: 'POST',
            url: my_custom_script_object.ajax_url, // Note: No quotes around ajaxurl
            data: formData,
            success: function (response) {
                $('#response_msg').html(response);
                $('#portfolio_submission_form')[0].reset(); // Reset the form
            }
        });
    });
});
