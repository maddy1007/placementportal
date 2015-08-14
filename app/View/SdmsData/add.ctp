<div class="sdmsData form">
<?php echo $this->Form->create('SdmsData'); ?>
	<fieldset>
		<legend><?php echo __('Add Sdms Data'); ?></legend>
	<?php
		echo $this->Form->input('candidate_id',array('type'=>'text'));
		echo $this->Form->input('certified');
		echo $this->Form->input('account_name');
		echo $this->Form->input('candidate_name');
		echo $this->Form->input('gender',array('type'=>'select','options'=>$gender,'empty'=>'Select'));
		echo $this->Form->input('dob',array('type'=>'text'));
		echo $this->Form->input('exp_year');
		echo $this->Form->input('exp_month');
		echo $this->Form->input('contact_no');
		echo $this->Form->input('education_level',array('type'=>'select','options'=>$educationLevels,'empty'=>'Select'));
		echo $this->Form->input('candidate_state_id',array('type'=>'select','options'=>$states,'empty'=>'Select'));
		echo $this->Form->input('candidate_district_id',array('type'=>'select','empty'=>'Select'));
		echo $this->Form->input('sector_id',array('type'=>'select','options'=>$sectors,'empty'=>'Select'));
		echo $this->Form->input('skill_flag1');
		echo $this->Form->input('skill_flag2');
		echo $this->Form->input('skill_flag3');
		echo $this->Form->input('nsqf_level');
		echo $this->Form->input('centre_state_id',array('type'=>'select','options'=>$states,'empty'=>'Select'));
		echo $this->Form->input('centre_district_id',array('type'=>'select','empty'=>'Select'));
		echo $this->Form->input('dummy_field1');
		echo $this->Form->input('dummy_field2');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List SDMS Data'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List States'), array('controller' => 'states', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New State'), array('controller' => 'states', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Districts'), array('controller' => 'districts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New District'), array('controller' => 'districts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Education Levels'), array('controller' => 'education_levels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Education Level'), array('controller' => 'education_levels', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sectors'), array('controller' => 'sectors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sector'), array('controller' => 'sectors', 'action' => 'add')); ?> </li>
	</ul>
</div>
