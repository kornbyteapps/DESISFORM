-- Crear tabla de regiones
CREATE TABLE Regiones (
    id_region INT AUTO_INCREMENT PRIMARY KEY,
    nombre_region VARCHAR(255) NOT NULL
);

-- Crear tabla de provincias
CREATE TABLE Provincias (
    id_provincia INT AUTO_INCREMENT PRIMARY KEY,
    nombre_provincia VARCHAR(255) NOT NULL,
    id_region INT NOT NULL,
    FOREIGN KEY (id_region) REFERENCES Regiones(id_region)
);

-- Crear tabla de comunas
CREATE TABLE Comunas (
    id_comuna INT AUTO_INCREMENT PRIMARY KEY,
    nombre_comuna VARCHAR(255) NOT NULL,
    id_provincia INT NOT NULL,
    FOREIGN KEY (id_provincia) REFERENCES Provincias(id_provincia)
);

-- Crear tabla de candidatos
CREATE TABLE Candidatos (
    id_candidato INT AUTO_INCREMENT PRIMARY KEY,
    nombre_candidato VARCHAR(255) NOT NULL
);

-- Crear tabla de votos
CREATE TABLE Votos (
    id_voto INT AUTO_INCREMENT PRIMARY KEY,
    nombre_apellido VARCHAR(255) NOT NULL,
    alias VARCHAR(20) NOT NULL,
    rut VARCHAR(12) NOT NULL,
    email VARCHAR(255) NOT NULL,
    id_candidato INT NOT NULL,
    id_region INT NOT NULL,
    id_comuna INT NOT NULL,
    UNIQUE KEY (rut),
    FOREIGN KEY (id_candidato) REFERENCES Candidatos(id_candidato),
    FOREIGN KEY (id_region) REFERENCES Regiones(id_region),
    FOREIGN KEY (id_comuna) REFERENCES Comunas(id_comuna)
);