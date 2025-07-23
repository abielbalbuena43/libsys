-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2025 at 08:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminid` int(111) NOT NULL,
  `username` varchar(111) NOT NULL,
  `fullname` varchar(111) NOT NULL,
  `adminemail` varchar(111) NOT NULL,
  `password` varchar(111) NOT NULL,
  `pic` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminid`, `username`, `fullname`, `adminemail`, `password`, `pic`) VALUES
(1, 'admin', 'lexine', 'lexine@gmail.com', 'admin', 'user2.png');

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `authorid` int(111) NOT NULL,
  `authorname` varchar(111) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`authorid`, `authorname`) VALUES
(1, 'Unknown'),
(2, 'Gordon Korman'),
(3, 'Suzanne Collins'),
(4, 'Holly Black'),
(5, 'Rick Riordan'),
(6, 'John Green'),
(7, 'Stephenie Meyer'),
(8, 'Neil Simon'),
(9, 'Edward Bloor'),
(10, 'Joan Lowery Nixon'),
(11, 'Gary Paulsen'),
(12, 'Brian Jacques'),
(13, 'Jennifer A. Nielsen'),
(14, 'E. Lockhart'),
(15, 'Gary Soto'),
(16, 'Patricia C. Wrede'),
(17, 'Jennifer Donnelly'),
(18, 'Ann M. Martin'),
(19, 'Matthew Cody'),
(20, 'Andrew Clements'),
(21, 'Anne McCaffrey'),
(22, 'Patricia Cornwell'),
(23, 'J.K. Rowling'),
(24, 'Philip Pullman'),
(25, 'Judith Ortiz Cofer'),
(26, 'Jerry Spinelli'),
(27, 'D.J. MacHale'),
(28, 'Susan Collins'),
(29, 'Maya Angelou'),
(30, 'Barbara Park'),
(31, 'Sara Pennypacker'),
(32, 'Lois Lowry'),
(33, 'Kathi Appelt'),
(34, 'Paul Fleischman'),
(35, 'Rita Williams Garcia'),
(36, 'Jeff Kinney'),
(37, 'Margaret Peterson Haddix'),
(38, 'Laura Numeroff'),
(39, 'James Dashner'),
(40, 'Jessica Day George'),
(41, 'Walt Disney'),
(42, 'Polly Horvath '),
(43, 'Eileen Spinelli'),
(44, 'Arthur Koestler'),
(45, 'Lisi Harrison'),
(46, 'Tera Lynn Childs'),
(47, 'Alice K. Boatwright'),
(48, 'Pat Murphy'),
(49, 'Denene Millner'),
(50, 'Elizabeth Winthrop'),
(51, 'Eva Ibbotson'),
(52, 'Scott Foresman'),
(53, 'Richard Peck'),
(54, 'Peadar O\' Guilin'),
(55, 'Kirsten Boie'),
(56, 'Johnathan Rand'),
(57, 'Adele Griffin'),
(58, 'Christopher Paul Curtis'),
(59, 'Anthony Horowitz'),
(60, 'Scott Lobdell'),
(61, 'Betty Ren Wright'),
(62, 'Phyllis Reynolds Naylor');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bookid` int(100) NOT NULL,
  `bookpic` varchar(500) NOT NULL,
  `bookname` varchar(100) NOT NULL,
  `bookdesc` text NOT NULL,
  `authorid` int(100) NOT NULL,
  `categoryid` int(100) NOT NULL,
  `ISBN` varchar(100) NOT NULL,
  `callnum` varchar(128) NOT NULL,
  `acessionnum` varchar(128) NOT NULL,
  `year` varchar(20) NOT NULL,
  `libsection` varchar(128) NOT NULL,
  `dewey` varchar(128) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`bookid`, `bookpic`, `bookname`, `bookdesc`, `authorid`, `categoryid`, `ISBN`, `callnum`, `acessionnum`, `year`, `libsection`, `dewey`, `price`, `quantity`, `status`) VALUES
(48, 'Arthur and the Crunch Ceareal Contest.jpg', 'Funny Animal', 'A delightful collection of humorous animal stories. humurus, unterestings, ;', 1, 1, '978-3-16-148410-1', 'FIC FUN', '032', '2021', 'Children', '823.92', 0, 2, 'Not Available'),
(49, 'coyote_attacks.jpg', 'Coyote Attacks', 'A suspenseful account of encounters with coyotes in urban areas.', 2, 2, '978-3-16-148410-2', 'FIC COY', '033', '2022', 'Non-Fiction', '599.77', 0, 0, 'Not Available'),
(50, 'careers_in_video.jpg', 'Careers in Video and Digital Video', 'An insightful guide to careers in video production.', 2, 2, '978-3-16-148410-3', 'FIC VID', '034', '2023', 'Non-Fiction', '650.14', 0, 1, 'Available'),
(51, 'hunchback_notre_dame.jpg', 'The Hunchback of Notre Dame', 'A classic novel by Victor Hugo about love, betrayal, and redemption.', 3, 3, '978-0-452-28433-8', 'FIC HUG', '035', '1831', 'Classics', '843.8', 0, 1, 'Available'),
(52, 'warriors_forest_secrets.jpg', 'Warriors Forest Of Secrets', 'An adventure story in the Warriors series exploring themes of loyalty and bravery.', 4, 4, '978-0-06-056025-4', 'FIC WAR', '036', '2006', 'Fiction', '813.6', 0, 1, 'Available'),
(53, 'gordon_korman_book_two.jpg', 'Gordon Korman Book Two', 'Another thrilling installment in the Gordon Korman series.', 1, 2, '978-1-4424-4101-7', 'FIC KOR', '037', '2018', 'Fiction', '813.6', 0, 1, 'Available'),
(54, 'hunger_games.jpg', 'The Hunger Games', 'A dystopian novel about a society that hosts a deadly competition.', 5, 5, '978-0-439-02348-1', 'FIC COL', '038', '2008', 'Young Adult Fiction', '813.6', 0, 0, 'Not Available'),
(55, 'confession_not_it_girl.jpg', 'Confession Of A Not It Girl', 'A humorous look at the trials of a teenage girl navigating social challenges.', 6, 6, '978-1-4507-0011-5', 'FIC NOT', '039', '2015', 'Young Adult Fiction', '813.6', 0, 1, 'Available'),
(56, 'its_my_life.jpg', 'Its My Life', 'A coming-of-age story that explores the importance of self-identity.', 7, 7, '978-1-56792-035-3', 'FIC MYL', '040', '2017', 'Young Adult Fiction', '813.6', 0, 0, 'Not Available'),
(57, 'americas_prison.jpg', 'Americas Prison', 'An exploration of the prison system in America.', 8, 8, '978-1-59420-244-2', 'FIC PRI', '041', '2019', 'Non-Fiction', '365.97', 0, 0, 'Not Available'),
(58, 'm_o_t_i_v_a_t_e.jpg', 'M.O.T.I.V.A.T.E', 'A motivational guide for young adults.', 9, 9, '978-1-5435-3104-0', 'FIC MOT', '042', '2021', 'Non-Fiction', '158.1', 0, 1, 'Available'),
(59, 'jane_long_mother_of_texas.jpg', 'Jane Long The Mother Of Texas', 'A biography about the influential woman in Texas history.', 10, 10, '978-1-61383-045-1', 'FIC LON', '043', '2020', 'Biography', '976.4', 0, 1, 'Available'),
(60, 'saturn_apartments.jpg', 'Saturn Apartments', 'A graphic novel set in a futuristic society.', 11, 11, '978-1-60439-062-3', 'FIC SAT', '044', '2018', 'Graphic Novel', '741.5', 0, 1, 'Available'),
(61, 'too_stressed_to_think.jpg', 'Too Stressed to Think', 'A guide to managing stress in everyday life.', 12, 12, '978-1-59327-384-7', 'FIC STRESS', '045', '2019', 'Self-Help', '158.1', 0, 1, 'Available'),
(62, 'missing_book_1_found.jpg', 'The Missing Book 1 Found', 'A mystery that unravels a secret.', 13, 13, '978-1-5348-2358-2', 'FIC MISSING', '046', '2022', 'Fiction', '813.6', 0, 1, 'Available'),
(63, 'viking_ships_sunrise.jpg', 'Viking Ships at Sunrise', 'A historical adventure through the eyes of children.', 14, 14, '978-0-439-02358-0', 'FIC VIK', '047', '2005', 'Children', '823.92', 0, 1, 'Available'),
(64, 'joey_pigza_loses_control.jpg', 'Joey Pigza Loses Control', 'A heartfelt story about a boy with ADHD.', 15, 15, '978-0-06-440775-8', 'FIC PIG', '048', '2000', 'Children', '813.54', 0, 1, 'Available'),
(65, 'beastly.jpg', 'Beastly', 'A modern retelling of the Beauty and the Beast tale.', 16, 16, '978-0-06-170208-5', 'FIC BEA', '049', '2007', 'Young Adult Fiction', '813.6', 0, 0, 'Not Available'),
(66, 'new_propecy_warriors.jpg', 'The New Propecy WARRIORS', 'Continuation of the Warriors saga.', 4, 4, '978-0-06-052496-7', 'FIC PROP', '050', '2005', 'Fiction', '813.6', 0, 1, 'Available'),
(67, 'holy_discontent.jpg', 'HOLY Discontent', 'A thought-provoking exploration of personal faith.', 17, 17, '978-1-59052-640-3', 'FIC HOLY', '051', '2018', 'Religion', '201.6', 0, 1, 'Available'),
(68, 'indian_summer_of_the_heart.jpg', 'INDIAN SUMMER OF THE HEART', 'A heartwarming tale about love and family.', 18, 18, '978-0-06-084737-2', 'FIC IND', '052', '2020', 'Fiction', '813.54', 0, 0, 'Not Available'),
(69, 'working_as_a_team.jpg', 'Working as a Team', 'A guide on the importance of teamwork in various settings.', 19, 19, '978-1-59327-392-2', 'FIC TEAM', '053', '2019', 'Self-Help', '658.4', 0, 1, 'Available'),
(70, 'readers_digest.jpg', 'Readers Digest', 'A compilation of informative articles and stories.', 20, 20, '978-1-57959-682-2', 'FIC REA', '054', '2021', 'Non-Fiction', '070.5', 0, 1, 'Available'),
(71, 'return_to_del.jpg', 'Return To Del', 'An exploration of a journey back to one\'s roots.', 21, 21, '978-1-5323-6576-1', 'FIC DEL', '055', '2022', 'Fiction', '813.6', 0, 1, 'Available'),
(72, 'creating_the_xmen.jpg', 'Creating the X-men', 'A behind-the-scenes look at the making of the X-men series.', 22, 22, '978-0-7851-2404-4', 'FIC XMEN', '056', '2018', 'Comics', '741.5', 0, 0, 'Not Available'),
(73, 'nighty_nightmare.jpg', 'Nighty-Nightmare', 'A whimsical tale that explores the importance of a good night’s sleep, filled with imaginative characters and dreamlike adventures.', 1, 8, '978-0689713345', 'J HOW', 'Not Specified', '1987', 'Not Specified', '813.54', 0, 1, 'Available'),
(74, '4500_7_05.jpg', 'Beauty and the Beast', 'asd asd asd', 41, 5, '123', '123', '123', '1991', 'fiction', '10.2', 100, 2, 'Available'),
(138, '', 'The Corpse Of The Bare Bone Plane', 'A mystery adventure featuring a group of friends who uncover secrets while exploring a haunted plane.', 42, 22, '9781466863019', 'FIC GRE', '036', '2007', 'Fiction', '813.54', 0, 1, 'Available'),
(139, '', 'Lizzie Logan Second Banana', 'Follows Lizzie Logan as she navigates friendship and rivalry in a humorous and relatable way.', 43, 23, '9780689815102', 'FIC DRA', '037', '1998', 'Fiction', '813.54', 0, 1, 'Available'),
(140, '', 'Ghost In The Machine', 'A thrilling tale that blends technology and the supernatural, where characters confront a ghostly presence linked to machines.', 44, 24, '9781939438348', 'FIC HAI', '038', '2009', 'Fiction', '813.54', 0, 1, 'Available'),
(141, '', 'The Clique Summer Collection', 'A companion to the Clique series, focusing on summer adventures and the dynamics of friendship among affluent teens.', 45, 25, '9780316056496', 'FIC HARR', ' 039', '2008', 'Young Adult Fiction', '813.6', 0, 1, 'Available'),
(142, '', 'Oh My Gods', 'A contemporary twist on Greek mythology, featuring a girl who discovers she is part of a world of gods and legends.', 46, 26, '9780525479420', 'FIC KID', '040', '2008', 'Young Adult Fiction', '813.6', 0, 1, 'Available'),
(143, '', 'What Child Is This (2)', 'A seasonal tale that explores themes of family and the spirit of Christmas, often featuring a mystery to be solved.', 47, 27, '9798986434452', 'FIC MAN', '041', '1997', 'Fiction', '813.54', 0, 1, 'Available'),
(144, '', 'The Wild Girls', 'A coming-of-age story about friendship and the struggles of young girls as they discover their identities and navigate social challenges.', 48, 7, '9780670062263', 'FIC FRI', '042', '2007', 'Young Adult Fiction', '813.54', 0, 1, 'Available'),
(145, '', 'Hotlanta', 'A graphic novel that tackles issues of race, identity, and friendship set in Atlanta, blending humor and serious themes.', 49, 28, '9780545003087', 'FIC WRI', '043', '2008', 'Young Adult Fiction', '813.54', 0, 1, 'Available'),
(146, '', 'The Castle In The Attic', 'A fantasy adventure where a boy is transported to a magical castle and must battle an evil wizard to save his friends.', 50, 29, '9780823405794', 'FIC WIL', '044', '1985', 'Children', '813.6', 0, 1, 'Available'),
(147, '', 'Dial-A-Ghost', 'A whimsical story about a boy who calls a ghost service to help him deal with his problems, leading to comical and spooky adventures.', 51, 30, '9780142500187', '	FIC JEN ', '045', '2001', 'Children', '813.54', 0, 1, 'Available'),
(148, '', 'Decodable Practice Readers 1.2', 'A collection of beginner-level readers designed to help children practice reading skills through engaging stories.', 52, 31, '9780328145010', '372.4 DEC', '046', '2005', 'Children', '372.4', 0, 1, 'Available'),
(149, '', 'Fair Weather', 'Set during the 1893 World’s Fair, it follows a family as they navigate the excitement and challenges of the event.', 53, 32, '9780803725164', 'FIC BOU', '047', '2001', 'Fiction', '813.6', 0, 1, 'Available'),
(150, '', 'The Inferior', 'A gripping tale that explores themes of power and identity, often focusing on characters who feel marginalized or overlooked.', 54, 33, '9780385610957', 'FIC CAR', '048', '2007', 'Fiction', '813.54', 0, 1, 'Available'),
(151, '', 'The Princess Plot', 'A romantic adventure where a young girl finds herself caught in a plot involving royalty, intrigue, and personal growth.', 55, 34, '9780545032216', 'FIC GRA', '049', '2008', 'Young Adult Fiction', '813.6', 0, 1, 'Available'),
(152, '', 'American Chillers (2)', 'A series featuring spooky and thrilling stories set in various American locales, appealing to young readers who love horror.', 56, 35, '9781893699939', 'FIC FRI', '050', '2007', 'Fiction', '813.6', 0, 1, 'Available'),
(153, '', 'Witch Twins and Melody Malady', 'A fun story about twin witches who must navigate challenges while dealing with friendship and magical mishaps.', 57, 36, '9780786819409', 'FIC OBE', '051', '2003', 'Children', '813.54', 0, 1, 'Available'),
(154, '', 'Bud, Not Buddy', 'A historical fiction novel about a boy during the Great Depression searching for his father, filled with hope and determination.', 58, 32, '9780440413288', 'JUV FIC CUR', '052', '1999', 'Children', '813.54', 0, 1, 'Available'),
(155, '', 'The Devil and his Boy', 'A historical adventure featuring a young boy in Elizabethan England who encounters the devil and embarks on a thrilling journey.', 59, 37, '9780142407974', 'FIC HEN', '053', '1998', 'Fiction', '813.54', 0, 1, 'Available'),
(156, '', 'Hardy Boys (vol.1)', 'The classic detective series follows brothers Frank and Joe Hardy as they solve mysteries and embark on adventures.', 60, 22, '9781597070010', 'JUV FIC HAA', '054', '2005', 'Mystery', '813.54', 0, 1, 'Available'),
(157, '', 'Cristinas Ghost', 'A ghost story about a girl who discovers a mysterious spirit in her new home, leading to unexpected revelations.', 61, 38, '9780823405817', 'FIC BLA', '055', '1985', 'Young Adult Fiction', '813.54', 0, 1, 'Available'),
(158, '', 'Reluctantly Alice', 'A coming-of-age story about Alice, who grapples with the challenges of adolescence, friendships, and self-discovery.', 62, 39, '9780689316814', 'FIC MUI', '056', '1991', 'Young Adult Fiction', '813.54', 0, 1, 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryid` int(111) NOT NULL,
  `categoryname` varchar(111) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryid`, `categoryname`) VALUES
(1, 'Fiction'),
(2, 'Non-Fiction'),
(3, 'Mystery & Thriller'),
(4, 'Science Fiction'),
(5, 'Fantasy'),
(6, 'Historical Fiction'),
(7, 'Young Adult'),
(8, 'Children\'s Books'),
(9, 'Biography & Autobiography'),
(10, 'Health & Wellness'),
(11, 'Self-Help'),
(12, 'Graphic Novels'),
(13, 'Poetry'),
(14, 'Classic Literature'),
(15, 'Adventure'),
(16, 'Romance'),
(17, 'Horror'),
(18, 'Dystopian'),
(19, 'Drama'),
(20, 'Educational'),
(21, 'Not Specified'),
(22, 'Mystery/Adventure'),
(23, 'Young Adult/Comedy'),
(24, 'Science Fiction/Thriller'),
(25, 'Young Adult/Fiction'),
(26, 'Fantasy/Young Adult'),
(27, 'Fiction/Family'),
(28, 'Graphic Novel'),
(29, 'Fantasy/Adventure'),
(30, 'Children\'s Fiction/Fantasy'),
(31, 'Educational/Children\'s Literature'),
(32, 'Historical Fiction/Coming of Age'),
(33, 'Dystopian/Science Fiction'),
(34, 'Fantasy/Romantic Adventure'),
(35, 'Horror/Young Adult'),
(36, 'Fantasy/Children\'s Fiction'),
(37, 'Historical Fiction/Adventure'),
(38, 'Children\'s Fiction'),
(39, 'Young Adult/Coming of Age');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(128) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fname` varchar(128) NOT NULL,
  `lname` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(128) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0-archive, 1-unarchived'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `employee_id`, `username`, `fname`, `lname`, `email`, `password`, `phone`, `pic`, `status`) VALUES
(35, '0036488', 'employeones', 'zxcdes', 'zxc', 'paganahinutak@gmail.com', 'wJKNqsGe', '09123456789', 'user2.png', 1),
(36, '1234567', 'jose', 'gabriel', 'balbuena', 'josegabriel.balbuena@letran.edu.ph', 'g1XdGVLz', '09199529123', 'user2.png', 1),
(37, '0123456', 'admin123', 'admin', 'admin', 'admin123@gmail.com', 'admin123', '09199529302', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `stdid` int(100) NOT NULL,
  `rating` int(100) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`stdid`, `rating`, `comment`, `date`) VALUES
(1, 0, 'ncnc\r\n', '2024-08-15');

-- --------------------------------------------------------

--
-- Table structure for table `issueinfo`
--

CREATE TABLE `issueinfo` (
  `issueid` int(11) NOT NULL,
  `studentid` int(100) NOT NULL,
  `bookid` int(100) NOT NULL,
  `issuedate` date NOT NULL,
  `returndate` date NOT NULL,
  `duedate` date DEFAULT NULL,
  `approve` varchar(200) NOT NULL,
  `fine` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issueinfo`
--

INSERT INTO `issueinfo` (`issueid`, `studentid`, `bookid`, `issuedate`, `returndate`, `duedate`, `approve`, `fine`) VALUES
(1, 3, 20, '0000-00-00', '0000-00-00', NULL, '', 0),
(2, 1, 22, '2024-07-19', '2024-07-21', NULL, '<p class=\"expired-pill\">OVERDUE</p>', 20),
(3, 1, 30, '2024-09-01', '2024-09-01', NULL, '<p class=\"approve-return-pill\">RETURNED</p>', 100),
(4, 1, 29, '2024-09-01', '2024-09-05', '2024-09-15', '<p class=\"approve-return-pill\">RETURNED</p>', 100),
(6, 1, 35, '2024-09-02', '0000-00-00', '2024-10-31', '<p class=\"issued-pill\">ISSUED</p>', 100),
(7, 1, 32, '2024-09-03', '0000-00-00', '2024-09-30', '<p class=\"issued-pill\">ISSUED</p>', 100),
(20, 1, 29, '0000-00-00', '2024-09-05', '0000-00-00', '<p class=\"pending-pill\">PENDING RETURN</p>', 0),
(22, 1, 29, '2024-10-01', '0000-00-00', '2024-10-10', '<p class=\"issued-pill\">ISSUED</p>', 300),
(23, 1, 20, '0000-00-00', '0000-00-00', '0000-00-00', '', 0),
(24, 1, 57, '2024-10-10', '0000-00-00', '2024-10-09', '<p class=\"stolen-pill\">STOLEN</p>', 100),
(25, 1, 49, '2024-10-10', '2024-10-10', '2024-10-15', '<p class=\"approve-return-pill\">RETURNED</p>', 0),
(26, 1, 65, '2024-10-10', '0000-00-00', '2024-10-22', '<p class=\"expired-pill\">OVERDUE</p>', 100),
(27, 1, 54, '2024-10-17', '2024-10-17', '2024-10-31', '<p class=\"approve-return-pill\">RETURNED</p>', 0),
(28, 1, 49, '0000-00-00', '0000-00-00', '0000-00-00', '', 0),
(29, 29, 74, '2024-10-17', '0000-00-00', '2024-10-30', '<p class=\"approve-return-pill\">PAID</p>', 100),
(30, 29, 48, '2024-10-17', '0000-00-00', '2024-10-29', '<p class=\"issued-pill\">ISSUED</p>', 0),
(31, 29, 56, '2024-10-17', '2024-10-20', '2024-10-30', '<p class=\"issued-pill\">ISSUED</p>', 0),
(32, 29, 68, '0000-00-00', '0000-00-00', '0000-00-00', '', 0),
(33, 35, 74, '2024-10-20', '2024-10-20', '2024-10-30', '<p class=\"discarded-pill\">DISCARDED</p>', 0),
(34, 35, 74, '2024-11-05', '0000-00-00', '2024-11-14', '<p class=\"issued-pill\">ISSUED</p>', 100),
(35, 35, 72, '0000-00-00', '0000-00-00', '0000-00-00', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` enum('0','1') NOT NULL COMMENT '0 - student, 1 - admin',
  `message` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`log_id`, `user_id`, `user_type`, `message`, `created_at`) VALUES
(1, 1, '1', 'Added a new book \"Sample\"', '2024-09-03 20:12:05'),
(2, 1, '1', 'Issued book \"Adrift\" with return date \"2024-09-30\"', '2024-09-03 22:08:10'),
(3, 1, '0', 'Requested a book with id \"32\"', '2024-09-05 10:49:03'),
(4, 1, '0', 'Deleted book request with id \"32\"', '2024-09-05 10:49:09'),
(5, 1, '0', 'Deleted book request with id \"29\"', '2024-09-05 13:46:10'),
(6, 1, '0', 'Deleted book request with id \"29\"', '2024-09-05 13:46:43'),
(8, 1, '0', 'Requested a book with id \"29\"', '2024-09-05 14:10:37'),
(9, 1, '0', 'Deleted book request with id \"29\"', '2024-09-05 14:12:00'),
(10, 1, '0', 'Requested a book with id \"29\"', '2024-09-05 14:12:48'),
(11, 1, '0', 'Requested a book with id \"29\"', '2024-09-05 14:14:18'),
(12, 1, '0', 'Deleted book request with id \"29\"', '2024-09-05 14:15:56'),
(13, 1, '0', 'Returned a book with issue id \"4\"', '2024-09-05 14:16:12'),
(14, 1, '0', 'Returned a book with issue id \"4\"', '2024-09-05 14:18:08'),
(15, 1, '0', 'Returned a book with issue id \"4\"', '2024-09-05 14:19:16'),
(16, 1, '0', 'Returned a book with issue id \"4\"', '2024-09-05 14:20:50'),
(17, 1, '0', 'Returned a book with issue id \"4\"', '2024-09-05 14:22:52'),
(18, 1, '0', 'Returned a book with issue id \"20\"', '2024-09-05 14:38:39'),
(19, 1, '0', 'Returned a book with issue id \"20\"', '2024-09-05 14:39:26'),
(20, 1, '0', 'Requested a book with id \"29\"', '2024-09-05 14:39:41'),
(21, 1, '0', 'Requested a book with id \"20\"', '2024-09-06 18:19:05'),
(22, 1, '1', 'Updated book with id \"29\"', '2024-09-06 21:12:59'),
(23, 1, '1', 'Updated book with id \"29\"', '2024-09-06 21:14:11'),
(24, 1, '1', 'Updated book with id \"29\"', '2024-09-06 21:15:02'),
(25, 1, '1', 'Logged in', '2024-09-28 15:58:26'),
(26, 1, '1', 'Updated book with id \"29\"', '2024-09-28 15:59:59'),
(27, 0, '0', 'Registered', '2024-09-30 08:58:28'),
(28, 0, '0', 'Registered', '2024-09-30 09:00:47'),
(29, 1, '1', 'Logged in', '2024-09-30 09:35:39'),
(30, 1, '1', 'Deleted book with id \"45\"', '2024-09-30 09:40:33'),
(31, 1, '1', 'Added a new category \"sample\"', '2024-09-30 09:46:24'),
(32, 1, '1', 'Deleted category with id \"11\"', '2024-09-30 09:46:32'),
(33, 1, '0', 'Logged in', '2024-09-30 09:55:28'),
(34, 1, '1', 'Logged in', '2024-09-30 13:49:20'),
(35, 1, '0', 'Logged in', '2024-09-30 14:17:28'),
(36, 1, '1', 'Logged in', '2024-10-01 10:35:33'),
(37, 1, '1', 'Logged in', '2024-10-01 20:29:26'),
(38, 1, '1', 'Issued book \"Broken Starss\" with return date \"2024-10-05\"', '2024-10-01 21:21:19'),
(39, 1, '1', 'Issued book \"Broken Starss\" with return date \"2024-10-05\"', '2024-10-01 21:25:14'),
(40, 1, '1', 'Issued book \"Broken Starss\" with return date \"2024-10-10\"', '2024-10-01 21:27:01'),
(41, 1, '0', 'Logged in', '2024-10-01 21:41:39'),
(42, 1, '1', 'Logged in', '2024-10-01 21:43:54'),
(43, 1, '1', 'Updated book with id \"28\"', '2024-10-01 21:44:44'),
(44, 1, '0', 'Logged in', '2024-10-02 19:42:44'),
(45, 1, '1', 'Logged in', '2024-10-03 08:32:57'),
(46, 1, '0', 'Logged in', '2024-10-03 08:39:22'),
(47, 1, '0', 'Logged in', '2024-10-05 22:12:46'),
(48, 1, '1', 'Logged in', '2024-10-05 22:13:54'),
(49, 1, '0', 'Logged in', '2024-10-05 22:15:07'),
(50, 1, '1', 'Logged in', '2024-10-05 22:16:41'),
(51, 1, '1', 'Archived student with id \"24\"', '2024-10-06 08:42:56'),
(52, 1, '1', 'Archived student with id \"24\"', '2024-10-06 08:47:16'),
(53, 1, '1', 'Archived student with id \"24\"', '2024-10-06 08:47:20'),
(54, 1, '1', 'Updated student with id \"1\"', '2024-10-06 09:09:06'),
(55, 1, '0', 'Logged in', '2024-10-06 09:10:32'),
(56, 1, '0', 'Logged in', '2024-10-06 09:14:26'),
(57, 1, '1', 'Updated book with id \"29\"', '2024-10-06 09:16:39'),
(58, 1, '1', 'Logged in', '2024-10-06 10:00:58'),
(59, 1, '1', 'Logged in', '2024-10-07 20:56:50'),
(60, 1, '1', 'Logged in', '2024-10-07 21:19:40'),
(61, 0, '0', 'Registered', '2024-10-07 21:20:43'),
(62, 25, '0', 'Logged in', '2024-10-07 21:20:53'),
(63, 1, '1', 'Logged in', '2024-10-07 22:23:01'),
(64, 25, '0', 'Logged in', '2024-10-07 22:52:24'),
(65, 1, '1', 'Logged in', '2024-10-07 22:53:54'),
(66, 1, '1', 'Added a new book \"Nighty-Nightmare\"', '2024-10-07 23:48:58'),
(67, 1, '1', 'Updated book with id \"48\"', '2024-10-07 23:50:06'),
(68, 1, '1', 'Updated book with id \"48\"', '2024-10-07 23:50:18'),
(69, 1, '1', 'Updated book with id \"49\"', '2024-10-07 23:50:48'),
(70, 1, '1', 'Updated book with id \"48\"', '2024-10-08 00:00:15'),
(71, 1, '1', 'Updated book with id \"49\"', '2024-10-08 00:00:30'),
(72, 1, '1', 'Logged in', '2024-10-08 11:33:20'),
(73, 1, '0', 'Logged in', '2024-10-08 11:34:59'),
(74, 1, '1', 'Logged in', '2024-10-08 11:37:11'),
(75, 1, '0', 'Logged in', '2024-10-08 11:40:18'),
(76, 1, '1', 'Logged in', '2024-10-08 11:45:16'),
(77, 1, '1', 'Logged in', '2024-10-09 21:48:19'),
(78, 1, '1', 'Logged in', '2024-10-10 10:42:16'),
(79, 1, '0', 'Logged in', '2024-10-10 10:42:37'),
(80, 1, '1', 'Logged in', '2024-10-10 10:43:32'),
(81, 1, '0', 'Logged in', '2024-10-10 10:44:44'),
(82, 1, '0', 'Requested a book with id \"57\"', '2024-10-10 10:44:50'),
(83, 1, '1', 'Issued book \"Americas Prison\" with return date \"2024-10-31\"', '2024-10-10 10:45:08'),
(84, 1, '0', 'Requested a book with id \"49\"', '2024-10-10 10:45:31'),
(85, 1, '1', 'Issued book \"Coyote Attacks\" with return date \"2024-10-15\"', '2024-10-10 10:45:44'),
(86, 1, '0', 'Returned a book with issue id \"25\"', '2024-10-10 10:46:21'),
(87, 1, '1', 'Approved returned book with issue id \"25\"', '2024-10-10 10:46:31'),
(88, 1, '0', 'Requested a book with id \"65\"', '2024-10-10 11:03:40'),
(89, 1, '1', 'Updated issued book \"Americas Prison\"', '2024-10-10 11:21:39'),
(90, 1, '1', 'Logged in', '2024-10-10 13:37:51'),
(91, 1, '1', 'Issued book \"Beastly\" with return date \"2024-10-22\"', '2024-10-10 13:38:18'),
(92, 1, '1', 'Logged in', '2024-10-10 13:51:37'),
(93, 1, '1', 'Updated issued book \"Americas Prison\"', '2024-10-10 13:51:47'),
(94, 1, '1', 'Updated issued book \"Americas Prison\"', '2024-10-10 13:52:00'),
(95, 1, '1', 'Updated issued book \"Americas Prison\"', '2024-10-10 13:52:13'),
(96, 1, '1', 'Updated issued book \"Americas Prison\"', '2024-10-10 13:52:24'),
(97, 1, '1', 'Updated issued book \"Americas Prison\"', '2024-10-10 15:31:51'),
(98, 1, '1', 'Updated issued book \"Americas Prison\"', '2024-10-10 15:33:49'),
(99, 1, '1', 'Updated issued book \"Americas Prison\"', '2024-10-10 15:35:46'),
(100, 1, '0', 'Logged in', '2024-10-10 15:38:16'),
(101, 1, '0', 'Requested a book with id \"54\"', '2024-10-10 16:01:56'),
(102, 1, '0', 'Logged in', '2024-10-11 12:44:40'),
(103, 1, '0', 'Requested a book with id \"49\"', '2024-10-11 12:48:33'),
(104, 0, '0', 'Registered', '2024-10-17 07:41:13'),
(105, 0, '0', 'Registered', '2024-10-17 07:44:08'),
(106, 0, '0', 'Registered', '2024-10-17 07:46:37'),
(107, 28, '0', 'Logged in', '2024-10-17 07:46:56'),
(108, 0, '0', 'Registered', '2024-10-17 09:19:04'),
(109, 29, '0', 'Logged in', '2024-10-17 09:19:30'),
(110, 1, '1', 'Logged in', '2024-10-17 09:23:54'),
(111, 1, '1', 'Added a new book \"Beauty and the Beast\"', '2024-10-17 09:48:35'),
(112, 29, '0', 'Logged in', '2024-10-17 09:55:54'),
(113, 29, '0', 'Requested a book with id \"74\"', '2024-10-17 09:56:18'),
(114, 1, '1', 'Issued book \"Beauty and the Beast\" with return date \"2024-10-30\"', '2024-10-17 10:01:41'),
(115, 1, '1', 'Updated issued book \"Beastly\"', '2024-10-17 10:08:42'),
(116, 1, '1', 'Updated issued book \"Beastly\"', '2024-10-17 10:10:19'),
(117, 1, '1', 'Updated issued book \"Beauty and the Beast\"', '2024-10-17 10:10:39'),
(118, 1, '1', 'Issued book \"The Hunger Games\" with return date \"2024-10-31\"', '2024-10-17 10:27:50'),
(119, 29, '0', 'Requested a book with id \"48\"', '2024-10-17 10:29:17'),
(120, 1, '1', 'Issued book \"Funny Animal\" with return date \"2024-10-29\"', '2024-10-17 10:29:34'),
(121, 1, '1', 'Updated issued book \"Beauty and the Beast\"', '2024-10-17 10:33:54'),
(122, 1, '1', 'Updated issued book \"Beauty and the Beast\"', '2024-10-17 10:34:10'),
(123, 1, '1', 'Updated issued book \"Beastly\"', '2024-10-17 10:39:25'),
(124, 1, '1', 'Updated issued book \"Beauty and the Beast\"', '2024-10-17 10:41:00'),
(125, 1, '1', 'Updated issued book \"Beastly\"', '2024-10-17 10:42:26'),
(126, 1, '1', 'Updated issued book \"Americas Prison\"', '2024-10-17 10:49:45'),
(127, 1, '1', 'Logged in', '2024-10-17 11:15:49'),
(128, 1, '1', 'Updated issued book \"Americas Prison\"', '2024-10-17 11:17:18'),
(129, 1, '1', 'Updated issued book \"Americas Prison\"', '2024-10-17 11:18:39'),
(130, 1, '1', 'Updated issued book \"Americas Prison\"', '2024-10-17 11:20:17'),
(131, 1, '1', 'Updated issued book \"The Hunger Games\"', '2024-10-17 11:22:22'),
(132, 1, '1', 'Updated issued book \"The Hunger Games\"', '2024-10-17 11:27:49'),
(133, 29, '0', 'Requested a book with id \"56\"', '2024-10-17 11:31:11'),
(134, 29, '0', 'Requested a book with id \"68\"', '2024-10-17 11:31:18'),
(135, 1, '1', 'Issued book \"Its My Life\" with return date \"2024-10-30\"', '2024-10-17 11:37:54'),
(136, 29, '0', 'Logged in', '2024-10-17 14:00:28'),
(137, 29, '0', 'Logged in', '2024-10-17 14:13:41'),
(138, 0, '0', 'Registered', '2024-10-19 19:45:47'),
(139, 0, '0', 'Logged in', '2024-10-19 19:46:58'),
(140, 3, '0', 'Logged in', '2024-10-19 19:50:45'),
(141, 1, '1', 'Logged in', '2024-10-19 19:51:52'),
(142, 1, '1', 'Logged in', '2024-10-19 19:52:41'),
(143, 0, '0', 'Logged in', '2024-10-20 07:46:27'),
(144, 1, '0', 'Requested a book with id \"74\"', '2024-10-20 07:58:40'),
(145, 1, '1', 'Logged in', '2024-10-20 08:01:10'),
(146, 1, '1', 'Logged in', '2024-10-20 08:05:08'),
(147, 1, '1', 'Issued book \"Beauty and the Beast\" with return date \"2024-10-30\"', '2024-10-20 08:51:17'),
(148, 1, '1', 'Updated issued book \"Beauty and the Beast\"', '2024-10-20 08:58:15'),
(149, 1, '1', 'Updated issued book \"Beauty and the Beast\"', '2024-10-20 08:58:34'),
(150, 1, '1', 'Updated issued book \"Beauty and the Beast\"', '2024-10-20 08:59:19'),
(151, 1, '1', 'Updated issued book \"Beauty and the Beast\"', '2024-10-20 09:00:33'),
(152, 1, '1', 'Updated issued book \"Its My Life\"', '2024-10-20 09:02:08'),
(153, 1, '1', 'Updated issued book \"Beauty and the Beast\"', '2024-10-20 09:03:10'),
(154, 1, '1', 'Updated issued book \"Beauty and the Beast\"', '2024-10-20 09:03:54'),
(155, 1, '1', 'Updated issued book \"Beauty and the Beast\"', '2024-10-20 09:06:55'),
(156, 1, '1', 'Updated issued book \"Beauty and the Beast\"', '2024-10-20 09:07:50'),
(157, 1, '1', 'Archived student with id \"1\"', '2024-10-20 10:10:42'),
(158, 1, '1', 'Archived student with id \"24\"', '2024-10-20 10:11:30'),
(159, 1, '1', 'Suspended student with id \"1\"', '2024-10-20 10:36:03'),
(160, 1, '1', 'Suspended student with id \"1\"', '2024-10-20 10:39:18'),
(161, 1, '1', 'Suspended student with id \"1\"', '2024-10-20 10:39:47'),
(162, 1, '1', 'Suspended student with id \"1\"', '2024-10-20 10:40:41'),
(163, 1, '1', 'Suspended student with id \"1\"', '2024-10-20 10:41:53'),
(164, 0, '0', 'Logged in', '2024-10-20 10:52:46'),
(165, 0, '0', 'Logged in', '2024-10-20 10:54:13'),
(166, 0, '0', 'Logged in', '2024-10-20 11:24:06'),
(167, 0, '0', 'Logged in', '2024-10-20 11:26:50'),
(168, 0, '0', 'Logged in', '2024-10-20 11:28:01'),
(169, 0, '0', 'Logged in', '2024-10-20 11:29:22'),
(170, 0, '0', 'Logged in', '2024-10-20 11:30:25'),
(171, 0, '0', 'Logged in', '2024-10-20 11:32:51'),
(172, 0, '0', 'Logged in', '2024-10-20 11:35:43'),
(173, 0, '0', 'Logged in', '2024-10-20 11:36:19'),
(174, 1, '1', 'Logged in', '2024-10-25 09:09:32'),
(175, 1, '1', 'Logged in', '2024-10-25 09:29:32'),
(176, 1, '1', 'Logged in', '2024-11-02 08:58:20'),
(177, 1, '1', 'Archived student with id \"0036488\"', '2024-11-02 10:07:42'),
(178, 1, '1', 'Archived student with id \"0036488\"', '2024-11-02 10:09:55'),
(179, 1, '1', 'Archived employee with id \"0036488\"', '2024-11-02 10:10:48'),
(180, 1, '1', 'Archived student with id \"1\"', '2024-11-02 10:11:16'),
(181, 1, '1', 'Archived employee with id \"0036488\"', '2024-11-02 10:11:26'),
(182, 1, '1', 'Archived employee with id \"0036488\"', '2024-11-02 10:11:30'),
(183, 1, '1', 'Archived employee with id \"0036488\"', '2024-11-02 10:11:33'),
(184, 1, '1', 'Logged in', '2024-11-02 10:20:36'),
(185, 1, '1', 'Updated employee with id \"35\"', '2024-11-02 10:39:38'),
(186, 1, '1', 'Updated employee with id \"35\"', '2024-11-02 10:39:47'),
(187, 1, '1', 'Logged in', '2024-11-02 19:55:07'),
(188, 1, '1', 'Archived employee with id \"0036488\"', '2024-11-02 19:55:16'),
(189, 1, '1', 'Archived employee with id \"0036488\"', '2024-11-02 19:55:21'),
(190, 1, '1', 'Archived employee with id \"0036488\"', '2024-11-02 19:56:40'),
(191, 1, '1', 'Archived employee with id \"0036488\"', '2024-11-02 19:56:43'),
(192, 1, '1', 'Archived employee with id \"0036488\"', '2024-11-02 19:56:56'),
(193, 1, '1', 'Archived employee with id \"0036488\"', '2024-11-02 19:57:05'),
(194, 1, '1', 'Archived employee with id \"0036488\"', '2024-11-02 19:57:53'),
(195, 1, '1', 'Archived employee with id \"0036488\"', '2024-11-02 19:57:58'),
(196, 1, '1', 'Archived student with id \"1\"', '2024-11-02 19:59:04'),
(197, 1, '1', 'Archived student with id \"1\"', '2024-11-02 19:59:08'),
(198, 2, '0', 'Logged in', '2024-11-05 08:41:43'),
(199, 2, '0', 'Logged in', '2024-11-05 08:43:02'),
(200, 1, '0', 'Logged in', '2024-11-05 08:44:01'),
(201, 2, '0', 'Logged in', '2024-11-05 08:48:02'),
(202, 1, '1', 'Logged in', '2024-11-05 08:48:35'),
(203, 2, '0', 'Logged in', '2024-11-05 08:54:16'),
(204, 2, '0', 'Logged in', '2024-11-05 09:07:11'),
(205, 1, '0', 'Logged in', '2024-11-05 09:07:27'),
(206, 2, '0', 'Logged in', '2024-11-05 09:08:22'),
(207, 35, '0', 'Requested a book with id \"74\"', '2024-11-05 09:12:44'),
(208, 1, '1', 'Logged in', '2024-11-05 09:13:12'),
(209, 1, '1', 'Issued book \"Beauty and the Beast\" with return date \"2024-11-14\"', '2024-11-05 09:13:48'),
(210, 1, '0', 'Logged in', '2024-11-05 09:14:26'),
(211, 1, '0', 'Logged in', '2024-11-05 09:17:01'),
(212, 1, '1', 'Logged in', '2024-11-05 09:32:42'),
(213, 1, '1', 'Logged in', '2024-11-06 22:11:07'),
(214, 1, '1', 'Logged in', '2024-11-06 22:22:40'),
(215, 2, '0', 'Logged in', '2024-11-06 22:50:53'),
(216, 35, '0', 'Requested a book with id \"72\"', '2024-11-06 22:55:43'),
(217, 1, '1', 'Logged in', '2024-11-06 22:57:51'),
(218, 1, '1', 'Logged in', '2024-11-07 08:21:31'),
(219, 1, '1', 'Updated book with id \"48\"', '2024-11-07 08:24:05'),
(220, 2, '0', 'Logged in', '2024-11-07 08:50:45'),
(221, 1, '1', 'Logged in', '2024-11-07 08:51:21'),
(222, 1, '1', 'Logged in', '2024-11-07 21:13:04'),
(223, 1, '1', 'Updated book with id \"48\"', '2024-11-07 21:16:01'),
(224, 1, '1', 'Updated book with id \"48\"', '2024-11-07 21:16:22'),
(225, 1, '1', 'Updated category with id \"38\"', '2024-11-07 21:19:18'),
(226, 1, '1', 'Updated category with id \"38\"', '2024-11-07 21:19:55'),
(227, 1, '1', 'Updated category with id \"38\"', '2024-11-07 21:23:07'),
(228, 1, '1', 'Updated category with id \"38\"', '2024-11-07 21:23:37'),
(229, 1, '1', 'Updated category with id \"38\"', '2024-11-07 21:23:45'),
(230, 1, '1', 'Updated book with id \"48\"', '2024-11-07 21:25:17'),
(231, 1, '1', 'Updated book with id \"48\"', '2024-11-07 21:25:24'),
(232, 1, '1', 'Logged in', '2024-11-07 21:30:36'),
(233, 3, '0', 'Logged in', '2024-11-17 13:59:16'),
(234, 1, '0', 'Logged in', '2024-11-17 14:00:01'),
(235, 1, '1', 'Logged in', '2024-11-17 14:01:42'),
(236, 1, '1', 'Logged in', '2024-11-19 09:28:37'),
(237, 1, '1', 'Updated book with id \"48\"', '2024-11-19 09:44:25'),
(238, 1, '0', 'Logged in', '2024-11-20 08:18:02'),
(239, 1, '0', 'Logged in', '2024-11-20 08:31:03'),
(240, 1, '1', 'Logged in', '2024-11-20 08:50:40'),
(241, 1, '1', 'Logged in', '2024-11-28 13:35:33'),
(242, 1, '0', 'Logged in', '2024-11-28 13:45:43'),
(243, 0, '0', 'Logged in', '2024-11-28 13:50:02'),
(244, 1, '0', 'Logged in', '2024-11-28 13:53:39'),
(245, 1, '1', 'Logged in', '2024-11-28 14:00:53'),
(246, 1, '0', 'Logged in', '2024-11-28 14:07:21'),
(247, 0, '0', 'Logged in', '2024-11-28 14:27:49'),
(248, 1, '1', 'Logged in', '2024-11-28 15:35:44'),
(249, 1234567, '0', 'Registered', '2025-07-23 13:37:28'),
(250, 0, '0', 'Logged in', '2025-07-23 13:38:36'),
(251, 0, '0', 'Logged in', '2025-07-23 14:04:20');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `status` varchar(100) NOT NULL,
  `sender` varchar(100) NOT NULL,
  `date` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `username`, `message`, `status`, `sender`, `date`) VALUES
(13, 'lebron', 'hello\r\n', 'yes', 'student', '08/15/2024 Thursday, 06:21 AM'),
(14, '', 'hi\r\n', 'no', 'admin', '11/07/2024 Thursday, 07:04 AM'),
(15, '', 'hi', 'no', 'admin', '11/07/2024 Thursday, 07:04 AM'),
(16, '', 'hi', 'no', 'admin', '11/07/2024 Thursday, 07:08 AM');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentid` int(111) NOT NULL,
  `lrn` varchar(25) NOT NULL,
  `yearlvl` varchar(128) NOT NULL,
  `student_username` varchar(111) NOT NULL,
  `fname` varchar(111) NOT NULL,
  `lname` varchar(111) NOT NULL,
  `Email` varchar(111) NOT NULL,
  `Password` varchar(111) NOT NULL,
  `PhoneNumber` varchar(111) NOT NULL,
  `studentpic` varchar(100) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0-student, 1-student-assistant',
  `status` tinyint(1) NOT NULL COMMENT '0-archived, 1-unarchived',
  `suspension` date DEFAULT NULL,
  `reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentid`, `lrn`, `yearlvl`, `student_username`, `fname`, `lname`, `Email`, `Password`, `PhoneNumber`, `studentpic`, `type`, `status`, `suspension`, `reason`) VALUES
(1, '101811070010', 'Grade 7', 'lebron', 'lebron jamess', '', 'paganahinutak@gmail.com', '123', '0152648790', 'lebron.png', 1, 1, '2024-11-11', ''),
(3, '101811070011', 'Grade 8', 'kobe', 'kobe bryant', '', 'kobe@gmail.com', '123456', '029833356373', 'kobe.jpg', 0, 1, NULL, ''),
(4, '101811070012', 'Grade 9', 'steph', 'stephen curry', '', 'stephen@gmail.com', '1234567', '4344654865769', 'steph.png', 0, 1, NULL, ''),
(24, '101811090030', 'Grade 10', 'kd', 'Kevin Durant', '', 'kd@example.com', 'pass123', '09123456789', '168291.png', 0, 1, NULL, ''),
(25, '123456789123', 'Grade 7', 'lex', 'Lexine ', '', 'lexinerae21@gmail.com', 'lexine', '09274983823', 'user2.png', 0, 1, NULL, ''),
(29, '109877848886', 'Grade 10', 'aezakmi', 'John', 'Doe', 'paganahinutak@gmail.com', 'hzakIVdF', '09123456789', 'user2.png', 0, 1, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `timer`
--

CREATE TABLE `timer` (
  `stdid` int(100) NOT NULL,
  `bid` int(100) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timer`
--

INSERT INTO `timer` (`stdid`, `bid`, `date`) VALUES
(1, 22, '2024-08-15 00:22:00'),
(3, 20, '2024-08-10 01:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `trendingbook`
--

CREATE TABLE `trendingbook` (
  `bookid` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trendingbook`
--

INSERT INTO `trendingbook` (`bookid`) VALUES
(22),
(20),
(33),
(28),
(48);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminid`);

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`authorid`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`bookid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryid`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issueinfo`
--
ALTER TABLE `issueinfo`
  ADD PRIMARY KEY (`issueid`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminid` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `authorid` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `bookid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryid` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `issueinfo`
--
ALTER TABLE `issueinfo`
  MODIFY `issueid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `studentid` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
