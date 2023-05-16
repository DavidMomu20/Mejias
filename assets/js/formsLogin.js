$(".btn-login").click(function() {

    $(".login-form").show();
    $(".register-form").hide();
})

$(".btn-register").click(function() {

    $(".login-form").hide();
    $(".register-form").show();
})

$("#show-password-btn-login").click(function() {

    let passwordField = document.getElementById("password-login");
    if (passwordField.type === "password") {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
});

$("#show-password-btn-register").click(function() {

    let passwordField = document.getElementById("password-register");
    if (passwordField.type === "password") {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
});