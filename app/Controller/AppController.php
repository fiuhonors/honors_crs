<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller', 'CakeEmail', 'Network/Email');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller{
    
    public $components = array('Session', 'Auth', 'RequestHandler');
    
    /**
     * Turns a text string into a serialized array given a delimiter, makes sure 
     * that there is no whitespace between each element before and after a given
     * delimiter
     * @param string $stringToTurn The string to turn into an array
     * @param string $delimiter The symbol inside the string that will be used as a delimiter.
     * 
     * @return mixed[] The array made from the string.
     */
    public function turnTextToArray($stringToTurn = NULL, $delimiter=",", $multiDimensional=false, $multiDimensionalDelimiter=" "){
        if(strlen($stringToTurn) < 1 || $stringToTurn == NULL){
            return false;
        }
        $array_to_output = array();
		if($multiDimensional == false){
			foreach(explode($delimiter,$stringToTurn) as $individual_inputs){
				$array_to_output[] = trim($individual_inputs);
			}
		}else{
			foreach(explode($delimiter,$stringToTurn) as $individual_inputs){
				$values = explode($multiDimensionalDelimiter,$individual_inputs);
				$array_to_output[$values[0]] = trim($values[1]);
			}
		}
        return serialize($array_to_output);
    }
    
    /**
     * Turns a serialized array into a text string.
     * 
     * @param mixed[] $arrayToTurn The serialized array to turn into a string
     * @param string $delimiter Symbol that will be used to join the array elements with
     * @return string The string generated from the provided array
     */
    public function turnArrayToText($arrayToTurn = NULL, $delimiter=", ", $multiDimensional=false, $multiDimensionalDelimiter=" "){
        $arrayToTurn = unserialize($arrayToTurn);
        if(!is_array($arrayToTurn) || count($arrayToTurn) < 1){
            return false;
        }
        
		if($multiDimensional == false){
			return implode($delimiter, $arrayToTurn);
		}else{
			$string_builder = '';
			// 
			foreach($arrayToTurn as $index=>$value){
				$string_builder.= $index . $multiDimensionalDelimiter . $value;
			}
			return trim($string_builder);
		}
    }
    
    public function beforeFilter(){
        
        if($this->request->prefix == 'admin'){
            $this->Auth->authenticate = array(
                'Form' => array(
                    'userModel' => 'Administrator',
                    'fields' => array(
                        'username' => 'id',
                        'password' => 'password'
                    ),
                   'passwordHasher' => array(
                       'className' => 'Simple',
                       'hashType' => 'sha256'
                   )
                )
            );
            $this->Auth->authorize = 'Controller';
            $this->Auth->loginAction = array(
                'controller' => 'administrators', 
                'action' => 'login'
            );
            $this->Auth->loginRedirect = array(
                'controller' => 'administrators',
                'action' => 'dashboard'
            );
            $this->Auth->logoutRedirect = array(
                'controller' => 'administrators',
                'action' => 'login'
            );
        }else {
            $this->Auth->authenticate = array(
                'PantherLdap' => array(
                   'userModel' => 'Student',
                   'fields' => array(
                       'username' => 'id',
                       'password' => 'password'
                   )   
                ) 
            );
            $this->Auth->authorize = 'Controller';
            $this->Auth->loginAction = array(
                'controller' => 'students', 
                'action' => 'login'
            );
            $this->Auth->loginRedirect = array(
                'controller' => 'students',
                'action' => 'dashboard'
            );
            $this->Auth->logoutRedirect = array(
                'controller' => 'students',
                'action' => 'login'
            );  
        }
        $this->Auth->authError = "Please login to view that page...";
    }
    
    public function isAuthorized($user = null){
        
        // If admin-prefixed, section cannot be accessed.
        if($this->request->prefix == 'admin'){
            return (bool)($user['level'] == 'admin');
        }
        
        // If no prefix, it is student-level - allow students access.
        if(empty($this->request->prefix)){
            return (bool)($user['level'] == 'student');
        }
        
        return false;
    }
 
    
}
