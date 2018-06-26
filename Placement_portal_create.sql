-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2018-06-14 08:35:03.608

-- tables
-- Table: Jobs
CREATE TABLE IF NOT EXISTS jobs (
    id int NOT NULL AUTO_INCREMENT,
    company_name varchar(32) NOT NULL,
    job_title varchar(20) NOT NULL,
    designation varchar(20) NOT NULL,
    description text NOT NULL,
    branch int NOT NULL,
    no_of_applications int NOT NULL DEFAULT 0,
    date_added date NOT NULL,
    last_date_for_apply date NOT NULL,
    posted_by int NOT NULL,
    CONSTRAINT Jobs_pk PRIMARY KEY (id)
) COMMENT 'Data for jobs';

-- Table: Jobs_Applied
CREATE TABLE IF NOT EXISTS jobs_applied (
    jobs_id int NOT NULL,
    student_id int NOT NULL,
    status enum NOT NULL,
    resume_id int NOT NULL,
    phone int NOT NULL,
    email varchar(50) NOT NULL,
    college varchar(50) NOT NULL,
    CONSTRAINT Jobs_Applied_pk PRIMARY KEY (jobs_id,student_id)
) COMMENT 'Total no of applicants on the job';

-- Table: Student
CREATE TABLE IF NOT EXISTS student (
    id int NOT NULL AUTO_INCREMENT,
    first_name varchar(32) NOT NULL,
    last_name varchar(32) NOT NULL,
    email varchar(50) NOT NULL,
    password char(64) NOT NULL,
    last_phone int NOT NULL,
    last_resume char(20) NOT NULL,
    dob date NOT NULL,
    gender enum NOT NULL,
    email_verified bool NOT NULL,
    phone_verified bool NOT NULL,
    last_location_id int NOT NULL,
    no_of_jobs_applied int NOT NULL DEFAULT 0,
    CONSTRAINT Student_pk PRIMARY KEY (id)
) COMMENT 'Table for students records';

-- Table: colleges
CREATE TABLE IF NOT EXISTS colleges (
    college_name int NOT NULL,
    Student_id int NOT NULL,
    year_of_passing int NOT NULL,
    specialization_id int NOT NULL,
    CONSTRAINT colleges_pk PRIMARY KEY (Student_id)
);

-- Table: course
CREATE TABLE IF NOT EXISTS course (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(20) NOT NULL,
    highest_qualification_id int NOT NULL,
    CONSTRAINT course_pk PRIMARY KEY (id)
);

-- Table: employer
CREATE TABLE IF NOT EXISTS employer (
    id int NOT NULL AUTO_INCREMENT,
    password char(64) NOT NULL,
    no_of_jobs_posted int NOT NULL DEFAULT 0,
    access_level enum NOT NULL,
    invited_by int NOT NULL,
    email varchar(50) NOT NULL,
    CONSTRAINT employer_pk PRIMARY KEY (id)
) COMMENT 'Details for employer';

-- Table: highest_qualification
CREATE TABLE IF NOT EXISTS highest_qualification (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(10) NOT NULL,
    CONSTRAINT highest_qualification_pk PRIMARY KEY (id)
);

-- Table: jobs_skills
CREATE TABLE IF NOT EXISTS jobs_skills (
    Jobs_id int NOT NULL,
    skills_id int NOT NULL,
    CONSTRAINT jobs_skills_pk PRIMARY KEY (Jobs_id,skills_id)
);

-- Table: location
CREATE TABLE IF NOT EXISTS location (
    id int NOT NULL,
    name varchar(20) NOT NULL,
    CONSTRAINT location_pk PRIMARY KEY (id)
) COMMENT 'Data for location';

-- Table: location_for_jobs
CREATE TABLE IF NOT EXISTS location_for_jobs (
    Jobs_id int NOT NULL,
    location_id int NOT NULL,
    CONSTRAINT location_for_jobs_pk PRIMARY KEY (Jobs_id,location_id)
);

-- Table: locations.json
CREATE TABLE IF NOT EXISTS locations (
    Student_id int NOT NULL,
    location_id int NOT NULL,
    CONSTRAINT locations_pk PRIMARY KEY (Student_id,location_id)
);

-- Table: resume
CREATE TABLE IF NOT EXISTS resume (
    resume varchar(20) NOT NULL,
    Student_id int NOT NULL,
    resume_id int NOT NULL AUTO_INCREMENT,
    CONSTRAINT resume_pk PRIMARY KEY (resume_id)
);

-- Table: skills
CREATE TABLE IF NOT EXISTS skills (
    id int NOT NULL,
    skill_name varchar(10) NOT NULL,
    CONSTRAINT skills_pk PRIMARY KEY (id)
);

-- Table: specialization
CREATE TABLE IF NOT EXISTS specialization (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(20) NOT NULL,
    course_id int NOT NULL,
    CONSTRAINT specialization_pk PRIMARY KEY (id)
);

-- Table: student_skills
CREATE TABLE IF NOT EXISTS student_skills (
    skills_id int NOT NULL,
    Student_id int NOT NULL,
    CONSTRAINT student_skills_pk PRIMARY KEY (skills_id,Student_id)
);

-- foreign keys
-- Reference: Jobs_Applied_Jobs (table: Jobs_Applied)
ALTER TABLE Jobs_Applied ADD CONSTRAINT Jobs_Applied_Jobs FOREIGN KEY Jobs_Applied_Jobs (jobs_id)
    REFERENCES Jobs (id);

-- Reference: Jobs_Applied_Student (table: Jobs_Applied)
ALTER TABLE Jobs_Applied ADD CONSTRAINT Jobs_Applied_Student FOREIGN KEY Jobs_Applied_Student (student_id)
    REFERENCES Student (id);

-- Reference: Jobs_Applied_resume (table: Jobs_Applied)
ALTER TABLE Jobs_Applied ADD CONSTRAINT Jobs_Applied_resume FOREIGN KEY Jobs_Applied_resume (resume_id)
    REFERENCES resume (resume_id);

-- Reference: Jobs_Employer (table: Jobs)
ALTER TABLE Jobs ADD CONSTRAINT Jobs_Employer FOREIGN KEY Jobs_Employer (posted_by)
    REFERENCES employer (id);

-- Reference: Student_location (table: Student)
ALTER TABLE Student ADD CONSTRAINT Student_location FOREIGN KEY Student_location (last_location_id)
    REFERENCES location (id);

-- Reference: colleges_Student (table: colleges)
ALTER TABLE colleges ADD CONSTRAINT colleges_Student FOREIGN KEY colleges_Student (Student_id)
    REFERENCES Student (id);

-- Reference: colleges_specialization (table: colleges)
ALTER TABLE colleges ADD CONSTRAINT colleges_specialization FOREIGN KEY colleges_specialization (specialization_id)
    REFERENCES specialization (id);

-- Reference: course_highest_qualification (table: course)
ALTER TABLE course ADD CONSTRAINT course_highest_qualification FOREIGN KEY course_highest_qualification (highest_qualification_id)
    REFERENCES highest_qualification (id);

-- Reference: jobs_skills_Jobs (table: jobs_skills)
ALTER TABLE jobs_skills ADD CONSTRAINT jobs_skills_Jobs FOREIGN KEY jobs_skills_Jobs (Jobs_id)
    REFERENCES Jobs (id);

-- Reference: jobs_skills_skills (table: jobs_skills)
ALTER TABLE jobs_skills ADD CONSTRAINT jobs_skills_skills FOREIGN KEY jobs_skills_skills (skills_id)
    REFERENCES skills (id);

-- Reference: location_Student (table: locations.json)
ALTER TABLE locations ADD CONSTRAINT location_Student FOREIGN KEY location_Student (Student_id)
    REFERENCES Student (id);

-- Reference: location_for_jobs_Jobs (table: location_for_jobs)
ALTER TABLE location_for_jobs ADD CONSTRAINT location_for_jobs_Jobs FOREIGN KEY location_for_jobs_Jobs (Jobs_id)
    REFERENCES Jobs (id);

-- Reference: location_for_jobs_location (table: location_for_jobs)
ALTER TABLE location_for_jobs ADD CONSTRAINT location_for_jobs_location FOREIGN KEY location_for_jobs_location (location_id)
    REFERENCES location (id);

-- Reference: location_location (table: locations.json)
ALTER TABLE locations ADD CONSTRAINT location_location FOREIGN KEY location_location (location_id)
    REFERENCES location (id);

-- Reference: resume_Student (table: resume)
ALTER TABLE resume ADD CONSTRAINT resume_Student FOREIGN KEY resume_Student (Student_id)
    REFERENCES Student (id);

-- Reference: specialization_course (table: specialization)
ALTER TABLE specialization ADD CONSTRAINT specialization_course FOREIGN KEY specialization_course (course_id)
    REFERENCES course (id);

-- Reference: student_skills_Student (table: student_skills)
ALTER TABLE student_skills ADD CONSTRAINT student_skills_Student FOREIGN KEY student_skills_Student (Student_id)
    REFERENCES Student (id);

-- Reference: student_skills_skills (table: student_skills)
ALTER TABLE student_skills ADD CONSTRAINT student_skills_skills FOREIGN KEY student_skills_skills (skills_id)
    REFERENCES skills (id);

-- End of file.

