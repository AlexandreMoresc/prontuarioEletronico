<?php
$conn = new mysqli("localhost", "root", "", "prontuario");
if ($conn->connect_error) die("Erro: " . $conn->connect_error);