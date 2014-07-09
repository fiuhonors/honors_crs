<div class="container_12">
    <div class="grid_7">
        <h2>Search for Student</h2>
        <h3>
            To search for a student, please input their full name and/or
            Panther ID. Results will automatically populate below.
        </h3>
    </div>
    <div class="grid_5">
        <?php
            echo $this->Form->create('Student', array('type' => 'get', 'class' => 'inline_elements'));
            echo $this->Form->label('Student.search', 'Search', array(
                'class' => 'inline'
            ));
            echo $this->Form->input('search', array(
                'label' => false,
                'class' => 'inline',
                'placeholder' => "Search Panther ID or Student's name."
            ));
            echo $this->Form->end('Search');
        ?>
    </div>
</div>

<div class="container_12">
    <hr/>
</div>

<div class="container_12">
    <div class="grid_10 push_1">
    <?php
        if(!empty($students)){
    ?>

        <table>
            <tbody>
                <tr>
                    <td>Panther ID</td>
                    <td>Name</td>
                    <td>Grade Level</td>
                    <td>Term Entered</td>
                    <td>Email</td>
                    <td>Status</td>
                    <td>View/Edit</td>
                </tr>
    <?php
        foreach($students as $student){
            echo "<tr>";
            
            $panther_id = $student['Student']['id'];
            $student_name = $student['Student']['first_name'] . " " . $student['Student']['last_name'];
            $grade_level = $student['Student']['grade_level'];
            $term_entered = $student['Student']['term_entered'];
            if($grade_level == '0'){
                $grade_level = 'Incoming Freshman';
            }else if($grade_level == '1'){
                $grade_level = 'Freshman';
            }else if($grade_level == '2'){
                $grade_level = 'Sophomore';
            }else if($grade_level == '3'){
                $grade_level = 'Junior';
            }else if($grade_level == '4'){
                $grade_level = 'Senior';
            }
            $email = $student['Student']['email'];
            $status = $student['Student']['status'];
            echo"
                <td>$panther_id</td>
                <td>$student_name</td>
                <td>$grade_level</td>
                <td>$term_entered</td>
                <td>$email</td>
                <td>$status</td>
                <td>";
            
            echo $this->Html->link('View', array(
                'controller' => 'students',
                'action' => 'edit',
                $panther_id
            ));
            
            echo "
                    </td></tr>
            ";
        }
    ?>
            </tbody>
        </table>

    <?php
        }else{
    ?>


    <?php
        }
    ?>
    </div>
</div>