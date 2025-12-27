-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2025 at 01:45 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticketflow`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `entity_type` varchar(50) DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `performed_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `ticket_id`, `user_id`, `body`, `created_at`) VALUES
(1, 1, 1, 'you are a chutiya that\'s why you can\'t see anything you said so yourself', '2025-12-21 22:51:21'),
(2, 1, 1, 'And remember this, you chutiya.', '2025-12-21 22:51:50'),
(3, 3, 1, 'hey', '2025-12-24 17:18:38'),
(4, 2, 1, 'We have reduced the severity of the ticket to High since a workaround has now been found.', '2025-12-24 18:26:22'),
(5, 2, 2, 'The ticket is assigned to user1 and should show in their queue.', '2025-12-25 15:47:00'),
(6, 1, 1, 'Made changes.', '2025-12-25 16:53:23'),
(7, 2, 3, 'Added comment.\r\nThis is a comment. There should be an option to attach files in the comments as well.', '2025-12-25 16:55:07'),
(8, 105, 1, 'Raising the severity to critical because of the nature of the issue.', '2025-12-25 18:01:30'),
(9, 1, 1, 'Changing status to in progress. Work being done on linked isssue. Ticket ID: 102', '2025-12-25 18:28:24'),
(10, 110, 1, 'Now I have fucking 3 issues in my bucket.', '2025-12-26 09:47:00'),
(11, 113, 7, 'Assigning this ticket to myself because of the criticality.', '2025-12-26 10:51:18'),
(12, 113, 7, 'Here is a comment with attachment.', '2025-12-26 11:05:28'),
(13, 113, 7, 'Another attachment', '2025-12-26 11:05:53'),
(14, 113, 7, 'Another attachment', '2025-12-26 12:02:36'),
(15, 113, 7, 'attachment', '2025-12-26 12:12:02'),
(16, 106, 7, 'This is a comment with attachment.', '2025-12-26 12:56:38'),
(17, 106, 7, 'Here\'s another comment with another attachment.\r\nThis files contains the logs.', '2025-12-26 12:57:10'),
(18, 113, 7, 'this is attached file', '2025-12-26 13:00:03'),
(19, 103, 9, 'Kindly look at the findings. This is a comment with attachments.', '2025-12-26 14:08:49'),
(20, 137, 2, 'This ticket is taken up for analysis. See attachment.', '2025-12-26 22:44:41'),
(21, 139, 2, 'Ayyoooooooo.', '2025-12-26 22:57:29'),
(22, 139, 2, 'Yo', '2025-12-26 22:57:44'),
(23, 1, 1, 'ayo, attachment', '2025-12-26 23:36:22'),
(24, 166, 1, 'A comment with attachments. PFA', '2025-12-27 00:24:24'),
(25, 1, 2, 'Why only Admin bheyandchod is commenting on every ticket?', '2025-12-27 00:41:29');

-- --------------------------------------------------------

--
-- Table structure for table `comment_attachments`
--

CREATE TABLE `comment_attachments` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size` int(11) NOT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment_attachments`
--

INSERT INTO `comment_attachments` (`id`, `comment_id`, `file_name`, `file_path`, `file_size`, `uploaded_at`) VALUES
(1, 16, 'Screenshot 2024-02-27 224645.png', 'uploads/comments/1766753798_Screenshot_2024-02-27_224645.png', 34515, '2025-12-26 17:56:38'),
(2, 17, 'Screenshot 2024-03-13 105913.png', 'uploads/comments/1766753830_Screenshot_2024-03-13_105913.png', 71456, '2025-12-26 17:57:10'),
(3, 18, 'Screenshot 2024-02-26 123250.png', 'uploads/comments/1766754003_Screenshot_2024-02-26_123250.png', 394208, '2025-12-26 18:00:03'),
(4, 19, 'Screenshot 2024-03-04 142601.png', 'uploads/comments/1766758129_Screenshot_2024-03-04_142601.png', 11320, '2025-12-26 19:08:49'),
(5, 20, 'Screenshot 2024-03-14 095426.png', 'uploads/comments/1766789081_Screenshot_2024-03-14_095426.png', 10504, '2025-12-27 03:44:41'),
(6, 23, 'Screenshot 2024-03-08 094557.png', 'uploads/comments/1766792182_Screenshot_2024-03-08_094557.png', 47473, '2025-12-27 04:36:22'),
(7, 24, '121.png', 'uploads/comments/1766795064_121.png', 37720, '2025-12-27 05:24:24');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `project_key` varchar(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `project_key`, `created_by`, `created_at`) VALUES
(1, 'New Project', 'CRM123', 1, '2025-12-21 22:12:30'),
(2, 'Project Number2', 'KEY2', 1, '2025-12-21 22:16:47');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('open','in_progress','done','closed') DEFAULT 'open',
  `priority` enum('low','medium','high','critical') DEFAULT 'medium',
  `assignee_id` int(11) DEFAULT NULL,
  `reporter_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `project_id`, `title`, `description`, `status`, `priority`, `assignee_id`, `reporter_id`, `created_at`, `updated_at`) VALUES
(1, 2, 'Can\'t see anything', 'Hi I\'m a chutiya user who can\'t see anything, can\'t do anything, is handicapped.', 'in_progress', 'medium', 6, 1, '2025-12-21 22:25:48', '2025-12-26 14:03:22'),
(2, 2, 'High priority ticket', 'Hi,\r\nthis is a high proiority ticket.', 'open', 'low', 3, 1, '2025-12-21 22:26:06', '2025-12-25 16:53:36'),
(3, 2, 'Medium ticket', 'medium ticket medium ticket. medium ticket medium ticket.', 'in_progress', 'high', 5, 1, '2025-12-21 22:35:41', '2025-12-25 15:57:35'),
(4, 2, 'Low Ticket', 'Low ticket. Low ticket. Low ticket. Low ticket.', 'open', 'medium', 5, 1, '2025-12-21 22:36:10', '2025-12-26 09:17:45'),
(100, 2, 'API created ticket', 'Created via REST API', 'in_progress', 'critical', 1, 1, '2025-12-25 17:27:00', '2025-12-26 09:46:37'),
(101, 2, 'API created ticket', 'Created via REST API', 'in_progress', 'high', 3, 1, '2025-12-25 17:30:33', '2025-12-25 17:35:22'),
(102, 2, 'API created ticket 3', 'Created via REST API', 'closed', 'high', NULL, 1, '2025-12-25 17:33:18', '2025-12-25 17:35:34'),
(103, 2, 'Login fails on production', 'Users are unable to log in after deployment', 'in_progress', 'critical', 9, 1, '2025-12-25 17:57:51', '2025-12-26 14:08:18'),
(104, 2, 'Login fails on production', 'Users are unable to log in after deployment', 'open', 'high', NULL, 1, '2025-12-25 17:59:30', NULL),
(105, 2, 'Login fails on production', 'Users are unable to log in after deployment', 'open', 'medium', 7, 1, '2025-12-25 17:59:40', '2025-12-26 14:26:42'),
(106, 2, 'Unable to view record', 'Users are unable to see records in the system', 'done', 'high', 2, 1, '2025-12-25 18:26:56', '2025-12-26 11:24:31'),
(107, 1, 'Unable to view record', 'Users are unable to see records in the system', 'open', 'medium', 2, 1, '2025-12-25 18:27:01', '2025-12-25 18:27:01'),
(108, 1, 'Unable to view record', 'Users are unable to see records in the system', 'open', 'medium', 3, 1, '2025-12-25 18:27:07', '2025-12-25 18:27:07'),
(109, 1, 'A new issue has arose', 'There is a new issueUsers are unable to see records in the system', 'open', 'high', 2, 1, '2025-12-26 08:32:04', '2025-12-26 08:32:04'),
(110, 1, 'A new issue has arose', 'There is a new issueUsers are unable to see records in the system', 'open', 'high', 1, 1, '2025-12-26 08:32:08', '2025-12-26 09:46:46'),
(111, 2, 'A new issue has arose', 'There is a new issueUsers are unable to see records in the system', 'open', 'high', 5, 1, '2025-12-26 08:32:15', '2025-12-26 08:32:15'),
(112, 1, 'A new issue has arose', 'There is a new issueUsers are unable to see records in the system', 'open', 'high', 3, 1, '2025-12-26 08:32:23', '2025-12-26 08:32:23'),
(113, 2, 'Unable to create anything', 'Anything can not be created no matter what I do. My life is fucked.', 'closed', 'critical', 7, 1, '2025-12-26 10:50:08', '2025-12-26 12:59:30'),
(114, 1, 'Error while executing the task', 'Bhai sab phat gaya hai kuch nai chal raha. Bund bhi phat gaee hai sath he.', 'open', 'high', 7, 1, '2025-12-26 11:51:56', '2025-12-26 11:51:56'),
(115, 2, 'Error while executing the task', 'Bhai sab phat gaya hai kuch nai chal raha. Bund bhi phat gaee hai sath he.', 'open', 'high', 7, 1, '2025-12-26 13:00:31', '2025-12-26 13:00:31'),
(116, 1, 'Login fails with valid credentials', 'Users report valid credentials being rejected on first attempt.', 'open', 'low', 1, 2, '2025-12-26 14:24:48', '2025-12-26 14:24:48'),
(117, 2, 'API response delay on dashboard load', 'Dashboard takes longer than expected to fetch summary data.', 'open', 'medium', 2, 2, '2025-12-26 14:24:48', '2025-12-26 14:24:48'),
(118, 1, 'Incorrect ticket count displayed', 'Total tickets shown do not match database records.', 'open', 'high', 3, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(119, 2, 'File upload progress stuck at 90%', 'Large file uploads appear to freeze near completion.', 'open', 'low', 3, 2, '2025-12-26 14:24:49', '2025-12-26 22:35:44'),
(120, 1, 'Broken navigation link in sidebar', 'Sidebar link redirects to a non-existing route.', 'open', 'medium', 5, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(121, 2, 'Email notifications not triggering', 'Assignment emails are not being sent to users.', 'open', 'medium', 6, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(122, 1, 'Ticket status resets after refresh', 'Updated ticket status reverts after page reload.', 'open', 'low', 7, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(123, 2, 'Comment formatting lost', 'Line breaks are removed when saving comments.', 'open', 'medium', 8, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(124, 1, 'Search results incomplete', 'Search misses tickets containing special characters.', 'open', 'high', 9, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(125, 2, 'Unauthorized access warning shown', 'Authorized users see access denied message intermittently.', 'open', 'low', NULL, 2, '2025-12-26 14:24:49', NULL),
(126, 1, 'Pagination resets filters', 'Filters are cleared when moving between pages.', 'open', 'medium', 1, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(127, 2, 'Slow ticket creation under load', 'Ticket submission slows down during peak hours.', 'open', 'critical', 2, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(128, 1, 'Attachment preview missing', 'Uploaded images do not show preview thumbnails.', 'open', 'low', 3, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(129, 2, 'Incorrect user role displayed', 'User profile shows outdated role name.', 'open', 'medium', NULL, 2, '2025-12-26 14:24:49', NULL),
(130, 1, 'PDF export crashes', 'Exporting tickets to PDF fails for large datasets.', 'open', 'high', 5, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(131, 2, 'Excel export encoding issue', 'Special characters appear corrupted in Excel.', 'open', 'low', 6, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(132, 1, 'Session expires too early', 'Users are logged out before session timeout.', 'open', 'medium', 7, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(133, 2, 'Assignee filter incorrect', 'Filtering by assignee returns wrong tickets.', 'open', 'high', 8, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(134, 1, 'Priority badge color mismatch', 'Priority color does not match severity.', 'open', 'low', 9, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(135, 2, 'Installer skips some tables', 'Fresh install misses attachment tables.', 'open', 'medium', NULL, 2, '2025-12-26 14:24:49', NULL),
(136, 1, 'Ticket update not reflected', 'Edited ticket details are not saved properly.', 'open', 'high', 1, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(137, 2, 'Comment count mismatch', 'Displayed comment count differs from actual.', 'open', 'low', 2, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(138, 1, 'Broken profile avatar upload', 'User avatar upload fails silently.', 'open', 'medium', 3, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(139, 2, 'Project switch reload issue', 'Switching projects reloads incorrect data.', 'open', 'high', NULL, 2, '2025-12-26 14:24:49', NULL),
(140, 1, 'Audit log missing entries', 'Some ticket actions are not logged.', 'open', 'low', 5, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(141, 2, 'Dashboard widgets misaligned', 'Dashboard boxes overlap on smaller screens.', 'open', 'medium', 6, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(142, 1, 'Role permission leak', 'Non-admin users can edit restricted fields.', 'open', 'high', 7, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(143, 2, 'Time tracking incorrect', 'Logged work hours do not sum correctly.', 'open', 'low', 8, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(144, 1, 'Ticket deletion not confirmed', 'Tickets are deleted without confirmation prompt.', 'open', 'medium', 9, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(145, 2, 'Bulk actions partially applied', 'Bulk updates affect only some tickets.', 'open', 'high', NULL, 2, '2025-12-26 14:24:49', NULL),
(146, 1, 'Notification badge not updating', 'Unread notification count remains stale.', 'open', 'low', 1, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(147, 2, 'Search indexing delay', 'New tickets are not searchable immediately.', 'open', 'medium', 6, 2, '2025-12-26 14:24:49', '2025-12-26 23:37:19'),
(148, 1, 'Dark mode contrast issue', 'Text becomes unreadable in dark mode.', 'open', 'high', 3, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(149, 2, 'Attachment delete fails', 'Removing attachments throws server error.', 'open', 'low', NULL, 2, '2025-12-26 14:24:49', NULL),
(150, 1, 'Ticket history incomplete', 'Some status changes missing in history.', 'open', 'medium', 5, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(151, 2, 'Project archive not working', 'Archived projects still appear active.', 'open', 'high', 6, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(152, 1, 'User dropdown truncated', 'Assignee dropdown cuts off long names.', 'open', 'low', 7, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(153, 2, 'Sorting resets after refresh', 'Applied sorting order is lost.', 'open', 'medium', 8, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(154, 1, 'Ticket cloning duplicates attachments', 'Cloned tickets copy attachments unexpectedly.', 'open', 'high', 9, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(155, 2, 'API rate limit too strict', 'Normal usage exceeds API rate limit.', 'open', 'low', NULL, 2, '2025-12-26 14:24:49', NULL),
(156, 1, 'User invitation email broken', 'Invited users do not receive signup email.', 'open', 'medium', 1, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(157, 2, 'Ticket SLA timer inaccurate', 'SLA countdown does not pause correctly.', 'open', 'high', 2, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(158, 1, 'Form validation inconsistent', 'Some required fields allow empty submission.', 'open', 'low', 3, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(159, 2, 'Cross-project ticket visibility bug', 'Tickets appear in wrong project lists.', 'open', 'medium', NULL, 2, '2025-12-26 14:24:49', NULL),
(160, 1, 'Ticket numbering skips values', 'Auto-increment ticket numbers are not sequential.', 'open', 'high', 5, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(161, 2, 'Logout redirect incorrect', 'Logout redirects to wrong landing page.', 'open', 'low', 6, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(162, 1, 'Assignee change not logged', 'Changing assignee does not appear in history.', 'open', 'medium', 7, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(163, 2, 'Mobile layout breaks on comments', 'Comment section overflows on mobile screens.', 'open', 'high', 8, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(164, 1, 'Ticket merge loses data', 'Merged tickets drop older comments.', 'open', 'low', 9, 2, '2025-12-26 14:24:49', '2025-12-26 14:24:49'),
(165, 2, 'System logs missing errors', 'Critical errors are not written to logs.', 'open', 'medium', NULL, 2, '2025-12-26 14:24:49', NULL),
(166, 2, 'A new test ticket has been opened', 'This is some dummy text. A new test ticket has been opened. This is some dummy text. A new test ticket has been opened. This is some dummy text. A new test ticket has been opened. This is some dummy text. A new test ticket has been opened. This is some dummy text. A new test ticket has been opened.', 'open', 'medium', NULL, 1, '2025-12-27 00:22:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_attachments`
--

CREATE TABLE `ticket_attachments` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket_attachments`
--

INSERT INTO `ticket_attachments` (`id`, `ticket_id`, `file_name`, `file_path`, `uploaded_at`) VALUES
(1, 3, 'upwork.PNG', 'uploads/6948763d83395.png', '2025-12-21 22:35:41'),
(2, 4, 'The Sopranos Season 4 Episode 12 - Eloise.avi_snapshot_52.07_[2019.09.20_14.22.10].jpg', 'uploads/6948765ab6ed9.jpg', '2025-12-21 22:36:10'),
(3, 113, 'Screenshot 2024-03-04 145209.png', 'uploads/694e68606ab6a.png', '2025-12-26 10:50:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','manager','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `api_token` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `api_token`) VALUES
(1, 'Admin', 'admin@ticketflow.local', '$2y$10$9F2BIbCIp3uqxHf.ga6QAOxbe/9wHrtcw5fr4WTEDJuunyLJDd2QC', 'admin', '2025-12-21 21:56:41', '3f682f8563cc53e0314984067d04936bfda339c4576ec24493a086b8275c4f2e'),
(2, 'Mansoor Shah', 'user1@ticketflow.local', '$2y$10$9F2BIbCIp3uqxHf.ga6QAOxbe/9wHrtcw5fr4WTEDJuunyLJDd2QC', 'user', '2025-12-21 21:56:41', 'a8d74fa41ea862069086f997442c42072404a09e9d84717c685507bd2729faec'),
(3, 'Ziyad Alvi', 'user2@ticketflow.local', '$2y$10$9F2BIbCIp3uqxHf.ga6QAOxbe/9wHrtcw5fr4WTEDJuunyLJDd2QC', 'user', '2025-12-21 21:56:41', NULL),
(5, 'Taloor Ansari', 'user3@ticketflow.local', '$2y$10$9F2BIbCIp3uqxHf.ga6QAOxbe/9wHrtcw5fr4WTEDJuunyLJDd2QC', 'user', '2025-12-21 21:56:41', NULL),
(6, 'Arsalan Pervez', 'user4@ticketflow.local', '$2y$10$9F2BIbCIp3uqxHf.ga6QAOxbe/9wHrtcw5fr4WTEDJuunyLJDd2QC', 'user', '2025-12-21 21:56:41', NULL),
(7, 'Uzain Ali Khan', 'user5@ticketflow.local', '$2y$10$9F2BIbCIp3uqxHf.ga6QAOxbe/9wHrtcw5fr4WTEDJuunyLJDd2QC', 'user', '2025-12-21 21:56:41', NULL),
(8, 'Dada1', 'user6@ticketflow.local', '$2y$10$9F2BIbCIp3uqxHf.ga6QAOxbe/9wHrtcw5fr4WTEDJuunyLJDd2QC', 'user', '2025-12-21 21:56:41', NULL),
(9, 'Dada2', 'user7@ticketflow.local', '$2y$10$9F2BIbCIp3uqxHf.ga6QAOxbe/9wHrtcw5fr4WTEDJuunyLJDd2QC', 'user', '2025-12-21 21:56:41', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `comment_attachments`
--
ALTER TABLE `comment_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comment_attachment` (`comment_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `assignee_id` (`assignee_id`),
  ADD KEY `reporter_id` (`reporter_id`);

--
-- Indexes for table `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `api_token` (`api_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `comment_attachments`
--
ALTER TABLE `comment_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `comment_attachments`
--
ALTER TABLE `comment_attachments`
  ADD CONSTRAINT `fk_comment_attachment` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`assignee_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  ADD CONSTRAINT `ticket_attachments_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
