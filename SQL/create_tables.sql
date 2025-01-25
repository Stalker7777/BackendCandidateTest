DROP TABLE IF EXISTS ads;
DROP TABLE IF EXISTS companies;
DROP TABLE IF EXISTS groups;

CREATE TABLE companies (
   id INT PRIMARY KEY AUTO_INCREMENT,
   name VARCHAR(255) NOT NULL
);

CREATE TABLE groups (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE ads (
    date_consumption INT NOT NULL,
    id INT NOT NULL,
    companies_id INT NOT NULL,
    groups_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    amount_consumption DECIMAL(18,2) NOT NULL,
    shows INT NOT NULL,
    clicks INT NOT NULL,
    PRIMARY KEY (date_consumption, id),
    INDEX IDX_ads_companies_id (companies_id),
    INDEX IDX_ads_groups_id (groups_id),
    CONSTRAINT FK_companies_id FOREIGN KEY (companies_id) REFERENCES companies (id),
    CONSTRAINT FK_groups_id FOREIGN KEY (groups_id) REFERENCES groups (id)
);
