<div>


</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>				
		<li><?php echo $this->Html->link(__('List Districts'), array('controller' => 'districts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List States'), array('controller' => 'states', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sectors'), array('controller' => 'sectors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Excels'), array('controller' => 'excels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link( "List SDMS Data",   array('controller' => 'sdms_data','action'=>'index') ); ?></li>
		<li><?php echo $this->Html->link( "Logout",   array('action'=>'logout') ); ?></li>
	</ul>	


</div>
