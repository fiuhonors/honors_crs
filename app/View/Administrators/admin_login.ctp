<div class='grid_6 prefix_3 suffix_3' id='login_box'>
    <?php echo $this->Html->image('honors-college.png'); ?>
</div>
<div class='grid_6 push_3 callout_container'>
    <div class='grid-6 callout_title'>
	CRS Administration Login
    </div>
    <div class='grid_4 suffix_1 prefix_1'>
        <?php 
        echo $this->Form->create('Administrator', array('type' => 'post')); 
        echo $this->Form->input('id', array('placeholder' => 'Admin Panther ID', 'label' => 'Username', 'type' => 'text'));
        echo $this->Form->input('password', array('placeholder' => 'Admin Password'));
        echo $this->Form->end('Log In');
        ?>
    </div>
    <br/>
</div>