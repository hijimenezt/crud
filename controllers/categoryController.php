<?php

session_start();
require_once '../db/db.php';

if ($_REQUEST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Token CSRF inválido');
}

$opc = $_REQUEST['opc'];

function getCategory($pdo){
    $response = array();

    $sql = "SELECT 
            category_id AS id, category, is_actived, created_by, created_at, modified_by, modified_at
        FROM categories
        WHERE is_actived = 1
        ORDER BY category_id ASC";
    $stmt = $pdo->query($sql);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if( count((array)$categories) > 0){
        $response = array("status" => "success", "data" => $categories);
    }else{
        $response = array("status" => "error", "message" => "");
    }
    echo json_encode($response);
}

switch ($opc) {
    case 'getCategory':
        $id = $_GET['categoryId'] ?? 0;
        $response = array();

        $sql = "SELECT category_id, category, is_actived, created_by, created_at, modified_by, modified_at FROM categories WHERE category_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        $categories = $stmt->fetch(PDO::FETCH_ASSOC);

        if( $categories){
            $response = array("status" => "success", "data" => $categories);
        }else{
            $response = array("status" => "error", "message" => "");
        }
        echo json_encode($response);
        break;
    case 'get':
        getCategory($pdo);
        break;
    case 'add':
        $response = array();
        $category = $_POST['category'] ?? "";

        if ( !empty($category) ) {
            $stmt = $pdo->prepare("INSERT INTO categories (category, created_by) VALUES (:category, :created_by)");
            $stmt->execute([
                'category' => $category,
                'created_by' => $_SESSION['user_id'],
            ]);
            $response = array("status" => "success", "message" => "");
        }else{
            $response = array("status" => "error", "message" => "Missing necessary data");
        }

        echo json_encode($response);
        break;
    case 'edit':

        $response = array();
        $category_id = $_POST['category_id'] ?? 0;
        $category = $_POST['category'] ?? "";

        if ( !empty($category_id) && !empty($category) ) {

            $stmt = $pdo->prepare("update categories set category = :category, modified_by = :modified_by, modified_at = now() WHERE category_id = :category_id");
            $stmt->execute([
                'category' => $category,
                'modified_by' => $_SESSION['user_id'],
                'category_id' => $category_id
            ]);
            $response = array("status" => "success", "message" => "");
        }else{
            $response = array("status" => "error", "message" => "Missing necessary data");
        }

        echo json_encode($response);
        break;
    case 'delete':
        $response = array();
        $categoryId = $_GET['categoryId'] ?? 0;

        if ( !empty($categoryId) ) {
            $stmt = $pdo->prepare("update categories set is_actived = 0, modified_by = :modified_by, modified_at = now() where category_id = :category_id");
            $stmt->execute([
                'modified_by' => $_SESSION['user_id'],
                'category_id' => $categoryId
            ]);

            $response = array("status" => "success", "message" => "");
        }else{
            $response = array("status" => "error", "message" => "Missing necessary data");
        }

        echo json_encode($response);
        break;
}