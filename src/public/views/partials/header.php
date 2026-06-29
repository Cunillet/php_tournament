<nav class="navbar navbar-expand lg bg-light navbar -light">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">DD Tournaments</a>
        <?php if ($_SESSION['logged_in']) { ?>
        <form action="/logout" method="GET" id="logoutForm">
            <input type="submit" class="btn btn-danger" value="Logout"/>
        </form>
        <?php } ?>
    </div>
</nav>