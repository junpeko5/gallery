<?php
include(dirname(__FILE__) . "/includes/header.php");

$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

$items_per_page = 4;

$items_total_count = Photo::count_all();
$paginate = new Paginate($page, $items_per_page, $items_total_count);

$sql = "
    SELECT
        *
    FROM
        photos
    LIMIT {$items_per_page} 
    OFFSET {$paginate->offset()}
";
$photos = Photo::find_by_query($sql);

?>
<div class="row">
    <!-- Blog Entries Column -->
    <div class="col-md-12">
        <div class="thumbnails row">
        <?php foreach ($photos as $photo) : ?>
            <div class="col-xs-6 col-md-3">
                <a class="thumbnail" href="photo.php?id=<?php echo $photo->id; ?>">
                    <img class="img-responsive home_page_photo" src="admin/<?php echo $photo->picture_path(); ?>" alt="">
                </a>
            </div>
        <?php endforeach; ?>
        </div>
        <div class="row">
            <ul class="pager">
                <?php if ($paginate->page_total() > 1) : ?>
                    <?php if ($paginate->has_next()) : ?>
                        <li class="next"><a href="index.php?page=<?php echo $paginate->next(); ?>">Next</a></li>
                    <?php endif; ?>
                <?php endif; ?>

                <li class="previous"><a href="">Previous</a></li>
            </ul>
        </div>
    </div>
</div>
<?php include("includes/footer.php"); ?>