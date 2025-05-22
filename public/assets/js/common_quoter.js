var baseURL = window.origin + "/";


/*====================Company Info==========================*/

$(document).ready(function () {


//request demo

    $("#RequestDemoForm").submit(function (e) {

        e.preventDefault();

    }).validate({

        rules: {

            name: {

                required: true

            },

            organization: {

                required: true

            },

            email: {

                required: true,

                email: true

            },

            phone: {

                required: true

            },

        },

        messages: {

            name: "Enter Full Name",

            organization: "Enter Organization Name",

            email: {

                required: "Enter A Valid Email Address"

            },

            phone: "Enter A Valid Phone Number"

        },

        submitHandler: function (form) {

            var RequestDemoForm = new FormData($('#RequestDemoForm')[0])

            $.ajax({

                type: "POST",
                url: baseURL + "request-demo",
                data: RequestDemoForm,
                processData: false,
                contentType: false,

                beforeSend: function () {
                },

                success: function (result) {

                    //console.log(result);

                    window.Popup.fire({
                            title: "Success!",
                            text: "Request send successfully, will contact you soon...",
                            icon: "success"
                        },

                        function () {

                            window.location.reload();

                        });

                }

            });

            return false;

        }

    });


    //drop us a message

    // $(document).ready(function () {
    //     $("#DropMsgForm").submit(function (e) {
    //         e.preventDefault(); // Prevent default form submission
    //     }).validate({
    //         rules: {
    //             name: {
    //                 required: true
    //             },
    //             email: {
    //                 required: true,
    //                 email: true
    //             },
    //             phone: {
    //                 required: true
    //             },
    //             subject: {
    //                 required: true
    //             },
    //             msg: {
    //                 required: true
    //             }
    //         },
    //         messages: {
    //             name: "Enter Full Name",
    //             email: {
    //                 required: "Enter a valid email address"
    //             },
    //             phone: "Enter a valid phone number",
    //             subject: "Enter subject",
    //             msg: "Enter message"
    //         },
    //         submitHandler: function (form) {
    //             const DropMsgForm = new FormData($('#DropMsgForm')[0]);
    
    //             // Get the reCAPTCHA response
    //             const recaptchaResponse = grecaptcha.getResponse();
    
    //             if (!recaptchaResponse) {
    //                 // If reCAPTCHA is not verified
    //                 window.Popup.fire({
    //                     title: 'Error',
    //                     text: 'Please verify that you are not a robot!',
    //                     icon: 'error',
    //                     confirmButtonText: 'OK'
    //                 });
    //                 return false; // Stop submission
    //             }
    
    //             // Append reCAPTCHA response to form data
    //             DropMsgForm.append('g-recaptcha-response', recaptchaResponse);
    
    //             $.ajax({
    //                 type: "POST",
    //                 url: baseURL + "drop-msg",
    //                 data: DropMsgForm,
    //                 processData: false,
    //                 contentType: false,
    //                 beforeSend: function () {
    //                     // Show loading spinner
    //                     $("#pageloader").fadeIn();
    //                 },
    //                 success: function (result) {
    //                     // Hide loader and reset reCAPTCHA
    //                     $("#pageloader").fadeOut();
    //                     grecaptcha.reset();
    
    //                     window.Popup.fire({
    //                         title: "Success!",
    //                         text: "Thanks for your inquiry. We will be in touch shortly.",
    //                         icon: "success"
    //                     }).then(function () {
    //                         // Reset the form after success
    //                         form.reset();
    //                     });
    //                 },
    //                 error: function () {
    //                     // Hide loader and reset reCAPTCHA
    //                     $("#pageloader").fadeOut();
    //                     grecaptcha.reset();
    
    //                     window.Popup.fire({
    //                         title: "Error",
    //                         text: "Something went wrong. Please try again later.",
    //                         icon: "error"
    //                     });
    //                 }
    //             });
    
    //             return false; // Prevent further form submission
    //         }
    //     });
    // });
    
    /***********************/

});
