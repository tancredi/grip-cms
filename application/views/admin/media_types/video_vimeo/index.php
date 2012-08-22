<?php $this->load->helper(array('html_helper')); ?>

<?php $i = 0; foreach(explode(',', $value) as $video_id) : ?>

	<a href="#" data-modal-type="videoVimeo" data-modal-url="<?=$video_id;?>" target="_blank" title="<?=$video_id;?>">
	    Watch &raquo;
	</a>
	<?php if ($i != count($value) && count($value) != 1) { echo  ','; } ?>

<?php $i++; endforeach; ?>