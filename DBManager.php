<?php

static $search_result;

function getAllEmployees() {
    global $search_result;
    $query = "SELECT distinct e.NAMES, emp_id, e.SHORE
                FROM employees e, b_employee_skills es
                ORDER BY e.NAMES ASC";
    $search_result = executeSQLQuery($query);
}

function getSkillsAssociated($search_text) {
    $condition = "";
    if (sizeof($_SESSION['skills']) > 0) {
        $condition = " AND SKILL_DESCRIPTION <> '" . $_SESSION['skills'][0] . "' ";
        for ($x = 1; $x < sizeof($_SESSION['skills']); $x++) {
            $condition = $condition . " AND SKILL_DESCRIPTION <> '" . $_SESSION['skills'][$x] . "' ";
        }
    }
    if ($search_text === '*') {
        $query = "SELECT distinct s.SKILL_DESCRIPTION
          FROM skills s, b_employee_skills es
          WHERE s.SKILL_ID = es.SKILL_ID " . $condition . " ORDER BY s.SKILL_DESCRIPTION";
    } else {
        $query1 = "SELECT distinct(e.NAMES), es.EMPLOYEE_ID, e.SHORE
            FROM employees e, b_employee_skills es, skills s, m_skills_level sl
            WHERE  e.EMP_ID = es.EMPLOYEE_ID
            AND es.SKILL_ID = s.SKILL_ID
            AND es.LEVEL_ID = sl.LEVEL_ID
            AND CONCAT (e.NAMES, s.SKILL_DESCRIPTION,sl.LEVEL_DESCR) 
            LIKE '%" . $search_text . "%'";
        $condition2 = " AND EMPLOYEE_ID IN (0";
        $result = executeSQLQuery($query1);
        while ($row = mysqli_fetch_array($result)):
            $condition2 = $condition2 . ", " . $row['EMPLOYEE_ID'];
        endwhile;
        $condition2 = $condition2 . ") ";
        $query = "SELECT distinct SKILL_DESCRIPTION "
                . "FROM b_employee_skills es, skills s "
                . " WHERE es.skill_id = s.skill_id "
                . " and employee_id " . $condition2 . $condition . " ORDER BY SKILL_DESCRIPTION";
    }
    return executeSQLQuery($query);
}

function getSkillsRemaining() {
    $condition = "";
    if (sizeof($_SESSION['skills']) > 0) {
        $condition = "WHERE SKILL_DESCRIPTION <> '" . $_SESSION['skills'][0] . "' ";
        for ($x = 1; $x < sizeof($_SESSION['skills']); $x++) {
            $condition = $condition . " AND SKILL_DESCRIPTION <> '" . $_SESSION['skills'][$x] . "' ";
        }
        echo "<script>alert('" . $condition . "' );</script>";
    }
    $query = "SELECT DISTINCT SKILL_DESCRIPTION FROM matrix.skills " . $condition . " ORDER BY SKILL_DESCRIPTION ASC";
    return executeSQLQuery($query);
}

function search($search_text) {
    global $search_result;
    $query = "SELECT distinct(e.NAMES), emp_id, e.SHORE
            FROM employees e, b_employee_skills es, skills s, m_skills_level sl
            WHERE  e.EMP_ID = es.EMPLOYEE_ID
            AND es.SKILL_ID = s.SKILL_ID
            AND es.LEVEL_ID = sl.LEVEL_ID
            AND CONCAT (e.NAMES, s.SKILL_DESCRIPTION,sl.LEVEL_DESCR) 
            LIKE '%" . $search_text . "%'";
    $search_result = executeSQLQuery($query);
}

function findEmpBySkills() {
    global $search_result;
    $condition = "WHERE SKILL_DESCRIPTION <> '" . $_SESSION['skills'][0] . "' ";
    for ($x = 1; $x < sizeof($_SESSION['skills']); $x++) {
        $condition = $condition . " OR SKILL_DESCRIPTION = '" . $_SESSION['skills'][$x] . "' ";
    }
    $sql = "SELECT SKILL_DESCRIPTION FROM matrix.skills " . $condition . " ORDER BY SKILL_DESCRIPTION ASC";
    $query = "SELECT distinct  e.NAMES, e.SHORE, SKILL_DESCRIPTION, sl.LEVEL_DESCR
                FROM employees e, b_employee_skills es, skills s, m_skills_level sl
                WHERE e.EMP_ID = es.EMPLOYEE_ID
                AND es.LEVEL_ID = sl.LEVEL_ID
                AND es.SKILL_ID = s.SKILL_ID";
    $search_result = executeSQLQuery($query);
}

function executeSQLQuery($query) {
    global $search_result;
    $connect = mysqli_connect("localhost", "root", "", "matrix");
    return mysqli_query($connect, $query);
}

function getEmployeeSkillLevel($ID, $skill) {
    //error_reporting(0);
    $query = "SELECT LEVEL_DESCR, SKILL_DESCRIPTION
FROM b_employee_skills es, skills s, m_skills_level l
WHERE s.SKILL_DESCRIPTION = '" . $skill . "' " .
            " AND es.EMPLOYEE_ID = " . $ID .
            " AND s.SKILL_ID = es.SKILL_ID
AND es.LEVEL_ID = l.LEVEL_ID";

    $result = executeSQLQuery($query);


    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)):
            return $row['LEVEL_DESCR'];
        endwhile;
    }
    return "";
}
?>
