<?php

Config::Set('db.table.user_ignore', '___db.table.prefix___user_ignore');

return array(
    'comments' => true, // игнорировать комментарии
    'topics' => true, // игнорировать топики
    'disallow_ignore' => array() // ID пользователей, запрещенных игнорировать
);