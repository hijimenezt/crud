<?php
require_once 'db/db.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crud</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="public/css/dashboard.css">
    <link rel="stylesheet" href="public/css/product.css">
</head>
<body>
<input id="csrf_token" type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

<div class="header">
    <a href="dashboard.php" class="logo">CRUD</a>
    <div class="header-right">
        <a href="product.php">Product</a>
        <a class="active" href="category.php">Category</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="row" style="display: flex;align-items: center;">
    <div class="column">
        <h1>Categories List</h1>
    </div>
    <div class="column">
        <a id="addCategoryModal" class="button success" style="float: right;" href="#">Add</a>
    </div>
</div>

<div style="overflow-x:auto;">
    <table id="categories"></table>
</div>

<!-- The Modal Add -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1>Add Category</h1>

        <div class="row">
            <div class="container">
                <form action="#" method="post">
                    <label for="category">Category</label>
                    <input type="text" id="category" name="category" required>

                    <br>
                    <br>

                    <button id="addCategory" class="button success" type="submit">Save</button>
                    <button id="cancelAddCategory" class="button danger" type="button">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- The Modal Edit -->
<div id="myModalEdit" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close closeEdit">&times;</span>
        <h1>Edit Category</h1>

        <div class="row">
            <div class="container">
                <form action="#" method="post">
                    <input type="hidden" name="categoryId" id="categoryId">

                    <label for="categoryEdit">Category</label>
                    <input type="text" id="categoryEdit" name="categoryEdit" required>

                    <br>
                    <br>

                    <button id="editCategory" class="button success" type="submit">Edit</button>
                    <button id="cancelEditCategory" class="button danger" type="button">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="public/js/category.js"></script>
</body>
</html>
