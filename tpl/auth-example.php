<?php
// Passwords in an array for now because I'm lazy
$validpass = array("alsoavalidpassword", "thisisvalidtoo", "andthisoneisvalidalso");

session_start();
// First we see if they're wanting to log out
// If they do we unset that and redirect them to the login page
if ($_GET['logout'] == 'true') {
        $_SESSION['authenticated'] = 'false';
        session_destroy();
        header("Location: login.php");
        }

// Check if we should be letting them in, or not
$pass = $_POST['pass'];
if (in_array($pass, $validpass)) {
        // User is trying to login, so let's remember that
        $authenticated = 'true';
        $_SESSION['authenticated'] = "true";
        }
elseif ($_SESSION['authenticated'] != "true") {
        // We check like this to ensure if the user is returning to the main page
        // And not from the login page, then we can return them
        // If they're already authenticated we don't wanna log them out though
        header("Location: login.php");
        }

// Config file included here as the last thing to include once authenticated
require_once('config.php');

?>
