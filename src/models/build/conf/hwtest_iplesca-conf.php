<?php
// This file generated by Propel 1.6.9 convert-conf target
// from XML runtime conf file D:\webprojects\hostelworld\HwTest\src\models\runtime-conf.xml
$conf = array (
  'datasources' => 
  array (
    'hwtest_iplesca' => 
    array (
      'adapter' => 'mysql',
      'connection' => 
      array (
        'dsn' => 'mysql:host=localhost;dbname=hwtest_iplesca',
        'user' => 'root',
        'password' => '',
      ),
    ),
    'default' => 'hwtest_iplesca',
  ),
  'generator_version' => '1.6.9',
);
$conf['classmap'] = include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classmap-hwtest_iplesca-conf.php');
return $conf;