<div class="districts form">
<?php echo $this->Form->create('District',array( 'enctype' => 'multipart/form-data')); ?>
	<fieldset>
		<legend><?php echo __('Upload District CSV'); ?></legend>
	<?php
		echo $this->Form->input('UploadExcel', array('type' => 'file','label'=>false));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New District'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Districts'), array('action' => 'index')); ?></li>
	</ul>
</div>
