<?php
require_once("../db_connect_mj.php");

// 檢查是否從正常管道進入此頁
if (!isset($_POST["course_name"])) {
    die("請循正常管道進入此頁");
}

// 接收表單數據
$course_name = $_POST["course_name"];
$price = $_POST["price"];
$course_category_id = $_POST["course_category_id"];
$on_datetime = $_POST["on_datetime"];
$off_datetime = $_POST["off_datetime"];
$file = $_FILES["file"];
$image = $_FILES["image"];
$now = date('Y-m-d H:i:s');

// 檢查課程是否已存在
$sqlCheckCourse = "SELECT * FROM course WHERE course_name = ?";
$stmtCheck = $conn->prepare($sqlCheckCourse);
$stmtCheck->bind_param("s", $course_name);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();
if ($resultCheck->num_rows > 0) {
    echo "此課程已經有人註冊";
    exit;
}
$stmtCheck->close();

// 使用預處理語句準備 SQL，防止 SQL 注入
$sql = "INSERT INTO course (course_name, price, course_category_id, on_datetime, off_datetime, file, images, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "錯誤: " . $conn->error;
    exit;
}

// 綁定參數
$stmt->bind_param("ssssssss", $course_name, $price, $course_category_id, $on_datetime, $off_datetime, $file['name'], $image['name'], $now);

// 執行語句
if ($stmt->execute()) {
    $last_id = $conn->insert_id;

$sqlCate ="SELECT course.*, course_category.name AS category_name FROM course 
JOIN course_category ON course.course_category_id = $course_category_id";
$resultCate = $conn->query($sqlCate);
$rowCate=$resultCate->fetch_assoc();

    // 如果目錄不存在則創建目錄
    $video_directory = "../mjphp/videos/" . $rowCate["category_name"];
    $image_directory = "../mjphp/images/". $rowCate["category_name"];
    if (!file_exists($video_directory)) {
        mkdir($video_directory, 0777, true); // 遞歸創建目錄
    }
    if (!file_exists($image_directory)) {
        mkdir($image_directory, 0777, true); // 遞歸創建目錄
    }

    // 移動上傳的文件到目錄
    $uploaded_file = $video_directory . '/' . basename($file["name"]);
    $uploaded_image = $image_directory . '/' . basename($image["name"]);

    if (move_uploaded_file($file["tmp_name"], $uploaded_file) && move_uploaded_file($image["tmp_name"], $uploaded_image)) {
        echo "檔案和圖片上傳成功，新資料輸入成功，id 為 $last_id";
        header("location: course-list.php");
    } else {
        echo "檔案或圖片上傳失敗";
    }
} else {
    echo "錯誤: " . $sql . "<br>" . $conn->error;
}

// 關閉語句和連接
$stmt->close();
$conn->close();


exit(); // 添加 exit 確保 header 重定向正常執行
?>

