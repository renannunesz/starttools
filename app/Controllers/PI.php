<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TbpisModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpParser\Node\Stmt\Return_;

class PI extends BaseController
{
    private $pisModel;

    public function __construct()
    {
        $this->pisModel = new TbpisModel();
    }

    function getPI($piInicio, $piFim, $piEmpresa)
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

    public function homologAPI()
    {
        return view('homolog', [
            'dados_pi' => $this->getPI('2023-03-01', '2023-03-31', "")
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
        $pis_api = $this->getPI($inpDataIni, $inpDataFim, $inpEmpresa);
        $pisAbertos = [];

        foreach ($pis_api as $pi) {
            $pifechado = array_search($pi['id'], array_column($tbPIs, 'idpi'));
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
        $this->request->getPost('empresaPI') == null ? $inpEmpresa = null : $inpEmpresa = $this->request->getPost('empresaPI');

        $tbPIs = $this->pisModel->find();
        $pis_api = $this->getPI($inpDataIni, $inpDataFim, $inpEmpresa);
        $pisAbertos = [];

        foreach ($pis_api as $pi) {
            $pifechado = array_search($pi['id'], array_column($tbPIs, 'idpi'));
            if ($pifechado == false) {
                $pisAbertos[] = $pi;
            }
        }

        return view('home', [
            'dados_pi'      => $pisAbertos,
            'tbpis'         => $this->pisModel->find(),
            'inputdataini'  => $inpDataIni,
            'inputdatafim'  => $inpDataFim,
            'inputempresa'  => $inpEmpresa
        ]);
    }

    public function pisBaixados()
    {

        $inpDataIni = $this->request->getPost('dataini');
        $inpDataFim = $this->request->getPost('datafim');
        $inpEmpresa = $this->request->getPost('empresapi');

        $tbPIs = $this->pisModel->find();
        $pis_api = $this->getPI($inpDataIni, $inpDataFim, $inpEmpresa);
        $pisFechados = [];

        foreach ($pis_api as $pi) {
            $pifechado = array_search($pi['id'], array_column($tbPIs, 'idpi'));
            if ($pifechado == true) {
                $pisFechados[] = $pi;
            }
        }

        return view('home', [
            'dados_pi'      => $pisFechados,
            'tbpis'         => $this->pisModel->find(),
            'inputdataini'  => $inpDataIni,
            'inputdatafim'  => $inpDataFim,
            'inputempresa'  => $inpEmpresa
        ]);
    }

    public function expAthenas()
    {
        $inpDataIni = $this->request->getPost('dataini');
        $inpDataFim = $this->request->getPost('datafim');
        $inpEmpresa = $this->request->getPost('empresapi');

        $tbPIs = $this->pisModel->find();
        $pis_api = $this->getPI($inpDataIni, $inpDataFim, $inpEmpresa);

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

        $rowNum = 2;

        foreach ($pis_api as $pi) {
            $pifechado = array_search($pi['id'], array_column($tbPIs, 'idpi'));
            if ($pifechado == false) {

                $sheet->setCellValue('A' . $rowNum, $pi['cliente']);
                $sheet->setCellValue('B' . $rowNum, $pi['cliente_cnpj']);
                $sheet->setCellValue('C' . $rowNum, $pi['data_da_venda']);
                $sheet->setCellValue('D' . $rowNum, 'TIPO DE PUBLICAÇÃO: ' . $pi['tipo_publicacao_pi'] . " - " . $pi['descricao_servico'] . ' - DATA VEICULAÇÃO: ' . date('d/m/Y', strtotime(end($pi['periodo_veiculacao'])['periodo_ate'])) . ' PI: ' . $pi['nr_pi']);
                $sheet->setCellValue('E' . $rowNum, str_replace(".", "", $pi['valor_liquido']));
                $sheet->setCellValue('F' . $rowNum, '1007');
                $sheet->setCellValue('G' . $rowNum, '2408102');
                $sheet->setCellValue('H' . $rowNum, $pi['id']);
                $sheet->setCellValue('I' . $rowNum, $pi['empresa_prestadora'] == "PARAMETRO AGENCIA DE NOTICIAS" ? '356028' : '354932');
                $sheet->setCellValue('J' . $rowNum, '8');
                $sheet->setCellValue('K' . $rowNum, $pi['endereco_cliente'] . " N: " . $pi['endereco_numero_cliente']);
                $sheet->setCellValue('L' . $rowNum, $pi['bairro_cliente']);
                $sheet->setCellValue('M' . $rowNum, $pi['cep_cliente']);
                $sheet->setCellValue('N' . $rowNum, $pi['uf_cliente']);
                $sheet->setCellValue('O' . $rowNum, $pi['nr_pi']);
                $sheet->setCellValue('P' . $rowNum, $pi['email_cliente']);

                $rowNum++;
            }
            
        }

        $sheet->setTitle('pis_athenas');
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="pis_athenas_' . date("dmYHms") . '.xlsx"');
        $writer->save('php://output');

    }
}
