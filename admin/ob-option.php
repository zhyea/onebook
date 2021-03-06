<?php
$options = array(
    //将选项放入数组中，管理更加方便
    //
    //标签页‘网站设置’开始
    array(
        'title' => '基本设置',
        'id' => 'webseting',
        'type' => 'panelstart'        //panel代表是顶部标签
    ),
    array(
        'title' => '在此设置您网站的基本信息',
        'type' => 'sutitle'    //sutitle代表顶部标签介绍信息
    ),//
    array(
        'name' => '网站名称',
        'desc' => '网站首页的SEO名称',
        'id' => "ob_title",
        'type' => 'text',
        'std' => ''
    ),
    array(
        'name' => '网站关键字',//选项显示的文字，选填
        'desc' => '各关键字间用半角逗号","分割，数量在6个以内最佳。',//选项显示的一段描述文字，选填
        'id' => "ob_keywords",//选项的id，必须是唯一，后面根据这个获取值，必填
        'type' => 'text',//种类，这个是普通的文字输入，必填
        'std' => ''//选项的默认值，选填
    ),
    array(
        'name' => '网站描述',
        'desc' => '用简洁的文字描述您的站点，字数建议在120个字以内',
        'id' => "ob_description",
        'type' => 'textarea',
        'std' => ''
    ),
    array(
        'name' => '网站缩略图',//选项显示的文字，选填
        'desc' => '网站og:image标签图片地址',//选项显示的一段描述文字，选填
        'id' => "ob_og_image",//选项的id，必须是唯一，后面根据这个获取值，必填
        'type' => 'images',//种类，这个是普通的文字输入，必填
        'std' => ''//选项的默认值，选填
    ),
    array(
        'name' => '最新章节文章数',
        'desc' => '最新章节显示的文章数量',
        'id' => "new_list_num",
        'type' => 'number',
        'std' => '9'
    ),
    array(
        'name' => '文章列表排序规则',
        'desc' => '选择您的文章列表排序规则【正序】或【倒序】',
        'id' => "ob_post_list_order",
        'type' => 'radio',
        'options' => array(
            '正序' => 'ASC',
            '倒序' => 'DESC',
        ),
        'std' => 'ob_post_list_order_asc'
    ),
    array(
        'name' => '是否开启小说章节分页',
        'desc' => '开启',
        'id' => 'ob_post_paged_on',
        'type'=>'checkbox'
    ),
    array(
        'name' => '每个分页显示文章数',
        'desc' => '每个分页显示的文章数量',
        'id' => "ob_post_paged_num",
        'type' => 'number',
        'std' => '50'
    ),
    array(
        'name' => '是否开启文章阅读页仿采集',
        'desc' => '开启后，也会影响搜索引擎对文章内容的爬取',
        'id' => 'ob_post_anti_spider_on',
        'type'=>'checkbox'
    ),
    array(
        'name' => '开启文章阅读页仿采集文字',
        'desc' => '开启后，采集者只会采集到这些文字',
        'id' => 'ob_post_anti_spider_text',
        'type' => 'textarea'
    ),
    array(
        'name' => 'QQ群链接',
        'desc' => '加入QQ群的链接，显示在全站最上方',
        'id' => 'qq_qun_link',
        'type' => 'text'
    ),
    array(
        'name' => '去除头部多余代码',
        'desc' => '如果不用wlw发布博客，则建议开启',
        'id' => 'ob_remove_head_code',
        'type' => 'checkbox'
    ),
    array(
        'name' => '统计代码',
        'desc' => '统计代码，百度，CNZZ等统计代码',
        'id' => 'ob_tongji_code',
        'type' => 'textarea'
    ),
    array(
        'name' => '百度自动推送代码',
        'desc' => '百度自动推送代码',
        'id' => 'ob_baidu_tui_code',
        'type' => 'textarea'
    ),
    array(
        'name' => '头部公共代码',
        'desc' => '网站头部公共代码,可以是任意HTML代码',
        'id' => 'ob_head_code',
        'type' => 'textarea'
    ),
    array(
        'name' => '页脚公共代码',
        'desc' => '网站页脚公共代码,可以是任意HTML代码',
        'id' => 'ob_foot_code',
        'type' => 'textarea'
    ),
    array(
        'name' => '免插件去除category',
        'desc' => '免插件去除链接中的category',
        'id' => 'ob_uncategroy_en',
        'type' => 'checkbox'
    ),
    array(
        'name' => '禁止主题自动更新',
        'desc' => '禁止自动更新 【不推荐】',
        'id' => "ob_updates_un",
        'type' => 'checkbox'
    ),
    array(
        'type' => 'panelend'
    ),
    //标签页‘网站设置’结束
    //
    //标签页‘首页设置’开始
    array(
        'title' => 'SEO设置',
        'id' => 'SEOsetting',
        'type' => 'panelstart'
    ),
    array(
        'title' => '网站SEO情况设置！',
        'type' => 'subtitle'
    ),
    array(
        'name' => '小说页SEO标题格式',
        'desc' => '小说页面SEO标题格式，可用标签：{{blog_name}}-网站名称,{{cat_name}}-小说名称,{{cat_auth}}-小说作者<br/>'
            . '示例：{{cat_name}}({{cat_auth}})_起点小说_{{cat_name}}最新章节_{{cat_auth}}新书全文免费阅读_{{blog_name}}',
        'id' => "ob_novel_seo_title",
        'type' => 'textarea',
        'std' => '{{cat_name}}({{cat_auth}})_起点小说_{{cat_name}}最新章节_{{cat_auth}}新书全文免费阅读_{{blog_name}}'
    ),
    array(
        'name' => '小说页SEO关键词格式',
        'desc' => '小说页面SEO关键词格式，可用标签：{{blog_name}}-网站名称,{{cat_name}}-小说名称,{{cat_auth}}-小说作者<br/>'
            . '示例：{{cat_name}},{{cat_name}}起点,{{cat_name}}小说,{{cat_name}}最新章节,{{cat_name}}免费阅读,{{cat_name}}全文阅读,{{cat_auth}},{{cat_name}}吧',
        'id' => "ob_novel_seo_keywords",
        'type' => 'textarea',
        'std' => '{{cat_name}},{{cat_name}}起点,{{cat_name}}小说,{{cat_name}}最新章节,{{cat_name}}免费阅读,{{cat_name}}全文阅读,{{cat_auth}},{{cat_name}}吧'
    ),
    array(
        'name' => '小说页SEO描述格式',
        'desc' => '小说页面SEO描述格式，可用标签：{{blog_name}}-网站名称,{{cat_name}}-小说名称,{{cat_auth}}-小说作者<br/>'
            . '示例：{{cat_name}}是{{cat_auth}}创作的全新精彩小说，{{cat_name}}最新章节来源于互联网网友,{{blog_name}}提供{{cat_name}}全文在线免费阅读，并且无任何弹窗广告。',
        'id' => "ob_novel_seo_desc",
        'type' => 'textarea',
        'std' => '{{cat_name}}是{{cat_name}}创作的全新精彩小说，{{cat_name}}最新章节来源于互联网网友,{{blog_name}}提供重燃全文在线免费阅读，并且无任何弹窗广告。'
    ),
    array(
        'name' => '章节阅读页SEO标题格式',
        'desc' => '章节阅读页面SEO标题格式，可用标签：{{blog_name}}-网站名称,{{cat_name}}-小说名称,{{cat_auth}}-小说作者,{{post_title}}-章节名称<br/>'
            . '示例：{{cat_name}}-{{post_title}}_{{cat_name}}最新章节',
        'id' => "ob_post_seo_title",
        'type' => 'textarea',
        'std' => '{{cat_name}}-{{post_title}}_{{cat_name}}最新章节'
    ),
    array(
        'name' => '章节阅读页SEO关键词格式',
        'desc' => '章节阅读页面SEO关键词格式，可用标签：{{blog_name}}-网站名称,{{cat_name}}-小说名称,{{cat_auth}}-小说作者,{{post_title}}-章节名称<br/>'
            . '示例：{{cat_name}},{{cat_name}}起点,{{cat_name}}小说,{{cat_name}}最新章节,{{cat_name}}免费阅读,{{cat_name}}全文阅读,{{cat_auth}},{{cat_name}}吧',
        'id' => "ob_post_seo_keywords",
        'type' => 'textarea',
        'std' => '{{cat_name}},{{cat_name}}起点,{{cat_name}}小说,{{cat_name}}最新章节,{{cat_name}}免费阅读,{{cat_name}}全文阅读,{{cat_auth}},{{cat_name}}吧'
    ),
    array(
        'name' => '章节阅读页SEO描述格式',
        'desc' => '章节阅读页面SEO描述格式，可用标签：{{blog_name}}-网站名称,{{cat_name}}-小说名称,{{cat_auth}}-小说作者,{{post_title}}-章节名称<br/>'
            . '示例：{{cat_name}}是{{cat_auth}}创作的全新精彩小说，{{cat_name}}最新章节来源于互联网网友,{{blog_name}}提供{{cat_name}}全文在线免费阅读，并且无任何弹窗广告。',
        'id' => "ob_post_seo_desc",
        'type' => 'textarea',
        'std' => '{{cat_name}}是{{cat_name}}创作的全新精彩小说，{{cat_name}}最新章节来源于互联网网友,{{blog_name}}提供重燃全文在线免费阅读，并且无任何弹窗广告。'
    ),
    array(
        'type' => 'panelend'
    ),
    //标签页‘网站设置’结束
    //标签页‘首页设置’开始
    array(
        'title' => '首页设置',
        'id' => 'personsetting',
        'type' => 'panelstart'
    ),
    array(
        'title' => '网站首页小说情况设置！',
        'type' => 'subtitle'
    ),
    array(
        'name' => '您的网站现有小说ID为：',
        'desc' => bing_show_category(),
        'type' => 'text_show'
    ),
    array(
        'name' => '首页小说ID',
        'desc' => '首页小说ID',
        'id' => "index_cat_id",
        'type' => 'number',
        'std' => '2'
    ),
    array(
        'name' => '开启最近更新和最新入库小说列表',
        'desc' => '开启后，在页面下半部分会显示最新更新的章节和一个最新增加的小说列表',
        'id' => 'ob_popcat_on',
        'type' => 'checkbox'
    ),
    array(
        'name' => '猜您喜欢板块排除小说ID',
        'desc' => '不想显示在猜您喜欢板块的小说ID，不同ID之间使用英文半角逗号分割',
        'id' => "index_pop_except_id",
        'type' => 'text',
        'std' => '1'
    ),
    array(
        'name' => '猜您喜欢板块显示小说数',
        'desc' => '猜您喜欢板块显示小说的数量',
        'id' => "index_pop_except_num",
        'type' => 'number',
        'std' => '9'
    ),
    array(
        'type' => 'panelend'
    ),
    //标签页‘其他设置’开始
    array(
        'title' => '其他设置',
        'id' => 'othersetting',
        'type' => 'panelstart'
    ),
    array(
        'title' => '网站其他情况设置！',
        'type' => 'subtitle'
    ),
    array(
        'name' => '文章开头代码',
        'desc' => '文章开头代码，可以写版权说明等,也可以放广告代码，支持HTML',
        'id' => 'ob_post_begin_code',
        'type' => 'textarea'
    ),
    array(
        'name' => '文章结尾代码',
        'desc' => '文章结尾代码，可以写版权说明等,也可以放广告代码，支持HTML',
        'id' => 'ob_post_end_code',
        'type' => 'textarea'
    ),
    array(
        'name' => '网站友情链接',
        'desc' => '友情链接的HTML代码，每个链接需要用li标签包裹',
        'id' => 'ob_flink',
        'type' => 'textarea'
    ),
    array(
        'name' => '本站强推',
        'desc' => '本站强推的HTML代码',
        'id' => 'ob_recommend',
        'type' => 'textarea'
    ),
    array(
        'name' => '文章底部推荐阅读',
        'desc' => '会显示在文章底部的推荐阅读部分',
        'id' => 'ob_post_bottom_recommend',
        'type' => 'textarea'
    ),
    array(
        'type' => 'panelend'
    ),
    //标签页‘广告设置’开始
    array(
        'title' => '广告设置',
        'id' => 'adsetting',
        'type' => 'panelstart'
    ),
    array(
        'name' => '首页-章节列表上-PC端',
        'desc' => '广告代码',
        'id' => 'ob_ad_chapter_top-PC',
        'type' => 'textarea'
    ),
    array(
        'name' => '首页-章节列表下-PC端',
        'desc' => '广告代码',
        'id' => 'ob_ad_chapter_bottom-PC',
        'type' => 'textarea'
    ),
    array(
        'name' => '文章页-左侧-PC端',
        'desc' => '广告代码',
        'id' => 'ob_ad_post_left-PC',
        'type' => 'textarea'
    ),
    array(
        'name' => '文章页-右侧-PC端',
        'desc' => '广告代码',
        'id' => 'ob_ad_post_right-PC',
        'type' => 'textarea'
    ),
    array(
        'name' => '文章页-文章上方-PC端',
        'desc' => '广告代码',
        'id' => 'ob_ad_post_top-PC',
        'type' => 'textarea'
    ),
    array(
        'name' => '文章页-文章下方-PC端',
        'desc' => '广告代码',
        'id' => 'ob_ad_post_bottom-PC',
        'type' => 'textarea'
    ),

    array(
        'name' => '首页-章节列表上-手机端',
        'desc' => '广告代码',
        'id' => 'ob_ad_chapter_top-wap',
        'type' => 'textarea'
    ),
    array(
        'name' => '首页-章节列表下-手机端',
        'desc' => '广告代码',
        'id' => 'ob_ad_chapter_bottom-wap',
        'type' => 'textarea'
    ),
    array(
        'name' => '文章页-文章上方-手机端',
        'desc' => '广告代码',
        'id' => 'ob_ad_post_top-wap',
        'type' => 'textarea'
    ),
    array(
        'name' => '文章页-文章下方-手机端',
        'desc' => '广告代码',
        'id' => 'ob_ad_post_bottom-wap',
        'type' => 'textarea'
    ),
    array(
        'type' => 'panelend'
    ),
    //标签页‘缓存设置’开始
    array(
        'title' => '缓存设置',
        'id' => 'CacheSetting',
        'type' => 'panelstart'
    ),
    array(
        'title' => '本主题内置纯静态HTML缓存功能，在此页设置静态缓存功能！',
        'type' => 'subtitle'
    ),
    array(
        'name' => '静态缓存使用说明：',
        'desc' => '1、请在服务器设置中，将主页的index.html页面优先级排到index.php之前。<br/>'
            . '2、请在【设置】-【固定链接】设置中设置合适的伪静态规则，文章页面以html结尾。推荐的伪静态规则：/book/%post_id%.html<br/>'
            . '3、小说页面链接请设置为英文，且不要以 wp- 开头，否则后果自负！<br/>'
            . '4、请尽量不要使用删除全部文章页缓存的功能，因为如果你网站的文章量很大，则此功能会消耗比较大的服务器资源。<br/>'
            . '5、只有以游客身份浏览页面时才会触发缓存，管理员访问未缓存的界面不会触发缓存操作。<br/>',
        'type' => 'text_show'
    ),
    array(
        'name' => '开启纯静态HTML缓存',
        'desc' => '缓存为纯静态HTML页面',
        'id' => 'ob_Cache_on',
        'type' => 'checkbox'
    ),
    array(
        'name' => '开启首页缓存',
        'desc' => '是否缓存首页',
        'id' => 'ob_Cache_index_on',
        'type' => 'checkbox'
    ),
    array(
        'name' => '开启小说页缓存',
        'desc' => '是否缓存小说页面',
        'id' => 'ob_Cache_cate_on',
        'type' => 'checkbox'
    ),
    array(
        'name' => '开启页面缓存',
        'desc' => '是否缓存自定义页面',
        'id' => 'ob_Cache_page_on',
        'type' => 'checkbox'
    ),
    array(
        'name' => '删除文章缓存',
        'desc' => '请输入要删除缓存的文章(页面)ID或者文章(页面)名称，留空则代表删除全部文章页缓存<br/>'
            . "<a href='#' class='button-primary' rel='nofollow' onclick='delHtmlCache(\"" . $blogUrl . "/index.php\",\"1\")'>删除缓存</a>"
            . '<br/><span style="color:red" id="ob_Cache_Del_span"></span>'
            . "<script type='application/javascript' src='$themeDir/js/wnovel.js'></script>",
        'id' => 'ob_Cache_Del_id',
        'type' => 'text'
    ),
    array(
        'name' => '删除小说页缓存',
        'desc' => '请输入要删除缓存的小说ID，留空则代表删除全部小说页缓存  '
            . "<a href='#' class='button-primary' rel='nofollow' onclick='delHtmlCache(\"" . $blogUrl . "/index.php\",\"2\")'>删除缓存</a>"
            . '<br/><span style="color:red" id="ob_Cache_Del_Cate_span"></span>'
            . "<script type='application/javascript' src='$themeDir/js/wnovel.js'></script>",
        'id' => 'ob_Cache_Del_cate_id',
        'type' => 'number'
    ),
    array(
        'name' => '您的网站现有小说ID为：',
        'desc' => bing_show_category(),
        'type' => 'text_show'
    ),

    array(
        'type' => 'panelend'
    ),
);