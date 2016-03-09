function validateUsername(field)
{
    if (field == "")
        return "No Username was entered<br>"
    else if (field.length < 5)
        return "Username must be at least 5 characters<br>"
    else if (field.length > 30)
        return "Username must to be no more than 30 characters<br>"
    else if (/[^a-zA-Z0-9_-]/.test(field))
        return "Only a-z, A-Z, 0-9, - and _ allowed in Usernames<br>"
    return ""
}

function validatePassword(field)
{
    if (field == "")
        return "No Password was entered<br>"
    else if (field.length < 6)
        return "Passwords must be at least 6 characters<br>"
    else if (field.length > 20)
        return "Passwords must be no more than 20 characters<br>"
    else if (!/[a-z]/.test(field) || !/[A-Z]/.test(field) ||
            !/[0-9]/.test(field))
        return "Passwords require one each of a-z, A-Z and 0-9<br>"
    return ""
}

function validatePasswordRepeat(password, passwordRepeat)
{
    if (password != passwordRepeat)
        return "Entered passwords don't match<br>"
    return ""
}

function validateEmail(field)
{
    if (field == "")
        return "No Email was entered<br>"
    else if (!((field.indexOf(".") > 0) &&
            (field.indexOf("@") > 0)) ||
            /[^a-zA-Z0-9.@_-]/.test(field))
        return "The Email address is invalid<br>"
    return ""
}

function validateRegistration(form)
{
    error = ""; 
    error += validateUsername(form.form_username.value);
    error += validatePassword(form.form_password.value);
    error += validatePasswordRepeat(form.form_password.value, form.form_password_repeat.value);
    error += validateEmail(form.form_email.value);
    
    errorBox = document.getElementById('registration_error_box');
    
    if (error == "")
        return true
    else
    {
        errorBox.innerHTML = error;
        return false;
    }
}

function validateLogin(form)
{
    error = ""; 
    error += validateUsername(form.form_username.value);
    error += validatePassword(form.form_password.value);
    
    errorBox = document.getElementById('login_error_box');
    
    if (error == "")
        return true
    else
    {
        errorBox.innerHTML = error;
        return false;
    }
}

