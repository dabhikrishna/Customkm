
jQuery(document).ready(function ($) {
    $('#submit_btn').on('click', function () {
        // Validate form fields
        var name = $('#name').val();
        var company = $('#company_name').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var address = $('#address').val();

        // Email validation regex
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        // Phone validation regex (accepts digits, spaces, dashes, parentheses)
        var phoneRegex = /^[0-9()-\s]+$/;

        // Check email format
        if (!emailRegex.test(email)) {
            $('#response_msg').html('<span style="color: red;">Please enter a valid email address.</span>');
            return;
        }
        // Check phone format
        if (!phoneRegex.test(phone)) {
            $('#response_msg').html('<span style="color: red;">Please enter a valid phone number.</span>');
            return;
        }
        // Check if any required field is empty
        if (name.trim() === '' || email.trim() === '' || company.trim() === '' || phone.trim() === '' || address.trim() === '') {
            $('#response_msg').html('<span style="color: red;">Please fill out all required fields.</span>');
            return;
        }
        

   
    });
});
