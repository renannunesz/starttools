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

    function getPI($piInicio,$piFim,$piEmpresa)
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
                "data_fim": "' . $piFim . '",
                "data_inicio": "' . $piInicio . '"              
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

        $filtros = array_filter(
            $dados,
            function ($dados) use ($piEmpresa) {

                return $dados['empresa_prestadora'] == $piEmpresa;
            }
        );

        return $filtros;
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
            'dados_pi' => $this->recebeDados('2023-03-01','2023-03-31')
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

        $inpDataIni = $this->request->getPost('dataini');
        $inpDataFim = $this->request->getPost('datafim');
        $inpEmpresa = $this->request->getPost('empresapi');

        $tbPIs = $this->pisModel->find();
        $pis_api = $this->getPI($inpDataIni,$inpDataFim,$inpEmpresa);
        $pisAbertos = [];

        foreach ($pis_api as $pi) 
        {
            $pifechado = array_search($pi['id'], array_column($tbPIs,'idpi'));
            if ($pifechado == false) {
                $pisAbertos[] = $pi;
            }
        }

        return view('home', [
            'dados_pi'          => $pisAbertos,
            'tbpis'             => $this->pisModel->find(),
            'inputdataini'      => $inpDataIni,
            'inputdatafim'      => $inpDataFim,
            'inputempresa'      => $inpEmpresa 
        ]);
    }

    public function pisLancados()
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

        $tbPIs = $this->pisModel->find();

        $pisAbertos = [];

        foreach ($filtros as $piapiA) 
        {
            $pesquisa2 = array_search($piapiA['id'], array_column($tbPIs,'idpi'));
            if ($pesquisa2 == false) {
                $pisAbertos[] = $piapiA;
            }
        }
        #var_dump($pisAbertos);

        return view('home',[
            'dados_pi'      => $pisAbertos,
            'tbpis'         => $this->pisModel->find(),
            'inputdataini'     => $inpDataIni,
            'inputdatafim'     => $inpDataFim,
            'inputempresa'  => $selectEmpresa
        ]);
    }

    public function pisBaixados()
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

        $tbPIs = $this->pisModel->find();

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

        return view('home',[
            'dados_pi'      => $pisFechados,
            'tbpis'         => $this->pisModel->find(),
            'inputdataini'     => $inpDataIni,
            'inputdatafim'     => $inpDataFim,
            'inputempresa'  => $selectEmpresa
        ]);
    }

    public function expAthenas()
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

        $tbPIs = $this->pisModel->find();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Nome Cliente/Fornecedor');
        $sheet->setCellValue('B1', 'CNPJ/CPF');
        $sheet->setCellValue('C1', 'Data Registro');
        $sheet->setCellValue('D1', 'Observação');
        $sheet->setCellValue('E1', 'Valor Total');
        $sheet->setCellValue('F1', 'Codigo Serviço');
        $sheet->setCellValue('G1', 'Codigo IBGE');
        $sheet->setCellValue('H1', 'Numero NF');
        $sheet->setCellValue('I1', 'Codigo Produto');
        $sheet->setCellValue('J1', 'Codigo Forma de Pagamento');
        $sheet->setCellValue('K1', 'Endereço');
        $sheet->setCellValue('L1', 'Bairro');
        $sheet->setCellValue('M1', 'CEP');
        $sheet->setCellValue('N1', 'UF');
        $sheet->setCellValue('O1', 'Observacao da Parcela');
        $sheet->setCellValue('P1', 'Email');

        $rowNum = 1;
        foreach ($filtros as $piapiA) 
        {
            $pesquisa2 = array_search($piapiA['id'], array_column($tbPIs,'idpi'));
            if ($pesquisa2 == false) {

                $sheet->setCellValue('A'.$rowNum, $piapiA['cliente']);
                $sheet->setCellValue('B'.$rowNum, $piapiA['cliente_cnpj']);
                $sheet->setCellValue('C'.$rowNum, $piapiA['data_da_venda']);
                $sheet->setCellValue('D'.$rowNum, 'TIPO DE PUBLICAÇÃO: ' . $piapiA['tipo_publicacao_pi'] . " - " . $piapiA['descricao_servico'] . ' - DATA VEICULAÇÃO: ' . date('d/m/Y', strtotime(end($piapiA['periodo_veiculacao'])['periodo_ate'])) . ' PI: ' . $piapiA['nr_pi']);
                $sheet->setCellValue('E'.$rowNum, str_replace(".", "", $piapiA['valor_liquido']));
                $sheet->setCellValue('F'.$rowNum, '1007');
                $sheet->setCellValue('G'.$rowNum, '2408102');
                $sheet->setCellValue('H'.$rowNum, $piapiA['id']);
                $sheet->setCellValue('I'.$rowNum, $piapiA['empresa_prestadora'] == "PARAMETRO AGENCIA DE NOTICIAS" ? '356028' : '354932');
                $sheet->setCellValue('J'.$rowNum, '8');
                $sheet->setCellValue('K'.$rowNum, $piapiA['endereco_cliente']. " N: " .$piapiA['endereco_numero_cliente'] );
                $sheet->setCellValue('L'.$rowNum, $piapiA['bairro_cliente']);
                $sheet->setCellValue('M'.$rowNum, $piapiA['cep_cliente']);
                $sheet->setCellValue('N'.$rowNum, $piapiA['uf_cliente']);
                $sheet->setCellValue('O'.$rowNum, $piapiA['nr_pi']);
                $sheet->setCellValue('P'.$rowNum, $piapiA['email_cliente']);
                $piapiA;
            }

            $rowNum++;
        }


        $writer = new Xlsx($spreadsheet);
        #$writer->save('C:\Users\Renan Nunes\Downloads\hello world.xlsx');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="pis_athenas.xls"');
        $writer->save('php://output');

    }
}

