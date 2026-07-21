<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 0);
error_reporting(E_ALL);

// ===========================
// LÊ JSON DO BODY
// ===========================
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!$data) {
    echo json_encode([
        'success' => false,
        'error' => 'Nenhum dado recebido'
    ]);
    exit;
}

$data = array(
	'nome' => $data['nome'],
	'email' => $data['email'],
	'telefone' => $data['telefone'],
	'mensagem' => 'Mensagem do site Leville',
	'site' => 'Landing Page Leville',
    'id_cliente_primario' => '95',
    'id_empreendimento' => '3744'
);

// Envio para API externa
$url = 'https://www.brokertecnologia.com.br/api/inserirEmail';
$data_string = json_encode($data);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string)
]);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$result = curl_exec($ch);


$data_cvcrm = [
	'nome' => $data['nome'] ?? '',
	'email' => $data['email'] ?? '',
	'telefone' => preg_replace('/\D/', '', $data['telefone'] ?? ''),
	'idempreendimento' => 7,
	'mensagem' =>  'Mensagem Site Leville',
	'origem' => 'SI'
];

$url = 'https://imobel.cvcrm.com.br/api/cvio/lead';
$data_string = json_encode($data_cvcrm);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
	'Content-Type: application/json',
	'Accept: application/json',
	'token: bfbdbba4b71e9f94672e33e194c78fa7657822d1',
	'email: equipe.marketing@agenciaaffinity.com.br'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if (curl_errno($ch)) {
	echo 'Erro ao enviar para CVCRM: ' . curl_error($ch);
}

curl_close($ch);

// ===========================
// RETORNO
// ===========================
echo json_encode([
    'success' => true,
    'message' => 'E-mail enviado com sucesso'
]);
exit;
