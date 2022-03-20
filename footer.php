<?php

$ob_foot_code = get_opt('ob_foot_code');
?>
<div id="footer">
    <div class="hd">
        <p>如若发现小说内容有与法律抵触之处或对作品版权有质疑，请发邮件告知本站，立即予以处理</p>
        <p>Copyright &copy; <a href="<?= home_url() ?>"><?= get_bloginfo('name') ?></a> 免费小说在线阅读</p>
    </div>
</div>
<script>backtotop();</script>
<?= get_opt('ob_tongji_code') ?>
<?= get_opt('ob_baidu_tui_code') ?>
<?= $ob_foot_code ?>
</body>
</html>