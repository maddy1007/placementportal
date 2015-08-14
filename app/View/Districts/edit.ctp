<div class="districts form">
<?php echo $this->Form->create('District'); ?>
	<fieldset>
		<legend><?php echo __('Edit District'); ?></legend>
	<?php
		echo $this->Form->input('id',array('type'=>'hidden'));
		echo $this->Form->input('state_id',array('type'=>'select', 'label'=>'State', 'options'=>$states,'empty'=>'Select','selected'=>$this->data['District']['state_id']));
		echo $this->Form->input('district_name');
		//echo $this->Form->input('created');
		//echo $this->Form->input('modified');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('District.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('District.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Districts'), array('action' => 'index')); ?></li>
	</ul>
</div>
