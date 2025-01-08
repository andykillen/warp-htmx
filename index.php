
<?php 
/**
 * The main template file
 * 
 * This file is purposfully this way. 
 * 
 * it allows for router.php to be the main file that is used to 
 * route the page to the correct template.
 * 
 * If it was using this index.php it would mean that there was always
 * the full page created, where the HTMX gateway, AJXA or REST API might want 
 * to get the content only without the header and footer.
 */
get_header();
get_template_part('template_parts/router');
get_footer(); 
