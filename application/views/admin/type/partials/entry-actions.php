<a title="Move up" href="<?=site_url(array('admin', 'type', 'move', $type->table_name, $entry['id'], 1))?>" class="button">
    <span class="icon-action icon-action-move-up">Move Up</span>
</a>

<a title="Move down" href="<?=site_url(array('admin', 'type', 'move', $type->table_name, $entry['id'], -1))?>" class="button">
    <span class="icon-action icon-action-move-down">Move Down</span>
</a>

<a title="Delete Entry" href="<?=site_url(array('admin', 'type', 'delete', $type->table_name, $entry['id']));?>" class="button">
    <span class="icon-action icon-action-delete">Delete</span>
</a>

<a title="Edit Entry" href="<?=site_url(array('admin', 'type', 'edit', $type->table_name, $entry['id']));?>" class="button">
    <span class="icon-action icon-action-edit">Edit</span>
</a>

<a title="View Entry details" href="<?=site_url(array('admin', 'type', 'view', $type->table_name, $entry['id']));?>" class="button">
    <span class="icon-action icon-action-details">View</span>
</a>
