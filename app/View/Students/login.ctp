
<!-- <div id='easter'><a href="http://akk.li/pics/anne.jpg">
        <div style='width:10px;height:10px;background:transparent;color:transparent;' id='easterlink'><h1>Hey There Kiddo</h1>
</div></a></div> -->
<div class='grid_6 prefix_3 suffix_3' id='login_box'>
    <style  type='text/css'>
        
        @font-face{
            font-family: ghost;
            src: url("http://myrighttoplay.com/Ghoulish.ttf");
        }
        #easterlink > h1:hover {
            color:red;
            font-family: ghost;
        }
    </style>
    <?php echo $this->Html->image('honors-college.png'); ?>
</div>
<div class='grid_6 push_3 callout_container'>
    <div class='grid-6 callout_title'>
	CRS Student Login
    </div>
    <div class='grid_4 suffix_1 prefix_1'>
        <?php 
        echo $this->Form->create('Student', array('action' => 'login', 'type' => 'POST'));
        echo $this->Form->input('id', array('placeholder' => 'Student Panther ID', 'label' => 'Panther ID', 'type' => 'text'));
        echo $this->Form->input('password', array('placeholder' => 'Student Password'));
        echo $this->Form->end('Log In');
        ?>
    </div>
</div>