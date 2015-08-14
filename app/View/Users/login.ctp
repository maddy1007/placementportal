<div >
<?php echo $this->Session->flash(); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Please enter your E-mail/Mobile Number and Password'); ?></legend>
        <?php echo $this->Form->input('username',array('label'=>'Email/Mobile'));
        echo $this->Form->input('password');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Login')); ?>
</div>
