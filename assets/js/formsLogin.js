$(".btn-login").click(function() {

    $(".card-body").find(".alert-danger").remove();

    $(".register-form").hide();
    $(".register-form input").val("");

    $(".login-form").show();
})

$(".btn-register").click(function() {

    $(".card-body").find(".alert-danger").remove();

    $(".login-form").hide();
    $(".login-form input").val("");

    $(".register-form").show();
})

$("#show-password-btn-login").hover(function() {

    let passwordField = document.getElementById("password-login");
    if (passwordField.type === "password") {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
});

$("#show-password-btn-register").hover(function() {

    let passwordField = document.getElementById("password-register");
    if (passwordField.type === "password") {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
});