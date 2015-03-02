<?php

/**
 * Description of AdministratorsController
 *
 * @author Alastair
 */
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class AdministratorsController extends AppController{
    var $layout = "admin";

    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('admin_login', 'admin_logout');
    }  

    
    public function admin_login(){
        // Set layout template = admin_login.ctp
        $this->layout = 'admin_login';
        if($this->request->is('post')){
			$passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
            if($this->Auth->login()){
                $this->Session->write('Auth.User.level', 'admin');
                return $this->redirect($this->Auth->loginRedirect);
            }else{
                $this->Session->setFlash("The username/password combination is incorrect.", 'default', array('class' => 'error'));
            }
        }

    }

    

    public function admin_logout(){
        return $this->redirect($this->Auth->logout());
    }

    

    public function admin_dashboard(){

    }

    

}



?>

