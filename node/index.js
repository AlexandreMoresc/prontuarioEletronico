// 1. Importar os módulos necessários
const express = require('express');
const bodyParser = require('body-parser');
// const mysql = require('mysql2'); // Descomente para uso real com banco de dados

// 2. Inicializar o aplicativo Express
const app = express();
const PORT = process.env.PORT || 3000;

// 3. Configurar o Body Parser
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

/*
// ----- SEÇÃO DE CONFIGURAÇÃO DO BANCO DE DADOS (Para Entrega 4) -----
// const dbPool = mysql.createPool({ ... }).promise();
// async function testarConexaoDB() { ... }
// testarConexaoDB();
// ----- FIM DA SEÇÃO DE CONFIGURAÇÃO DO BANCO DE DADOS ----- 
*/

// 4. Rota Inicial
app.get('/', (req, res) => {
 res.status(200).json({ message: 'API do Sistema de Biomedicina (Simples)' });
});

// --- ROTAS CRUD PARA BIOMÉDICOS ---

// ROTA 1: Listar todos os biomédicos (READ all)
app.get('/api/biomedicos', (req, res) => {
 console.log('Recebida requisição GET em /api/biomedicos para listar todos');
 // TODO: Buscar dados reais do banco
 res.status(200).json({ message: 'Listagem de todos os biomédicos (simulação)' });
});

// ROTA 2: Buscar um biomédico específico pelo ID (READ by ID)
app.get('/api/biomedicos/:id', (req, res) => {
 const biomedicoId = req.params.id;
 console.log(`--- Requisição GET Recebida em /api/biomedicos/${biomedicoId} ---`);
 console.log('ID do Biomédico para buscar:', biomedicoId);
 // TODO: Buscar o biomédico no banco
 res.status(200).send(`Dados simulados do biomédico com ID ${biomedicoId}`);
});

// ROTA 3: Cadastrar um novo biomédico (CREATE)
app.post('/api/biomedicos', (req, res) => {
 const { nome, email, senha, crbm } = req.body;
 console.log('--- Requisição POST Recebida em /api/biomedicos ---');
 console.log('Dados Recebidos para Cadastro:', { nome, email, senha, crbm });
 // TODO: Inserir no banco
 res.status(201).send('Biomédico cadastrado com sucesso (simulação)');
});

// ROTA 4: Atualizar um biomédico existente (UPDATE)
app.put('/api/biomedicos/:id', (req, res) => {
 const biomedicoId = req.params.id;
 const { nome, email, senha, crbm } = req.body;
 console.log(`--- Requisição PUT Recebida em /api/biomedicos/${biomedicoId} ---`);
 console.log('Dados para atualização:', { nome, email, senha, crbm });
 // TODO: Atualizar no banco
 res.status(200).send(`Biomédico com ID ${biomedicoId} atualizado com sucesso (simulação)`);
});

// ROTA 5: Excluir um biomédico (DELETE)
app.delete('/api/biomedicos/:id', (req, res) => {
 const biomedicoId = req.params.id;
 console.log(`--- Requisição DELETE Recebida em /api/biomedicos/${biomedicoId} ---`);
 console.log('ID do Biomédico para excluir:', biomedicoId);
 // TODO: Excluir do banco
 res.status(200).send(`Biomédico com ID ${biomedicoId} excluído com sucesso (simulação)`);
});

// 5. Iniciar o Servidor
app.listen(PORT, () => {
 console.log(`Servidor da API (biomedico) rodando na porta ${PORT}`);
 console.log(`Acesse em: http://localhost:${PORT}`);
});