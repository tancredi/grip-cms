<?php

if ($entries_total > MAX_ENTRIES_PER_PAGE):

    $previous_page_exists = ($current_page != 0);
    $next_page_exists = (MAX_ENTRIES_PER_PAGE * ($current_page + 1) < $entries_total);

    $previous_page_url = site_url(array('admin', 'type', 'index', $type->table_name, $order_by[0], $order_by[1], $current_page - 1));
    $next_page_url = site_url(array('admin', 'type', 'index', $type->table_name, $order_by[0], $order_by[1], $current_page + 1));

?>

    <div class="pagination">

        <?php if ($previous_page_exists): ?>
            <a class="previous" href="<?=$previous_page_url;?>">&laquo; Previous page</a>
        <?php endif; ?>

        Page <?=$current_page + 1;?> of <?=$pages_total;?>

        <?php if ($next_page_exists): ?>
            <a class="next" href="<?=$next_page_url;?>">Next page &raquo;</a>
        <?php endif; ?>

    </div>


<?php endif; ?>