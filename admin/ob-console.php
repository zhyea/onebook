<?php
require_once 'ob-option.php';

function ob_admin_page()
{
    global $themeName, $options;
    if ($_GET['page'] == basename(__FILE__)) {
        if ('update' == $_REQUEST['action']) {
            foreach ($options as $op) {
                if (isset($_REQUEST[$op['id']])) {
                    update_option($op['id'], $_REQUEST[$op['id']]);
                } else {
                    delete_option($op['id']);
                }
            }
            update_option('ob_options_setup', true);
            header('Location: admin.php?page=ob-console.php&update=true');
            die;
        } else {
            if ('reset' == $_REQUEST['action']) {
                foreach ($options as $op) {
                    delete_option($op['id']);
                }
                delete_option('ob_options_setup');
                header('Location: themes.php?page=ob-console.php&reset=true');
                die;
            }
        }
    }
    add_menu_page($themeName . '主题选项', $themeName, 'edit_themes', basename(__FILE__), 'ob_options_page', '', 26);
    add_submenu_page('ob-console.php', $themeName . '主题配置', '主题配置', 'edit_themes', basename(__FILE__), 'ob_options_page');
}

add_action('admin_menu', 'ob_admin_page');

function ob_options_page()
{
    global $themeName, $options, $notice;
    if ($_REQUEST['update']) {
        echo '<div class="updated"><p><strong>设置已保存。</strong></p></div>';
    }
    if ($_REQUEST['reset']) {
        echo '<div class="updated"><p><strong>设置已重置。</strong></p></div>';
    }
    echo '    <div class="wrap d_wrap" id="ob_theme_option_div">
        ';
    ?>
	<h2><?php
    echo $themeName;
    echo '主题选项</h2><input placeholder="筛选主题选项…" type="search" id="theme-options-search"/>
        <div class="d_formwrap">
            <div class="d_alter_w">
                <div class="d_alter">
                    ';
    echo '                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <form method="post">
                <h2 id="nav_tap_wrapper">
                    ';
    $cfg_count = 0;
    foreach ($options as $opt) {
        if ($opt['type'] == 'panelstart') {
            echo '<a href="#' . $opt['id'] . '" id="' . $opt['id'] . '_a" class="nav-tab' . ($cfg_count == 0 ? ' nav-tab-active' : '') . '">' . $opt['title'] . '</a>';
        }
        $cfg_count++;
    }
    echo '                </h2>
                ';
    $cfg_count = 0;
    $opt_setup = get_option('ob_options_setup');
    foreach ($options as $opt) {
        switch ($opt['type']) {
            case 'panelstart':
                echo '<div class="panel" id="' . $opt['id'] . '" ' . ($cfg_count == 0 ? ' style="display:block"' : '') . '><table class="form-table">';
                $cfg_count++;
                break;
            case 'panelend':
                echo '</table></div>';
                break;
            case 'subtitle':
                echo '<tr><th colspan="2"><h3>' . $opt['title'] . '</h3></th></tr>';
                break;
            case 'text':
                echo '                            <tr>
                                <th><label for="';
                echo $opt['id'];
                ?>"><?php
                echo $opt['name'];
                echo '</label></th>
                                <td>
                                    <label>
                                        <input name="';
                echo $opt['id'];
                echo '" class="regular-text"
                                               id="';
                echo $opt['id'];
                echo '" type=\'text\'
                                               value="';
                if ($opt_setup || get_option($opt['id']) != '') {
                    echo stripslashes(get_option($opt['id']));
                } else {
                    echo $opt['std'];
                }
                echo '"/>
                                        </br>
                                        <span class="description">';
                echo $opt['desc'];
                echo '</span>
                                    </label>
                                </td>
                            </tr>
                            ';
                break;
            case 'number':
                echo '                            <tr>
                                <th><label for="';
                echo $opt['id'];
                ?>"><?php
                echo $opt['name'];
                echo '</label></th>
                                <td>
                                    <label>
                                        <input name="';
                echo $opt['id'];
                echo '" class="small-text"
                                               id="';
                echo $opt['id'];
                echo '" type="number"
                                               value="';
                if ($opt_setup || get_option($opt['id']) != '') {
                    echo get_option($opt['id']);
                } else {
                    echo $opt['std'];
                }
                echo '"/>
                                        <span class="description">';
                echo $opt['desc'];
                echo '</span>
                                    </label>
                                </td>
                            </tr>
                            ';
                break;
            case 'smalltext':
                echo '                            <tr>
                                <th><label for="';
                echo $opt['id'];
                ?>"><?php
                echo $opt['name'];
                echo '</label></th>
                                <td>
                                    <label>
                                        <input name="';
                echo $opt['id'];
                echo '" class="small-text"
                                               id="';
                echo $opt['id'];
                echo '" type="text"
                                               value="';
                if ($opt_setup || get_option($opt['id']) != '') {
                    echo get_option($opt['id']);
                } else {
                    echo $opt['std'];
                }
                echo '"/>
                                        <span class="description">';
                echo $opt['desc'];
                echo '</span>
                                    </label>
                                </td>
                            </tr>
                            ';
                break;
            case 'password':
                echo '                            <tr>
                                <th><label for="';
                echo $opt['id'];
                ?>"><?php
                echo $opt['name'];
                echo '</label></th>
                                <td>
                                    <label>
                                        <input name="';
                echo $opt['id'];
                echo '" class="regular-text"
                                               id="';
                echo $opt['id'];
                echo '" type="password"
                                               value="';
                if ($opt_setup || get_option($opt['id']) != '') {
                    echo get_option($opt['id']);
                } else {
                    echo $opt['std'];
                }
                echo '"/>
                                        <span class="description">';
                echo $opt['desc'];
                echo '</span>
                                    </label>
                                </td>
                            </tr>
                            ';
                break;
            case 'textarea':
                echo '                            <tr>
                                <th>';
                echo $opt['name'];
                echo '</th>
                                <td>
                                    <p><label for="';
                echo $opt['id'];
                ?>"><?php
                echo $opt['desc'];
                echo '</label>
                                    </p>
                                    <p><textarea name="';
                echo $opt['id'];
                ?>" id="<?php
                echo $opt['id'];
                echo '"
                                                 rows="5" cols="50"
                                                 class="large-text code">';
                if ($opt_setup || get_option($opt['id']) != '') {
                    echo stripslashes(get_option($opt['id']));
                } else {
                    echo $opt['std'];
                }
                echo '</textarea></p>
                                </td>
                            </tr>
                            ';
                break;
            case 'select':
                echo '                            <tr>
                                <th><label for="';
                echo $opt['id'];
                ?>"><?php
                echo $opt['name'];
                echo '</label></th>
                                <td>
                                    <label>
                                        <select name="';
                echo $opt['id'];
                ?>" id="<?php
                echo $opt['id'];
                echo '">
                                            ';
                foreach ($opt['options'] as $sub_opt) {
                    echo '                                                <option value="';
                    echo $sub_opt;
                    ?>" <?php
                    selected(get_option($opt['id']), $sub_opt);
                    echo '>
                                                    ';
                    echo $sub_opt;
                    echo '                                                </option>
                                            ';
                }
                echo '                                        </select>
                                        <span class="description">';
                echo $opt['desc'];
                echo '</span>
                                    </label>
                                </td>
                            </tr>
                            ';
                break;
            case 'radio':
                echo '                            <tr>
                                <th><label for="';
                echo $opt['id'];
                ?>"><?php
                echo $opt['name'];
                echo '</label></th>
                                <td>
                                    ';
                foreach ($opt['options'] as $sub_op_k => $sub_op_v) {
                    echo '                                        <label>
                                            <input type="radio" name="';
                    echo $opt['id'];
                    echo '"
                                                   id="';
                    echo $opt['id'];
                    echo '"
                                                   value="';
                    echo $sub_op_v;
                    ?>" <?php
                    checked(get_option($opt['id']), $sub_op_v);
                    echo '>
                                            ';
                    echo $sub_op_k;
                    echo '                                        </label>
                                    ';
                }
                echo '                                    <p><span class="description">';
                echo $opt['desc'];
                echo '</span></p>
                                </td>
                            </tr>
                            ';
                break;
            case 'checkbox':
                echo '                            <tr>
                                <th>';
                echo $opt['name'];
                echo '</th>
                                <td>
                                    <label>
                                        <input type=\'checkbox\' name="';
                echo $opt['id'];
                echo '"
                                               id="';
                echo $opt['id'];
                echo '"
                                               value="1" ';
                echo checked(get_option($opt['id']), 1);
                echo ' />
                                        <span>';
                echo $opt['desc'];
                echo '</span>
                                    </label>
                                </td>
                            </tr>
                            ';
                break;
            case 'checkboxs':
                echo '                            <tr>
                                <th>';
                echo $opt['name'];
                echo '</th>
                                <td>
                                    ';
                $opt_id = get_option($opt['id']);
                if (!is_array($opt_id)) {
                    $opt_id = array();
                }
                foreach ($opt['options'] as $sub_opt_k => $sub_opt_v) {
                    echo '                                        <label>
                                            <input type="checkbox" name="';
                    echo $opt['id'];
                    echo '[]"
                                                   id="';
                    echo $opt['id'];
                    echo '[]"
                                                   value="';
                    echo $sub_opt_k;
                    ?>" <?php
                    checked(in_array($sub_opt_k, $opt_id), true);
                    echo '>
                                            ';
                    echo $sub_opt_v;
                    echo '                                        </label>
                                    ';
                }
                echo '                                    <span class="description">';
                echo $opt['desc'];
                echo '</span>
                                </td>
                            </tr>
                            ';
                break;
            case 'images':
                echo '                            <tr>
                                <th><label for="';
                echo $opt['id'];
                ?>"><?php
                echo $opt['name'];
                echo '</label></th>
                                <td>
                                    <label>
                                        <input name="';
                echo $opt['id'];
                echo '" class="regular-text"
                                               id="';
                echo $opt['id'];
                echo '" type=\'text\' style="width: 80%;"
                                               value="';
                if ($opt_setup || get_option($opt['id']) != '') {
                    echo stripslashes(get_option($opt['id']));
                } else {
                    echo $opt['std'];
                }
                echo '"/>
                                        <input type="button" class="button button-primary"
                                               onclick="insertImage(\'';
                echo $opt['id'];
                echo '\')" value="上传图片"/>
                                        <br>
                                        <span class="description">';
                echo $opt['desc'];
                echo '</span>
                                        <br>
                                        <img id="img_';
                echo $opt['id'];
                echo '" style="max-width:80%;"
                                             src="';
                if ($opt_setup || get_option($opt['id']) != '') {
                    echo stripslashes(get_option($opt['id']));
                } else {
                    echo $opt['std'];
                }
                echo '">
                                    </label>
                                </td>
                            </tr>
                            ';
                break;
            case 'text_show':
                echo '<tr class="textshow"><th>' . $opt['name'] . '</th><td>' . $opt['desc'] . '</td></tr>';
                break;
        }
    }
    wp_enqueue_media();
    echo '                <p class="submit">
                    <input id="ob_save_btn" name="submit" type="submit" class="button button-primary" value="保存选项"/>
                    <input type="hidden" name="action" value="update"/>
                </p>
            </form>
            <form method="post">
                <p>
                    <input id="ob_reset_btn" name="reset" type="submit" class="button button-secondry" value="重置选项"
                           onclick="return confirm(\'你确定要重置选项吗？重置之后您的全部设置将被清空! \');"/>
                    <input type="hidden" name="action" value="reset"/>
                </p>
            </form>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <style>
        #ob_save_btn {
            margin-left: 52%;
            width: 10%;
            background-color: rgb(33, 150, 243);
            color: #fff;
        }

        #ob_reset_btn {
            position: fixed;
            bottom: 10px;
            width: 10%;
            left: 20%;
            z-index: 9999;
        }

        .submit {
            position: fixed;
            bottom: 0;
            padding: 10px;
            margin-bottom: 0;
            width: 100%;
            background: rgba(204, 204, 204, 0.62);
            z-index: 9999;
        }

        .d_alter_w {
            display: inline;
            /*float: right;*/
            width: 29%;
            margin-top: 10px;
            position: absolute;
            top: 220px;
            right: 1%
        }

        .d_alter {
            padding: 20px 10px;
            border: 5px solid #CCC;
            min-height: 500px;
        }

        .catlist {
            border: 2px solid #FFB6C1;
            padding: 5px;
            margin-top: 12px;
            text-align: center;
            color: #000;
        }

        .d_formwrap {
            float: left;
            width: 100%
        }

        #nav_tap_wrapper {
            clear: both;
            font-size: 23px;
            font-weight: 400;
            line-height: 29px;
            padding: 9px 0px 4px;
        }

        .textshow {
            color: #999;
        }

        .d_formwrap tr {
            border: 2px /*solid #ccc*/;
            padding: 20px
        }

        .panel {
            display: none;
            width: 69%
        }

        .panel input[type="text"] {
            width: 99%;
        }

        .panel input[type="text"].small-text {
            width: auto;
            max-width: 80px;
        }

        .panel h3 {
            margin: 0;
            font-size: 1.2em
        }

        #panel_update ul {
            list-style-type: disc
        }

        .nav-tab-wrapper {
            clear: both
        }

        .nav-tab {
            position: relative
        }

        .nav-tab i:before {
            position: absolute;
            top: -10px;
            right: -8px;
            display: inline-block;
            padding: 2px;
            border-radius: 50%;
            background: #30e14a;
            color: #ff0323;
            content: "\\f463";
            vertical-align: text-bottom;
            font: 400 18px/1 dashicons;
            speak: none
        }

        #theme-options-search {
            display: none;
            float: right;
            margin-top: -34px;
            width: 280px;
            font-weight: 300;
            font-size: 16px;
            line-height: 1.5
        }

        .updated + #theme-options-search {
            margin-top: -91px
        }

        .wrap.searching .nav-tab-wrapper a, .wrap.searching .panel tr, #attrselector {
            display: none
        }

        .wrap.searching .panel {
            display: block !important
        }

        #attrselector[attrselector*=ok] {
            display: block
        }
    </style>
    <style id="theme-options-filter"></style>
    <div id="attrselector" attrselector="ok"></div>
    <script type="text/javascript" src="';
    bloginfo('template_url');
    echo '/js/jquery.min.js"></script>
    <script>
        function insertImage(value_id) {
            var ashu_upload_frame;
            event.preventDefault();
            if (ashu_upload_frame) {
                ashu_upload_frame.open();
                return;
            }
            ashu_upload_frame = wp.media({
                title: \'插入图片\',
                button: {
                    text: \'插入\'
                },
                multiple: false
            });
            ashu_upload_frame.on(\'select\', function () {
                attachment = ashu_upload_frame.state().get(\'selection\').first().toJSON();
                $(\'#\' + value_id).val(attachment.url);
                $(\'#img_\' + value_id).attr("src", attachment.url);
            });
            ashu_upload_frame.open();
        }

        jQuery(function ($) {
            var activeId = sessionStorage.getItem(\'panelId\');
            if(activeId!==null&&activeId!==undefined&&activeId!==\'\'){
                $(".panel").hide();
                $(activeId).show();
                var activeAId = activeId + "_a";
                $(activeAId).addClass("nav-tab-active").siblings().removeClass("nav-tab-active");
            }
            $(".nav-tab").click(function () {
                var thisId = $(this).attr("href");
                sessionStorage.setItem(\'panelId\', thisId);
                $(this).addClass("nav-tab-active").siblings().removeClass("nav-tab-active");
                $(".panel").hide();
                $($(this).attr("href")).show();
                return false;
            });
            var themeOptionsFilter = $("#theme-options-filter");
            themeOptionsFilter.text("ok");
            if ($("#attrselector").is(":visible") && themeOptionsFilter.text() !== "") {
                $(".panel tr").each(function (el) {
                    $(this).attr("data-searchtext", $(this).text().replace(/\\r|\\n/g, \'\').replace(/ +/g, \' \').toLowerCase());
                });
                var wrap = $(".wrap");
                $("#theme-options-search").show().on("input propertychange", function () {
                    var text = $(this).val().replace(/^ +| +$/, "").toLowerCase();
                    if (text !== "") {
                        wrap.addClass("searching");
                        themeOptionsFilter.text(".wrap.searching .panel tr[data-searchtext*=\'" + text + "\']{display:block}");
                    } else {
                        wrap.removeClass("searching");
                        themeOptionsFilter.text("");
                    }
                });
            }
        });
    </script>
    ';
}

global $pagenow;
if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php') {
    wp_redirect(admin_url('themes.php?page=ob-console.php'));
    exit;
}
function ob_enqueue_pointer_script_style($_var_11)
{
    $_var_12 = false;
    $_var_13 = explode(',', get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true));
    if (!in_array('ob_options_pointer', $_var_13)) {
        $_var_12 = true;
        add_action('admin_print_footer_scripts', 'ob_pointer_print_scripts');
    }
    if ($_var_12) {
        wp_enqueue_style('wp-pointer');
        wp_enqueue_script('wp-pointer');
    }
}

add_action('admin_enqueue_scripts', 'ob_enqueue_pointer_script_style');
function ob_pointer_print_scripts()
{
    echo '    <script>
        jQuery(document).ready(function ($) {
            var $menuAppearance = $("#menu-appearance");
            $menuAppearance.pointer({
                content: \'<h3>恭喜，主题安装成功！</h3><p>该主题支持选项，请访问<a href="themes.php?page=ob-console.php">主题选项</a>页面进行配置。</p>\',
                position: {
                    edge: "left",
                    align: "center"
                },
                close: function () {
                    $.post(ajaxurl, {
                        pointer: "ob_options_pointer",
                        action: "dismiss-wp-pointer"
                    });
                }
            }).pointer("open").pointer("widget").find("a").eq(0).click(function () {
                var href = $(this).attr("href");
                $menuAppearance.pointer("close");
                setTimeout(function () {
                    location.href = href;
                }, 700);
                return false;
            });
            $(window).on("resize scroll", function () {
                $menuAppearance.pointer("reposition");
            });
            $("#collapse-menu").click(function () {
                $menuAppearance.pointer("reposition");
            });
        });
    </script>
    ';
}