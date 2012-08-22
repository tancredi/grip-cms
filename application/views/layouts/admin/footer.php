<?php

$this->load->helper('directory');

$templates_dir = APPPATH . '../admin/templates/';
$templates_dir_map = directory_map($templates_dir);

foreach ($templates_dir_map as $item):
    if (!is_array($item)): ?>

        <script type="text/html" data-template-ns="<?=str_replace('.html', '', $item);?>">
            <?php include $templates_dir . $item; ?>
        </script>

    <?php endif;
endforeach;

?>

</body>
</html>