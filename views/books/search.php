<?php require_once __DIR__.'/../layout/header.php'; ?>

<div class="container">
    <h1 class="my-4">Search about books</h1>

    <form action="index.php?action=books&method=search" method="GET" class="mb-4">
        <input type="hidden" name="action" value="books">
        <input type="hidden" name="method" value="search">

        <div class="input-group">
            <input type="text" class="form-control" name="query" placeholder="Search by book title or author..." 
                    value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '' ?>">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </div>
    </form>

    <?php if (isset($results)): ?>
        <div class="alert alert-info">
            Search result <?= count($results) ?>
        </div>

        <div class="row">
            <?php foreach ($results as $book): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($book['title']) ?></h5>
                            <p class="card-text">
                                <strong>Author:</strong> <?= htmlspecialchars($book['author']) ?><br>
                                <strong>ISBN :</strong> <?= htmlspecialchars($book['isbn']) ?>
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="index.php?action=books&method=edit&id=<?= $book['id'] ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__.'/../layout/footer.php'; ?>