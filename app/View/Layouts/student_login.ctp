<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
                <?php 
                    if($title_for_layout != ''){
                       echo $title_for_layout;
                    }else{
                        echo "Honors CRS Student";
                    }
                ?>
	</title>
	<?php
		echo $this->fetch('meta');
                echo $this->Html->css(array('format', 'jquery_ui'));
                echo $this->Html->script(array('jquery', 'jquery_ui'));
	?>
</head>

<div class='container_12'>
        <?php echo $this->fetch('content'); ?>
        <div class='grid_6 prefix_3 suffix_3'>
            <?php echo $this->Session->flash(); ?>
        </div>
        <div class='grid_6 prefix_3 suffix_3'>
            <div class='error_noknob'>
                CRS will open for those who have not selected a course on May 1, 2014. The classes will be put on your schedule (my.fiu.edu) by June 23, 2014.
            </div>
        </div>  
</div>

</body>
</html>