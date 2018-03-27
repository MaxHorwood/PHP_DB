# PHP_DB

###Usage

A _easy_ way to create prepared statements.

```php
// Once required the file.

$db = new DB($hostname, $username, $password, $database);

// Selecting Data
$query = "SELECT * FROM `users` WHERE id=?";
// Names in the database to return as a array
$rows  = array("id", "email", "name, "age"); 
$out = $db->do_query($query, array(10), "i", true, $rows);

// $out[0] = Row position
print_r($out[0]["name"]);

// Inserting Data
$query = "INSERT INTO `users` (id, name, email, age) VALUES (default, ?, ?, ?)";
$db->do_query($query, array("Max", "Max@Max.com", 20), "ssi");

// "error"=>bool,"desc"=>"String of the error"
$db->get_error(); 

$db->close_connection();
```