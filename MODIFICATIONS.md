# Modifications

## 0 Complétion de l'import
### Modifications apportées :

- Ajout du chronométrage de la commande d'import de carte
- Utilisation de getAllUuids dans le CardRepository pour ne pas fetch les cartes dans la base de données à chaque ajout de carte
- Passage de flush à toutes les 2000 cartes ajoutées au lieu d'à toutes les cartes
- Utilisation du flag --no-debug à l'exécution de la commande d'import de carte

## 1 Ajout de logs
### Modifications apportées :

- Ajout de logs pour chaque appel à l'API card
- Ajout de logs en cas de carte introuvable
- Ajout de logs pour le début, la fin, la durée et les erreurs de l'import de carte
