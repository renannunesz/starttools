<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PI extends BaseController
{
    function recebeDados($dataInicio)
    {
        //$dataInicio
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://agorarn.datavence.com.br/api/private/faturasPI',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => array(
            //'numero_pi' => '15489/2021',
            'data_inicio' => $dataInicio,
            'data_fim' => date('Y-m-d'),
        ),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic 408fb3e9b90a4c59b34628b3b80fbe64'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response, true);

        $dados = json_decode($response, true);

        return $dados;

    }

    public function index()
    {

        $this->request->getPost('dataPI') == null ? $inpData = '2023-01-01' : $inpData = $this->request->getPost('dataPI') ;

        $dados = $this->recebeDados($inpData);
        
        $filtros = array_filter($dados, 
            function($dados) {                 

                $this->request->getPost('empresaPI') == null ? $inpEmpresa = null : $inpEmpresa = $this->request->getPost('empresaPI') ;

                return $dados['empresa_prestadora'] == $inpEmpresa;
            }
        );
        
        return view('api', [
            'dados_pi' => $filtros,
        ]);
        
    }

    public function homologAPI()
    {
        return view('homolog', [
            'dados_pi' => $this->recebeDados('2022-01-01')
        ]);
    }

    public function export()
    {
        $dadosTabela = $this->request->getPost('inp_h_tabdados');

        if ( isset($dadosTabela) ) {

            $temporary_html_file = 'C:\xampp\htdocs\tmp_html' . time() . '.html';

            file_put_contents($temporary_html_file, $dadosTabela);

            $reader = IOFactory::createReader('Html');

            $spreadsheet = $reader->load($temporary_html_file);

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

            $filename = 'pedidos_' . time() . '.xlsx';

            $writer->save($filename);

            header('Content-Type: application/x-www-form-urlencoded');

            header('Content-Transfer-Encoding: Binary');

            header("Content-disposition: attachment; filename=\"".$filename."\"");

            readfile($filename);

            unlink($temporary_html_file);

            unlink($filename);

            exit;

        } else {

            echo 'não existe, volte';

        }

        return view('homolog');

    }
}