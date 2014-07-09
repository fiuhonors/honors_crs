<div class='container_12'>
    <div class='grid_12'>
        <div class='grid_8 alpha'>
            <h2><?php echo $course_details['Course']['catalog'] . ' - Section ' . $course_details['Course']['section']; ?> </h2>
            <h3>Instructor: <?php echo $course_details['Course']['instructor']; ?></h3>
            <h3>Location: <?php echo $course_details['Course']['location']; ?></h3>
            <h3>Term: <?php echo $course_details['Course']['term']; ?></h3>
            <h3>Meeting Times: <?php echo $course_details['Course']['time']; ?></h3>
            <h3>Meeting Dates: <?php echo $course_details['Course']['date']; ?></h3>
        </div>
        <div class='grid_4 omega align_right'>
            <h3>Holds <b><?php echo $course_details['Course']['capacity']; ?></b>, 
                currently <b><?php echo $course_details['Course']['oc_capacity']; ?></b> students in class. </h3>
        </div>
    </div>
    
    <div class='grid_12'>
        <br/>
        <h3><?php echo utf8_encode($course_details['Course']['description']); ?></h3>
        <br/>
        <h3>Syllabus: <?php echo $course_details['Course']['uploaded_file']!='' ? $course_details['Course']['uploaded_file'] : 'No Syllabus provided'; ?></h3>
    </div>
    
    <div class='grid_12' id='calendarForClass'>
        
    </div>
</div>