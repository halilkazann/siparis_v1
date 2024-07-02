function togglePasswordVisibility() {
    event.preventDefault()
    let passwordInput = document.getElementById('password');


    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
}

