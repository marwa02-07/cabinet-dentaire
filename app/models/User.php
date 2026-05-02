<?php

/**
 * Modèle User
 * Gère les requêtes SQL pour l'utilisateur
 */

class User extends Model
{
    /**
     * Rechercher un utilisateur par email
     */
    public function findByEmail($email)
    {
        try {
            // Vérifier que l'email n'est pas vide
            if (empty($email)) {
                return false;
            }
            
            // Normaliser l'email (lowercase)
            $email = strtolower(trim($email));
            
            // Requête préparée
            $query = "SELECT * FROM users WHERE LOWER(email) = :email LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            
            // Lier le paramètre
            $stmt->bindParam(':email', $email);
            
            // Exécuter
            $stmt->execute();
            
            // Récupérer le résultat
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $user ?: false;
            
        } catch (PDOException $e) {
            error_log("Erreur PDO dans findByEmail: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Erreur dans findByEmail: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Créer un nouvel utilisateur
     */
    public function create($data)
    {
        try {
            // Normaliser l'email
            $data['email'] = strtolower(trim($data['email']));
            
            $query = "INSERT INTO users (nom, prenom, email, password, role) VALUES (:nom, :prenom, :email, :password, :role)";
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':nom', $data['nom']);
            $stmt->bindParam(':prenom', $data['prenom']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', $data['password']);
            $stmt->bindParam(':role', $data['role']);
            
            $result = $stmt->execute();
            
            if (!$result) {
                error_log("Erreur lors de l'insertion de l'utilisateur: " . json_encode($stmt->errorInfo()));
                return false;
            }
            
            $lastId = $this->pdo->lastInsertId();
            error_log("Utilisateur créé avec succès. ID: " . $lastId . ", Email: " . $data['email']);
            
            return $lastId;
            
        } catch (PDOException $e) {
            error_log("Erreur PDO lors de création utilisateur: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Supprimer un utilisateur
     */
    public function delete($id)
    {
        try {
            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':id', $id);
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Récupérer tous les utilisateurs
     */
    public function findAll()
    {
        try {
            $query = "SELECT * FROM users ORDER BY nom, prenom";
            $stmt = $this->pdo->prepare($query);
            
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erreur PDO dans findAll: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update($id, $data)
    {
        try {
            $fields = [];
            $params = [':id' => $id];
            
            if (isset($data['nom'])) {
                $fields[] = 'nom = :nom';
                $params[':nom'] = $data['nom'];
            }
            if (isset($data['prenom'])) {
                $fields[] = 'prenom = :prenom';
                $params[':prenom'] = $data['prenom'];
            }
            if (isset($data['email'])) {
                $fields[] = 'email = :email';
                $emailValue = strtolower(trim($data['email']));
                $params[':email'] = $emailValue;
            }
            if (isset($data['password'])) {
                $fields[] = 'password = :password';
                $params[':password'] = $data['password'];
            }
            
            if (empty($fields)) {
                return false;
            }
            
            $query = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Erreur PDO dans update: " . $e->getMessage());
            return false;
        }
    }
}
