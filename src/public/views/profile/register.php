<div class="row">
    <div class="col-12 justify-content-center">
        <!-- Your content here -->
        <h1>Register</h1>
        <div id="message"></div>
        <form action="api/register" id="registerForm" method="POST" class="d-flex flex-column">
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
<script src="../../js/profile/register.js"></script>