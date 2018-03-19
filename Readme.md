# Module de livraison Mondial Relay

Ce module vous permet de proposer à vos clients une livraison avec le transporteur Mondial Relay,
en point relais ou directement à domicile, en fonction des options disponibles
dans le pays de destination.

## Installation

Ajoutez le module depuis la page Modules de votre back-office, ou directement sur votre serveur si vous préférez. Vous
pouvez aussi utiliser composer : 

    composer require thelia/mondialrelay:~1.0

## Configuration

Par défaut, le module utilise des identifiants de test. Rendez-vous dans la configuration du module pour indiquer vos
propres identifiants Mondial Relay, et configurer les divers aspects du module.  

Lors de son installation, le module crée cinq zones de livraison, qui correspondent aux zones proposées par
Mondial Relay [sur la page des tarifs](http://www.mondialrelay.fr/envoi-de-colis/premiere-visite/#Tarifs "sur cette page").

Chacun de ces zones de livraison peut proposer la livraison en point relais, la livraison à domicile, ou les deux. 
Vous pouvez régler ceci dans l'onglet "Prix" de la configuration du module.

Pour chaque zone, vous pouvez définir des prix par tranche de poids. Ces prix sont initialisés l'installation du module 
avec les prix de mars 2018.

## Intégration

Le module utilise les hooks de Thelia, aucun travail d'intégration n'est nécessaire.

Pour une livraison en point relais, les caractéristiques du relais (numéro, coordonnées, horaires d'ouverture) sont 
communiquées à vos clients dans les e-mails, documents PDF et historique de commande.

## Notifications par email

Si vous avez saisi un numéro de suivi, une notification d'envoi est expédiée à vos clients lorsque la commande passe à
 l'état "envoyé". Vous pouvez modifier le contenu de ce mail dans les fichiers 
 `templates/email/default/mondial-relay-tracking-message.html` et `templates/email/default/mondial-relay-tracking-message.txt`
