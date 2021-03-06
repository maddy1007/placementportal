<div class="districts form">
	<fieldset>
		<legend><?php echo __('Upload Results'); ?></legend>
			<b>Upload Type    :</b> <?php echo $result['Excel']['type'];  ?> <br>
			<b>File Name      :</b> <?php echo $result['Excel']['excel_name'];  ?> <br>			
			<b>Uploaded By    :</b> <?php echo $result['Excel']['created_by'];  ?> <br>
			<b>Uploaded Date  :</b> <?php echo date('d-m-Y',strtotime($result['Excel']['created']));  ?> <br>
			<b>Total Rows     :</b> <?php echo $result['Excel']['total_rows']; ?> <br>
			<b>Total Uploaded :</b> <?php echo $result['Excel']['total_upload']; ?> <br>
			<b>Total Rejected :</b> <?php echo $result['Excel']['total_rejected']; ?><br>
			<b>Total Empty    :</b> <?php echo $result['Excel']['total_empty']; ?><br>
			<br>
			<br>
		<?php if(!empty($result['Excel']['error_csv_path'])) { ?>			
			<b>Download File    :</b> <?php echo $this->Html->link(__('Download'), array('controller' => 'sdms_data', 'action' => 'downloadFile/'.base64_encode($result['Excel']['id'])));?><br>
		<?php } ?>
	</fieldset>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Districts'), array('controller' => 'districts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List States'), array('controller' => 'states', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sectors'), array('controller' => 'sectors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List SDMS Data'), array('controller' => 'sdms_data','action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Excel'), array('controller' => 'excels','action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link( "Logout",   array('controller' => 'users','action'=>'logout') ); ?></li>
	</ul>
</div>
