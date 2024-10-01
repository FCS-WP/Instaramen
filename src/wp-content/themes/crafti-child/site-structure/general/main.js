//function check strong password register form
var passwordInput = document.querySelector('.trx_addons_popup_form_register .sc_form_field_password .sc_form_field_wrap input');

if (passwordInput) {
    passwordInput.addEventListener('input', event => {
    const password = document.querySelector('.trx_addons_popup_form_register .sc_form_field_password .sc_form_field_wrap input').value;
    const strengthIndicator = document.getElementById("status-password");


    const minLength = 8;
    const hasUpperCase = /[A-Z]/.test(password);
    const hasLowerCase = /[a-z]/.test(password);
    const hasDigit = /[0-9]/.test(password);
    const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);


    let strength = 0;
    if (password.length >= minLength) strength++;
    if (hasUpperCase) strength++;
    if (hasLowerCase) strength++;
    if (hasDigit) strength++;
    if (hasSpecialChar) strength++;


    switch (strength) {
        case 0:
        case 1:
            strengthIndicator.textContent = "Password Very Weak";
            strengthIndicator.style.color = "red";
            break;
        case 2:
            strengthIndicator.textContent = "Password Weak";
            strengthIndicator.style.color = "orange";
            break;
        case 3:
            strengthIndicator.textContent = "Password Normal";
            strengthIndicator.style.color = "yellow";
            break;
        case 4:
            strengthIndicator.textContent = "Password Strong";
            strengthIndicator.style.color = "blue";
            break;
        case 5:
            strengthIndicator.textContent = "Password Supper Strong";
            strengthIndicator.style.color = "green";
            break;
        default:
            strengthIndicator.textContent = "";
    }
})
} else {
    return;
}
