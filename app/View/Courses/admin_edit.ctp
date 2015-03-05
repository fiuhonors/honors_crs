<script type='text/javascript'>
    $(function(){
        $('#instructorAutoComplete').autocomplete({
            source: "<?php echo $this->Html->url(array(
                'controller' => 'instructors',
                'action' => 'autocomplete.json'
            )); ?>"
        });
        $('#CourseDateFrom').datepicker({
            defaultDate: "+1w",
            changeMonth: true
        });
        $('#CourseDateTo').datepicker({
            defaultDate: "+1w",
            changeMonth: true
        });
    });
</script>

<div class="container_12">
    <div class="grid_12">
        <h2> Add Courses </h2>
        <?php echo $this->Form->create('Course', array('type' => 'file')); ?>
        <div class='grid_6 alpha'>
        <?php
            echo $this->Form->input('id', array(
                'type' => 'text',
                'label' => 'Class ID',
                'placeholder' => '5-digit Class ID'
            ));
            echo $this->Form->input('term', array(
                'label' => 'Class Term',
                'placeholder' => 'Term this class runs for e.g. Fall 2013, Summer 2014'
            ));
            echo $this->Form->input('section', array(
               'label' => 'Class Section',
                'placeholder' => 'Class Section e.g. U02, U10'
            ));
            echo $this->Form->input('catalog', array(
               'label' => 'Class Catalog',
                'placeholder' => 'Class Catalog e.g. 1001, 1002, Arch, StudyAbroad Vietnam'
            ));
            echo $this->Form->label('Meeting Dates');
            echo $this->Form->input('date_from', array(
                'label' => false,
                'class' => 'inline',
                'placeholder' => 'Dates this class will meet e.g. 09/20/13-12/10/13'
            ));
            echo $this->Form->input('date_to', array(
                'label' => false,
                'class' => 'inline',
                'placeholder' => 'Dates this class will meet e.g. 09/20/13-12/10/13'
            ));
            echo $this->Form->input('time', array(
                'label' => 'Meeting Times',
                'placeholder' => 'Times/Days class will meet e.g. M10:15AM-11:15AM, W2:00PM-3:15PM'
            ));
            echo $this->Form->input('syllabus', array(
               'label' => 'Upload Syllabus Document',
                'type' => 'file'
            ));
            echo $this->Form->input("uploaded_file");
            
            
        ?>
        </div>
        <div class='grid_6 omega'>
        <?php
            echo $this->Form->input('title', array(
                'label' => 'Class Title',
                'placeholder' => 'Title from the syllabus, e.g. The Middle Circle'
            ));
            echo $this->Form->input('location', array(
                'label' => 'Meeting Location',
                'placeholder' => 'Location of this class e.g. GC203, SIPA125'
            ));
            echo $this->Form->input('instructor', array(
                'id' => 'instructorAutoComplete',
                'label' => 'Class Instructor',
                'placeholder' => 'Professor for the class e.g. Rahman, Bailey'
            ));
            echo $this->Form->input('description', array(
                'label' => 'Class Description',
                'placeholder' => 'Description for the class.',
                'type' => 'textarea'
            ));
            echo $this->Form->input('capacity', array(
                'placeholder' => 'Capacity of students this class can hold. e.g. 10, 20' 
            ));
            echo $this->Form->input('oc_capacity', array(
                'label' => 'Students Enrolled',
                'placeholder' => 'Enrollment of students in this class. e.g. 10, 20' 
            ));
            echo $this->Form->input('add_students', array(
               'placeholder' => 'List of student I.D.s to register in this class, e.g. 1234567,7654321',
               'type' => 'text' 
            ));
            echo $this->Form->end('Edit Class');
        ?>
        </div>
    </div>
</div>