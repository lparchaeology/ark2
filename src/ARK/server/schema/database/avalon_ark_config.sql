-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 21, 2018 at 07:17 PM
-- Server version: 10.2.12-MariaDB
-- PHP Version: 7.1.13

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `avalon_ark_core`
--

--
-- Dumping data for table `ark_model`
--

INSERT INTO `ark_model` (`model`, `enabled`, `deprecated`, `keyword`) VALUES
('arch', 1, 0, NULL);

--
-- Dumping data for table `ark_model_association`
--

INSERT INTO `ark_model_association` (`model`, `schma`, `class`, `association`, `schema1`, `schema2`, `enabled`, `deprecated`, `keyword`) VALUES
('arch', 'arch.area', 'site', 'context_find', 'arch.context', 'arch.find', 1, 0, NULL),
('arch', 'arch.area', 'site', 'context_sample', 'arch.context', 'arch.sample', 1, 0, NULL),
('arch', 'arch.area', 'site', 'find_context', 'arch.find', 'arch.context', 1, 0, NULL),
('arch', 'arch.area', 'site', 'photo_context', 'arch.photo', 'arch.context', 1, 0, NULL),
('arch', 'arch.area', 'site', 'section_context', 'arch.section', 'arch.context', 1, 0, NULL),
('arch', 'arch.area', 'site', 'section_drawing', 'arch.section', 'arch.drawing', 1, 0, NULL),
('arch', 'arch.area', 'site', 'timber_drawing', 'arch.timber', 'arch.drawing', 1, 0, NULL);

--
-- Dumping data for table `ark_model_attribute`
--

INSERT INTO `ark_model_attribute` (`schma`, `class`, `attribute`, `dataclass`, `vocabulary`, `event`, `edit`, `view`, `span`, `minimum`, `maximum`, `unique_values`, `additional_values`, `visibility`, `enabled`, `deprecated`, `keyword`) VALUES
('arch.area', 'area', 'class', 'identifier', 'arch.area.class', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.area', 'area', 'id', 'identifier', NULL, NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.area', 'area', 'status', 'term', 'core.item.status', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.area', 'area', 'visibility', 'term', 'core.visibility', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.context', 'context', 'class', 'term', 'arch.context.class', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, 'arch.context.class'),
('arch.context', 'context', 'description', 'plaintext', 'core.event.class', 'described', 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, 'arch.context.description'),
('arch.context', 'context', 'id', 'identifier', NULL, NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, 'arch.context.id'),
('arch.context', 'context', 'register', 'shorttext', NULL, NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, 'arch.context.register'),
('arch.context', 'context', 'registered', 'event', 'core.event.class', 'registered', 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, 'arch.context.registered'),
('arch.context', 'context', 'snapshot', 'image', NULL, NULL, 'arch.item.update', 'arch.item.read', 0, 0, 0, 1, 0, 'restricted', 1, 0, 'arch.context.snapshot'),
('arch.context', 'context', 'status', 'term', 'core.item.status', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, 'core.item.status'),
('arch.context', 'context', 'visibility', 'term', 'core.visibility', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, 'core.visibility'),
('arch.drawing', 'drawing', 'class', 'identifier', 'arch.drawing.class', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.drawing', 'drawing', 'id', 'identifier', NULL, NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.drawing', 'drawing', 'status', 'term', 'core.item.status', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.drawing', 'drawing', 'visibility', 'term', 'core.visibility', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.find', 'find', 'class', 'term', 'arch.find.class', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.find', 'find', 'id', 'identifier', NULL, NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.find', 'find', 'register', 'shorttext', NULL, NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, 'arch.context.register'),
('arch.find', 'find', 'status', 'term', 'core.item.status', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.find', 'find', 'visibility', 'term', 'core.visibility', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.group', 'group', 'class', 'identifier', 'arch.group.class', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.group', 'group', 'id', 'identifier', NULL, NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.group', 'group', 'status', 'term', 'core.item.status', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.group', 'group', 'visibility', 'term', 'core.visibility', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.landuse', 'landuse', 'class', 'identifier', 'arch.landuse.class', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.landuse', 'landuse', 'id', 'identifier', NULL, NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.landuse', 'landuse', 'status', 'term', 'core.item.status', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.landuse', 'landuse', 'visibility', 'term', 'core.visibility', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.photo', 'photo', 'class', 'identifier', 'arch.photo.class', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.photo', 'photo', 'id', 'identifier', NULL, NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.photo', 'photo', 'status', 'term', 'core.item.status', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.photo', 'photo', 'visibility', 'term', 'core.visibility', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.project', 'project', 'class', 'identifier', 'arch.project.class', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.project', 'project', 'id', 'identifier', NULL, NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.project', 'project', 'status', 'term', 'core.item.status', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.project', 'project', 'visibility', 'term', 'core.visibility', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.sample', 'sample', 'class', 'identifier', 'arch.sample.class', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.sample', 'sample', 'id', 'identifier', NULL, NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.sample', 'sample', 'status', 'term', 'core.item.status', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.sample', 'sample', 'visibility', 'term', 'core.visibility', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.section', 'section', 'class', 'identifier', 'arch.section.class', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.section', 'section', 'id', 'identifier', NULL, NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.section', 'section', 'status', 'term', 'core.item.status', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.section', 'section', 'visibility', 'term', 'core.visibility', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.site', 'site', 'class', 'identifier', 'arch.site.class', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.site', 'site', 'id', 'identifier', NULL, NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.site', 'site', 'status', 'term', 'core.item.status', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.site', 'site', 'visibility', 'term', 'core.visibility', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.subgroup', 'subgroup', 'class', 'identifier', 'arch.subgroup.class', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.subgroup', 'subgroup', 'id', 'identifier', NULL, NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.subgroup', 'subgroup', 'status', 'term', 'core.item.status', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.subgroup', 'subgroup', 'visibility', 'term', 'core.visibility', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.timber', 'timber', 'class', 'identifier', 'arch.timber.class', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.timber', 'timber', 'id', 'identifier', NULL, NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'public', 1, 0, NULL),
('arch.timber', 'timber', 'status', 'term', 'core.item.status', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL),
('arch.timber', 'timber', 'visibility', 'term', 'core.visibility', NULL, 'arch.item.update', 'arch.item.read', 0, 1, 1, 1, 0, 'restricted', 1, 0, NULL);

--
-- Dumping data for table `ark_model_class`
--

INSERT INTO `ark_model_class` (`schma`, `class`, `vocabulary`, `namespace`, `entity`, `classname`, `superclass`, `instantiable`, `enabled`, `deprecated`) VALUES
('arch.area', 'area', 'arch.area.class', 'Entity', 'Area', 'Entity\\Area', 1, 1, 1, 0),
('arch.area', 'trench', 'arch.area.class', 'Entity', 'Area', NULL, 0, 1, 1, 0),
('arch.context', 'context', 'arch.context.class', 'Entity', 'Context', 'Entity\\Context', 1, 0, 1, 0),
('arch.context', 'cut', 'arch.context.class', 'Entity', 'Context', NULL, 0, 1, 1, 0),
('arch.context', 'fill', 'arch.context.class', 'Entity', 'Context', NULL, 0, 1, 1, 0),
('arch.context', 'masonry', 'arch.context.class', 'Entity', 'Context', NULL, 0, 1, 1, 0),
('arch.context', 'skeleton', 'arch.context.class', 'Entity', 'Context', NULL, 0, 1, 1, 0),
('arch.context', 'timber', 'arch.context.class', 'Entity', 'Context', NULL, 0, 1, 1, 0),
('arch.drawing', 'drawing', 'arch.drawing.class', 'Entity', 'Drawing', 'Entity\\Drawing', 0, 1, 1, 0),
('arch.find', 'coin', 'arch.find.class', 'Entity', 'Find', NULL, 0, 1, 1, 0),
('arch.find', 'find', 'arch.find.class', 'Entity', 'Find', 'Entity\\Find', 1, 0, 1, 0),
('arch.find', 'object', 'arch.find.class', 'Entity', 'Find', NULL, 0, 1, 1, 0),
('arch.group', 'group', 'arch.group.class', 'Entity', 'Group', 'Entity\\Group', 1, 1, 1, 0),
('arch.landuse', 'landuse', 'arch.landuse.class', 'Entity', 'Landuse', 'Entity\\Landuse', 1, 1, 1, 0),
('arch.photo', 'photo', 'arch.photo.class', 'Entity', 'Photo', 'Entity\\Photo', 1, 1, 1, 0),
('arch.project', 'project', 'arch.project.class', 'Entity', 'Project', 'Entity\\Project', 1, 1, 1, 0),
('arch.sample', 'sample', 'arch.sample.class', 'Entity', 'Sample', 'Entity\\Sample', 1, 1, 1, 0),
('arch.section', 'section', 'arch.section.class', 'Entity', 'Section', 'Entity\\Section', 1, 1, 1, 0),
('arch.site', 'site', 'arch.site.class', 'Entity', 'Site', 'Entity\\Site', 1, 1, 1, 0),
('arch.subgroup', 'subgroup', 'arch.subgroup.class', 'Entity', 'Subgroup', 'Entity\\Subgroup', 1, 1, 1, 0),
('arch.timber', 'timber', 'arch.timber.class', 'Entity', 'Timber', 'Entity\\Timber', 1, 1, 1, 0);

--
-- Dumping data for table `ark_model_module`
--

INSERT INTO `ark_model_module` (`module`, `resource`, `tbl`, `core`, `enabled`, `deprecated`, `keyword`) VALUES
('area', 'areas', 'ark_item_area', 0, 1, 0, NULL),
('context', 'contexts', 'ark_item_context', 0, 1, 0, NULL),
('drawing', 'drawings', 'ark_item_drawing', 0, 1, 0, NULL),
('find', 'finds', 'ark_item_find', 0, 1, 0, NULL),
('group', 'groups', 'ark_item_group', 0, 1, 0, NULL),
('landuse', 'landuses', 'ark_item_landuse', 0, 1, 0, NULL),
('photo', 'photos', 'ark_item_photo', 0, 1, 0, NULL),
('project', 'projects', 'ark_item_project', 0, 1, 0, NULL),
('sample', 'samples', 'ark_item_sample', 0, 1, 0, NULL),
('section', 'sections', 'ark_item_section', 0, 1, 0, NULL),
('subgroup', 'subgroups', 'ark_item_subgroup', 0, 1, 0, NULL),
('timber', 'timbers', 'ark_item_timber', 0, 1, 0, NULL);

--
-- Dumping data for table `ark_model_root`
--

INSERT INTO `ark_model_root` (`model`, `schma`, `class`, `enabled`, `deprecated`) VALUES
('arch', 'arch.project', 'project', 1, 0),
('arch', 'arch.site', 'site', 1, 0),
('arch', 'core.actor', 'actor', 1, 0),
('arch', 'core.event', 'event', 1, 0),
('arch', 'core.file', 'file', 1, 0),
('arch', 'core.message', 'message', 1, 0),
('arch', 'core.page', 'page', 1, 0);

--
-- Dumping data for table `ark_model_schema`
--

INSERT INTO `ark_model_schema` (`schma`, `module`, `subclasses`, `entities`, `attribute`, `vocabulary`, `generator`, `sequence`, `event`, `visibility`, `new`, `view`, `remove`, `edit`, `enabled`, `deprecated`, `keyword`) VALUES
('arch.area', 'area', 1, 0, 'class', 'arch.area.class', 'sequence', 'id', NULL, 'restricted', 'arch.item.create', 'arch.item.read', 'arch.item.delete', 'arch.item.update', 1, 0, NULL),
('arch.context', 'context', 1, 0, 'class', 'arch.context.class', 'sequence', 'id', NULL, 'restricted', 'arch.item.create', 'arch.item.read', 'arch.item.delete', 'arch.item.update', 1, 0, NULL),
('arch.drawing', 'drawing', 0, 0, 'class', 'arch.drawing.class', 'sequence', 'id', NULL, 'restricted', 'arch.item.create', 'arch.item.read', 'arch.item.delete', 'arch.item.update', 1, 0, NULL),
('arch.find', 'find', 1, 0, 'class', 'arch.find.class', 'sequence', 'id', NULL, 'restricted', 'arch.item.create', 'arch.item.read', 'arch.item.delete', 'arch.item.update', 1, 0, NULL),
('arch.group', 'group', 0, 0, 'class', 'arch.group.class', 'sequence', 'id', NULL, 'restricted', 'arch.item.create', 'arch.item.read', 'arch.item.delete', 'arch.item.update', 1, 0, NULL),
('arch.landuse', 'landuse', 0, 0, 'class', 'arch.landuse.class', 'sequence', 'id', NULL, 'restricted', 'arch.item.create', 'arch.item.read', 'arch.item.delete', 'arch.item.update', 1, 0, NULL),
('arch.photo', 'photo', 0, 0, 'class', 'arch.photo.class', 'sequence', 'id', NULL, 'restricted', 'arch.item.create', 'arch.item.read', 'arch.item.delete', 'arch.item.update', 1, 0, NULL),
('arch.project', 'project', 0, 0, 'class', 'arch.project.class', 'sequence', 'id', NULL, 'restricted', 'arch.item.create', 'arch.item.read', 'arch.item.delete', 'arch.item.update', 1, 0, NULL),
('arch.sample', 'sample', 0, 0, 'class', 'arch.sample.class', 'sequence', 'id', NULL, 'restricted', 'arch.item.create', 'arch.item.read', 'arch.item.delete', 'arch.item.update', 1, 0, NULL),
('arch.section', 'section', 0, 0, 'class', 'arch.section.class', 'sequence', 'id', NULL, 'restricted', 'arch.item.create', 'arch.item.read', 'arch.item.delete', 'arch.item.update', 1, 0, NULL),
('arch.site', 'area', 0, 0, 'class', 'arch.site.class', 'sequence', 'id', NULL, 'restricted', 'arch.item.create', 'arch.item.read', 'arch.item.delete', 'arch.item.update', 1, 0, NULL),
('arch.subgroup', 'subgroup', 0, 0, 'class', 'arch.subgroup.class', 'sequence', 'id', NULL, 'restricted', 'arch.item.create', 'arch.item.read', 'arch.item.delete', 'arch.item.update', 1, 0, NULL),
('arch.timber', 'timber', 0, 0, 'class', 'arch.timber.class', 'sequence', 'id', NULL, 'restricted', 'arch.item.create', 'arch.item.read', 'arch.item.delete', 'arch.item.update', 1, 0, NULL);

--
-- Dumping data for table `ark_model_subschema`
--

INSERT INTO `ark_model_subschema` (`model`, `schma`, `class`, `subschema`, `enabled`, `deprecated`) VALUES
('arch', 'arch.area', 'area', 'arch.context', 1, 0),
('arch', 'arch.site', 'site', 'arch.area', 1, 0),
('arch', 'arch.site', 'site', 'arch.context', 1, 0),
('arch', 'arch.site', 'site', 'arch.drawing', 1, 0),
('arch', 'arch.site', 'site', 'arch.find', 1, 0),
('arch', 'arch.site', 'site', 'arch.group', 1, 0),
('arch', 'arch.site', 'site', 'arch.landuse', 1, 0),
('arch', 'arch.site', 'site', 'arch.photo', 1, 0),
('arch', 'arch.site', 'site', 'arch.sample', 1, 0),
('arch', 'arch.site', 'site', 'arch.section', 1, 0),
('arch', 'arch.site', 'site', 'arch.subgroup', 1, 0),
('arch', 'arch.site', 'site', 'arch.timber', 1, 0);

--
-- Dumping data for table `ark_route`
--

INSERT INTO `ark_route` (`route`, `collection`, `can_get`, `can_post`, `page`, `redirect`, `controller`) VALUES
('arch.context.add', 'view', 1, 1, 'arch_context_page_add', 'arch.context.item', 'ARK\\Framework\\Controller\\ItemAddPageController'),
('arch.context.item', 'view', 1, 1, 'arch_context_page_item', NULL, 'ARK\\Framework\\Controller\\ItemPageController'),
('arch.context.list', 'view', 1, 1, 'arch_context_page_list', NULL, 'ARK\\Framework\\Controller\\ItemListPageController');

--
-- Dumping data for table `ark_route_path`
--

INSERT INTO `ark_route_path` (`route`, `language`, `path`) VALUES
('arch.context.add', 'en', '/contexts/add'),
('arch.context.item', 'en', '/contexts/{id}'),
('arch.context.list', 'en', '/contexts');

--
-- Dumping data for table `ark_translation_keyword`
--

INSERT INTO `ark_translation_keyword` (`keyword`, `domain`, `is_plural`, `has_parameters`) VALUES
('arch.area.class', 'arch', 0, 0),
('arch.area.class.site', 'arch', 0, 0),
('arch.area.class.trench', 'arch', 0, 0),
('arch.context.class', 'arch', 0, 0),
('arch.context.class.cut', 'arch', 0, 0),
('arch.context.class.fill', 'arch', 0, 0),
('arch.context.class.masonry', 'arch', 0, 0),
('arch.context.class.skeleton', 'arch', 0, 0),
('arch.context.class.timber', 'arch', 0, 0),
('arch.context.description', 'arch', 0, 0),
('arch.context.id', 'arch', 0, 0),
('arch.context.register', 'arch', 0, 0),
('arch.context.registered', 'arch', 0, 0),
('arch.context.snapshot', 'arch', 0, 0),
('arch.translation.domain', 'arch', 0, 0);

--
-- Dumping data for table `ark_translation_domain`
--

INSERT INTO `ark_translation_domain` (`domain`, `keyword`) VALUES
('arch', 'translation.domain.arch');

--
-- Dumping data for table `ark_view_element`
--

INSERT INTO `ark_view_element` (`element`, `type`) VALUES
('arch_area_field_class', 'field'),
('arch_area_field_id', 'field'),
('arch_area_field_status', 'field'),
('arch_area_field_visibility', 'field'),
('arch_context_field_class', 'field'),
('arch_context_field_description', 'field'),
('arch_context_field_id', 'field'),
('arch_context_field_register', 'field'),
('arch_context_field_registered', 'field'),
('arch_context_field_snapshot', 'field'),
('arch_context_field_status', 'field'),
('arch_context_field_visibility', 'field'),
('arch_find_field_class', 'field'),
('arch_find_field_id', 'field'),
('arch_find_field_register', 'field'),
('arch_find_field_status', 'field'),
('arch_find_field_visibility', 'field'),
('arch_group_field_class', 'field'),
('arch_group_field_id', 'field'),
('arch_group_field_status', 'field'),
('arch_group_field_visibility', 'field'),
('arch_landuse_field_class', 'field'),
('arch_landuse_field_id', 'field'),
('arch_landuse_field_status', 'field'),
('arch_landuse_field_visibility', 'field'),
('arch_photo_field_class', 'field'),
('arch_photo_field_id', 'field'),
('arch_photo_field_status', 'field'),
('arch_photo_field_visibility', 'field'),
('arch_plan_field_class', 'field'),
('arch_plan_field_id', 'field'),
('arch_plan_field_status', 'field'),
('arch_plan_field_visibility', 'field'),
('arch_project_field_class', 'field'),
('arch_project_field_id', 'field'),
('arch_project_field_status', 'field'),
('arch_project_field_visibility', 'field'),
('arch_sample_field_class', 'field'),
('arch_sample_field_id', 'field'),
('arch_sample_field_status', 'field'),
('arch_sample_field_visibility', 'field'),
('arch_section_field_class', 'field'),
('arch_section_field_id', 'field'),
('arch_section_field_status', 'field'),
('arch_section_field_visibility', 'field'),
('arch_subgroup_field_class', 'field'),
('arch_subgroup_field_id', 'field'),
('arch_subgroup_field_status', 'field'),
('arch_subgroup_field_visibility', 'field'),
('arch_timber_field_class', 'field'),
('arch_timber_field_id', 'field'),
('arch_timber_field_status', 'field'),
('arch_timber_field_visibility', 'field'),
('arch_context_form_item', 'form'),
('arch_context_form_register', 'form'),
('arch_find_form_item', 'form'),
('arch_find_form_register', 'form'),
('arch_context_page_add_content', 'grid'),
('arch_context_page_item_content', 'grid'),
('arch_context_page_list_content', 'grid'),
('arch_context_page_add', 'page'),
('arch_context_page_item', 'page'),
('arch_context_page_list', 'page'),
('arch_find_page_add', 'page'),
('arch_find_page_item', 'page'),
('arch_find_page_list', 'page'),
('arch_context_table_list', 'table'),
('arch_find_table', 'table');

--
-- Dumping data for table `ark_view_form`
--

INSERT INTO `ark_view_form` (`element`, `name`, `mode`, `method`, `action`, `template`, `form_type`, `keyword`) VALUES
('arch_context_form_item', 'context', NULL, NULL, NULL, NULL, NULL, NULL),
('arch_context_form_register', 'context', NULL, NULL, NULL, NULL, NULL, NULL),
('arch_find_form_item', 'find', NULL, NULL, NULL, NULL, NULL, NULL),
('arch_find_form_register', 'find', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Dumping data for table `ark_view_group`
--

INSERT INTO `ark_view_group` (`element`, `name`, `mode`, `template`, `form_type`, `keyword`) VALUES
('arch_context_page_add_content', NULL, NULL, NULL, NULL, NULL);

--
-- Dumping data for table `ark_view_page`
--

INSERT INTO `ark_view_page` (`element`, `mode`, `header`, `sidebar`, `content`, `footer`, `visibility`, `view`, `edit`, `template`, `keyword`) VALUES
('arch_context_page_add', 'edit', 'core_page_header', 'core_page_sidebar', 'arch_context_page_add_content', 'core_page_footer', 'restricted', 'arch.item.create', 'arch.item.create', 'pages/map.html.twig', NULL),
('arch_context_page_item', 'edit', 'core_page_header', 'core_page_sidebar', 'arch_context_form_item', 'core_page_footer', 'restricted', 'arch.item.read', 'arch.item.update', 'pages/map.html.twig', NULL),
('arch_context_page_list', 'edit', 'core_page_header', 'core_page_sidebar', 'arch_context_table_list', 'core_page_footer', 'public', 'arch.item.read', 'arch.item.update', 'pages/map.html.twig', NULL);

--
-- Dumping data for table `ark_view_table`
--

INSERT INTO `ark_view_table` (`element`, `name`, `mode`, `caption`, `header`, `footer`, `sortable`, `searchable`, `list`, `detail`, `expand`, `card`, `thumb`, `view`, `image`, `export`, `columns`, `pagination`, `selection`, `classes`, `template`, `keyword`, `url`) VALUES
('arch_context_table_list', 'contexts', NULL, 1, 1, 0, 1, 1, 1, 0, 0, 0, 0, 'list', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
('arch_find_table', 'finds', NULL, 1, 1, 0, 1, 1, 1, 0, 0, 0, 0, 'list', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Dumping data for table `ark_vocabulary_concept`
--

INSERT INTO `ark_vocabulary_concept` (`concept`, `type`, `source`, `closed`, `transitions`, `enabled`, `deprecated`, `keyword`, `description`) VALUES
('arch.area.class', 'list', 'Archaeology Area', 1, 0, 1, 0, 'arch.area.class', 'Archaeology Area Class'),
('arch.context.class', 'list', 'Archaeology Schema', 1, 0, 1, 0, 'arch.context.class', 'Archaeology Context Class'),
('arch.drawing.class', 'list', 'Archaeology Drawing', 1, 0, 1, 0, NULL, 'Archaeology Drawing Class'),
('arch.find.class', 'list', 'Archaeology Model', 1, 0, 1, 0, NULL, 'Archaeology Find Class'),
('arch.group.class', 'list', 'Archaeology Model', 1, 0, 1, 0, NULL, 'Archaeology Group Class'),
('arch.landuse.class', 'list', 'Archaeology Model', 1, 0, 1, 0, NULL, 'Archaeology Landuse Class'),
('arch.photo.class', 'list', 'Archaeology Model', 1, 0, 1, 0, NULL, 'Archaeology Photo Class'),
('arch.project.class', 'list', 'Archaeology Model', 1, 0, 1, 0, NULL, 'Archaeology Project Class'),
('arch.sample.class', 'list', 'Archaeology Model', 1, 0, 1, 0, NULL, 'Archaeology Sample Class'),
('arch.section.class', 'list', 'Archaeology Model', 1, 0, 1, 0, NULL, 'Archaeology Section Class'),
('arch.site.class', 'list', 'Archaeology Area', 1, 0, 1, 0, NULL, 'Archaeology Site Class'),
('arch.subgroup.class', 'list', 'Archaeology Model', 1, 0, 1, 0, NULL, 'Archaeology Subgroup Class'),
('arch.timber.class', 'list', 'Archaeology Model', 1, 0, 1, 0, NULL, 'Archaeology Timber Class');

--
-- Dumping data for table `ark_workflow_action`
--

INSERT INTO `ark_workflow_action` (`schma`, `action`, `event_vocabulary`, `event_term`, `agent`, `actionable`, `default_permission`, `default_agency`, `default_allowance`, `enabled`, `keyword`, `description`) VALUES
('arch.area', 'edit', 'core.event.class', 'edited', NULL, 0, 0, 1, 0, 1, 'core.action.edit', NULL),
('arch.area', 'view', 'core.event.class', 'viewed', NULL, 0, 0, 1, 0, 1, 'core.action.view', NULL),
('arch.context', 'edit', 'core.event.class', 'edited', NULL, 0, 0, 1, 0, 1, 'core.action.edit', NULL),
('arch.context', 'view', 'core.event.class', 'viewed', NULL, 0, 0, 1, 0, 1, 'core.action.view', NULL),
('arch.drawing', 'edit', 'core.event.class', 'edited', NULL, 0, 0, 1, 0, 1, 'core.action.edit', NULL),
('arch.drawing', 'view', 'core.event.class', 'viewed', NULL, 0, 0, 1, 0, 1, 'core.action.view', NULL),
('arch.find', 'edit', 'core.event.class', 'edited', NULL, 0, 0, 1, 0, 1, 'core.action.edit', NULL),
('arch.find', 'view', 'core.event.class', 'viewed', NULL, 0, 0, 1, 0, 1, 'core.action.view', NULL),
('arch.group', 'edit', 'core.event.class', 'edited', NULL, 0, 0, 1, 0, 1, 'core.action.edit', NULL),
('arch.group', 'view', 'core.event.class', 'viewed', NULL, 0, 0, 1, 0, 1, 'core.action.view', NULL),
('arch.landuse', 'edit', 'core.event.class', 'edited', NULL, 0, 0, 1, 0, 1, 'core.action.edit', NULL),
('arch.landuse', 'view', 'core.event.class', 'viewed', NULL, 0, 0, 1, 0, 1, 'core.action.view', NULL),
('arch.photo', 'edit', 'core.event.class', 'edited', NULL, 0, 0, 1, 0, 1, 'core.action.edit', NULL),
('arch.photo', 'view', 'core.event.class', 'viewed', NULL, 0, 0, 1, 0, 1, 'core.action.view', NULL),
('arch.project', 'edit', 'core.event.class', 'edited', NULL, 0, 0, 1, 0, 1, 'core.action.edit', NULL),
('arch.project', 'view', 'core.event.class', 'viewed', NULL, 0, 0, 1, 0, 1, 'core.action.view', NULL),
('arch.sample', 'edit', 'core.event.class', 'edited', NULL, 0, 0, 1, 0, 1, 'core.action.edit', NULL),
('arch.sample', 'view', 'core.event.class', 'viewed', NULL, 0, 0, 1, 0, 1, 'core.action.view', NULL),
('arch.section', 'edit', 'core.event.class', 'edited', NULL, 0, 0, 1, 0, 1, 'core.action.edit', NULL),
('arch.section', 'view', 'core.event.class', 'viewed', NULL, 0, 0, 1, 0, 1, 'core.action.view', NULL),
('arch.subgroup', 'edit', 'core.event.class', 'edited', NULL, 0, 0, 1, 0, 1, 'core.action.edit', NULL),
('arch.subgroup', 'view', 'core.event.class', 'viewed', NULL, 0, 0, 1, 0, 1, 'core.action.view', NULL),
('arch.timber', 'edit', 'core.event.class', 'edited', NULL, 0, 0, 1, 0, 1, 'core.action.edit', NULL),
('arch.timber', 'view', 'core.event.class', 'viewed', NULL, 0, 0, 1, 0, 1, 'core.action.view', NULL);

--
-- Dumping data for table `ark_workflow_allow`
--

INSERT INTO `ark_workflow_allow` (`schma`, `action`, `role`, `operator`) VALUES
('arch.area', 'edit', 'manager', 'is'),
('arch.area', 'view', 'archaeologist', 'is'),
('arch.context', 'edit', 'archaeologist', 'is'),
('arch.context', 'view', 'archaeologist', 'is'),
('arch.drawing', 'edit', 'archaeologist', 'is'),
('arch.drawing', 'view', 'archaeologist', 'is'),
('arch.find', 'edit', 'archaeologist', 'is'),
('arch.find', 'view', 'archaeologist', 'is'),
('arch.group', 'edit', 'supervisor', 'is'),
('arch.group', 'view', 'archaeologist', 'is'),
('arch.landuse', 'edit', 'supervisor', 'is'),
('arch.landuse', 'view', 'archaeologist', 'is'),
('arch.photo', 'edit', 'archaeologist', 'is'),
('arch.photo', 'view', 'archaeologist', 'is'),
('arch.project', 'edit', 'manager', 'is'),
('arch.project', 'view', 'archaeologist', 'is'),
('arch.sample', 'edit', 'archaeologist', 'is'),
('arch.sample', 'view', 'archaeologist', 'is'),
('arch.section', 'edit', 'archaeologist', 'is'),
('arch.section', 'view', 'archaeologist', 'is'),
('arch.subgroup', 'edit', 'supervisor', 'is'),
('arch.subgroup', 'view', 'archaeologist', 'is'),
('arch.timber', 'edit', 'archaeologist', 'is'),
('arch.timber', 'view', 'archaeologist', 'is');

--
-- Dumping data for table `ark_workflow_grant`
--

INSERT INTO `ark_workflow_grant` (`role`, `permission`) VALUES
('archaeologist', 'arch.item.create'),
('archaeologist', 'arch.item.read'),
('archaeologist', 'arch.item.update'),
('archaeologist', 'core.actor.read'),
('archaeologist', 'core.actor.update'),
('archaeologist', 'core.event.create'),
('archaeologist', 'core.event.read'),
('archaeologist', 'core.file.create'),
('archaeologist', 'core.file.read'),
('archaeologist', 'core.file.update'),
('archaeologist', 'core.message.create'),
('archaeologist', 'core.message.read'),
('archaeologist', 'core.message.update');

--
-- Dumping data for table `ark_workflow_permission`
--

INSERT INTO `ark_workflow_permission` (`permission`, `enabled`, `keyword`, `description`) VALUES
('arch.item.create', 1, NULL, NULL),
('arch.item.delete', 1, NULL, NULL),
('arch.item.read', 1, NULL, NULL),
('arch.item.register', 1, NULL, NULL),
('arch.item.update', 1, NULL, NULL);

--
-- Dumping data for table `ark_workflow_role`
--

INSERT INTO `ark_workflow_role` (`role`, `agent_for`, `level`, `enabled`, `keyword`) VALUES
('archaeologist', NULL, 'ROLE_USER', 1, NULL),
('client', NULL, 'ROLE_USER', 1, NULL),
('manager', NULL, 'ROLE_USER', 1, NULL),
('specialist', NULL, 'ROLE_USER', 1, NULL),
('supervisor', NULL, 'ROLE_USER', 1, NULL);

SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
