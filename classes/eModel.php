<?php

/*
 * Developed for Department of Educational Technology - Saarland University
 * http://edutech.uni-saarland.de/
 */

/**
 * Description of eModel
 *
 * @author Thomas Mang <thomas.mang@mx.uni-saarland.de>
 */
class eModel extends eObject {
    
    public      $output;
    public      $success = true;
    public      $message = "";


    protected   $table;
    protected   $parent;
    protected   $idProperty         = "id";
    protected   $order_property      =   "id";
    protected   $order_direction    =   "ASC";
    
    public      $data;
    
    public function __construct() {
        parent::__construct();  
    }
    
    public function create($data) {
        if(!is_array($data)) {  // single record
            $keyValueString = "";
            foreach ($data as $key=>$value) {
                if ($key != $this->idProperty) {
                    $keyValueString .= (!$keyValueString) ? ($key . " = :" . $key ) : (", " . $key . " = :" . $key );
                    $paramArray[':'.$key] = $value;
                }
            }
            $query = "
                INSERT {$this->table}
                SET {$keyValueString}
            ";
            try {
                $stmt = $this->getDB()->prepare($query);
                $stmt->execute($paramArray);
                $id = $this->getDB()->lastInsertId();
                $this->read($id);
            } catch (Exception $ex) {
                $this->debug($ex);
                $this->stmt($ex);
            }
        }
        else {                  // multi record
            
        }
        return $id;
    }
    
    public function read($id = NULL, $filters = NULL) {
        if (isset($id)) {       // single record with id (model)
            if ($id != 0) {     // only useful requests
                $query = "SELECT * FROM {$this->table} WHERE id = :id ORDER BY {$this->order_property} {$this->order_direction}";

                try {
                    $stmt = $this->getDB()->prepare($query);
                    $stmt->execute(array(':id' => $id));
                } catch (Exception $ex) {
                    $this->debug($ex);
                }
                
                $this->output = $stmt->fetch();
            }
        }
        else {                  // multi records (store)
            $limit = (isset($_GET['start']) && isset($_GET['limit'])) ? ("LIMIT " . $_GET['start'] . ", " . $_GET['limit']) : ("LIMIT 100");
           
            
            $filterString = (isset($_GET['filter'])) ? ('WHERE ') : ('');
            $filters = json_decode($_GET['filter']);
            $i=0;
            while ($filters[$i]) {
                $filterString .= "{$filters[$i]->property} = '{$filters[$i]->value}' ";
                $filterString .= ($filters[++$i]) ? ('AND ') : ('');
            }
            
                        
            $query = "SELECT * FROM {$this->table} {$filterString} ORDER BY {$this->order_property} {$this->order_direction} {$limit}";

            try {
                $stmt = $this->getDb()->prepare($query);
                $stmt->execute();                
            } catch (Exception $ex) {
                $this->debug($ex);
                $this->debug($stmt);
            }

            
            $this->output = $stmt->fetchAll();
        }
    }
    
    public function update($data) {
        $keyValueString     = "";
        $conditionString    = "";
        $paramArray         = array();

        foreach ($data as $key=>$value) {
            if ($key != $this->idProperty) {
                $keyValueString .= (!$keyValueString) ? ($key . " = :" . $key ) : (", " . $key . " = :" . $key );
                $paramArray[':'.$key] = $value;
            }
            else {
                $id = $value;
                $conditionString = $this->idProperty . " = :" . $key;
                $paramArray[':'.$key] = $value;
            }
        }        
                
        $sql_query = "
            UPDATE {$this->table}
            SET {$keyValueString}
            WHERE {$conditionString}
        ";
        
        try {
            $stmt = $this->getDB()->prepare($sql_query);
            $stmt->execute($paramArray);            
        } catch (Exception $ex) {
            $this->debug($ex);
        }

        $this->read($id);
    }
    
    public function destroy() {
        
    }
    
    /*
    protected function getById($id) {
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC $limit";
        $this->getDB()->prepare($query);
    }
     * */
     

}

?>
