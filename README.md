# 3dw17-groupeA

Le repo pour le projet de symfony du groupe A avec les membres Ruben BARROS et Romain VIDON

Ajouter ou Mettre à jour une entité :
php bin/console make:entity

Préparer les données pour l'envoi dans la bdd :
php bin/console make:migration

Initialiser la bdd et pousser les migrations sur la bdd :
php bin/console doctrine:migrations:migrate


(RAPPEL) Types pour la création d'entité sur Doctrine :
string,
integer,
boolean,
date,
float,
time,
datetime,
object,
array,