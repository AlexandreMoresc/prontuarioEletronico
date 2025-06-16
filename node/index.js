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

let biomedicos = [];
let nextId = 1;

// ROTA 1: Listar todos os biomédicos (READ all)
app.get('/api/biomedicos', (req, res) => {
  console.log('Recebida requisição GET em /api/biomedicos para listar todos');
  res.status(200).json(biomedicos);
});

// ROTA 2: Buscar um biomédico específico pelo ID (READ by ID)
app.get('/api/biomedicos/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const user = biomedicos.find(b => b.id === id);
  if (user) {
    console.log(`--- Requisição GET Recebida em /api/biomedicos/${id} ---`);
    console.log('ID do Biomédico para buscar:', id);
    res.status(200).json(user);
  } else {
    res.status(404).json({ error: 'Usuário não encontrado' });
  }
});

// ROTA 3: Cadastrar um novo biomédico (CREATE)
app.post('/api/biomedicos', (req, res) => {
  const { nome, email, senha, crbm } = req.body;
  const novo = { id: nextId++, nome, email, senha, crbm };
  biomedicos.push(novo);
  console.log('--- Requisição POST Recebida em /api/biomedicos ---');
  console.log('Dados Recebidos para Cadastro:', { nome, email, senha, crbm });
  res.status(201).json(novo);
});

// ROTA 4: Atualizar um biomédico existente (UPDATE)
app.put('/api/biomedicos/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const idx = biomedicos.findIndex(b => b.id === id);
  if (idx === -1) return res.status(404).json({ error: 'Usuário não encontrado' });
  const { nome, email, senha, crbm } = req.body;
  biomedicos[idx] = { id, nome, email, senha, crbm };
  console.log(`--- Requisição PUT Recebida em /api/biomedicos/${id} ---`);
  console.log('Dados para atualização:', { nome, email, senha, crbm });
  res.status(200).json(biomedicos[idx]);
});

// ROTA 5: Excluir um biomédico (DELETE)
app.delete('/api/biomedicos/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const idx = biomedicos.findIndex(b => b.id === id);
  if (idx === -1) return res.status(404).json({ error: 'Usuário não encontrado' });
  biomedicos.splice(idx, 1);
  console.log(`--- Requisição DELETE Recebida em /api/biomedicos/${id} ---`);
  console.log('ID do Biomédico para excluir:', id);
  res.status(200).json({ message: 'Usuário excluído' });
});

// 5. Iniciar o Servidor
app.listen(PORT, () => {
 console.log(`Servidor da API (biomedico) rodando na porta ${PORT}`);
 console.log(`Acesse em: http://localhost:${PORT}`);
});