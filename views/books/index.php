<?php require_once __DIR__.'/../layout/header.php'; ?>

<h1>Books</h1>

<a href="index.php?action=books&method=create" class="btn btn-primary">Add New Book</a>
<a href="index.php?action=books&method=search" class="btn btn-secondary">Search Books</a>

<?php if (isset($_GET['message'])): ?>
    <div class="alert alert-info">
        <?php 
        switch ($_GET['message']) {
            case 'borrow_success':
                echo 'Book borrowed successfully!';
                break;
            case 'borrow_failed':
                echo 'Failed to borrow book.';
                break;
        }
        ?>
    </div>
<?php endif; ?>

<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>ISBN</th>
            <th>Available Copies</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($books as $book): ?>
            <tr>
                <td><?php echo htmlspecialchars($book['title']); ?></td>
                <td><?php echo htmlspecialchars($book['author']); ?></td>
                <td><?php echo htmlspecialchars($book['isbn']); ?></td>
                <td><?php echo htmlspecialchars($book['available_copies']); ?></td>
                <td>
                    <a href="index.php?action=books&method=edit&id=<?php echo $book['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="index.php?action=books&method=delete&id=<?php echo $book['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    <a href="index.php?action=books&method=borrow&book_id=<?php echo $book['id']; ?>&user_id=1" class="btn btn-sm btn-success">Borrow</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__.'/../layout/footer.php'; ?>