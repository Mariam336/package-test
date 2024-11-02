<?php


class db {

    private $table;

    private $sql;

    private $connection;
    
   
    


    public function __construct($hostname,$usernae,$password,$database,$table)
    {
        $this->connection=mysqli_connect($hostname,$usernae,$password,$database);
        $this->table=$table;
        
    }


    public function where($condition)
    {
        $this->sql .=$condition ;
        return $this;
    }




    public function insert($data)
    {
        $columns="";
        $values="";
        foreach($data as $column=>$value){
            $columns .="`$column`,";
            $values .="'$value',";
        }
        $columns=rtrim($columns,",");
        $values=rtrim($values,",");

        $this->sql="INSERT INTO $this->table($columns) VALUES ($values)";
        return $this;


    }
    public function update($data)
    {
        $rows="";
        foreach($data as $column=>$value){
            $rows .="`$column`='$value',";
        }
        $rows=rtrim($rows,",");

        $this->sql="UPDATE $this->table SET $rows";
        return $this;
   
    }


    public function delete()
    {
        $this->sql="DELETE FROM `$this->table`";
        return $this;

    } 
     
    public function select($columns="*")
    {
        $this->sql="SELECT $columns FROM $this->table ";
        
        return $this;
        
    }

    public function join($type,$table,$pk,$fk)
    {
        $this->sql .="$type JOIN $table IN $pk = $fk ";
        return $this;
    }



    public function excute()
    {
        mysqli_query($this->connection,$this->sql);
        return mysqli_affected_rows($this->connection);
    }



    public function all()
    {
        $query=mysqli_query($this->connection,$this->sql);
        return mysqli_fetch_all($query,MYSQLI_ASSOC);
    }


    public function get()
    {
        $query=mysqli_query($this->connection,$this->sql);
        return mysqli_fetch_assoc($query);
    }
}
?>