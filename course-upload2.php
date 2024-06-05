<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>course-upload</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <?php include("../css_mj.php"); ?>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-6">
                <form action="course-upload2.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="course_name" class="form-label">*課程名稱</label>
                        <input type="text" class="form-control" id="course_name" name="course_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">*課程價格</label>
                        <input type="text" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="on_datetime" class="form-label">*上架時間</label>
                        <input type="date" class="form-control" id="on_datetime" name="on_datetime" required>
                    </div>
                    <div class="mb-3">
                        <label for="off_datetime" class="form-label">*下架時間</label>
                        <input type="date" class="form-control" id="off_datetime" name="off_datetime" required>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">*選擇檔案</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-info">送出</button>
                </form>
            </div>

            <div class="col-lg-6">
                <div class="row row-cols-1 row-cols-md-2 g-3">
                    <?php foreach($rows as $image): ?>
                    <div class="col">
                        <div class="card">
                            <img src="/uploadmj/<?=$image["pic_name"]?>" class="card-img-top" alt="<?=$image["name"]?>">
                            <div class="card-body">
                                <h5 class="card-title"><?=$image["name"]?></h5>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
