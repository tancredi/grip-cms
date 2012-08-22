<?php
$this->config->load('file_upload');
$upload_config = $this->config->item('file_upload');
$filename = str_replace($upload_config['upload_path'], '', $value);
?>

<a href="<?=BASE_URL . $filename;?>" target="_blank" title="<?=$filename;?>">
    <?php echo (strlen($filename) > 30) ? '..' .  substr($filename, -27) : $filename;?>
</a>