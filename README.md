# PHP_DB

####Usage

```php
// Once required the file.

$db = new DB($hostname, $username, $password, $database);

// Selecting Data
$query = "SELECT * FROM `users` WHERE id=?";
$rows  = array("id", "email", "name, "age"); // Names in the database to return as a array
$out = $db->do_query($query, array(10), "i", true, $rows);

// Inserting Data
$query = "INSERT INTO `users` (id, name, email, age) VALUES (default, ?, ?, ?)";
$db->do_query($query, array($name, $email, $age), "ssi");

$db->get_error(); // "error"=>bool,"desc"=>"String of the error"

$db->close_connection();
```