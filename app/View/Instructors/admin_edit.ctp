<div class="container_12">
    <div class="grid_12">
        <h2> Edit Instructor </h2>
        <?php echo $this->Form->create('Instructor'); ?>
        <div class='grid_6 alpha'>
        <?php
            echo $this->Form->input('id', array('placeholder' => 'Panther ID of Instructor', 'label' => 'Panther ID', 'type' => 'text'));
            echo $this->Form->input('last_name', array('placeholder' => 'Last name of Instructor'));
            echo $this->Form->input('first_name', array('placeholder' => 'First name of Instructor'));
            echo $this->Form->input('email', array('placeholder' => 'Panther Email of Instructor'));
        ?>
        </div>
        <div class='grid_6 omega'>
        <?php
            echo $this->Form->input('position', array('placeholder' => 'Instructor Position'));
            echo $this->Form->input('address', array('placeholder' => 'Instructor Address'));
            echo $this->Form->end('Edit Instructor');
        ?>
        </div>
    </div>
</div>