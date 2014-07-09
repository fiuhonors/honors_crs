<div class='container_12'>
    <div class='grid_12'>
        <?php

        if(!empty($future_courses)){
        ?>
        
            <h2>Future Class Cart</h2>
            <table>
                <tbody>
                <?php
                    echo $this->Html->tableCells(array('ID','Term','Section','Catalog','Date','Time','Location','Instructor','Description'));
                    foreach($future_courses as $course){
                        echo $this->Html->tableCells(array(
                            array(
                                            $course['Course']['id'],
                                            $course['Course']['term'],
                                            $course['Course']['section'],
                                            $course['Course']['catalog'],
                                            $course['Course']['date'],
                                            $course['Course']['time'],
                                            $course['Course']['location'],
                                            $course['Course']['instructor'],
                                            $this->Html->link('View More', 
                                                    array('controller' => 'courses', 'action' => 'view', $course['Course']['id']), array('target' => '_new'))
													/*,
                                            $this->Html->link('Remove',
                                                    array('controller' => 'students', 'action' => 'deleteFromSchedule', $course['Course']['catalog'], $course['Course']['section'])) */

                        )));
                    }
                ?>
                </tbody>
            </table>
            <br/><br/>
       <?php
         }
        ?>
    </div>
    <div class='grid_9'>
        <h2>Welcome to the Honors College Course Selection System</h2>
        <br/>
        <h3>To begin selecting your Honors College courses, click on the button in the menu bar above: CLASSES.
        </h3>
        <br/>
         <h3>You will be able to select from courses in your grade level (i.e. if you are a sophomore, you will see the junior options, etc.).
         </h3>
        <br/>
        <h3>Problems? Contact Alastair Paragas at <u>alastairparagas@gmail.com</u>, Robin Mayrand at <u>rcmayrand@outlook.com </u> or Umer Rahman at <u>urahman@fiu.edu</u>.
        </h3>
    </div>
</div>