-- Crear tabla de regiones
CREATE TABLE Regiones (
    id_region INT AUTO_INCREMENT PRIMARY KEY,
    nombre_region VARCHAR(255) NOT NULL,
    abreviatura VARCHAR(4) NOT NULL,
    capital VARCHAR(64) NOT NULL
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
CREATE TABLE `candidatos` (
  `id_candidato` int(11) NOT NULL,
  `nombre_candidato` varchar(255) NOT NULL
);

-- Crear tabla de votos
CREATE TABLE `votos` (
  `id_voto` int(11) NOT NULL,
  `nombre_apellido` varchar(255) NOT NULL,
  `alias` varchar(20) NOT NULL,
  `rut` varchar(12) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_candidato` int(11) NOT NULL,
  `id_region` int(11) NOT NULL,
  `id_comuna` int(11) NOT NULL,
  `referencia` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `votos`
  ADD PRIMARY KEY (`id_voto`),
  ADD UNIQUE KEY `rut` (`rut`),
  ADD KEY `id_candidato` (`id_candidato`),
  ADD KEY `id_region` (`id_region`),
  ADD KEY `id_comuna` (`id_comuna`);
