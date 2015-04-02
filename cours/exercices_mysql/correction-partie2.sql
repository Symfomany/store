/*-----------
Le film le plus long parmi les derniers films réalisés par Quentin Tarantino */

SELECT title, duree
FROM movies
WHERE id IN
(
SELECT m.id
FROM movies AS m
INNER JOIN directors_movies AS dm
ON m.id = dm.movies_id
INNER JOIN directors AS d
ON d.id = dm.directors_id
WHERE CONCAT(d.firstname, ' ',d.lastname) = 'Quentin Tarantino'
ORDER BY m.date_release DESC
)
ORDER BY duree DESC
LIMIT 1


/*-----------
Le budget total des films les plus longs joués avec Aaron Paul */

SELECT SUM(x.budget)
FROM (
SELECT budget
FROM movies
INNER JOIN actors_movies
ON movies.id = actors_movies.movies_id
INNER JOIN actors
ON actors.id = actors_movies.actors_id
WHERE CONCAT(actors.firstname,' ',actors.lastname) = 'Christoph Waltz'
) AS x


/*-----------
Le film le plus cher parmi la liste des films visibles qui ont le plus de commentaires */

SELECT COUNT(comments.id), comments.movies_id, movies.budget, movies.title
FROM movies
INNER JOIN comments
ON comments.movies_id = movies.id
WHERE movies.visible = 1
GROUP BY comments.movies_id
ORDER BY budget DESC
LIMIT 1


/*-----------
Le cinema qui diffuse le plus de films de 2012 à 2014 */
/*
SELECT cinema.title
FROM cinema
INNER JOIN cinema_movies
ON cinema.id = cinema_movies.cinemas_id
INNER JOIN movies
ON movies.id = cinema_movies.movies_id
WHERE YEAR(movies.date_release) BETWEEN 2012 AND 2014
GROUP BY cinema_movies.cinemas_id
ORDER BY COUNT(cinema_movies.cinemas_id) DESC
LIMIT 1
*/

SELECT cinema.title
FROM cinema
INNER JOIN cinema_movies
ON cinema.id = cinema_movies.cinemas_id
INNER JOIN movies
ON movies.id = cinema_movies.movies_id
INNER JOIN sessions
ON sessions.movies_id = movies.id
WHERE YEAR(sessions.date_session) BETWEEN 2012 AND 2014
GROUP BY cinema_movies.cinemas_id
ORDER BY COUNT(cinema_movies.cinemas_id) DESC
LIMIT 1



/*-----------
L'acteur le plus jeune parmi la liste d'acteurs Lyonnais qui ont joué dans le plus de films */

SELECT actors.firstname, actors.lastname, TIMESTAMPDIFF(YEAR, actors.dob, NOW())
FROM actors
INNER JOIN actors_movies
ON actors.id = actors_movies.actors_id
INNER JOIN movies
ON movies.id = actors_movies.movies_id
WHERE actors.city LIKE '%Lyon%'
ORDER BY TIMESTAMPDIFF(YEAR, actors.dob, NOW()) ASC
LIMIT 1



/* Afficher la liste des films dans 2 colonnes : une colonne FR et une colonne EN  */

SELECT  GROUP_CONCAT(DISTINCT(table2.title)), GROUP_CONCAT(DISTINCT(table3.title))
FROM movies

INNER JOIN movies AS table2
ON  table2.languages='fr'

INNER JOIN movies AS table3 
ON table3.languages='en'









