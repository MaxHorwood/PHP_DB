<?php

class DB {

    // Database Information
    private $hostname;
    private $database;
    private $password;
    private $username;
    // connection
    private $sql_con;

    private $error; // Store error

    public function __construct($hostname, $username, $password, $database) {
        $this->$sql_con = new mysqli($hostname, $username, $password, $database);
        if (mysqli_connect_errno()){
            $this->set_error(true, "Failed to connect to database");
        }else{
            $this->set_error(false, "Connected");
        }
    }
    private function set_error($err, $desc){
        $this->error = array("error"=>$err, "desc"=>$desc);
    }
    public function get_error(){
        return $this->error;
    }
    /**
     * Create a prepared statment:
     * $sql_stmt - String of the sql statement: "SELECT * FROM TABLE WHERE id=?"
     * $values   - Used to bind with the '?' (array(10))
     * $keys     - String for bind params -- "i"
     * $get_result - When true, puts all data in an array and returns it
     * $rows     - names of the rows array('id') 
     */
    public function do_query($sql_stmt, $values, $keys, $get_res=false, $rows=null){
        $stmt = $this->$sql_con->stmt_init();
        if ($stmt->prepare($sql_stmt)){
            // Make sure there are some keys
            if ($keys != ""){
                $stmt->bind_param($keys, ...$values);
            }
            $stmt->execute();
            // Error
            if ($stmt->errno > 0){
                $this->set_error(true, "Statement Execution Error");
            }else{
                if ($get_res){
                    /** Puts all results in an array:
                     * $out[0]['name_given'];
                     */
                    $out = array();
                    $res = $stmt->get_result();
                    while($row = $res->fetch_array(MYSQLI_ASSOC)){
                        $size = sizeof($out);
                        foreach ($rows as $name){
                            $out[$size][$name] = $row[$name];
                        }
                    }
                }
            }
            $stmt->close();
            // Should only be set if returning a selection
            if ($get_res){ 
                return $out;
            }else {
                return null;
            }
        }else{
            $this->set_error(true, "Statement Prepare Error");
            return null;
        }
    }
	// Example usage
    public function insert_data($name, $email, $age){
        $this->do_query("INSERT INTO `users` (id, name, email, age) VALUES (default, ?, ?, ?)", array($name, $email, $age), "ssi");
		print_r(json_encode($this->get_error());
    }


    public function close_connection(){
        $this->$sql_con->close();
    }
}

?>