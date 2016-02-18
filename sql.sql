CREATE TABLE  `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `title_a` varchar(45) NOT NULL,
  `votes_a` int(10) unsigned NOT NULL DEFAULT '0',
  `image_a` text NOT NULL,
  `title_b` varchar(45) NOT NULL,
  `votes_b` int(10) unsigned NOT NULL DEFAULT '0',
  `image_b` text NOT NULL,
  `author` varchar(45) NOT NULL,
  `url` varchar(45) NOT NULL,
  `status` int(10) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `clean_url` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE  `votes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(45) NOT NULL,
  `user` varchar(45) NOT NULL,
  `vote` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;