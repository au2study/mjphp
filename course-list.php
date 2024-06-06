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
    $categoryArr[$cate["id"]] = $cate["name"];
}



// 初始變數設置

$pageTitle = "課程列表";
$perPage = 10;
$on_datetime = isset($_GET["on_datetime"]) ? $_GET["on_datetime"] : '';
$off_datetime = isset($_GET["off_datetime"]) ? $_GET["off_datetime"] : '';
$minValue = isset($_GET["minValue"]) && $_GET["minValue"] !== '0' ? $_GET["minValue"] : '';
$maxValue = isset($_GET["maxValue"]) && $_GET["maxValue"] !== '0' ? $_GET["maxValue"] : '';
$search = isset($_GET["search"]) ? $_GET["search"] : '';
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
$order = isset($_GET["order"]) ? (int)$_GET["order"] : 1;
$firstItem = ($page - 1) * $perPage;





// 建立 WHERE 子句
$whereClause = " WHERE valid = 1 ";
if (!empty($on_datetime) && !empty($off_datetime)) {
    $whereClause .= " AND on_datetime >= '$on_datetime' AND off_datetime <= '$off_datetime'";
}
if (!empty($minValue)) {
    $whereClause .= " AND price >= $minValue";
}
if (!empty($maxValue)) {
    $whereClause .= " AND price <= $maxValue";
}
if (!empty($search)) {
    $whereClause .= " AND (course_name LIKE '%$search%')";
}

// 設置排序選項

$orderOptions = [
    1 => " ORDER BY id DESC",
    2 => " ORDER BY id ASC",
    3 => " ORDER BY course_name DESC",
    4 => " ORDER BY course_name ASC",
    5 => " ORDER BY price DESC",
    6 => " ORDER BY price ASC",
    7 => " ORDER BY on_datetime DESC",
    8 => " ORDER BY on_datetime ASC",
    9 => " ORDER BY off_datetime DESC",
    10 => " ORDER BY off_datetime ASC",
];

$orderClause = $orderOptions[$order] ?? $orderOptions[1];


// 初始化 categoryClause
$categoryClause = "";
if (isset($_GET["category"]) && !empty($_GET["category"])) {
    $category_id = $_GET["category"];
    $categoryClause = " AND course.course_category_id = $category_id"; // 確保前面有空格
    $pageTitle = isset($categoryArr[$category_id]) ? $categoryArr[$category_id] . "課程列表" : "課程列表";
}

// 建立查詢語句
$sql = "SELECT course.*, course_category.name AS category_name 
        FROM course 
        JOIN course_category ON course.course_category_id = course_category.id 
        $whereClause 
        $categoryClause 
        $orderClause 
        LIMIT $firstItem, $perPage";

// 設置搜尋結果
$searchResult = "";

if (!empty($on_datetime) && !empty($off_datetime)) {
    $searchResult .= "日期在 $on_datetime ~ $off_datetime 之間";
}
if (!empty($maxValue) && !empty($minValue)) {
    $searchResult .= ($searchResult ? ', ' : '') . "價格在 $minValue ~ $maxValue 元";
}
if (!empty($search)) {
    $searchResult .= ($searchResult ? ', ' : '') . "$search 的搜尋結果";
}


// 獲取查詢結果

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
$courseCount = $result->num_rows;


// 獲取符合條件的總數量以進行分頁
// 獲取符合條件的總數量以進行分頁
$totalSql = "SELECT COUNT(*) AS total FROM course $whereClause $categoryClause";

$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$allCourseCount = $totalRow['total'];
$pageCount = ceil($allCourseCount / $perPage);

?>

<!doctype html>
<html lang="zh-TW">

<head>
    <title>Course List</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->


    <?php include("../css_mj.php"); ?>
</head>

<body>
    <div class="container my-4">

        <div class="d-flex justify-content-center align-items-center my-3">
            <h1 class="text-success fw-bold"><?= $pageTitle ?></h1>
        </div>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?php if (isset($_GET["search"]) || isset($_GET["on_datetime"]) || isset($_GET["off_datetime"]) || isset($_GET["minValue"]) || isset($_GET["maxValue"])) : ?>
                    <a class="btn btn-primary" href="course-list.php"><i class="fa-solid fa-arrow-left"></i> 返回列表</a>
                <?php endif; ?>
            </div>

            <a class="btn btn-success" href="course-create.php"><i class="fa-solid fa-file-circle-plus"></i> 新增課程</a>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <form action="" method="get" class="">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <label for="on_datetime" class="form-label fw-semibold w-50">上架日期</label>
                            <input type="date" id="on_datetime" name="on_datetime" class="form-control" value="<?= $on_datetime ?>">
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="off_datetime" class="form-label fw-semibold  w-50">下架日期</label>
                            <input type="date" id="off_datetime" name="off_datetime" class="form-control" value="<?= $off_datetime ?>">
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="minValue" class="form-label fw-semibold  w-50">最低價格</label>
                            <input type="number" id="minValue" placeholder="請輸入查詢價格。" name="minValue" class="form-control " min="0" value="<?= $minValue ?>">
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="maxValue" class="form-label fw-semibold  w-50">最高價格</label>
                            <input type="number" min="0" id="maxValue" placeholder="請輸入查詢價格。" name="maxValue" class="form-control" value="<?= $maxValue ?>">
                        </div>

                        <div class="">
                            <input type="hidden" name="search" value="<?= $search ?>">
                            <input type="hidden" name="page" value="1">
                            <input type="hidden" name="order" value="<?= $order ?>">
                            <input type="hidden" name="course_category" value="<?= $category_id ?>">
                            <button type="submit" class="btn btn-primary "><i class="fa-solid fa-magnifying-glass"></i></button>
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
                            <input type="text" class="form-control" placeholder="請輸入要查詢的課程名稱。" name="search" value="<?= $search ?>">
                            <input type="hidden" name="off_datetime" value="<?= $off_datetime ?>">
                            <input type="hidden" name="on_datetime" value="<?= $on_datetime ?>">
                            <input type="hidden" name="minValue" value="<?= $minValue ?>">
                            <input type="hidden" name="maxValue" value="<?= $maxValue ?>">
                            <input type="hidden" name="page" value="1">
                            <input type="hidden" name="order" value="<?= $order ?>">
                            <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i> 搜尋</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="ps-3"><?= " $searchResult  共 $allCourseCount 堂課程" ?></div>
            <div class="px-2">
                <?php include("nav_mj.php") ?>
            </div>
        </div>

        <?php if ($courseCount > 0) : ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-end">ID
                                <a href="?page=<?= $page ?>&order=<?= ($order == 1) ? 2 : 1 ?>&on_datetime=<?php if (isset($on_datetime)) echo $on_datetime ?>&off_datetime=<?php if (isset($off_datetime)) echo $off_datetime ?>&maxValue=<?php if (isset($maxValue)) echo $maxValue ?>&minValue=<?php if (isset($minValue)) echo $minValue ?>&search=<?php if (isset($search)) echo $search ?>&category=<?php if (isset($category_id)) echo $category_id ?>" class="sort-icon text-white">
                                    <i class="fa-solid fa-sort"></i>
                                </a>
                            </th>
                            <th>課程名稱
                                <a href="?page=<?= $page ?>&order=<?= ($order == 3) ? 4 : 3 ?>&on_datetime=<?php if (isset($on_datetime)) echo $on_datetime ?>&off_datetime=<?php if (isset($off_datetime)) echo $off_datetime ?>&maxValue=<?php if (isset($maxValue)) echo $maxValue ?>&minValue=<?php if (isset($minValue)) echo $minValue ?>&search=<?php if (isset($search)) echo $search ?>&category=<?php if (isset($category_id)) echo $category_id ?>" class="sort-icon text-white">
                                    <i class="fa-solid fa-sort"></i>
                                </a>
                            </th>
                            <th>分類ID </th>
                            <th>圖片</th>
                            <th class="text-end">價格
                                <a href="?page=<?= $page ?>&order=<?= ($order == 5) ? 6 : 5 ?>&on_datetime=<?php if (isset($on_datetime)) echo $on_datetime ?>&off_datetime=<?php if (isset($off_datetime)) echo $off_datetime ?>&maxValue=<?php if (isset($maxValue)) echo $maxValue ?>&minValue=<?php if (isset($minValue)) echo $minValue ?>&search=<?php if (isset($search)) echo $search ?>&category=<?php if (isset($category_id)) echo $category_id ?>" class="sort-icon text-white">
                                    <i class="fa-solid fa-sort"></i>
                                </a>
                            </th>
                            <th class="text-end">上架日期
                                <a href="?page=<?= $page ?>&order=<?= ($order == 7) ? 8 : 7 ?>&on_datetime=<?php if (isset($on_datetime)) echo $on_datetime ?>&off_datetime=<?php if (isset($off_datetime)) echo $off_datetime ?>&maxValue=<?php if (isset($maxValue)) echo $maxValue ?>&minValue=<?php if (isset($minValue)) echo $minValue ?>&search=<?php if (isset($search)) echo $search ?>&category=<?php if (isset($category_id)) echo $category_id ?>" class="sort-icon text-white">
                                    <i class="fa-solid fa-sort"></i>
                                </a>
                            </th>
                            <th class="text-end">下架日期
                                <a href="?page=<?= $page ?>&order=<?= ($order == 9) ? 10 : 9 ?>&on_datetime=<?php if (isset($on_datetime)) echo $on_datetime ?>&off_datetime=<?php if (isset($off_datetime)) echo $off_datetime ?>&maxValue=<?php if (isset($maxValue)) echo $maxValue ?>&minValue=<?php if (isset($minValue)) echo $minValue ?>&search=<?php if (isset($search)) echo $search ?>&category=<?php if (isset($category_id)) echo $category_id ?>" class="sort-icon text-white">
                                    <i class="fa-solid fa-sort"></i>
                                </a>
                            </th>

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
                                    <img src="/mjphp/images/<?= $course["category_name"] ?>/<?= $course["images"] ?>" alt="images" class="img-thumbnail" style="max-width: 100px;">
                                </td>
                                <td class="text-end"><?= $course["price"] ?></td>
                                <td class="text-end"><?= $course["on_datetime"] ?></td>
                                <td class="text-end"><?= $course["off_datetime"] ?></td>
                                <td>
                                    <a href="course-detail.php?id=<?= $course["id"] ?>" class="btn btn-warning"><i class="fa-solid fa-eye"></i> 查看</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                <?php if ($pageCount >= 1) : ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                                <li class="page-item <?php if ($i == $page) echo "active"; ?>">
                                    <a class="page-link" href="?page=<?= $i ?>&order=<?php if (isset($order)) echo $order ?>&on_datetime=<?php if (isset($on_datetime)) echo $on_datetime ?>&off_datetime=<?php if (isset($off_datetime)) echo $off_datetime ?>&maxValue=<?php if (isset($maxValue)) echo $maxValue ?>&minValue=<?php if (isset($minValue)) echo $minValue ?>&search=<?php if (isset($search)) echo $search ?>&category=<?php if (isset($category_id)) echo $category_id ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php else : ?>
                <p class="text-center">無符合條件的課程。</p>
            <?php endif; ?>

            </div>

            <!-- Bootstrap JS -->
            <script>
                // 防止日曆選之前或之後
                document.getElementById("on_datetime").addEventListener("change", function() {
                    document.getElementById("off_datetime").min = this.value;
                });
                document.getElementById("off_datetime").addEventListener("change", function() {
                    document.getElementById("on_datetime").max = this.value;
                });
            </script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>