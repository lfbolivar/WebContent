<?php
/*
 * Author:	LF Bolivar
 * Created:	7/22/2016
 * 
 *   The iCRUD Interface
 *   The interface identifies four methods:
 *   - create()
 *   - read()
 *   - update()
 *   - delete()
 */
interface iCRUD {
	
	public function create($data);
	public function read();
	public function update($data);
	public function delete();
	
}