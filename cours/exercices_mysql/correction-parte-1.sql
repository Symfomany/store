SELECT title, synopsis
FROM movies
WHERE duree >= 3 AND (distributeur = 'Warner_Bros' OR distributeur = 'HBO')

SELECT title, synopsis, annee, languages, visible, cover
FROM movies
WHERE languages = 'fr' AND visible = 1 AND cover = 1

SELECT title, synopsis, description, budget
FROM movies
WHERE budget > 1000000

SELECT title, synopsis, year(date_release)
FROM movies
WHERE date_release between '2014-01-01' AND '2014-12-31'
order by date_release desc
limit 5

SELECT title, date_release
FROM movies
WHERE date_release >= '2015-01-01' AND (note_presse between 3 and 5)

SELECT firstname, lastname
FROM actors
WHERE year(dob) between 1970 and 1979

SELECT lastname
FROM actors
WHERE city = 'New York'

SELECT firstname, lastname
FROM directors
WHERE dob > '1963-06-20'

SELECT content, date_created, state
FROM comments
WHERE state = 1
order by date_created desc
limit 10

SELECT *
FROM medias
WHERE video regexp '<iframe'

SELECT *
FROM movies
WHERE shop is null

SELECT title, ville
FROM cinema
WHERE ville in ('Paris 4eme','Paris 2eme')

SELECT ville, title
FROM cinema
WHERE (title LIKE '%Path\é%'
OR title LIKE '%UGC%')
AND date_created = YEAR(NOW())-1
AND MONTH(date_created) >= 2

SELECT content, note
FROM comments
WHERE content IS NOT NULL
AND note < 4

SELECT *
FROM tags
WHERE CHAR_LENGTH(word) > 5

SELECT firstname, lastname, image
FROM directors
WHERE image LIKE '%wikimedia%'

SELECT username, email
FROM user
WHERE zipcode in ('69006','69008')

SELECT username, tel
FROM user
WHERE tel LIKE '06%'
OR tel LIKE '07%'

SELECT firstname, lastname
FROM directors
WHERE dob IS NOT NULL
AND YEAR(NOW()) - YEAR(dob) > 40

SELECT firstname, lastname
FROM directors
WHERE dob IS NOT NULL
AND DATEDIFF(NOW(),dob)/365 > 40

/*
Des 7 premiers films français visibles qui sont sortis il y a au moins une semaine*/

SELECT title, date_release
FROM movies
WHERE TIMESTAMPDIFF(day, date_release, now()) >= 7
AND languages = 'fr'
AND visible = 1
ORDER BY date_release DESC
LIMIT 7

SELECT title, date_release
FROM movies
WHERE date_release >= DATE_SUB(NOW(), INTERVAL 7 DAY)
AND languages = 'fr'
AND visible = 1
ORDER BY date_release DESC
LIMIT 7

/*
Des séances qui sortiront prochainement dans 1 mois maximum*/

SELECT *
FROM sessions
WHERE date_session BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 MONTH)
ORDER BY date_session DESC

/*
Des acteurs qui ont des récompenses et qui ont entre 30 et 50 ans*/

SELECT firstname, lastname, dob
FROM actors
WHERE recompenses IS NOT NULL
AND dob BETWEEN DATE_SUB(NOW(), INTERVAL 50 YEAR)
AND DATE_SUB(NOW(), INTERVAL 30 YEAR)

/*
Des réalisateurs nés entre 1962 et 1973 ou qui ont entre 70 et 75 ans*/

SELECT firstname, lastname, dob
FROM directors
WHERE 
(dob BETWEEN DATE_SUB(NOW(), INTERVAL 75 YEAR)
AND DATE_SUB(NOW(), INTERVAL 70 YEAR))
OR
(YEAR(dob) BETWEEN 1962 AND 1973)


/*
Des utilisateurs qui se sont connectés il y a moins de 10 min*/

SELECT username, lastActivity
FROM user
WHERE lastActivity BETWEEN DATE_SUB(NOW(), INTERVAL 10 MINUTE) AND NOW()


/*
Des utilisateurs lyonnais qui se sont inscrits hier entre 20h et minuit (HOUR())*/

SELECT username, created_at
FROM user
WHERE 
LEFT(zipcode,4) = "6900" /* OU SUBSTR(zipcode,1,4) = "6900" */
AND
DATE(created_at)= DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))
AND
HOUR(created_at) BETWEEN 20 AND 23


/*
Des 10 derniers utilisateurs qui se sont connectés*/

SELECT username, last_login
FROM user
ORDER BY last_login DESC
LIMIT 10


/*
La date du dernier jour du mois des inscriptions d'utilisateurs*/

SELECT username, created_at, LAST_DAY(created_at)
FROM user
WHERE created_at IS NOT NULL
ORDER BY LAST_DAY(created_at) DESC


/*
Les utilisateurs nés un vendredi 13 ou entre les semaines 32 et 45
*/
SELECT firstname, lastname, dob
FROM actors
WHERE
(DAYOFWEEK(dob) = 6 AND DAY(dob) = 13)
OR
(WEEKOFYEAR(dob) BETWEEN 32 AND 45)


/*
Nombre de films sortis en 2014 */

SELECT COUNT(id)
FROM movies
WHERE YEAR(date_release) = 2014


/*
Somme des budgets des films dont la note est comprise entre 3 et 5 */

SELECT SUM(budget)
FROM movies
WHERE note_presse BETWEEN 3 AND 5


/*
Durée totale des films en VO */

SELECT SUM(duree)
FROM movies
WHERE bo = "VO"


/*
Durée moyenne des films de 2014 */

SELECT AVG(duree)
FROM movies
WHERE YEAR(date_release) = 2014


/*
Moyenne des budgets des films de 2014 */

SELECT CONCAT(FLOOR(AVG(budget)), "€")
FROM movies
WHERE YEAR(date_release) = 2014


/*
Moyenne des ages des acteurs de Birmingham */

SELECT FLOOR(AVG(TIMESTAMPDIFF(YEAR, dob, NOW())))
FROM actors
WHERE city = 'Birmingham' 


/*
Budget le plus petit des films */

SELECT MIN(budget)
FROM movies

/*
Réalisateur le plus jeune */

SELECT MIN(TIMESTAMPDIFF(YEAR, dob, NOW()))
FROM directors

/*OU*/

SELECT TIMESTAMPDIFF(YEAR, dob, NOW()), firstname, lastname
FROM directors
ORDER BY dob DESC
LIMIT 1

/*
Age du réalisateur le plus vieux qui ait une note de plus de 3 */

SELECT MAX(TIMESTAMPDIFF(YEAR, dob, NOW()))
FROM directors
WHERE note >= 3 AND dob IS NOT NULL

/*OU*/

SELECT TIMESTAMPDIFF(YEAR, dob, NOW()), firstname, lastname
FROM directors
WHERE note >= 3 AND dob IS NOT NULL
ORDER BY dob ASC
LIMIT 1

/*
Nombre d'acteurs par ville, ayant au moins 40 ans*/

SELECT COUNT(id), city
FROM actors
WHERE TIMESTAMPDIFF(YEAR, dob, NOW()) >= 40
GROUP BY city




/*
Nombre de films par annee depuis 2010 ayant le mot "Hobbit" ou "Gandalf" dans leur titre ou description*/

SELECT COUNT(id), title
FROM movies
WHERE 
(synopsis LIKE '%Hobbit%'
OR 
synopsis LIKE '%Gandalf%'
OR
title LIKE '%Hobbit%' 
OR 
title LIKE '%Gandalf%')
GROUP BY annee
HAVING annee >= 2010

/*
Le nombre d'utilisateurs par département ayant une dernière activité de plus d'une semaine*/

SELECT COUNT(id), LEFT(zipcode,2)
FROM user
WHERE TIMESTAMPDIFF(DAY, lastActivity, NOW()) >= 7
GROUP BY LEFT(zipcode,2)

/*
Le nombre d'utilisateurs actifs par ville qui soit administrateur et qui ait un email ou numéro de téléphone dans leur description*/

SELECT COUNT(id), ville
FROM user
WHERE enabled = 1
AND is_admin = 1
AND (description REGEXP "(([+]|00)33\s?|0)[1-9]([\s.-]?\d{2}){4}" OR description REGEXP ".+@[a-zA-Z_.-]+\.[a-zA-Z]{2,3}")
GROUP BY ville

/*
La note maximum des commentaires publiés (state = 1) par films*/
SELECT MAX(note), movies_id
FROM comments
WHERE state = 1
GROUP BY movies_id

/*
Le nb de séances par cinéma diffusé après 20h*/

SELECT COUNT(id), cinema_id
FROM sessions
WHERE HOUR(date_session) >= 20
GROUP BY cinema_id

/*
La ville ou il y a le plus d'acteurs*/

SELECT COUNT(id), city
FROM actors
GROUP BY city
ORDER BY COUNT(id) DESC
LIMIT 1


/*
La moyenne des notes de presse des films qui ont au moins une URL dans leur synopsis ou description */

SELECT AVG(note_presse)
FROM movies
WHERE synopsis LIKE "%http://%"
OR description LIKE "%http://%"


/*
Le nb de catégories de films dont la somme des budgets soit supérieure à 3M */

/*
Le nb de caractère de la description de l'arrondissement de l'utilisateur lyonnais qui a le plus de vue */

/*
Sélection de tous les films de la catégorie Fantastique */

SELECT *
FROM movies
INNER JOIN categories
ON movies.categories_id = categories.id
WHERE categories.title = 'Fantastique'

/*
Tous les commentaires du film Godzilla */

SELECT *
FROM comments
INNER JOIN movies
ON comments.movies_id = movies.id
WHERE title = 'Godzilla'

/*
Les séances du cinéma UGC */

SELECT date_session, cinema.title
FROM sessions
INNER JOIN cinema
ON sessions.cinema_id = cinema.id
WHERE cinema.title LIKE '%UGC%'

/*
Le nb de commentaire par ville d'utilisateur */

SELECT COUNT(comments.id), user.ville
FROM comments
INNER JOIN user
ON comments.user_id = user.id
GROUP BY user.ville

/*
Moyenne de la duree des films joués par Yann McKellen */

SELECT AVG(movies.duree)
FROM movies
INNER JOIN actors_movies
ON actors_movies.movies_id = movies.id
	INNER JOIN actors
	ON actors_movies.actors_id = actors.id
WHERE actors.firstname = 'Christoph' AND actors.lastname = 'Waltz'

/*
Le nom du film qui a le plus de commentaires */

SELECT COUNT(comments.id), movies.title
FROM movies
INNER JOIN comments
ON comments.movies_id = movies.id
GROUP BY movies.title
ORDER BY COUNT(comments.id) DESC
LIMIT 1

/*
Le nom de la catégorie qui comporte des films joués par Christoph Waltz */

SELECT categories.title, actors.firstname, actors.lastname
FROM categories
INNER JOIN movies
ON movies.categories_id = categories.id
INNER JOIN actors_movies
ON movies.id = actors_movies.movies_id
INNER JOIN actors
ON actors.id = actors_movies.actors_id
WHERE CONCAT(actors.firstname, ' ', actors.lastname) = 'Christoph Waltz'

/*
Le nb de tags des films réalisés par Peter jackson */

SELECT COUNT(tags.id), CONCAT(d.firstname, ' ', d.lastname)
FROM tags
INNER JOIN tags_movies AS tm
ON tm.tags_id = tags.id
INNER JOIN movies AS m
ON tm.movies_id = m.id
INNER JOIN directors_movies AS dm
ON m.id = dm.movies_id
INNER JOIN directors AS d
ON dm.directors_id = d.id
WHERE CONCAT(d.firstname, ' ', d.lastname) = 'Quentin Tarantino'


/*
La prochaine séance qui soit diffusé à Lyon pour le film "Man of steel" */

SELECT sessions.date_session, m.title, c.ville
FROM sessions
INNER JOIN movies AS m
ON sessions.movies_id = m.id
INNER JOIN cinema_movies AS cm
ON m.id = cm.movies_id
INNER JOIN cinema AS c
ON cm.cinemas_id = c.id
WHERE c.ville LIKE '%Lyon%' 
AND m.title = 'Le Seigneur des anneaux'
AND date_session > NOW()
ORDER BY date_session DESC
LIMIT 1


/*
Le nombre d'acteurs qui ont joué dans aucun film */

SELECT COUNT(actors.id)
FROM actors
LEFT JOIN actors_movies AS am
ON am.actors_id = actors.id
WHERE am.actors_id IS NULL


/*
La moyenne d'âge des acteurs des films qui ont au moins 2 commentaires */

SELECT FLOOR(AVG(TIMESTAMPDIFF(YEAR, actors.dob, NOW())))
FROM actors
INNER JOIN actors_movies AS am
ON am.actors_id = actors.id
INNER JOIN comments AS c
ON am.movies_id = c.movies_id
WHERE actors.dob IS NOT NULL
AND actors.dob <> '0000-00-00'
AND c.movies_id IN(
	SELECT movies_id
	FROM comments
	GROUP BY movies_id
	HAVING COUNT(id) >=2
)

/*
Le budget maximum dépensé par le réalisateur Francis Veber
*/

SELECT MAX(budget)
FROM movies
INNER JOIN directors_movies AS dm
ON dm.movies_id = movies.id
INNER JOIN directors AS d
ON d.id = dm.directors_id
WHERE CONCAT(d.firstname,' ',d.lastname) = 'Peter Jackson'






























































































