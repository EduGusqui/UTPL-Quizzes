<?php
interface IBaseService
{
	public static function getAll();
	public static function getById($id);
	public static function create($data);
	public static function update($data);
	public static function delete($id);
}
?>