<?php

function h($sql){
    return htmlspecialchars($sql, ENT_QUOTES);
}