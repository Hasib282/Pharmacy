$('#loginForm').submit(function(e) {
    e.preventDefault();

    const formData = {
        email: $('input[name="email"]').val(),
        password: $('input[name="password"]').val(),
    };

    $.ajax({
        url: '/api/login',
        type: 'POST',
        data: formData,
        success: function(response) {
            console.log('Login Successful', response);
            // Save the token for future API requests
            localStorage.setItem('token', response.token);
            window.location.href = '/dashboard';
        },
        error: function(error) {
            console.log('Login Failed', error);
        }
    });
});