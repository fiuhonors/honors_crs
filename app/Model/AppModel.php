<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
    
    
    public $recursive = -1;
    
    /* Checks if Panther ID is unique. Primary Keys cannot use isUnique rule,
     * as they are used in conjunction in an SQL statement. If you try to isUnique
     * a primary key, an SQL statement would look like where Model.primaryKey = 'something'
     * and Model.primaryKey != 'something', which is self contradicting and thus
     * gives a result of 0 count, making it seem as if it was unique.
     */
    function isUniqueId($u_id, $table_id = 'id'){
        return ($this->find('count', array('conditions' => array("$this->name" . '.' . "$table_id" => $u_id))) == 0);
    }
    
    
    /**
     * Searches a value in two tables in the database. Helpful for querying names
     * on both first_name and last_name fields.
     * 
     * WHEN I HAVE TIME, FIX THIS CODE BECAUSE VIRTUAL FIELDS BASICALLY MAKES
     * THIS USELESS
     * 
     * @param string $searchString Search string
     * @param string $firstColumn first column in database to look $searchString for
     * @param string $secondColumn second column in database to look $searchString for
     * @param string $find_type How should database be queried.
     * @param mixed[] $list_structure array of table fields to be displayed
     * @param mixed[] $parameters additional parameters
     * @return Results of the multi-column search
     */
    function multiColumnSearch($searchString = NULL, $firstColumn = NULL, $secondColumn = NULL, $find_type = 'all', $list_structure = NULL){
        if(!isset($searchString) || strlen($searchString) < 1){
            return false;
        }
        
        $searchArray = explode(' ', $searchString);
                
        if(count($searchArray) > 1){
            /* Imploding just-turned array from string $searchArray so that
             * we can get "first name" part of $searchString - everything
             * before the last word in searchString. Implode returns a string.
             */
             $first_part = implode(' ', array_slice($searchArray, 0, count($searchArray) - 1));
             $last_part = $searchArray[count($searchArray) - 1];
             if($find_type == 'list'){
                $db_results = $this->find($find_type, array(
                    'fields' => $list_structure,
                    'conditions' => array(
                        "$this->name" . '.' . "$firstColumn " . 'LIKE' => "%$first_part%",
                        "$this->name" . '.' . "$secondColumn " . 'LIKE' => "%$last_part%"
                    ) 
                )); 
             }else{
                $db_results = $this->find($find_type, array(
                    'conditions' => array(
                        "$this->name" . '.' . "$firstColumn " . 'LIKE' => "%$first_part%",
                        "$this->name" . '.' . "$secondColumn " . 'LIKE' => "%$last_part%"
                    ) 
                ));
             }
        }else{
              /* If the search string contains less than one word, then search
               * both columns with the same word. Use OR statement.
               */
            if($find_type == 'list'){
                $db_results = $this->find($find_type, array(
                    'fields' => $list_structure,
                    'conditions' => array(
                        'OR' => array(
                             "$this->name" . '.' . "$firstColumn " . 'LIKE' => "%$searchArray[0]%",
                             "$this->name" . '.' . "$secondColumn " . 'LIKE' => "%$searchArray[0]%"
                        )
                    )
                )); 
            }else{
              $db_results = $this->find($find_type, array(
                 'conditions' => array(
                     'OR' => array(
                          "$this->name" . '.' . "$firstColumn " . 'LIKE' => "%$searchArray[0]%",
                          "$this->name" . '.' . "$secondColumn " . 'LIKE' => "%$searchArray[0]%"
                     )
                 ) 
              ));
            }
       }
       return $db_results;
    }
    
    
    /**
     * Reads CSV data and returns back a corresponding Model-saveable array structure.
     * This is meant for mass uploads and the like.
     * 
     * @param string $file File location to read from and gain the information
     * @param type $csvStyleType Either "all" or "multidata". "All" is when the
     *      first row of the CSV sheet corresponds to table column names, allowing
     *      for custom-made CSV worksheets that relates a corresponding data
     *      to a corresponding column.
     * @param type $columnWithMultipleInput Optional. Column in the database where
     *      an array will be stored because a corresponding cell in the worksheet
     *      holds multiple values delimited by a slash (for All $csvStyleType) OR
     *      following cells after an identifier have data(for Multidata $csvStyleType)
     * @return Model-storeable array of data or boolean if mistake.
     */
    public function readCsvData($file = NULL, $csvStyleType = NULL, $columnWithMultipleInput = NULL){
        /* If there was a file uploaded and the uploaded file does exist,
         * continue. Otherwise, redirect false. There are two options
         * of a CSV file type = multidata, and all. Multidata is the CSV structure of
         * one column of database identifier (eg id), and the next
         * following cells in line correspond to an array buildup, while All is a relational 
         * header to table column relationship.
         * 
         * For ex:
         * All
         * -----------------------------------------------
         * id  |    username    |  password  |  status  |
         * -----------------------------------------------
         * 404 | Altair La-Ahad |    empire  |   active |
         * Generates a Model-consumable data where the first row are the table colum names,
         * and the cells aligned below correspond to the column names above id
         * identifiers on the first cell of each row.
         * 
         * Multidata
         * --------------------------------------------
         * 404 | Class1 Section2 | Class2 Section 4|
         * Multidata, for the corresponding row in database (using first cell per row
         * as the row identifier - 404), and corresponding column (being $column
         * with MultipleInput), stores cells after first cell of each line into
         * an array to be serialized and turned into Model-consumable data.
         */
        
        if(empty($file) || !is_uploaded_file($file)){
            return false;
        }
        $file_pointer = fopen($file, "r");
        $csv_data = array(); // CakePHP-convention array structure to store in database
        $csv_line_counter = 0; //First read is line 0 - headers
            
        if($csvStyleType == 'all'){
            $csv_index = -1;
            /* Counts current row we are in that actually includes data, not headers
             * First column is not an object - it's a header, Hence -1 
             * instead of 0. This variable holds what current Student object
             * are we working on - Student[0] - first student, Student[1]
             * - second student and so forth.
             */
            $csv_headers = array(); //Array that will store column names
                
            /* While we are looping through each line inside the CSV file,
             * set the results of each line (which is turned to an array)
             * into $csv_line.
             */
            while(($csv_line = fgetcsv($file_pointer, 1000, ",")) !== FALSE){
                /* Each line have several cells. Loop through these individual
                 * cells and add them as values in the Model Array that
                 * will be sent as a body of a parent array to be returned.
                 */
                for($i=0; $i < count($csv_line); $i++){
                    /* If it's the first line in CSV file, store values - column
                     * names, into the $csv_headers array.
                     * If it's not, add pair given a key. Since we do not
                     * know key names specified by user, make array of array keys,
                     * then access them in their index (i) position, then store
                     * the corresponding object (value) to a corresponding key
                     */
                    if($csv_line_counter == 0){
                        $csv_headers[] = trim($csv_line[$i]); //Trim each first row cells
                    }else{                      
                        if($csv_headers[$i] == $columnWithMultipleInput){
                            /* If a cell corresponds to a multiple-dataset column that as such,
                             * holds an array of values, explode the string (delimited by slashes) 
                             * into arrays, then add the serialized array to return statement
                             */
                            $multiple_data = array();
                            foreach(explode("|", $csv_line[$i]) as $multiple_data_obtained){
                                $multiple_data[] = trim($multiple_data_obtained);
                            }
                            $csv_data[$csv_index]["$this->name"][$csv_headers[$i]] = serialize($multiple_data);
                        }else{
                            $csv_data[$csv_index]["$this->name"][$csv_headers[$i]] = trim($csv_line[$i]);
                        }
                    }
                }
                $csv_index++; // Increment to store appropriate values for next actual object
                $csv_line_counter++; // Increment to move pointer to next line in CSV parsed file.
            }
            return $csv_data;
        }else if($csvStyleType == 'multidata'){
            $csv_index = 0; // Current student we are working on.
            $multiple_data = array(); // Array of past and present classes of a student

            /* While we have data in CSV file, loop through each line. Cells
             * in a line is a specific index in an array.
             */
            while(($csv_line = fgetcsv($file_pointer, 1000, ",")) !== FALSE){
                    /* For each element in a CSV line loop.
                     * First element in each line corresponds to a student id.
                     * Following elements after first column are just past classes.
                     */
                    for($i=0; $i < count($csv_line); $i++){
                        if($i == 0){
                            $csv_data[$csv_index]["$this->name"]['id'] = trim($csv_line[$i]);
                        }else{
                            $multiple_data[] = trim($csv_line[$i]);
                        }
                    }
                    $csv_data[$csv_index]["$this->name"]["$columnWithMultipleInput"] = serialize($multiple_data);
                    $multiple_data = array(); // Empty the array for next line.
                    $csv_index++;
                    $csv_line_counter++;
            }
            return $csv_data;
        }else{
            // No CSV file type
            return false;
        }
    }
    
    public function csvErrorsAsString($csvRelationship="all"){
        $problemSet = $this->validationErrors;
        
        if($csvRelationship == 'all'){
            $problemString = "";
            foreach($problemSet as $problemRow => $problemDescription){
                $problemRow += 2;
                $problemString .= "At <b>$problemRow</b> row of CSV, ";
                foreach($problemDescription as $problemInput => $problemDescription){
                    $problemString .= "<u>$problemInput</u> - $problemDescription[0] " ;
                }
                $problemString .= "<br/>";
            }
        }else{
            $problemString = "";
            foreach($problemSet as $problemRow => $problemDescription){
                $problemRow += 1;
                $problemString .= "At <b>$problemRow</b> row of CSV, ";
                foreach($problemDescription as $problemInput => $problemDescription){
                    $problemString .= "<u>$problemInput</u> - $problemDescription[0] " ;
                }
                $problemString .= ".<br/>";
            }
        }
        
        return $problemString;
    }
        
    
}
