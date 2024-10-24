<?php
class dbConnection{
    private $connection;
    private $db_type;
    private $db_host;
    private $db_port;
    private $db_user;
    private $db_pass;
    private $db_name;
    public $posted_values;
    public function __construct($db_type, $db_host, $db_port, $db_user, $db_pass, $db_name){
        $this->db_type = $db_type;
        $this->db_host = $db_host;
        $this->db_port = $db_port;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
        $this->connection($db_type, $db_host, $db_port, $db_user, $db_pass, $db_name);
    }
    public function connection($db_type, $db_host, $db_port, $db_user, $db_pass, $db_name){
        switch($db_type){
            case 'MySQLi':
                if($db_port<>Null){
                    $db_host .= ":" . $db_port;
                }
                $this->connection = new mysqli($db_host, $db_user, $db_pass, $db_name);
                if($this->connection->connect_error){
                    return "Connection Failed" . $this->connection->connect_error;
                }else{
                    print "Connected Successfully";
                }
                break;
            case 'PDO':
                if($db_port<>Null){
                    $db_host .= ":" . $db_port;
                }
                try {
                    $this->connection = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
                    // set the PDO error mode to exception
                    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    //echo "Connected successfully to PDO";
                  } catch(PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                  }
                break;
        }
    }

    public function insert($table, $data){
        ksort($data);
        $fielDetails = NULL;
        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = implode("', '", array_values($data));
        $sth = "INSERT INTO $table (`$fieldNames`) VALUES ('$fieldValues')";
        
        switch($this->db_type){
            case 'MySQLi' :
                if($this->connection->query($sth) === TRUE){
                    return TRUE;
                }else{
                    return "Error: " . $sth . "<br>" . $this->connection->error;
                }
                break;
            case 'PDO' :
                try{
                    $this->connection->exec($sth);
                    return TRUE;
                  } catch(PDOException $e) {
                    return $sth . "<br>" . $e->getMessage();
                  }
        }
    }
    public function escape_values($posted_values): string
{
    switch ($this->db_type) {
        case 'MySQLi':
            $this->posted_values = $this->connection->real_escape_string($posted_values);
            break;
        case 'PDO':
            $this->posted_values = addslashes($posted_values);
            break;
    }
    return $this->posted_values;
}

public function count_results($sql){
    switch ($this->db_type) {
        case 'MySQLi':
            if(is_object($this->connection->query($sql))){
                $result = $this->connection->query($sql);
                return $result->num_rows;
            }else{
                print "Error 5: " . $sql . "<br />" . $this->connection->error . "<br />";
            }
            break;        
        case 'PDO':
            $res = $this->connection->prepare($sql);
            $res->execute();
            return $res->rowCount();
            break;
    }
}

public function select($sql){
    switch ($this->db_type) {
        case 'MySQLi':
            $result = $this->connection->query($sql);
            return $result->fetch_assoc();
            break;
        case 'PDO':
            $result = $this->connection->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC)[0];
            break;
    }
}

public function select_while($sql){
    switch ($this->db_type) {
        case 'MySQLi':
            $result = $this->connection->query($sql);
            for ($res = array (); $row = $result->fetch_assoc(); $res[] = $row);
            return $res;
            break;        
        case 'PDO':
            $result = $this->connection->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
            break;
    }
}

public function update($table, $data, $where){
    $wer = '';
    if(is_array($where)){
        foreach ($where as $clave=>$value){
            $wer.= $clave."='".$value."' AND ";
        }
        $wer   = substr($wer, 0, -4);
        $where = $wer;
    }
    ksort($data);
    $fieldDetails = NULL;
    foreach ($data as $key => $values){
        $fieldDetails .= "$key='$values',";
    }
    $fieldDetails = rtrim($fieldDetails,',');
    if($where==NULL or $where==''){
        $sth = "UPDATE $table SET $fieldDetails";
    }else {
        $sth = "UPDATE $table SET $fieldDetails WHERE $where";
    }
    return $this->extracted($sth);
}

public function delete($table,$where){
    $wer = '';
    if(is_array($where)){
        foreach ($where as $clave=>$value){
            $wer.= $clave."='".$value."' and ";
        }
        $wer   = substr($wer, 0, -4);
        $where = $wer;
    }
    if($where==NULL or $where==''){
        $sth = "DELETE FROM $table";
    }else{
        $sth = "DELETE FROM $table WHERE $where";
    }
        return $this->extracted($sth);
}

public function truncate($table){
    $sth = "TRUNCATE $table";
    return $this->extracted($sth);
}

public function last_id(){
    switch ($this->db_type) {
        case 'MySQLi':
            return $this->connection->insert_id;
        break;    
        case 'PDO':
            return $this->connection->lastInsertId();
        break;
    }
}	

/**
 * @param string $sth
 * @return bool|string|void
 */
public function extracted(string $sth)
{
    switch ($this->db_type) {
        case 'MySQLi':
            if ($this->connection->query($sth) === TRUE) {
                return TRUE;
            } else {
                return "Error: " . $sth . "<br>" . $this->connection->error;
            }
            break;        
        case 'PDO':
            try {
                // Prepare statement
                $stmt = $this->connection->prepare($sth);
                // execute the query
                $stmt->execute();
                return TRUE;
            } catch (PDOException $e) {
                return $sth . "<br>" . $e->getMessage();
            }
            break;
    }
}

}