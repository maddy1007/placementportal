<div class="sectors form">
<?php echo $this->Form->create('Sector',array( 'enctype' => 'multipart/form-data')); ?>
	<fieldset>
		<legend><?php echo __('Upload Sector CSV'); ?></legend>
	<?php
		echo $this->Form->input('UploadExcel', array('type' => 'file','label'=>false));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Sector'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Sectors'), array('action' => 'index')); ?></li>
	</ul>
</div>
