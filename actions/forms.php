<?php

var_dump($_POST); // use apenas pra depurar

$data_cvcrm = [
    'nome' => $_POST['nome'] ?? '',
    'email' => $_POST['email'] ?? '',
    'telefone' => preg_replace('/\D/', '', $_POST['tel'] ?? ''),
    'idempreendimento' => 6,
    'mensagem' => 'Mensagem da LP Boulevard',
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
} else {
    echo $response;
}

curl_close($ch);
?>
