-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: May 27, 2016 at 04:47 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ark_minories`
--

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_alias`
--

CREATE TABLE `cor_conf_alias` (
  `element_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `tbl` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `col` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `src_key` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `lang` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_ark`
--

CREATE TABLE `cor_conf_ark` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `markup` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `site_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `display_errors` tinyint(1) NOT NULL,
  `log_ins` tinyint(1) NOT NULL,
  `log_upd` tinyint(1) NOT NULL,
  `log_del` tinyint(1) NOT NULL,
  `search_mode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `search_ftx_mode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `anon_login` tinyint(1) NOT NULL,
  `anon_user` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `anon_password` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `skin` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `skin_mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `form_method` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `arkthumb_width` int(11) NOT NULL,
  `arkthumb_height` int(11) NOT NULL,
  `webthumb_width` int(11) NOT NULL,
  `webthumb_height` int(11) NOT NULL,
  `max_upload_size` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `version_original` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `version_database` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_condition`
--

CREATE TABLE `cor_conf_condition` (
  `element_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `seq` int(11) NOT NULL,
  `func` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `args` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_element`
--

CREATE TABLE `cor_conf_element` (
  `element_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `element_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `markup` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_element_type`
--

CREATE TABLE `cor_conf_element_type` (
  `element_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `conf_table` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `conf_key` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_element_vld`
--

CREATE TABLE `cor_conf_element_vld` (
  `element_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `vld_role` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `vld_group_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_field`
--

CREATE TABLE `cor_conf_field` (
  `field_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `dataclass` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `classtype` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `editable` tinyint(1) NOT NULL,
  `hidden` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_group`
--

CREATE TABLE `cor_conf_group` (
  `element_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `seq` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `child_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_layout_role`
--

CREATE TABLE `cor_conf_layout_role` (
  `layout_role` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_link`
--

CREATE TABLE `cor_conf_link` (
  `link_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `markup` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `link_class` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `img_class` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `list_class` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `lightbox` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `page` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `reload_page` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `query` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_modtype`
--

CREATE TABLE `cor_conf_modtype` (
  `module_id` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `modtype` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `markup` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `schema_group_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_module`
--

CREATE TABLE `cor_conf_module` (
  `module_id` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `itemkey` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `markup` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `tbl` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `type_lut_tbl` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `description` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_option`
--

CREATE TABLE `cor_conf_option` (
  `element_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `option_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_page`
--

CREATE TABLE `cor_conf_page` (
  `page_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `sgrp` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `code_dir` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `nav_seq` int(11) NOT NULL,
  `navname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `nav_link_vars` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_page_layout`
--

CREATE TABLE `cor_conf_page_layout` (
  `page_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `module_id` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `layout_role` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `layout_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_subform`
--

CREATE TABLE `cor_conf_subform` (
  `subform_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `view_state` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `edit_state` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nav_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `script` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `input` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_ user_role`
--

CREATE TABLE `cor_conf_ user_role` (
  `user_role` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `markup` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_vld_group`
--

CREATE TABLE `cor_conf_vld_group` (
  `vld_group_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `seq` int(11) NOT NULL,
  `vld_rule_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_vld_role`
--

CREATE TABLE `cor_conf_vld_role` (
  `vld_role` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_vld_rule`
--

CREATE TABLE `cor_conf_vld_rule` (
  `vld_rule_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `rq_func` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `vd_func` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `var_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `lv_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `var_locn` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `force_var` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `req_keytype` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ret_keytype` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cor_conf_alias`
--
ALTER TABLE `cor_conf_alias`
  ADD PRIMARY KEY (`element_id`);

--
-- Indexes for table `cor_conf_ark`
--
ALTER TABLE `cor_conf_ark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cor_conf_condition`
--
ALTER TABLE `cor_conf_condition`
  ADD PRIMARY KEY (`element_id`,`seq`);

--
-- Indexes for table `cor_conf_element`
--
ALTER TABLE `cor_conf_element`
  ADD PRIMARY KEY (`element_id`);

--
-- Indexes for table `cor_conf_element_type`
--
ALTER TABLE `cor_conf_element_type`
  ADD PRIMARY KEY (`element_type`);

--
-- Indexes for table `cor_conf_element_vld`
--
ALTER TABLE `cor_conf_element_vld`
  ADD PRIMARY KEY (`element_id`,`vld_role`);

--
-- Indexes for table `cor_conf_field`
--
ALTER TABLE `cor_conf_field`
  ADD PRIMARY KEY (`field_id`);

--
-- Indexes for table `cor_conf_group`
--
ALTER TABLE `cor_conf_group`
  ADD PRIMARY KEY (`element_id`,`seq`);

--
-- Indexes for table `cor_conf_layout_role`
--
ALTER TABLE `cor_conf_layout_role`
  ADD PRIMARY KEY (`layout_role`);

--
-- Indexes for table `cor_conf_link`
--
ALTER TABLE `cor_conf_link`
  ADD PRIMARY KEY (`link_id`);

--
-- Indexes for table `cor_conf_modtype`
--
ALTER TABLE `cor_conf_modtype`
  ADD PRIMARY KEY (`module_id`,`modtype`);

--
-- Indexes for table `cor_conf_module`
--
ALTER TABLE `cor_conf_module`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `cor_conf_option`
--
ALTER TABLE `cor_conf_option`
  ADD PRIMARY KEY (`element_id`,`option_id`);

--
-- Indexes for table `cor_conf_page`
--
ALTER TABLE `cor_conf_page`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `cor_conf_page_layout`
--
ALTER TABLE `cor_conf_page_layout`
  ADD PRIMARY KEY (`page_id`,`module_id`,`layout_role`);

--
-- Indexes for table `cor_conf_subform`
--
ALTER TABLE `cor_conf_subform`
  ADD PRIMARY KEY (`subform_id`);

--
-- Indexes for table `cor_conf_ user_role`
--
ALTER TABLE `cor_conf_ user_role`
  ADD PRIMARY KEY (`user_role`);

--
-- Indexes for table `cor_conf_vld_group`
--
ALTER TABLE `cor_conf_vld_group`
  ADD PRIMARY KEY (`vld_group_id`,`seq`);

--
-- Indexes for table `cor_conf_vld_role`
--
ALTER TABLE `cor_conf_vld_role`
  ADD PRIMARY KEY (`vld_role`);

--
-- Indexes for table `cor_conf_vld_rule`
--
ALTER TABLE `cor_conf_vld_rule`
  ADD PRIMARY KEY (`vld_rule_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cor_conf_ark`
--
ALTER TABLE `cor_conf_ark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
