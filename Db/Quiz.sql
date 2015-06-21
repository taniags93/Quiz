-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema quiz
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema Quiz
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `Quiz` ;

-- -----------------------------------------------------
-- Schema Quiz
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Quiz` ;
USE `Quiz` ;

-- -----------------------------------------------------
-- Table `Quiz`.`Student`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Quiz`.`Student` (
  `StudentID` INT(11) NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(145) NULL DEFAULT NULL,
  `Passcode` VARCHAR(145) NULL DEFAULT NULL,
  PRIMARY KEY (`StudentID`),
  UNIQUE INDEX `StudentID_UNIQUE` (`StudentID` ASC),
  UNIQUE INDEX `username_UNIQUE` (`Username` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `Quiz`.`Subject`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Quiz`.`Subject` (
  `SubjectID` INT(11) NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(145) NOT NULL,
  PRIMARY KEY (`SubjectID`),
  UNIQUE INDEX `QuizID_UNIQUE` (`SubjectID` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `Quiz`.`Quiz`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Quiz`.`Quiz` (
  `QuizID` INT(11) NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(145) NOT NULL,
  `MaximumScore` INT(11) NULL DEFAULT NULL,
  `Duration` INT(11) NULL DEFAULT NULL,
  `SubjectID` INT(11) NOT NULL,
  PRIMARY KEY (`QuizID`),
  UNIQUE INDEX `QuizID_UNIQUE` (`QuizID` ASC),
  UNIQUE INDEX `Title_UNIQUE` (`Title` ASC),
  INDEX `fk_Quiz_Subject1_idx` (`SubjectID` ASC),
  CONSTRAINT `fk_Quiz_Subject1`
    FOREIGN KEY (`SubjectID`)
    REFERENCES `Quiz`.`Subject` (`SubjectID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `Quiz`.`Test`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Quiz`.`Test` (
  `TestID` INT(11) NOT NULL AUTO_INCREMENT,
  `StudentID` INT(11) NOT NULL,
  `QuizID` INT(11) NOT NULL,
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
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `Quiz`.`Question`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Quiz`.`Question` (
  `QuestionID` INT(11) NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(145) NOT NULL,
  `QuizID` INT(11) NOT NULL,
  PRIMARY KEY (`QuestionID`),
  UNIQUE INDEX `QuestionID_UNIQUE` (`QuestionID` ASC),
  INDEX `fk_Question_Quiz_idx` (`QuizID` ASC),
  CONSTRAINT `fk_Question_Quiz`
    FOREIGN KEY (`QuizID`)
    REFERENCES `Quiz`.`Quiz` (`QuizID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `Quiz`.`Option`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Quiz`.`Option` (
  `OptionID` INT(11) NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(145) NOT NULL,
  `Score` FLOAT NOT NULL DEFAULT '0',
  `QuestionID` INT(11) NOT NULL,
  PRIMARY KEY (`OptionID`),
  UNIQUE INDEX `OptionID_UNIQUE` (`OptionID` ASC),
  INDEX `fk_Options_Question_idx` (`QuestionID` ASC),
  CONSTRAINT `fk_Options_Question`
    FOREIGN KEY (`QuestionID`)
    REFERENCES `Quiz`.`Question` (`QuestionID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `Quiz`.`Answer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Quiz`.`Answer` (
  `TestID` INT(11) NOT NULL,
  `OptionID` INT(11) NOT NULL,
  INDEX `fk_Answer_Test_idx` (`TestID` ASC),
  INDEX `fk_Answer_Options_idx` (`OptionID` ASC),
  PRIMARY KEY (`TestID`, `OptionID`),
  CONSTRAINT `fk_Answer_Test`
    FOREIGN KEY (`TestID`)
    REFERENCES `Quiz`.`Test` (`TestID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Answer_Options`
    FOREIGN KEY (`OptionID`)
    REFERENCES `Quiz`.`Option` (`OptionID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
