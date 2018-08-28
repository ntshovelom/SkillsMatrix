<?php

session_start();

$_SESSION['search_text'] = '*';
$_SESSION['search'] = false;

$_SESSION['skills'] = array();
$_SESSION['skills_ids'] = array();
$_SESSION['skills_database'] = array('PHP', 'HTML', 'JAVA', 'C++', 'PHP', 'MySQL', 'Oracle SQL', 'C#', 'VB', 'Small Basic', 'Python', 'MS World');
header("Location: index.php");
?>