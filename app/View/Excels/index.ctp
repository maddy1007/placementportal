<div class="excels index">
	<h2><?php echo __('Excels'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('excel_name'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($excels as $excel): ?>
	<tr>
		<td><?php echo h($excel['Excel']['id']); ?>&nbsp;</td>
		<td><?php echo h($excel['Excel']['excel_name']); ?>&nbsp;</td>
		<td><?php echo h($excel['Excel']['type']); ?>&nbsp;</td>
		<td><?php echo $this->Time->niceShort($excel['Excel']['created']); ?>&nbsp;</td>
		<td class="actions">
		      <?php echo $this->Html->link(__('View'), array('action' => 'upload_results', base64_encode($excel['Excel']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('Logout'),  array('controller'=>'users','action'=>'logout') ); ?></li>
	</ul>
</div>
