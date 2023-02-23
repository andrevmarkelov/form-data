<?php

namespace App\Models;

use ItvisionSy\SimpleORM\DataModel;

class FormData extends DataModel
{
// CREATE TABLE IF NOT EXISTS  form_data (
// form_data_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
// length int(10) UNSIGNED NOT NULL DEFAULT 0,
// height int(10) UNSIGNED NOT NULL DEFAULT 0,
// depth int(10) UNSIGNED NOT NULL DEFAULT 0,
// PRIMARY KEY (form_data_id),
// UNIQUE KEY length_idx (length)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8

    protected static $tableName = 'form_data';

    protected static $pkColumn = 'form_data_id';
}
