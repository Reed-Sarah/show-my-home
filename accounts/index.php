<?php

/* Accounts Controller*/

session_start();
include_once "../model/accounts.php";
include_once "../library/functions.php";
include_once "../library/connection.php";

$db = connectDB();

$action = filter_input(INPUT_POST, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
 }

 switch ($action){
    case 'account':
      include '../views/login.php';
     break;
     case 'register':
      include '../views/register.php';
     break;
     case 'Login':
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
      $user_password = filter_input(INPUT_POST, 'user_password', FILTER_SANITIZE_STRING);  
      $email = checkEmail($email);
      $checkPassword = checkPassword($user_password);
     
      if(empty($email) || empty($checkPassword)){
        $_SESSION["message"] = '<p>Missing or invalid email or password, please try again.</p>';
        include '../views/login.php';
        exit; 
       }

       // A valid password exists, proceed with the login process
// Query the user data based on the email address
$userData = getUser($email, $db);

// Compare the password just submitted against
// the hashed password for the matching user
$hashCheck = password_verify($user_password, $userData['user_password']);
// If the hashes don't match create an error
// and return to the login view
if(!$hashCheck) {
  $_SESSION['message'] = '<p class="notice">Please check your password and try again.</p>';
  include '../views/login.php';
  exit;
}
// A valid user exists, log them in
$_SESSION['loggedin'] = TRUE;
echo $_SESSION['loggedin'];
// Remove the password from the array
// the array_pop function removes the last
// element from an array
array_pop($userData);
// Store the array into the session
$_SESSION['userData'] = $userData;
// Send them to the home page
//include '../../week3/';
header('location: /week3/');
exit;
     break;
     case 'createAccount':
      $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
$last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$user_password = filter_input(INPUT_POST, 'user_password', FILTER_SANITIZE_STRING);  
$email = checkEmail($email, $db);
$checkPassword = checkPassword($user_password, $db);

// Check if account already exists
$existingEmail = checkForAccount($email, $db);

// Check for existing email address in the table
if($existingEmail){
 $_SESSION['message'] = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
 include '../views/login.php';
 exit;
}
// Check for missing data
if(empty($first_name) || empty($last_name) || empty($email) || empty($checkPassword)){
  $message = '<p>*Please provide information for all empty form fields.</p>';
  include '../views/register.php';
  exit; 
 }

// Hash the checked password
$hashedPassword = password_hash($user_password, PASSWORD_DEFAULT);

 // Send the data to the model
$regOutcome = regUser($first_name, $last_name, $email, $hashedPassword, $db);

// Check and report the result
if($regOutcome === 1){
  setcookie('firstname', $first_name, strtotime('+1 year'), '/');
  $_SESSION['message'] = "<p>$first_name, Thanks for registering. Please use your email and password to login.</p>";
  header('Location: /week3/accounts/?action=account');
 
  exit;
 } else {
  $message = "<p>Sorry $first_name, but the registration failed. Please try again.</p>";
  include '../views/registration.php';
  exit;
 }
     break;
     case 'Logout':
      session_destroy(); 
      header('Location: /week3/');
      exit;
    break;
    case 'accountUpdate':
      $user_id = $_SESSION['userData']['user_id'];//filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $userInfo = getUserInfo($user_id);
      include '../views/manage-account.php';
      exit;
    break;
    case 'updateAccountInfo':
      $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
      $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
      $email = checkEmail($email);
      $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
  
      if ($email != $_SESSION['userData']['email'])
      {
        // Check if account already exists
      $existingEmail = checkForAccount($email, $db);
      // Check for existing email address in the table
      if($existingEmail){
       $_SESSION['message'] = '<p class="notice">*That email address already exists. </p>';
       include '../views/manage-account.php';
       exit;
      }
      }
      // Check for missing data
      if(empty($first_name) || empty($last_name) || empty($email)){
        $message = '<p>*Please provide information for all empty form fields.</p>';
        include '../views/manage-account.php';
        exit; 
       }
      
       // Send the data to the model
      $updateUser = updateUser($first_name, $last_name, $email, $user_id, $db);
      
      // Check and report the result
      if($updateUser === 1){
        setcookie('firstname', $first_name, strtotime('+1 year'), '/');
        $_SESSION['message'] = "<p>$first_name, your account was successfully updated</p>";
      
        $userInfo = getUserInfo($user_id, $db);
        $_SESSION['userData'] = $userInfo;
        include '../views/manage-account.php';
        //header('Location: /week3/accounts/');
        exit;
       } else {
        $message = "<p>Sorry $first_name, the update failed. Please try again.</p>";
        include '../views/manage-account.php';
        exit;
       }
    break;
    case 'changePassword':
      $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
      $user_password = filter_input(INPUT_POST, 'user_password', FILTER_SANITIZE_STRING);
      $checkPassword = checkPassword($user_password);
      
      if(empty($checkPassword)){
        $message = '<p>*Missing or invalid password.</p>';
        include '../views/manage-account.php';
        exit; 
       }
       $hashedPassword = password_hash($user_password, PASSWORD_DEFAULT);
       $changePassword = changePassword($hashedPassword, $user_id, $db);

// Check and report the result
if($changePassword === 1){
  $_SESSION['message'] = "<p>Your password was successfully changed.</p>";
  header('Location: /week3/accounts');
 
  exit;
 } else {
  $message = "<p>The password change failed. Please try again.</p>";
  include '../views/admin.php';
  exit;
 }
    break;
    case 'userUpdate':
      include '../views/manage-account.php';
      exit;
      break;
    default:
   
    include '../views/login.php';
  exit;
    break;
   }
 ?>