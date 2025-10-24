<?php
$mysqli = new mysqli('data', 'app', 'app', 'testdb');
if ($mysqli->connect_errno) { die("Failed to connect to MySQL: " . $mysqli->connect_error); }
$mysqli->query("INSERT INTO compteur (visites) VALUES (NULL)");
$result = $mysqli->query("SELECT COUNT(*) as total FROM compteur");
$row = $result->fetch_assoc();
echo "<h1>Count updated</h1>";
echo "<h2>Count : " . $row['total'] . "</h2>";
