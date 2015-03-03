<div class="container_12">
    <div class="grid_6">
        <h2>Lock Class</h2>
        <br>
        <h3>
            Are you sure you want to proceed locking this class? 
            <br><br>
            Locking this class locks all the current students enrolled into this class so that they cannot switch to another class that has the same catalog number.
        </h3>
        <br><br>
        <a href="<?php echo Router::url(array('controller'=>'courses', 'action'=>'admin_lockAction', $course_catalog, $course_section, "true")); ?>"><button>Lock this class</button></a>
    </div>
    <div class="grid_6">
        <h2>Unlock Class</h2>
        <br>
        <h3>
            Are you sure you want to proceed unlocking this class?
            <br><br>
            Unlocking this class unlocks all of the current students enrolled into this class, allowing them to switch to another class that has
            the same catalog number.
        </h3>
        <br><br>
        <a href="<?php echo Router::url(array('controller'=>'courses', 'action'=>'admin_unlockAction', $course_catalog, $course_section, "true")); ?>"><button>Unlock this class</button></a>
    </div>
</div>