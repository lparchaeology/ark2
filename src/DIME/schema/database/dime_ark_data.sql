-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 24, 2017 at 11:11 PM
-- Server version: 5.6.34
-- PHP Version: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dime_ark_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `ark_dataclass_member`
--

CREATE TABLE `ark_dataclass_member` (
  `object_fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_fid` int(11) NOT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_blob`
--

CREATE TABLE `ark_fragment_blob` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longblob NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_boolean`
--

CREATE TABLE `ark_fragment_boolean` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` tinyint(1) NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_date`
--

CREATE TABLE `ark_fragment_date` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` date NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_date`
--

INSERT INTO `ark_fragment_date` (`fid`, `module`, `item`, `attribute`, `parameter`, `value`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(12, 'find', '15', 'finddate', NULL, '2017-01-24', NULL, 0, '2017-01-24 11:45:37', 0, '2017-01-24 11:45:37', ''),
(13, 'find', '16', 'finddate', NULL, '2017-01-24', NULL, 0, '2017-01-24 12:01:29', 0, '2017-01-24 12:01:29', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_datetime`
--

CREATE TABLE `ark_fragment_datetime` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` datetime NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_decimal`
--

CREATE TABLE `ark_fragment_decimal` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_decimal`
--

INSERT INTO `ark_fragment_decimal` (`fid`, `module`, `item`, `attribute`, `parameter`, `value`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(23, 'find', '15', 'weight', 'g', '1', NULL, 0, '2017-01-24 11:45:37', 0, '2017-01-24 11:45:37', ''),
(24, 'find', '15', 'length', 'm', '1', NULL, 0, '2017-01-24 11:45:37', 0, '2017-01-24 11:45:37', ''),
(25, 'find', '16', 'weight', 'g', '2', NULL, 0, '2017-01-24 12:01:29', 0, '2017-01-24 12:01:29', ''),
(26, 'find', '16', 'length', 'm', '2', NULL, 0, '2017-01-24 12:01:29', 0, '2017-01-24 12:01:29', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_float`
--

CREATE TABLE `ark_fragment_float` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` double NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_integer`
--

CREATE TABLE `ark_fragment_integer` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` bigint(20) NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_item`
--

CREATE TABLE `ark_fragment_item` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_object`
--

CREATE TABLE `ark_fragment_object` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_string`
--

CREATE TABLE `ark_fragment_string` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_string`
--

INSERT INTO `ark_fragment_string` (`fid`, `module`, `item`, `attribute`, `parameter`, `value`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(144, 'find', '15', 'finder_id', NULL, '1', NULL, 0, '2017-01-24 11:45:37', 0, '2017-01-24 11:45:37', ''),
(145, 'find', '15', 'type', 'dime.find.type', 'accessory', NULL, 0, '2017-01-24 11:45:37', 0, '2017-01-24 11:45:37', ''),
(146, 'find', '15', 'subtype', NULL, 'sub', NULL, 0, '2017-01-24 11:45:37', 0, '2017-01-24 11:45:37', ''),
(147, 'find', '15', 'period_start', 'dime.period', 'AÆAX', NULL, 0, '2017-01-24 11:45:37', 0, '2017-01-24 11:45:37', ''),
(148, 'find', '15', 'period_end', 'dime.period', 'AÆBX', NULL, 0, '2017-01-24 11:45:37', 0, '2017-01-24 11:45:37', ''),
(149, 'find', '15', 'material', 'dime.material', 'ag', NULL, 0, '2017-01-24 11:45:37', 0, '2017-01-24 11:45:37', ''),
(152, 'find', '16', 'finder_id', NULL, '2', NULL, 0, '2017-01-24 12:01:29', 0, '2017-01-24 12:01:29', ''),
(153, 'find', '16', 'type', 'dime.find.type', 'fibula', NULL, 0, '2017-01-24 12:01:29', 0, '2017-01-24 12:01:29', ''),
(154, 'find', '16', 'subtype', NULL, '2', NULL, 0, '2017-01-24 12:01:29', 0, '2017-01-24 12:01:29', ''),
(155, 'find', '16', 'material', 'dime.material', 'au', NULL, 0, '2017-01-24 12:01:29', 0, '2017-01-24 12:01:29', ''),
(156, 'find', '16', 'id', NULL, '16', NULL, 0, '2017-01-24 12:01:29', 0, '2017-01-24 12:01:29', ''),
(157, 'find', '15', 'id', NULL, '15', NULL, 0, '2017-01-24 12:01:29', 0, '2017-01-24 12:01:29', ''),
(164, 'find', '15', 'secondary', 'dime.material', 'cu', NULL, 0, '2017-01-24 22:10:22', 0, '2017-01-24 22:10:22', ''),
(165, 'find', '15', 'secondary', 'dime.material', 'niello', NULL, 0, '2017-01-24 22:10:22', 0, '2017-01-24 22:10:22', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_text`
--

CREATE TABLE `ark_fragment_text` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_text`
--

INSERT INTO `ark_fragment_text` (`fid`, `module`, `item`, `attribute`, `parameter`, `value`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(11, 'page', 'about', 'content', 'da', '<h2>Om DIME</h2>\\n\\n<p>DIME står for ”Digitale Metaldetektorfund” og er en brugerdrevet platform til registrering af metaldetektorfund til brug i formidling, forskning og forvaltning.</p>\\n\\n<p>Ideen bag DIME er, at den skal:\\n<ul><li>øge inddragelse af metaldetektorbrugerne i det museale arbejde</li>\\n<li>øge og skærpe samarbejdet mellem metaldetektorbrugere og museer</li>\\n<li>lette arbejdsbyrden vedr. fundregistrering og danefæbehandling på museerne</li>\\n<li>muliggøre en hurtig behandling af Danefæ</li>\\n<li>muliggøre en ensartet registreringspraksis landet over</li>\\n<li>optimere tilgængeligheden af information om metaldetektorfundene til forskningsbrug</li>\\n<li>fungere som indgang for indberetning af fund til centrale, museale databaser (SARA mfl.)</li></ul>\\n</p>\\n\\n<h3>Baggrunden for DIME</h3>\\n\\n<p>Hvert år finder frivillige metaldetektorbrugere på danske marker i 1000vis af fund af stor kulturhistorisk betydning. De bidrager løbende til fremkomsten af nogle af de mest opsigtsvækkende fund i dansk arkæologi, og metaldetektorfundene har i mange henseender revolutioneret vor forståelse af de forhistoriske og historiske samfund fra bronzealder til nyere tid. Dansk metaldetektorarkæologi har på den baggrund udviklet sig til en unik og internationalt anerkendt succeshistorie, som forener de bedste sider af den danske model med en bred folkelig involvering i det arkæologiske arbejde og en decentral museumsstruktur. Men den kolossale tilvækst af indkomne fund har i stigende grad tydeliggjort behovet for en samlet registrering af metaldetektorfundene, idet kun en brøkdel af de mange fund er tilgængelige for offentligheden, museerne og for forskningen. DIME er udviklet med henblik på at muliggøre optimal udnyttelse af metaldetektorfundenes store formidlings- og forskningsmæssige potentiale.</p>\\n\\n<h3>Udviklingen af DIME</h3>\\n\\n<p>DIME-databasen blev udviklet i 2016-2017 af en gruppe museumsfolk og universitetsarkæologer i tæt samarbejde med detektorbrugere og et bredt panel fagfolk fra museer landet over. DIME er således udviklet af brugere for brugere, og under udformning af databasen har udviklerne bl.a. kunne støtte sig til:\\n<ul><li>Interview af 27 museumsmedarbejder (fra 27 forskellige museer) om praksis og erfaringer med fundregistrering og krav til en evt. databaseløsning</li>\\n<li>Online spørgeskema blandt detektorfolk om praksis og ønsker til fundregistrering (168 besvarelser)</li>\\n<li>Fokusgruppeinterview med udvalgte detektorfolk</li></ul>\\n</p>\\n\\n<p>DIME er udviklet af følgende institutioner:\\n<ul><li>Aarhus Universitet</li>\\n<li>Moesgaard Museum</li>\\n<li>Nordjyllands Historiske Museum</li>\\n<li>Odense Bys Museer</li></ul>\\n</p>\\n\\n<p>Udvikling af DIME blev muliggjort med økonomisk støtte fra KROGAGERFONDEN</p>\\n', NULL, 0, '2017-01-24 13:14:58', 0, '0000-00-00 00:00:00', ''),
(23, 'page', 'treasure', 'content', 'da', '<h2>Danefæ</h2>\\n\\n<p>Danefæ er genstande fra fortiden, der kommer til veje som jordfund i Danmark, og som er forarbejdet af ædelt metal eller i øvrigt er af kulturhistorisk værdi, herunder mønter. Den, der finder danefæ eller får danefæ i sin besiddelse, skal aflevere det, idet danefæ tilhører staten.\\n\\n<p>Loven om danefæ kan spores tilbage til middelalderen. Nationalmuseet administrerer denne lov, der sikrer, at vigtige fund fra Danmarks fortid bliver bevaret for kommende generationer.\\n\\n<h3>Indlevering af Danefæ</h3>\\n\\n<p>Oldsager og andre betydningsfulde genstande fra fortiden, som skønnes at være danefæ, skal indleveres til staten. Det foregår i praksis ved, at finderen indleverer fundet til det lokale museum, der har ansvaret for arkæologiske fund i området - <a href=\"http://slks.dk/fortidsminder-diger/arkaeologi-paa-land/museernes-arkaeologiske-arbejde/ansvarsomraader-og-kontakt/\">se fordelingen af ansvarsområder her</a>.\\n\\n<p>Den endelige vurdering af fundets danefæ-status foretages på Nationalmuseet. Den faglige bestemmelse af fundene foretages af medarbejdere fra tre af Nationalmuseets enheder: Den Kgl. Mønt- og Medaillesamling, Danmarks Middelalder og Renæssance og Danmarks Oldtid.\\n\\n<p>Nationalmuseet har fra 2013 indført en transportordning for danefæ og ikke-danefæ. Ordningen indebærer, at Nationalmuseet en gang årligt transporterer danefæ til uddeponering samt ikke-danefæ retur til lokalmuseerne. Transporten kan også medtage danefæ til vurdering fra lokalmuseet til Nationalmuseet. Det er dog stadig muligt for lokalmuseerne, at indlevere genstande til danefævurdering direkte til Nationalmuseet.\\n\\n<h3>Jeg har fundet danefæ - hvad gør jeg?</h3>\\n\\n<p>Du skal i første omgang henvende dig på dit lokale museum. Det er dit lokale museum, der skal tage imod dit fund og kontakte Nationalmuseet. Her kan du printe <a href=\"http://natmus.dk/fileadmin/user_upload/natmus/Danefae/Kvitteringsseddel.pdf\">et kvitteringsskema, du afleverer sammen med dit fund</a>(PDF).\\n\\n<p>Hvis du alligevel ønsker at indlevere til Nationalmuseet, tager vi kontakten til det lokale museum. Derved kan danefævurderingen trække ud, da vi skal afvente, at det lokale museum indberetter fundet. Nationalmuseet anmoder herefter det lokale museum om at indsende en danefæanmeldelse ud fra de oplysninger, som du har indleveret sammen med genstanden. Den indleverede genstand bliver på Nationalmuseet og afventer fundanmeldelse fra det lokale museum. Herefter fortsætter danefæsagen efter sædvanlig procedure.\\n\\n<h3>Sådan udviser man omhu ved fund af danefæ</h3>\\n\\n<p><strong>Forskellige udtryk for omhu i forbindelse med danefæfund:</strong>\\n\\n<p><strong>Ved tilfældige fund</strong>, dvs. ikke-detektorfund kan finderen udvises særlig omhu ved:\\n\\n<ol>\\n<li>Forsigtig håndtering.\\n<li>Forsvarlig emballering.\\n<li>Hurtig kontakt til antikvariske myndigheder.\\n<li>Opmærksomhed på forekomsten af relevante kulturspor: skår, lerklining, trækul, sten, knoglestumper, sortjord, etc.\\n</ol>\\n\\n<p><strong>Ved detektorfund</strong> kan finderen i øvrigt udvises særlig omhu ved:\\n<ol>\\n<li>Nøjagtig ”on-site” lokalisering af fundsted – ved indmåling af GPS-koordinater.</li>\\n<li>Øjeblikkelig ”on-site” fotodokumentation af fundenes tilstand og GPS-målingernes troværdighed</li>\\n<li>Tilsvarende omhyggelig indsamling af ”ikke danefæ”- fund, til belysning af konteksten for de regulære danefæ-stykker, dvs. til sikring af danefæets videnskabelige værdi. Ligeledes at finder har indgået aftale med det lokale museum om at overdrage ikke-danefæ til lokalmuseet. Kvitteringsblanket skal være underskrevet.</li>\\n<li>Elektronisk fundrapportering til lokalmuseet (med foreløbige betegnelser, eventuelle løbenumre, koordinater, fotos).  </li>\\n<li>I tvivlstilfælde og ved mulighed for dybereliggende grav- eller skattefund kontaktes lokalmuseet  straks. Ingen gravning under pløjedybde!</li>\\n<li>Der gives løbende orientering om eventuelle fund til lodsejer og lokalmuseum.</li>\\n<li>Fund udsættes ikke for afrensning, imprægnering eller afstøbning</li>\\n<li>Fund udsættes ikke for skader eller informations-tab som følge af uhensigtsmæssig (eller langvarig) opbevaring.</li>\\n</ol>\\n\\n<p><em>Ved grundig registrering af fundene i DIME opfyldes en række af ovenstående punkter udpeget af Nationalmuseet som særligt væsentlige for omhyggelig behandling af potentielt danefæ.</em>\\n\\n<h3>Hvad kan være danefæ?</h3>\\n\\n<p>Som udgangspunkt er fragmenter lige så vigtige som hele genstande i detektorsammenhæng, idet de(t) resterende fragment(er) oftest dukker op med tiden. Det afgørende for om noget bør erklæres for danefæ er altså typen af genstand - ikke genstandens tilstand. Hittegods er aldrig danefæ.\\n\\n<h4>Guld</h4>\\n\\n<p>Alle genstande af guld er danefæ.\\n\\n<h4>Sølv</h4>\\n\\n<p>+ Genstande af sølv fra før 1700 samt sølvklip og -fragmenter\\n<p>- Sølv fra tiden efter 1700 med mindre det er af ekstraordinær karakter\\n\\n<h4>Bronze</h4>\\n\\n<p>+ Bronzegenstande fra oldtid og vikingetid er danefæ\\n<p>+ Genstande af bronze med særlig ornamentik eller udsmykning - f.eks. inskription eller emalje fra middelalder\\n<p>+ Hele eller tilnærmelsesvis hele malmgryder\\n<p>+ Vægtlodder\\n<p>+ Seglstamper fra før 1700\\n<p>- Simple genstande af bronze fra middelalder og renæssance\\n<p>- Fragmenter af malmgryder\\n<p>- Taphaner\\n<p>- Nøgler eller hængelåse uden kunstnerisk udsmykning.\\n\\n<h4>Bly</h4>\\n\\n<p>+ Vægtlodder\\n<p>+ Støbemodeller\\n<p>+ Tenvægte med særlig udsmykning fra middelalder\\n<p>+ Klædeplomber med ornamentik og/eller skrift\\n<p>+ Genstande med runer eller anden skrift\\n<p>- Musketkugler\\n<p>- Udaterbare smelteklumper og simple blygenstande fra tiden efter 1536\\n\\n<h4>Jern</h4>\\n\\n<p>+ Ekstraordinære jerngenstande og genstande med f.eks. tauschering, indlægning, ornamentik; eksempelvis sværd fra oldtiden og middelalderen\\n<p>- Andre genstande af jern fra oldtid og middelalder, våben som værktøj o.a.\\n\\n<h4>Mønter</h4>\\n\\n<p>+ Mønter fra oldtid, vikingetid og middelalder (fra 1536 og før)\\n<p>+ Mønter i skattefund - flere mønter nedlagt sammen\\n<p>+ Guldmønter og større sølvmønter, f.eks. dalermønter fra tiden efter 1536.\\n<p>- Småmønter af sølv og kobber fra tiden efter 1536\\n\\n<h4>Figurer</h4>\\n\\n<p>+ Figurer og plastiske fremstillinger i sten, metal, ben, rav og træ\\n<p>+ Figurer i keramik og tegl fra oldtid og middelalder\\n\\n<h4>Runer og anden indskrift</h4>\\n\\n<p>+ Sten og andre genstande med runer og anden indskrift\\n\\n<p><p>Desuden omfatter listen af muligt Danefæ også en række ikke-metalliske genstande. For nærmere herom <a href=\"http://natmus.dk/salg-og-ydelser/museumsfaglige-ydelser/danefae/hvad-kan-vaere-danefae/\">se Nationalmuseets hjemmeside</a>.\\n\\n<p>(Kilde: Nationalmuseet)\\n', NULL, 0, '2017-01-24 09:52:59', 0, '0000-00-00 00:00:00', ''),
(24, 'page', 'background', 'content', 'da', '<h2>Metaldetektorbrug i Danmark</h2>\\r\\n\\r\\n<p>Siden 1970erne har metaldetektering vundet stor popularitet blandt private brugere i Danmark. Hvert år bruger entusiastiske detektorbrugere i tusindvis af timer på at afsøge marker over hele landet og bidrager alle på denne vis til at redde vigtige arkæologiske fund fra gradvis nedbrydning som følge af dyrkning, vind og vejr.\\r\\n\\r\\n<p>Tabt, ofret til guderne eller gemt til senere brug. De mange genstande, som bliver fundet med metaldetektor, er endt i jorden af vidt forskellige årsager igennem tiderne. De fleste er dog små enkeltliggende genstande, f.eks. mønter og smykker, som øjensynligt er blevet tabt under brug. Mange fund i et område indikerer derfor, at her har været høj aktivitet. Men mængden af fund afspejler i høj grad også, hvor udbredt brugen af metaller har været. Der er således betydeligt længere mellem fundene fra bronzealderen og de tidligste dele af jernalderen, hvor metaller udgjorde kostbare sjældenheder, end mellem fundene fra yngre jernalder og ikke mindst fra middelalderen og fremefter. På sammen vis er genstande af jern, bronze, bly og aluminium almindelige mens fund af sølv og i særdeleshed fund af guld naturligvis er anderledes sjældne.\\r\\n\\r\\n<p>Metaldetektorens effektive søgedybde afhænger af metalgenstandens karakter og markens overflade og udgør oftest kun nogle kun få cm, hvorfor dyrkede marker, hvor ploven jævnligt vender de dybere dele af muldlaget op til overfladen, opbyder de mest optimale ”jagtmarker”. Højsæsonen for metaldetektering er derfor ikke overraskende forår og efterår, hvor markerne står uden afgrøder.\\r\\n\\r\\n<h3>Regler</h3>\\r\\n\\r\\n<p>I Danmark er det lovligt at gå med metaldetektor i de fleste områder. Der er dog nogle enkle regler, som skal overholdes, og Kulturstyrelsen har udarbejdet følgende vejledning til, hvordan man som detektorbruger skal og bør forholde sig.\\r\\n\\r\\n<p>Du skal:\\r\\n<ul>\\r\\n<li>Du  skal sørge for at få tilladelse til at gå på det areal du ønsker, hos ejeren af jorden. Er ejeren offentlig, skal du henvende dig til den relevante myndighed, f.eks. en kommunes tekniske forvaltning. <a href=\"http://svana.dk/natur/friluftsliv/hvad-maa-jeg-i-naturen/\">For statens arealer, der forvaltes af Naturstyrelsen, gælder der særlige regler</a>.</li>\\r\\n<li>Du skal aflevere de fundne genstande til det lokale museum (eller Nationalmuseet), såfremt du mener at der kan være tale om danefæ.</li>\\r\\n</ul>\\r\\n\\r\\n<p>Du må ikke:\\r\\n<ul>\\r\\n<li>Du må ikke gå med detektor på fredede fortidsminder, eller nærmere end to meter fra fredningsgrænsen. Se om et fortidsminde er fredet på Kulturstyrelsens database <a href=\"http://www.kulturarv.dk/fundogfortidsminder/\">Fund og Fortidsminder</a></li>\\r\\n<li>Du må ikke foretage en udgravning af et fundområde, herunder grave dybere end pløjelaget.</li>\\r\\n</ul>\\r\\n\\r\\n<p>Du må gerne:\\r\\n<ul>\\r\\n<li>Du må gerne gå med detektor på <a href=\"http://www.kulturstyrelsen.dk/index.php?id=13240\">kulturarvsarealer</a>, dog ikke på fredede fortidsminder indenfor arealerne, se <a href=\"http://www.kulturarv.dk/fundogfortidsminder/\">Fund og Fortidsminder</a>, og du skal stadig spørge ejeren om lov.</li>\\r\\n</ul>\\r\\n\\r\\n<p>Om selve genstandene (danefæ):\\r\\n<ul>\\r\\n<li>En række af de genstande du kan finde med en metaldetektor kan være danefæ (se menupunktet ”danefæ”). Danefæ tilhører staten, og er du det mindste i tvivl, om det du har fundet evt. kan være danefæ, skal du kontakte det lokale museum eller Nationalmuseet, der kan vejlede dig om det videre forløb.</li>\\r\\n<li>Du må ikke sælge genstande/danefæ.</li>\\r\\n<li>Du må ikke videregive genstande/danefæ.</li>\\r\\n<li>Du bør behandle genstandene med omhu og forsigtighed, de er sårbare.</li>\\r\\n<li>Du bør ikke rengøre, børste eller vaske genstande da informationer kan gå tabt.</li>\\r\\n<li>Du bør opbevare genstande i en plastpose og æske med låg.</li>\\r\\n<li>Du bør anvende en GPS til at måle dine fund ind med – også dem du er i tvivl om er noget.</li>\\r\\n<li>Du bør notere findernavn, sted, dato og GPS-koordinater sammen med fundet. Hvis du skriver på en seddel der lægges i posen, så brug en blyant – aldrig kuglepen eller filtpen da skriftes let flyder ud hvis papiret bliver fugtigt.</li>\\r\\n<li>Du bør markere fundområdet på et kort.</li>\\r\\n</ul>\\r\\n\\r\\n<p>Om fundstedet:\\r\\n<li>Du må ikke påbegynde en udgravning af fundstedet. Grav aldrig dybere end pløjelagets dybde.</li>\\r\\n\\r\\n<p>Det er en god idé:\\r\\n<ul>\\r\\n<li>At have god kontakt med lokalmuseet.</li>\\r\\n<li>At have god kontakt med lodsejere.</li>\\r\\n<li>At orientere sig i <a href=\"http://www.kulturarv.dk/fundogfortidsminder/\">Fund & Fortidsminder-databasen</a>.</li>\\r\\n<li>At være medlem af den lokale detektorklub eller amatørarkæologiske forening.</li>\\r\\n<li>At være to eller flere, der går sammen.</li>\\r\\n<li>At have indbyrdes klare aftaler med hinanden og med lodsejer.</li>\\r\\n<li>At være systematisk i sin søgen.</li>\\r\\n<li>At føre dagbog over sin søgen.</li>\\r\\n<li>At diskutere fundne genstande og afsøgningsmetoder i detektorklubben.</li>\\r\\n</ul>\\r\\n\\r\\n<h3>Metaldetektorfund og arkæologiske udgravninger</h3>\\r\\n\\r\\n<p>Grundejere, der skal give lov til, at der må anvendes metaldetektor på ens ejendom – typisk landmænd – er indimellem usikre omkring, hvorvidt fund gjort med metaldetektor kan medføre udgravninger, som skal betales af ejeren af jorden. Fremkomsten af detektorfund vil i sig selv ikke medføre, at en jordejer påføres udgifter til en evt. efterfølgende arkæologisk udgravning.\\r\\n\\r\\n<p>De fleste detektorfund indgår i museernes samlinger - enten som danefæ på Nationalmuseet eller på det lokale museum som almindelige genstande, der indlemmes i museets samling. Enkelte fund, typisk fra nyere tid, kan beholdes af detektorføreren selv.\\r\\n\\r\\n<p>I de sjældne tilfælde, hvor der gøres et skattefund, f.eks. mønter eller værdifuldt metal, er museerne ofte interesserede i at gennemføre en begrænset undersøgelse af fundstedet. Formålet vil være at sikre de dele af skatten, der muligvis endnu er bevaret under pløjelaget. Herved kan man sikre en række væsentlige oplysninger om deponeringsmåden (i et lerkar, en læderpung eller lignende) og ofte også årsagen til deponeringen (til gudernes gunst eller i ufredstider). Samtidig sikrer man, at alle dele af skatten kommer til syne – og dermed er den videnskabelige værdi af fundet væsentligt større.\\r\\n\\r\\n<p>Når en skat i første omgang findes, skyldes det, at nogle af genstandene allerede ligger oppe i pløjelaget. De kan være ført derop af markredskaber for både 10, 50 eller 100 år siden. Altså som følge af ”jordarbejde i forbindelse med erosion eller jordarbejde udført som led i dyrkning af almindelige landbrugsafgrøder eller som led i almindelig skovdrift,” som det hedder i lovteksten (<a href=\"https://www.retsinformation.dk/forms/r0710.aspx?id=12017\">Museumslovens § 27, stk. 5. pind 1</a>). Arkæologiske undersøgelser af denne type skal ikke betales af jordejeren, men bekostes typisk af midler fra en pulje, som Slots- og Kulturstyrelsen råder over, efter ansøgning fra det lokale museum. Afhængig af undersøgelsens omfang og tidspunkt på året kan jordejeren kompenseres for eventuelle tab efter gældende regler for afgrødeerstatning.\\r\\n\\r\\n<h3>Fra landmand til bygherre</h3>\\r\\n\\r\\n<p>Der kan dog opstå situationer, hvor detektorfund på længere sigt kan være en medvirkende årsag til, at der skal gennemføres en arkæologisk undersøgelse for landmandens regning – nemlig i det tilfælde, hvor han går fra at dyrke marken til at være bygherre. Et eksempel:\\r\\n\\r\\n<p>Hvis man forestiller sig, at der bliver gået med metaldetektor tæt ind til en eksisterende gård, og der på hele den vestlige side fremkommer spredte metalfund, f.eks. fra en bebyggelse fra vikingetid og ældre middelalder, vil det i første omgang ikke medføre en udgravning. Metaldetektorfundene er naturligvis med til at forøge vores viden om placeringen af landsbyer, bopladser og gravpladser rundt omkring i landskabet. På den måde er detektorfundene med til at give et mere detaljeret indblik i den forhistoriske udnyttelse af landskabet, end hvis vi ikke havde disse fund. Det svarer til fund af potteskår eller flintredskaber som f.eks. økser eller dolke.\\r\\n\\r\\n<p>Hvis landmanden på et senere tidspunkt ønsker at udvide sin gård, f.eks. med en ny løsdriftsstald med tilhørende gylletank og plansilo, vil metaldetektorfundene - på lige fod med alle andre oplysninger, som museet kender til (f.eks. overpløjede gravhøje, løsfundne stenoldsager, spor set fra luften eller som fremgår af såkaldte LiDAR-scanninger) - danne baggrund for den rådgivning, som museet vil tilbyde landmanden i forbindelse med hans byggeprojekt.\\r\\n\\r\\n<p>Landmanden kan i den forbindelse vælge at få gennemført en forundersøgelse af arealet (<a href=\"http://slks.dk/fortidsminder-diger/arkaeologi-paa-land/museernes-arkaeologiske-arbejde/vejledning-om-arkaeologiske-undersoegelser/\">se mere i Vejledning om arkæologiske undersøgelser</a>), og hvis det herefter viser sig, at der på det areal, hvor han ønsker at udvide gården, fremkommer væsentlige fortidsminder, er det museumslovens bestemmelse, at han som bygherre skal betale for den nødvendige arkæologiske undersøgelse før byggestart. En bygherre - i dette eksempel en landmand - kan i den forbindelse godt have den opfattelse, at det er metaldetektor-fundenes skyld, at han kommer til at betale for en arkæologisk undersøgelse. Det er dog ikke korrekt, for uanset om der er gjort metalfund eller ej, ville en arkæologisk forundersøgelse afsløre, at der er væsentlige fortidsminder bevaret under muldjorden i form af eksempelvis stolpehuller efter huse, brønde, hegnsspor og affaldsgruber. Museumsloven bestemmer herefter, at den nødvendige arkæologiske undersøgelse skal betales af bygherre, med mindre det er muligt at bevare fortidsminderne på stedet ved at ændre eller flytte anlægsarbejdet.  (Kilde: Kulturstyrelsen - http://slks.dk/fortidsminder-diger/metaldetektor-og-danefae/)\\r\\n', NULL, 0, '2017-01-24 09:52:59', 0, '0000-00-00 00:00:00', ''),
(34, 'page', 'research', 'content', 'da', '<h2>Vidensdeling via DIME</h2>\\r\\n\\r\\n<p>Gennem vidensdeling bliver vi alle klogere. DIME hylder og søger aktivt at understøtte dette princip, hvorfor vi ikke kun opfordrer detektorbrugerne til at levere deres unikke viden i form af fundindberetninger, men også tilskynder, at forskere her på hjemmesiden offentliggør nye forskningsresultater vedrørende metaldetektorfundene. For at stimulere denne ”delingskultur” bliver alle med forskeradgang til databasen afkrævet et kort resumé af deres arbejde, når de publicerer forskning med afsæt i DIME. Disse resuméer kan i lighed med anden relevant forskning og henvisninger til andre forskningsarbejder findes ved at følgende de forskellige nedenstående links.\\r\\n', NULL, 0, '2017-01-24 09:52:59', 0, '0000-00-00 00:00:00', ''),
(35, 'find', '15', 'title', 'en', 'Find 1', NULL, 0, '2017-01-24 11:45:37', 0, '2017-01-24 11:45:37', ''),
(36, 'find', '15', 'name', 'en', 'Find1', NULL, 0, '2017-01-24 11:45:37', 0, '2017-01-24 11:45:37', ''),
(37, 'find', '15', 'description', 'en', 'Find number 1!', NULL, 0, '2017-01-24 11:45:37', 0, '2017-01-24 11:45:37', ''),
(38, 'find', '16', 'title', 'en', '2', NULL, 0, '2017-01-24 12:01:29', 0, '2017-01-24 12:01:29', ''),
(39, 'find', '16', 'name', 'en', '2', NULL, 0, '2017-01-24 12:01:29', 0, '2017-01-24 12:01:29', ''),
(40, 'find', '16', 'description', 'en', '222', NULL, 0, '2017-01-24 12:01:29', 0, '2017-01-24 12:01:29', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_time`
--

CREATE TABLE `ark_fragment_time` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` time NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_wkt`
--

CREATE TABLE `ark_fragment_wkt` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext CHARACTER SET utf8mb4mb4 COLLATE utf8mb4mb4_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_fragment_wkt`
--

INSERT INTO `ark_fragment_wkt` (`fid`, `module`, `item`, `attribute`, `parameter`, `value`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(1, 'find', '15', 'findpoint', '4326', 'POINT (56.162939 10.203921)', NULL, 0, '2017-01-24 22:10:22', 0, '2017-01-24 21:28:32', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_actor`
--

CREATE TABLE `ark_item_actor` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_item_actor`
--

INSERT INTO `ark_item_actor` (`id`, `schma`, `type`, `parent_module`, `parent_id`, `idx`, `label`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
('1', 'core.actor', 'person', NULL, NULL, '1', '1', 0, '2017-01-20 14:01:52', 0, '0000-00-00 00:00:00', ''),
('2', 'core.actor', 'person', NULL, NULL, '2', '2', 0, '2017-01-20 14:02:05', 0, '0000-00-00 00:00:00', ''),
('3', 'core.actor', 'person', NULL, NULL, '3', '3', 0, '2017-01-20 14:02:09', 0, '0000-00-00 00:00:00', ''),
('4', 'core.actor', 'person', NULL, NULL, '4', '4', 0, '2017-01-20 14:02:11', 0, '0000-00-00 00:00:00', ''),
('5', 'core.actor', 'institution', NULL, NULL, '5', '5', 0, '2017-01-20 14:02:14', 0, '0000-00-00 00:00:00', ''),
('6', 'core.actor', 'institution', NULL, NULL, '6', '6', 0, '2017-01-20 14:01:57', 0, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_campaign`
--

CREATE TABLE `ark_item_campaign` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_file`
--

CREATE TABLE `ark_item_file` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_find`
--

CREATE TABLE `ark_item_find` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_item_find`
--

INSERT INTO `ark_item_find` (`id`, `schma`, `type`, `parent_module`, `parent_id`, `idx`, `label`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
('15', 'dime.find', 'accessory', NULL, NULL, '15', '15', 0, '2017-01-24 22:10:22', 0, '2017-01-24 22:10:22', ''),
('16', 'dime.find', 'fibula', NULL, NULL, '16', '16', 0, '2017-01-24 12:01:29', 0, '2017-01-24 12:01:29', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_image`
--

CREATE TABLE `ark_item_image` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_location`
--

CREATE TABLE `ark_item_location` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_item_location`
--

INSERT INTO `ark_item_location` (`id`, `schma`, `type`, `parent_module`, `parent_id`, `idx`, `label`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
('1', 'dime.location', NULL, NULL, NULL, '1', '1', 0, '2017-01-11 11:36:01', 0, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_page`
--

CREATE TABLE `ark_item_page` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_item_page`
--

INSERT INTO `ark_item_page` (`id`, `schma`, `type`, `parent_module`, `parent_id`, `idx`, `label`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
('about', 'core.page', '', NULL, NULL, 'about', 'about', 0, '2017-01-24 01:39:34', 0, '0000-00-00 00:00:00', ''),
('background', 'core.page', '', NULL, NULL, 'background', 'background', 0, '2017-01-24 09:06:35', 0, '0000-00-00 00:00:00', ''),
('detector', 'core.page', '', NULL, NULL, 'detector', 'detector', 0, '2017-01-24 01:39:44', 0, '0000-00-00 00:00:00', ''),
('exhibits', 'core.page', '', NULL, NULL, 'exhibits', 'exhibits', 0, '2017-01-24 09:06:29', 0, '0000-00-00 00:00:00', ''),
('news', 'core.page', '', NULL, NULL, 'news', 'news', 0, '2017-01-24 09:06:32', 0, '0000-00-00 00:00:00', ''),
('research', 'core.page', '', NULL, NULL, 'research', 'research', 0, '2017-01-24 09:06:35', 0, '0000-00-00 00:00:00', ''),
('treasure', 'core.page', '', NULL, NULL, 'treasure', 'treasure', 0, '2017-01-24 09:06:35', 0, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_relation_xmi`
--

CREATE TABLE `ark_relation_xmi` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `xmi_module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `xmi_item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_sequence`
--

CREATE TABLE `ark_sequence` (
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idx` int(11) NOT NULL,
  `min` int(11) DEFAULT NULL,
  `max` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_sequence`
--

INSERT INTO `ark_sequence` (`module`, `parent`, `sequence`, `idx`, `min`, `max`) VALUES
('find', '', 'id', 16, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_sequence_lock`
--

CREATE TABLE `ark_sequence_lock` (
  `id` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idx` int(11) NOT NULL,
  `recycle` tinyint(1) NOT NULL DEFAULT '0',
  `locked_by` int(11) NOT NULL,
  `locked_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_sequence_lock`
--

INSERT INTO `ark_sequence_lock` (`id`, `module`, `parent`, `sequence`, `idx`, `recycle`, `locked_by`, `locked_on`) VALUES
(2, 'find', '', 'id', 1, 0, 0, '0000-00-00 00:00:00'),
(3, 'find', '', 'id', 1, 0, 0, '0000-00-00 00:00:00'),
(4, 'find', '', 'id', 1, 0, 0, '0000-00-00 00:00:00'),
(5, 'find', '', 'id', 1, 0, 0, '0000-00-00 00:00:00'),
(6, 'find', '', 'id', 1, 0, 0, '0000-00-00 00:00:00'),
(7, 'find', '', 'id', 1, 0, 0, '0000-00-00 00:00:00'),
(8, 'find', '', 'id', 1, 0, 0, '0000-00-00 00:00:00'),
(9, 'find', '', 'id', 1, 0, 0, '0000-00-00 00:00:00'),
(10, 'find', '', 'id', 1, 0, 0, '0000-00-00 00:00:00'),
(11, 'find', '', 'id', 1, 0, 0, '0000-00-00 00:00:00'),
(12, 'find', '', 'id', 1, 0, 0, '0000-00-00 00:00:00'),
(13, 'find', '', 'id', 1, 0, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ark_sequence_reserve`
--

CREATE TABLE `ark_sequence_reserve` (
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idx` int(11) NOT NULL,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_spatial_search`
--

CREATE TABLE `ark_spatial_search` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `geometry` geometry NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ark_dataclass_member`
--
ALTER TABLE `ark_dataclass_member`
  ADD PRIMARY KEY (`object_fid`,`module`,`item`,`property`,`member`,`member_fid`);

--
-- Indexes for table `ark_fragment_blob`
--
ALTER TABLE `ark_fragment_blob`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `property` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_boolean`
--
ALTER TABLE `ark_fragment_boolean`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_date`
--
ALTER TABLE `ark_fragment_date`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_datetime`
--
ALTER TABLE `ark_fragment_datetime`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_decimal`
--
ALTER TABLE `ark_fragment_decimal`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `property` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_float`
--
ALTER TABLE `ark_fragment_float`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_integer`
--
ALTER TABLE `ark_fragment_integer`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_item`
--
ALTER TABLE `ark_fragment_item`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_object`
--
ALTER TABLE `ark_fragment_object`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `item` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_string`
--
ALTER TABLE `ark_fragment_string`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_text`
--
ALTER TABLE `ark_fragment_text`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_time`
--
ALTER TABLE `ark_fragment_time`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_wkt`
--
ALTER TABLE `ark_fragment_wkt`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `property` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_item_actor`
--
ALTER TABLE `ark_item_actor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_campaign`
--
ALTER TABLE `ark_item_campaign`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_file`
--
ALTER TABLE `ark_item_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE,
  ADD KEY `name` (`label`) USING BTREE;

--
-- Indexes for table `ark_item_find`
--
ALTER TABLE `ark_item_find`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_image`
--
ALTER TABLE `ark_item_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_location`
--
ALTER TABLE `ark_item_location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_page`
--
ALTER TABLE `ark_item_page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_relation_xmi`
--
ALTER TABLE `ark_relation_xmi`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`),
  ADD KEY `xmi_module` (`xmi_module`,`xmi_item`);

--
-- Indexes for table `ark_sequence`
--
ALTER TABLE `ark_sequence`
  ADD PRIMARY KEY (`module`,`parent`,`sequence`);

--
-- Indexes for table `ark_sequence_lock`
--
ALTER TABLE `ark_sequence_lock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ark_sequence_reserve`
--
ALTER TABLE `ark_sequence_reserve`
  ADD PRIMARY KEY (`module`,`parent`,`sequence`);

--
-- Indexes for table `ark_spatial_search`
--
ALTER TABLE `ark_spatial_search`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`property`),
  ADD SPATIAL KEY `geometry` (`geometry`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ark_fragment_blob`
--
ALTER TABLE `ark_fragment_blob`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_boolean`
--
ALTER TABLE `ark_fragment_boolean`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_date`
--
ALTER TABLE `ark_fragment_date`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `ark_fragment_datetime`
--
ALTER TABLE `ark_fragment_datetime`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_decimal`
--
ALTER TABLE `ark_fragment_decimal`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `ark_fragment_float`
--
ALTER TABLE `ark_fragment_float`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_integer`
--
ALTER TABLE `ark_fragment_integer`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_item`
--
ALTER TABLE `ark_fragment_item`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_object`
--
ALTER TABLE `ark_fragment_object`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_string`
--
ALTER TABLE `ark_fragment_string`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;
--
-- AUTO_INCREMENT for table `ark_fragment_text`
--
ALTER TABLE `ark_fragment_text`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `ark_fragment_time`
--
ALTER TABLE `ark_fragment_time`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_wkt`
--
ALTER TABLE `ark_fragment_wkt`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ark_relation_xmi`
--
ALTER TABLE `ark_relation_xmi`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_sequence_lock`
--
ALTER TABLE `ark_sequence_lock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
