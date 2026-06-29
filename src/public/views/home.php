<main class="container my-5">
    <section class="text-center py-5">
        <h1 class="display-4 fw-bold mb-3">
            DD Tournaments
        </h1>
        <p class="lead mb-4">
            Welcome to Public Tournament WebApp!<br/>
            wish you enjoy your stay and kill lots of space marines!</br>
        <?php if ($_SESSION['logged_in']) { ?>
        </p>
        <p class="lead mb-4">
            User logged in: <?php echo $_SESSION['logged_in'] ? $_SESSION['user_name'] : 'Session corrupted, please logout and login again' ?>
        </p>
        <div class="row">
            <a href="/tournaments" class="btn btn-primary col m-3">Tournaments Dashboard</a>
            <a href="/tournaments/create" class="btn btn-success col m-3">Create Tournament</a>
        </div>
        <?php if ($_SESSION['user_role'] === 'admin') { ?>
        <div class="row">
            <a href="/gameTypes" class="btn btn-primary col m-3">Game Types Dashboard</a>
            <a href="/gameTypes/create" class="btn btn-success col m-3">Create Game Type</a>
        </div>
        <?php }} else { ?>
            Please Login/Register in order to proceed:
        </p>
        <div class="row">
            <a href="/register" class="btn btn-success col m-3">Register</a>
            <a href="/login" class="btn btn-primary col m-3">Login</a>
        </div>
        <?php } ?>
    </section>
</div>