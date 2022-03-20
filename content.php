<?php
$cat_id = $_SESSION['cat_id'];
$thiscat = $_SESSION['thiscat'];
$catUrl = get_category_link($thiscat->term_id);
$cats_id_arr = get_term_children($cat_id, 'category');
$themeUrl = get_template_directory_uri();
$new_list_num = get_opt('new_list_num');
$blogUrl = get_bloginfo('url');
$blogName = get_bloginfo('name');
$ob_ad_chapter_top = '';
if (wp_is_mobile()) {
    $ob_ad_chapter_top = get_opt('ob_ad_chapter_top-wap');
} else {
    $ob_ad_chapter_top = get_opt('ob_ad_chapter_top-PC');
}
$ob_ad_chapter_bottom = '';
if (wp_is_mobile()) {
    $ob_ad_chapter_bottom = get_opt('ob_ad_chapter_bottom-wap');
} else {
    $ob_ad_chapter_bottom = get_opt('ob_ad_chapter_bottom-PC');
}
?>
<?php if (is_category()) { ?>
	<div class="container crumbs">
		<div class="fl"><span>当前位置：</span>
			<a href="<?= $blogUrl ?>" title="<?= $blogName ?>"><?= $blogName ?></a> &gt;
			<a href="<?= $catUrl ?>" title="<?= $thiscat->name ?>"><?= $thiscat->name ?>全文阅读</a>
		</div>
	</div>
<?php } ?>
	<div class="clear"></div>
	<div class="container">
		<div class="inner">
			<div class="bookinfo">
				<div class="btitle">
					<h1><a href="<?= $catUrl ?>" target="_blank"><?= $thiscat->name ?></a></h1>
					<em>作者：<?= get_opt("cat_author_" . $thiscat->term_id) ?></em>
					<div class="hidden-xs hidden-sm hidden-md">
						<style>
                            #share {
                                float: right;
                            }

                            #share a {
                                width: 181px;
                                height: 50px;
                            }

                            #share a.bds_bdhome {
                                background: url('<?= $themeUrl ?>/img/baiduindex.png') no-repeat;
                            }
						</style>
						<div id="share">
							<div class="bdsharebuttonbox"><a href="#" class="bds_bdhome" data-cmd="bdhome"
							                                 title="分享到百度新首页"></a></div>
						</div>
					</div>
					<p class="stats">
								<span class="fl"><b>最新章节：</b><?php query_posts("posts_per_page=1&cat=" . $cat_id) ?>
                                    <?php while (have_posts()) :
                                    the_post(); ?>
                                    <a href="<?php the_permalink() ?>" target="_blank" title="<?php the_title(); ?>">
                            <?php the_title(); ?>
                    </a></span></p>
					<div class="status"><font color="#999999">更新时间：</font><?php echo the_time('Y年m月d日 H:i'); ?></div>
                    <?php endwhile;
                    wp_reset_query(); ?>
					<div class="clear"></div>
					<div class="intro">
                        <?php if (get_opt("cat_image_" . $thiscat->term_id)) { ?>
							<p class="img-p">
								<a class="img-a" href="<?= $catUrl ?>">
									<img class="img-img" alt="<?= $thiscat->name ?>"
									     src="<?= get_opt("cat_image_" . $thiscat->term_id) ?>">
								</a>
							</p>
                        <?php } ?>
						<span class="intro-p">内容简介：<?= wpautop($thiscat->description) ?>
                            <div class="clear"></div></span>
					</div>
					<div class="clear"></div>
                    <?php if (get_opt('ob_recommend')) { ?>
						<div class="recommend">
							重磅推荐：
                            <?= get_opt('ob_recommend') ?>
						</div>
                    <?php } ?>
				</div>
                <?php if (get_opt("cat_other_novel_" . $cat_id)) { ?>
					<dl class="chapterlist">
						<!--最新列表-->
						<dt class="title"><?= get_opt("cat_author_" . $cat_id) ?> 大神的其他作品</dt>
                        <?= get_opt("cat_other_novel_" . $cat_id) ?>
					</dl>
                <?php } ?>
                <?= $ob_ad_chapter_top ?>
				<dl class="chapterlist">
					<!--最新列表-->
					<dt class="title"><?= $thiscat->name ?> 最新章节列表</dt>
                    <?php
                    $args = array(
                        'numberposts' => $new_list_num,
                        'offset' => 0,
                        'category' => $thiscat->term_id,
                        'orderby' => 'post_date',
                        'order' => 'DESC',
                        'post_status' => 'publish');
                    $postList = get_posts($args);
                    foreach ($postList as $post) {
                        $postUrl = get_permalink($post->ID);
                        $postTitle = $post->post_title;
                        echo "<dd><a href=\"$postUrl\" title=\"$postTitle\">$postTitle</a></dd>";
                    }
                    /**判断是否有自定义章节
                     * 如果有，则优先显示自定义章节
                     * 如果没有，则显示正文章节
                     * 如果有子分类，但没有放入子分类的文章，则显示在最后的正文章节中
                     */
                    //首先处理分页
                    $offset = 0;
                    $numberPosts = -1;
                    $totalPage = 1;
                    if (get_opt('ob_post_paged_on')) {
                        global $paged;
                        $total = $thiscat->count;
                        $numberPosts = get_opt('ob_post_paged_num');
                        $totalPage = ceil($total / $numberPosts);
                        if ($paged) {
                            $offset = ($paged - 1) * $numberPosts;
                        }
                    }

                    //判断文章列表页排序规则
                    $ob_post_list_order = get_opt('ob_post_list_order');

                    //仿采集字段
                    $antiSP = date('Y-m-d-H:i:s');

                    if (count($cats_id_arr) != 0) {
                        foreach ($cats_id_arr as $childCatId) {
                            $childCat = get_category($childCatId);
                            echo "<dt class=\"dt-title-$antiSP title\">$childCat->name</dt>";
                            $args = array(
                                'numberposts' => $numberPosts,
                                'offset' => $offset,
                                'category' => $childCatId,
                                'orderby' => 'post_date',
                                'order' => $ob_post_list_order,
                                'post_status' => 'publish');
                            $postList = get_posts($args);
                            foreach ($postList as $post) {
                                $postUrl = get_permalink($post->ID);
                                $postTitle = $post->post_title;
                                echo "<dd><a href=\"$postUrl\" title=\"$postTitle\">$postTitle</a></dd>";
                            }
                        }

                    } else {
                        $args = array(
                            'numberposts' => $numberPosts,
                            'offset' => $offset,
                            'category' => $thiscat->term_id,
                            'orderby' => 'post_date',
                            'order' => $ob_post_list_order,
                            'post_status' => 'publish');
                        $postList = get_posts($args);
                        echo '<dt class="dt-title-' . $antiSP . ' title">正文</dt>';
                        foreach ($postList as $post) {
                            $postUrl = get_permalink($post->ID);
                            $postTitle = $post->post_title;
                            echo "<dd><a href=\"$postUrl\" title=\"$postTitle\">$postTitle</a></dd>";
                        }
                    }
                    ?>
				</dl>
				<div class="clear"></div>
                <?php
                if (get_opt('ob_post_paged_on')) {
                    deal_paging($totalPage);
                }
                ?>
                <?= $ob_ad_chapter_bottom ?>
			</div>
		</div>
	</div>
<?php
if (get_opt('ob_popcat_on')) {
    require_once 'popcate.php';
}
if (get_opt('ob_flink')) {
    require_once 'flink.php';
}
