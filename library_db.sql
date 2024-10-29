-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2024 at 05:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `available` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `genre`, `available`) VALUES
(1, 'To Kill a Mockingbird', 'Harper Lee', 'Fiction', 1),
(2, '1984', 'George Orwell', 'Dystopian', 1),
(3, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Classic', 1),
(4, 'The Silent Patient', 'Alex Michaelides', 'Psychological Thriller', 1),
(5, 'The Vanishing Half', 'Brit Bennett', 'Fiction', 1),
(6, 'Klara and the Sun', 'Kazuo Ishiguro', 'Science Fiction', 1),
(7, 'The Midnight Library', 'Matt Haig', 'Fiction', 1),
(8, 'Project Hail Mary', 'Andy Weir', 'Science Fiction', 1),
(9, 'Malibu Rising', 'Taylor Jenkins Reid', 'Contemporary Fiction', 1),
(10, 'The Last House on Needless Street', 'Catriona Ward', 'Horror', 1),
(11, 'The Push', 'Ashley Audrain', 'Psychological Thriller', 1),
(12, 'The Paper Palace', 'Miranda Cowley Heller', 'Fiction', 1),
(13, 'The Four Winds', 'Kristin Hannah', 'Historical Fiction', 1),
(14, 'The Invisible Life of Addie LaRue', 'V.E. Schwab', 'Fantasy', 1),
(15, 'The Song of Achilles', 'Madeline Miller', 'Historical Fiction', 1),
(16, 'Circe', 'Madeline Miller', 'Fantasy', 1),
(17, 'Anxious People', 'Fredrik Backman', 'Fiction', 1),
(18, 'The Guest List', 'Lucy Foley', 'Mystery', 1),
(19, 'Normal People', 'Sally Rooney', 'Fiction', 1),
(20, 'The Seven Husbands of Evelyn Hugo', 'Taylor Jenkins Reid', 'Historical Fiction', 1),
(21, 'Daisy Jones & The Six', 'Taylor Jenkins Reid', 'Historical Fiction', 1),
(22, 'Where the Crawdads Sing', 'Delia Owens', 'Fiction', 1),
(23, 'The Huntress', 'Kate Quinn', 'Historical Fiction', 1),
(24, 'The Night Circus', 'Erin Morgenstern', 'Fantasy', 1),
(25, 'Little Fires Everywhere', 'Celeste Ng', 'Fiction', 1),
(26, 'The Light We Lost', 'Jill Santopolo', 'Fiction', 1),
(27, 'Big Little Lies', 'Liane Moriarty', 'Fiction', 1),
(28, 'The Woman in the Window', 'A.J. Finn', 'Thriller', 1),
(29, 'The Couple Next Door', 'Shari Lapena', 'Thriller', 1),
(30, 'The Girl on the Train', 'Paula Hawkins', 'Thriller', 1),
(31, 'Before We Were Strangers', 'Renée Carlino', 'Romance', 1),
(32, 'The Rosie Project', 'Graeme Simsion', 'Romance', 1),
(33, 'The Giver of Stars', 'Jojo Moyes', 'Historical Fiction', 1),
(34, 'A Man Called Ove', 'Fredrik Backman', 'Fiction', 1),
(35, 'Educated', 'Tara Westover', 'Memoir', 1),
(36, 'Becoming', 'Michelle Obama', 'Memoir', 1),
(37, 'The Immortal Life of Henrietta Lacks', 'Rebecca Skloot', 'Non-fiction', 1),
(38, 'Born a Crime', 'Trevor Noah', 'Memoir', 1),
(39, 'Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', 'Non-fiction', 1),
(40, 'The Subtle Art of Not Giving a F*ck', 'Mark Manson', 'Self-help', 1),
(41, 'The Body Keeps the Score', 'Bessel van der Kolk', 'Non-fiction', 1),
(42, 'Atomic Habits', 'James Clear', 'Self-help', 1),
(43, 'The Alchemist', 'Paulo Coelho', 'Fiction', 1),
(44, 'Life of Pi', 'Yann Martel', 'Fiction', 1),
(45, 'The Kite Runner', 'Khaled Hosseini', 'Fiction', 1),
(46, 'A Thousand Splendid Suns', 'Khaled Hosseini', 'Fiction', 1),
(47, 'The Book Thief', 'Markus Zusak', 'Historical Fiction', 1),
(48, 'The Fault in Our Stars', 'John Green', 'Young Adult', 1),
(49, 'Looking for Alaska', 'John Green', 'Young Adult', 1),
(50, 'The Perks of Being a Wallflower', 'Stephen Chbosky', 'Young Adult', 1),
(51, 'It Ends with Us', 'Colleen Hoover', 'Romance', 1),
(52, 'Verity', 'Colleen Hoover', 'Thriller', 1),
(53, 'Beach Read', 'Emily Henry', 'Romance', 1),
(54, 'One Last Stop', 'Casey McQuiston', 'Romance', 1),
(55, 'The Flatshare', 'Beth O’Leary', 'Romance', 1),
(56, 'The Spanish Love Deception', 'Elena Armas', 'Romance', 1),
(57, 'The Hating Game', 'Sally Thorne', 'Romance', 1),
(58, 'The Unhoneymooners', 'Christina Lauren', 'Romance', 1),
(59, 'The Deal', 'Elle Kennedy', 'Romance', 1),
(60, 'Red, White & Royal Blue', 'Casey McQuiston', 'Romance', 1),
(61, 'The Nightingale', 'Kristin Hannah', 'Historical Fiction', 1),
(62, 'The Book of Lost Names', 'Kristin Harmel', 'Historical Fiction', 1),
(63, 'The Tattooist of Auschwitz', 'Heather Morris', 'Historical Fiction', 1),
(64, 'The Henna Artist', 'Alka Joshi', 'Historical Fiction', 1),
(65, 'The Overstory', 'Richard Powers', 'Literary Fiction', 1),
(66, 'Pachinko', 'Min Jin Lee', 'Historical Fiction', 1),
(67, 'The Vanishing Half', 'Brit Bennett', 'Fiction', 1),
(68, 'The City We Became', 'N.K. Jemisin', 'Fantasy', 1),
(69, 'The Poppy War', 'R.F. Kuang', 'Fantasy', 1),
(70, 'Crescent City', 'Sarah J. Maas', 'Fantasy', 1),
(71, 'The Priory of the Orange Tree', 'Samantha Shannon', 'Fantasy', 1),
(72, 'House of Earth and Blood', 'Sarah J. Maas', 'Fantasy', 1),
(73, 'The Shadow of the Wind', 'Carlos Ruiz Zafón', 'Literary Fiction', 1),
(74, 'The Night Watchman', 'Louise Erdrich', 'Historical Fiction', 1),
(75, 'The Overstory', 'Richard Powers', 'Literary Fiction', 1),
(76, 'Muna Madan', 'Laxmi Prasad Devkota', 'Narrative ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `borrowed_books`
--

CREATE TABLE `borrowed_books` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `borrow_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowed_books`
--

INSERT INTO `borrowed_books` (`id`, `user_id`, `book_id`, `borrow_date`, `return_date`) VALUES
(1, 1, 5, '2024-10-28', NULL),
(2, 1, 6, '2024-10-28', NULL),
(5, 4, 6, '2024-10-28', NULL),
(6, 1, 39, '2024-10-31', NULL),
(7, 2, 22, '2024-10-24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `librarians`
--

CREATE TABLE `librarians` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `librarians`
--

INSERT INTO `librarians` (`id`, `username`, `password`) VALUES
(1, 'gaurab', '$2y$10$HEQ/fRBwKEuC0aD7p75tau9OfrAs7TphAlWPeasg0x0iSZ7zutD/a');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'gaurav', 'gaurav@ef', '$2y$10$U5im/jfq4SUIWcsUnemtIedn7YhFFJ3515e7oPCpQcBu6jbzfzc2O', '2024-10-28 11:05:48'),
(2, 'ram', 'ram@hotmail.com', '$2y$10$EIShEXd8deJitKh9a04qcOXIW5f2eHYOqWhCJTGx8NQSLToW5mTLa', '2024-10-29 04:07:40'),
(3, 'sita', 'sita@gmail.com', '$2y$10$dHASf74HXub1VIoJHlKYpePULDDQBFRG0hpRObihuHEvNWEBVkbJW', '2024-10-29 04:07:54'),
(4, 'hari', 'hari@hotmail.com', '$2y$10$SQgghzhnBFFRQqDlk0CoEOfWffqo41xa5ugswXtYXUB6/vuc67.Ne', '2024-10-29 04:08:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `librarians`
--
ALTER TABLE `librarians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `librarians`
--
ALTER TABLE `librarians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD CONSTRAINT `borrowed_books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `borrowed_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
