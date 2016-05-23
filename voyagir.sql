-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `activity_commitment`;
CREATE TABLE `activity_commitment` (
  `activity_type` int(11) unsigned NOT NULL,
  `commitment` int(11) unsigned NOT NULL,
  PRIMARY KEY (`activity_type`,`commitment`),
  KEY `commitment` (`commitment`),
  CONSTRAINT `activity_commitment_ibfk_1` FOREIGN KEY (`activity_type`) REFERENCES `activity_type` (`id`),
  CONSTRAINT `activity_commitment_ibfk_2` FOREIGN KEY (`commitment`) REFERENCES `commitment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `activity_commitment` (`activity_type`, `commitment`) VALUES
(6,	1),
(1,	2),
(6,	2),
(1,	3);

DROP TABLE IF EXISTS `activity_type`;
CREATE TABLE `activity_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `activity_type` (`id`, `name`) VALUES
(1,	'Engaged Fishing'),
(2,	'Hunting'),
(3,	'Kayak'),
(4,	'Snorkeling'),
(6,	'Dive');

DROP TABLE IF EXISTS `base_user`;
CREATE TABLE `base_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1BF018B992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_1BF018B9A0D96FBF` (`email_canonical`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `base_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`) VALUES
(1,	'mat',	'mat',	'erfmath@gmail.com',	'erfmath@gmail.com',	1,	'c4jemskjbzwc0s08woogc04kss8s84k',	'$2y$13$c4jemskjbzwc0s08woogcuQoJzRg7.lKvdrJlrCfiuoXHgyPlF1..',	'2016-05-18 22:29:47',	0,	0,	NULL,	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',	0,	NULL),
(2,	'mat2',	'mat2',	'erfmath@orange.Fr',	'erfmath@orange.fr',	1,	'htbapp711b4ks8skgsskkwskwsc4408',	'$2y$13$htbapp711b4ks8skgsskkuMUMH5RsSin1qnQg6itlgwRUAW7CLCEa',	'2015-11-19 20:17:25',	0,	0,	NULL,	NULL,	NULL,	'a:0:{}',	0,	NULL),
(3,	'test',	'test',	'test@gmail.com',	'test@gmail.com',	1,	'no6z49fdmio44ggg8cs40g4g8wkw0c8',	'$2y$13$no6z49fdmio44ggg8cs40ePqRk1SNifUEv4/1IfSY13ovWJJDxvKK',	'2016-05-02 22:35:05',	0,	0,	NULL,	NULL,	NULL,	'a:0:{}',	0,	NULL);

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `limit_inf` int(11) unsigned NOT NULL,
  `limit_sup` int(11) unsigned NOT NULL,
  `level` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `limits` (`limit_inf`,`limit_sup`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `category` (`id`, `limit_inf`, `limit_sup`, `level`, `name`, `description`) VALUES
(1,	0,	9,	0,	'Etablissement',	'Catégorie racine'),
(2,	1,	6,	1,	'Restaurant',	'Où on mange'),
(7,	2,	3,	2,	'Végétarien',	'Pas de viande'),
(8,	7,	8,	1,	'Hotel',	'Où on dort'),
(10,	4,	5,	2,	'Carnivore',	'Plein de viande !');

DROP TABLE IF EXISTS `category_commitment`;
CREATE TABLE `category_commitment` (
  `commitment` int(11) unsigned NOT NULL,
  `category` int(11) unsigned NOT NULL,
  PRIMARY KEY (`commitment`,`category`),
  KEY `category` (`category`),
  CONSTRAINT `category_commitment_ibfk_1` FOREIGN KEY (`commitment`) REFERENCES `commitment` (`id`),
  CONSTRAINT `category_commitment_ibfk_2` FOREIGN KEY (`category`) REFERENCES `category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


SET NAMES utf8mb4;

DROP TABLE IF EXISTS `comment_activity`;
CREATE TABLE `comment_activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `activity` int(11) unsigned NOT NULL,
  `user` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `establishment_activity` (`activity`),
  KEY `user` (`user`),
  CONSTRAINT `comment_activity_ibfk_1` FOREIGN KEY (`activity`) REFERENCES `establishment_activity` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `comment_establishment`;
CREATE TABLE `comment_establishment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `establishment` int(11) unsigned NOT NULL,
  `user` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `note` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_com_etb_user` (`user`),
  KEY `establishment` (`establishment`),
  CONSTRAINT `comment_establishment_ibfk_1` FOREIGN KEY (`establishment`) REFERENCES `establishment` (`id`),
  CONSTRAINT `fk_com_etb_user` FOREIGN KEY (`user`) REFERENCES `base_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `commitment`;
CREATE TABLE `commitment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `commitment` (`id`, `icon`, `description`) VALUES
(1,	'Test',	'Tri des déchets'),
(2,	'Test',	'Développement durable'),
(3,	'Test',	'Doux foyer');

DROP TABLE IF EXISTS `commitment_question`;
CREATE TABLE `commitment_question` (
  `id` int(11) unsigned NOT NULL,
  `commitment` int(11) unsigned NOT NULL,
  `question` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) unsigned NOT NULL,
  `level` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `commitment_order` (`commitment`,`level`),
  CONSTRAINT `commitment_question_ibfk_2` FOREIGN KEY (`commitment`) REFERENCES `commitment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `code` int(3) NOT NULL,
  `alpha2` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `alpha3` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `name_en_gb` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `name_fr_fr` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alpha2` (`alpha2`),
  UNIQUE KEY `alpha3` (`alpha3`),
  UNIQUE KEY `code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `country` (`id`, `code`, `alpha2`, `alpha3`, `name_en_gb`, `name_fr_fr`) VALUES
(1,	4,	'AF',	'AFG',	'Afghanistan',	'Afghanistan'),
(2,	8,	'AL',	'ALB',	'Albania',	'Albanie'),
(3,	10,	'AQ',	'ATA',	'Antarctica',	'Antarctique'),
(4,	12,	'DZ',	'DZA',	'Algeria',	'Algérie'),
(5,	16,	'AS',	'ASM',	'American Samoa',	'Samoa Américaines'),
(6,	20,	'AD',	'AND',	'Andorra',	'Andorre'),
(7,	24,	'AO',	'AGO',	'Angola',	'Angola'),
(8,	28,	'AG',	'ATG',	'Antigua and Barbuda',	'Antigua-et-Barbuda'),
(9,	31,	'AZ',	'AZE',	'Azerbaijan',	'Azerbaïdjan'),
(10,	32,	'AR',	'ARG',	'Argentina',	'Argentine'),
(11,	36,	'AU',	'AUS',	'Australia',	'Australie'),
(12,	40,	'AT',	'AUT',	'Austria',	'Autriche'),
(13,	44,	'BS',	'BHS',	'Bahamas',	'Bahamas'),
(14,	48,	'BH',	'BHR',	'Bahrain',	'Bahreïn'),
(15,	50,	'BD',	'BGD',	'Bangladesh',	'Bangladesh'),
(16,	51,	'AM',	'ARM',	'Armenia',	'Arménie'),
(17,	52,	'BB',	'BRB',	'Barbados',	'Barbade'),
(18,	56,	'BE',	'BEL',	'Belgium',	'Belgique'),
(19,	60,	'BM',	'BMU',	'Bermuda',	'Bermudes'),
(20,	64,	'BT',	'BTN',	'Bhutan',	'Bhoutan'),
(21,	68,	'BO',	'BOL',	'Bolivia',	'Bolivie'),
(22,	70,	'BA',	'BIH',	'Bosnia and Herzegovina',	'Bosnie-Herzégovine'),
(23,	72,	'BW',	'BWA',	'Botswana',	'Botswana'),
(24,	74,	'BV',	'BVT',	'Bouvet Island',	'Île Bouvet'),
(25,	76,	'BR',	'BRA',	'Brazil',	'Brésil'),
(26,	84,	'BZ',	'BLZ',	'Belize',	'Belize'),
(27,	86,	'IO',	'IOT',	'British Indian Ocean Territory',	'Territoire Britannique de l\'Océan Indien'),
(28,	90,	'SB',	'SLB',	'Solomon Islands',	'Îles Salomon'),
(29,	92,	'VG',	'VGB',	'British Virgin Islands',	'Îles Vierges Britanniques'),
(30,	96,	'BN',	'BRN',	'Brunei Darussalam',	'Brunéi Darussalam'),
(31,	100,	'BG',	'BGR',	'Bulgaria',	'Bulgarie'),
(32,	104,	'MM',	'MMR',	'Myanmar',	'Myanmar'),
(33,	108,	'BI',	'BDI',	'Burundi',	'Burundi'),
(34,	112,	'BY',	'BLR',	'Belarus',	'Bélarus'),
(35,	116,	'KH',	'KHM',	'Cambodia',	'Cambodge'),
(36,	120,	'CM',	'CMR',	'Cameroon',	'Cameroun'),
(37,	124,	'CA',	'CAN',	'Canada',	'Canada'),
(38,	132,	'CV',	'CPV',	'Cape Verde',	'Cap-vert'),
(39,	136,	'KY',	'CYM',	'Cayman Islands',	'Îles Caïmanes'),
(40,	140,	'CF',	'CAF',	'Central African',	'République Centrafricaine'),
(41,	144,	'LK',	'LKA',	'Sri Lanka',	'Sri Lanka'),
(42,	148,	'TD',	'TCD',	'Chad',	'Tchad'),
(43,	152,	'CL',	'CHL',	'Chile',	'Chili'),
(44,	156,	'CN',	'CHN',	'China',	'Chine'),
(45,	158,	'TW',	'TWN',	'Taiwan',	'Taïwan'),
(46,	162,	'CX',	'CXR',	'Christmas Island',	'Île Christmas'),
(47,	166,	'CC',	'CCK',	'Cocos (Keeling) Islands',	'Îles Cocos (Keeling)'),
(48,	170,	'CO',	'COL',	'Colombia',	'Colombie'),
(49,	174,	'KM',	'COM',	'Comoros',	'Comores'),
(50,	175,	'YT',	'MYT',	'Mayotte',	'Mayotte'),
(51,	178,	'CG',	'COG',	'Republic of the Congo',	'République du Congo'),
(52,	180,	'CD',	'COD',	'The Democratic Republic Of The Congo',	'République Démocratique du Congo'),
(53,	184,	'CK',	'COK',	'Cook Islands',	'Îles Cook'),
(54,	188,	'CR',	'CRI',	'Costa Rica',	'Costa Rica'),
(55,	191,	'HR',	'HRV',	'Croatia',	'Croatie'),
(56,	192,	'CU',	'CUB',	'Cuba',	'Cuba'),
(57,	196,	'CY',	'CYP',	'Cyprus',	'Chypre'),
(58,	203,	'CZ',	'CZE',	'Czech Republic',	'République Tchèque'),
(59,	204,	'BJ',	'BEN',	'Benin',	'Bénin'),
(60,	208,	'DK',	'DNK',	'Denmark',	'Danemark'),
(61,	212,	'DM',	'DMA',	'Dominica',	'Dominique'),
(62,	214,	'DO',	'DOM',	'Dominican Republic',	'République Dominicaine'),
(63,	218,	'EC',	'ECU',	'Ecuador',	'Équateur'),
(64,	222,	'SV',	'SLV',	'El Salvador',	'El Salvador'),
(65,	226,	'GQ',	'GNQ',	'Equatorial Guinea',	'Guinée Équatoriale'),
(66,	231,	'ET',	'ETH',	'Ethiopia',	'Éthiopie'),
(67,	232,	'ER',	'ERI',	'Eritrea',	'Érythrée'),
(68,	233,	'EE',	'EST',	'Estonia',	'Estonie'),
(69,	234,	'FO',	'FRO',	'Faroe Islands',	'Îles Féroé'),
(70,	238,	'FK',	'FLK',	'Falkland Islands',	'Îles (malvinas) Falkland'),
(71,	239,	'GS',	'SGS',	'South Georgia and the South Sandwich Islands',	'Géorgie du Sud et les Îles Sandwich du Sud'),
(72,	242,	'FJ',	'FJI',	'Fiji',	'Fidji'),
(73,	246,	'FI',	'FIN',	'Finland',	'Finlande'),
(74,	248,	'AX',	'ALA',	'Åland Islands',	'Îles Åland'),
(75,	250,	'FR',	'FRA',	'France',	'France'),
(76,	254,	'GF',	'GUF',	'French Guiana',	'Guyane Française'),
(77,	258,	'PF',	'PYF',	'French Polynesia',	'Polynésie Française'),
(78,	260,	'TF',	'ATF',	'French Southern Territories',	'Terres Australes Françaises'),
(79,	262,	'DJ',	'DJI',	'Djibouti',	'Djibouti'),
(80,	266,	'GA',	'GAB',	'Gabon',	'Gabon'),
(81,	268,	'GE',	'GEO',	'Georgia',	'Géorgie'),
(82,	270,	'GM',	'GMB',	'Gambia',	'Gambie'),
(83,	275,	'PS',	'PSE',	'Occupied Palestinian Territory',	'Territoire Palestinien Occupé'),
(84,	276,	'DE',	'DEU',	'Germany',	'Allemagne'),
(85,	288,	'GH',	'GHA',	'Ghana',	'Ghana'),
(86,	292,	'GI',	'GIB',	'Gibraltar',	'Gibraltar'),
(87,	296,	'KI',	'KIR',	'Kiribati',	'Kiribati'),
(88,	300,	'GR',	'GRC',	'Greece',	'Grèce'),
(89,	304,	'GL',	'GRL',	'Greenland',	'Groenland'),
(90,	308,	'GD',	'GRD',	'Grenada',	'Grenade'),
(91,	312,	'GP',	'GLP',	'Guadeloupe',	'Guadeloupe'),
(92,	316,	'GU',	'GUM',	'Guam',	'Guam'),
(93,	320,	'GT',	'GTM',	'Guatemala',	'Guatemala'),
(94,	324,	'GN',	'GIN',	'Guinea',	'Guinée'),
(95,	328,	'GY',	'GUY',	'Guyana',	'Guyana'),
(96,	332,	'HT',	'HTI',	'Haiti',	'Haïti'),
(97,	334,	'HM',	'HMD',	'Heard Island and McDonald Islands',	'Îles Heard et Mcdonald'),
(98,	336,	'VA',	'VAT',	'Vatican City State',	'Saint-Siège (état de la Cité du Vatican)'),
(99,	340,	'HN',	'HND',	'Honduras',	'Honduras'),
(100,	344,	'HK',	'HKG',	'Hong Kong',	'Hong-Kong'),
(101,	348,	'HU',	'HUN',	'Hungary',	'Hongrie'),
(102,	352,	'IS',	'ISL',	'Iceland',	'Islande'),
(103,	356,	'IN',	'IND',	'India',	'Inde'),
(104,	360,	'ID',	'IDN',	'Indonesia',	'Indonésie'),
(105,	364,	'IR',	'IRN',	'Islamic Republic of Iran',	'République Islamique d\'Iran'),
(106,	368,	'IQ',	'IRQ',	'Iraq',	'Iraq'),
(107,	372,	'IE',	'IRL',	'Ireland',	'Irlande'),
(108,	376,	'IL',	'ISR',	'Israel',	'Israël'),
(109,	380,	'IT',	'ITA',	'Italy',	'Italie'),
(110,	384,	'CI',	'CIV',	'Côte d\'Ivoire',	'Côte d\'Ivoire'),
(111,	388,	'JM',	'JAM',	'Jamaica',	'Jamaïque'),
(112,	392,	'JP',	'JPN',	'Japan',	'Japon'),
(113,	398,	'KZ',	'KAZ',	'Kazakhstan',	'Kazakhstan'),
(114,	400,	'JO',	'JOR',	'Jordan',	'Jordanie'),
(115,	404,	'KE',	'KEN',	'Kenya',	'Kenya'),
(116,	408,	'KP',	'PRK',	'Democratic People\'s Republic of Korea',	'République Populaire Démocratique de Corée'),
(117,	410,	'KR',	'KOR',	'Republic of Korea',	'République de Corée'),
(118,	414,	'KW',	'KWT',	'Kuwait',	'Koweït'),
(119,	417,	'KG',	'KGZ',	'Kyrgyzstan',	'Kirghizistan'),
(120,	418,	'LA',	'LAO',	'Lao People\'s Democratic Republic',	'République Démocratique Populaire Lao'),
(121,	422,	'LB',	'LBN',	'Lebanon',	'Liban'),
(122,	426,	'LS',	'LSO',	'Lesotho',	'Lesotho'),
(123,	428,	'LV',	'LVA',	'Latvia',	'Lettonie'),
(124,	430,	'LR',	'LBR',	'Liberia',	'Libéria'),
(125,	434,	'LY',	'LBY',	'Libyan Arab Jamahiriya',	'Jamahiriya Arabe Libyenne'),
(126,	438,	'LI',	'LIE',	'Liechtenstein',	'Liechtenstein'),
(127,	440,	'LT',	'LTU',	'Lithuania',	'Lituanie'),
(128,	442,	'LU',	'LUX',	'Luxembourg',	'Luxembourg'),
(129,	446,	'MO',	'MAC',	'Macao',	'Macao'),
(130,	450,	'MG',	'MDG',	'Madagascar',	'Madagascar'),
(131,	454,	'MW',	'MWI',	'Malawi',	'Malawi'),
(132,	458,	'MY',	'MYS',	'Malaysia',	'Malaisie'),
(133,	462,	'MV',	'MDV',	'Maldives',	'Maldives'),
(134,	466,	'ML',	'MLI',	'Mali',	'Mali'),
(135,	470,	'MT',	'MLT',	'Malta',	'Malte'),
(136,	474,	'MQ',	'MTQ',	'Martinique',	'Martinique'),
(137,	478,	'MR',	'MRT',	'Mauritania',	'Mauritanie'),
(138,	480,	'MU',	'MUS',	'Mauritius',	'Maurice'),
(139,	484,	'MX',	'MEX',	'Mexico',	'Mexique'),
(140,	492,	'MC',	'MCO',	'Monaco',	'Monaco'),
(141,	496,	'MN',	'MNG',	'Mongolia',	'Mongolie'),
(142,	498,	'MD',	'MDA',	'Republic of Moldova',	'République de Moldova'),
(143,	500,	'MS',	'MSR',	'Montserrat',	'Montserrat'),
(144,	504,	'MA',	'MAR',	'Morocco',	'Maroc'),
(145,	508,	'MZ',	'MOZ',	'Mozambique',	'Mozambique'),
(146,	512,	'OM',	'OMN',	'Oman',	'Oman'),
(147,	516,	'NA',	'NAM',	'Namibia',	'Namibie'),
(148,	520,	'NR',	'NRU',	'Nauru',	'Nauru'),
(149,	524,	'NP',	'NPL',	'Nepal',	'Népal'),
(150,	528,	'NL',	'NLD',	'Netherlands',	'Pays-Bas'),
(151,	530,	'AN',	'ANT',	'Netherlands Antilles',	'Antilles Néerlandaises'),
(152,	533,	'AW',	'ABW',	'Aruba',	'Aruba'),
(153,	540,	'NC',	'NCL',	'New Caledonia',	'Nouvelle-Calédonie'),
(154,	548,	'VU',	'VUT',	'Vanuatu',	'Vanuatu'),
(155,	554,	'NZ',	'NZL',	'New Zealand',	'Nouvelle-Zélande'),
(156,	558,	'NI',	'NIC',	'Nicaragua',	'Nicaragua'),
(157,	562,	'NE',	'NER',	'Niger',	'Niger'),
(158,	566,	'NG',	'NGA',	'Nigeria',	'Nigéria'),
(159,	570,	'NU',	'NIU',	'Niue',	'Niué'),
(160,	574,	'NF',	'NFK',	'Norfolk Island',	'Île Norfolk'),
(161,	578,	'NO',	'NOR',	'Norway',	'Norvège'),
(162,	580,	'MP',	'MNP',	'Northern Mariana Islands',	'Îles Mariannes du Nord'),
(163,	581,	'UM',	'UMI',	'United States Minor Outlying Islands',	'Îles Mineures Éloignées des États-Unis'),
(164,	583,	'FM',	'FSM',	'Federated States of Micronesia',	'États Fédérés de Micronésie'),
(165,	584,	'MH',	'MHL',	'Marshall Islands',	'Îles Marshall'),
(166,	585,	'PW',	'PLW',	'Palau',	'Palaos'),
(167,	586,	'PK',	'PAK',	'Pakistan',	'Pakistan'),
(168,	591,	'PA',	'PAN',	'Panama',	'Panama'),
(169,	598,	'PG',	'PNG',	'Papua New Guinea',	'Papouasie-Nouvelle-Guinée'),
(170,	600,	'PY',	'PRY',	'Paraguay',	'Paraguay'),
(171,	604,	'PE',	'PER',	'Peru',	'Pérou'),
(172,	608,	'PH',	'PHL',	'Philippines',	'Philippines'),
(173,	612,	'PN',	'PCN',	'Pitcairn',	'Pitcairn'),
(174,	616,	'PL',	'POL',	'Poland',	'Pologne'),
(175,	620,	'PT',	'PRT',	'Portugal',	'Portugal'),
(176,	624,	'GW',	'GNB',	'Guinea-Bissau',	'Guinée-Bissau'),
(177,	626,	'TL',	'TLS',	'Timor-Leste',	'Timor-Leste'),
(178,	630,	'PR',	'PRI',	'Puerto Rico',	'Porto Rico'),
(179,	634,	'QA',	'QAT',	'Qatar',	'Qatar'),
(180,	638,	'RE',	'REU',	'Réunion',	'Réunion'),
(181,	642,	'RO',	'ROU',	'Romania',	'Roumanie'),
(182,	643,	'RU',	'RUS',	'Russian Federation',	'Fédération de Russie'),
(183,	646,	'RW',	'RWA',	'Rwanda',	'Rwanda'),
(184,	654,	'SH',	'SHN',	'Saint Helena',	'Sainte-Hélène'),
(185,	659,	'KN',	'KNA',	'Saint Kitts and Nevis',	'Saint-Kitts-et-Nevis'),
(186,	660,	'AI',	'AIA',	'Anguilla',	'Anguilla'),
(187,	662,	'LC',	'LCA',	'Saint Lucia',	'Sainte-Lucie'),
(188,	666,	'PM',	'SPM',	'Saint-Pierre and Miquelon',	'Saint-Pierre-et-Miquelon'),
(189,	670,	'VC',	'VCT',	'Saint Vincent and the Grenadines',	'Saint-Vincent-et-les Grenadines'),
(190,	674,	'SM',	'SMR',	'San Marino',	'Saint-Marin'),
(191,	678,	'ST',	'STP',	'Sao Tome and Principe',	'Sao Tomé-et-Principe'),
(192,	682,	'SA',	'SAU',	'Saudi Arabia',	'Arabie Saoudite'),
(193,	686,	'SN',	'SEN',	'Senegal',	'Sénégal'),
(194,	690,	'SC',	'SYC',	'Seychelles',	'Seychelles'),
(195,	694,	'SL',	'SLE',	'Sierra Leone',	'Sierra Leone'),
(196,	702,	'SG',	'SGP',	'Singapore',	'Singapour'),
(197,	703,	'SK',	'SVK',	'Slovakia',	'Slovaquie'),
(198,	704,	'VN',	'VNM',	'Vietnam',	'Viet Nam'),
(199,	705,	'SI',	'SVN',	'Slovenia',	'Slovénie'),
(200,	706,	'SO',	'SOM',	'Somalia',	'Somalie'),
(201,	710,	'ZA',	'ZAF',	'South Africa',	'Afrique du Sud'),
(202,	716,	'ZW',	'ZWE',	'Zimbabwe',	'Zimbabwe'),
(203,	724,	'ES',	'ESP',	'Spain',	'Espagne'),
(204,	732,	'EH',	'ESH',	'Western Sahara',	'Sahara Occidental'),
(205,	736,	'SD',	'SDN',	'Sudan',	'Soudan'),
(206,	740,	'SR',	'SUR',	'Suriname',	'Suriname'),
(207,	744,	'SJ',	'SJM',	'Svalbard and Jan Mayen',	'Svalbard etÎle Jan Mayen'),
(208,	748,	'SZ',	'SWZ',	'Swaziland',	'Swaziland'),
(209,	752,	'SE',	'SWE',	'Sweden',	'Suède'),
(210,	756,	'CH',	'CHE',	'Switzerland',	'Suisse'),
(211,	760,	'SY',	'SYR',	'Syrian Arab Republic',	'République Arabe Syrienne'),
(212,	762,	'TJ',	'TJK',	'Tajikistan',	'Tadjikistan'),
(213,	764,	'TH',	'THA',	'Thailand',	'Thaïlande'),
(214,	768,	'TG',	'TGO',	'Togo',	'Togo'),
(215,	772,	'TK',	'TKL',	'Tokelau',	'Tokelau'),
(216,	776,	'TO',	'TON',	'Tonga',	'Tonga'),
(217,	780,	'TT',	'TTO',	'Trinidad and Tobago',	'Trinité-et-Tobago'),
(218,	784,	'AE',	'ARE',	'United Arab Emirates',	'Émirats Arabes Unis'),
(219,	788,	'TN',	'TUN',	'Tunisia',	'Tunisie'),
(220,	792,	'TR',	'TUR',	'Turkey',	'Turquie'),
(221,	795,	'TM',	'TKM',	'Turkmenistan',	'Turkménistan'),
(222,	796,	'TC',	'TCA',	'Turks and Caicos Islands',	'Îles Turks et Caïques'),
(223,	798,	'TV',	'TUV',	'Tuvalu',	'Tuvalu'),
(224,	800,	'UG',	'UGA',	'Uganda',	'Ouganda'),
(225,	804,	'UA',	'UKR',	'Ukraine',	'Ukraine'),
(226,	807,	'MK',	'MKD',	'The Former Yugoslav Republic of Macedonia',	'L\'ex-République Yougoslave de Macédoine'),
(227,	818,	'EG',	'EGY',	'Egypt',	'Égypte'),
(228,	826,	'GB',	'GBR',	'United Kingdom',	'Royaume-Uni'),
(229,	833,	'IM',	'IMN',	'Isle of Man',	'Île de Man'),
(230,	834,	'TZ',	'TZA',	'United Republic Of Tanzania',	'République-Unie de Tanzanie'),
(231,	840,	'US',	'USA',	'United States',	'États-Unis'),
(232,	850,	'VI',	'VIR',	'U.S. Virgin Islands',	'Îles Vierges des États-Unis'),
(233,	854,	'BF',	'BFA',	'Burkina Faso',	'Burkina Faso'),
(234,	858,	'UY',	'URY',	'Uruguay',	'Uruguay'),
(235,	860,	'UZ',	'UZB',	'Uzbekistan',	'Ouzbékistan'),
(236,	862,	'VE',	'VEN',	'Venezuela',	'Venezuela'),
(237,	876,	'WF',	'WLF',	'Wallis and Futuna',	'Wallis et Futuna'),
(238,	882,	'WS',	'WSM',	'Samoa',	'Samoa'),
(239,	887,	'YE',	'YEM',	'Yemen',	'Yémen'),
(240,	891,	'CS',	'SCG',	'Serbia and Montenegro',	'Serbie-et-Monténégro'),
(241,	894,	'ZM',	'ZMB',	'Zambia',	'Zambie');

DROP TABLE IF EXISTS `estabilshment_tags`;
CREATE TABLE `estabilshment_tags` (
  `establishment` int(11) unsigned NOT NULL,
  `tag` int(11) unsigned NOT NULL,
  KEY `establishment` (`establishment`),
  KEY `tag` (`tag`),
  CONSTRAINT `estabilshment_tags_ibfk_1` FOREIGN KEY (`establishment`) REFERENCES `establishment` (`id`),
  CONSTRAINT `estabilshment_tags_ibfk_2` FOREIGN KEY (`tag`) REFERENCES `tag` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `establishment`;
CREATE TABLE `establishment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID de l''établissement',
  `user_owner` int(11) NOT NULL COMMENT 'Propriétaire de l''établissement',
  `category` int(11) unsigned NOT NULL DEFAULT '1' COMMENT 'Catégorie d''établissement',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nom de l''établissement',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Description de l''établissement',
  `useful_info` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `custom_commitments` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `adress` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Adresse de l''établissement',
  `adress_city` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `adress_region` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `adress_country` smallint(5) unsigned DEFAULT NULL,
  `contact_mail` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_fb` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_twt` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_website` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `coord` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `validated` tinyint(1) NOT NULL DEFAULT '0',
  `validated_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `last_update_at` timestamp NULL DEFAULT NULL,
  `image_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_offset` smallint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_user` (`user_owner`),
  KEY `category` (`category`),
  KEY `adress_country` (`adress_country`),
  CONSTRAINT `establishment_ibfk_1` FOREIGN KEY (`category`) REFERENCES `category` (`id`),
  CONSTRAINT `establishment_ibfk_2` FOREIGN KEY (`adress_country`) REFERENCES `country` (`id`),
  CONSTRAINT `fk_establishment_user` FOREIGN KEY (`user_owner`) REFERENCES `base_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Etablissement touristique';

INSERT INTO `establishment` (`id`, `user_owner`, `category`, `name`, `description`, `useful_info`, `custom_commitments`, `adress`, `adress_city`, `adress_region`, `adress_country`, `contact_mail`, `contact_fb`, `contact_twt`, `contact_website`, `contact_phone`, `coord`, `validated`, `validated_at`, `created_at`, `last_update_at`, `image_name`, `image_offset`) VALUES
(8,	1,	1,	'Chez oim',	'C\'est d\'la balle',	'On est chez nous',	'Aimer ma chérie',	'35 rue des Champions',	'Millau',	NULL,	75,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	'2016-05-03',	'2016-05-03 11:45:59',	'2016-05-03 11:45:59',	'8_Chez oim.jpg',	200),
(9,	3,	1,	'Etablissement de test',	'test',	NULL,	NULL,	'404 rue des Tests',	'Paris',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	'2016-05-03',	'2016-05-03 11:47:38',	'2016-05-03 11:47:38',	'9_Etablissement de test.jpg',	300),
(10,	1,	1,	'Un autre établissement',	'Celui là est pas mal aussi',	NULL,	NULL,	'333',	'Pragues',	NULL,	12,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	'2016-05-03',	'2016-05-03 11:50:07',	'2016-05-03 11:31:41',	'_Un autre établissement.jpg',	200),
(11,	1,	1,	'La fête du slip',	'Comme son nom l\'indique',	NULL,	NULL,	'13 rue de ma culotte',	'Ouille',	NULL,	83,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	'2016-05-03',	'2016-05-18 21:14:44',	'2016-05-18 21:14:44',	'_La fête du slip.jpg',	300);

DROP TABLE IF EXISTS `establishment_activity`;
CREATE TABLE `establishment_activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `establishment` int(11) unsigned NOT NULL,
  `activity_type` int(11) unsigned NOT NULL DEFAULT '0',
  `description` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `price` int(11) DEFAULT NULL,
  `level` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `establishment_order` (`establishment`,`level`),
  KEY `activity_type` (`activity_type`),
  CONSTRAINT `establishment_activity_ibfk_2` FOREIGN KEY (`activity_type`) REFERENCES `activity_type` (`id`),
  CONSTRAINT `establishment_activity_ibfk_3` FOREIGN KEY (`establishment`) REFERENCES `establishment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table des activités touristiques';

INSERT INTO `establishment_activity` (`id`, `establishment`, `activity_type`, `description`, `price`, `level`) VALUES
(1,	8,	1,	'Venez pêchez !',	100,	1);

DROP TABLE IF EXISTS `establishment_label`;
CREATE TABLE `establishment_label` (
  `label` int(11) unsigned NOT NULL,
  `establishment` int(11) unsigned NOT NULL,
  PRIMARY KEY (`label`,`establishment`),
  KEY `establishment` (`establishment`),
  CONSTRAINT `establishment_label_ibfk_5` FOREIGN KEY (`label`) REFERENCES `label` (`id`),
  CONSTRAINT `establishment_label_ibfk_1` FOREIGN KEY (`establishment`) REFERENCES `establishment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `label`;
CREATE TABLE `label` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `label` (`id`, `name`) VALUES
(2,	'Label 1'),
(3,	'Label 2'),
(4,	'Label 3');

DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `user_answer`;
CREATE TABLE `user_answer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `establishment` int(11) unsigned NOT NULL,
  `question` int(11) unsigned NOT NULL,
  `answer` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `establishment` (`establishment`),
  KEY `user` (`user`),
  KEY `question_id` (`question`),
  CONSTRAINT `user_answer_ibfk_2` FOREIGN KEY (`user`) REFERENCES `base_user` (`id`),
  CONSTRAINT `user_answer_ibfk_3` FOREIGN KEY (`establishment`) REFERENCES `establishment` (`id`),
  CONSTRAINT `user_answer_ibfk_4` FOREIGN KEY (`question`) REFERENCES `commitment_question` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2016-05-22 12:18:26
