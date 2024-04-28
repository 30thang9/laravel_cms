<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" />
</head>
<body>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center bg-white py-3 fs-4 fw-bold">Login</div>
                <div class="card-body p-4">
                    <div id="message"></div>
                    <form id="login-form" method="POST" action="{{ route('api.login') }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="mb-3 d-flex justify-content-center">
                            <button type="button" id="login-button" class="btn btn-primary mt-3">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#login-button').click(function(e) {
            e.preventDefault();

            let email = $('#email').val();
            let password = $('#password').val();

            if(!email || !password){
                return;
            }

            let formData = {
                email: email,
                password: password,
            };

            $.ajax({
                type: 'POST',
                url: $('#login-form').attr('action'),
                data: formData,
                success: function(response) {
                    localStorage.setItem('token', response.token);
                    localStorage.setItem('user', JSON.stringify(response.data));
                    window.location.href = "/users/" + response.data.id + "/posts";
                },
                error: function(xhr, status, error) {
                    res = JSON.parse(xhr.responseText);
                    var $message = `<div class="text-danger py-1 mb-3"><span>${res.message}</span></div>`
                    $('#message').empty().append($message);
                }
            });
        });
    });
</script>

</body>
</html>
