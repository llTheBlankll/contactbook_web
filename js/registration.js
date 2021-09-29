
function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validateInputs() {
    usernameinput = document.getElementById("js_username");
    emailinput = document.getElementById("js_email");
    passwordinput = document.getElementById("js_password");
    reenterpasswordinput = document.getElementById("js_reenterpassword");
    errors = document.getElementById("errors")

    // Alert Danger!
    alert_danger_start = "<div class='alert alert-danger'>"
    alert_danger_end = "</div>"

    // Alert Success!
    alert_success_start = "<div class='alert alert-success'>"
    alert_success_end = "</div>"

    isEmailGood = false;

    if (usernameinput.value != "") {
        if (passwordinput.value != "") {
            if (reenterpasswordinput.value == passwordinput.value) {
                if (emailinput.value != "") {
                    if (validateEmail(emailinput.value)) {
                        document.getElementById("js_signup").disabled = false;
                        errors.innerHTML = alert_success_start + "All Good!" + alert_success_end;
                    } else {
                        document.getElementById("js_signup").disabled = false;
                        errors.innerHTML = alert_danger_start + "Email is invalid." + alert_danger_end;
                    }
                } else {
                    errors.innerHTML = alert_danger_start + "Email cannot be blank." + alert_danger_end;
                }
            } else {
                errors.innerHTML = alert_danger_start + "Password is not the same." + alert_danger_end;
            }
        } else {
            errors.innerHTML = alert_danger_start + "Password cannot be blank." + alert_danger_end;
        }
    } else {
        errors.innerHTML = alert_danger_start + "Username cannot be blank." + alert_danger_end;
    }
}