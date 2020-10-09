<form class="form-signin" method="post" action="/guest/registration">
    <h1 class="h3 mb-3 font-weight-normal">Please register</h1>
    <label for="username" class="sr-only">Username</label>
    <input type="text" id="username" class="form-control" placeholder="User name" required="" autofocus="" name="username" autocomplete="off">
    <label for="password" class="sr-only">Password</label>
    <input type="password" id="password" class="form-control" placeholder="Password" required="" name="password" autocomplete="off">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
    <p class="mt-5 mb-3 text-muted">© 2017-<?=date('Y')?></p>
</form>