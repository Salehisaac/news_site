<div class="col-lg-4">
    <div class="sidebars-area">
        <div class="single-sidebar-widget editors-pick-widget">
            <h6 class="title">انتخاب سردبیر</h6>
            <?php if (isset($topSelectedPostside[0])) { ?>
            <div class="editors-pick-post">
                <div class="feature-img-wrap relative">
                    <div class="feature-img relative">
                        <div class="overlay overlay-bg"></div>
                        <img class="img-fluid" src="<?= asset($topSelectedPostside[0]['image']) ?>" alt="">
                    </div>
                    <ul class="tags">
                        <li><a href="<?= url('show-category/' . $topSelectedPostside[0]['cat_id'] )  ?>"><?= ($topSelectedPostside[0]['category']) ?></a></li>
                    </ul>
                </div>
                <div class="details">
                    <a href="<?= url('show-post/' . $topSelectedPostside[0]['id']) ?>">
                        <h4 class="mt-20"><?= ($topSelectedPostside[0]['title']) ?></h4>
                    </a>
                    <ul class="meta">
                        <li><a href="#"><span class="lnr lnr-user"></span><?= ($topSelectedPostside[0]['username']) ?></a></li>
                        <li><a href="#"><?= jalaliDate($topSelectedPostside[0]['created_at']) ?><span class="lnr lnr-calendar-full"></span></a></li>
                        <li><a href="#"><?= ($topSelectedPostside[0]['comments_count']) ?><span class="lnr lnr-bubble"></span></a></li>
                    </ul>

                </div>
            </div>
            <?php } ?>
        </div>
        <?php if (!empty($sidebarBanner)) {  ?>
        <div class="single-sidebar-widget ads-widget">
            <a href="<?= $sidebarBanner['url']  ?>" >
            <img class="img-fluid" src="<?= asset($sidebarBanner['image']) ?>" alt="" width="120" height="80">
        </div>
        <?php } ?>

        <div class="single-sidebar-widget most-popular-widget">
            <h6 class="title">پر بحث ترین ها</h6>
            <?php foreach($mostCommentPosts as $mostCommentPost) { ?>
                <div class="single-list flex-row d-flex">
                    <div class="thumb">
                        <img src="<?= asset($mostCommentPost['image']) ?>" alt="" width="120" height="80">
                    </div>
                    <div class="details">
                        <a href="<?= url('show-post/' . $mostCommentPost['id']) ?>">
                            <h6><?= $mostCommentPost['title'] ?></h6>
                        </a>
                        <ul class="meta">
                            <li><a href="#"><?= jalaliDate($mostCommentPost['created_at']) ?><span class="lnr lnr-calendar-full"></span></a></li>
                            <li><a href="#"><?= $mostCommentPost['comments_count'] ?><span class="lnr lnr-bubble"></span></a></li>
                        </ul>
                    </div>
                </div>
            <?php } ?>


        </div>

    </div>
</div>
