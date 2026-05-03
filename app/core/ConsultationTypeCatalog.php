<?php

/**
 * Source unique des types de consultation/specialites.
 */
class ConsultationTypeCatalog
{
    private const TYPES = [
        'consultation' => 'Consultation',
        'nettoyage' => 'Nettoyage',
        'extraction' => 'Extraction',
        'traitement' => 'Traitement',
        'blanchiment' => 'Blanchiment',
        'radio' => 'Radio',
        'autre' => 'Autre',
    ];

    public static function getTypes(): array
    {
        return self::TYPES;
    }

    public static function getLabels(): array
    {
        return array_values(self::TYPES);
    }

    public static function normalize(?string $value): string
    {
        if ($value === null) {
            return '';
        }

        $normalized = strtolower(trim($value));
        if ($normalized === '') {
            return '';
        }

        $map = [];
        foreach (self::TYPES as $key => $label) {
            $map[$key] = $key;
            $map[strtolower($label)] = $key;
        }

        return $map[$normalized] ?? '';
    }

    public static function isValid(?string $value): bool
    {
        return self::normalize($value) !== '';
    }

    public static function getLabel(?string $value): string
    {
        $key = self::normalize($value);
        if ($key === '') {
            return '';
        }

        return self::TYPES[$key];
    }

    public static function matches(?string $specialite, ?string $type): bool
    {
        $specialiteKey = self::normalize($specialite);
        $typeKey = self::normalize($type);

        return $specialiteKey !== '' && $specialiteKey === $typeKey;
    }
}
