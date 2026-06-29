
<section class="p-4 rounded shadow-sm bg-light text-muted">
    <h1 class="display-4 fw-bold mb-3">
        Login
    </h1>
    <form
        action="/login"
        method="POST"
        id="loginForm"
        enctype="multipart/form-data"
        class="container h4">
        <div class="row form-group mb-2">
            <label class="col-4 col-form-label fw-bold" for="inputEmail">Email</label>
            <input class="col up form-control rounded" name="email" id="inputEmail" type="email" value="" placeholder="Email"/>
        </div>
        <div class="row form-group mb-2">
            <label class="col-4 col-form-label fw-bold" for="inputPassword">Password</label>
            <input class="col up form-control rounded" name="password" id="inputPassword" type="password" value="" placeholder="Password"/>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-success mt-5 mr-2">Login</button>
        </div>
    </form>
</section>
<script src="../../js/profile/login.js"></script>