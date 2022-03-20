<?php
$dname = 'OneBook';
$themeName = 'OneBook';
define('THEMEVERSION', '2.1.1');
$themeDir = get_stylesheet_directory_uri();
$blogUrl = get_bloginfo('url');
require_once('admin/ob-console.php');
require_once 'inc/whtml.php';

/**
 * 日志函数
 * @param $data
 */
function ob_logs($data)
{
    if (constant('WP_DEBUG') == true) {
        $file = constant('ABSPATH') . '/logs.txt';
        $contant = date('Y-m-d H:i:s') . ' [' . $_SERVER["REQUEST_URI"] . ']:' . $data . "\n";
        file_put_contents($file, $contant, FILE_APPEND);
    }
}

/**
 * 处理分页
 */
if (!function_exists('deal_paging')) :
    function deal_paging($max_page)
    {
        $p = 3;
        if (is_singular()) return;
        global $paged;
        if ($max_page == 1) return;
        echo '<div class="pagination"><ul>';
        if (empty($paged)) $paged = 1;
        echo '<li class="prev-page">';
        previous_posts_link('上一页');
        echo '</li>';
        if ($paged > $p + 1) echo p_link(1, '<li>第一页</li>');
        if ($paged > $p + 2) echo "<li><span>···</span></li>";
        for ($i = $paged - $p; $i <= $paged + $p; $i++) {
            $content = '';
            if ($i > 0 && $i <= $max_page) $content = $i == $paged ? "<li class=\"active\"><span>{$i}</span></li>" : p_link($i);
            echo $content;
        }
        if ($paged < $max_page - $p - 1) echo "<li><span> ... </span></li>" . p_link($max_page);
        echo '<li class="next-page">';
        next_posts_link('下一页');
        echo '</li>';
        echo '<li><span>共 ' . $max_page . ' 页</span></li>';
        echo '</ul></div>';
    }

    function p_link($i, $title = '')
    {
        if ($title == '') $title = "第 {$i} 页";
        return "<li><a href='" . esc_html(get_pagenum_link($i)) . "'>{$i}</a></li>";
    }
endif;

function deal_strimwidth($str, $start, $width, $trimmarker)
{
    $output = preg_replace('/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $start . '}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $width . '}).*/s', '\1', $str);
    return $output . $trimmarker;
}

function get_opt($e)
{
    return stripslashes(get_option($e));
}

if (get_opt('ob_remove_head_code')) {
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'wp_generator');
}
function google_remove_open_sans_from_wp_core()
{
    wp_deregister_style('open-sans');
    wp_register_style('open-sans', false);
    wp_enqueue_style('open-sans', '');
}

add_action('init', 'google_remove_open_sans_from_wp_core');
//获取所有站点分类id
function bing_show_category()
{
    $args = array(
        'type' => 'post',
        'child_of' => 0,
        'parent' => '0',
        'orderby' => 'ID',
        'order' => 'ASC',
        'hide_empty' => 0,
        'hierarchical' => 0,
        'exclude' => '1',
        'include' => '',
        'number' => '',
        'taxonomy' => 'category',
        'pad_counts' => false);
    $categorys = get_categories($args);
    $output = '<table><tbody><tr style="padding:5px;">';

    $num = 1;
    foreach ($categorys as $category) { //调用菜单
        $output .= '<td style="padding:5px;">' . $category->name . "&nbsp;&nbsp;[&nbsp" . $category->term_id . '&nbsp;]</td>';
        if ($num % 4 == 0) {
            $output .= '</tr><tr style="padding:5px;">';
        }
        $num += 1;
    }
    $output .= '</tr></tbody></table>';
    return $output;
}

//免插件去除Category
if (get_opt('ob_uncategroy_en')) {
    add_action('load-themes.php', 'no_category_base_refresh_rules');
    add_action('created_category', 'no_category_base_refresh_rules');
    add_action('edited_category', 'no_category_base_refresh_rules');
    add_action('delete_category', 'no_category_base_refresh_rules');

    function no_category_base_refresh_rules()
    {
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
    }

    // Remove category base
    add_action('init', 'no_category_base_permastruct');
    function no_category_base_permastruct()
    {
        global $wp_rewrite, $wp_version;
        if (version_compare($wp_version, '3.4', '<')) {
        } else {
            $wp_rewrite->extra_permastructs['category']['struct'] = '%category%';
        }
    }

    // Add our custom category rewrite rules
    add_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
    function no_category_base_rewrite_rules($category_rewrite)
    {
        //var_dump($category_rewrite); // For Debugging
        $category_rewrite = array();
        $categories = get_categories(array(
            'hide_empty' => false
        ));
        foreach ($categories as $category) {
            $category_nicename = $category->slug;
            if ($category->parent == $category->cat_ID) // recursive recursion
                $category->parent = 0;
            elseif ($category->parent != 0) $category_nicename = get_category_parents($category->parent, false, '/', true) . $category_nicename;
            $category_rewrite['(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
            $category_rewrite['(' . $category_nicename . ')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
            $category_rewrite['(' . $category_nicename . ')/?$'] = 'index.php?category_name=$matches[1]';
        }
        // Redirect support from Old Category Base
        global $wp_rewrite;
        $old_category_base = get_option('category_base') ? get_option('category_base') : 'category';
        $old_category_base = trim($old_category_base, '/');
        $category_rewrite[$old_category_base . '/(.*)$'] = 'index.php?category_redirect=$matches[1]';
        //var_dump($category_rewrite); // For Debugging
        return $category_rewrite;
    }

    // Add 'category_redirect' query variable
    add_filter('query_vars', 'no_category_base_query_vars');
    function no_category_base_query_vars($public_query_vars)
    {
        $public_query_vars[] = 'category_redirect';
        return $public_query_vars;
    }

    // Redirect if 'category_redirect' is set
    add_filter('request', 'no_category_base_request');
    function no_category_base_request($query_vars)
    {
        //print_r($query_vars); // For Debugging
        if (isset($query_vars['category_redirect'])) {
            $catlink = trailingslashit(get_option('home')) . user_trailingslashit($query_vars['category_redirect'], 'category');
            status_header(301);
            header("Location: $catlink");
            exit();
        }
        return $query_vars;
    }
}

//分类参数
function ashu_add_cat_field()
{
    global $themeDir;
    echo '<div class="form-field">';
    echo '<label for="cat_author" >小说作者</label>';
    echo '<input type="text" size="" value="" id="cat_author" name="cat_author"/>';
    echo '<p>请输入本小说作者</p>';
    echo '</div>';
    echo '<div class="form-field">';
    echo '<label for="cat_image" >小说图片</label>';
    echo '<input type="text" size="" value="" id="cat_image" name="cat_image" style="width:80%"/>';
    echo '<input type="button" class="button button-primary" onclick="insertImage_cat()" value="上传图片"/>';
    echo '<p>请输入本小说图片链接地址</p>';
    echo '<br/>';
    echo '<img id="img_cat_image" style="max-width:80%;" src="">';
    echo '</div>';
    echo '<div class="form-field">';
    echo '<label for="cat_novel_about" >作品相关</label>';
    echo '<textarea type="textarea" rows="5" cols="40" class="large-text code" value="" id="cat_novel_about" name="cat_novel_about"/></textarea>';
    echo '<p>请输入作品相关</p>';
    echo '</div>';
    echo '<div class="form-field">';
    echo '<label for="cat_other_novel" >本作者其他小说</label>';
    echo '<textarea type="textarea" rows="5" cols="40" class="large-text code" value="" id="cat_other_novel" name="cat_other_novel"/></textarea>';
    echo '<p>请输入本作者其他小说名称及链接（HTML格式，每个项目用dd标签包裹）</p>';
    echo '</div>';
    echo '<div class="form-field">';
    echo '<label for="cat_download_url" >小说TXT下载地址</label>';
    echo '<input type="text" size="" value="" id="cat_download_url" name="cat_download_url"/>';
    echo '<p>请输入本小说TXT文件下载地址</p>';
    echo '</div>';
    echo "<script type='application/javascript' src='$themeDir/js/jquery.min.js'></script>";
    echo "<script type='application/javascript' src='$themeDir/js/wnovel.js'></script>";
    wp_enqueue_media();//加载媒体中心
}

add_action('category_add_form_fields', 'ashu_add_cat_field', 10, 2);

//分类再编辑需要接受参数
function ashu_edit_cat_field($tag)
{
    global $themeDir;
    echo '<tr class="form-field"><th>小说作者</th><td><input type="text" size="40" value="' . get_option('cat_author_' . $tag->term_id) . '" id="cat_author" name="cat_author"/><p class="description">请输入本小说作者</p></td></tr>';
    echo '<tr><th>小说图片地址</th><td><input type="text" style="width:60%" size="40" value="' . get_option('cat_image_' . $tag->term_id) . '" id="cat_image" name="cat_image"/><input type="button" class="button button-primary" onclick="insertImage_cat()" value="上传图片"/>&nbsp;&nbsp;&nbsp;&nbsp;请输入本小说图片链接地址';
    echo '<p class="description"><img style="max-width:80%" id="img_cat_image" src="' . get_option('cat_image_' . $tag->term_id) . '"/></p>';
    echo '</td></tr>';
    echo '<tr class="form-field"><th>本小说的作品相关内容</th><td><textarea type="textarea" rows="5" cols="40" class="large-text code" value="" id="cat_novel_about" name="cat_novel_about"/>' . stripslashes(get_option('cat_novel_about_' . $tag->term_id)) . '</textarea><br/>请输入作品相关</td></tr>';
    echo '<tr class="form-field"><th>本作者其他小说</th><td><textarea type="textarea" rows="5" cols="40" class="large-text code" value="" id="cat_other_novel" name="cat_other_novel"/>' . stripslashes(get_option('cat_other_novel_' . $tag->term_id)) . '</textarea><br/>请输入本作者其他小说名称及链接（HTML格式，每个项目用dd标签包裹）</td></tr>';
    echo '<tr class="form-field"><th>小说TXT下载地址</th><td><input type="text" size="40" value="' . get_option('cat_download_url_' . $tag->term_id) . '" id="cat_download_url" name="cat_download_url"/>请输入本小说TXT文件下载地址</td></tr>';
    echo "<script type='application/javascript' src='$themeDir/js/jquery.min.js'></script>";
    echo "<script type='application/javascript' src='$themeDir/js/wnovel.js'></script>";
    wp_enqueue_media();//加载媒体中心
}

add_action('category_edit_form_fields', 'ashu_edit_cat_field', 10, 2);

/**************保存数据接受的参数为分类ID*****************/
function ashu_taxonomy_metadata($term_id)
{
    if (isset($_POST['cat_author'])) {
        //判断权限--可改
        if (!current_user_can('manage_categories')) {
            return $term_id;
        }

        $data = $_POST['cat_author'];
        $key = 'cat_author_' . $term_id; //选项名为 ashu_cat_value_1 类型
        update_option($key, $data); //更新选项值
    }
    if (isset($_POST['cat_image'])) {
        //判断权限--可改
        if (!current_user_can('manage_categories')) {
            return $term_id;
        }

        $data = $_POST['cat_image'];
        $key = 'cat_image_' . $term_id; //选项名为 ashu_cat_value_1 类型
        update_option($key, $data); //更新选项值
    }
    if (isset($_POST['cat_novel_about'])) {
        //判断权限--可改
        if (!current_user_can('manage_categories')) {
            return $term_id;
        }

        $data = $_POST['cat_novel_about'];
        $key = 'cat_novel_about_' . $term_id; //选项名为 ashu_cat_value_1 类型
        update_option($key, $data); //更新选项值
    }
    if (isset($_POST['cat_other_novel'])) {
        //判断权限--可改
        if (!current_user_can('manage_categories')) {
            return $term_id;
        }

        $data = $_POST['cat_other_novel'];
        $key = 'cat_other_novel_' . $term_id; //选项名为 ashu_cat_value_1 类型
        update_option($key, $data); //更新选项值
    }
    if (isset($_POST['cat_download_url'])) {
        //判断权限--可改
        if (!current_user_can('manage_categories')) {
            return $term_id;
        }

        $data = $_POST['cat_download_url'];
        $key = 'cat_download_url_' . $term_id; //选项名为 ashu_cat_value_1 类型
        update_option($key, $data); //更新选项值
    }
}

/*******虽然要两个钩子，但是我们可以两个钩子使用同一个函数********/
add_action('created_category', 'ashu_taxonomy_metadata', 10, 1);
add_action('edited_category', 'ashu_taxonomy_metadata', 10, 1);
//分类参数

//隐藏admin Bar
add_filter('show_admin_bar', 'hide_admin_bar');
function hide_admin_bar($flag)
{
    return false;
}


//注册菜单
register_nav_menus(array(
    'header_menu' => __('顶部全站菜单')
));

//增加后台菜单

/*获取根分类的id*/
function get_category_root_id($cat)
{
    $this_category = get_category($cat); // 取得当前分类
    while ($this_category->category_parent) // 若当前分类有上级分类时，循环
    {
        $this_category = get_category($this_category->category_parent); // 将当前分类设为上级分类（往上爬）
    }
    return $this_category->term_id; // 返回根分类的id号
}

/*获取根分类的id*/
function get_root_category($cat)
{
    $this_category = get_category($cat->term_id); // 取得当前分类
    while ($this_category->category_parent) // 若当前分类有上级分类时，循环
    {
        $this_category = get_category($this_category->category_parent); // 将当前分类设为上级分类（往上爬）
    }
    return $this_category; // 返回根分类的id号
}

//去除评论中无用字段
add_filter('comment_form_default_fields', 'unset_url_field');
function unset_url_field($fields)
{
    if (isset($fields['url']))
        unset($fields['url']);
    if (isset($fields['email']))
        unset($fields['email']);
    return $fields;
}

function change_post_menu_label()
{
    global $menu;
    global $submenu;
    $menu[5][0] = '小说管理';
    $submenu['edit.php'][5][0] = '小说章节管理';
    $submenu['edit.php'][10][0] = '新增小说章节';
    $submenu['edit.php'][15][0] = '小说管理'; // Change name for categories
    $submenu['edit.php'][16][0] = ''; // Change name for tags
    echo '';
}

function change_post_object_label()
{
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Contacts';
    $labels->singular_name = 'Contact';
    $labels->add_new = 'Add Contact';
    $labels->add_new_item = 'Add Contact';
    $labels->edit_item = 'Edit Contacts';
    $labels->new_item = 'Contact';
    $labels->view_item = 'View Contact';
    $labels->search_items = 'Search Contacts';
    $labels->not_found = 'No Contacts found';
    $labels->not_found_in_trash = 'No Contacts found in Trash';
}

//add_action( 'init', 'change_post_object_label' );
add_action('admin_menu', 'change_post_menu_label');

/**
 * 汉字转Unicode编码，只转汉字
 * @param string $str 原始汉字的字符串
 * @param string $encoding 原始汉字的编码
 * @param bool|boot $ishex 是否为十六进制表示（支持十六进制和十进制）
 * @param string $prefix 编码后的前缀
 * @param string $postfix 编码后的后缀
 * @return string
 */
function unicode_encode($str, $encoding = 'UTF-8', $ishex = false, $prefix = '&#', $postfix = ';') {
    $str = iconv($encoding, 'UCS-2', $str);
    $arrstr = str_split($str, 2);
    $unistr = '';
    for($i = 0, $len = count($arrstr); $i < $len; $i++) {
        $dec = $ishex ? bin2hex($arrstr[$i]) : hexdec(bin2hex($arrstr[$i]));
        $unistr .= $prefix . $dec . $postfix;
    }
    return $unistr;
}


/**
 * Unicode编码转汉字
 * @param $unistr
 * @param string $encoding
 * @param bool|boot $ishex 是否为十六进制表示（支持十六进制和十进制）
 * @param string $prefix 编码后的前缀
 * @param string $postfix 编码后的后缀
 * @return string
 * @internal param string $str Unicode编码的字符串
 * @internal param string $decoding 原始汉字的编码
 */
function unicode_decode($unistr, $encoding = 'UTF-8', $ishex = false, $prefix = '&#', $postfix = ';')
{
    $arruni = explode($prefix, $unistr);
    $unistr = '';
    for ($i = 1, $len = count($arruni); $i < $len; $i++) {
        if (strlen($postfix) > 0) {
            $arruni[$i] = substr($arruni[$i], 0, strlen($arruni[$i]) - strlen($postfix));
        }
        $temp = $ishex ? hexdec($arruni[$i]) : intval($arruni[$i]);
        $unistr .= ($temp < 256) ? chr(0) . chr($temp) : chr($temp / 256) . chr($temp % 256);
    }
    return iconv('UCS-2', $encoding, $unistr);
}