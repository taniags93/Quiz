-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema Quiz
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Quiz
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Quiz` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `Quiz` ;

-- -----------------------------------------------------
-- Table `Quiz`.`Student`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Quiz`.`Student` (
  `StudentID` INT NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(145) NULL,
  `Passcode` VARCHAR(145) NULL,
  PRIMARY KEY (`StudentID`),
  UNIQUE INDEX `StudentID_UNIQUE` (`StudentID` ASC),
  UNIQUE INDEX `username_UNIQUE` (`Username` ASC))
AUTO_INCREMENT=1001;


-- -----------------------------------------------------
-- Table `Quiz`.`Quiz`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Quiz`.`Quiz` (
  `QuizID` INT AUTO_INCREMENT,
  `Title` VARCHAR(145) NOT NULL,
  `MaximumScore` INT,
  `Duration` INT NULL,
  PRIMARY KEY (`QuizID`),
  UNIQUE INDEX `QuizID_UNIQUE` (`QuizID` ASC),
  UNIQUE INDEX `Title_UNIQUE` (`Title` ASC));


-- -----------------------------------------------------
-- Table `Quiz`.`Question`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Quiz`.`Question` (
  `QuestionID` INT AUTO_INCREMENT,
  `Title` VARCHAR(145) NOT NULL,
  `QuizID` INT NOT NULL,
  PRIMARY KEY (`QuestionID`),
  UNIQUE INDEX `QuestionID_UNIQUE` (`QuestionID` ASC),
  INDEX `fk_Question_Quiz_idx` (`QuizID` ASC),
  CONSTRAINT `fk_Question_Quiz`
    FOREIGN KEY (`QuizID`)
    REFERENCES `Quiz`.`Quiz` (`QuizID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `Quiz`.`Options`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Quiz`.`Options` (
  `OptionID` INT AUTO_INCREMENT,
  `Title` VARCHAR(145) NOT NULL,
  `Score` FLOAT NOT NULL DEFAULT 0,
  `QuestionID` INT NOT NULL,
  PRIMARY KEY (`OptionID`),
  UNIQUE INDEX `OptionID_UNIQUE` (`OptionID` ASC),
  INDEX `fk_Options_Question_idx` (`QuestionID` ASC),
  CONSTRAINT `fk_Options_Question`
    FOREIGN KEY (`QuestionID`)
    REFERENCES `Quiz`.`Question` (`QuestionID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `Quiz`.`Test`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Quiz`.`Test` (
  `TestID` INT AUTO_INCREMENT,
  `StudentID` INT NOT NULL,
  `QuizID` INT NOT NULL,
  PRIMARY KEY (`TestID`),
  UNIQUE INDEX `StudentID_UNIQUE` (`TestID` ASC),
  INDEX `fk_Test_Student_idx` (`StudentID` ASC),
  INDEX `fk_Test_Quiz_idx` (`QuizID` ASC),
  CONSTRAINT `fk_Test_Student`
    FOREIGN KEY (`StudentID`)
    REFERENCES `Quiz`.`Student` (`StudentID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Test_Quiz`
    FOREIGN KEY (`QuizID`)
    REFERENCES `Quiz`.`Quiz` (`QuizID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

-- -----------------------------------------------------
-- Table `Quiz`.`Answer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Quiz`.`Answer` (
  `AnswerID` INT AUTO_INCREMENT,
  `TestID` INT NOT NULL,
  `OptionID` INT NOT NULL,
  PRIMARY KEY (`AnswerID`),
  UNIQUE INDEX `TestID_UNIQUE` (`AnswerID` ASC),
  INDEX `fk_Answer_Test_idx` (`TestID` ASC),
  INDEX `fk_Answer_Options_idx` (`OptionID` ASC),
  CONSTRAINT `fk_Answer_Test`
    FOREIGN KEY (`TestID`)
    REFERENCES `Quiz`.`Test` (`TestID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Answer_Options`
    FOREIGN KEY (`OptionID`)
    REFERENCES `Quiz`.`Options` (`OptionID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);
    
-- -----------------------------------------------------
-- Table `Quiz`.`Subject`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Quiz`.`Subject` (
  `SubjectID` INT AUTO_INCREMENT,
  `QuizID` INT NOT NULL,
  `Title` VARCHAR(145) NOT NULL,
  PRIMARY KEY (`SubjectID`),
  UNIQUE INDEX `QuizID_UNIQUE` (`SubjectID` ASC),
  INDEX `fk_Subject_Quiz_idx` (`QuizID` ASC),
  CONSTRAINT `fk_Subject_Quiz`
    FOREIGN KEY (`QuizID`)
    REFERENCES `Quiz`.`Quiz` (`QuizID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);
    
SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
