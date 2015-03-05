<style>
    .warning{
        font-weight:bold;
        color:red;
        font-size:17;
    }
    .caution{
        font-weight:bold;
        color:orange;
        font-size:16;
    }
</style>
<div class="container_12">
<div class="grid_12">

    <table>
        <tbody>
            
           <?php
           echo $this->Html->tableCells(
                   array(
                       $this->Html->link("Course ID", array('controller'=>'courses', 'action'=>'enrollment', 'id', 'ASC')),
                       $this->Html->link("Catalog", array('controller'=>'courses', 'action'=>'enrollment', 'catalog', 'ASC')),
                       $this->Html->link("Section", array('controller'=>'courses', 'action'=>'enrollment', 'section', 'ASC')),
                       $this->Html->link("Instructor", array('controller'=>'courses', 'action'=>'enrollment', 'instructor', 'ASC')),
                       $this->Html->link("Title", array('controller'=>'courses', 'action'=>'enrollment', 'title', 'ASC')),
                       $this->Html->link("Capacity", array('controller'=>'courses', 'action'=>'enrollment', 'capacity', 'ASC')),
                       $this->Html->link("Occupied Capacity", array('controller'=>'courses', 'action'=>'enrollment', 'oc_capacity', 'ASC')),
                       "Actual OC",
                       "Status",
                       "Lock Class"
                   )
                   );
            
            foreach($courses as $course){
                $importance='';
                $realcount = $courses_realcount[$course['Course']['catalog']][$course['Course']['section']];
                if($realcount == ''){
                    $realcount = 0;
                }
                if($realcount < $course['Course']['oc_capacity']){
                    $importance = "orange";
                }else if($realcount > $course['Course']['capacity']){
                    $importance = "red";
                }
                echo $this->Html->tableCells(
                        array(
                            $course['Course']['id'],
                            $course['Course']['catalog'],
                            $course['Course']['section'],
                            $course['Course']['instructor'],
                            $course['Course']['title'],
                            $course['Course']['capacity'],
                            $course['Course']['oc_capacity'],
                            $this->Html->link($realcount, 
                                array('controller'=>'courses','action'=>'registrees',$course['Course']['catalog'],$course['Course']['section']), 
                                array('class'=>$importance)
                            ),
                            $course['Course']['capacity'] > $course['Course']['oc_capacity'] ? 'Open' : 'Closed',  
                            $this->Html->link("Lock/Unlock Class", 
                                array('controller'=>'courses','action'=>'lock_confirm',$course['Course']['catalog'],$course['Course']['section'])
                            )
                        )
                        );
            }
            ?> 
        </tbody>
    </table>
    
</div>
</div>