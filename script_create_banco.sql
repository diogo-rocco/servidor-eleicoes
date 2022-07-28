CREATE DATABASE IF NOT EXISTS base_eleitoral;

CREATE TABLE IF NOT EXISTS base_eleitoral.candidaturas (
	IdCandidatura int NOT NULL PRIMARY KEY,
	Cargo varchar(50) NOT NULL,
	NumeroCandidatura varchar(10) NOT NULL,
	NomeCandidato varchar(100) NOT NULL,
	NomeVice varchar(100),
	NomePartido varchar(10) NOT NULL,
	NumeroPartido varchar(10) NOT NULL,
	FotoCandidato varchar(2500),
	FotoVice varchar(2500)
);

CREATE TABLE IF NOT EXISTS base_eleitoral.votos(
	IdVoto int NOT NULL PRIMARY KEY,
	IdCandidaturaVotada int NOT NULL,
	FOREIGN KEY (IdCandidaturaVotada) REFERENCES candidaturas(IdCandidatura)
);