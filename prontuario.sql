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

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);
CREATE TABLE requisicoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    data DATETIME NOT NULL,
    FOREIGN KEY (paciente_id) REFERENCES paciente(id)
);
-- Tabela de requisições de exames

CREATE TABLE requisicao_exames (
    id INT AUTO_INCREMENT PRIMARY KEY,
    requisicao_id INT NOT NULL,
    exame_id INT NOT NULL,
    FOREIGN KEY (requisicao_id) REFERENCES requisicoes(id),
    FOREIGN KEY (exame_id) REFERENCES exame(id)
);


-- Tabela de requisições
CREATE TABLE requisicoes (
    id INT AUTO_INCREMENT PRIMARY KEY, -- ID único da requisição
    numero INT NOT NULL AUTO_INCREMENT UNIQUE, -- Número sequencial único da requisição
    paciente_id INT NOT NULL, -- ID do paciente relacionado
    data DATETIME NOT NULL, -- Data da criação da requisição
    FOREIGN KEY (paciente_id) REFERENCES paciente(id) -- Chave estrangeira para a tabela de pacientes
);

-- Tabela de requisições de exames
CREATE TABLE requisicao_exames (
    id INT AUTO_INCREMENT PRIMARY KEY, -- ID único da relação
    requisicao_id INT NOT NULL, -- ID da requisição
    exame_id INT NOT NULL, -- ID do exame relacionado
    FOREIGN KEY (requisicao_id) REFERENCES requisicoes(id) ON DELETE CASCADE, -- Chave estrangeira para a tabela de requisições
    FOREIGN KEY (exame_id) REFERENCES exame(id) ON DELETE CASCADE -- Chave estrangeira para a tabela de exames
);

DESCRIBE requisicoes;

DROP TABLE IF EXISTS requisicoes;

DROP TABLE IF EXISTS requisicao_exames;

CREATE TABLE requisicoes (
    id INT NOT NULL PRIMARY KEY, -- ID manual (não auto_increment)
    numero INT NOT NULL AUTO_INCREMENT UNIQUE, -- Número sequencial único
    paciente_id INT NOT NULL,
    data DATETIME NOT NULL,
    FOREIGN KEY (paciente_id) REFERENCES paciente(id)
);