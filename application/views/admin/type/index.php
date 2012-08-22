<div class="data-table-wrapper">
    <span class="test"></span>
    <?php
    $this->table->set_template(array('table_open' => '<table class="data-table with-actions">'));
    echo $this->table->generate($table_data);
    ?>
</div>