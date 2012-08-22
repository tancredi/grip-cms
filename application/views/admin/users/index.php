
<ul class="entries-list">
    <?php
    foreach ($users as $user) :
    ?>
        <li>

            <a href="<?=site_url(array('admin', 'users', 'edit', $user->id));?>" class="separed"><?=$user->username;?> &raquo;</a>
            <span class="detail separed"><?=$user->email;?></span>
            <span class="detail"><strong><?=$user_levels[$user->level]['label'];?></strong></span>

            <a title="Move up" href="<?=site_url(array('admin', 'users', 'move', $user->id, 1));?>" class="button">
                <span class="icon-action icon-action-move-up">Move Up</span>
            </a>

            <a title="Move down" href="<?=site_url(array('admin', 'users', 'move', $user->id, -1));?>" class="button">
                <span class="icon-action icon-action-move-down">Move Down</span>
            </a>
            
            <a title="Delete User" href="<?=site_url(array('admin', 'users', 'delete', $user->id));?>" class="button">
                <span class="icon-action icon-action-delete">Delete</span>
            </a>

            <a title="Edit User details" href="<?=site_url(array('admin', 'users', 'edit', $user->id));?>" class="button">
                <span class="icon-action icon-action-edit">Edit</span>
            </a>

        </li>
    <?php endforeach;
    if (count($users) == 0): ?>

        <div class="data-display">
            No users registered.
            <a href="<?=site_url(array('admin', 'users', 'add'));?>">
                Register a User &raquo;
            </a>
        </div>

    <?php endif; ?>
</ul>

<hr />

<a href="<?=site_url(array('admin', 'users', 'add'));?>" class="cta">Register a new User</a>