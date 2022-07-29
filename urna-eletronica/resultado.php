<?php
// Connection settings
$servername = "localhost";
$username = "app_user";
$password = "senha_app";
$bdname = "base_eleitoral";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $bdname);
if (mysqli_connect_error()) {
    die("Database Connection Error");
}

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

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}


function main() {
    echo createPage();
}

main();