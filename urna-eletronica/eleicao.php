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
 * Imprime um objeto JSON com a informação de todos os candidatos no banco de dados, esse objeto vai ser recebido por uma função no front
 * 
 * @return void
 */
function get_candidato(){
    $result = mysqli_query($GLOBALS["conn"], 'SELECT * FROM candidaturas');

    if($result){
        $str_lista_prefeito = "";
        $str_lista_vereador = "";
        while ($row = mysqli_fetch_array($result)) {
            //prefeito
            if(strlen($row[2]) == 2){
                //Exemplo obj -> $NumeroCandidatura: {"nome": $NomeCandidato, "partido": $NomePartido, "foto": $FotoCandidato}
                $str_vice = '{ "nome": "' . $row[4] . '", "partido": "' . $row[5] . '", "foto": "' . $row[8] . '"}';
                $str_lista_prefeito .= '"' . $row[2] . '": { "nome": "' . $row[3] . '", "partido": "' . $row[5] . '", "foto": "' . $row[7] . '", "vice": ' . $str_vice . '},';
            }
            //vereador
            else{
                //Exemplo obj -> $NumeroCandidatura: {"nome": $NomeCandidato, "partido": $NomePartido, "foto": $FotoCandidato}
                $str_lista_vereador .= '"' . $row[2] . '": { "nome": "' . $row[3] . '", "partido": "' . $row[5] . '", "foto": "' . $row[7] . '"},';
            }
        }

        $str_lista_prefeito = rtrim($str_lista_prefeito, ",");
        $str_lista_vereador = rtrim($str_lista_vereador, ",");

        print('{
            "0": {
                "titulo": "vereador",
                "numeros": 5,
                "candidatos": {' . $str_lista_vereador . '}
            },
            "1": {
                "titulo": "prefeito",
                "numeros": 2,
                "candidatos": {' . $str_lista_prefeito . '}
            }
        }');
    } else print("\nNenhum candidato encontrado");
}

/**
 * Insere, na tabela de votos, um registro com o voto efetuado em um candidato
 * 
 * @param $numero_candidato numero do candidato que está sendo votado
 * 
 * @return void
 */
function count_vote($numero_candidato){
    $result = mysqli_query($GLOBALS["conn"], 'INSERT INTO votos (IdCandidaturaVotada)
    VALUE ((SELECT IdCandidatura FROM candidaturas WHERE NumeroCandidatura = ' . $numero_candidato . '))');
}

/**
 * verifica se a variavel $_GET possui alguma chave válida (nessa aplicação as chaves válidas são "cadidato" e "voto"). Para cada chave ele direciona para a função devida
 * 
 * -> "candidato" chama a função get_candidato() para mandar para o front a lista de candidatos
 * 
 * -> "voto" chama a função count_vote($numero_candidato) para contabilizar o voto em um candidato
 */
function main() {
    $candidato_number = -1;
    
    if (array_key_exists("candidato", $_GET) &&
        is_numeric($_GET["candidato"]) &&
        $_GET["candidato"] > 0 &&
        $_GET["candidato"] == round((int)$_GET["candidato"], 0))
    {
        $candidato_number = $_GET["candidato"];
        get_candidato($candidato_number);
    } elseif(array_key_exists("voto", $_GET) &&
        is_numeric($_GET["voto"]) &&
        $_GET["voto"] > 0 &&
        $_GET["voto"] == round((int)$_GET["voto"], 0))
    {
        count_vote($_GET["voto"]);
    }
    elseif ($_GET) 
    {
        print "Insira um numero valido de candidato.";
    } else 
    {
        print('{
            "0": {
                "titulo": "vereador",
                "numeros": 5,
                "candidatos": {
                    "51222": {
                        "nome": "Christianne Varão",
                        "partido": "PEN",
                        "foto": "cv1.jpg"
                    },
                    "55555": {
                        "nome": "Homero do Zé Filho",
                        "partido": "PSL",
                        "foto": "cv2.jpg"
                    },
                    "43333": {
                        "nome": "Dandor",
                        "partido": "PV",
                        "foto": "cv3.jpg"
                    },
                    "15123": {
                        "nome": "Filho",
                        "partido": "MDB",
                        "foto": "cv4.jpg"
                    },
                    "27222": {
                        "nome": "Joel Varão",
                        "partido": "PSDC",
                        "foto": "cv5.jpg"
                    },
                    "45000": {
                        "nome": "Professor Clebson Almeida",
                        "partido": "PSDB",
                        "foto": "cv6.jpg"
                    }
                }
            },
            "1": {
                "titulo": "prefeito",
                "numeros": 2,
                "candidatos": {
                    "12": {
                        "nome": "Chiquinho do Adbon",
                        "partido": "PDT",
                        "foto": "cp3.jpg",
                        "vice": {
                            "nome": "Arão",
                            "partido": "PRP",
                            "foto": "v3.jpg"
                        }
                    },
                    "15": {
                        "nome": "Malrinete Gralhada",
                        "partido": "MDB",
                        "foto": "cp2.jpg",
                        "vice": {
                            "nome": "Biga",
                            "partido": "MDB",
                            "foto": "v2.jpg"
                        }
                    },
                    "45": {
                        "nome": "Dr. Francisco",
                        "partido": "PSC",
                        "foto": "cp1.jpg",
                        "vice": {
                            "nome": "João Rodrigues",
                            "partido": "PV",
                            "foto": "v1.jpg"
                        }
                    },
                    "54": {
                        "nome": "Zé Lopes",
                        "partido": "PPL",
                        "foto": "cp4.jpg",
                        "vice": {
                            "nome": "Francisca Ferreira Ramos",
                            "partido": "PPL",
                            "foto": "v4.jpg"
                        }
                    },
                    "65": {
                        "nome": "Lindomar Pescador",
                        "partido": "PC do B",
                        "foto": "cp5.jpg",
                        "vice": {
                            "nome": "Malú",
                            "partido": "PC do B",
                            "foto": "v5.jpg"
                        }
                    }
                }
            }
        }');
    }
    
    

}

main();