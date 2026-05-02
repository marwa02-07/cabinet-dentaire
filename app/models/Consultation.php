<?php

/**
 * Mod�le Consultation
 * G�re les requ�tes SQL pour les consultations
 */

class Consultation extends Model
{
    /**
     * Récupérer la dernière consultation d'un patient
     */
    public function getLastByPatientId($patient_id)
    {
        try {
            $query = "SELECT c.* FROM consultations c 
                      WHERE c.patient_id = :patient_id 
                      ORDER BY c.created_at DESC LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
        } catch (PDOException $e) {
            error_log("Erreur PDO getLastByPatientId: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Récupérer une consultation par ID de rendez-vous
     */
    public function getByRendezVousId($rendez_vous_id)
    {
        try {
            $query = "SELECT c.* FROM consultations c WHERE c.rendez_vous_id = :rendez_vous_id LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':rendez_vous_id', $rendez_vous_id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur PDO getByRendezVousId: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Récupérer les consultations d'un patient
     */
    public function getByPatientId($patient_id)
    {
        try {
            $query = "SELECT c.*, rv.date_heure, rv.motif, rv.type_rendez_vous, d.specialite as dentiste_specialite, u.nom as dentiste_nom, u.prenom as dentiste_prenom
                     FROM consultations c
                     LEFT JOIN rendez_vous rv ON c.rendez_vous_id = rv.id
                     LEFT JOIN dentistes d ON c.dentiste_id = d.id
                     LEFT JOIN users u ON d.user_id = u.id
                     WHERE c.patient_id = :patient_id
                     ORDER BY c.created_at DESC";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':patient_id', $patient_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur PDO getByPatientId: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Créer une nouvelle consultation
     */
    public function create($data)
    {
        try {
            $query = "INSERT INTO consultations (rendez_vous_id, dentiste_id, patient_id, diagnostic, traitement_effectue, traitement_prevu, dents_traitees, prix, notes) 
                      VALUES (:rendez_vous_id, :dentiste_id, :patient_id, :diagnostic, :traitement_effectue, :traitement_prevu, :dents_traitees, :prix, :notes)";
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':rendez_vous_id', $data['rendez_vous_id']);
            $stmt->bindParam(':dentiste_id', $data['dentiste_id']);
            $stmt->bindParam(':patient_id', $data['patient_id']);
            $stmt->bindParam(':diagnostic', $data['diagnostic']);
            $stmt->bindParam(':traitement_effectue', $data['traitement_effectue']);
            $stmt->bindParam(':traitement_prevu', $data['traitement_prevu']);
            $stmt->bindParam(':dents_traitees', $data['dents_traitees']);
            $stmt->bindParam(':prix', $data['prix']);
            $stmt->bindParam(':notes', $data['notes']);
            
            $result = $stmt->execute();
            
            if (!$result) {
                error_log("Erreur lors de l'insertion de la consultation: " . json_encode($stmt->errorInfo()));
                return false;
            }
            
            $lastId = $this->pdo->lastInsertId();
            // Forcer en entier pour éviter les problèmes de type
            $lastId = $lastId ? (int)$lastId : 0;
            error_log("Consultation créée avec ID: $lastId (type: " . gettype($lastId) . ")");
            return $lastId;
            
        } catch (PDOException $e) {
            error_log("Erreur PDO lors de création consultation: " . $e->getMessage());
            return false;
        }
    }
    
    /**     * Compter les consultations cette semaine pour un m�decin
     */
    public function countThisWeekByMedecin($medecin_id, $start, $end)
    {
        try {
            $query = "SELECT COUNT(*) as cnt FROM consultations c \
                     JOIN rendez_vous rv ON c.rendez_vous_id = rv.id \
                     WHERE c.dentiste_id = :mid AND rv.date_heure BETWEEN :start AND :end";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':mid', $medecin_id);
            $stmt->bindParam(':start', $start);
            $stmt->bindParam(':end', $end);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)($row['cnt'] ?? 0);
        } catch (PDOException $e) {
            error_log("Erreur PDO countThisWeekByMedecin: " . $e->getMessage());
            return 0;
        }
    }
}

?>
