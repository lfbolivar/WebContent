<?php

function _open($database_name, $table_name)
{
	global $_connection;
	global $_hostname;
	global $_session_user;
	global $_session_pass;

	$_connection = mysqli_init();
	if (!mysqli_real_connect($_connection ,$_hostname,$_session_user,$_session_pass,$database_name,8889))
	{
		die ("Failed msqli_real_connect() ".$database_name);
//	    trigger_error("Failed msqli_real_connect()", E_USER_ERROR);
	}
//	if (!mysqli_select_db($_connection,$database_name))
//	{
//		die ("Failed _open() mysqli_select_db to ".$database_name);
//	}
	global $session_table;
	$session_table = $table_name;

	return true;
}

function _close()
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

function _read($id)
{
	global $_connection;

	$id = mysqli_real_escape_string($_connection,$id);

	$sql = "SELECT data
            FROM   sessions
            WHERE  id = '$id'";

	if ($result = mysqli_query($_connection, $sql))
	{
		if (mysqli_affected_rows($_connection))
		{
			$record = mysqli_fetch_assoc($result);

			return $record['data'];
		}
	}

	return '';
}

function _write($id, $data)
{
	global $_connection;
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
	 
	$id = mysqli_real_escape_string($_connection, $id);
	$access = mysqli_real_escape_string($_connection, $access);
	$data = mysqli_real_escape_string($_connection, $data);

	$sql = "REPLACE
            INTO    sessions
            VALUES  ('$id', '$access', '$data')";

	return mysqli_query($_connection,$sql);
}

function _destroy($id)
{
	global $_connection;

	$id = mysqli_real_escape_string($_connection,$id);

	$sql = "DELETE
            FROM   sessions
            WHERE  id = '$id'";

	return mysqli_query($_connection, $sql);
}

function _clean($max)
{
	global $_connection;

	$old = time() - $max;
	$old = mysqli_real_escape_string($_connection, $old);

	$sql = "DELETE
            FROM   sessions
            WHERE  access < '$old'";

	return mysqli_query($_connection, $sql);
}

// ini_set('session.gc_probability', 50);
// ini_set('session.save_handler', 'user');
ini_set('session.save_path','mamp_session');

session_set_save_handler('_open',
                         '_close',
                         '_read',
                         '_write',
                         '_destroy',
                         '_clean');


session_write_close();

?>