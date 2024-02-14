<?php

$columns = require "src/assets/columns.php";

$getColumnLetter = function ($colName) use ($columns) {
    if (key_exists($colName, $columns)) {
        return $columns[$colName];
    } else {
        return "";
    }
};

