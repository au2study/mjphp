<!doctype html>
<html lang="en">
    <head>
        <title>test</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <?php include("../css_mj.php"); ?>
    </head>

    <body>

    if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT * FROM course WHERE name LIKE '$search' WHERE valid=1";
    $pageTitle = "$search 的搜尋結果";
} else if (isset($_GET["page"]) && isset($_GET["order"])) {
    $page = $_GET["page"];
    $perPage = 5;
    $firstItem = ($page - 1) * $perPage;
    $pageCount = ceil($allCourseCount / $perPage);

    $order=$_GET["order"];
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

    $sql = "SELECT * FROM course WHERE valid=1 
    $orderClause LIMIT $firstItem, $perPage";
    
    $pageTitle = "課程列表， 第 $page 頁";
} else {
    $sql = "SELECT * FROM course WHERE valid=1";
    $pageTitle = "課程列表";
    header("location: users_course.php?page=1&order=1");
}

<i class="fa-solid fa-arrow-down-short-wide"></i>
<i class="fa-solid fa-arrow-down-wide-short"></i>
<i class="fa-solid fa-arrow-down-short-wide"></i>
<i class="fa-solid fa-arrow-down-wide-short"></i>
<i class="fa-solid fa-eye"></i>

uploadImage.addEventListener("change", (e) => {
            const file = e.target.files[0];
            const reader = new FileReader();

            if (image.src) {
                URL.revokeObjectURL(image.src);
            }

            reader.readAsDataURL(file);
            reader.addEventListener("load", () => {
                image.src = reader.result;
                image.classList.remove("d-none");
            });
        });

<?php else : ?>
    沒有使用者
<?php endif; ?>

<div class="col-lg-6">
                <div class="row g-3">
                    <?php foreach($rows as $image): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="ratio ratio-1x1">
                            <img class="object-fit-cover" src="/uploadmj/<?=$image["pic_name"]?>" alt="">
                        </div>
                        <h2 class="h4"><?=$image["course_name"]?></h2>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

        $on_datetime = isset($_GET["on_datetime"]) ? $_GET["on_datetime"] : '';
        $off_datetime = isset($_GET["off_datetime"]) ? $_GET["off_datetime"] : '';

<div class="d-flex align-items-center justify-content-between mb-3 border p-1 rounded">
        <form action="" method="get">
          <div class="d-flex justify-content-center gap-3 ">
            <div class="input-group">
              <label for="on_datetime" class="input-group-text  fw-semibold">開始時間</label>
              <input type="date" id="on_datetime" name="on_datetime" class="form-control">
            </div>
            <div class="input-group">
              <label for="off_datetime" class="input-group-text fw-semibold">結束時間</label>
              <input type="date" id="off_datetime" name="off_datetime" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
          </div>
        </form>

<div>
<?php if (isset($_GET["search"])) : ?>
<a class="btn btn-primary" href="users_course.php"><i class="fa-solid fa-arrow-left"></i></a>
<?php endif; ?>
</div>

//選date
else if (isset($_GET["on_datetime"]) && isset($_GET["off_datetime"])) {
    $on_datetime = $_GET["on_datetime"];
    $off_datetime = $_GET["off_datetime"];
    $sql = "SELECT * FROM course 
            WHERE course.on_datetime >= '$on_datetime' AND course.off_datetime <= '$off_datetime'
            ORDER BY id ASC";
    $pageTitle = "$on_datetime ~ $off_datetime 的搜尋結果";
} else if (isset($_GET["min"]) && isset($_GET["max"])) {
    $min = $_GET["min"];
    $max = $_GET["max"];
    $sql = "SELECT * FROM course 
            WHERE course.price >= '$min' AND course.price <= '$max'
            ORDER BY id ASC";
    $pageTitle = "$min ~ $max 元的搜尋結果";
} else if ((isset($_GET["min"]) && $_GET["min"] !== '') || (isset($_GET["max"]) && $_GET["max"] !== '')) {
    $minValue = isset($_GET["min"]) ? $_GET["min"] : 0;
    $maxValue = isset($_GET["max"]) ? $_GET["max"] : 99999;
    $sql = "SELECT * FROM course 
            WHERE course.price >= '$minValue' AND course.price <= '$maxValue'
            ORDER BY id ASC";
    $pageTitle = "價格在 $minValue ~ $maxValue 之間的搜尋結果";
} else if ((isset($_GET["on_datetime"]) && $_GET["on_datetime"] !== '') || (isset($_GET["off_datetime"]) && $_GET["off_datetime"] !== '')) {
    $on_datetime = isset($_GET["on_datetime"]) ? $_GET["on_datetime"] : '';
    $off_datetime = isset($_GET["off_datetime"]) ? $_GET["off_datetime"] : '';
    $sql = "SELECT * FROM course 
            WHERE course.on_datetime >= '$on_datetime' AND course.off_datetime <= '$off_datetime'
            ORDER BY id ASC";
    $pageTitle = "日期在 $on_datetime ~ $off_datetime 之間的搜尋結果";
}

//選$
else if (isset($_GET["min"]) && isset($_GET["max"])) {
    $min = $_GET["min"];
    $max = $_GET["max"];
    $sql = "SELECT * FROM course 
            WHERE course.price >= '$min' AND course.price <= '$max'
            ORDER BY id ASC";
    $pageTitle = "$min ~ $max 元的搜尋結果";
} else if (isset($_GET["on_datetime"]) && isset($_GET["off_datetime"])) {
    $on_datetime = $_GET["on_datetime"];
    $off_datetime = $_GET["off_datetime"];
    $sql = "SELECT * FROM course 
            WHERE course.on_datetime >= '$on_datetime' AND course.off_datetime <= '$off_datetime'
            ORDER BY id ASC";
    $pageTitle = "$on_datetime ~ $off_datetime 的搜尋結果";
}

// 同時選
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

<a href="user_course.php?id=<?= $course["id"] ?>" class="btn btn-secondary">返回</a>

</body>
</html>
