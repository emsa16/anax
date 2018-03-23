--
-- Creating Book table and inserting example books.
-- Create a database and a user having access to this database,
-- this must be done by hand, see commented rows on how to do it.
-- Default database SQL, NOTE that all database name and account details should
-- be replaced by actual information
--



--
-- Create a database for test and user
--
-- CREATE DATABASE IF NOT EXISTS anaxdb;
-- GRANT ALL ON anaxdb.* TO anax@localhost IDENTIFIED BY 'anax';
-- USE anaxdb;

-- Ensure UTF8 on the database connection
SET NAMES utf8;



--
-- Table Book
--
DROP TABLE IF EXISTS rv1_Book;
CREATE TABLE rv1_Book (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `title` VARCHAR(256) NOT NULL,
    `author` VARCHAR(256) NOT NULL,
    `published`INT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

INSERT INTO rv1_Book(title, author, published) VALUES
    ('1984', 'George Orwell', 1949),
    ('Flugornas herre', 'William Golding', 1954)
;
