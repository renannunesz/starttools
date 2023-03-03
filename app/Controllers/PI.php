<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TbpisModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PI extends BaseController
{
    private $pisModel;

    public function __construct()
    {

        $this->pisModel = new TbpisModel();
    }

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
            CURLOPT_POSTFIELDS => '{  
                "data_fim": "'.date('Y-m-d').'",
                "data_inicio": "'.$dataInicio.'"              
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic 408fb3e9b90a4c59b34628b3b80fbe64',
                'Content-Type: application/json'
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

        $this->request->getPost('dataPI') == null ? $inpData = date('Y-m-d') : $inpData = $this->request->getPost('dataPI');                  

        $dados = $this->recebeDados($inpData);

        $filtros = array_filter(
            $dados,
            function ($dados) {

                $this->request->getPost('empresaPI') == null ? $inpEmpresa = null : $inpEmpresa = $this->request->getPost('empresaPI');

                return $dados['empresa_prestadora'] == $inpEmpresa;
            }
        );

        $selectEmpresa = $this->request->getPost('empresaPI');

        return view('api', [
            'dados_pi'      => $filtros,
            'tbpis'         => $this->pisModel->find(),
            'inputdata'     => $inpData,
            'inputempresa'  => $selectEmpresa
        ]);
    }


    public function homologAPI()
    {
        return view('homolog', [
            'dados_pi' => $this->recebeDados('2023-02-20')
        ]);
    }

    public function export()
    {
        $dadosTabela = $this->request->getPost('inp_h_tabdados');

        if (isset($dadosTabela)) {

            $temporary_html_file = 'C:\xampp\htdocs\tmp_html' . time() . '.html';

            file_put_contents($temporary_html_file, $dadosTabela);

            $reader = IOFactory::createReader('Html');

            $spreadsheet = $reader->load($temporary_html_file);

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

            $filename = 'pedidos_' . time() . '.xlsx';

            $writer->save($filename);

            header('Content-Type: application/x-www-form-urlencoded');

            header('Content-Transfer-Encoding: Binary');

            header("Content-disposition: attachment; filename=\"" . $filename . "\"");

            readfile($filename);

            unlink($temporary_html_file);

            unlink($filename);

            exit;
        } else {

            echo 'não existe, volte';
        }

        return view('homolog');
    }

    public function gravaStatus()
    {
        $this->pisModel->save($this->request->getPost());

        return view('api', [
            'dados_pi' => $this->recebeDados(date('Y-m-d')),
            'tbpis' => $this->pisModel->find(),
            'inputdata'     => date('Y-m-d'),
            'inputempresa'  => ""
        ]);
    }
}
