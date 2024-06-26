-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2024 at 06:55 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `separateshopmaindb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartID` int(11) NOT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `ItemQuantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CartID`, `ProductID`, `CustomerID`, `ItemQuantity`) VALUES
(48, 5, 1, 1),
(49, 5, 1, 1),
(53, 2, 2, 1),
(54, 2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `CategoryDescription` varchar(255) DEFAULT NULL,
  `CategoryName` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `CategoryDescription`, `CategoryName`) VALUES
(1, 'Electronics', 'Electronics'),
(2, 'Clothing', 'Clothing'),
(3, 'Home and Garden', 'Home & Garden'),
(4, 'Books', 'Books'),
(5, 'Toys', 'Toys'),
(6, 'Appliances', 'Appliances'),
(7, 'Furniture', 'Furniture'),
(8, 'Beauty', 'Beauty'),
(9, 'Sports', 'Sports'),
(10, 'Jewelry', 'Jewelry'),
(11, 'Automotive', 'Automotive'),
(12, 'Food', 'Food'),
(13, 'Health', 'Health'),
(14, 'Music', 'Music');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(11) NOT NULL,
  `CustomerName` varchar(255) DEFAULT NULL,
  `CustomerTPNo` varchar(15) DEFAULT NULL,
  `CustomerAddHouseNo` varchar(50) DEFAULT NULL,
  `CustomerAddStreetNo` varchar(50) DEFAULT NULL,
  `CustomerAddCity` varchar(50) DEFAULT NULL,
  `CustomerDOB` date DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `CustomerName`, `CustomerTPNo`, `CustomerAddHouseNo`, `CustomerAddStreetNo`, `CustomerAddCity`, `CustomerDOB`, `UserID`) VALUES
(1, 'David Customer', '123456789', '12A', 'Main St', 'Cityville', '1990-05-15', 4),
(2, 'Eva Example', '987654321', '34B', 'Oak Ave', 'Townsville', '1985-12-03', 5),
(3, 'Grace Buyer', '111223344', '56C', 'Maple Rd', 'Villagetown', '1992-08-20', 1),
(5, 'Olivia Client', '999000111', '90E', 'Pine Blvd', 'Metropolis', '1995-11-28', 3),
(6, 'Liam Consumer', '456789012', '22F', 'Birch Street', 'Citytown', '1994-09-14', 6),
(7, 'Sophia Buyer', '123987456', '44G', 'Elm Lane', 'Suburbville', '1997-03-02', 7),
(8, 'Mason Shopper', '789321654', '66H', 'Cypress Road', 'Towndale', '1987-07-18', 8),
(9, 'Isabella Client', '654123987', '88I', 'Maple Avenue', 'Villageville', '1998-12-09', 9),
(10, 'Jackson Consumer', '321456987', '10J', 'Oak Street', 'Citydale', '1993-06-27', 10),
(11, 'Ava Buyer', '159753468', '32K', 'Birch Lane', 'Suburbtown', '1996-01-31', 11),
(12, 'Logan Shopper', '852369147', '54L', 'Elm Road', 'Towndale', '1991-10-23', 12);

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `OrderItemListID` int(11) NOT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `ItemsCount` int(11) DEFAULT NULL,
  `OrderID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`OrderItemListID`, `ProductID`, `ItemsCount`, `OrderID`) VALUES
(35, 7, 1, 11),
(36, 5, 1, 12),
(37, 9, 1, 12),
(38, 9, 1, 12),
(39, 6, 1, 12),
(40, 3, 1, 12),
(41, 7, 1, 12),
(42, 1, 1, 12),
(43, 5, 1, 13),
(44, 5, 1, 13),
(45, 2, 1, 14),
(46, 2, 1, 14);

-- --------------------------------------------------------

--
-- Table structure for table `ordertable`
--

CREATE TABLE `ordertable` (
  `OrderID` int(11) NOT NULL,
  `DeliveryLocation` varchar(255) DEFAULT NULL,
  `OrderTotal` decimal(10,2) DEFAULT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `MobileNumber01` int(10) NOT NULL,
  `MobileNumber02` int(10) NOT NULL,
  `OrderDate` date DEFAULT NULL,
  `OrderTime` time DEFAULT NULL,
  `OrderQuantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordertable`
--

INSERT INTO `ordertable` (`OrderID`, `DeliveryLocation`, `OrderTotal`, `CustomerID`, `MobileNumber01`, `MobileNumber02`, `OrderDate`, `OrderTime`, `OrderQuantity`) VALUES
(11, '12A, Main St, Cityville', 1294.94, 1, 755544556, 755544557, '2023-12-30', '09:11:43', 0),
(12, '12A, Main St, Cityville', 1494.93, 1, 755544856, 755546557, '2023-12-31', '10:06:11', 0),
(13, '12A, Main St, Cityville', 29.98, 1, 755544556, 755544557, '2024-01-03', '14:19:57', 0),
(14, '34B, Oak Ave, Townsville', 99.98, 2, 755544556, 755544557, '2024-01-06', '20:06:28', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `ProductExpDate` date DEFAULT NULL,
  `ProductMnuDate` date DEFAULT NULL,
  `ProductPrice` decimal(10,2) DEFAULT NULL,
  `ProductName` varchar(255) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `ProductQuantity` int(11) DEFAULT NULL,
  `Availability` varchar(100) NOT NULL,
  `ProductImage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductExpDate`, `ProductMnuDate`, `ProductPrice`, `ProductName`, `CategoryID`, `ProductQuantity`, `Availability`, `ProductImage`) VALUES
(1, '2023-12-31', '2023-01-15', 199.99, 'Smartphone', 1, 50, 'Available', 'smartphone.jpg'),
(2, '2024-06-30', '2023-03-05', 49.99, 'T-shirt', 2, 100, 'Available', 'tshirt.jpg'),
(3, '2023-10-15', '2023-02-01', 399.99, 'Lawn Mower', 3, 20, 'Available', 'lawnmower.jpg'),
(4, '2024-01-01', '2023-04-20', 29.99, 'Novel', 4, 80, 'Available', 'novel.jpg'),
(5, '2023-08-31', '2023-01-30', 14.99, 'Action Figure', 5, 200, 'Available', 'actionfigure.jpg'),
(6, '2023-11-30', '2023-02-15', 799.99, '4K TV', 1, 30, 'Available', '4ktv.jpg'),
(7, '2024-04-15', '2023-05-20', 59.99, 'Jeans', 2, 150, 'Available', 'jeans.jpg'),
(8, '2023-09-30', '2023-03-10', 149.99, 'Garden Hose', 3, 40, 'Available', 'gardenhose.jpg'),
(9, '2023-07-31', '2023-04-25', 9.99, 'Notebook', 4, 120, 'Available', 'notebook.jpg'),
(10, '2023-12-15', '2023-01-30', 24.99, 'Board Game', 5, 80, 'Available', 'boardgame.jpg'),
(11, '2024-02-28', '2023-07-05', 199.99, 'Blender', 6, 25, 'Available', 'blender.jpg'),
(12, '2023-06-15', '2023-04-15', 129.99, 'Coffee Table', 7, 50, 'Available', 'coffeetable.jpg'),
(13, '2023-10-31', '2023-08-20', 49.99, 'Lipstick Set', 8, 100, 'Available', 'lipstickset.jpg'),
(14, '2024-03-30', '2023-10-10', 29.99, 'Yoga Mat', 9, 75, 'Available', 'yogamat.jpg'),
(15, '2023-11-15', '2023-06-25', 14.99, 'Guitar Strings', 10, 200, 'Available', 'guitarstrings.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `StaffID` int(11) NOT NULL,
  `StaffType` varchar(50) DEFAULT NULL,
  `StaffName` varchar(255) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`StaffID`, `StaffType`, `StaffName`, `UserID`) VALUES
(1, 'Manager', 'Michael Manager', 1),
(2, 'Inventory Handling Clerk', 'Sandra Sales', 17),
(3, 'Support', 'Steve Support', 3),
(4, 'Admin', 'Alex Admin', 3),
(5, 'Salesperson', 'Sophie Sales', 2),
(6, 'Manager', 'Mark Manager', 6),
(7, 'Support', 'Susan Support', 7),
(8, 'Admin', 'Andrew Admin', 8),
(9, 'Salesperson', 'Sharon Sales', 9),
(10, 'Manager', 'Matthew Manager', 10),
(11, 'Salesperson', 'Emily Sales', 11),
(12, 'Support', 'Scott Support', 12),
(13, 'Admin', 'Anna Admin', 13),
(14, 'Chief Accountant', 'Chris Sales', 14),
(15, 'Production Manager', 'Melissa Manager', 15);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `UserEmail` varchar(255) DEFAULT NULL,
  `UserPassword` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `UserEmail`, `UserPassword`) VALUES
(1, 'john.doe@example.com', 'password123'),
(2, 'jane.smith@example.com', 'securepass'),
(3, 'admin@admin.com', 'adminpass'),
(4, 'alice@gmail.com', 'mypassword'),
(5, 'bob@yahoo.com', 'letmein'),
(6, 'emma@gmail.com', 'emmapass'),
(7, 'mike@yahoo.com', 'mikepass'),
(8, 'sara@gmail.com', 'sarapass'),
(9, 'tom@gmail.com', 'tompass'),
(10, 'linda@yahoo.com', 'lindapass'),
(11, 'peter@gmail.com', 'peterpass'),
(12, 'grace@yahoo.com', 'gracepass'),
(13, 'sam@gmail.com', 'sampass'),
(14, 'olivia@yahoo.com', 'oliviapass'),
(15, 'ryan@gmail.com', 'ryanpass'),
(17, 'testinveclar@yahoo.com', 'Password@123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`OrderItemListID`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Indexes for table `ordertable`
--
ALTER TABLE `ordertable`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`StaffID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UserEmail` (`UserEmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `OrderItemListID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `ordertable`
--
ALTER TABLE `ordertable`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `ordertable` (`OrderID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
