<?php

$sql = "
    SELECT
        *
    FROM
        wp_posts 
    WHERE
        post_type = 'sc-car'
    AND
        post_status = 'publish'        
";



?>