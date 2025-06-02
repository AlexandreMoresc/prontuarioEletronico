-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS prontuario;
USE prontuario;

-- Tabela de pacientes
CREATE TABLE IF NOT EXISTS paciente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    nascimento DATE NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    sexo VARCHAR(20) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(255),
    endereco TEXT,
    convenio VARCHAR(255),
    observacoes TEXT
);

-- Tabela de exames
CREATE TABLE IF NOT EXISTS exame (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT
);

-- Tabela de resultados
CREATE TABLE IF NOT EXISTS resultado (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    exame_id INT NOT NULL,
    data DATE NOT NULL,
    resultado TEXT NOT NULL,
    FOREIGN KEY (paciente_id) REFERENCES paciente(id),
    FOREIGN KEY (exame_id) REFERENCES exame(id)
);