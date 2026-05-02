<?php

/**
 * Modèle Ordonnance
 * Gère les requêtes SQL pour les ordonnances
 */

class Ordonnance extends Model
{
    public function create($data)
    {
        try {
            $num_ordonnance = $data['num_ordonnance'] ?? $this->generateNumero();

            // Préparer les valeurs avec validation
            $patient_id = (int)$data['patient_id'];
            $dentiste_id = (int)$data['dentiste_id'];
            $rendez_vous_id = isset($data['rendez_vous_id']) && $data['rendez_vous_id'] > 0 ? (int)$data['rendez_vous_id'] : null;
            
            // Consultation_id: accepter soit entier soit chaîne numérique
            $consultation_id_raw = $data['consultation_id'] ?? null;
            if (is_numeric($consultation_id_raw)) {
                $consultation_id = (int)$consultation_id_raw;
            } elseif (is_int($consultation_id_raw) && $consultation_id_raw > 0) {
                $consultation_id = $consultation_id_raw;
            } else {
                $consultation_id = null;
            }
            
            // ========== DEBUG: Log des valeurs reçues ==========
            error_log("╔════════════════════════════════════════════════╗");
            error_log("║ 🟢 ORDONNANCE MODEL: Réception données          ║");
            error_log("╚════════════════════════════════════════════════╝");
            error_log("► patient_id: " . $patient_id);
            error_log("► dentiste_id: " . $dentiste_id);
            error_log("► rendez_vous_id: " . var_export($rendez_vous_id, true));
            error_log("► consultation_id brut: " . var_export($consultation_id_raw, true));
            error_log("► consultation_id type: " . gettype($consultation_id_raw));
            error_log("► consultation_id converti: " . var_export($consultation_id, true));
            
            // 🔴 VALIDATION STRICTE: consultation_id requis pour création d'ordonnance liée
            if ($consultation_id === null || $consultation_id <= 0) {
                error_log("╔════════════════════════════════════════════════╗");
                error_log("║ ❌ ERREUR: consultation_id manquant ou invalide ║");
                error_log("╚════════════════════════════════════════════════╝");
                error_log("► Valeur reçue: " . var_export($consultation_id_raw, true));
                error_log("► Type reçu: " . gettype($consultation_id_raw));
                throw new Exception('consultation_id manquant ou invalide');
            }
            
            error_log("► ✓ consultation_id validé: " . $consultation_id);
            $date_creation = $data['date_creation'] ?? date('Y-m-d');
            $instructions = $data['instructions'] ?? '';
            $recommandations = $data['recommandations'] ?? '';

            $query = "INSERT INTO ordonnances (
                        patient_id,
                        dentiste_id,
                        rendez_vous_id,
                        consultation_id,
                        num_ordonnance,
                        date_creation,
                        instructions,
                        recommandations,
                        created_at
                    ) VALUES (
                        :patient_id,
                        :dentiste_id,
                        :rendez_vous_id,
                        :consultation_id,
                        :num_ordonnance,
                        :date_creation,
                        :instructions,
                        :recommandations,
                        NOW()
                    )";

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);
            $stmt->bindParam(':dentiste_id', $dentiste_id, PDO::PARAM_INT);
            
            // Gestion explicite des valeurs NULL pour les clés étrangères
            if ($rendez_vous_id !== null) {
                $stmt->bindValue(':rendez_vous_id', $rendez_vous_id, PDO::PARAM_INT);
            } else {
                $stmt->bindValue(':rendez_vous_id', null, PDO::PARAM_NULL);
            }
            
            if ($consultation_id !== null) {
                $stmt->bindValue(':consultation_id', $consultation_id, PDO::PARAM_INT);
            } else {
                $stmt->bindValue(':consultation_id', null, PDO::PARAM_NULL);
            }
            
            $stmt->bindParam(':num_ordonnance', $num_ordonnance);
            $stmt->bindParam(':date_creation', $date_creation);
            $stmt->bindParam(':instructions', $instructions);
            $stmt->bindParam(':recommandations', $recommandations);

            $result = $stmt->execute();
            if (!$result) {
                $errorInfo = $stmt->errorInfo();
                error_log("=== ERREUR ORDONNANCE CREATE ===");
                error_log("SQLSTATE: " . ($errorInfo[0] ?? 'unknown'));
                error_log("Code erreur: " . ($errorInfo[1] ?? 'unknown'));
                error_log("Message: " . ($errorInfo[2] ?? 'unknown'));
                error_log("Données: patient_id=$patient_id, dentiste_id=$dentiste_id, consultation_id=$consultation_id");
                return false;
            }

            $lastId = $this->pdo->lastInsertId();
            error_log("Ordonnance créée avec ID: $lastId, consultation_id: $consultation_id");
            return $lastId;
        } catch (PDOException $e) {
            error_log("=== ERREUR PDO ORDONNANCE CREATE ===");
            error_log("Message: " . $e->getMessage());
            error_log("Code: " . $e->getCode());
            return false;
        }
    }

    /**
     * Récupérer une ordonnance par consultation
     */
    public function findByConsultationId($consultation_id)
    {
        try {
            $query = "SELECT * FROM ordonnances WHERE consultation_id = :consultation_id LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':consultation_id', $consultation_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
        } catch (PDOException $e) {
            error_log("Erreur PDO Ordonnance findByConsultationId: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Génère un numéro d'ordonnance unique
     */
    private function generateNumero()
    {
        $date = date('Ymd');
        $random = strtoupper(substr(md5(uniqid('', true)), 0, 6));
        return "ORD-{$date}-{$random}";
    }
}
