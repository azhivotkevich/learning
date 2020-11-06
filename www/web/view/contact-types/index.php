<?php

use components\ValidationResult;

/**
 * @var ValidationResult|null $result
 */
?>

<form class="form-signin" method="post" action="/contact-types/create">
    <h1 class="h3 mb-3 font-weight-normal">Add new contact type</h1>
    <label for="name" class="sr-only">Contact type</label>
    <input type="text"
           id="name"
           class="form-control"
           placeholder="Contact type name"
           required=""
           name="name"
           autocomplete="off"
           value="">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>
</form>

<?php

