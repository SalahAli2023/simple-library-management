<?php require_once __DIR__.'/../layout/header.php'; ?>

<div class="container">
    <h1 class="my-4">Update User: <?= htmlspecialchars($user['name']) ?></h1>

    <form action="index.php?action=users&method=edit&id=<?= $user['id'] ?>" method="POST">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" 
                    value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" 
                    value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone No</label>
            <input type="tel" class="form-control" id="phone" name="phone" 
                    value="<?= htmlspecialchars($user['phone']) ?>">
        </div>

        <div class="form-group">
            <label for="password"> A new password (let it blank if you would not change)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="index.php?action=users" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php require_once __DIR__.'/../layout/footer.php'; ?>