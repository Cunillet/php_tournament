<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12 justify-content-center">
                <!-- Your content here -->
                <h1>Register</h1>
                <form action="api/register" id="register_form" method="POST" class="d-flex flex-column">
                    <span class="">
                        <input type="text" name="user_name" id="user_name" placeholder="user display name"/>
                    </span>
                    <span class="">
                        <input type="email" name="user_email" id="user_email" placeholder="email"/>
                    </span>
                    <span class="">
                        <input type="password" name="user_password" id="user_password" placeholder="password"/>
                    </span>
                    <input type="submit" id="register_submit" value="Submit"/>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>