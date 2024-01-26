<?php

define('DEFAULT_MESSAGE', "Hi,

I hope this email finds you well. I wanted to remind everyone about our upcoming team meeting scheduled for next Friday at 10 a.m.. We'll be discussing new features. Your active participation and input are highly valued, so please come prepared with any updates or insights you'd like to share.

If you have any specific items you'd like to include in the agenda, feel free to let me know before the meeting.

Looking forward to our productive discussion!");

define('GET_USERS_BY_CATEGORIES_QUERY', '
    SELECT users.*
    FROM users
    JOIN user_category ON users.id = user_category.user_id
    WHERE user_category.category_id IN (:placeholders)
    GROUP BY users.id
');

define('GET_ALL_CATEGORIES_QUERY', 'SELECT * FROM categories');

?>
