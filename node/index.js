const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql2');
const dbPool = require('./db');
const PacienteController = require('./controllers/pacienteController');

async function testarConexaoDB() {
  try {
    await dbPool.query('SELECT 1');
    console.log('Conexão com o banco de dados estabelecida com sucesso!');
  } catch (error) {
    console.error('Erro ao conectar ao banco de dados:', error);
    process.exit(1);
  }
}
testarConexaoDB();

const app = express();
const PORT = process.env.PORT || 3000;

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// CRUD Pacientes
app.get('/api/pacientes', PacienteController.listar);
app.get('/api/pacientes/:id', PacienteController.buscarPorId);
app.post('/api/pacientes', PacienteController.cadastrar);
app.put('/api/pacientes/:id', PacienteController.editar);
app.delete('/api/pacientes/:id', PacienteController.excluir);

app.get('/', (req, res) => {
    res.status(200).json({ message: 'API do Sistema de Bioquimica (Simples)' });
});

// Iniciar o Servidor
app.listen(PORT, () => {
  console.log(`Servidor da API rodando na porta ${PORT}`);
  console.log(`Acesse em: http://localhost:${PORT}`);
});