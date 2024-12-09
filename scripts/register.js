const validateRegistrationForm = () => {
    let isFormValid = true;

    const username = document.getElementById("username").value.trim().replaceAll(" ", "");
    const email = document.getElementById("email").value.trim().replaceAll(" ", "");
    const password = document.getElementById("password").value.trim().replaceAll(" ", "");

    const emailPattern = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;

    displayFieldError('username', '');
    displayFieldError('email', '');
    displayFieldError('password', '');

    if(username.length <= 0){
        displayFieldError('username', 'Username field is required.');
        isFormValid = false;
    }
    if(!emailPattern.test(email)){
        displayFieldError('email', 'Email field dont be looking like an email dawg.');
        isFormValid = false;
    }
    if(email.length <= 0){
        displayFieldError('email', 'Email field is required.');
        isFormValid = false;
    }
    if(password.length < 6){
        displayFieldError('password', 'Password must be at least 6 characters long.');
        isFormValid = false;
    }
    return isFormValid
}

const displayFieldError = (inputFieldID, errorMessage) =>{
    const errorSpan = document.getElementById(inputFieldID + "Error");
    errorSpan.textContent = errorMessage;
}