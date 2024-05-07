-- Database: LibraryManagement
CREATE DATABASE LibraryManagement;

USE LibraryManagement;

-- Users Table
CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50),
    Password VARCHAR(255), -- Storing hashed passwords
    IsAdmin BOOLEAN
);

-- Memberships Table
CREATE TABLE Memberships (
    MembershipID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    MembershipType ENUM('6 months', '1 year', '2 years'),
    StartDate DATE,
    EndDate DATE,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

-- Transactions Table
CREATE TABLE Transactions (
    TransactionID INT AUTO_INCREMENT PRIMARY KEY,
    MembershipID INT,
    Description VARCHAR(255),
    Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (MembershipID) REFERENCES Memberships(MembershipID)
);

-- Books Table
CREATE TABLE Books (
    BookID INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(255),
    Author VARCHAR(255),
    PublishedYear INT
);
