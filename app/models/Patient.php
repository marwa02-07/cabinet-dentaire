<?php

/**
 * Modèle Patient - Cabinet Dentaire
 * Gère les requêtes SQL pour les patients
 */

class Patient extends Model
{
    /**
     * Créer un nouveau patient
     */
    public function create($data)
    {
        try {
            $query = "INSERT INTO patients (user_id, age, telephone, adresse, date_naissance, groupe_sanguin, allergies, observations) 
                      VALUES (:user_id, :age, :telephone, :adresse, :date_naissance, :groupe_sanguin, :allergies, :observations)";
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':user_id', $data['user_id']);
            $stmt->bindParam(':age', $data['age']);
            $stmt->bindParam(':telephone', $data['telephone']);
            $stmt->bindParam(':adresse', $data['adresse']);
            $stmt->bindParam(':date_naissance', $data['date_naissance']);
            $stmt->bindParam(':groupe_sanguin', $data['groupe_sanguin']);
            $stmt->bindParam(':allergies', $data['allergies']);
            $stmt->bindParam(':observations', $data['observations']);
            
            $result = $stmt->execute();
            
            if (!$result) {
                error_log("Erreur lors de l'insertion du patient: " . json_encode($stmt->errorInfo()));
                return false;
            }
            
            return $this->pdo->lastInsertId();
            
        } catch (PDOException $e) {
            error_log("Erreur PDO lors de création patient: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Trouver un patient par user_id
     */
    public function findByUserId($user_id)
    {
        try {
            $query = "SELECT p.*, u.nom, u.prenom, u.email FROM patients p 
                     JOIN users u ON p.user_id = u.id 
                     WHERE p.user_id = :user_id LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
            
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Récupérer un patient par son identifiant
     */
    public function findById($id)
    {
        try {
            $query = "SELECT p.*, u.nom, u.prenom, u.email FROM patients p 
                     JOIN users u ON p.user_id = u.id 
                     WHERE p.id = :id LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Récupérer tous les patients avec infos utilisateur
     */
    public function findAll()
    {
        try {
            $query = "SELECT p.*, u.nom, u.prenom, u.email, u.created_at as inscription_date 
                     FROM patients p 
                     JOIN users u ON p.user_id = u.id 
                     ORDER BY u.created_at DESC";
            $stmt = $this->pdo->prepare($query);
            
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erreur PDO dans findAll: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Retourne le nombre total de patients
     */
    public function countAll()
    {
        try {
            $query = "SELECT COUNT(*) as cnt FROM patients";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)($row['cnt'] ?? 0);
        } catch (PDOException $e) {
            error_log("Erreur PDO dans countAll patients: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Rechercher des patients par nom, prénom, email ou téléphone
     */
    public function search($keyword)
    {
        try {
            $search = "%$keyword%";
            $query = "SELECT p.*, u.nom, u.prenom, u.email, u.telephone
                      FROM patients p
                      JOIN users u ON p.user_id = u.id
                      WHERE u.nom LIKE :search OR u.prenom LIKE :search OR u.email LIKE :search OR u.telephone LIKE :search
                      ORDER BY u.nom, u.prenom";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':search', $search);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erreur PDO dans search: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Mettre à jour un patient
     */
    public function update($id, $data)
    {
        try {
            $query = "UPDATE patients SET 
                      age = :age, 
                      telephone = :telephone, 
                      adresse = :adresse,
                      date_naissance = :date_naissance,
                      groupe_sanguin = :groupe_sanguin,
                      allergies = :allergies,
                      observations = :observations
                      WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':age', $data['age']);
            $stmt->bindParam(':telephone', $data['telephone']);
            $stmt->bindParam(':adresse', $data['adresse']);
            $stmt->bindParam(':date_naissance', $data['date_naissance']);
            $stmt->bindParam(':groupe_sanguin', $data['groupe_sanguin']);
            $stmt->bindParam(':allergies', $data['allergies']);
            $stmt->bindParam(':observations', $data['observations']);
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Erreur PDO dans update: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Récupérer les rendez-vous d'un patient
     */
    public function getRendezVous($patientId)
    {
        try {
            $query = "SELECT rv.*, d.specialite as dentiste_specialite, u.nom as dentiste_nom, u.prenom as dentiste_prenom
                      FROM rendez_vous rv
                      JOIN dentistes d ON rv.dentiste_id = d.id
                      JOIN users u ON d.user_id = u.id
                      WHERE rv.patient_id = ?
                      ORDER BY rv.date_heure DESC";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$patientId]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erreur PDO dans getRendezVous: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Récupérer les 2 prochains rendez-vous d'un patient (non passés)
     * Trie du plus proche au plus loin
     */
    public function getNextRendezVous($patientId, $limit = 2)
    {
        try {
            $now = date('Y-m-d H:i:s');
            
            $query = "SELECT rv.*, d.specialite as dentiste_specialite, u.nom as dentiste_nom, u.prenom as dentiste_prenom
                      FROM rendez_vous rv
                      JOIN dentistes d ON rv.dentiste_id = d.id
                      JOIN users u ON d.user_id = u.id
                      WHERE rv.patient_id = :patient_id
                      AND rv.statut != 'annulé'
                      AND rv.date_heure > :now
                      ORDER BY rv.date_heure ASC
                      LIMIT :limit";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':patient_id', $patientId, PDO::PARAM_INT);
            $stmt->bindParam(':now', $now);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erreur PDO dans getNextRendezVous: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Récupérer les consultations d'un patient
     */
    public function getConsultations($patientId)
    {
        try {
            $query = "SELECT c.*, u.nom as dentiste_nom, u.prenom as dentiste_prenom
                      FROM consultations c
                      JOIN dentistes d ON c.dentiste_id = d.id
                      JOIN users u ON d.user_id = u.id
                      WHERE c.patient_id = ?
                      ORDER BY c.created_at DESC";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$patientId]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erreur PDO dans getConsultations: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Supprimer un patient
     */
    public function delete($id)
    {
        try {
            $query = "DELETE FROM patients WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur PDO dans delete: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Récupérer les factures d'un patient
     */
    public function getFactures($patientId)
    {
        try {
            $query = "SELECT * FROM factures WHERE patient_id = ? ORDER BY date_facture DESC";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$patientId]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erreur PDO dans getFactures: " . $e->getMessage());
            return [];
        }
    }
}
