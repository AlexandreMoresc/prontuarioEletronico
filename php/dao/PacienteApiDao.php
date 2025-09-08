<?php
// É necessário incluir o novo Model para que o DAO possa criar os objetos
require_once __DIR__ . '/../models/Paciente.php';

class PacienteApiDao {
    private $apiUrl = 'http://localhost:3000/api';

    private function converterParaObjeto($row) {
        return new Paciente(
            $row['nome'] ?? '',
            $row['cpf'] ?? '',
            $row['data_nascimento'] ?? '',
            $row['email'] ?? '',
            $row['id'] ?? null
        );
    }

    public function read() {
        try {
            $endpoint = $this->apiUrl . '/pacientes';
            $jsonResponse = @file_get_contents($endpoint);

            if ($jsonResponse === false) {
                error_log("Não foi possível conectar à API em " . $endpoint);
                return [];
            }
            
            $pacientesArray = json_decode($jsonResponse, true);

            $listaPacientesObj = [];
            if (is_array($pacientesArray)) {
                foreach ($pacientesArray as $pacienteData) {
                    $listaPacientesObj[] = $this->converterParaObjeto($pacienteData);
                }
            }
            return $listaPacientesObj;

        } catch (Exception $e) {
            error_log('Erro ao buscar pacientes da API: ' . $e->getMessage());
            return [];
        }
    }

    public function buscarPorId($id) {
        $endpoint = $this->apiUrl . '/pacientes/' . $id;
        $response = @file_get_contents($endpoint);

        if ($response === false) {
            return null;
        }

        $pacienteData = json_decode($response, true);
        return $pacienteData ? $this->converterParaObjeto($pacienteData) : null;
    }

    public function criar(Paciente $paciente) {
        $endpoint = $this->apiUrl . '/pacientes';

        $dadosPaciente = [
            'nome' => $paciente->getNome(),
            'cpf' => $paciente->getCpf(),
            'dataNascimento' => $paciente->getDataNascimento(),
            'email' => $paciente->getEmail()
        ];

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dadosPaciente));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($dadosPaciente))
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $http_code == 201;
    }

    public function atualizar(Paciente $paciente) {
        $endpoint = $this->apiUrl . '/pacientes/' . $paciente->getId();

        $dadosPaciente = [
            'nome' => $paciente->getNome(),
            'cpf' => $paciente->getCpf(),
            'data_nascimento' => $paciente->getDataNascimento(),
            'email' => $paciente->getEmail()
        ];

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dadosPaciente));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($dadosPaciente))
        ]);
        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $http_code == 200;
    }

    public function excluir($id) {
        $endpoint = $this->apiUrl . '/pacientes/' . $id;

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $http_code == 200;
    }
}
?>