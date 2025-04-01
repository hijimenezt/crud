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
        <a class="active" href="product.php">Product</a>
        <a href="category.php">Category</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="row" style="display: flex;align-items: center;">
    <div class="column">
        <h1>Products List</h1>
    </div>
    <div class="column">
        <a id="addProductModal" class="button success" style="float: right;" href="#">Add</a>
    </div>
</div>

<div style="overflow-x:auto;">
    <table id="products"></table>
</div>

<!-- The Modal view photo-->
<div id="myModalImg" class="modalImg">

    <!-- The Close Button -->
    <span class="closeImg">&times;</span>

    <!-- Modal Content (The Image) -->
    <img class="modalImg-content" id="img01">

    <!-- Modal Caption (Image Text) -->
    <div id="caption"></div>
</div>

<!-- The Modal Add product -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1>Add Product</h1>

        <div class="row">
            <div class="container">
                <form action="#" method="post">
                    <label for="product">Product</label>
                    <input type="text" id="product" name="product" required>

                    <label for="Description">Description</label>
                    <textarea id="Description" name="Description" style="height:200px"></textarea>

                    <label for="category">Category</label>
                    <select id="category" name="category" required></select>

                    <label for="Price">Price</label>
                    <input type="number" id="Price" name="Price" required>

                    <label for="photo">Select a file:</label>
                    <input type="file" id="photo" name="photo" accept="image/*">

                    <br>
                    <br>

                    <button id="addProduct" class="button success" type="submit">Save</button>
                    <button id="cancelAddProduct" class="button danger" type="button">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- The Modal Edit product -->
<div id="myModalEdit" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close closeEdit">&times;</span>
        <h1>Edit Product</h1>

        <div class="row">
            <div class="container">
                <form action="#" method="post">
                    <input type="hidden" name="productId" id="productId">

                    <label for="productEdit">Product</label>
                    <input type="text" id="productEdit" name="productEdit" required>

                    <label for="DescriptionEdit">Description</label>
                    <textarea id="DescriptionEdit" name="DescriptionEdit" style="height:200px"></textarea>

                    <label for="categoryEdit">Category</label>
                    <select id="categoryEdit" name="categoryEdit" required></select>

                    <label for="PriceEdit">Price</label>
                    <input type="number" id="PriceEdit" name="PriceEdit" required>

                    <label for="photoEdit">Select a file:</label>
                    <input type="file" id="photoEdit" name="photoEdit" accept="image/*">

                    <br>
                    <br>

                    <button id="editProduct" class="button success" type="submit">Edit</button>
                    <button id="cancelEditProduct" class="button danger" type="button">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="public/js/product.js"></script>
</body>
</html>
