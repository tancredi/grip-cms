<?php $this->load->helper(array('admin/thumbnail', 'html')); ?>

<a class="thumbnail" data-modal-type="image" data-modal-url="<?=BASE_URL . $value;?>" target="_blank" title="<?=$value;?>">

<?php echo img(thumb('.' . $value, 40, 40)); ?>
</a>