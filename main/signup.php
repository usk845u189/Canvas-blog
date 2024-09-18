<?php
require_once("../config/function.php");

$csrf_token = generate_csrf_token();

require("../main/views/signup_view.php");