<?php require_once __DIR__.'/../layout/header.php'; ?>

<div class="container">
    <h1 class="my-4">Edit Book : <?= htmlspecialchars($book['title']) ?></h1>

    <form action="index.php?action=books&method=edit&id=<?= $book['id'] ?>" method="POST">
        <input type="hidden" name="id" value="<?= $book['id'] ?>">

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" 
                    value="<?= htmlspecialchars($book['title']) ?>" required>
        </div>

        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" class="form-control" id="author" name="author" 
                    value="<?= htmlspecialchars($book['author']) ?>" required>
        </div>

        <div class="form-group">
            <label for="isbn">(ISBN)</label>
            <input type="text" class="form-control" id="isbn" name="isbn" 
                    value="<?= htmlspecialchars($book['isbn']) ?>" required>
        </div>

        <div class="form-group">
            <label for="total_copies">Total Copies</label>
            <input type="number" class="form-control" id="total_copies" name="total_copies" 
                    value="<?= htmlspecialchars($book['total_copies']) ?>" min="1" required>
        </div>

        <div class="form-group">
            <label for="available_copies">Available Copies</label>
            <input type="number" class="form-control" id="available_copies" name="available_copies" 
                    value="<?= htmlspecialchars($book['available_copies']) ?>" min="0" 
                    max="<?= htmlspecialchars($book['total_copies']) ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="index.php?action=books" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php require_once __DIR__.'/../layout/footer.php'; ?>