<div class="sdmsData view">
<h2><?php echo __('Sdms Data'); ?></h2>
	<dl>
		
		<dt><?php echo __('Candidate Id'); ?></dt>
		<dd>
			<?php echo h($sdmsData['SdmsData']['candidate_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Certified'); ?></dt>
		<dd>
			<?php echo h($sdmsData['SdmsData']['certified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Account Name'); ?></dt>
		<dd>
			<?php echo h($sdmsData['SdmsData']['account_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Candidate Name'); ?></dt>
		<dd>
			<?php echo h($sdmsData['SdmsData']['candidate_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gender'); ?></dt>
		<dd>
			<?php echo h($gender[$sdmsData['SdmsData']['gender']]); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dob'); ?></dt>
		<dd>
			<?php echo date('d M Y',strtotime($sdmsData['SdmsData']['dob'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Exp Year'); ?></dt>
		<dd>
			<?php echo h($sdmsData['SdmsData']['exp_year']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Exp Month'); ?></dt>
		<dd>
			<?php echo h($sdmsData['SdmsData']['exp_month']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contact No'); ?></dt>
		<dd>
			<?php echo h($sdmsData['SdmsData']['contact_no']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Education Level'); ?></dt>
		<dd>
			<?php echo h($sdmsData['EducationLevel']['education_level_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Candidate State'); ?></dt>
		<dd>
			<?php echo h($sdmsData['CandidateState']['state_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Candidate District'); ?></dt>
		<dd>
			<?php echo h($sdmsData['CandidateDistrict']['district_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sector'); ?></dt>
		<dd>
			<?php echo h($sdmsData['Sector']['sector_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Skill Flag1'); ?></dt>
		<dd>
			<?php echo h($sdmsData['Skill1']['skill_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Skill Flag2'); ?></dt>
		<dd>
			<?php echo h($sdmsData['Skill2']['skill_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Skill Flag3'); ?></dt>
		<dd>
			<?php echo h($sdmsData['Skill3']['skill_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nsqf Level'); ?></dt>
		<dd>
			<?php echo h($sdmsData['SdmsData']['nsqf_level']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('CentreState'); ?></dt>
		<dd>
			<?php echo h($sdmsData['CentreState']['state_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('CentreDistrict'); ?></dt>
		<dd>
			<?php echo h($sdmsData['CentreDistrict']['district_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dummy Field1'); ?></dt>
		<dd>
			<?php echo h($sdmsData['SdmsData']['dummy_field1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dummy Field2'); ?></dt>
		<dd>
			<?php echo h($sdmsData['SdmsData']['dummy_field2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($sdmsData['SdmsData']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($sdmsData['SdmsData']['modified']); ?>
			&nbsp;
		</dd>
		
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Sdms Data'), array('action' => 'edit', $sdmsData['SdmsData']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Sdms Data'), array('action' => 'delete', $sdmsData['SdmsData']['id']), array(), __('Are you sure you want to delete # %s?', $sdmsData['SdmsData']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List SDMS Data'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Add SDMS Data'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List States'), array('controller' => 'states', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Add State'), array('controller' => 'states', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Districts'), array('controller' => 'districts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Add District'), array('controller' => 'districts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sectors'), array('controller' => 'sectors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Add Sector'), array('controller' => 'sectors', 'action' => 'add')); ?> </li>
	</ul>
</div>
	
		
		
		
	
