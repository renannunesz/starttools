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

    function recebeDados($dataInicio,$dataFim)
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
                "data_fim": "' . $dataFim . '",
                "data_inicio": "' . $dataInicio . '"              
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

        $this->request->getPost('dataPIini') == null ? $inpDataIni = date('Y-m-d') : $inpDataIni = $this->request->getPost('dataPIini');

        $this->request->getPost('dataPIfim') == null ? $inpDataFim = date('Y-m-d') : $inpDataFim = $this->request->getPost('dataPIfim');

        $dados = $this->recebeDados($inpDataIni,$inpDataFim);

        $filtros = array_filter(
            $dados,
            function ($dados) {

                $this->request->getPost('empresaPI') == null ? $inpEmpresa = null : $inpEmpresa = $this->request->getPost('empresaPI');

                return $dados['empresa_prestadora'] == $inpEmpresa;
            }
        );

        $selectEmpresa = $this->request->getPost('empresaPI');

        /*
        foreach ($filtros as $pit) 
        {                        
            $pesquisa = array_search("5709", $pit);
            #var_dump($pesquisa);
            #echo "aqui: ";
            if ($pesquisa !== false) {
                var_dump($pit);
            } else {
                #echo "nao";
            }                            
        }    
        */

        $tbPIs = $this->pisModel->find();

        $pisAbertos = [];
        $pisFechados = [];

        foreach ($tbPIs as $pitb) {
            foreach ($filtros as $piapi) {
                $pesquisa = array_search($pitb['idpi'], $piapi);
                if ($pesquisa == true) {
                    $pisFechados[] = $piapi;
                }
            }
        }
        #var_dump($pisFechados);

        foreach ($filtros as $piapiA) 
        {
            $pesquisa2 = array_search($piapiA['id'], array_column($tbPIs,'idpi'));
            if ($pesquisa2 == false) {
                $pisAbertos[] = $piapiA;
            }
        }
        #var_dump($pisAbertos);

        return view('api', [
            'dados_pi'      => $pisAbertos,
            'tbpis'         => $this->pisModel->find(),
            'inputdataini'     => $inpDataIni,
            'inputdatafim'     => $inpDataFim,
            'inputempresa'  => $selectEmpresa
        ]);
    }


    public function homologAPI()
    {
        return view('homolog', [
            'dados_pi' => $this->recebeDados('2023-02-20',date('Y-m-d'))
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
            'dados_pi' => $this->recebeDados(date('Y-m-d'),date('Y-m-d')),
            'tbpis' => $this->pisModel->find(),
            'inputdataini'     => date('Y-m-d'),
            'inputdatafim'     => date('Y-m-d'),
            'inputempresa'  => ""
        ]);
    }
}
