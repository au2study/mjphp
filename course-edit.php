<?php

if (!isset($_GET["id"])) {
    $id = 1;
} else {
    $id = $_GET["id"];
}

require_once("../db_connect_mj.php");

$sql = "SELECT * FROM course WHERE id = $id AND valid = 1";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($result->num_rows > 0) {
    $courseExit = true;
    $title = $row["course_name"];
} else {
    $courseExit = false;
    $title = "課程不存在";
}

?>

<!doctype html>
<html lang="en">

<head>
    <title><?= $title ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php include("../css_mj.php") ?>
</head>

<body>

    <div class="container">
        <h1 class="my-4">編輯課程</h1>
        <div class="py-2">
            <a class="btn btn-primary" href="course-list.php?id=<?= $id ?>"><i class="fa-solid fa-arrow-left"></i>回課程列表</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <?php if ($courseExit) : ?>
                    <form action="doUpdateCourse.php" method="post">
                        <table class="table table-bordered">
                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                            <tr>
                                <th>id</th>
                                <td>
                                    <?= $row["id"] ?>
                                </td>
                            </tr>
                            <tr>
                                <th>course_name</th>
                                <td>
                                    <input type="text" class="form-control" name="course_name" value="<?= $row["course_name"] ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>course_category_id</th>
                                <td>
                                    <select id="course_category_id" name="course_category_id" value="<?= $row["course_category_id"] ?> class=" form-select" required>
                                        <option value="1">1: Gomoku</option>
                                        <option value="2">2: Mahjong</option>
                                        <option value="3">3: Go</option>
                                        <option value="4">4: Chess</option>
                                        <option value="5">5: Shogi</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>images</th>
                                <td>
                                    <input type="file" class="form-control" name="images" value="<?= $row["images"] ?>" accept="image/*" required>
                                </td>
                            </tr>
                            <tr>
                                <th>file</th>
                                <td>
                                    <input type="file" class="form-control" name="file" value="<?= $row["file"] ?>" accept="video/*" required>
                                </td>
                            </tr>
                            <tr>
                                <th>price</th>
                                <td>
                                    <input type="text" class="form-control" name="price" value="<?= $row["price"] ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>on_datetime</th>
                                <td>
                                    <input type="date" class="form-control" name="on_datetime" value="<?= $row["on_datetime"] ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>off_datetime</th>
                                <td>
                                    <input type="date" class="form-control" name="off_datetime" value="<?= $row["off_datetime"] ?>">
                                </td>
                            </tr>

                        </table>
                    <?php else : ?>
                        <h1>課程不存在</h1>
                    <?php endif; ?>
                    <button class="btn btn-primary" type="submit">送出</button>
                    <a class="btn btn-secondary" href="course-detail.php">back <i class="fa-solid fa-arrow-left"></i></a>
                    </form>
            </div>
        </div>

    </div>


</body>

</html>