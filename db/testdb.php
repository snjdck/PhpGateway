<?php
$user = array(
	'first_name' => 'MongoDB',
	'last_name' => 'Fan',
	'tags' => array('developer','user')
);

$dbHost = 'localhost';
$dbName = 'test';

$m = new Mongo("mongodb://$dbHost");
$db = $m->$dbName;

$c_users = $db->users;

$c_users->save($user);