<style>
    .cateHover.hover{
        .li{
            background-color: #fff;
            transition: .3s;
        }
    }
</style>
<ul class="nav nav-underline mb-3 cateHover">
    <li class="nav-item">
        <a class="nav-link 
        <?php
        if (!isset($_GET["category"])) echo "active";
        ?>" href="course-list.php">全部</a>
    </li>
    <?php foreach ($cateRows as $course_category) : ?>
        <li class="nav-item">
            <a class="nav-link 
            <?php
            if (isset($_GET["category"]) &&  $_GET["category"]  == $course_category["id"]) echo "active";
            ?>" href="course-list.php?page=1&category=<?= $course_category["id"] ?>"><?= $course_category["name"] ?></a>
        </li>
    <?php endforeach; ?>
</ul>