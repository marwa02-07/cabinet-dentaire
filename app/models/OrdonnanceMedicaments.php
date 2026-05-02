<?php

/**
 * Modèle OrdonnanceMedicaments
 * Gère les médicaments associés à une ordonnance
 */

class OrdonnanceMedicaments extends Model
{
    /**
     * Créer plusieurs médicaments pour une ordonnance
     */
    public function createMany($ordonnance_id, array $medicaments)
    {
        try {
            $query = "INSERT INTO ordonnance_medicaments (
                        ordonnance_id,
                        nom_medicament,
                        dosage,
                        frequence,
                        duree,
                        instructions_medicament,
                        created_at
                    ) VALUES (
                        :ordonnance_id,
                        :nom_medicament,
                        :dosage,
                        :frequence,
                        :duree,
                        :instructions_medicament,
                        NOW()
                    )";

            $stmt = $this->pdo->prepare($query);
            foreach ($medicaments as $medicament) {
                if (empty($medicament['nom_medicament'])) {
                    continue;
                }

                $dosage = trim($medicament['dosage'] ?? 'Non précisé');
                $frequence = trim($medicament['frequence'] ?? 'Non précisé');

                $stmt->bindParam(':ordonnance_id', $ordonnance_id, PDO::PARAM_INT);
                $stmt->bindParam(':nom_medicament', $medicament['nom_medicament']);
                $stmt->bindParam(':dosage', $dosage);
                $stmt->bindParam(':frequence', $frequence);
                $stmt->bindValue(':duree', trim($medicament['duree'] ?? '') ?: null);
                $stmt->bindValue(':instructions_medicament', trim($medicament['instructions_medicament'] ?? '') ?: null);
                $stmt->execute();
            }

            return true;
        } catch (PDOException $e) {
            error_log("Erreur PDO OrdonnanceMedicaments createMany: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Récupérer les médicaments d'une ordonnance
     */
    public function getByOrdonnanceId($ordonnance_id)
    {
        try {
            $query = "SELECT * FROM ordonnance_medicaments WHERE ordonnance_id = :ordonnance_id ORDER BY id ASC";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':ordonnance_id', $ordonnance_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur PDO OrdonnanceMedicaments getByOrdonnanceId: " . $e->getMessage());
            return [];
        }
    }
}
