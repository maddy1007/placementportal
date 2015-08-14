<div class="districts form">
<?php echo $this->Form->create('SdmsData',array( 'enctype' => 'multipart/form-data')); ?>
	<fieldset>
		<legend><?php echo __('Upload SDMS CSV'); ?></legend>
	<?php
		echo $this->Form->input('UploadExcel', array('type' => 'file','label'=>false));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Return to Dashboard'), array('controller'=>'users','action'=>'index') ); ?></li>
		<li><?php echo $this->Html->link(__('Add Sdms Data'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List SDMS Data'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List States'), array('controller' => 'states', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Add State'), array('controller' => 'states', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Districts'), array('controller' => 'districts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Add District'), array('controller' => 'districts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sectors'), array('controller' => 'sectors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Add Sector'), array('controller' => 'sectors', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Logout'),  array('controller'=>'users','action'=>'logout') ); ?></li>
	</ul>
</div>
