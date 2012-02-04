<?php

if (!class_exists('Config')) die('Hacking attempt!');

Config::Set('db.table.user_ignore', '___db.table.prefix___user_ignore');

return array(
    'comments' => true, // игнорировать комментарии
    'topics' => true, // игнорировать топики
    'disallow_ignore' => array(1) // ID пользователей, которых запрещено игнорировать
);