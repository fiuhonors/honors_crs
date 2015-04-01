<div class="container_12">
<div class="grid_12">
    <h1>Students Registered in this class</h1>
    <table>
        <tbody>
            
           <?php
           echo $this->Html->tableCells(
                   array(
                       "Panther ID",
                       "Last Name",
                       "First Name",
                       "Email",
                       "Grade Level",
                       "Locked"
                   )
                   );
           
            foreach($students as $student){
                switch($student['Student']['grade_level']){
                    case 0:
                        $grade_level = "Incoming Freshman";
                        break;
                    case 1:
                        $grade_level = "Freshman";
                        break;
                    case 2:
                        $grade_level = "Sophomore";
                        break;
                    case 3:
                        $grade_level = "Junior";
                        break;
                    case 4:
                        $grade_level = "Senior";
                        break;
                }
                echo $this->Html->tableCells(
                        array(
                            $student['Student']['id'],
                            $student['Student']['last_name'],
                            $student['Student']['first_name'],
                            $student['Student']['email'],
                            $grade_level,
                            (strpos($student['Student']['f_schedule_lock'], $class['catalog']) !== false ? 1 : 0)
                        )
                        );
            }
            ?> 
        </tbody>
    </table>
    
</div>
</div>