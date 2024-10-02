const $passwordInput = $(
  ".trx_addons_popup_form_register .sc_form_field_password .sc_form_field_wrap input"
);

if ($passwordInput.length) {
  $passwordInput.on("input", (event) => {
    const password = $(event.target).val();
    const $strengthIndicator = $("#status-password");

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
        $strengthIndicator.text("Password Very Weak").css("color", "red");
        break;
      case 2:
        $strengthIndicator.text("Password Weak").css("color", "orange");
        break;
      case 3:
        $strengthIndicator.text("Password Normal").css("color", "yellow");
        break;
      case 4:
        $strengthIndicator.text("Password Strong").css("color", "blue");
        break;
      case 5:
        $strengthIndicator.text("Password Super Strong").css("color", "green");
        break;
      default:
        $strengthIndicator.text("");
    }
  });
}