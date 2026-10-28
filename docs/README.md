# Modélisation

Ce dossier contient les images de la modélisation de l'application avecLesFemmes.

- `diagramme-classes.png` : diagramme de classes (entités Doctrine, enums, trait et relations)

## Entités

- `Role`, `Membre`, `Groupement`, `Exercice`
- `TypeCampagne`, `Campagne`, `ModeCotisation`
- `Seance`, `Cotisation`, `Amende`
- `CaisseSociale`, `MouvementCaisse`

## Enums

- `StatutExercice` : EN_COURS, CLOTURE
- `Periodicite` : HEBDOMADAIRE, BIMENSUEL, QUINZAINE, MENSUEL
- `TypePresence` : PRESENT, ABSENT_PAYE, ABSENT_NON_PAYE
- `TypeMouvement` : CAISSE_PRESENT, CAISSE_ABSENT, AMENDE, LOCATION, INTERET, COTISATION_CAISSE

## Trait

- `DateTimeTrait` : `createdAt` et `updatedAt`, remplis par les callbacks `PrePersist` et `PreUpdate`

## Règles de la caisse sociale

- Membre présent : cotisation + `caissePresent`
- Membre absent qui a envoyé sa cotisation : cotisation + `caisseAbsent`
- Membre absent qui n'a pas payé : amende de `amendeJour` par jour jusqu'au paiement
- Chaque entrée dans la caisse est un `MouvementCaisse`
