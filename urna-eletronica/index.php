<?php

/**
 * Inclui a pagina com o HTML principal do site
 * 
 * @return string to create the page.
 */
function createPage()
{
    include './index.html';
}

/**
 * envia para o front a página criada pela função createPage
 */
function main() {
    echo createPage();
}

main();