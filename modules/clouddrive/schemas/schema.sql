SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Table structure for table `filebox`
--

CREATE TABLE IF NOT EXISTS `filebox` (
  `file_srl` int(11) NOT NULL AUTO_INCREMENT,
  `file_type` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `sid` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `down_cnt` int(11) NOT NULL DEFAULT '0',
  `dir_down` char(1) COLLATE utf8_bin DEFAULT 'Y',
  `upload_file_name` varchar(250) COLLATE utf8_bin NOT NULL,
  `source_file_name` varchar(250) COLLATE utf8_bin NOT NULL,
  `file_size` int(11) NOT NULL DEFAULT '0',
  `module_srl` int(11) DEFAULT NULL, 
  `tag` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `isvalid` char(1) COLLATE utf8_bin DEFAULT 'Y',
  `member_srl`int(11) DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL, 
  `ip_address` varchar(128) COLLATE utf8_bin NOT NULL,	 
PRIMARY KEY (`file_srl`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- --------------------------------------------------------

--
-- Table structure for table `filetag`
--
CREATE TABLE IF NOT EXISTS `filetag` (
  `tag_id` int(3) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `sid` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL, 
PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

