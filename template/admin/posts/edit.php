<?php

require_once(BASE_PATH . '/template/admin/layouts/header.php');


?>


<section class="pt-3 pb-1 mb-2 border-bottom">
    <h1 class="h5">Edit Article</h1>
</section>
<section class="row my-3">
    <section class="col-12">

        <form method="post" action="<?= url('admin/post/update/' . $posts['id']) ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title"  value="<?=$posts['title'] ?>">



            </div>

            <div class="form-group">
                <label for="cat_id">Category</label>
                <select name="cat_id" id="cat_id" class="form-control" required autofocus>

                    <?php foreach ($categories as $category){ ?>
                        <option value="<?= $category['id']?>" <?php if ($category['id'] == $posts['cat_id']) echo "selected"; ?>>
                            <?= $category['name'] ?>
                        </option>
                    <?php } ?>

                </select>
            </div>

            <div class="form-group">

                <hr/>
                <label for="image"></label>
                <img style="width: 80px;" src="<?=asset($posts['image'])?>" alt="">
                <input type="file" id="image" name="image" class="form-control-file" autofocus>
            </div>

            <div class="form-group">
                <label for="published_at">published at</label>
                <input type="text" class="form-control d-none" id="published_at" name="published_at" required autofocus>
                <input type="text" class="form-control" id="published_at_view" value="<?=$posts['published_at'] ?>" required autofocus >

            </div>

            <div class="form-group">
                <label for="summary">summary</label>
                <textarea class="form-control" id="summary" name="summary" placeholder="summary ..." rows="3"><?=$posts['summary'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="body">body</label>
                <textarea class="form-control" id="body" name="body" placeholder="body ..." rows="5"><?=$posts['body'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">update</button>
        </form>
    </section>
</section>





<?php

require_once(BASE_PATH . '/template/admin/layouts/footer.php');


?>

