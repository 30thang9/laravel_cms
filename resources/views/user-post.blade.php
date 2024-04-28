<!-- resources/views/user_posts.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Posts</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>User Posts</h1>
    <div class="row" id="postList"></div> <!-- Đây là nơi để hiển thị dữ liệu posts -->
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $.ajaxSetup({
        beforeSend: function(xhr) {
            var token = localStorage.getItem('token');
            if (token) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            }
        }
    });

    $(document).ready(function() {
        var userId = "{{ $userId }}";

        $.ajax({
            url: '/api/users/' + userId + '/posts',
            type: 'GET',
            success: function(response) {
                console.log(response);
                var posts = response.data;
                var postListHtml = '';
                $.each(posts, function(index, post) {
                    postListHtml += '<div class="col-md-4">';
                    postListHtml += '<div class="card mb-4">';
                    postListHtml += '<div class="card-body">';
                    postListHtml += '<h5 class="card-title">' + post.title + '</h5>';
                    postListHtml += '<p class="card-text">' + post.description + '</p>';
                    postListHtml += '</div>';
                    postListHtml += '</div>';
                    postListHtml += '</div>';
                });
                $('#postList').html(postListHtml);
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Error: ' + error);
            }
        });
    });
</script>
</body>
</html>
