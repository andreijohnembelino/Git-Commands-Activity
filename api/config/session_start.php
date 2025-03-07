<?php
session_start();
if (!isset($_SESSION['client_id']) && !isset($_SESSION['user_id'])) {
    die(json_encode(["success" => false, "message" => "Unauthorized access"]));
}
?>
