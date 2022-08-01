<?php
/**
 * Nome do servidor do banco de dados
 */
$servername = "localhost";
/**
 * Usuario de acesso ao banco de dados
 */
$username = "app_user";
/**
 * Senha de acesso do usuario para o banco de dados
 */
$password = "senha_app";
/**
 * Nome da base de dados
 */
$bdname = "base_eleitoral";

/**
 * Objeto de conexão com o banco de dados
 */
$conn = mysqli_connect($servername, $username, $password, $bdname);
if (mysqli_connect_error()) {
    die("Database Connection Error");
}

/**
 * Faz a a consulta para obter o resultado atual da votação e monta o HTML da pagina com esse resultado
 * 
 * @return string contendo o HTML da pagina do resultado atual da votação
 */
function createPage()
{
    $teste = "teste";
  
    $result = mysqli_query($GLOBALS["conn"], 'SELECT c.NomeCandidato, c.NomeVice, c.NumeroCandidatura, COUNT(v.IdVoto) AS votos  from votos v
    INNER JOIN candidaturas c ON IdCandidaturaVotada = IdCandidatura
    GROUP BY c.NomeCandidato, c.NomeVice, c.NumeroCandidatura');
  
  if($result)
  {
    $page = '
    <!DOCTYPE html>
    <html>
        
        <head>
            <title>Resultados</title>
        </head>
        
        <body>
        <table style="border: 1px solid">
          <tr>
              <th style="border: 1px solid">Candidato</th>
              <th style="border: 1px solid">Vice</th>
              <th style="border: 1px solid">Numero Candidatura</th>
              <th style="border: 1px solid">Quantidade de Votos</th>
          </tr>';

    while ($row = mysqli_fetch_array($result)) {
        $page .= '<tr style="border: 1px solid">
        <td style="border: 1px solid">' . $row[0] . '</td>
        <td style="border: 1px solid">' . $row[1] . '</td>
        <td style="border: 1px solid">' . $row[2] . '</td>
        <td style="border: 1px solid">' . $row[3] . '</td>
    </tr>';
    }

    $page .= '</table>

    </body>
    
    </html>';

      return $page;
  } else {
    return <<<HTML
      <!DOCTYPE html>
      <html>
          
          <head>
              <title>Resultados</title>
          </head>
          
          <body>
                <h1>
                  Nenhum voto efetuado
                </h1>
          </body>
          
      </html> 
  HTML;
  }
}

/**
 * manda para o front a página criada na função createPage()
 */
function main() {
    echo createPage();
}

main();