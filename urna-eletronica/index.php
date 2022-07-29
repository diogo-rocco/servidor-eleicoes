<?php

/**
 * include page with the main html of the site.
 * 
 * @return string to create the page.
 * 
 * @see https://www.geeksforgeeks.org/php-strings/
 * @see https://www.phptutorial.net/php-tutorial/php-heredoc/
 */
function createPage()
{
    include './index.html';
}

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}


function main() {
    echo createPage();
}

main();