<?php

if (get_opt('ob_flink')) {
    ?>
    <div class="clear"></div>
    <div class="container">
        <div class="inner links">
            <div class="title">友情链接</div>
            <ul class="link">
                <?= get_opt('ob_flink') ?>
            </ul>
        </div>
    </div>
<?php }