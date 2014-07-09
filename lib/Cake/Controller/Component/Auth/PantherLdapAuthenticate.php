<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PantherLdap
 *
 * @author aparagas
 */

App::uses('BaseAuthenticate', 'Controller/Component/Auth');

class PantherLdapAuthenticate extends BaseAuthenticate{
    
        /**
     * Checks the fields to ensure they are supplied.
     *
     * @param CakeRequest $request The request that contains login information.
     * @param string $model The model used for login verification.
     * @param array $fields The fields to be checked.
     * @return boolean False if the fields have not been supplied. True if they exist.
     */
    protected function _checkFields(CakeRequest $request, $model, $fields) {
	if (empty($request->data[$model])) {
		return false;
	}
	foreach (array($fields['username'], $fields['password']) as $field) {
		$value = $request->data($model . '.' . $field);
		if (empty($value) || !is_string($value)) {
			return false;
		}
	}
	return true;
    }
        
    public function authenticate(CakeRequest $request, CakeResponse $response){
        list(, $model) = pluginSplit($this->settings['userModel']);
        $fields = $this->settings['fields'];
        $username = $request->data[$model][$fields['username']];
        $password = $request->data[$model][$fields['password']];
        
        // Check if fields are supplied
        if(!$this->_checkFields($request, $model, $fields)){
            return false;
        }
        
        /* Check if student is in Student table of database. We are checking
            db first because Model sanitizes input. Before we pass anything to
            LDAP, we need to have some security of sanitized inputs.
         */
        if($this->_findUser($username) == false){
            return false;
        }
        
        // Check if student is in LDAP director of FIU, with correct password.
        $ldapconnect = ldap_connect('fiuldap1.fiu.edu');
        $ldapbind = ldap_bind($ldapconnect, 'uid=' . $username . ',ou=panthersoft,dc=fiu,dc=edu', $password);
        if($ldapbind){
            // LDAP user was found.
            return $this->_findUser($username);
        }else{
            // LDAP user cannot be found.
            return false;
        }
        ldap_unbind($ldapbind);
    }
}
