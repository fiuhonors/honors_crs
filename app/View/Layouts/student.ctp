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
<body>
        <div class='header'>
		<div class='container_12'>
			<div class='grid_3'>
				<?php
                                echo $this->Html->link(
					'<h1>Honors College<small>Course Registration System</small></h1>',
                                        array('controller' => 'students', 'action' => 'dashboard'),
                                        array('escape' => false)
                                        );
				?>
			</div>
			<ul class='grid_9 menu'>
				<li class='grid_2 alpha modernpics' data-icon='a'>
                                                    <?php 
                                                    echo $this->Html->link('Dashboard',
                                                            array(
                                                                'controller' => 'students',
                                                                'action' => 'dashboard'
                                                            ));
                                                    ?>
                                </li>
                                <li class='grid_2 modernpics' data-icon='Y'>
                                                    <?php
                                                       echo $this->Html->link('Classes',
                                                            array(
                                                                'controller' => 'courses',
                                                                'action' => 'register'
                                                            ));
                                                    ?>
                                        
                                </li>
				<li class='push_2 grid_3 omega modernpics' data-icon='f'>Hello, <?php echo $this->Session->read('Auth.User.first_name'); ?>
 !                                    <ul>
                                         <li>
                                             <?php echo $this->Html->link('Logout',
                                               array(
                                                    'controller' => 'students',
                                                    'action' => 'logout'
                                                ));
                                             ?>
                                        </li>
                                    </ul>
                                </li>
			</ul>
		</div>
	</div>
	<div class='container_12'>
            <div class='grid_12'>
			<?php echo $this->Session->flash(); ?>
            </div>
	</div>
        <?php echo $this->fetch('content'); ?>
</body>
</html>
