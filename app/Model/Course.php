<?php/* * To change this template, choose Tools | Templates * and open the template in the editor. *//** * Description of Course * * @author Alastair */class Course extends AppModel{        public $belongsTo = array(        'Instructor' => array(            'className' => 'Instructor',            'foreignKey' => 'id'        ),        'Student' => array(            'className' => 'Student',            'foreignKey' => 'id'        )    );           var $validate = array(          'id' => array(             'notEmpty' => array(                'rule' => 'notEmpty',                'message' => 'Class ID cannot be empty.'            ),            'numeric' => array(                'rule' => 'numeric',                'message' => 'Class ID must be numeric.'            ),            'minLength' => array(                'rule' => array('minLength', 1),                'message' => 'Class ID must be at least 1 digit long.'            ),            'maxLength' => array(                'rule' => array('maxLength', 5),                'message' => 'Class ID must be 5 digits long.'            )        ),        'term' => array(            'notEmpty' => array(                'rule' => 'notEmpty',                'message' => 'Term must not be empty.'            ),            'custom' => array(                'rule' => array('custom', '/((?:[a-z][a-z]+))(\\s+)((?:(?:[1]{1}\\d{1}\\d{1}\\d{1})|(?:[2]{1}\\d{3})))(?![\\d])/is'),                'message' => 'Must be in the format of Semester Year e.g. Fall 2013'            )        ),        'section' => array(            'notEmpty' => array(                'rule' => 'notEmpty',                'message' => 'Section Number cannot be empty.'            ),            'alphaNumeric' => array(                'rule' => 'alphaNumeric',                'message' => 'Section Number must be alphanumeric.'            )        ),        'catalog' => array(            'notEmpty' => array(                'rule' => 'notEmpty',                'message' => 'Catalog Number cannot be empty.'            )        ),        'date' => array(            'notEmpty' => array(                'rule' => 'notEmpty',                'message' => 'Meeting Dates cannot be empty.'            ),            'custom' => array(                'rule' => array('custom', '/(\\d)(\\d)(\\/)(\\d)(\\d)(\\/)(\\d)(\\d)(\\d)(\\d)(-)(\\d)(\\d)(\\/)(\\d)(\\d)(\\/)(\\d)(\\d)(\\d)(\\d)/is'),                'message' => 'Meeting Date must be in format mm/dd/yyyy, delimited by dash (-).'            )        ),        'time' => array(            'notEmpty' => array(                'rule' => 'notEmpty',                'message' => 'Meeting Times cannot be empty.'            ),            'meetingTimesValidate' => array(                'rule' => 'meetingTimesValidate',                'message' => 'Meeting Time must be formatted e.g. M10:00AM-12:50PM.'            )        ),        'location' => array(            'notEmpty' => array(                'rule' => 'notEmpty',                'message' => 'Meeting Location cannot be empty.'            )        ),        'instructor' => array(            'notEmpty' => array(                'rule' => 'notEmpty',                'message' => 'Instructor for class must be specified.'            ),            'instructorExists' => array(                'rule' => 'instructorExists',                'message' => 'Instructor for the course must exist.'            )        ),        'capacity' => array(            'notEmpty' => array(                'rule' => 'notEmpty',                'message' => 'Capacity for class cannot be empty.'            ),            'numeric' => array(                'rule' => 'numeric',                'message' => 'Input must only be a number.'            )        )    );            public function instructorExists($instructorName){                if(!isset($instructorName['instructor'])){            return false;        }            if(is_array($instructorName['instructor'])){           return false;                   }                return $this->Instructor->instructorExists($instructorName['instructor']);    }        public function meetingTimesValidate($meetingTimes){         $meetingTimes = explode(" ", trim($meetingTimes['time']));                foreach($meetingTimes as $meetingTime){            if(strlen(trim($meetingTime)) > 0){                $match_test = (preg_match('/((?:[a-z]+))(\\d+)(:)(\\d+)((?:[a-z][a-z]+))(-)(\\d+)(:)(\\d+)((?:[a-z][a-z]+))/is', $meetingTime) == 1);                if($match_test == false){                    return false;                }            }        }        return true;    }                /**     * Actually registers the student. Done after the course availability check     * @param string comma-delimited list of course id, catalog, and section     * @param array student's future schedule as compiled     * @return array array on success of new student's future schedule     */    public function courseRegister($course_info, $course_list){                            $course_id = $course_info[0];        $course_catalog = $course_info[1];        $course_section = $course_info[2];                            /* Update class size for the class and its respective spring counterpart         * it must have the same section, and catalog must correspond (eg 1001 to 1002)         */        $update_query = $this->updateAll(            array('Course.oc_capacity' => 'Course.oc_capacity+1'),             array('Course.catalog' => $course_catalog,                     'Course.section' => $course_section,                    'Course.oc_capacity < Course.capacity'            )        );                if($update_query == true){            // Update future class schedule of student            $course_list[] = "$course_catalog $course_section";             return $course_list;        }      }      /**    * Checks whether a class is available, given a string input of course id,    * course catalog, and course section, all comma-delimited    * @param array array of course id, catalog, and section    * @return boolean true on class availability, false on none.    */   public function courseCheck($course_info){                            $course_id = $course_info[0];        $course_catalog = $course_info[1];        $course_section = $course_info[2];                debug($course_catalog);        debug($course_section);        // Check if the class is available. Return a count, make sure only 1 exists.        $availability_count = $this->find('count', array(            'conditions' => array(                    'Course.catalog' => $course_catalog,                     'Course.section' => $course_section,                    'Course.oc_capacity < `Course`.`capacity`'                )            )        );                        if($availability_count != 1){            return false;        }else{            return true;        }      } }?>