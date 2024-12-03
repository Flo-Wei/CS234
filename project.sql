-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 03, 2024 at 05:01 AM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `AuthorID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Biography` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`AuthorID`, `Name`, `Biography`) VALUES
(2, 'J.K. Rowling', NULL),
(4, 'J.R.R. Tolkien', NULL),
(5, 'George R.R. Martin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `BookID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `AuthorID` int(11) DEFAULT NULL,
  `PublisherID` int(11) DEFAULT NULL,
  `PublicationDate` date DEFAULT NULL,
  `ISBN` varchar(20) DEFAULT NULL,
  `Genre` varchar(100) DEFAULT NULL,
  `Description` text,
  `CoverImageURL` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`BookID`, `Title`, `AuthorID`, `PublisherID`, `PublicationDate`, `ISBN`, `Genre`, `Description`, `CoverImageURL`) VALUES
(12, 'Harry Potter and the Sorcerer’s Stone', 2, 2, '1997-06-26', '9781338878929', 'Fantasy', '\"Turning the envelope over, his hand trembling, Harry saw a purple wax seal bearing a coat of arms; a lion, an eagle, a badger and a snake surrounding a large letter \'H\'.\"\r\n\r\nHarry Potter has never even heard of Hogwarts when the letters start dropping on the doormat at number four, Privet Drive. Addressed in green ink on yellowish parchment with a purple seal, they are swiftly confiscated by his grisly aunt and uncle. Then, on Harry\'s eleventh birthday, a great beetle-eyed giant of a man called Rubeus Hagrid bursts in with some astonishing news: Harry Potter is a wizard, and he has a place at Hogwarts School of Witchcraft and Wizardry. An incredible adventure is about to begin!', 'https://m.media-amazon.com/images/I/71XqqKTZz7L._AC_UF1000,1000_QL80_.jpg'),
(13, 'Harry Potter and the Chamber of Secrets', 2, 2, '1998-06-02', '978-1408855669', 'Fantasy', 'Ever since Harry Potter had come home for the summer, the Dursleys had been so mean and hideous that all Harry wanted was to get back to the Hogwarts School for Witchcraft and Wizardry. But just as he’s packing his bags, Harry receives a warning from a strange impish creature who says that if Harry returns to Hogwarts, disaster will strike.\r\n\r\nAnd strike it does. For in Harry’s second year at Hogwarts, fresh torments and horrors arise, including an outrageously stuck-up new professor and a spirit who haunts the girls’ bathroom. But then the real trouble begins – someone is turning Hogwarts students to stone. Could it be Draco Malfoy, a more poisonous rival than ever? Could it possibly be Hagrid, whose mysterious past is finally told? Or could it be the one everyone at Hogwarts most suspects… Harry Potter himself!', 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1474169725i/15881.jpg'),
(14, 'The Lord of the Rings: The Fellowship of the Ring', 4, 3, '1954-06-29', NULL, 'Fantasy Adventure', 'One Ring to rule them all, One Ring to find them, One Ring to bring them all and in the darkness bind them.\r\n\r\nIn ancient times the Rings of Power were crafted by the Elven-smiths, and Sauron, the Dark Lord, forged the One Ring, filling it with his own power so that he could rule all others. But the One Ring was taken from him, and though he sought it throughout Middle-earth, it remained lost to him. After many ages it fell into the hands of Bilbo Baggins, as told in The Hobbit.\r\n\r\nIn a sleepy village in the Shire, young Frodo Baggins finds himself faced with an immense task, as his elderly cousin Bilbo entrusts the Ring to his care. Frodo must leave his home and make a perilous journey across Middle-earth to the Cracks of Doom, there to destroy the Ring and foil the Dark Lord in his evil purpose.', 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1654215925i/61215351.jpg'),
(15, 'A Song of Ice and Fire: A Game of Thrones', 5, NULL, '1996-07-06', '9780553588484', 'Fantasy', 'Long ago, in a time forgotten, a preternatural event threw the seasons out of balance. In a land where summers can last decades and winters a lifetime, trouble is brewing. The cold is returning, and in the frozen wastes to the north of Winterfell, sinister forces are massing beyond the kingdom’s protective Wall. To the south, the king’s powers are failing—his most trusted adviser dead under mysterious circumstances and his enemies emerging from the shadows of the throne. At the center of the conflict lie the Starks of Winterfell, a family as harsh and unyielding as the frozen land they were born to. Now Lord Eddard Stark is reluctantly summoned to serve as the king’s new Hand, an appointment that threatens to sunder not only his family but the kingdom itself.\r\n\r\nSweeping from a harsh land of cold to a summertime kingdom of epicurean plenty, A Game of Thrones tells a tale of lords and ladies, soldiers and sorcerers, assassins and bastards, who come together in a time of grim omens. Here an enigmatic band of warriors bear swords of no human metal; a tribe of fierce wildlings carry men off into madness; a cruel young dragon prince barters his sister to win back his throne; a child is lost in the twilight between life and death; and a determined woman undertakes a treacherous journey to protect all she holds dear. Amid plots and counter-plots, tragedy and betrayal, victory and terror, allies and enemies, the fate of the Starks hangs perilously in the balance, as each side endeavors to win that deadliest of conflicts: the game of thrones.', 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1562726234i/13496.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `UserID` int(11) NOT NULL,
  `BookID` int(11) NOT NULL,
  `DateAdded` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `publishers`
--

CREATE TABLE `publishers` (
  `PublisherID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `publishers`
--

INSERT INTO `publishers` (`PublisherID`, `Name`, `Address`) VALUES
(2, 'Pottermore Publishing', NULL),
(3, 'Recorded Books', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `CreatedAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `Role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`UserID`, `Username`, `PasswordHash`, `CreatedAt`, `Role`) VALUES
(1, 'admin', '$2y$10$.Yv6Br05WWFAFjcbceLXGuKCbaqgBKThoJg/HlMwVeWOPbziKtnK6', '2024-12-01 17:10:35', 'admin'),
(2, 'user', '$2y$10$.9Al/9.vHtW0q9ohnBpmGOM4EIZkdmqzCkzG3nJ2O7VmJquuR9UtG', '2024-12-02 22:27:56', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`AuthorID`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`BookID`),
  ADD UNIQUE KEY `ISBN` (`ISBN`),
  ADD KEY `AuthorID` (`AuthorID`),
  ADD KEY `PublisherID` (`PublisherID`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`UserID`,`BookID`),
  ADD KEY `BookID` (`BookID`);

--
-- Indexes for table `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`PublisherID`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `AuthorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `BookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `publishers`
--
ALTER TABLE `publishers`
  MODIFY `PublisherID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`AuthorID`) REFERENCES `authors` (`AuthorID`),
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`PublisherID`) REFERENCES `publishers` (`PublisherID`);

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `registration` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
