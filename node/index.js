const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql2');

// Inicializar o aplicativo Express
const app = express();
const PORT = process.env.PORT || 3000;

// Configurar o Body Parser
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Configuração do Banco de Dados
const dbPool = mysql.createPool({
  host: '127.0.0.1',
  port: 3307, // Adicione a porta correta
  user: 'root',
  password: '', 
  database: 'prontuario',
}).promise();

// Testar conexão com o banco de dados
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

// Rota Inicial
app.get('/', (req, res) => {
  res.status(200).json({ message: 'API do Sistema de Biomedicina (Simples)' });
});

// ROTA 1: Listar todos os biomédicos (READ all)
app.get('/api/biomedicos', async (req, res) => {
  try {
    const [rows] = await dbPool.query('SELECT * FROM usuario');
    res.status(200).json(rows);
  } catch (error) {
    console.error('Erro ao listar biomédicos:', error);
    res.status(500).json({ error: 'Erro ao listar biomédicos' });
  }
});

// ROTA 2: Buscar um biomédico específico pelo ID (READ by ID)
app.get('/api/biomedicos/:id', async (req, res) => {
  const id = parseInt(req.params.id);
  try {
    const [rows] = await dbPool.query('SELECT * FROM usuario WHERE id = ?', [id]);
    if (rows.length > 0) {
      res.status(200).json(rows[0]);
    } else {
      res.status(404).json({ error: 'Usuário não encontrado' });
    }
  } catch (error) {
    console.error('Erro ao buscar biomédico:', error);
    res.status(500).json({ error: 'Erro ao buscar biomédico' });
  }
});

// ROTA 3: Cadastrar um novo biomédico (CREATE)
app.post('/api/biomedicos', async (req, res) => {
  const { nome, email, senha, crbm } = req.body;
  try {
    const [result] = await dbPool.query(
      'INSERT INTO usuario (nome, email, senha, crbm) VALUES (?, ?, ?, ?)',
      [nome, email, senha, crbm]
    );
    res.status(201).json({ id: result.insertId, nome, email, crbm });
  } catch (error) {
    console.error('Erro ao cadastrar biomédico:', error);
    res.status(500).json({ error: 'Erro ao cadastrar biomédico' });
  }
});

// ROTA 4: Atualizar um biomédico existente (UPDATE)
app.put('/api/biomedicos/:id', async (req, res) => {
  const id = parseInt(req.params.id);
  const { nome, email, senha, crbm } = req.body;
  try {
    const [result] = await dbPool.query(
      'UPDATE usuario SET nome = ?, email = ?, senha = ?, crbm = ? WHERE id = ?',
      [nome, email, senha, crbm, id]
    );
    if (result.affectedRows > 0) {
      res.status(200).json({ id, nome, email, crbm });
    } else {
      res.status(404).json({ error: 'Usuário não encontrado' });
    }
  } catch (error) {
    console.error('Erro ao atualizar biomédico:', error);
    res.status(500).json({ error: 'Erro ao atualizar biomédico' });
  }
});

// ROTA 5: Excluir um biomédico (DELETE)
app.delete('/api/biomedicos/:id', async (req, res) => {
  const id = parseInt(req.params.id);
  try {
    const [result] = await dbPool.query('DELETE FROM usuario WHERE id = ?', [id]);
    if (result.affectedRows > 0) {
      res.status(200).json({ message: 'Usuário excluído' });
    } else {
      res.status(404).json({ error: 'Usuário não encontrado' });
    }
  } catch (error) {
    console.error('Erro ao excluir biomédico:', error);
    res.status(500).json({ error: 'Erro ao excluir biomédico' });
  }
});

// Iniciar o Servidor
app.listen(PORT, () => {
  console.log(`Servidor da API rodando na porta ${PORT}`);
  console.log(`Acesse em: http://localhost:${PORT}`);
});