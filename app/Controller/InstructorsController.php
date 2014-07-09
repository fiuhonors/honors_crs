<?php/** * Description of InstructorsController * * @author aparagas */class InstructorsController extends AppController{        var $layout = 'admin';        public $components = array('RequestHandler');        public function beforeFilter() {            parent::beforeFilter();    }        public function autocomplete(){        $this->layout = '';             if(empty($this->request->query['term'])){            return false;        }               $instructorNames = $this->Instructor->multiColumnSearch($this->request->query['term'], 'first_name', 'last_name', 'list',                 array('Instructor.full_name', 'Instructor.full_name'));                $this->set(compact('instructorNames'));        $this->set('_serialize','instructorNames');    }        public function admin_add(){          if($this->request->data){            if($this->Instructor->saveAll($this->request->data)){                unset($this->request->data);                $this->Session->setFlash('Succesfully added new instructor', 'default', array('class' => 'success'));            }else{                $this->Session->setFlash('Cannot validate. Fix errors below.', 'default', array('class' => 'error'));            }        }            }       public function admin_addBulk(){               $file = $this->request->data['Instructor']['file']['tmp_name'];        $readCSVdata = $this->Instructor->readCsvData($file, 'all');               if(!isset($file)){            $this->Session->setFlash("No file uploaded.", 'default', array('class' => 'error'));            return $this->redirect(array('controller' => 'instructors', 'action' => 'add'));        }              if(!$readCSVdata){            $this->Session->setFlash("Something went wrong with the request.", 'default', array('class' => 'error'));            return $this->redirect(array('controller' => 'instructors', 'action' => 'add'));        }             if($this->Instructor->saveAll($readCSVdata)){            $this->Session->setFlash("Mass Add has been processed succesfully!", 'default', array('class' => 'success'));            return $this->redirect(array('controller' => 'instructors', 'action' => 'add'));        }else{            $inputErrors = $this->Course->csvErrorsAsString();             $this->Session->setFlash("Something went wrong with the request.  CSV data inputs are invalid. $inputErrors", 'default', array('class' => 'error'));            return $this->redirect(array('controller' => 'instructors', 'action' => 'add'));        }    }    public function admin_search(){                if(!empty($this->request->query['search'])){            $searchString = $this->request->query['search'];            if(is_numeric($searchString)){                $instructor_results = $this->Instructor->findAllById($searchString);            }else{                $instructor_results = $this->Instructor->multiColumnSearch($searchString, 'first_name', 'last_name');            }            $this->set('instructors', $instructor_results);        }    }        public function admin_edit($id){             if(!isset($id)){            $this->Session->setFlash("No ID provided for viewing purposes.");        }                if($this->request->data){            if($this->Instructor->saveAll($this->request->data)){                $this->Session->setFlash("Instructor edit was saved.", "default", array('class' => 'success'));                return $this->redirect(array('controller' => 'instructors','action' => 'search' ));            }        }else{            $this->request->data = $this->Instructor->findById($id);        }    }}