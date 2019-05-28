<?php


 class dbSession implements SessionHandlerInterface{
    private     $_connection;
    private     $session_table;
    private     $_hostname;
    private     $_session_user;
    private     $_session_pass;
    protected   $save_path;
    protected   $session_name;
    
    
    
 //   function _open($database_name, $table_name){
 //   function _open(){
    public function open(string $save_path, string $session_name)
    {
    
       $this->_connection = mysqli_init();
       if (!mysqli_real_connect($this->_connection ,'localhost','lfbolivar','Tereb!nth','mamp_session',8889)){
        die ("Failed msqli_real_connect() ".$save_path);
        //	    trigger_error("Failed msqli_real_connect()", E_USER_ERROR);
       }
    	if (!mysqli_select_db($this->_connection,$save_path))
        	{
        		die ("Failed _open() mysqli_select_db to ".$save_path);
        }
       $this->session_table = $session_name;
            
       return true;
    }

 //   function _close(){
    public function close()
    {
    //    global $_connection;
    
    //    if (isset($_connection))
    //	{
    //		mysqli_close($_connection);
        //	}
        //	else
        //	{
        return true;
        //	}
    }
        
 //   function _read($id){
    public function read(string $session_id)
    {
    
            
        $id = mysqli_real_escape_string($this->_connection,$session_id);
            
        $sql = "SELECT data
        FROM   sessions
            WHERE  id = '$id'";
            
        if ($result = mysqli_query($this->_connection, $sql)){
            if (mysqli_affected_rows($this->_connection)){
                $record = mysqli_fetch_assoc($result);
                return $record['data'];
            }
        }
            
        return '';
    }
       
 //   function _write($id, $data){
    public function write(string $session_id, string $session_data)
    {
    
    
        global $_session_db_name;
            global $_hostname;
            global $_session_user;
            global $_session_pass;
            
            $_connection = mysqli_init();
            if (!mysqli_real_connect($_connection ,$_hostname,$_session_user,$_session_pass,$_session_db_name,8889))
            {
                die ("Failed _open() @mysqli_connect");
            }
            if (!mysqli_select_db($_connection,$_session_db_name))
            {
                die ("Failed _open() mysqli_select_db to ".$_session_db_name);
            }
            $access = time();
            
            $id = mysqli_real_escape_string($_connection, $session_id);
            $access = mysqli_real_escape_string($_connection, $access);
            $data = mysqli_real_escape_string($_connection, $session_data);
            
            $sql = "REPLACE
            INTO    sessions
            VALUES  ('$id', '$access', '$data')";
            
            return mysqli_query($_connection,$sql);
        }
        
 //       function _destroy($id)
        public function destroy(string $session_id)
        {
        
            $id = mysqli_real_escape_string($this->_connection,$session_id);
            
            $sql = "DELETE
            FROM   sessions
            WHERE  id = '$id'";
            
            return mysqli_query($this->_connection, $sql);
        }
        
 //       function _clean($max)
        public function gc(int $maxlifetime)
        {
        
            $old = time() - $maxlifetime;
            $old = mysqli_real_escape_string($this->_connection, $old);
            
            $sql = "DELETE
            FROM   sessions
            WHERE  access < '$old'";
            
            return mysqli_query($this->_connection, $sql);
        } 
    
}

// ini_set('session.gc_probability', 50);
//ini_set('session.save_handler', 'user');
//ini_set('session.save_path', 'mamp_session');

$handler = new dbSession();
session_set_save_handler(
    //
   array($handler,'open'),
   array($handler,'close'),
   array($handler, 'read'),
   array($handler, 'write'),
   array($handler, 'destroy'),
   array($handler,'clean'));
        
        
session_write_close();
        
        
?>