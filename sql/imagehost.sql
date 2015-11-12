CREATE TABLE `images` (
  `id` int(11) NOT NULL auto_increment,
  `dateadded` datetime NOT NULL default '0000-00-00 00:00:00',
  `mimetype` varchar(100) NOT NULL default '',
  `originalfilename` varchar(255) NOT NULL default '',
  `filename` varchar(100) NOT NULL default '',
  `filesize` int(11) NOT NULL default '0',
  `description` mediumtext NOT NULL,
  `originalip` varchar(20) NOT NULL default '',
  `originalwidth` int(11) NOT NULL default '0',
  `originalheight` int(11) NOT NULL default '0',
  `lastaccessed` datetime NOT NULL default '0000-00-00 00:00:00',
  `totalviews` int(11) NOT NULL default '0',
  `status` enum('new','private','public','removed','adult') NOT NULL default 'new',
  `tracker` varchar(35) NOT NULL default '',
  `password` varchar(30) NOT NULL default '',
  `mutracker` varchar(35) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;