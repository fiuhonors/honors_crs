<?php

/**
 * Description of CoursesController
 *
 * @author Alastair
 */

class CoursesController extends AppController {

    var $layout = 'admin';
    var $helpers = array('CourseDisplay');
    
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    
    public function admin_add() {

        if (!empty($this->request->data)) {
            $syllabus_file = $this->request->data['Course']['syllabus']['tmp_name'];
            $syllabus_file_type = $this->request->data['Course']['syllabus']['type'];

            if (!empty($syllabus_file) && is_uploaded_file($syllabus_file)) {
                if ($syllabus_file_type == 'application/pdf') {
                    $syllabus_file_ending = ".pdf";
                } else if ($syllabus_file_type == 'application/msword') {
                    $syllabus_file_ending = ".doc";
                } else if ($syllabus_file_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                    $syllabus_file_ending = ".docx";
                }

                $class_catalog = $this->request->data['Course']['catalog'];
                $class_section = $this->request->data['Course']['section'];
                $syllabus_file_location = WWW_ROOT . 'files' . DS . str_replace(' ', '', $class_catalog) . '_' . $class_section . $syllabus_file_ending;

                if (!move_uploaded_file($syllabus_file, $syllabus_file_location)) {
                    $this->Session->setFlash("File cannot be uploaded for some reason. Please try uploading later.");
                    return false;
                } else {
                    $this->request->data['Course']['uploaded_file'] = $syllabus_file_location;
                }
            }

            // Store date_from and date_to inputs as date
            $this->request->data['Course']['date'] = $this->request->data['Course']['date_from'] . "-" . $this->request->data['Course']['date_to'];

            if ($this->Course->saveAll($this->request->data)) {
                unset($this->request->data);
                $this->Session->setFlash("The Course has been added succesfully.", 'default', array('class' => 'success'));
            } else {
                if (isset($this->Course->validationErrors['date'])) {
                    $this->Course->validationErrors['date_from'] = $this->Course->validationErrors['date'];
                    $this->Course->validationErrors['date_to'] = $this->Course->validationErrors['date'];
                }
                $this->Session->setFlash("Cannot validate. Check errors below.", 'default', array('class' => 'error'));
            }
        }
        
    }

    
    public function admin_addBulk() {

        $file = $this->request->data['Course']['file']['tmp_name'];
        $readCSVdata = $this->Course->readCsvData($file, 'all');

        if (!isset($file)) {
            $this->Session->setFlash("No file uploaded.", 'default', array('class' => 'error'));
            return $this->redirect(array('controller' => 'courses', 'action' => 'add'));
        }

        if (!$readCSVdata) {
            $this->Session->setFlash("Something went wrong with the request.", 'default', array('class' => 'error'));
            return $this->redirect(array('controller' => 'courses', 'action' => 'add'));
        }

        if ($this->Course->saveAll($readCSVdata)) {
            $this->Session->setFlash("Mass Add has been processed succesfully!", 'default', array('class' => 'success'));
            return $this->redirect(array('controller' => 'courses', 'action' => 'add'));
        } else { 
           $inputErrors = $this->Course->csvErrorsAsString();  
            $this->Session->setFlash("Something went wrong with the request. CSV data inputs are invalid. <br/> $inputErrors", 'default', array('class' => 'error'));
            return $this->redirect(array('controller' => 'courses', 'action' => 'add'));
        }
        
    }
    
    
    public function admin_enrollment(){
        $students = $this->Course->Student->find('all');
        $courses_list = array();
        foreach($students as $student){
            $student_courses = unserialize($student['Student']['f_schedule']);
            foreach($student_courses as $course_catalog => $course_section){
                $courses_list[$course_catalog][$course_section] += 1;
            }
        }
        $this->set('courses', $this->Course->find('all', array('order' => array('Course.catalog ASC', 'Course.section ASC'))));
        $this->set('courses_realcount', $courses_list);
    }
    
    public function admin_registrees($course_catalog,$course_section){
        $students = $this->Course->Student->find('all');
        $students_list = array();
        foreach($students as $student){
            $student_courses = unserialize($student['Student']['f_schedule']);
            if($student_courses[$course_catalog] == $course_section){
                $students_list[] = $student;
            }
        }
        $this->set('students', $students_list);
    }

    
    public function admin_search() {

        if (!empty($this->request->query['search'])) {
            $searchString = $this->request->query['search'];
            
            if (is_numeric($searchString)) {
                $course_results = $this->Course->findAllById($searchString);
                if (count($course_results) == 0) {
                    $course_results = $this->Course->findAllByCatalog($searchString);
                }
            } else {
                $course_results = $this->Course->find('all', array(
                    'conditions' => array('Course.instructor LIKE' => "%$searchString%")
                ));
                if (count($course_results) == 0) {
                    $course_results = $this->Course->find('all', array(
                        'conditions' => array('Course.catalog LIKE' => "%$searchString%")
                    ));
                }
            }

            $this->set('courses', $course_results);
        }
        
    }

    
    public function admin_edit($id = NULL) {

        if (empty($id)) {
            $this->Session->setFlash("No ID was provided to view/edit!", "default", array(
                'class' => 'error'
            ));
        }

        if ($this->Course->findById($id)) {
            if (!$this->request->data) {
                $course_result = $this->Course->findById($id);
                $this->request->data = $course_result;
                
                list($this->request->data['Course']['date_from'], $this->request->data['Course']['date_to']) = explode("-", $this->request->data['Course']['date']);
            } else {
                $syllabus_file = $this->request->data['Course']['syllabus']['tmp_name'];

                if (!empty($syllabus_file) && is_uploaded_file($syllabus_file)) {
                    $syllabus_file_type = $this->request->data['Course']['syllabus']['type'];
                    if ($syllabus_file_type == 'application/pdf') {
                        $syllabus_file_ending = ".pdf";
                    } else if ($syllabus_file_type == 'application/msword') {
                        $syllabus_file_ending = ".doc";
                    } else if ($syllabus_file_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                        $syllabus_file_ending = ".docx";
                    }

                    $class_catalog = $this->request->data['Course']['catalog'];
                    $class_section = $this->request->data['Course']['section'];
                    $syllabus_file_location = WWW_ROOT . 'files' . DS . str_replace(' ', '', $class_catalog) . '_' . $class_section . $syllabus_file_ending;

                    if (!move_uploaded_file($syllabus_file, $syllabus_file_location)) {
                        $this->Session->setFlash("File cannot be uploaded for some reason. Please try uploading later.", 'default', array('class' => 'error'));
                        return false;
                    } else {
                        $this->request->data['Course']['uploaded_file'] = $syllabus_file_location;
                    }
                }

                $this->request->data['Course']['date'] = $this->request->data['Course']['date_from'] . "-" . $this->request->data['Course']['date_to'];

                if ($this->Course->saveAll($this->request->data)) {
                    $this->Session->setFlash('Course edit has been saved.', 'default', array('class' => 'success'));
                    return $this->redirect(array('controller' => 'courses', 'action' => 'search'));
                } else {
                    $this->Session->setFlash('Cannot validate. Check errors below.', 'default', array('class' => 'error'));
                }
            }
        }
        
    }
    
    
    public function view($course_id){
        $this->layout = "student";
        if(!is_numeric($course_id)){
            $this->Session->setFlash("Course ID provided was invalid.", 'default', array('class' => 'error'));
            return false;
        }
        
        $course_details = $this->Course->findById($course_id);
        if(empty($course_details)){
            $this->Session->setFlash("Course with that ID does not exist in the system.", 'default', array('class' => 'error'));
            return false;
        }
        
        list($course_details['Course']['date-from'], $course_details['Course']['date_to']) = $course_details['Course']['date'];
        $this->set('course_details', $course_details);
        
    }
    
        
    public function register() {
		
        $this->layout = "student";
        // Check if student is already registered.
        $student_data = $this->Course->Student->findById($this->Auth->user('id'));
        $student_schedule = unserialize($student_data['Student']['f_schedule']);
        $student_schedule = empty($student_schedule) ? array() : $student_schedule;
        $this->set('student_term_entered', $student_data['Student']['term_entered']);
		$this->set('student_schedule', $student_schedule);
		
        // Set this to global scope so they're accessible to whole method.
        $course_choices = array();
        $course_choices_labels = array(
            '1001' => 'IDH 1001-1002 Classes (Required)',
            '1931' => 'IDH 1931: First-Year (Required - If you have equal to/greater than 60 credits, contact Administration)',
            '2003' => 'IDH 2003-2004 Classes (Required)',
            '3034' => 'IDH 3034-3035 Classes (Required)',
            '4007' => 'IDH 4007-4008 Classes (Required)',
            'SA' => 'Study Abroad Options (Optional)',
            'ARCH' => 'Advanced Research and Creativity in Honors (Optional)'
        );
        // Default configuration. Required courses must go first.
        $course_types = array('required_courses', 'optional_courses', 'optional_courses2');
        
        // Set Model recursive to just Course Table of database
        $this->Course->recursive = -1;
        
        // Set Course Choices
        if($this->Auth->user('grade_level') == 0) {
            $course_choices = array('1001','1931','SA');
            $course_types = array('required_courses', 'required_courses2', 'optional_courses');
        }elseif($this->Auth->user('grade_level') == 1) {
            $course_choices = array('2003','ARCH','SA');
        }elseif($this->Auth->user('grade_level') == 2) {
            $course_choices = array('3034','ARCH','SA');
        }elseif($this->Auth->user('grade_level') == 3) {
            $course_choices = array('4007','ARCH','SA');
        }elseif($this->Auth->user('grade_level') == 4) {
            $course_choices = array('4007','ARCH','SA');
        }
        
        $this->set('course_types', $course_types);
        
        // Loop through course types and get appropriate classes
        for($i=0; $i<count($course_types); $i++){
            $this->set($course_types[$i], $this->Course->find('all',
                array(
                    'conditions' => array('Course.catalog' => array($course_choices[$i])),
                    'order' => array('Course.location' => 'DESC')
                ))
            );
            $this->set($course_types[$i].'_label', $course_choices_labels[$course_choices[$i]]);
        }
            
        if ($this->request->is('post')) {
            if(empty($this->request->data['Course']['verification'])){
                $this->Session->setFlash("You must accept the Class Registration Terms.", 'default', array('class' => 'error'));
                return false;
            }
            
            $student_schedule_new = $student_schedule; // Holds Student's Course Choices.
            $course_errors = ''; // Holds any errors with registration.
            $course_successes = ''; // Holds information success messages for registration.
            // Make sure all required courses were filled
            foreach($course_types as $course_type){
                // Increment Class's Occupied Capacity.
                $course_chosen_identifier = $this->request->data['Course'][$course_type.'_chosen'];
                
                /* If the Course was a required course, check if they already have a required course in their schedule. If not,
                 * stop code execution and ask that they register for one ASAP!
                 */
                if(strpos($course_type, 'required') !== false && empty($course_chosen_identifier)){
                    // If there is no class in student schedule, student hasn't signed up for a registered class!
                    if(empty($student_schedule)){
                        $this->Session->setFlash("A required class must be chosen.", 'default', array('class' => 'error'));
                        $this->Auth->redirect(array('controller' => 'courses', 'action' => 'register'));
                        return false;
                    }
                }
            }
            
            // Get each course type set
            foreach($course_types as $course_type){
                // Increment Class's Occupied Capacity.
                $course_chosen_identifier = $this->request->data['Course'][$course_type.'_chosen'];
                
                if(!empty($course_chosen_identifier)){
                    list($course_chosen_id, $course_chosen_catalog, $course_chosen_section) = explode(',', $course_chosen_identifier);
                    if(is_numeric($course_chosen_id) && $course_chosen_id > 0){
                        // If Course with same catalog and section already exists in student's schedule, do not add!
                        if($student_schedule[$course_chosen_catalog] == $course_chosen_section){
                            $course_errors .= "That course is already in your cart. <br/>";
                        }
                        
                        // If the Course exists, and there are still seats, add student to class.
                        $course_sql = $this->Course->updateAll(
                                array('Course.oc_capacity' => 'Course.oc_capacity + 1'),
                                array('Course.id' => $course_chosen_id, 'Course.capacity > Course.oc_capacity')
                        );
                        // If Course was updated, add Course to student's schedule, or else, pass error message.
                        if($this->Course->getAffectedRows() > 0){
                            // If Student registered for a class with same Catalog before, unregister him/her there and replace
                            if(array_key_exists($course_chosen_catalog, $student_schedule_new)){
                                $course_successes .= "$course_chosen_catalog - Section $student_schedule[$course_chosen_catalog] has been removed "
                                        . "and $course_chosen_catalog - Section $course_chosen_section has been added to your course cart. <br/>";
                                $this->Course->updateAll(
                                        array('Course.oc_capacity' => 'Course.oc_capacity - 1'),
                                        array('Course.catalog' => $course_chosen_catalog, 'Course.section' => $student_schedule[$course_chosen_catalog])
                                );
                                $student_schedule_new[$course_chosen_catalog] = $course_chosen_section;
                            }else{
                                $course_successes .= "$course_chosen_catalog - Section $course_chosen_section was added to your course cart.<br/>";
                                $student_schedule_new[$course_chosen_catalog] = $course_chosen_section;
                            }
                        }else{
                            $course_errors .= "Failed to register for $course_chosen_catalog - Section $course_chosen_section class. Capacity Full <br/>";
                        }
                    }
                }
                            
            }
            
            // Store Schedule Array of Student to database
            $this->Course->Student->updateAll(
                    array('Student.f_schedule' => "'" . serialize($student_schedule_new) . "'"),
                    array('Student.id' => $this->Auth->user('id'))
            );
            
            if(empty($course_errors)){
                $this->Session->setFlash($course_successes, 'default', array('class' => 'success'));
            }else{
                $this->Session->setFlash($course_errors, 'default', array('class' => 'error'));
            }
            
            // Avoid browser refreshing and reposting POST data!
            $this->redirect(array('controller' => 'courses', 'action' => 'register'));
        }
        
    }

}
?>
