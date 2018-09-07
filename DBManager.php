<?php

static $search_result;

function getAllEmployees() {
    global $search_result;
    $query = "SELECT distinct e.NAMES, emp_id, e.SHORE, r.ROLE_DESCRIPTION, d.DIV_DESCRIPTION
                FROM employees e, b_employee_skills es, roles r, divisions d
                WHERE e.role_id = r.role_id 
                AND r.division_id = d.division_id ";
    if ($_SESSION['show_offshore'] === false && $_SESSION['show_onshore'] === false) {
        $query = $query . " AND e.shore NOT IN ('Offshore', 'Onshore')";
    } else if ($_SESSION['show_offshore'] === true && $_SESSION['show_onshore'] === false) {
        $query = $query . " AND e.shore <> 'Onshore'";
    } else if ($_SESSION['show_offshore'] === false && $_SESSION['show_onshore'] === true) {
        $query = $query . " AND e.shore <> 'Offshore'";
    }

    $query = $query . " ORDER BY e.shore DESC, e.NAMES ASC";
    $search_result = executeSQLQuery($query);
}

function getSkillsAssociated($search_text) {
    $condition = "";
    if (sizeof($_SESSION['skills']) > 0) {
        $condition = " AND SKILL_DESCRIPTION <> '" . getSkillByID($_SESSION['skills'][0]) . "' ";
        for ($x = 1; $x < sizeof($_SESSION['skills']); $x++) {
            $condition = $condition . " AND SKILL_DESCRIPTION <> '" . getSkillByID($_SESSION['skills'][$x]) . "' ";
        }
    }
    if ($search_text === '*')
        $search_text = ' ';
    $query1 = "SELECT es.EMPLOYEE_ID, e.shore
            FROM employees e, b_employee_skills es, skills s, m_skills_level sl, roles r
            WHERE  e.EMP_ID = es.EMPLOYEE_ID
            AND es.SKILL_ID = s.SKILL_ID
            AND es.LEVEL_ID = sl.LEVEL_ID
             AND e.role_id = r.role_id
            AND CONCAT (e.NAMES, s.SKILL_DESCRIPTION, r.ROLE_DESCRIPTION, sl.LEVEL_DESCR) 
            LIKE '%" . $search_text . "%' ";
    if ($_SESSION['show_offshore'] === false && $_SESSION['show_onshore'] === false) {
        $query1 = $query1 . " AND e.shore NOT IN ('Offshore', 'Onshore')";
    } else if ($_SESSION['show_offshore'] === true && $_SESSION['show_onshore'] === false) {
        $query1 = $query1 . " AND e.shore <> 'Onshore'";
    } else if ($_SESSION['show_offshore'] === false && $_SESSION['show_onshore'] === true) {
        $query1 = $query1 . " AND e.shore <> 'Offshore'";
    }

    $condition2 = " AND EMPLOYEE_ID IN (0";
    $result = executeSQLQuery($query1);
    while ($row = mysqli_fetch_array($result)):
        $condition2 = $condition2 . ", " . $row['EMPLOYEE_ID'];
    endwhile;
    $condition2 = $condition2 . ") ";

    $query = "SELECT distinct es.SKILL_ID "
            . "FROM b_employee_skills es, skills s "
            . " WHERE es.skill_id = s.skill_id "
            . " and employee_id " . $condition2 . $condition . " ORDER BY SKILL_DESCRIPTION";

    return executeSQLQuery($query);
}

function addResource($names, $shore, $role, $skill, $level) {
    $query = "INSERT INTO EMPLOYEES(NAMES, SHORE, ROLE_ID) "
            . "VALUES ('" . $names . "', '" . $shore . "', '" . $role . "')";
    $connect = mysqli_connect("localhost", "root", "", "matrix");
    mysqli_query($connect, $query);

    $empid = $connect->insert_id;
    for ($x = 0; $x < sizeof($_SESSION['add_skills']); $x++) {
        $query = "INSERT INTO B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID) "
                . "VALUES ('" . $empid . "', '" . $_SESSION['add_skills'][$x] . "', '" . $_SESSION['add_levels'][$x] . "')";
        mysqli_query($connect, $query);
    }
    $_SESSION['add_skills'] = array();
    $_SESSION['add_levels'] = array();
}

function getSkillByID($ID) {
    $query = "SELECT SKILL_DESCRIPTION FROM SKILLS WHERE SKILL_ID = '" . $ID . "'";
    $result = executeSQLQuery($query);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)):
            return $row['SKILL_DESCRIPTION'];
        endwhile;
    }
    return "";
}

function getSkillIDByDescr($descr) {
    $query = "SELECT SKILL_ID FROM SKILLS WHERE SKILL_DESCRIPTION = '" . $descr . "'";
    $result = executeSQLQuery($query);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)):
            return $row['SKILL_ID'];
        endwhile;
    }
    return "";
}

function getSkillsRemaining($skills) {
    $condition = "";
    if (sizeof($skills) > 0) {
        $condition = "WHERE SKILL_ID NOT IN (" . $skills[0];
        for ($x = 1; $x < sizeof($skills); $x++) {
            $condition = $condition . ", " . $skills[$x] . " ";
        }
        $condition = $condition . ")";
    }
    $query = "SELECT SKILL_ID, SKILL_DESCRIPTION, SKILL_ID FROM matrix.skills " . $condition . " ORDER BY SKILL_DESCRIPTION ASC";
    return executeSQLQuery($query);
}

function search($search_text) {
    global $search_result;
    $query = "SELECT distinct(e.NAMES), emp_id, e.SHORE, r.ROLE_DESCRIPTION, d.DIV_DESCRIPTION
            FROM employees e, b_employee_skills es, skills s, m_skills_level sl, roles r, divisions d
            WHERE  e.EMP_ID = es.EMPLOYEE_ID
            AND es.SKILL_ID = s.SKILL_ID
            AND es.LEVEL_ID = sl.LEVEL_ID
            AND e.role_id = r.role_id
            AND CONCAT (e.NAMES, s.SKILL_DESCRIPTION, r.ROLE_DESCRIPTION, sl.LEVEL_DESCR) 
            LIKE '%" . $search_text . "%' "
            . " AND r.division_id = d.division_id  ";

    if ($_SESSION['show_offshore'] === false && $_SESSION['show_onshore'] === false) {
        $query = $query . " AND e.shore NOT IN ('Offshore', 'Onshore')";
    } else if ($_SESSION['show_offshore'] === true && $_SESSION['show_onshore'] === false) {
        $query = $query . " AND e.shore <> 'Onshore'";
    } else if ($_SESSION['show_offshore'] === false && $_SESSION['show_onshore'] === true) {
        $query = $query . " AND e.shore <> 'Offshore'";
    }
    $query = $query . " ORDER BY e.shore DESC, e.NAMES ";
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
    $connect = mysqli_connect("localhost", "root", "", "matrix");
    return mysqli_query($connect, $query);
}

function getEmployeeSkillLevel($ID, $skill_ID) {
    $query = "SELECT LEVEL_DESCR, SKILL_DESCRIPTION
FROM b_employee_skills es, skills s, m_skills_level l
WHERE s.SKILL_ID = '" . $skill_ID . "' " .
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

function getLevels() {
    $query = "SELECT LEVEL_ID, LEVEL_DESCR FROM M_SKILLS_LEVEL ORDER BY LEVEL_ID";
    return executeSQLQuery($query);
}

function getLevelByID($ID) {
    $query = "SELECT LEVEL_DESCR FROM M_SKILLS_LEVEL WHERE LEVEL_ID = '" . $ID . "'";
    $result = executeSQLQuery($query);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)):
            return $row['LEVEL_DESCR'];
        endwhile;
    }
    return "";
}

function getRoleByID($ID) {
    $query = "SELECT ROLE_DESCRIPTION FROM ROLES WHERE ROLE_ID = '" . $ID . "'";
    $result = executeSQLQuery($query);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)):
            return $row['ROLE_DESCRIPTION'];
        endwhile;
    }
    return "";
}

?>
