jQuery(document).ready(function ($) {

    // For creating new accounts
    $("#signup-form").submit(function (e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: my_ajax_object.ajax_url,
            data: formData + "&action=custom_user_registration", // Data send
            success: function (response) {
                if (response.success) {
                    console.log(response.data.redirect_url);
                    $("#signup-error").css("color", "green").html("Sign-up successful! Redirecting...");
                    setTimeout(() => {
                        // formData.reset();
                        window.location.href = response.data.redirect_url;
                    }, 2000);
                } else {
                    $("#signup-error").html(response.data);
                }
            },
        });
    });




    // For forgetting password
    $("#forgot-form").submit(function (e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: my_ajax_object.ajax_url,
            data: formData + "&action=custom_forgot_password",
            success: function (response) {
                if (response.success) {
                    $("#forgot-error").css("color", "green").html("Password reset link sent! Check your email.");
                } else {
                    $("#forgot-error").html(response.data);
                }
            },
        });
    });

});