<div class="row">
    <div class="col-12 justify-content-center">
        <!-- Your content here -->
        <h1>Login</h1>
        <div id="message"></div>
        <form action="api/login" id="loginForm" method="POST" class="d-flex flex-column">
            <span class="">
                <input type="email" name="user_email" id="user_email" placeholder="email"/>
            </span>
            <span class="">
                <input type="password" name="user_password" id="user_password" placeholder="password"/>
            </span>
            <input type="submit" id="login_submit" value="Submit"/>
        </form>
    </div>
</div>
<script src="../../js/profile/login.js"></script>