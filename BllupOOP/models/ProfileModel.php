<?php

class ProfileModel extends Model {

    public function getProfileByUserId($user_id) {
        $stmt = $this->dbconn->prepare("SELECT * FROM user_profiles WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object();
    }

    public function createProfile($user_id, $email) {
        $stmt = $this->dbconn->prepare(
            "INSERT INTO user_profiles (user_id, email, fullname) VALUES (?, ?, '')"
        );
        $stmt->bind_param("is", $user_id, $email);
        return $stmt->execute();
    }

    public function syncEmailFromUsers($user_id) {
        // Sync email dari users table ke user_profiles
        $stmt = $this->dbconn->prepare(
            "UPDATE user_profiles SET email = (SELECT email FROM users WHERE id = ?) WHERE user_id = ?"
        );
        $stmt->bind_param("ii", $user_id, $user_id);
        return $stmt->execute();
    }

    public function updateProfile($data) {
        $sql = "UPDATE user_profiles SET 
            foto_profil = ?,
            foto_header = ?,
            fullname = ?, 
            nickname = ?, 
            email = ?, 
            gender = ?, 
            date_of_birth = ?, 
            phone_number = ?, 
            country = ?, 
            address = ?
        WHERE user_id = ?";

        $stmt = $this->dbconn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(
            "ssssssssssi",
            $data['foto_profil'],
            $data['foto_header'],
            $data['fullname'],
            $data['nickname'],
            $data['email'],
            $data['gender'],
            $data['date_of_birth'],
            $data['phone_number'],
            $data['country'],
            $data['address'],
            $data['user_id']
        );

        return $stmt->execute();
    }
}
