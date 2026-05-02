<?php

/**
 * Mod�le RendezVous
 * G�re les requ�tes SQL pour les rendez-vous
 */

class RendezVous extends Model
{
    /**
     * Vérifier si un patient a déjà un rendez-vous à cette date/heure
     * Empêche les rendez-vous doublons
     */
    public function checkConflict($patient_id, $date_heure, $exclude_id = null)
    {
        try {
            $query = "SELECT * FROM rendez_vous 
                     WHERE patient_id = :patient_id 
                     AND date_heure = :date_heure 
                     AND statut != 'annulé'";
            
            // Exclure un rendez-vous spécifique (pour modification)
            if ($exclude_id !== null) {
                $query .= " AND id != :exclude_id";
            }
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':patient_id', $patient_id);
            $stmt->bindParam(':date_heure', $date_heure);
            
            if ($exclude_id !== null) {
                $stmt->bindParam(':exclude_id', $exclude_id);
            }
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result ?: false;
            
        } catch (PDOException $e) {
            error_log("Erreur PDO checkConflict: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Vérifier si un patient a déjà un rendez-vous dans la même heure
     */
    public function checkConflictSameHour($patient_id, $date_heure, $exclude_id = null)
    {
        try {
            $query = "SELECT * FROM rendez_vous 
                     WHERE patient_id = :patient_id 
                     AND DATE_FORMAT(date_heure, '%Y-%m-%d %H') = DATE_FORMAT(:date_heure, '%Y-%m-%d %H') 
                     AND statut != 'annulé'";
            
            if ($exclude_id !== null) {
                $query .= " AND id != :exclude_id";
            }
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':patient_id', $patient_id);
            $stmt->bindParam(':date_heure', $date_heure);
            
            if ($exclude_id !== null) {
                $stmt->bindParam(':exclude_id', $exclude_id);
            }
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result ?: false;
        } catch (PDOException $e) {
            error_log("Erreur PDO checkConflictSameHour: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Vérifier les chevauchements de rendez-vous (niveau avancé)
     * Prend en compte la durée du rendez-vous
     */
    public function checkOverlap($patient_id, $date_heure, $duree_minutes, $exclude_id = null)
    {
        try {
            // Calculer les timestamps de début et fin du nouveau rendez-vous
            $nouveau_debut = $date_heure;
            $nouveau_fin = date('Y-m-d H:i:s', strtotime($date_heure . ' + ' . $duree_minutes . ' minutes'));
            
            $query = "SELECT * FROM rendez_vous
                     WHERE patient_id = :patient_id
                     AND statut != 'annulé'
                     AND (
                        -- Exactement le même horaire
                        date_heure = :date_heure
                        OR (
                            -- Chevauche avec un rendez-vous existant
                            date_heure < :nouveau_fin
                            AND DATE_ADD(date_heure, INTERVAL duree_minutes MINUTE) > :nouveau_debut
                        )
                     )";
            
            // Exclure un rendez-vous spécifique (pour modification)
            if ($exclude_id !== null) {
                $query .= " AND id != :exclude_id";
            }
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':patient_id', $patient_id);
            $stmt->bindParam(':date_heure', $date_heure);
            $stmt->bindParam(':nouveau_debut', $nouveau_debut);
            $stmt->bindParam(':nouveau_fin', $nouveau_fin);
            
            if ($exclude_id !== null) {
                $stmt->bindParam(':exclude_id', $exclude_id);
            }
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result ?: false;
            
        } catch (PDOException $e) {
            error_log("Erreur PDO checkOverlap: " . $e->getMessage());
            return false;
        }
    }
    
    /**     * Récupérer les rendez-vous d'un patient
     */
    public function getByPatientId($patient_id)
    {
        try {
            $query = "SELECT rv.*, d.specialite as dentiste_specialite, u.nom as dentiste_nom, u.prenom as dentiste_prenom
                     FROM rendez_vous rv
                     LEFT JOIN dentistes d ON rv.dentiste_id = d.id
                     LEFT JOIN users u ON d.user_id = u.id
                     WHERE rv.patient_id = :patient_id
                     ORDER BY rv.date_heure DESC";
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
     * Récupérer un rendez-vous par son identifiant
     */
    public function getById($id)
    {
        try {
            $query = "SELECT * FROM rendez_vous WHERE id = :id LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur PDO getById: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Récupérer tous les rendez-vous d'un médecin
     */
    public function getByMedecinId($medecin_id)
    {
        try {
            $query = "SELECT r.id as rdv_id, r.patient_id as rdv_patient_id, r.dentiste_id, 
                            r.date_heure, r.duree_minutes, r.motif, r.type_rendez_vous, 
                            r.statut, r.notes, r.created_at,
                            p.id as p_id, p.user_id as p_user_id, p.age, p.telephone, p.adresse, 
                            p.date_naissance, p.groupe_sanguin, p.allergies, p.observations,
                            u.nom as patient_nom, u.prenom as patient_prenom
                     FROM rendez_vous r
                     JOIN patients p ON p.id = r.patient_id
                     JOIN users u ON p.user_id = u.id
                     WHERE r.dentiste_id = :medecin_id
                     AND r.statut != 'annulé'
                     ORDER BY r.date_heure ASC";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':medecin_id', $medecin_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur PDO getByMedecinId: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Met à jour le statut d'un rendez-vous
     */
    private function translateStatusToFrench($status)
    {
        $map = [
            'pending' => 'planifié',
            'confirmed' => 'confirmé',
            'cancelled' => 'annulé',
            'completed' => 'complété',
            'absent' => 'absent',
            'planifié' => 'planifié',
            'confirmé' => 'confirmé',
            'annulé' => 'annulé',
            'complété' => 'complété',
            'absent' => 'absent'
        ];

        return $map[$status] ?? $status;
    }

    private function translateStatusToEnglish($status)
    {
        $map = [
            'planifié' => 'pending',
            'confirmé' => 'confirmed',
            'annulé' => 'cancelled',
            'complété' => 'completed',
            'absent' => 'absent',
            'pending' => 'pending',
            'confirmed' => 'confirmed',
            'cancelled' => 'cancelled',
            'completed' => 'completed',
            'absent' => 'absent'
        ];

        return $map[$status] ?? $status;
    }

    public function updateStatus($id, $status)
    {
        try {
            $englishStatus = $this->translateStatusToEnglish($status);
            $frenchStatus = $this->translateStatusToFrench($status);
            $updateBoth = in_array($englishStatus, ['pending', 'confirmed', 'cancelled'], true);

            if ($updateBoth) {
                $query = "UPDATE rendez_vous SET status = :status, statut = :statut WHERE id = :id";
            } else {
                $query = "UPDATE rendez_vous SET statut = :statut WHERE id = :id";
            }

            error_log("=== RendezVous::updateStatus ===");
            error_log("SQL: " . $query);
            error_log("id: " . $id . ", status: " . $status);
            $stmt = $this->pdo->prepare($query);

            if ($updateBoth) {
                $stmt->bindParam(':status', $englishStatus);
            }

            $stmt->bindParam(':statut', $frenchStatus);
            $stmt->bindParam(':id', $id);
            $result = $stmt->execute();
            error_log("Rows affected: " . $stmt->rowCount());
            return $result;
        } catch (PDOException $e) {
            error_log("Erreur PDO updateStatus: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Vérifier qu'un patient est associé à un médecin via un rendez-vous
     */
    public function existsForMedecinPatient($medecin_id, $patient_id)
    {
        try {
            $query = "SELECT 1 FROM rendez_vous WHERE dentiste_id = :medecin_id AND patient_id = :patient_id LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':medecin_id', $medecin_id);
            $stmt->bindParam(':patient_id', $patient_id);
            $stmt->execute();
            return (bool) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Erreur PDO existsForMedecinPatient: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Créer un nouveau rendez-vous
     */
    public function create($data)
    {
        try {
            $query = "INSERT INTO rendez_vous (patient_id, dentiste_id, secretaire_id, date_heure, duree_minutes, motif, type_rendez_vous, status, statut) 
                      VALUES (:patient_id, :dentiste_id, :secretaire_id, :date_heure, :duree_minutes, :motif, :type_rendez_vous, 'pending', 'planifié')";
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':patient_id', $data['patient_id']);
            $stmt->bindParam(':dentiste_id', $data['dentiste_id']);
            $stmt->bindParam(':secretaire_id', $data['secretaire_id']);
            $stmt->bindParam(':date_heure', $data['date_heure']);
            $stmt->bindParam(':duree_minutes', $data['duree_minutes']);
            $stmt->bindParam(':motif', $data['motif']);
            $stmt->bindParam(':type_rendez_vous', $data['type_rendez_vous']);
            
            $result = $stmt->execute();
            
            if (!$result) {
                error_log("Erreur lors de l'insertion du rendez-vous: " . json_encode($stmt->errorInfo()));
                return false;
            }
            
            return $this->pdo->lastInsertId();
            
        } catch (PDOException $e) {
            error_log("Erreur PDO lors de création rendez-vous: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Compter les rendez-vous d'un médecin entre deux dates
     */
    public function countByMedecinBetween($medecin_id, $start, $end)
    {
        try {
            $query = "SELECT COUNT(*) as cnt FROM rendez_vous WHERE dentiste_id = :mid AND date_heure BETWEEN :start AND :end";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':mid', $medecin_id);
            $stmt->bindParam(':start', $start);
            $stmt->bindParam(':end', $end);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)($row['cnt'] ?? 0);
        } catch (PDOException $e) {
            error_log("Erreur PDO countByMedecinBetween: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Compter tous les rendez-vous pour un médecin
     */
    public function countByMedecin($medecin_id)
    {
        try {
            $query = "SELECT COUNT(*) as cnt FROM rendez_vous WHERE dentiste_id = :mid";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':mid', $medecin_id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)($row['cnt'] ?? 0);
        } catch (PDOException $e) {
            error_log("Erreur PDO countByMedecin: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Compter les patients distincts pour un m�decin
     */
    public function countDistinctPatientsByMedecin($medecin_id)
    {
        try {
            $query = "SELECT COUNT(DISTINCT patient_id) as cnt FROM rendez_vous WHERE dentiste_id = :mid";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':mid', $medecin_id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)($row['cnt'] ?? 0);
        } catch (PDOException $e) {
            error_log("Erreur PDO countDistinctPatientsByMedecin: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Compter tous les rendez-vous cette semaine (pour secr�taire)
     */
    public function countThisWeek($start, $end)
    {
        try {
            $query = "SELECT COUNT(*) as cnt FROM rendez_vous WHERE date_heure BETWEEN :start AND :end";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':start', $start);
            $stmt->bindParam(':end', $end);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)($row['cnt'] ?? 0);
        } catch (PDOException $e) {
            error_log("Erreur PDO countThisWeek (RendezVous): " . $e->getMessage());
            return 0;
        }
    }
    /**
     * Compter les rendez-vous par date
     */
    public function countByDate($start, $end)
    {
        try {
            $query = "SELECT COUNT(*) as cnt FROM rendez_vous WHERE date_heure BETWEEN :start AND :end";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':start', $start);
            $stmt->bindParam(':end', $end);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)($row['cnt'] ?? 0);
        } catch (PDOException $e) {
            error_log("Erreur PDO countByDate: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Compter les rendez-vous par statut
     */
    public function countByStatus($status)
    {
        try {
            $englishStatus = $this->translateStatusToEnglish($status);
            $frenchStatus = $this->translateStatusToFrench($status);
            $query = "SELECT COUNT(*) as cnt FROM rendez_vous WHERE status = :status OR statut = :statut";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':status', $englishStatus);
            $stmt->bindParam(':statut', $frenchStatus);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)($row['cnt'] ?? 0);
        } catch (PDOException $e) {
            error_log("Erreur PDO countByStatus: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Récupérer tous les rendez-vous
     */
    public function getAll()
    {
        try {
            $query = "SELECT rv.*, 
                            p.user_id as patient_user_id,
                            u_patient.nom as patient_nom, u_patient.prenom as patient_prenom,
                            d.id as dentiste_id, d.specialite as dentiste_specialite,
                            u_dentiste.nom as dentiste_nom, u_dentiste.prenom as dentiste_prenom
                     FROM rendez_vous rv
                     LEFT JOIN patients p ON rv.patient_id = p.id
                     LEFT JOIN users u_patient ON p.user_id = u_patient.id
                     LEFT JOIN dentistes d ON rv.dentiste_id = d.id
                     LEFT JOIN users u_dentiste ON d.user_id = u_dentiste.id
                     ORDER BY rv.date_heure DESC";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur PDO getAll: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupérer les rendez-vous à venir
     */
    public function getUpcoming()
    {
        try {
            $query = "SELECT rv.*, 
                            p.user_id as patient_user_id,
                            u_patient.nom as patient_nom, u_patient.prenom as patient_prenom,
                            d.id as dentiste_id, d.specialite as dentiste_specialite,
                            u_dentiste.nom as dentiste_nom, u_dentiste.prenom as dentiste_prenom
                     FROM rendez_vous rv
                     LEFT JOIN patients p ON rv.patient_id = p.id
                     LEFT JOIN users u_patient ON p.user_id = u_patient.id
                     LEFT JOIN dentistes d ON rv.dentiste_id = d.id
                     LEFT JOIN users u_dentiste ON d.user_id = u_dentiste.id
                     WHERE rv.date_heure >= NOW()
                     AND rv.statut != 'annulé'
                     ORDER BY rv.date_heure ASC";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur PDO getUpcoming: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupérer les rendez-vous passés
     */
    public function getPast()
    {
        try {
            $query = "SELECT rv.*, 
                            p.user_id as patient_user_id,
                            u_patient.nom as patient_nom, u_patient.prenom as patient_prenom,
                            d.id as dentiste_id, d.specialite as dentiste_specialite,
                            u_dentiste.nom as dentiste_nom, u_dentiste.prenom as dentiste_prenom
                     FROM rendez_vous rv
                     LEFT JOIN patients p ON rv.patient_id = p.id
                     LEFT JOIN users u_patient ON p.user_id = u_patient.id
                     LEFT JOIN dentistes d ON rv.dentiste_id = d.id
                     LEFT JOIN users u_dentiste ON d.user_id = u_dentiste.id
                     WHERE rv.date_heure < NOW()
                     ORDER BY rv.date_heure DESC";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur PDO getPast: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupérer les rendez-vous par plage de dates
     */
    public function getByDateRange($start, $end)
    {
        try {
            $query = "SELECT rv.*, 
                            p.user_id as patient_user_id,
                            u_patient.nom as patient_nom, u_patient.prenom as patient_prenom,
                            d.id as dentiste_id, d.specialite as dentiste_specialite,
                            u_dentiste.nom as dentiste_nom, u_dentiste.prenom as dentiste_prenom
                     FROM rendez_vous rv
                     LEFT JOIN patients p ON rv.patient_id = p.id
                     LEFT JOIN users u_patient ON p.user_id = u_patient.id
                     LEFT JOIN dentistes d ON rv.dentiste_id = d.id
                     LEFT JOIN users u_dentiste ON d.user_id = u_dentiste.id
                     WHERE rv.date_heure BETWEEN :start AND :end
                     ORDER BY rv.date_heure ASC";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':start', $start);
            $stmt->bindParam(':end', $end);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur PDO getByDateRange: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Vérifier les conflits de dentiste
     * Prend en compte la durée pour éviter les chevauchements
     */
    public function checkDentistConflict($dentiste_id, $date_heure, $exclude_id = null, $duree_minutes = 30)
    {
        try {
            // Calculer les timestamps de début et fin du nouveau rendez-vous
            $nouveau_debut = $date_heure;
            $nouveau_fin = date('Y-m-d H:i:s', strtotime($date_heure . ' + ' . $duree_minutes . ' minutes'));
            
            $query = "SELECT * FROM rendez_vous 
                     WHERE dentiste_id = :dentiste_id 
                     AND statut != 'annulé'
                     AND (
                        -- Exactement le même horaire
                        date_heure = :date_heure
                        OR (
                            -- Chevauche avec un rendez-vous existant
                            date_heure < :nouveau_fin
                            AND DATE_ADD(date_heure, INTERVAL duree_minutes MINUTE) > :nouveau_debut
                        )
                     )";
            
            if ($exclude_id !== null) {
                $query .= " AND id != :exclude_id";
            }
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':dentiste_id', $dentiste_id);
            $stmt->bindParam(':date_heure', $date_heure);
            $stmt->bindParam(':nouveau_debut', $nouveau_debut);
            $stmt->bindParam(':nouveau_fin', $nouveau_fin);
            
            if ($exclude_id !== null) {
                $stmt->bindParam(':exclude_id', $exclude_id);
            }
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result ?: false;
            
        } catch (PDOException $e) {
            error_log("Erreur PDO checkDentistConflict: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Récupérer les rendez-vous par dentiste et date
     */
    public function getByDentisteAndDate($dentiste_id, $start, $end)
    {
        try {
            $query = "SELECT rv.*, 
                            p.user_id as patient_user_id,
                            u_patient.nom as patient_nom, u_patient.prenom as patient_prenom,
                            d.id as dentiste_id, d.specialite as dentiste_specialite,
                            u_dentiste.nom as dentiste_nom, u_dentiste.prenom as dentiste_prenom
                     FROM rendez_vous rv
                     LEFT JOIN patients p ON rv.patient_id = p.id
                     LEFT JOIN users u_patient ON p.user_id = u_patient.id
                     LEFT JOIN dentistes d ON rv.dentiste_id = d.id
                     LEFT JOIN users u_dentiste ON d.user_id = u_dentiste.id
                     WHERE rv.dentiste_id = :dentiste_id
                     AND rv.date_heure BETWEEN :start AND :end
                     ORDER BY rv.date_heure ASC";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':dentiste_id', $dentiste_id);
            $stmt->bindParam(':start', $start);
            $stmt->bindParam(':end', $end);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur PDO getByDentisteAndDate: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Mettre à jour un rendez-vous
     */
    public function update($id, $data)
    {
        try {
            $query = "UPDATE rendez_vous SET 
                      patient_id = :patient_id,
                      dentiste_id = :dentiste_id,
                      date_heure = :date_heure,
                      duree_minutes = :duree_minutes,
                      motif = :motif,
                      type_rendez_vous = :type_rendez_vous
                      WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            
            $stmt->bindParam(':patient_id', $data['patient_id']);
            $stmt->bindParam(':dentiste_id', $data['dentiste_id']);
            $stmt->bindParam(':date_heure', $data['date_heure']);
            $stmt->bindParam(':duree_minutes', $data['duree_minutes']);
            $stmt->bindParam(':motif', $data['motif']);
            $stmt->bindParam(':type_rendez_vous', $data['type_rendez_vous']);
            $stmt->bindParam(':id', $id);
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Erreur PDO update: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Supprimer un rendez-vous
     */
    public function delete($id)
    {
        try {
            $query = "DELETE FROM rendez_vous WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur PDO delete: " . $e->getMessage());
            return false;
        }
    }}

?>
