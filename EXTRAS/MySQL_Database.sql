/*DROPPING ALL CONTRAINTS*/

ALTER TABLE MATRIX.SKILLS
DROP FOREIGN KEY FK_SKILL_CATEG;

ALTER TABLE MATRIX.ROLES
DROP FOREIGN KEY FK_DIV_ROLE;

ALTER TABLE MATRIX.EMPLOYEES
DROP FOREIGN KEY FK_ROLE;

ALTER TABLE MATRIX.B_EMPLOYEE_SKILLS
DROP FOREIGN KEY FK_EMP_SKILL, 
DROP FOREIGN KEY  FK_SKILL, 
DROP FOREIGN KEY  FK_LEVEL;

/*DROPPING ALL TABLES*/
DROP TABLE IF EXISTS MATRIX.USERS;
DROP TABLE IF EXISTS MATRIX.EMPLOYEES;
DROP TABLE IF EXISTS MATRIX.SKILLS;
DROP TABLE IF EXISTS MATRIX.DIVISIONS;
DROP TABLE IF EXISTS MATRIX.M_SKILLS_LEVEL;
DROP TABLE IF EXISTS MATRIX.B_EMPLOYEE_SKILLS;
DROP TABLE IF EXISTS MATRIX.ROLES;
DROP TABLE IF EXISTS MATRIX.SKILL_CATEGORY;
DROP TABLE IF EXISTS MATRIX.B_EMPLOYEE_ROLES;

DROP SCHEMA IF EXISTS MATRIX;
CREATE SCHEMA MATRIX;

CREATE TABLE MATRIX.USERS
(USERNAME VARCHAR(60) PRIMARY KEY,
 EMAIL VARCHAR(60) NOT NULL UNIQUE,
 PASS VARCHAR(60) NOT NULL);

CREATE TABLE MATRIX.EMPLOYEES
(EMP_ID INT AUTO_INCREMENT PRIMARY KEY,
NAMES VARCHAR(60) NOT NULL,
SHORE VARCHAR(20) NOT NULL,
ROLE_ID INT NOT NULL);

CREATE TABLE MATRIX.DIVISIONS
(DIVISION_ID INT AUTO_INCREMENT PRIMARY KEY,
 DIV_DESCRIPTION VARCHAR(60) NOT NULL);

CREATE TABLE MATRIX.SKILLS
(SKILL_ID INT AUTO_INCREMENT PRIMARY KEY, 
SKILL_DESCRIPTION VARCHAR(60) NOT NULL,
CATEG_ID INT NOT NULL);

CREATE TABLE MATRIX.SKILL_CATEGORY
(ID INT AUTO_INCREMENT PRIMARY KEY, 
CATEG_DESCRIPTION VARCHAR(60) NOT NULL);

CREATE TABLE MATRIX.M_SKILLS_LEVEL
(LEVEL_ID INT AUTO_INCREMENT PRIMARY KEY,
LEVEL_DESCR VARCHAR(30) NOT NULL);

CREATE TABLE MATRIX.B_EMPLOYEE_SKILLS
(EMPLOYEE_ID INT NOT NULL,
SKILL_ID INT NOT NULL,
LEVEL_ID INT NOT NULL,
PRIMARY KEY (EMPLOYEE_ID, SKILL_ID));

CREATE TABLE MATRIX.ROLES
(ROLE_ID INT AUTO_INCREMENT PRIMARY KEY,
 ROLE_DESCRIPTION VARCHAR(60) NOT NULL,
 DIVISION_ID INT NOT NULL);
 
/* ADDING CONTRAINTS
-- FOR SKILLS TABLE*/
ALTER TABLE MATRIX.SKILLS
ADD CONSTRAINT FK_SKILL_CATEG
FOREIGN KEY (CATEG_ID) 
REFERENCES MATRIX.SKILL_CATEGORY(ID);

/* FOR ROLES TABLE*/
ALTER TABLE MATRIX.ROLES
ADD CONSTRAINT FK_DIV_ROLE
FOREIGN KEY (DIVISION_ID) 
REFERENCES MATRIX.DIVISIONS(DIVISION_ID);

/* FOR EMPLOYEES TABLE*/
ALTER TABLE MATRIX.EMPLOYEES
ADD CONSTRAINT FK_ROLE
FOREIGN KEY (ROLE_ID) 
REFERENCES MATRIX.ROLES(ROLE_ID);


/* FOR EMPLOYEE SKILLS BRIDGE*/
ALTER TABLE MATRIX.B_EMPLOYEE_SKILLS
ADD CONSTRAINT FK_EMP_SKILL
FOREIGN KEY (EMPLOYEE_ID) 
REFERENCES MATRIX.EMPLOYEES(EMP_ID),
ADD CONSTRAINT FK_SKILL
FOREIGN KEY (SKILL_ID)
REFERENCES MATRIX.SKILLS(SKILL_ID),
ADD CONSTRAINT FK_LEVEL 
FOREIGN KEY (LEVEL_ID)
REFERENCES MATRIX.M_SKILLS_LEVEL(LEVEL_ID);

/*INSERING LEVELS */
INSERT INTO MATRIX.M_SKILLS_LEVEL(LEVEL_DESCR)
VALUES('Entry Level');

INSERT INTO MATRIX.M_SKILLS_LEVEL(LEVEL_DESCR)
VALUES('Intermediate');

INSERT INTO MATRIX.M_SKILLS_LEVEL(LEVEL_DESCR)
VALUES('Advanced');

INSERT INTO MATRIX.M_SKILLS_LEVEL(LEVEL_DESCR)
VALUES('Certified');

/*INSERING USERS */
INSERT INTO MATRIX.USERS(USERNAME, EMAIL, PASS)
VALUES('andile', 'andile.hlophe@zensar.com', 'Zxc@123');

INSERT INTO MATRIX.USERS(USERNAME, EMAIL, PASS)
VALUES('dynah', 'tsokolo.khama@zensar.com', 'Zxc@123');

INSERT INTO MATRIX.USERS(USERNAME, EMAIL, PASS)
VALUES('ntshovelo', 'ntshovelo.makwarela@zensar.com', 'Zxc@123');

INSERT INTO MATRIX.USERS(USERNAME, EMAIL, PASS)
VALUES('root', 'n.makwarela93@gmail.com', 'S3qcsSG');


/*INSERING CATEGORIES */
INSERT INTO MATRIX.SKILL_CATEGORY(CATEG_DESCRIPTION)
VALUES('Other');

INSERT INTO MATRIX.SKILL_CATEGORY(CATEG_DESCRIPTION)
VALUES('Testing');

INSERT INTO MATRIX.SKILL_CATEGORY(CATEG_DESCRIPTION)
VALUES('MS Office');

INSERT INTO MATRIX.SKILL_CATEGORY(CATEG_DESCRIPTION)
VALUES('Monitoring Tools');

INSERT INTO MATRIX.SKILL_CATEGORY(CATEG_DESCRIPTION)
VALUES('ITIL');

INSERT INTO MATRIX.SKILL_CATEGORY(CATEG_DESCRIPTION)
VALUES('Ticketing Tools');

INSERT INTO MATRIX.SKILL_CATEGORY(CATEG_DESCRIPTION)
VALUES('Investigation Tools');

INSERT INTO MATRIX.SKILL_CATEGORY(CATEG_DESCRIPTION)
VALUES('Investigation Tools 2');

INSERT INTO MATRIX.SKILL_CATEGORY(CATEG_DESCRIPTION)
VALUES('Product');

/*INSERING DIVISIONS */
INSERT INTO MATRIX.DIVISIONS(DIV_DESCRIPTION)
VALUES('Testing');

INSERT INTO MATRIX.DIVISIONS(DIV_DESCRIPTION)
VALUES('Devops');

INSERT INTO MATRIX.DIVISIONS(DIV_DESCRIPTION)
VALUES('Incident Management');

INSERT INTO MATRIX.DIVISIONS(DIV_DESCRIPTION)
VALUES('OPs');

/*INSERTING ROLES*/
INSERT INTO MATRIX.ROLES(ROLE_DESCRIPTION, DIVISION_ID)
VALUES('Sr. Test Manager', 1);

INSERT INTO MATRIX.ROLES(ROLE_DESCRIPTION, DIVISION_ID)
VALUES('Sr. Test Analyst', 1);

INSERT INTO MATRIX.ROLES(ROLE_DESCRIPTION, DIVISION_ID)
VALUES('Sr. Lead', 1);

INSERT INTO MATRIX.ROLES(ROLE_DESCRIPTION, DIVISION_ID)
VALUES('Test Analyst', 1);

INSERT INTO MATRIX.ROLES(ROLE_DESCRIPTION, DIVISION_ID)
VALUES('Tester', 1);

INSERT INTO MATRIX.ROLES(ROLE_DESCRIPTION, DIVISION_ID)
VALUES('Jr. Tester', 1);

INSERT INTO MATRIX.ROLES(ROLE_DESCRIPTION, DIVISION_ID)
VALUES('DevOps Architect', 2);

INSERT INTO MATRIX.ROLES(ROLE_DESCRIPTION, DIVISION_ID)
VALUES('DevOps Engineer',2);

INSERT INTO MATRIX.ROLES(ROLE_DESCRIPTION, DIVISION_ID)
VALUES('Senior DevOps Engineer', 2);

INSERT INTO MATRIX.ROLES(ROLE_DESCRIPTION, DIVISION_ID)
VALUES('Incident Coordinator',3);

INSERT INTO MATRIX.ROLES(ROLE_DESCRIPTION, DIVISION_ID)
VALUES('Incident Analyst', 3);

INSERT INTO MATRIX.ROLES(ROLE_DESCRIPTION, DIVISION_ID)
VALUES('Monitoring Analyst',3);

INSERT INTO MATRIX.ROLES(ROLE_DESCRIPTION, DIVISION_ID)
VALUES('Team Lead', 4);

INSERT INTO MATRIX.ROLES(ROLE_DESCRIPTION, DIVISION_ID)
VALUES('Operation Analyst',4);

INSERT INTO MATRIX.ROLES(ROLE_DESCRIPTION, DIVISION_ID)
VALUES('Problem Manager', 4);

INSERT INTO MATRIX.ROLES(ROLE_DESCRIPTION, DIVISION_ID)
VALUES('Buisness Analyst',4);

/*INSERING SKILLS FOR TESTING CATEGORY*/
INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('VMP', 2);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Mobile App', 2);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('FitNesse', 2);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Test Rail', 2);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Jira', 2);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Automation', 2);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('VSP', 2);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Gatling', 2);

/*INSERING SKILLS FOR MS Office CATEGORY*/
INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('MS Word', 3);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('MS Excel', 3);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('MS Power Point', 3);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('MS Visio', 3);

/*INSERING SKILLS FOR Monitoring Tools CATEGORY*/

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Grafana', 4);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Azure', 4);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Dynatrace', 4);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('AWS', 4);

/*INSERING SKILLS FOR ITIL CATEGORY*/
INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('ITIL Foundation', 5);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('ITIL Service Operations Intermediate', 5);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('ITIL Service Transition Intermediate', 5);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('ITIL Service Design Intermediate', 5);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('ITIL Service Strategy Intermediate', 5);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('ITIL CSI Intermediate', 5);

/*INSERING SKILLS FOR Ticketing Tools CATEGORY*/

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('CA Tool', 6);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Generali - Service Now', 6);

/*INSERING SKILLS FOR Other CATEGORY*/
INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Git', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('OpenShift Dashboard', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Dashbord', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Kubectl', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Install', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Clustering', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Docker', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Prometheus', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('RHEL', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Centos', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Ubuntu', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Debian', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('ElasticSearch', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Fluent', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('CFEngine', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Ansible', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Terraform', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Java', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Python', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Jenkins', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Gerrit', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Bitbucket', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Obsidian', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Tomcat', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Hashicorp Vault', 1);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Zookeeper', 1);

/*INSERING SKILLS FOR Investigation Tools CATEGORY*/
INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('WSO2 API', 7);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('LifeRay', 7);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Swagger', 7);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Zuul', 7);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Openshift', 7);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('MDA', 7);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Kibana', 7);

/*INSERING SKILLS FOR Investigation Tools 2 CATEGORY*/
INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Linux Server Comands', 8);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Kubernetes Architecture', 8);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Kafka', 8);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('Database', 8);

/*INSERING SKILLS FOR Product CATEGORY*/
INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('V1', 9);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('VDP', 9);

INSERT INTO MATRIX.SKILLS(SKILL_DESCRIPTION, CATEG_ID)
VALUES('AR', 9);

/*Inserting Employees*/

INSERT INTO MATRIX.EMPLOYEES(NAMES, SHORE, ROLE_ID)
VALUES ('Amit Kanoujia', 'Offshore', 1);

INSERT INTO MATRIX.EMPLOYEES(NAMES, SHORE, ROLE_ID)
VALUES ('Ankur Tiwari', 'Offshore', 2);

INSERT INTO MATRIX.EMPLOYEES(NAMES, SHORE, ROLE_ID)
VALUES('Harmanpreet Bhatia','offshore', 5);

INSERT INTO MATRIX.EMPLOYEES(NAMES, SHORE, ROLE_ID)
VALUES('Shamin Pathan','Onshore',4);

INSERT INTO MATRIX.EMPLOYEES(NAMES, SHORE, ROLE_ID)
VALUES('Vanessa Boipelo Matlala','Onshore', 6);

INSERT INTO MATRIX.EMPLOYEES(NAMES, SHORE, ROLE_ID)
VALUES('Gladys Moiana','Onshore', 11);

INSERT INTO MATRIX.EMPLOYEES(NAMES, SHORE, ROLE_ID)
VALUES('Luthando Hlati','Onshore', 12);

INSERT INTO MATRIX.EMPLOYEES(NAMES, SHORE, ROLE_ID)
VALUES('Pooja Shinde','Offshore', 10);

INSERT INTO MATRIX.EMPLOYEES(NAMES, SHORE, ROLE_ID)
VALUES('Jagruti patil','Offshore', 11);

INSERT INTO MATRIX.EMPLOYEES(NAMES, SHORE, ROLE_ID)
VALUES('Peeyush Ahluwalia','Onshore', 13);

INSERT INTO MATRIX.EMPLOYEES(NAMES, SHORE, ROLE_ID)
VALUES('Jagdeep Kumar','Offshore', 14);

INSERT INTO MATRIX.EMPLOYEES(NAMES, SHORE, ROLE_ID)
VALUES('Anil Kumar Talakokkula','Offshore', 15);

INSERT INTO MATRIX.EMPLOYEES(NAMES, SHORE, ROLE_ID)
VALUES('Rohini Nair','Offshore', 16);

INSERT INTO MATRIX.EMPLOYEES(NAMES, SHORE, ROLE_ID)
VALUES('Nitin Pawar','Onshore', 9);

INSERT INTO MATRIX.EMPLOYEES(NAMES, SHORE, ROLE_ID)
VALUES('Moshe Immerman','Onshore', 7);

INSERT INTO MATRIX.EMPLOYEES(NAMES, SHORE, ROLE_ID)
VALUES('Surya Kalchetti','Onshore', 8);


INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(1, 1, 1 );

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(1, 2, 1 );

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(1, 4, 1 );

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(1, 5, 1 );

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(1, 6, 2 );

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(1, 7, 1 );

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(2, 1,1 );

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(2, 2,1 );

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(2, 4, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(2, 5, 1 );

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(2, 6, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(2, 7, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(3, 1, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(3, 2, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(3, 4, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(3, 5, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(3, 6, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(4, 1, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(4, 2, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(4, 4, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(4, 5, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(4, 6, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(4, 7, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(5, 1, 1 );

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(5, 2, 1 );

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(5, 4, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(5, 5, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(6,9, 3);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(6, 10, 3);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(6, 11, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(6, 12, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(6, 17, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(6, 18, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(6, 19, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(6, 20, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(6, 21, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(6, 22, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(7, 9, 3);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(7, 10, 3);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(7, 11, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(7, 12, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(7, 18, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(7, 21, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(8, 17, 4);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(8, 18, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(9, 17, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(9, 18, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(10, 51, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(10, 52, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(10, 53, 3);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(10, 26, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(10, 56, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(10, 57, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(10, 58, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(10, 59, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(10, 60, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(10, 3, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(10, 61, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(11, 51, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(11, 52, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(11, 53, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(11, 26, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(11, 56, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(11, 57, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(11, 58, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(11, 59, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(11, 60, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(11, 3, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(11, 61, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(12, 9, 3);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(12, 10, 3);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(12, 11, 3);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(12, 12, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(12, 23, 3);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(13, 9, 3);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(13, 10, 3);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(13, 11, 3);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(13, 12, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(14, 13, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(14, 14, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(14, 16, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(15, 13, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(15, 14, 2);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(15, 15, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(15, 16, 3);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(16, 13, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(16, 14, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(16, 15, 1);

INSERT INTO MATRIX.B_EMPLOYEE_SKILLS(EMPLOYEE_ID, SKILL_ID, LEVEL_ID)
VALUES(16, 16, 1);

