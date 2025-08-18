<?php require_once __DIR__.'/../layout/header.php'; ?>

<div class="container">
    <h1 class="my-4">Add new user</h1>

    <form action="index.php?action=users&method=create" method="POST">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="email"> Email </label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone No </label>
            <input type="tel" class="form-control" id="phone" name="phone">
        </div>

        <div class="form-group">
            <label for="password">Password </label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="index.php?action=users" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php require_once __DIR__.'/../layout/footer.php'; ?>