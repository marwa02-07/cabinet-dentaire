<?php

/**
 * Modèle Medecin
 * Gère les requêtes SQL pour les médecins
 */

class Medecin extends Model
{
    /**
     * Créer un nouveau médecin
     */
    public function create($data)
    {
        try {
            $query = "INSERT INTO dentistes (user_id, specialite, numero_licence, telephone, cabinet) 
                     VALUES (:user_id, :specialite, :numero_licence, :telephone, :cabinet)";
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':user_id', $data['user_id']);
            $stmt->bindParam(':specialite', $data['specialite']);
            $stmt->bindParam(':numero_licence', $data['numero_licence']);
            $stmt->bindParam(':telephone', $data['telephone']);
            $stmt->bindParam(':cabinet', $data['cabinet']);
            
            $result = $stmt->execute();
            
            if (!$result) {
                error_log("Erreur lors de l'insertion du médecin: " . json_encode($stmt->errorInfo()));
                return false;
            }
            
            $lastId = $this->pdo->lastInsertId();
            error_log("Médecin créé avec succès. ID: " . $lastId . ", User ID: " . $data['user_id']);
            
            return $lastId;
            
        } catch (PDOException $e) {
            error_log("Erreur PDO lors de création médecin: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Trouver un médecin par user_id
     */
    public function findByUserId($user_id)
    {
        try {
            $query = "SELECT * FROM dentistes WHERE user_id = :user_id LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':user_id', $user_id);
            
            $stmt->execute();
            
            $medecin = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $medecin ?: false;
            
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Récupérer un médecin par son id
     */
    public function getById($id)
    {
        try {
            $query = "SELECT d.*, u.nom, u.prenom, u.email FROM dentistes d 
                     JOIN users u ON d.user_id = u.id 
                     WHERE d.id = :id LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $medecin = $stmt->fetch(PDO::FETCH_ASSOC);
            return $medecin ?: false;
        } catch (PDOException $e) {
            error_log("Erreur PDO getById medecin: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Récupérer tous les médecins
     */
    public function findAll()
    {
        try {
            $query = "SELECT d.*, u.nom, u.prenom, u.email FROM dentistes d 
                     JOIN users u ON d.user_id = u.id 
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
     * Récupérer tous les dentistes (alias de findAll)
     */
    public function getAll()
    {
        return $this->findAll();
    }
    
    /**
     * Récupérer les dentistes par spécialité
     * Utilise une correspondance flexible basée sur des mots-clés
     */
    public function getBySpecialite($specialite)
    {
        try {
            $specialiteNormalized = ConsultationTypeCatalog::normalize($specialite);
            if ($specialiteNormalized === '') {
                return [];
            }

            $allDentistes = $this->findAll();
            $filtered = [];
            foreach ($allDentistes as $dentiste) {
                if (ConsultationTypeCatalog::matches($dentiste['specialite'] ?? '', $specialiteNormalized)) {
                    $filtered[] = $dentiste;
                }
            }

            return $filtered;
        } catch (PDOException $e) {
            error_log("Erreur PDO getBySpecialite: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Vérifier qu'un dentiste correspond à une spécialité
     * Utilise une correspondance flexible basée sur des mots-clés
     */
    public function verifySpecialite($dentiste_id, $specialite)
    {
        try {
            // Récupérer le dentiste
            $query = "SELECT * FROM dentistes WHERE id = :id LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $dentiste_id);
            $stmt->execute();
            $dentiste = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$dentiste) {
                return false;
            }

            return ConsultationTypeCatalog::matches($dentiste['specialite'] ?? '', $specialite) ? $dentiste : false;
            
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Supprimer un médecin
     */
    public function delete($id)
    {
        try {
            $query = "DELETE FROM dentistes WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':id', $id);
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Mettre à jour un médecin
     */
    public function update($id, $data)
    {
        try {
            // Récupérer le user_id du médecin
            $medecin = $this->getById($id);
            if (!$medecin) {
                return false;
            }
            $user_id = $medecin['user_id'];
            
            // Préparer les valeurs
            $specialite = $data['specialite'] ?? '';
            $telephone = $data['telephone'] ?? '';
            $numero_licence = $data['numero_licence'] ?? '';
            $cabinet = $data['cabinet'] ?? null;
            
            // Mise à jour dans la table dentistes
            $query = "UPDATE dentistes SET specialite = :specialite, telephone = :telephone, numero_licence = :numero_licence";
            
            // Ajouter cabinet seulement s'il est fourni
            if ($cabinet !== null) {
                $query .= ", cabinet = :cabinet";
            }
            $query .= " WHERE id = :id";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':specialite', $specialite);
            $stmt->bindParam(':telephone', $telephone);
            $stmt->bindParam(':numero_licence', $numero_licence);
            
            if ($cabinet !== null) {
                $stmt->bindParam(':cabinet', $cabinet);
            }
            
            $result = $stmt->execute();
            
            if ($result && isset($data['nom'])) {
                // Préparer les valeurs utilisateur
                $nom = $data['nom'];
                $prenom = $data['prenom'];
                $email = $data['email'];
                
                // Mise à jour dans la table users
                $queryUser = "UPDATE users SET nom = :nom, prenom = :prenom, email = :email WHERE id = :user_id";
                $stmtUser = $this->pdo->prepare($queryUser);
                $stmtUser->bindParam(':nom', $nom);
                $stmtUser->bindParam(':prenom', $prenom);
                $stmtUser->bindParam(':email', $email);
                $stmtUser->bindParam(':user_id', $user_id);
                $stmtUser->execute();
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Erreur PDO update medecin: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Trouver un médecin par son id
     */
    public function find($id)
    {
        return $this->getById($id);
    }
    
    /**
     * Récupérer les rendez-vous d'un médecin
     */
    public function getRendezVous($medecin_id)
    {
        try {
            $query = "SELECT rv.*, p.*, 
                            rv.id as rdv_id, 
                            p.id as rdv_patient_id,
                            u.nom as patient_nom, u.prenom as patient_prenom 
                     FROM rendez_vous rv
                     JOIN patients p ON rv.patient_id = p.id
                     JOIN users u ON p.user_id = u.id
                     WHERE rv.dentiste_id = :medecin_id 
                     AND rv.statut != 'annulé'
                     ORDER BY rv.date_heure ASC";
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':medecin_id', $medecin_id);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            return [];
        }
    }
    
    /**
     * Récupérer les 2 prochains rendez-vous d'un médecin (non passés)
     * Trie du plus proche au plus loin
     */
    public function getNextRendezVous($medecin_id, $limit = 2)
    {
        try {
            $now = date('Y-m-d H:i:s');
            
            $query = "SELECT rv.*, p.*, u.nom as patient_nom, u.prenom as patient_prenom,
                            rv.id as rdv_id, p.id as rdv_patient_id
                     FROM rendez_vous rv
                     JOIN patients p ON rv.patient_id = p.id
                     JOIN users u ON p.user_id = u.id
                     WHERE rv.dentiste_id = :medecin_id 
                     AND rv.statut NOT IN ('annulé', 'complété', 'absent')
                     AND DATE(rv.date_heure) = CURDATE()
                     AND rv.date_heure > :now
                     ORDER BY rv.date_heure ASC
                     LIMIT :limit";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':medecin_id', $medecin_id, PDO::PARAM_INT);
            $stmt->bindParam(':now', $now);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erreur PDO getNextRendezVous: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Récupérer les consultations d'un médecin
     */
    public function getConsultations($medecin_id)
    {
        try {
            $query = "SELECT c.*, rv.date_heure, p.*, u.nom as patient_nom, u.prenom as patient_prenom 
                     FROM consultations c
                     JOIN rendez_vous rv ON c.rendez_vous_id = rv.id
                     JOIN patients p ON rv.patient_id = p.id
                     JOIN users u ON p.user_id = u.id
                     WHERE c.dentiste_id = :medecin_id
                     ORDER BY rv.date_heure DESC";
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':medecin_id', $medecin_id);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            return [];
        }
    }
}
