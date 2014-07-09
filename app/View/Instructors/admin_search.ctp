<div class="container_12">
    <div class="grid_7">
        <h2>Search for Instructor</h2>
        <h3>
            To search for a course, please input the course id, catalog number,
             or class instructor. Results will automatically populate below.
        </h3>
    </div>
    <div class="grid_5">
        <?php
            echo $this->Form->create('Instructor', array('type' => 'get', 'class' => 'inline_elements'));
            echo $this->Form->label('Instructor.search', 'Search', array(
                'class' => 'inline'
            ));
            echo $this->Form->input('search', array(
                'label' => false,
                'class' => 'inline',
                'placeholder' => "Search by Panther ID or Name"
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
        if(!empty($instructors)){
    ?>

        <table>
            <tbody>
                <tr>
                    <td>Panther ID</td>
                    <td>First Name</td>
                    <td>Last Name</td>
                    <td>Email</td>
                    <td>Position</td>
                    <td>Address</td>
                    <td>View</td>
                </tr>
    <?php
        foreach($instructors as $instructor){
            echo "<tr>";
            
            $instructor_id = $instructor['Instructor']['id'];
            $instructor_firstname = $instructor['Instructor']['first_name'];
            $instructor_lastname = $instructor['Instructor']['last_name'];
            $instructor_email= $instructor['Instructor']['email'];
            $instructor_position = $instructor['Instructor']['position'];
            $instructor_address = $instructor['Instructor']['address'];
            echo"
                <td>$instructor_id</td>
                <td>$instructor_firstname</td>
                <td>$instructor_lastname</td>
                <td>$instructor_email</td>
                <td>$instructor_position</td>
                <td>$instructor_address</td>
                <td>";
            
            echo $this->Html->link('View', array(
                'controller' => 'instructors',
                'action' => 'edit',
                $instructor_id
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