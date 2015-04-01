<div class='container_12'>
    <div class='grid_12'>
        <h2>Course Selection</h2>
        <br/>
        <h3>Honors seminar courses are listed below, along with descriptions. Students interested in Special Classes, such as ARCH and Study Abroad, must still select a seminar course in case we cannot successfully enroll you in those special courses.
        <br/>
        <br/>
        Additional questions or concerns may be addressed to the Honors College at 305-348-4100 or you can email Pablo Currea at jpcurrea@fiu.edu. 
	</h3>
        <br/> 
    </div>
    <?php 
    echo $this->Form->create('Course');
    foreach($course_types as $course_type){
        if(!empty(${$course_type})) {
    ?>
        <div class="grid_12">
            <hr>
        </div>
        <?php
            if (in_array(${$course_type.'_catalog'}, $student_schedule_lock)) {
        ?>
                <div class="container_12" style="margin:0;">
                    <div class="grid_12" style="margin-top:0;margin-bottom:0;">
                        <div class="error_noknob" style="margin-top:0;margin-bottom:0;">
                            You are currently locked into a class of Catalog <?php echo ${$course_type.'_catalog'}; ?>.
                        </div>
                    </div>
                </div>
        <?php
            }
        ?>
        <div class='grid_12'>
            <table>
                <tbody>
                <?php    
                    if(isset(${$course_type.'_label'})){
                        echo "<h3 class='bold'>${$course_type.'_label'} - choose one</h3>";
                    }
                    if (in_array(${$course_type.'_catalog'}, $student_schedule_lock)) {
                        echo $this->Form->input($course_type . '_message', array(
                            'label' => 'Reason for switching out of locked class',
                            'placeholder' => 
                                'You are locked into a class of catalog ' . ${$course_type.'_catalog'} . 
                                '. Should you choose to switch, please provide your reasoning here.',
                            'type' => 'textarea'
                        ));
                    }
                    echo $this->Html->tableCells(array('Term','Date','Time','Location','Instructor','Description'));
                    foreach(${$course_type} as $course){
                        $enrollmentElement = "";
                        if ($course['Course']['special'] == 1) {
                            $enrollmentElement = 
                                $this->Html->link('Special Class', 
                                    array('controller' => 'courses', 'action' => 'view', $course['Course']['id']),
                                    array('target' => '_blank')
                                );
                        } 
                        elseif ($course['Course']['capacity'] > $course['Course']['oc_capacity']) {
                            $enrollmentElement = 
                                $this->Form->input($course_type.'_chosen', array(
                                    'options' => array($course['Course']['id'] . ',' 
                                    . $course['Course']['catalog'] . ','
                                    . $course['Course']['section'] => ''),
                                    'type' => 'radio',
                                    'label' => false,
                                    'legend' => false,
                                    'hiddenField' => false
                                    )
                                );
                        }
                        if ($course['Course']['capacity'] > $course['Course']['oc_capacity'])
                            {
                            echo $this->Html->tableCells(
                                    array(
                                        $course['Course']['term'],
                                        $course['Course']['date'],
                                        $course['Course']['time'],
                                        $course['Course']['location'],
                                        $course['Course']['instructor'],
                                        $this->Html->link(($course['Course']['title'] == "" ? 'View More' : $course['Course']['title']), 
                                                array('controller' => 'courses', 'action' => 'view', $course['Course']['id']), array('target' => '_new')),
                                        $enrollmentElement
                                   )
                            );
                        }
                    }
               ?>
                </tbody>
            </table>
        </div>
    <?php 
        }
    } 
    ?>
    <div class='grid_12'>
    <?php
    if(!empty($course_types)){
        echo $this->Form->input('verification', array(
            'type' => 'checkbox',
            'label' => 'By checking this box and submitting this form, I authorize the Honors College to register me into an Honors Course for the following academic year and assume all related financial liabilities. I understand that I am responsible for notifying the Honors College, in writing, if I do not wish to be registered in an Honors course.'
        ));
        echo $this->Form->submit('Register for Classes');
    }
    ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>

<?php
/*
<div class="container_12">
    <div class="grid_8 push_2">
        <div class="error">
            Course Registration is now closed. For any inquiries or requests, please contact <br/>
            Pablo Currea at jpcurrea@fiu.edu. You may change your course choice after this <br/>
            semester by appointment.
        </div>
    </div>
</div>
*/
?>