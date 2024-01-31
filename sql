// this from chat dont trust shit

-- Create the employees table
CREATE TABLE IF NOT EXISTS employees (
    emp_id INT PRIMARY KEY AUTO_INCREMENT,
    emp_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role VARCHAR(50) NOT NULL
);

-- Create the login_log table
CREATE TABLE IF NOT EXISTS login_log (
    log_id INT PRIMARY KEY AUTO_INCREMENT,
    emp_id INT,
    login_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (emp_id) REFERENCES employees(emp_id)
);

-- Create the user_logs table
CREATE TABLE IF NOT EXISTS user_logs (
    log_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    activity TEXT NOT NULL,
    log_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES employees(emp_id)
);

-- Create the positions table 
CREATE TABLE IF NOT EXISTS positions (
    position_id INT PRIMARY KEY AUTO_INCREMENT,
    position_name VARCHAR(255) NOT NULL,
    position_description TEXT NOT NULL,
    position_type VARCHAR(50) NOT NULL,
    approved BOOLEAN
);

-- Create an index on the position_name column in the positions table
CREATE INDEX idx_positions_position_name ON positions(position_name);

-- Create the contestants table
CREATE TABLE IF NOT EXISTS contestant (
    contestant_id INT PRIMARY KEY AUTO_INCREMENT,
    emp_id INT,
    contestant_name VARCHAR(255),
    position_id INT,
    position_name VARCHAR(255),
    position_type VARCHAR(255),
    INDEX (position_name),
    FOREIGN KEY (emp_id) REFERENCES employees(emp_id),
    FOREIGN KEY (position_id) REFERENCES positions(position_id)
);

-- Create the votes table
CREATE TABLE IF NOT EXISTS votes (
    votes_id INT PRIMARY KEY AUTO_INCREMENT,
    emp_id INT NOT NULL,
    contestant_id INT,
    position_id INT,
    number_of_votes INT NOT NULL DEFAULT 1,
    CONSTRAINT fk_votes_emp FOREIGN KEY (emp_id) REFERENCES employees(emp_id),
    CONSTRAINT fk_votes_contestant FOREIGN KEY (contestant_id) REFERENCES contestant(contestant_id),
    CONSTRAINT fk_votes_position FOREIGN KEY (position_id) REFERENCES positions(position_id)
);
