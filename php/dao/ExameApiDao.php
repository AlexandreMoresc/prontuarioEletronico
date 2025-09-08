<?php
class ExameApiDao {
    
    private $apiUrl = 'http://localhost:3000/api';

    public function iniciarExame($paciente_id, $tipo_exame) {
        $endpoint = $this->apiUrl . '/exames';
        $dados = ['paciente_id' => $paciente_id, 'tipo_exame' => $tipo_exame];

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($dados))
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 201) {
            return json_decode($response, true);
        }
    
        error_log("Erro ao iniciar exame. Código HTTP: $http_code. Resposta: $response");
        return null;
    }

    public function buscarPorId($id) {
        $endpoint = $this->apiUrl . '/exames/' . $id;
        $response = @file_get_contents($endpoint);

        if ($response === false) {
            return null;
        }

        return json_decode($response, true);
    }
    
    public function atualizar($id, $dados) {
        $endpoint = $this->apiUrl . '/exames/' . $id;

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($dados))
        ]);

        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $http_code == 200;
    }

    public function listarPorPaciente($paciente_id) {
        $endpoint = $this->apiUrl . '/pacientes/' . $paciente_id . '/exames';
        $response = @file_get_contents($endpoint);

        if ($response === false) {
            return [];
        }

        return json_decode($response, true);
    }
}