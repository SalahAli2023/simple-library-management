<?php require_once __DIR__ .'/../layout/header.php'; ?>

<div class=" container-fluid">

    <h1 class="my-4">Users Management </h1>
    <div class="row">
        <div class="col-12">
            <div class=" px-4 shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Users List</h6>
                    <div>
                        <a href="index.php?action=users&method=create" class="btn btn-primary btn-sm ">
                            <i class="fas fa-user-plus"></i> Add new user  
                        </a>
                    </div>
                </div>
                <hr>
                <div class="card-body">

                    <form method="get" action="index.php" class="mb-4">
                        <input type="hidden" name="action" value="users">
                        <input type="hidden" name="method" value="search">
                        <div class="input-group">
                            <input type="text" class="form-control" name="query" 
                                    placeholder="Search by name or email..." 
                                    value="<?= htmlspecialchars($_GET['query'] ?? '') ?>">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <?php if (isset($_GET['query'])): ?>
                                <a href="index.php?action=users" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                    
                    <!-- Status Messages -->
                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <?= htmlspecialchars($_GET['success']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email </th>
                                <th>Phone No</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user ): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['id']) ?></td>
                                    <td><?= htmlspecialchars($user['name']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['phone']) ?></td>
                                    <td>
                                        <a href="index.php?action=users&method=edit&id=<?= $user['id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i>Edit</a>
                                        <a href="index.php?action=books&method=delete&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ .'/../layout/footer.php'; ?>

