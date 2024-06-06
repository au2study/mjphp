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


<div>
<?php if (isset($_GET["search"])) : ?>
<a class="btn btn-primary" href="users_course.php"><i class="fa-solid fa-arrow-left"></i></a>
<?php endif; ?>
</div>

<a href="user_course.php?id=<?= $course["id"] ?>" class="btn btn-secondary">返回</a>

<?php
require_once("../db_connect_mj.php");
$sql = "SELECT * FROM images ORDER BY id DESC";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
?>

$image = $_FILES["image"];
    $imageName = $image["name"];

 if (is_uploaded_file($image["tmp_name"])) {
        if (!file_exists("../images/rent_product/$last_id")) {
            mkdir("../images/rent_product/$last_id");
        }
        $file = "../images/rent_product/$last_id/" . basename($imageName);
        }

<!--         
        if (move_uploaded_file($image["tmp_name"], $file)) {
            // echo "上傳成功";
            // unset($_SESSION["errorMsg"]);
            // $sqlImg = "UPDATE rent_product SET img = '$imageName' WHERE id = $last_id";
            // $sqlImgs = "INSERT INTO rent_images (rent_product_id, url) values ('$last_id', '$imageName')";
            // if ($conn->query($sqlImgs) === TRUE) {
            // } else {
            //     echo "Error: " . $sqlImgs . "<br>" . $conn->error;
            // }

            // if ($conn->query($sqlImg) === TRUE) {
            // } else {
            //     echo "Error: " . $sqlImg . "<br>" . $conn->error;
            // }
        } else {
            echo "上傳失敗";
        }
    } -->

$now=date("Y-m-d);
<?php if($off_datetime < $now) : ?>
    <span class="text-danger">下架中</span>
<?php endif; ?>


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

value="<?= $row["course_category_id"] ?> 
value="<?= $row["images"] ?>" accept="image/*" required
value="<?= $row["file"] ?>" accept="video/*


</body>
</html>
