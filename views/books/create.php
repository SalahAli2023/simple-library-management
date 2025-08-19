<?php require_once __DIR__.'/../layout/header.php'; ?>

<div class="container">
    <h1 class="my-4">Add new book</h1>

    <form action="index.php?action=books&method=create" method="POST">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" class="form-control" id="author" name="author" required>
        </div>

        <div class="form-group">
            <label for="isbn"> (ISBN)</label>
            <input type="text" class="form-control" id="isbn" name="isbn" required>
        </div>

        <div class="form-group">
            <label for="total_copies">Total of Copies</label>
            <input type="number" class="form-control" id="total_copies" name="total_copies" min="1" value="1" required>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="index.php?action=books" class="btn btn-secondary">Cancle</a>
    </form>
</div>

<?php require_once __DIR__.'/../layout/footer.php'; ?>