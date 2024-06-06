<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>course-upload</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include("../css_mj.php"); ?>

    <style>
        /* 全局樣式調整 */
        body {
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px; /* 增加最大寬度 */
            margin-top: 50px; /* 增加上方間距 */
        }

        /* 表單樣式調整 */
        .form-label {
            font-weight: bold;
        }

        /* 影片和圖片輸入欄樣式調整 */
        input[type="file"] {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
    <a class="btn btn-primary" href="course-list.php">回列表 <i class="fa-solid fa-arrow-left"></i></a>
        <h1 class="text-center mb-5">課程上傳</h1>
        
        <div class="row">
            <div class="col-md-6">
                <form action="doCreateCourse.php" method="post" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label for="course_name" class="form-label">*課程名稱</label>
                        <input type="text" class="form-control" id="course_name" name="course_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">*課程價格</label>
                        <input type="text" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="course_category_id" class="form-label">*類別</label>
                        <select id="course_category_id" name="course_category_id" class="form-select" required>
                            <option value="1">1: Gomoku</option>
                            <option value="2">2: Mahjong</option>
                            <option value="3">3: Go</option>
                            <option value="4">4: Chess</option>
                            <option value="5">5: Shogi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="on_datetime" class="form-label">*上架時間</label>
                        <input type="date" class="form-control" id="on_datetime" name="on_datetime" required>
                    </div>
                    <div class="mb-3">
                        <label for="off_datetime" class="form-label">*下架時間</label>
                        <input type="date" class="form-control" id="off_datetime" name="off_datetime" required>
                    </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="file" class="form-label">*上傳影片</label>
                    <input type="file" class="form-control" id="file" name="file" accept="video/*" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">*上傳圖片</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-info">送出</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>




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
    $video_directory = "../videos/" . $rowCate["category_name"] . "/$last_id";
    $image_directory = "../images/". $rowCate["category_name"] . "/$last_id";
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
    } else {
        echo "檔案或圖片上傳失敗";
    }
} else {
    echo "錯誤: " . $sql . "<br>" . $conn->error;
}

// 關閉語句和連接
$stmt->close();
$conn->close();

// header("location: course-list.php");
exit(); // 添加 exit 確保 header 重定向正常執行
?>
