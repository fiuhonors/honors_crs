<div class="container_12">
    <div class="grid_7">
        <h2>Search for Course</h2>
        <h3>
            To search for a course, please input the course id, catalog number,
             or class instructor. Results will automatically populate below.
        </h3>
    </div>
    <div class="grid_5">
        <?php
            echo $this->Form->create('Course', array('type' => 'get', 'class' => 'inline_elements'));
            echo $this->Form->label('Course.search', 'Search', array(
                'class' => 'inline'
            ));
            echo $this->Form->input('search', array(
                'label' => false,
                'class' => 'inline',
                'placeholder' => "Search by Course ID, Catalog#, or Instructor."
            ));
            echo $this->Form->end('Search');
        ?>
    </div>
</div>

<div class="container_12">
    <hr/>
</div>

<div class="container_12">
    <div class="grid_12">
    <?php
        if(!empty($courses)){
    ?>

        <table>
            <tbody>
                <tr>
                    <td>Course ID</td>
                    <td>Term</td>
                    <td>Section</td>
                    <td>Catalog</td>
                    <td>Location</td>
                    <td>Instructor</td>
                    <td>Meeting Date</td>
                    <td>Meeting Time</td>
                    <td>View</td>
                </tr>
    <?php
        foreach($courses as $course){
            echo "<tr>";
            
            $course_id = $course['Course']['id'];
            $course_term = $course['Course']['term'];
            $course_section = $course['Course']['section'];
            $course_catalog = $course['Course']['catalog'];
            $course_location = $course['Course']['location'];
            $course_instructor = $course['Course']['instructor'];
            $course_date = $course['Course']['date'];
            $course_time = $course['Course']['time'];
            echo"
                <td>$course_id</td>
                <td>$course_term</td>
                <td>$course_section</td>
                <td>$course_catalog</td>
                <td>$course_location</td>
                <td>$course_instructor</td>
                <td>$course_date</td>
                <td>$course_time</td>
                <td>";
            
            echo $this->Html->link('View', array(
                'controller' => 'courses',
                'action' => 'edit',
                $course_id
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