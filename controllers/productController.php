<?php

session_start();
require_once '../db/db.php';

if ($_REQUEST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Token CSRF inválido');
}

$opc = $_REQUEST['opc'];

function getProduct($pdo){
    $response = array();

    $sql = "SELECT 
            p.product_id AS id,
            p.photo, 
            p.category_id,
            c.category,
            p.product,
            p.description,
            p.price,
            p.photo
        FROM products AS p
            INNER JOIN categories AS c ON c.category_id = p.category_id
        WHERE p.is_actived = 1
        ORDER BY p.product_id ASC";
    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if( count((array)$products) > 0){
        $response = array("status" => "success", "data" => $products);
    }else{
        $response = array("status" => "error", "message" => "");
    }
    echo json_encode($response);
}

function getCategory($pdo){
    $response = array();

    $sql = "SELECT 
            category_id, category, is_actived, created_by, created_at, modified_by, modified_at
        FROM categories
        WHERE is_actived = 1
        ORDER BY category_id ASC";
    $stmt = $pdo->query($sql);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if( count((array)$categories) > 0){
        $response = array("status" => "success", "data" => $categories);
    }else{
        $response = array("status" => "success", "data" => []);
    }
    echo json_encode($response);
}

switch ($opc) {
    case 'getProduct':
        $productId = $_GET['productId'] ?? 0;
        $response = array();

        $sql = "SELECT 
            p.product_id AS id,
            p.photo, 
            p.category_id,
            c.category,
            p.product,
            p.description,
            p.price,
            p.photo
        FROM products AS p
            INNER JOIN categories AS c ON c.category_id = p.category_id
        WHERE p.is_actived = 1 AND p.product_id = :product_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'product_id' => $productId
        ]);
        $products = $stmt->fetch(PDO::FETCH_ASSOC);

        if( $products){
            $response = array("status" => "success", "data" => $products);
        }else{
            $response = array("status" => "success", "data" => []);
        }
        echo json_encode($response);
    break;
    case 'get':
        getProduct($pdo);
    break;
    case 'getCategory':
        getCategory($pdo);
    break;
    case 'add':
        $response = array();
        $photo = $_FILES['photo'] ?? "";
        $product = $_POST['product'] ?? "";
        $Description = $_POST['Description'] ?? "";
        $category = $_POST['category'] ?? 0;
        $Price = $_POST['Price'] ?? 0;

        if ( !empty($product) && !empty($category) && !empty($Price) ) {
            if ($photo['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../public/img/products/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $imageExtension = pathinfo($photo['name'], PATHINFO_EXTENSION);
                $uniqueName = uniqid('img_', true) . '.' . $imageExtension;
                $uploadFile = $uploadDir . $uniqueName;

                if (move_uploaded_file($photo['tmp_name'], $uploadFile)) {
                    $stmt = $pdo->prepare("INSERT INTO products (product, description, category_id, price, photo, created_by) VALUES (:product, :description, :category, :price, :photo, :created_by)");
                    $stmt->execute([
                        'product' => $product,
                        'description' => $Description,
                        'category' => $category,
                        'price' => $Price,
                        'photo' => $uniqueName,
                        'created_by' => $_SESSION['user_id'],
                    ]);
                    $response = array("status" => "success", "message" => "");
                } else {
                    $response = array("status" => "error", "message" => "Error moving image");
                }
            } else {
                $response = array("status" => "error", "message" => "Image upload error");
            }
        }else{
            $response = array("status" => "error", "message" => "Missing necessary data");
        }

        echo json_encode($response);
    break;
    case 'edit':

        $response = array();
        $photo = $_FILES['photo'] ?? "";
        $product_id = $_POST['product_id'] ?? 0;
        $product = $_POST['product'] ?? "";
        $Description = $_POST['Description'] ?? "";
        $category = $_POST['category'] ?? 0;
        $Price = $_POST['Price'] ?? 0;

        if ( !empty($product_id) && !empty($product) && !empty($category) && !empty($Price) ) {

            if( !empty($photo) ){
                if ($photo['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = '../public/img/products/';

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $imageExtension = pathinfo($photo['name'], PATHINFO_EXTENSION);
                    $uniqueName = uniqid('img_', true) . '.' . $imageExtension;
                    $uploadFile = $uploadDir . $uniqueName;

                    if (move_uploaded_file($photo['tmp_name'], $uploadFile)) {
                        $stmt = $pdo->prepare("update products set category_id = :category_id, product = :product, description = :description, price = :price, photo = :photo, modified_by = :modified_by, modified_at = now() WHERE product_id = :product_id");
                        $stmt->execute([
                            'category_id' => $category,
                            'product' => $product,
                            'description' => $Description,
                            'price' => $Price,
                            'photo' => $uniqueName,
                            'modified_by' => $_SESSION['user_id'],
                            'product_id' => $product_id,
                        ]);
                        $response = array("status" => "success", "message" => "");
                    } else {
                        $response = array("status" => "error", "message" => "Error moving image");
                    }
                } else {
                    $response = array("status" => "error", "message" => "Image upload error");
                }
            }else{
                $stmt = $pdo->prepare("update products set category_id = :category_id, product = :product, description = :description, price = :price, modified_by = :modified_by, modified_at = now() WHERE product_id = :product_id");
                $stmt->execute([
                    'category_id' => $category,
                    'product' => $product,
                    'description' => $Description,
                    'price' => $Price,
                    'modified_by' => $_SESSION['user_id'],
                    'product_id' => $product_id,
                ]);
                $response = array("status" => "success", "message" => "");
            }
        }else{
            $response = array("status" => "error", "message" => "Missing necessary data");
        }

        echo json_encode($response);
    break;
    case 'delete':
        $response = array();
        $productId = $_GET['productId'] ?? 0;

        if ( !empty($productId) ) {
            $stmt = $pdo->prepare("update products set is_actived = 0, modified_by = :modified_by, modified_at = now() where product_id = :productId");
            $stmt->execute([
                'modified_by' => $_SESSION['user_id'],
                'productId' => $productId
            ]);

            $response = array("status" => "success", "message" => "");
        }else{
            $response = array("status" => "error", "message" => "Missing necessary data");
        }

        echo json_encode($response);
    break;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

}
