# avecLesFemmes

Application Symfony de gestion des calebasses participatives (épargne et tontine) pour des groupements de femmes.
Projet réalisé par **Abdoulaye Togo** dans le cadre du cours de Symfony.

## Prérequis

- PHP 8.2 ou plus (testé avec PHP 8.3), extensions requises activées dans `php.ini`
- Composer
- Symfony CLI
- Git
- MySQL / MariaDB

Vérifier la machine :

```bash
php -v
composer --version
symfony check:requirements
```

## Installation après un clone

```bash
git clone <url-du-depot>
cd avecLesFemmes
composer install
cp .env .env.local      # puis renseigner ses propres identifiants de base de données
```

Le fichier `.env` est versionné avec des valeurs génériques. Chaque développeur met ses vraies valeurs dans `.env.local`, qui n'est jamais poussé sur Git. Le dossier `vendor/` n'est pas versionné : `composer install` le reconstruit à partir de `composer.lock`.

## Modélisation

Le diagramme de classes se trouve dans [`docs/`](docs/).

## Branches

Une branche par étape du travail. `main` contient toujours une version qui fonctionne.

| Branche | Contenu attendu |
|---|---|
| `feature/commandes-composer` | Commandes `togoabdoulaye:db:create`, `togoabdoulaye:cache:clear`, `togoabdoulaye:make:entity`, `togoabdoulaye:migration` dans `composer.json` |
| `feature/entite-role` | Entité `Role` |
| `feature/entite-membre` | Entité `Membre` (relation vers `Role`) |
| `feature/entite-groupement` | Entité `Groupement` |
| `feature/entite-type-campagne` | Entité `TypeCampagne` |
| `feature/entite-campagne` | Entité `Campagne` (relation vers `TypeCampagne`) |
| `feature/entite-mode-cotisation` | Entité `ModeCotisation` (relations vers `Membre` et `Campagne`) |
| `feature/entite-seance` | Entité `Seance` |
| `feature/migration` | Génération et exécution des migrations |
| `feature/fixtures` | Fausses données pour alimenter la base |

### Cycle de travail sur une branche

```bash
git checkout feature/entite-role
git merge main                      # récupérer le travail déjà fusionné
# ... travailler ...
git add -A
git commit -m "feat: création de l'entité Role"
git checkout main
git merge feature/entite-role
git push origin main feature/entite-role
```

## Convention de commits

Un commit par action réalisée :

- `feat:` nouvelle fonctionnalité ou nouvelle entité
- `chore:` configuration, dépendances, outillage
- `docs:` documentation, diagrammes
- `fix:` correction
