<div class="districts index">
	<h2><?php echo __('Districts'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('Id'); ?></th>
			<th><?php echo $this->Paginator->sort('State Id'); ?></th>
			<th><?php echo $this->Paginator->sort('District Name'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($districts as $district): ?>
	<tr>
		<td><?php echo h($district['District']['id']); ?>&nbsp;</td>
		<td><?php echo h($district['State']['state_name']); ?>&nbsp;</td>
		<td><?php echo h($district['District']['district_name']); ?>&nbsp;</td>
		<td><?php echo h($district['District']['created']); ?>&nbsp;</td>
		<td><?php echo h($district['District']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $district['District']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $district['District']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $district['District']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $district['District']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Return to Dashboard'), array('controller'=>'users','action'=>'index') ); ?></li>
		<li><?php echo $this->Html->link(__('New District'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Upload CSV'), array('action' => 'uploadExcel')); ?> </li>
		<li><?php echo $this->Html->link(__('Logout'),  array('controller'=>'users','action'=>'logout') ); ?></li>
	</ul>
</div>
