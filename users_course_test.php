<?php
require_once("../db_connect_mj.php");

$sqlAll = "SELECT * FROM course WHERE valid=1";
$resultALL = $conn->query($sqlAll);
$allCourseCount = $resultALL->num_rows;

$sqlCategory = "SELECT * FROM course_category ORDER BY id ASC";
$resultCate = $conn->query($sqlCategory);
$cateRows = $resultCate->fetch_all(MYSQLI_ASSOC);
$categoryArr = [];
foreach ($cateRows as $cate) {
    $categoryArr[$cate["id"]] = $cate["category_name"];
}

$on_datetime = isset($_GET["on_datetime"]) ? $_GET["on_datetime"] : '';
$off_datetime = isset($_GET["off_datetime"]) ? $_GET["off_datetime"] : '';
$minValue = isset($_GET["min"]) ? $_GET["min"] : 0;
$maxValue = isset($_GET["max"]) ? $_GET["max"] : 99999;

$whereClauses = ["valid = 1"];
if ($on_datetime) {
    $whereClauses[] = "on_datetime >= '$on_datetime'";
}
if ($off_datetime) {
    $whereClauses[] = "off_datetime <= '$off_datetime'";
}
if ($minValue !== '') {
    $whereClauses[] = "price >= $minValue";
}
if ($maxValue !== '') {
    $whereClauses[] = "price <= $maxValue";
}

$whereClause = implode(" AND ", $whereClauses);

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT * FROM course WHERE course_name LIKE '%$search%' AND $whereClause";
    $pageTitle = "$search 的搜尋結果";
}

else if ((isset($_GET["min"]) && $_GET["min"] !== '') || (isset($_GET["max"]) && $_GET["max"] !== '') || (isset($_GET["on_datetime"]) && $_GET["on_datetime"] !== '') || (isset($_GET["off_datetime"]) && $_GET["off_datetime"] !== '')) {
    $minValue = isset($_GET["min"]) ? $_GET["min"] : 0;
    $maxValue = isset($_GET["max"]) ? $_GET["max"] : 99999;
    $on_datetime = isset($_GET["on_datetime"]) ? $_GET["on_datetime"] : '';
    $off_datetime = isset($_GET["off_datetime"]) ? $_GET["off_datetime"] : '';

    $whereClauses = ["valid = 1"];

    if ($minValue !== '' && $maxValue !== '') {
        $whereClauses[] = "price >= $minValue AND price <= $maxValue";
    }

    if ($on_datetime !== '' && $off_datetime !== '') {
        $whereClauses[] = "on_datetime >= '$on_datetime' AND off_datetime <= '$off_datetime'";
    }

    $whereClause = implode(" AND ", $whereClauses);

    $sql = "SELECT * FROM course 
            WHERE $whereClause
            ORDER BY id ASC";

    if ($minValue !== '' && $maxValue !== '' && $on_datetime !== '' && $off_datetime !== '') {
        $pageTitle = "價格在 $minValue ~ $maxValue 元，日期在 $on_datetime ~ $off_datetime 之間的搜尋結果";
    } else if ($minValue !== '' && $maxValue !== '') {
        $pageTitle = "價格在 $minValue ~ $maxValue 元的搜尋結果";
    } else if ($on_datetime !== '' && $off_datetime !== '') {
        $pageTitle = "日期在 $on_datetime ~ $off_datetime 之間的搜尋結果";
    }
}

else if (isset($_GET["page"]) && isset($_GET["order"])) {
    $page = $_GET["page"];
    $perPage = 5;
    $firstItem = ($page - 1) * $perPage;
    $pageCount = ceil($allCourseCount / $perPage);

    $order = $_GET["order"];
    switch ($order) {
        case 1:
            $orderClause = "ORDER BY id ASC";
            break;
        case 2:
            $orderClause = "ORDER BY id DESC";
            break;
        case 3:
            $orderClause = "ORDER BY on_datetime ASC";
            break;
        case 4:
            $orderClause = "ORDER BY on_datetime DESC";
            break;
    }

    $sql = "SELECT * FROM course WHERE $whereClause $orderClause LIMIT $firstItem, $perPage";
    $pageTitle = "課程列表， 第 $page 頁";
} else {
    $sql = "SELECT * FROM course WHERE $whereClause";
    $pageTitle = "課程列表";
    header("location: users_course2.php?page=1&order=1");
}

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
$courseCount = $result->num_rows;
if (isset($_GET["page"])) {
    $userCourseCount = $allCourseCount;
}

?>

<!doctype html>
<html lang="zh-TW">

<head>
    <title>Course</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->


    <?php include("../css_mj.php"); ?>
</head>

<body>
    <div class="container my-4">

        <?php include("nav_mj.php") ?>

        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
            <?php if (isset($_GET["search"]) || isset($_GET["on_datetime"]) || isset($_GET["off_datetime"]) || isset($_GET["max"]) || isset($_GET["min"])) : ?>
    <a class="btn btn-primary" href="users_course2.php">back <i class="fa-solid fa-arrow-left"></i></a>
<?php endif; ?>
            </div>
            <h1 class="h3 text-success"><?= $pageTitle ?></h1>
            <a class="btn btn-success" href="course-upload2.php"><i class="fa-solid fa-file-circle-plus"></i> 新增課程</a>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <form action="" method="get" class="row g-3">
                    <div class="col-md-3">
                        <label for="on_datetime" class="form-label fw-semibold">開始時間</label>
                        <input type="date" id="on_datetime" name="on_datetime" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="off_datetime" class="form-label fw-semibold">結束時間</label>
                        <input type="date" id="off_datetime" name="off_datetime" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="min" class="form-label">最低價格</label>
                        <input type="number" id="min" name="min" min="0" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="max" class="form-label">最高價格</label>
                        <input type="number" id="max" name="max" min="0" class="form-control">
                    </div>
                    <div class="col-md-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> 篩選</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <form action="" method="get" class="row g-3">
                    <div class="col-md-12">
                        <label for="search" class="form-label">搜尋課程</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..." name="search">
                            <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i> 搜尋</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>共 <?= $allCourseCount ?> 門課程</div>
            <?php if (isset($_GET["page"])) : ?>
                <div class="btn-group">
                    <a href="?page=<?= $page ?>&order=1" class="btn btn-outline-primary <?php if ($order == 1) echo "active"; ?>">ID <i class="fa-solid fa-arrow-down-short-wide"></i></a>
                    <a href="?page=<?= $page ?>&order=2" class="btn btn-outline-primary <?php if ($order == 2) echo "active"; ?>">ID <i class="fa-solid fa-arrow-down-wide-short"></i></a>
                    <a href="?page=<?= $page ?>&order=3" class="btn btn-outline-primary <?php if ($order == 3) echo "active"; ?>">上架日期 <i class="fa-solid fa-arrow-down-short-wide"></i></a>
                    <a href="?page=<?= $page ?>&order=4" class="btn btn-outline-primary <?php if ($order == 4) echo "active"; ?>">上架日期 <i class="fa-solid fa-arrow-down-wide-short"></i></a>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($result->num_rows > 0) : ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-end">ID</th>
                            <th>課程名稱</th>
                            <th>分類ID</th>
                            <th>圖片</th>
                            <th class="text-end">價格</th>
                            <th class="text-end">上架日期</th>
                            <th class="text-end">下架日期</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $course) : ?>
                            <tr>
                                <td class="text-end"><?= $course["id"] ?></td>
                                <td><?= $course["course_name"] ?></td>
                                <td><?= $course["course_category_id"] ?></td>
                                <td>
                                    <img src="/mjphp/mjpic/<?= $course["images"] ?>" alt="images" class="img-thumbnail" style="max-width: 100px;">
                                </td>
                                <td class="text-end"><?= $course["price"] ?></td>
                                <td class="text-end"><?= $course["on_datetime"] ?></td>
                                <td class="text-end"><?= $course["off_datetime"] ?></td>
                                <td>
                                    <a href="user_course.php?id=<?= $course["id"] ?>" class="btn btn-warning"><i class="fa-solid fa-eye"></i> 查看</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <p class="text-center">無符合條件的課程。</p>
        <?php endif; ?>

        <?php if (isset($_GET["page"])) : ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                        <li class="page-item <?php if ($i == $page) echo "active"; ?>">
                            <a class="page-link" href="?page=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>