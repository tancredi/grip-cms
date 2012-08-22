<?php
$ci =& get_instance();
$ci->load->library('session');
$this->load->helper('url');
?>

<div class="navigation">
    
    <ul>
        <?php foreach ($page_navigation as $link): ?>
            <li class="<?=($link['selected'] ? 'selected' : '');?>">
                <a href="<?=site_url($link['segments']);?>">
                    <?=$link['label'];?>
                </a>
            </li>
        <?php endforeach;?>
    </ul>

    <?php if ($ci->session->userdata('logged_in') == true): ?>
        <div class="user-info">
            Logged in as <strong><?=$ci->session->userdata('user')->username;?></strong>. <a href="<?=site_url(array('admin', 'login', 'logout'));?>">Log out</a>
        </div>
    <?php endif; ?>

</div>