<div class="row">
    <div class="col-12 justify-content-center">
        <!-- Your content here -->
        <h1>Register</h1>
        <div id="message"></div>
        <form action="/register" id="registerForm" method="POST" class="d-flex flex-column">
            <span class="">
                <span type="text" name="user_name" id="user_name">
                    <?php echo $name ?>
                </span>
            </span>
            <span class="">
                <span type="text" name="user_role" id="user_role">
                    <?php echo $role ?>
                </span>
            </span>
        </form>
    </div>
</div>