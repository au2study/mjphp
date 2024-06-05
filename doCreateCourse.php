<?php
require_once("../db_connect_mj.php");

if(!isset($_POST["course_name"])){
    die("請循正常管道進入此頁");
}

$course_name=$_POST["course_name"];
$price=$_POST["price"];
$on_datetime=$_POST["on_datetime"];
$off_datetime=$_POST["off_datetime"];
$file=$_FILES["file"];

$sqlCheckCourse="SELECT * FROM course WHERE course_name = '$course_name'";
$resultCheck=$conn->query($sqlCheckCourse);
if($resultCheck->num_rows>0){
    echo "此課程已經有人註冊";
    exit;
}

$now=date('Y-m-d H:i:s');
$sql="INSERT INTO course (course_name, price, on_datetime, off_date, file, created_at) VALUES ('$course_name', '$price', '$on_datetime', '$off_datetime', '$file', '$now'";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "新資料輸入成功, id 為 $last_id";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header("location: course-list.php");