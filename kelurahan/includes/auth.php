<?php
session_start();

// Database connection (assuming it's in db.php)
require_once 'db.php';

/**
* Verify admin credentials and create session
*/
function authenticateAdmin($username, $password) {
   $conn = connectDB();
   
   try {
       $stmt = $conn->prepare("SELECT id, username, password_hash FROM admin_users WHERE username = ? AND is_active = 1 LIMIT 1");
       $stmt->bind_param("s", $username);
       $stmt->execute();
       $result = $stmt->get_result();
       $user = $result->fetch_assoc();
       
       if ($user && password_verify($password, $user['password_hash'])) {
           // Create session
           $_SESSION['admin_id'] = $user['id'];
           $_SESSION['admin_username'] = $user['username'];
           $_SESSION['admin_last_activity'] = time();
           
           // Update last login timestamp
           $updateStmt = $conn->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
           $updateStmt->bind_param("i", $user['id']);
           $updateStmt->execute();
           
           $updateStmt->close();
           $stmt->close();
           $conn->close();
           return true;
       }
       
       $stmt->close();
       $conn->close();
       return false;
   } catch (Exception $e) {
       error_log("Authentication error: " . $e->getMessage());
       return false;
   }
}

/**
* Check if user is logged in as admin
*/
function isAdminLoggedIn() {
   // Check if admin session exists and is not expired
   if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_last_activity'])) {
       // Check for session timeout (30 minutes)
       $timeout = 30 * 60; // 30 minutes in seconds
       
       if (time() - $_SESSION['admin_last_activity'] > $timeout) {
           logoutAdmin();
           return false;
       }
       
       // Update last activity time
       $_SESSION['admin_last_activity'] = time();
       return true;
   }
   
   return false;
}

/**
* Logout admin user and destroy session
*/
function logoutAdmin() {
   // Unset all session variables
   $_SESSION = array();
   
   // Destroy the session cookie
   if (isset($_COOKIE[session_name()])) {
       setcookie(session_name(), '', time() - 3600, '/');
   }
   
   // Destroy the session
   session_destroy();
}

/**
* Change admin password
*/
function changeAdminPassword($adminId, $currentPassword, $newPassword) {
   $conn = connectDB();
   
   try {
       // Verify current password
       $stmt = $conn->prepare("SELECT password_hash FROM admin_users WHERE id = ?");
       $stmt->bind_param("i", $adminId);
       $stmt->execute();
       $result = $stmt->get_result();
       $user = $result->fetch_assoc();
       
       if (!$user || !password_verify($currentPassword, $user['password_hash'])) {
           $stmt->close();
           $conn->close();
           return false;
       }
       
       // Update password
       $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
       $updateStmt = $conn->prepare("UPDATE admin_users SET password_hash = ? WHERE id = ?");
       $updateStmt->bind_param("si", $newPasswordHash, $adminId);
       $updateStmt->execute();
       
       $updateStmt->close();
       $stmt->close();
       $conn->close();
       return true;
   } catch (Exception $e) {
       error_log("Password change error: " . $e->getMessage());
       return false;
   }
}

/**
* Create new admin user
*/
function createAdmin($username, $password, $isActive = true) {
   $conn = connectDB();
   
   try {
       // Check if username already exists
       $checkStmt = $conn->prepare("SELECT id FROM admin_users WHERE username = ?");
       $checkStmt->bind_param("s", $username);
       $checkStmt->execute();
       $result = $checkStmt->get_result();
       if ($result->fetch_assoc()) {
           $checkStmt->close();
           $conn->close();
           return false; // Username already exists
       }
       
       // Create new admin user
       $passwordHash = password_hash($password, PASSWORD_DEFAULT);
       $active = $isActive ? 1 : 0;
       $stmt = $conn->prepare("INSERT INTO admin_users (username, password_hash, is_active, created_at) VALUES (?, ?, ?, NOW())");
       $stmt->bind_param("ssi", $username, $passwordHash, $active);
       $stmt->execute();
       
       $stmt->close();
       $checkStmt->close();
       $conn->close();
       return true;
   } catch (Exception $e) {
       error_log("Admin creation error: " . $e->getMessage());
       return false;
   }
}

/**
* Validate password strength
*/
function validatePasswordStrength($password) {
   // Password must be at least 8 characters long and contain:
   // - At least one uppercase letter
   // - At least one lowercase letter
   // - At least one number
   // - At least one special character
   $uppercase = preg_match('@[A-Z]@', $password);
   $lowercase = preg_match('@[a-z]@', $password);
   $number = preg_match('@[0-9]@', $password);
   $special = preg_match('@[^\w]@', $password);
   
   return strlen($password) >= 8 && $uppercase && $lowercase && $number && $special;
}