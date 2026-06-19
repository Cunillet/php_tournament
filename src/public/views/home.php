<div class="row">
    <div class="col-12 justify-content-center d-flex flex-column">
        <!-- Your content here -->
        <h1 class="mt-5">Centered Content</h1>
        <div id="message"></div>
        <?php if ($_SESSION['logged_in']) { ?>
            <p class="row">User logged in: <?php echo $_SESSION['logged_in'] ? $_SESSION['user_name'] : 'Session corrupted, please logout and login again' ?></p>
            <form action="api/logout" method="POST" id="logoutForm" class="row">
                <input type="submit" class="btn btn-danger" value="Logout"/>
            </p>
        <?php } else { ?>
            <p class="row">
                Welcome to Public Tournament WebApp!<br/>
                wish you enjoy your stay and kill lots of space marines!</br>
                Please Login/Register in order to proceed:
            </p>
            <div class="row">
                <a href="/register" class="btn btn-success col m-3">Register</a>
                <a href="/login" class="btn btn-primary col m-3">Login</a>
            </div>
            <?php } ?>
    </div>
</div>
<script src="../../js/profile/logout.js"></script>