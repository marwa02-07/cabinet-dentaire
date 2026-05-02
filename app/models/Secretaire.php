<?php

/**
 * Modèle Secretaire
 * Gère les requêtes SQL pour les secrétaires
 */

class Secretaire extends Model
{
    /**
     * Créer une nouvelle secrétaire
     */
    public function create($data)
    {
        try {
            $query = "INSERT INTO secretaires (user_id, telephone, departement)
                     VALUES (:user_id, :telephone, :departement)";
            $stmt = $this->pdo->prepare($query);

            $stmt->bindParam(':user_id', $data['user_id']);
            $stmt->bindParam(':telephone', $data['telephone']);
            $stmt->bindParam(':departement', $data['departement']);

            $result = $stmt->execute();

            if (!$result) {
                error_log("Erreur lors de l'insertion de la secrétaire: " . json_encode($stmt->errorInfo()));
                return false;
            }

            $lastId = $this->pdo->lastInsertId();
            error_log("Secrétaire créée avec succès. ID: " . $lastId . ", User ID: " . $data['user_id']);

            return $lastId;

        } catch (PDOException $e) {
            error_log("Erreur PDO lors de création secrétaire: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Trouver une secrétaire par user_id
     */
    public function findByUserId($user_id)
    {
        try {
            $query = "SELECT * FROM secretaires WHERE user_id = :user_id LIMIT 1";
            $stmt = $this->pdo->prepare($query);

            $stmt->bindParam(':user_id', $user_id);

            $stmt->execute();

            $secretaire = $stmt->fetch(PDO::FETCH_ASSOC);

            return $secretaire ?: false;

        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Récupérer toutes les secrétaires
     */
    public function findAll()
    {
        try {
            $query = "SELECT s.*, u.nom, u.prenom, u.email FROM secretaires s
                     JOIN users u ON s.user_id = u.id
                     ORDER BY u.nom, u.prenom";
            $stmt = $this->pdo->prepare($query);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Erreur PDO dans findAll: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Supprimer une secrétaire
     */
    public function delete($id)
    {
        try {
            $query = "DELETE FROM secretaires WHERE id = :id";
            $stmt = $this->pdo->prepare($query);

            $stmt->bindParam(':id', $id);

            return $stmt->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Mettre à jour une secrétaire
     */
    public function update($id, $data)
    {
        try {
            // Récupérer la secrétaire avec les infos user
            $secretaire = $this->getById($id);
            if (!$secretaire) {
                return false;
            }
            $user_id = $secretaire['user_id'];
            
            // Mise à jour dans la table secretaires
            $query = "UPDATE secretaires SET telephone = :telephone, departement = :departement WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindValue(':telephone', $data['telephone']);
            $stmt->bindValue(':departement', $data['departement'] ?? null);
            $result = $stmt->execute();
            
            if ($result && isset($data['nom'])) {
                // Mise à jour dans la table users
                $queryUser = "UPDATE users SET nom = :nom, prenom = :prenom, email = :email WHERE id = :user_id";
                $stmtUser = $this->pdo->prepare($queryUser);
                $stmtUser->bindValue(':nom', $data['nom']);
                $stmtUser->bindValue(':prenom', $data['prenom']);
                $stmtUser->bindValue(':email', $data['email']);
                $stmtUser->bindParam(':user_id', $user_id);
                $stmtUser->execute();
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Erreur PDO update secretaire: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Trouver une secrétaire par son id
     */
    public function find($id)
    {
        return $this->getById($id);
    }
    
    /**
     * Récupérer une secrétaire par son id
     */
    public function getById($id)
    {
        try {
            $query = "SELECT s.*, u.nom, u.prenom, u.email FROM secretaires s 
                     JOIN users u ON s.user_id = u.id 
                     WHERE s.id = :id LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $secretaire = $stmt->fetch(PDO::FETCH_ASSOC);
            return $secretaire ?: false;
        } catch (PDOException $e) {
            error_log("Erreur PDO getById secretaire: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Récupérer les patients gérés par une secrétaire
     */
    public function getPatients()
    {
        try {
            $query = "SELECT p.*, u.nom, u.prenom, u.email FROM patients p
                     JOIN users u ON p.user_id = u.id
                     ORDER BY u.nom, u.prenom";
            $stmt = $this->pdo->prepare($query);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Récupérer les rendez-vous
     */
    public function getRendezVous()
    {
        try {
            $query = "SELECT rv.*, m.*, u_med.nom as medecin_nom, u_med.prenom as medecin_prenom,
                             p.*, u_pat.nom as patient_nom, u_pat.prenom as patient_prenom
                     FROM rendez_vous rv
                     JOIN medecins m ON rv.medecin_id = m.id
                     JOIN users u_med ON m.user_id = u_med.id
                     JOIN patients pat ON rv.patient_id = pat.id
                     JOIN users u_pat ON pat.user_id = u_pat.id
                     ORDER BY rv.date_heure DESC";
            $stmt = $this->pdo->prepare($query);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Récupérer les médecins
     */
    public function getMedecins()
    {
        try {
            $query = "SELECT m.*, u.nom, u.prenom FROM medecins m
                     JOIN users u ON m.user_id = u.id
                     ORDER BY u.nom, u.prenom";
            $stmt = $this->pdo->prepare($query);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }
}
