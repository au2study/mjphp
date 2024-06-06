<?php
require_once("../db_connect_mj.php");

if (!isset($_POST["course_name"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$id = $_POST["id"];
$course_name = $_POST["course_name"];
$price = $_POST["price"];
$on_datetime = $_POST["on_datetime"];
$off_datetime = $_POST["off_datetime"];
$images = $_POST["images"];
$file = $_POST["file"];
$course_category_id = $_POST["course_category_id"];


$sql = "UPDATE course SET course_name='$course_name', images='$images', file='$file', course_category_id='$course_category_id', price='$price', on_datetime='$on_datetime', off_datetime='$off_datetime' WHERE id=$id";

// echo $sql;

if ($conn->query($sql) === TRUE) {
    echo "更新成功";
    header("location: course-list.php");
} else {
    echo "更新資料錯誤: " . $conn->error;
}
// header("location: course-edit.php?id=".$id);

$conn->close();
