<?php
require_once("../config/function.php");

$csrf_token = generate_csrf_token();

require("../views/signin_view.php");