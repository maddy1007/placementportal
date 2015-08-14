<div class="districts form">
<?php echo $this->Form->create('District'); ?>
	<fieldset>
		<legend><?php echo __('Add District'); ?></legend>
	<?php
		echo $this->Form->input('state_id',array('type'=>'select', 'label'=>'State', 'options'=>$states,'empty'=>'Select'));
		echo $this->Form->input('district_name');
		//echo $this->Form->input('Created');
		//echo $this->Form->input('Modified');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Upload CSV'), array('action' => 'uploadExcel')); ?> </li>
		<li><?php echo $this->Html->link(__('List Districts'), array('action' => 'index')); ?></li>
	</ul>
</div>
