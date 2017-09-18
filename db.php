<?php
class db{
    public static function connect(){
        $conn=new mysqli('localhost', 'root','mysql','chat');
        if($conn->connect_error)
        {
            return NULL;
        }
        else{
            return $conn;
        }
    }
    public static function insert_data($query){
        $connection=self::connect();
        if($connection->query($query) == TRUE)
        {
            return 1;
        }
        else
        {
            return 0;
        }
        $connection->close();
    }
    public static function get_data($qry){
        $con=self::connect();
        $data=$con->query($qry);
        if($data->num_rows >0)
        {
            return $data;
        }
        else
        {
            return 0;
        }
        $con->close();
    }
}