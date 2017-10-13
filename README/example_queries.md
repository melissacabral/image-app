##########
# SELECT #
##########
SELECT title, body, user_id, category_id, date
FROM posts
WHERE is_published = 1
ORDER BY title ASC
LIMIT 20


# IMPLICIT JOIN get all the posts and their authors
SELECT posts.title, users.username
FROM posts, users
WHERE users.user_id = posts.user_id
AND posts.is_published = 1
LIMIT 20

# LEFT JOIN Get all the users and any posts they have written

SELECT users.username, posts.title
FROM users
LEFT JOIN posts
	ON (users.user_id = posts.user_id
	AND posts.is_published = 1 )

##########
# INSERT #
##########

INSERT INTO comments
(user_id, body, date, post_id, is_approved )
VALUES
($user_id, '$body', now(), $post_id, 1)

##########
# UPDATE #
##########
UPDATE users
SET secret_key = '$secret_key'
WHERE user_id = $user_id

##########
# DELETE #
##########

# un-like a post
DELETE FROM likes 
WHERE user_id = $user_id
AND post_id = $post_id
LIMIT 1



#########
# COUNT #
#########

# COUNT with LEFT JOIN on a Junction table
# get all the posts, and a count of how many likes they have
# includes posts with Zero (0) likes. 

SELECT posts.title, count(likes.post_id) AS total 
FROM posts
LEFT JOIN likes
ON( posts.post_id = likes.post_id)
GROUP BY posts.post_id