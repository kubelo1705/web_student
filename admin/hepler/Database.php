<?php
  class Database {
      private $conn;
      private $hostname = 'localhost';
      private $username = 'root';
      private $password = '';
      private $dbname = 'web_student';
      function connect(){
        if(!$this->conn)
          $this->conn=new mysqli($this->hostname,$this->username,$this->password,$this->dbname);
    }
     
    function dis_connect(){
        if($this->conn)
          $this->conn->close();
    }
     
    function insert(string $table,array $data){
     
      $field_list = '';
      $value_list = '';
      foreach ($data as $key => $value){
          $field_list .= "$key".",";
          $value_list .= "'".($value)."',";
      }
      $sql = 'INSERT INTO '.$table. '('.rtrim($field_list, ',').') VALUES ('.rtrim($value_list, ',').')';
      $result= $this->conn->query($sql);
      return $result;
    }
    
    function update(string $table,array $data,string $where){
      $update = '';
      foreach ($data as $key => $value){
          $update .= "$key = '".($value)."',";
      }
      $sql = 'UPDATE '.$table. ' SET '.rtrim($update, ',').' WHERE '.$where;
      $result= $this->conn->query( $sql);

      return $result;
    }
    
    function remove(string $table, string $where){

      $sql = "DELETE FROM $table WHERE $where";
      
      $result= $this->conn->query( $sql);

      return $result;
    }
     
    function get_list(string $table, string $where){

      $sql = 'SELECT * FROM '.$table.' WHERE '.$where;
      $result=$this->conn->query( $sql);
      if (!$result){
          die ('Câu truy vấn sai');
      }
      // $return = array();
      // if ($result->num_rows > 0) {
      //   while ($row = mysqli_fetch_assoc($result)){
      //     $return[]=$row;
      //   }}
      // mysqli_free_result($result);

      return $result;
    }



    function checkAccount(string $username,string $password)
    {

      $table='account';
      $where="username='".$username."' and password='".$password."'";
      $sql = 'SELECT * FROM '.$table.' WHERE '.$where;

  
      $result = $this->conn->query($sql);



      if($result->num_rows==0)
      {
        return 0;
      }
      $row=mysqli_fetch_assoc($result);
      return $row;
      
      
    }
     
    
      // add delete edit getById getAll getAllStudent 
  }