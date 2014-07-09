<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
                <?php 
                    if($title_for_layout != ''){
                       echo $title_for_layout;
                    }else{
                        echo "Honors CRS Admin";
                    }
                ?>
	</title>
	<?php
                echo $this->fetch('meta');
                echo $this->Html->css(array('format', 'jquery_ui'));
                echo $this->Html->script(array('jquery', 'jquery_ui'));
	?>
</head>
<body>
        <div class='header'>
		<div class='container_12'>
			<div class='grid_3'>
				<?php
                                echo $this->Html->link(
					'<h1>Honors College<small>Course Registration System</small></h1>',
                                        array('controller' => 'administrators', 'action' => 'dashboard'),
                                        array('escape' => false)
                                        );
				?>
			</div>
			<ul class='grid_9 menu'>
				<li class='grid_2 alpha modernpics' data-icon='g'>Students
                                        <ul>
						<li>
                                                    <?php echo $this->Html->link('Add Students',
                                                            array(
                                                               'controller' => 'students',
                                                               'action' => 'add'
                                                           ));
                                                    ?>
                                                </li>
                                                <li>
                                                    <?php echo $this->Html->link('Edit Students',
                                                            array(
                                                                'controller' => 'students',
                                                                'action' => 'search'
                                                            ));
                                                     ?>
                                                </li>
					</ul>
				</li>
				<li class='grid_2 modernpics' data-icon='p'>Classes
                                        <ul>
                                                <li>
                                                    <?php echo $this->Html->link('Add Classes',
                                                            array(
                                                                'controller' => 'courses',
                                                                'action' => 'add'
                                                            ));
                                                    ?>
                                                </li>
						<li>
                                                    <?php echo $this->Html->link('Edit Classes',
                                                            array(
                                                                'controller' => 'courses',
                                                                'action' => 'search'
                                                            ));
                                                    ?>
                                                </li>
                                        </ul>
                                </li>
				<li class='grid_2 modernpics' data-icon='Y'>Instructors
                                        <ul>
                                                <li>
                                                    <?php echo $this->Html->link('Add Instructors',
                                                            array(
                                                                'controller' => 'instructors',
                                                                'action' => 'add'
                                                            ));
                                                    ?>
                                                </li>
                                                <li>
                                                    <?php echo $this->Html->link('Edit Instructors',
                                                            array(
                                                                'controller' => 'instructors',
                                                                'action' => 'search'
                                                            ));
                                                    ?>
                                                </li>
                                        </ul>
                                </li>
				<li class='grid_2 modernpics' data-icon='v'>Other
                                    <ul>
                                        <li>Appointment</li>
                                        <li>Calendar</li>
                                        <li>
                                            <?php echo $this->Html->link('Enrollment',
                                                            array(
                                                                'controller' => 'courses',
                                                                'action' => 'enrollment'
                                                            ));
                                                    ?>
                                        </li>
                                    </ul>
                                </li>
				<li class='grid_1 omega modernpics'>
                                    <?php echo $this->Html->link('Logout',
                                            array(
                                               'controller' => 'administrators',
                                               'action' => 'logout'
                                            ));
                                    ?>
                                </li>
			</ul>
		</div>
	</div>
	<div class='container_12'>
			<?php echo $this->Session->flash(); ?>
	</div>
        <?php echo $this->fetch('content'); ?>
        <?php echo $this->element('sql_dump');?>
</body>
</html>
