<?php
/**
 * Installation of test/data database
 * Checks for configuration, database and tries to make a PDO connection
 * Creates the appropriate tables structure.
 * Imports data.
 * 
 * @author Ionut Plesca
 * 
 * @param $conn PDO connection
 * @param $socialData array of users
 */
set_time_limit(0); // if process stalls, kill in apache :P

define('IMPORT_FILE', 'socialGraph.php');
define('CONFIG_FILE', 'config.inc.php');
define('SELECTED_DB', 'default');

// database connection
$conn = null;

// open config:
file_exists(CONFIG_FILE) ? true : die('Cannot access configuration file.<br>');
$config = @require_once(CONFIG_FILE);

echo 'Reading configuration <br>';
if (!$config || !is_array($config)) {
    die('Cannot access configuration.<br>');
}
// open import data:
file_exists(IMPORT_FILE) ? true : die('Cannot read import data file.<br>');
@require_once(IMPORT_FILE);

if (!@$socialData || !is_array($socialData)) {
    die('Wrong import data format.<br>');
}

// check database credentials
if (!isset($config['db']) && !isset($config['db'][SELECTED_DB])) {
    die('No database provided.<br>');
} else {
    $db = $config['db'][SELECTED_DB];
    $db = array_merge(array(
        'host'     => '_undefined_',
        'name'     => '_undefined_',
        'username' => '_undefined_',
        'password' => '',
    ), $db);
    
    $dsn = sprintf('mysql:host=%s;dbname=%s', $db['host'], $db['name']);
    
    try {
        $conn = new PDO($dsn, $db['username'], $db['password']);

    } catch (PDOException $e) { // otherwise will throw the full PDO object, in all it's splendor, including the user/pass
        die('Cannot connect to the provided database credentials <em>' . $e->getMessage() . '</em>');
    }
}

echo 'Using "'. SELECTED_DB .'"database : <strong>'. $db['name'] .'</strong> <br>';

// Done reading config

// Tables SQL. I used InnoDB so I can put some constraints for a bit of "magic"
$databaseDDL = <<<SQL

-- Users table
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = male, 0 = female',
  `age` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='User table' AUTO_INCREMENT=1 ;

-- Friends table
DROP TABLE IF EXISTS `friends`;
CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL COMMENT 'users table id',
  `friendId` int(10) DEFAULT NULL COMMENT 'users table id of friend',
  PRIMARY KEY (`id`),
  UNIQUE KEY `aToB` (`userId`,`friendId`),
  KEY `userId` (`userId`),
  KEY `friendId` (`friendId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Friends table defines 1:n relations of users' AUTO_INCREMENT=1 ;

-- Cities table
DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Cities table' AUTO_INCREMENT=1 ;

-- Visited cities table
DROP TABLE IF EXISTS `visitedcities`;
CREATE TABLE IF NOT EXISTS `visitedcities` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL,
  `cityId` int(5) DEFAULT NULL,
  `rating` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0 means 100%',
  PRIMARY KEY (`id`),
  UNIQUE KEY `userCity` (`userId`,`cityId`),
  KEY `userId` (`userId`),
  KEY `cityId` (`cityId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='1:n user to visited cities' AUTO_INCREMENT=1 ;


-- 
-- Foreign keys
-- 
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friendId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
ALTER TABLE `visitedcities`
  ADD CONSTRAINT `visitedcities_ibfk_2` FOREIGN KEY (`cityId`) REFERENCES `cities` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `visitedcities_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;



SQL;

// go ahead only if we can make the tables
if ($conn->query($databaseDDL)) {
    // get some unique key
    $importKey = substr(md5(uniqid()), rand(0, 15) + 1, 6);

    $importUsers         = array();
    $importConnections   = array();
    $importCities        = array();
    $importVisitedCities = array();

    // temporary
    $connectionRecords    = array();

    $cityNr = 0;

    // do we have any data in the first place?
    if (!empty($socialData)) {
        // lets split the big array into inteligible chunks
        foreach ($socialData as $user) {
            // prepare the "insert" ready user array
            $userRecord = array(
                'firstname' => $user['firstName'],
                'lastname'  => $user['surname'],
                'age'       => $user['age'],
                'gender'    => 'male' == trim(strtolower($user['gender'])) ? 1 : 0,
                'importId'  => 'user' . $importKey . $user['id'],
            );

            // user duplication check
            if (!isset($importUsers[ $user['id'] ])) {
                $importUsers[ $user['id'] ] = $userRecord;
            } else {
                echo "Warning!<br>";
                echo "User <strong>{$userRecord['firstname']} {$userRecord['lastname']}</strong> has the same ID[{$user['id']}] with the user <strong>{$importUsers[ $user['id'] ]['firstname']} {$importUsers[ $user['id'] ]['lastname']}</strong><br>";
                echo "This can lead to wrong user connection definition!<br>";
                echo "Discarding user import...<br><br>";
            }

            // put user connections separate, will return to complete definition
            if (isset($user['connections']) && is_array($user['connections']) && !empty($user['connections'])) {
                $connectionRecords[ $userRecord['importId'] ] = $user['connections'];
            }

            // create the cities list based on user travel, will have to check for duplicates in the db
            if (isset($user['cities']) && is_array($user['cities'])) {
                foreach ($user['cities'] as $city => $rating) {

                    // do we have this city already?
                    if (isset($importCities[ $city ])) {
                        $cityRecord = $importCities[ $city ];
                    } else {

                        // prepare the "insert" ready city array
                        $cityRecord = array(
                            'name' => $city,
                            'importId' => 'city' . $importKey . ++$cityNr
                        );
                        $importCities[ $city ] = $cityRecord;
                    }

                    $vcRecord = array(
                        'userId' => $userRecord['importId'],
                        'cityId' => $cityRecord['importId'],
                        'rating' => 100 == (int)$rating ? 0 : $rating // rating field has only 2 digits, we consider 100% as 0
                    );
                    // put user's visited city separate
                    $importVisitedCities[] = $vcRecord;
                }
            }
        }
        // complete the user's connection definition
        if (!empty($connectionRecords)) {
            foreach ($connectionRecords as $userImportId => $connectionsIds) {
                // for each of the $userImportId friends ...
                foreach ($connectionsIds as $connectionId) {
                    // make pairs of this user's importId and the connection user's importId
                    // in this order, they will become friends.userId and friends.friendId
                    $pairAB = array($userImportId, $importUsers[ $connectionId ]['importId']);
                    $pairBA = array($importUsers[ $connectionId ]['importId'], $userImportId);

                    // make an unique index to ensure the reciprocal friendship
                    // maybe user A has user B listed as connection, but if, by means of incomplete import data,
                    // B hasn't, then will make him friend with A nonetheless :P
                    $aToB = implode('#', $pairAB);
                    $bToA = implode('#', $pairBA);

                    // and this way we'll not have reciprocal pairs duplication (will be ignored by the insert statment anyway)
                    $importConnections[$aToB] = $pairAB;
                    $importConnections[$bToA] = $pairBA;
                }
            }
        }
        // time to explain the importId role (and make the big import statement)
        $importDDL = '';

        // first insert all the users - assume each is unique-enough [no other PPSN available to check against existing db users]
        $userDdlTemplate = "INSERT INTO users SET firstname = '%s', lastname = '%s', age = %d, gender = %d;
                            SET @%s = LAST_INSERT_ID();
                            ";

        // each user will have its own INSERT so that we can store the generated ID in a 'importId' variable for future reference in visitedCities and connections
        // this is a fair trade compared to make countless SELECT to fetch the generated user id
        foreach ($importUsers as $user) {
            $user = array_map('mysql_real_escape_string', $user);
            $importDDL .= sprintf($userDdlTemplate, $user['firstname'], $user['lastname'], $user['age'], $user['gender'], 
                                                    $user['importId']);
        }

        // now insert the cities, but check in case it was already defined in a previous import batch
        // yes, I've created the cities table just now but this only educational
        // the database might exist already in the exact same format with real data
        $cityDdlTemplate = "INSERT IGNORE INTO cities SET name = '%s';
                            SELECT IF( LAST_INSERT_ID() = 0, id, LAST_INSERT_ID()) INTO @%s FROM cities WHERE name = '%s';
                            ";

        foreach ($importCities as $city) {
            $city = array_map('mysql_real_escape_string', $city);
            $importDDL .= sprintf($cityDdlTemplate, $city['name'], 
                                                    $city['importId'], $city['name']);
        }

        // add the user's connections
        if (!empty($importConnections)) {
            $connectionsDdlTemplate = 'INSERT IGNORE INTO friends (userId, friendId) VALUES %s;
                                      ';

            $connectionValues = array();
            foreach ($importConnections as $pair) {
                // and here we use the previous user id value stored in their corresponding @userImportId vars
                $connectionValues[] = "(@{$pair[0]}, @{$pair[1]})\n";
            }

            $importDDL .= sprintf($connectionsDdlTemplate, implode(',', $connectionValues));
        }

        // and last, add the visited cities
        if (!empty($importVisitedCities)) {
            // the user can visit the city multiple times but can give a single rating to it
            // userId+cityId is unique
            $visitedCitiesDdlTemplate = "INSERT INTO visitedcities (userId, cityId, rating) 
                                         VALUES %s
                                         ON DUPLICATE KEY UPDATE
                                         rating = VALUES(rating);
                                         ";

            $visitedCitiesValues = array();
            foreach ($importVisitedCities as $vc) {
                $visitedCitiesValues[] = sprintf("(@%s, @%s, %d)\n", $vc['userId'], $vc['cityId'], $vc['rating']);
            }

            $importDDL .= sprintf($visitedCitiesDdlTemplate, implode(',', $visitedCitiesValues));
        }

        // happy days!
    //    echo nl2br($importDDL);

        $importResult = $conn->query($importDDL);
        if (!$importResult) {
            echo 'Oops! Something went wrong. Import failed, heads must roll...';
        } else {
            echo 'Import finished successfully!';
        }
    }
}