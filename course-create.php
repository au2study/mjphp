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