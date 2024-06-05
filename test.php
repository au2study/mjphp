<?php
require_once("../db_connect_mj.php");

if(!isset($_POST["course_name"])){
    echo json_encode([
        'success' => false,
        'message' => '請循正常管道進入此頁'
    ]);
    exit;
}

header('Content-Type: application/json');

// 上傳目錄
$uploadDir = './uploadmj/';

// 檢查目錄是否存在，不存在就建立一個
if (!is_dir($uploadDir)) {
  mkdir($uploadDir, 0777, true);
}

// 檢查是否有上傳檔案
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
  $file = $_FILES['file'];
  $fileInfo = pathinfo($file['name']);
  $extension = isset($fileInfo['extension']) ? '.' . $fileInfo['extension'] : '';
  $filename = time() . $extension;
  $targetFile = $uploadDir . $filename;

  // 檢查檔案是否已存在，如果存在就重新命名
  if (file_exists($targetFile)) {
    $filename = uniqid() . '_' . $filename;
    $targetFile = $uploadDir . $filename;
  }

  // 移動上傳檔案到目標目錄
  if (move_uploaded_file($file['tmp_name'], $targetFile)) {
    $course_name = $conn->real_escape_string($_POST['course_name']);
    $pic_name = $conn->real_escape_string($filename);

    $sql = "INSERT INTO images (course_name, pic_name) VALUES ('$course_name', '$pic_name')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode([
            'success' => true,
            'filename' => $filename
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $conn->error
        ]);
    }
  } else {
    echo json_encode([
      'success' => false,
      'message' => '移動檔案失敗'
    ]);
  }
} else {
  echo json_encode([
    'success' => false,
    'message' => '上傳發生錯誤'
  ]);
}

$conn->close();
?>
