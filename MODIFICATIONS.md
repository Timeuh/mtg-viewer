# Modifications

## 0 Complétion de l'import
### Modifications apportées :

- Ajout du chronométrage de la commande d'import de carte
- Utilisation de getAllUuids dans le CardRepository pour ne pas fetch les cartes dans la base de données à chaque ajout de carte
- Passage de flush à toutes les 2000 cartes ajoutées au lieu d'à toutes les cartes
- Utilisation du flag --no-debug à l'exécution de la commande d'import de carte

