<?php

session_start();

$_SESSION['search_text'] = '*';
$_SESSION['search'] = false;

$_SESSION['show_offshore'] = true;
$_SESSION['show_onshore'] = true;
$_SESSION['show_role'] = true;
$_SESSION['show_division'] = false;

$_SESSION['skills'] = array();
$_SESSION['skills_ids'] = array();

$_SESSION['add_skills'] = array();
$_SESSION['add_levels'] = array();


header("Location: index.php");
?>