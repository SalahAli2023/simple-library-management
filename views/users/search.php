<?php
$pageTitle = "Search Users";
require_once __DIR__ .'/../layout/header.php';
?>

<div class="container">
    <h1 class="my-4">Search Results</h1>
    
    <!-- Search Form -->
    <form method="GET" action="index.php?action=users&method=create" class="mb-4">
        <input type="hidden" name="action" value="users">
        <input type="hidden" name="method" value="search">
        
        <div class="input-group">
            <input type="text" class="form-control" 
                    name="query" 
                    placeholder="Search by name, email..."
                    value="<?= htmlspecialchars($query) ?>">
                    
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search"></i> Search
            </button>
            
            <a href="index.php?action=users" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> Clear
            </a>
        </div>
    </form>

    <!-- Results -->
    <?php if (!empty($results)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['phone']) ?></td>
                            <td>
                                <a href="index.php?action=users&method=edit&id=<?= $user['id'] ?>" 
                                    class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            No users found matching "<?= htmlspecialchars($query) ?>"
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ .'/../layout/footer.php'; ?>