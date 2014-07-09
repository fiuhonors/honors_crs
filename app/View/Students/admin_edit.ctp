<div class="container_12">
     <div class="grid_12">
        <h2>View/Edit Student</h2>
        <?php echo $this->Form->create('Student'); ?>
        <div class='grid_6 alpha'>
        <?php
            echo $this->Form->input('id', array('placeholder' => 'Panther ID of student', 'label' => 'Student ID', 'type' => 'text'));
            echo $this->Form->input('last_name', array('placeholder' => 'Last name of student'));
            echo $this->Form->input('first_name', array('placeholder' => 'First name of student'));
            echo $this->Form->input('email', array('placeholder' => 'Panther Email of student'));
            echo $this->Form->input('pp_schedule', array('placeholder' => 'Comma delimited current/past classes e.g. 1001 U02,1002 U01', 'label' => 'Current/Past Classes (Catalog Section, Catalog Section)'));
            echo $this->Form->input('f_schedule', array('placeholder' => 'Future student schedule e.g. 1001 U02, ARCH U10', 'label' => 'Future Schedule (Catalog Section, Catalog Section)'));
            ?>
        </div>
        <div class='grid_6 omega'>
        <?php
            echo $this->Form->input('grade_level', 
                    array(
                        'options' => array(
                            '' => 'Please select current grade level...',
                            '0' => 'Incoming Freshman',
                            '1' => 'Freshman',
                            '2' => 'Sophomore',
                            '3' => 'Junior',
                            '4' => 'Senior'),
                        'label' => 'Current Grade Level'
                        ));
            echo $this->Form->input('term_entered', array('placeholder' => 'Term student is entering to e.g. Fall 2013'));
            echo $this->Form->input('status',
                    array(
                        'options' => array(
                            'Active' => 'Active', 
                            'Dropped' => 'Dropped', 
                            'Probation' => 'Probation', 
                            'Sabbatical' => 'Sabbatical', 
                            'Graduated' => 'Graduated', 
                            'Early Exit' => 'Early Exit')
                    ));
            echo $this->Form->input('notes', array('label' => 'Administrative Notes', 'placeholder' => 'Etcetera notes. Optional.'));
            echo $this->Form->end('Edit Student');
        ?>
        </div>
    </div>
</div>