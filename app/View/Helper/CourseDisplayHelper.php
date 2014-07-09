<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CourseDisplayHelper
 *
 * @author aparagas
 */
class CourseDisplayHelper extends AppHelper{
    
    var $helpers = array('Html', 'Form');
    
    function classesFormat($courses_array, $radio_set_name){
            if(count($courses_array) > 0){
               $course_radio = array();

               foreach($courses_array as $course=>$course_content){
                  $course_id = $course_content['Course']['id'] . ',' 
                           . $course_content['Course']['catalog'] . ',' 
                           . $course_content['Course']['section'];
                  $course_description
                    = $course_content['Course']['section'] . ": " 
                      . $course_content['Course']['instructor'] . "<br/>"
                      . $course_content['Course']['time'] . "<br/>"
                      . $course_content['Course']['location'];
                   $course_radio[$course_id] = $course_description;
               }
               return $this->Form->input($radio_set_name, array(
                   'before' => "<div class='grid_4'>",
                   'after' => "</div>",
                   'separator' => "</div><div class='grid_4'>",
                   'options' => $course_radio,
                   'type' => 'radio',
                   'legend' => false
               ));
            }
    }
    
}
