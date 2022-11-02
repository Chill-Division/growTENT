SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `growTENT`
--
CREATE DATABASE IF NOT EXISTS `growTENT` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `growTENT`;

-- --------------------------------------------------------

--
-- Table structure for table `cultivars`
--

CREATE TABLE `cultivars` (
  `id` int NOT NULL,
  `cultivar_name` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `expected_thc` int NOT NULL,
  `expected_cbd` int NOT NULL,
  `expected_flowertime` varchar(32) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int NOT NULL,
  `facilityname` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `approved_for_cultivation` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `max_flowers` varchar(16) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int NOT NULL,
  `facilityid` int NOT NULL,
  `facilityname` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `date_of_spawn` date NOT NULL COMMENT 'What was the date of spawn, either cutting day or date the seed popped',
  `date_of_harvest` date DEFAULT NULL COMMENT 'What day did we harvest the plant?',
  `date_of_pack` date DEFAULT NULL COMMENT 'What day was it packed, after drying / curing?',
  `date_of_disposal` date DEFAULT NULL,
  `date_of_lastmove` date DEFAULT NULL,
  `date_prop_nursery` date DEFAULT NULL,
  `date_nursery_vege` date DEFAULT NULL,
  `date_vege_flower` date DEFAULT NULL,
  `mother_uniqueid` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `plant_uniqueid` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `season_id` varchar(8) COLLATE utf8mb4_general_ci NOT NULL,
  `plant_num` int NOT NULL,
  `where_is_it_now` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `harvest_ww` int DEFAULT NULL COMMENT 'Harvest wet weight (grams)',
  `harvest_dw` int DEFAULT NULL COMMENT 'Harvest dry weight (grams). If 0, we will provide it later. If null, we won''t provide one',
  `current_state` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `cultivar` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `is_alive` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nutrients`
--

CREATE TABLE `nutrients` (
  `seasonid` varchar(8) COLLATE utf8mb4_general_ci NOT NULL,
  `reservoir` int NOT NULL,
  `amount` int NOT NULL,
  `ecstrength` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plant_notes`
--

CREATE TABLE `plant_notes` (
  `id` int NOT NULL,
  `plant_uniqueid` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `note_date` date NOT NULL,
  `notes` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seasons`
--

CREATE TABLE `seasons` (
  `seasonid` int NOT NULL,
  `year` year NOT NULL,
  `season_number` int NOT NULL,
  `cultivarid` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `name_of_preparer` varchar(128) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Name of staff preparing shipment',
  `email_for_notifications` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `date_of_preparation` date NOT NULL COMMENT 'Date prepared for shipping',
  `time_of_preparation` time NOT NULL COMMENT 'Time prepared for shipping',
  `product_type` varchar(128) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Product type (eg cutting, plant, wet flower, dry flower etc)\r\n*',
  `number_being_shipped` int NOT NULL COMMENT '# of bags / plants / containers',
  `total_weight` int NOT NULL COMMENT 'Total shipment weight (if applicable) excl packaging',
  `total_weight_incl_packaging` int NOT NULL COMMENT 'Total weight including packaging, either / or to be used',
  `recipient_name` varchar(256) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Receipient name / company',
  `destination_address` text COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Destination address',
  `collected_by` varchar(256) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Collected from facility by',
  `date_of_collection` date NOT NULL COMMENT 'Date of collection',
  `time_of_collection` time NOT NULL COMMENT 'Time of collection',
  `number_collected` int NOT NULL COMMENT '# of bags / plants / containers collected',
  `received_by` varchar(256) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Received by (name)',
  `date_of_receipt` date NOT NULL COMMENT 'Date of receipt',
  `time_of_receipt` time NOT NULL COMMENT 'Time of receipt',
  `number collected` int NOT NULL COMMENT '# of bags / plants / containers collected',
  `confirmed_delivery_matched` int NOT NULL COMMENT '0 unset, 1 is matched, 2 is unmatched',
  `uniqueid` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treatments`
--

CREATE TABLE `treatments` (
  `id` int NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `room` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `action_taken` varchar(128) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int NOT NULL,
  `Name` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `Phone` varchar(24) COLLATE utf8mb4_general_ci NOT NULL,
  `Purpose` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `EscortedBy` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `TimeIn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `haz_light` int NOT NULL,
  `haz_co2` int NOT NULL,
  `haz_gloves` int NOT NULL,
  `haz_flame` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cultivars`
--
ALTER TABLE `cultivars`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plant_notes`
--
ALTER TABLE `plant_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seasons`
--
ALTER TABLE `seasons`
  ADD PRIMARY KEY (`seasonid`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`uniqueid`,`date_of_preparation`);

--
-- Indexes for table `treatments`
--
ALTER TABLE `treatments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cultivars`
--
ALTER TABLE `cultivars`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plant_notes`
--
ALTER TABLE `plant_notes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seasons`
--
ALTER TABLE `seasons`
  MODIFY `seasonid` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `uniqueid` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `treatments`
--
ALTER TABLE `treatments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
