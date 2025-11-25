<?php
// models/User.php

class User extends Model {
    
    /**
     * Get user by email
     */
    public function getByEmail($email) {
        $stmt = $this->dbconn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object();
    }
    
    /**
     * Get user by ID
     */
    public function getById($id) {
        $stmt = $this->dbconn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object();
    }
    
    /**
     * Create new user (Register)
     */
    public function create($email, $password) {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert user
        $stmt = $this->dbconn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hashedPassword);
        
        if ($stmt->execute()) {
            $user_id = $this->dbconn->insert_id;
            
            // Create user profile automatically
            $this->createUserProfile($user_id, $email);
            
            return $user_id;
        }
        
        return false;
    }
    
    /**
     * Create user profile
     */
    private function createUserProfile($user_id, $email) {
        $stmt = $this->dbconn->prepare("INSERT INTO user_profiles (user_id, email, fullname) VALUES (?, ?, '')");
        $stmt->bind_param("is", $user_id, $email);
        return $stmt->execute();
    }
    
    /**
     * Update user password
     */
    public function updatePassword($id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        $stmt = $this->dbconn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashedPassword, $id);
        
        return $stmt->execute();
    }
    
    /**
     * Verify password
     */
    public function verifyPassword($id, $password) {
        $user = $this->getById($id);
        
        if ($user) {
            return password_verify($password, $user->password);
        }
        
        return false;
    }
    
    /**
     * Generate password reset token
     */
    public function generatePasswordResetToken($id) {
        // Generate random token
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Check if password_resets table exists, if not create it
        $this->createPasswordResetsTableIfNotExists();
        
        // Delete old tokens for this user
        $stmt = $this->dbconn->prepare("DELETE FROM password_resets WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // Insert new token
        $stmt = $this->dbconn->prepare("INSERT INTO password_resets (user_id, token, expiry) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $id, $token, $expiry);
        
        if ($stmt->execute()) {
            return $token;
        }
        
        return false;
    }
    
    /**
     * Verify password reset token
     */
    public function verifyPasswordResetToken($token) {
        $stmt = $this->dbconn->prepare("SELECT * FROM password_resets WHERE token = ? AND expiry > NOW()");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_object();
    }
    
    /**
     * Reset password with token
     */
    public function resetPasswordWithToken($token, $newPassword) {
        // Verify token
        $resetRequest = $this->verifyPasswordResetToken($token);
        
        if (!$resetRequest) {
            return false;
        }
        
        // Update password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->dbconn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashedPassword, $resetRequest->user_id);
        
        if ($stmt->execute()) {
            // Delete used token
            $stmt = $this->dbconn->prepare("DELETE FROM password_resets WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Delete user account
     */
    public function delete($id) {
        // Delete user profile first (because of foreign key)
        $stmt = $this->dbconn->prepare("DELETE FROM user_profiles WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // Delete user
        $stmt = $this->dbconn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    /**
     * Check if email exists
     */
    public function emailExists($email) {
        $stmt = $this->dbconn->prepare("SELECT COUNT(*) as count FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['count'] > 0;
    }
    
    /**
     * Get all users with their profiles
     */
    public function getAll() {
        $sql = "SELECT u.id, u.email, up.fullname, up.nickname, up.foto_profil, up.phone_number 
                FROM users u 
                LEFT JOIN user_profiles up ON u.id = up.user_id 
                ORDER BY u.id DESC";
        
        $result = $this->dbconn->query($sql);
        
        $users = [];
        while ($row = $result->fetch_object()) {
            $users[] = $row;
        }
        
        return $users;
    }
    
    /**
     * Get user with profile
     */
    public function getUserWithProfile($id) {
        $sql = "SELECT u.*, up.* 
                FROM users u 
                LEFT JOIN user_profiles up ON u.id = up.user_id 
                WHERE u.id = ?";
        
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_object();
    }
    
    /**
     * Create password_resets table if not exists
     */
    private function createPasswordResetsTableIfNotExists() {
        $sql = "CREATE TABLE IF NOT EXISTS password_resets (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            token VARCHAR(255) NOT NULL UNIQUE,
            expiry DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_user_id (user_id),
            INDEX idx_token (token)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
        
        $this->dbconn->query($sql);
    }
}