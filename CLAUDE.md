# Contexte — moncreneau-php

SDK client officiel PHP pour l'API MonCréneau (`moncreneau/moncreneau-php`, publié sur Packagist).

## Contenu

Client basé sur clé API (`mk_live_...`), PSR-4, client HTTP Guzzle, gestion d'erreurs (`MoncreneauException`), vérification de signature webhook. Exemple d'intégration Laravel fourni dans le README. Ressources : `appointments`, `departments`.

## Publication

```bash
cd moncreneau-php
# Update composer.json version, tag Git, Packagist se synchronise via webhook GitHub
```

## Documentation complète

https://moncreneau-docs.vercel.app/docs/v1/sdks/php (voir aussi `moncreneau-docs/`)

## À maintenir en synchro avec

L'API publique exposée par `rdv/` (backend).
