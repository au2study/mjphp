<ul class="nav nav-underline mb-3">
    <li class="nav-item">
        <a class="nav-link 
        <?php
        if (!isset($_GET["course_category"])) echo "active";
        ?>" href="users_course.php">全部</a>
    </li>
    <?php foreach ($cateRows as $course_category) : ?>
        <li class="nav-item">
            <a class="nav-link 
            <?php
            if (isset($_GET["course_category"]) && $category_id == $course_category["id"]) echo "active";
            ?>" href="users_course.php?category=<?= $course_category["id"] ?>"><?= $course_category["category_name"] ?></a>
        </li>
    <?php endforeach; ?>
</ul>