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
                <div class="card-header text-center bg-white py-3 fs-4 fw-bold">Register</div>
                <div class="card-body p-4">
                    <div id="message"></div>
                    <form id="register-form" method="POST" action="{{ route('api.register') }}">

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Password Confirmation</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>

                        <div class="mb-3 d-flex justify-content-center">
                            <button type="button" id="register-button" class="btn btn-primary mt-3">Register</button>
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
        $('#register-button').click(function(e) {
            e.preventDefault();

            let name = $('#name').val();
            let email = $('#email').val();
            let password = $('#password').val();
            let password_confirmation = $('#password_confirmation').val();

            if(!name || !email || !password || !password_confirmation){
                return;
            }

            let formData = {
                name: name,
                email: email,
                password: password,
                password_confirmation: password_confirmation,
            };

            $.ajax({
                type: 'POST',
                url: $('#register-form').attr('action'),
                data: formData,
                success: function(response) {
                    window.location.href = "/login";
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
