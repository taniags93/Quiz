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
  `StudentID` INT NOT NULL,
  `Username` VARCHAR(45) NULL,
  `Passcode` VARCHAR(45) NULL,
  PRIMARY KEY (`StudentID`),
  UNIQUE INDEX `StudentID_UNIQUE` (`StudentID` ASC),
  UNIQUE INDEX `username_UNIQUE` (`Username` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Quiz`.`Quiz`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Quiz`.`Quiz` (
  `QuizID` INT NOT NULL,
  `Title` VARCHAR(45) NULL,
  `Duration` INT NULL,
  PRIMARY KEY (`QuizID`),
  UNIQUE INDEX `QuizID_UNIQUE` (`QuizID` ASC),
  UNIQUE INDEX `Title_UNIQUE` (`Title` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Quiz`.`Question`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Quiz`.`Question` (
  `QuestionID` INT NOT NULL,
  `Title` VARCHAR(45) NULL,
  `QuizID` INT NOT NULL,
  PRIMARY KEY (`QuestionID`),
  UNIQUE INDEX `QuestionID_UNIQUE` (`QuestionID` ASC),
  INDEX `fk_Question_Quiz_idx` (`QuizID` ASC),
  CONSTRAINT `fk_Question_Quiz`
    FOREIGN KEY (`QuizID`)
    REFERENCES `Quiz`.`Quiz` (`QuizID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Quiz`.`Options`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Quiz`.`Options` (
  `OptionID` INT NOT NULL,
  `Title` VARCHAR(45) NULL,
  `Score` DECIMAL(2) NULL,
  `QuestionID` INT NOT NULL,
  PRIMARY KEY (`OptionID`),
  UNIQUE INDEX `OptionID_UNIQUE` (`OptionID` ASC),
  INDEX `fk_Options_Question1_idx` (`QuestionID` ASC),
  CONSTRAINT `fk_Options_Question1`
    FOREIGN KEY (`QuestionID`)
    REFERENCES `Quiz`.`Question` (`QuestionID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Quiz`.`Transcript`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Quiz`.`Transcript` (
  `TranscriptID` INT NOT NULL,
  `Score` DECIMAL(2) NULL,
  `StudentID` INT NOT NULL,
  `QuizID` INT NOT NULL,
  PRIMARY KEY (`TranscriptID`),
  UNIQUE INDEX `StudentID_UNIQUE` (`TranscriptID` ASC),
  INDEX `fk_Transcript_Student1_idx` (`StudentID` ASC),
  INDEX `fk_Transcript_Quiz1_idx` (`QuizID` ASC),
  CONSTRAINT `fk_Transcript_Student1`
    FOREIGN KEY (`StudentID`)
    REFERENCES `Quiz`.`Student` (`StudentID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Transcript_Quiz1`
    FOREIGN KEY (`QuizID`)
    REFERENCES `Quiz`.`Quiz` (`QuizID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
