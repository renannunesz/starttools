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
            CURLOPT_URL => 'https://sistema.meusistema.dev.br/api/private/faturasPI', //https://sistema.meusistema.dev.br/api/private/faturamentosLiberados
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => '{  
                "empresa_prestadora": ' . $piEmpresa . ', 
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

        $return = json_decode($response, true);

        $dados = json_decode($return, true);

        return $dados;
    }

    public function index()
    {

        $tbPIs = $this->pisModel->find();

        $pis_api_parametro = $this->getPI(date('Y-m-d'), date('Y-m-d'), 1);
        $pisLancados_parametro = [];
        $pisBaixados_parametro = [];

        foreach ($pis_api_parametro as $pi) {
            $piBaixado_parametro = array_search($pi['id_pi'], array_column($tbPIs, 'idpi'));
            if ($piBaixado_parametro == false) {
                $pisLancados_parametro[] = $pi;
            }
        }

        foreach ($pis_api_parametro as $pi) {
            $piBaixado_parametro = array_search($pi['id_pi'], array_column($tbPIs, 'idpi'));
            if ($piBaixado_parametro == true) {
                $pisBaixados_parametro[] = $pi;
            }
        }

        $pis_api_adeo = $this->getPI(date('Y-m-d'), date('Y-m-d'), 2);
        $pisLancados_adeo = [];
        $pisBaixados_adeo = [];

        foreach ($pis_api_adeo as $pi) {
            $piBaixado_adeo = array_search($pi['id_pi'], array_column($tbPIs, 'idpi'));
            if ($piBaixado_adeo == false) {
                $pisLancados_adeo[] = $pi;
            }
        }

        foreach ($pis_api_adeo as $pi) {
            $piBaixado_adeo = array_search($pi['id_pi'], array_column($tbPIs, 'idpi'));
            if ($piBaixado_adeo == true) {
                $pisBaixados_adeo[] = $pi;
            }
        }

        return view('home', [
            'pisLancados_parametro' => $pisLancados_parametro,
            'pisBaixados_parametro' => $pisBaixados_parametro,
            'pisLancados_adeo' => $pisLancados_adeo,
            'pisBaixados_adeo' => $pisBaixados_adeo
        ]);
    }

    public function homologAPI()
    {

        $this->request->getPost('dtinihomolog') == null ? $dtinihomolog = date('Y-m-d') : $dtinihomolog = $this->request->getPost('dtinihomolog');
        $this->request->getPost('dtfimhomolog') == null ? $dtfimhomolog = date('Y-m-d') : $dtfimhomolog = $this->request->getPost('dtfimhomolog');
        $this->request->getPost('empresahomolog') == null ? $empresahomolog = 0 : $empresahomolog = $this->request->getPost('empresahomolog');

        $dados_pis = $this->getPI($dtinihomolog, $dtfimhomolog, $empresahomolog);

        return view('homolog', [
            'dados_pi' => $dados_pis,
        ]);
    }

    public function pisLancados()
    {

        $this->request->getPost('dataPIini') == null ? $inpDataIni = date('Y-m-d') : $inpDataIni = $this->request->getPost('dataPIini');
        $this->request->getPost('dataPIfim') == null ? $inpDataFim = date('Y-m-d') : $inpDataFim = $this->request->getPost('dataPIfim');
        $this->request->getPost('empresaPI') == null ? $inpEmpresa = 0 : $inpEmpresa = $this->request->getPost('empresaPI');
        $inpTipo = 1;

        $tbPIs = $this->pisModel->find();
        $pis_api = $this->getPI($inpDataIni, $inpDataFim, $inpEmpresa);
        $pisAbertos = [];

        foreach ($pis_api as $pi) {
            $pifechado = array_search($pi['id_pi'], array_column($tbPIs, 'idpi'));
            if ($pifechado == false) {
                $pisAbertos[] = $pi;
            }
        }

        return view('pis', [
            'dados_pi'      => $pisAbertos,
            'tbpis'         => $this->pisModel->find(),
            'inputdataini'  => $inpDataIni,
            'inputdatafim'  => $inpDataFim,
            'inputempresa'  => $inpEmpresa,
            'tipopi'        => $inpTipo
        ]);
    }

    public function pisBaixados()
    {

        $this->request->getPost('dataPIini') == null ? $inpDataIni = date('Y-m-d') : $inpDataIni = $this->request->getPost('dataPIini');
        $this->request->getPost('dataPIfim') == null ? $inpDataFim = date('Y-m-d') : $inpDataFim = $this->request->getPost('dataPIfim');
        $this->request->getPost('empresaPI') == null ? $inpEmpresa = 0 : $inpEmpresa = $this->request->getPost('empresaPI');
        $inpTipo = 2;

        $tbPIs = $this->pisModel->find();
        $pis_api = $this->getPI($inpDataIni, $inpDataFim, $inpEmpresa);
        $pisFechados = [];

        foreach ($pis_api as $pi) {
            $pifechado = array_search($pi['id_pi'], array_column($tbPIs, 'idpi'));
            if ($pifechado == true) {
                $pisFechados[] = $pi;
            }
        }

        return view('pis', [
            'dados_pi'      => $pisFechados,
            'tbpis'         => $this->pisModel->find(),
            'inputdataini'  => $inpDataIni,
            'inputdatafim'  => $inpDataFim,
            'inputempresa'  => $inpEmpresa,
            'tipopi'        => $inpTipo
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
        $sheet->setCellValue('Q1', 'Data Emissao');
        $sheet->setCellValue('R1', 'Emitido por');

        $rowNum = 2;

        foreach ($pis_api as $pi) {
            $pifechado = array_search($pi['id_pi'], array_column($tbPIs, 'idpi'));
            if ($pifechado == false) {

                $sheet->setCellValue('A' . $rowNum, $pi['cliente']);
                $sheet->setCellValue('B' . $rowNum, $pi['cliente_cnpj']);
                $sheet->setCellValue('C' . $rowNum, $pi['data_da_venda']);
                $sheet->setCellValue('D' . $rowNum, 'TIPO DE PUBLICAÇÃO: ' . $pi['tipo_publicacao_pi'] . " - " . $pi['descricao_servico'] . ' - DATA VEICULAÇÃO: ' . date('d/m/Y', strtotime(end($pi['periodo_veiculacao'])['periodo_ate'])) . ' PI: ' . $pi['nr_pi']);
                $sheet->setCellValue('E' . $rowNum, $pi['tipo_de_fatura'] == "BRUTO C/ CLIENTE" ? str_replace(".", "", $pi['valor_bruto']) : str_replace(".", "", $pi['valor_liquido']));
                $sheet->setCellValue('F' . $rowNum, '1007');
                $sheet->setCellValue('G' . $rowNum, '2408102');
                $sheet->setCellValue('H' . $rowNum, $pi['id_pi']);
                $sheet->setCellValue('I' . $rowNum, $pi['empresa_prestadora'] == "PARAMETRO AGENCIA DE NOTICIAS" ? '356028' : '354932');
                $sheet->setCellValue('J' . $rowNum, '8');
                $sheet->setCellValue('K' . $rowNum, $pi['endereco_cliente'] . " N: " . $pi['endereco_numero_cliente']);
                $sheet->setCellValue('L' . $rowNum, $pi['bairro_cliente']);
                $sheet->setCellValue('M' . $rowNum, $pi['cep_cliente']);
                $sheet->setCellValue('N' . $rowNum, $pi['uf_cliente']);
                $sheet->setCellValue('O' . $rowNum, $pi['nr_pi']);
                $sheet->setCellValue('P' . $rowNum, $pi['send_mail_nf']);
                $sheet->setCellValue('Q' . $rowNum, $pi['data_liberacao']);
                $sheet->setCellValue('R' . $rowNum, $pi['emitido_por']);

                $rowNum++;
            }
        }

        $sheet->setTitle('pis_athenas');
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="pis_athenas_' . date("dmYHms") . '.xlsx"');
        $writer->save('php://output');
    }

    public function gravaStatus()
    {

        $this->pisModel->save($this->request->getPost());

        $inpDataIni = $this->request->getPost('dataini');
        $inpDataFim = $this->request->getPost('datafim');
        $inpEmpresa = $this->request->getPost('empresapi');
        $inpTipo    = $this->request->getPost('tppi');

        $tbPIs = $this->pisModel->find();
        $pis_api = $this->getPI($inpDataIni, $inpDataFim, $inpEmpresa);
        $pisAbertos = [];

        foreach ($pis_api as $pi) {
            $pifechado = array_search($pi['id_pi'], array_column($tbPIs, 'idpi'));
            if ($pifechado == false) {
                $pisAbertos[] = $pi;
            }
        }

        return view('pis', [
            'dados_pi'      => $pisAbertos,
            'tbpis'         => $this->pisModel->find(),
            'inputdataini'  => $inpDataIni,
            'inputdatafim'  => $inpDataFim,
            'inputempresa'  => $inpEmpresa,
            'tipopi'        => $inpTipo
        ]);
    }

    public function desfasBaixa($idpi)
    {

        $this->pisModel->where('idpi', $idpi)->delete();

        $inpDataIni = $this->request->getPost('dataini');
        $inpDataFim = $this->request->getPost('datafim');
        $inpEmpresa = $this->request->getPost('empresapi');
        $inpPI      = $this->request->getPost('idpi');
        $inpTipo    = $this->request->getPost('tppi');

        $tbPIs = $this->pisModel->find();
        $pis_api = $this->getPI($inpDataIni, $inpDataFim, $inpEmpresa);
        $pisFechados = [];

        foreach ($pis_api as $pi) {
            $pifechado = array_search($pi['id_pi'], array_column($tbPIs, 'idpi'));
            if ($pifechado == true) {
                $pisFechados[] = $pi;
            }
        }

        return view('pis', [
            'dados_pi'      => $pisFechados,
            'tbpis'         => $this->pisModel->find(),
            'inputdataini'  => $inpDataIni,
            'inputdatafim'  => $inpDataFim,
            'inputempresa'  => $inpEmpresa,
            'tipopi'        => $inpTipo
        ]);
    }

    public function pisComissoes()
    {
        $this->request->getPost('dataPIini') == null ? $inpDataIni = date('Y-m-d') : $inpDataIni = $this->request->getPost('dataPIini');
        $this->request->getPost('dataPIfim') == null ? $inpDataFim = date('Y-m-d') : $inpDataFim = $this->request->getPost('dataPIfim');
        $this->request->getPost('empresaPI') == null ? $inpEmpresa = 0 : $inpEmpresa = $this->request->getPost('empresaPI');

        $pis_api = $this->getPI($inpDataIni, $inpDataFim, $inpEmpresa);

        $VLTotal = 0;
        $VCAtotal = 0;
        $VCRtotal = 0;
        $VCVtotal = 0;
        foreach ($pis_api as $pi) {
            $VLTotal = $VLTotal + floatval($pi['valor_liquido']);
            $VCAtotal = $VCAtotal + floatval($pi['comissao_agencia']);
            $VCRtotal = $VCRtotal + floatval($pi['comissao_representante']);
            $VCVtotal = $VCVtotal + floatval($pi['comissao_vendedor']);
        }

        return view('comissoes', [
            'inputdataini'  => $inpDataIni,
            'inputdatafim'  => $inpDataFim,
            'inputempresa'  => $inpEmpresa,
            'dados_pi' => $pis_api,
            'vl_total' => $VLTotal,
            'vca_total' => $VCAtotal,
            'vcr_total' => $VCRtotal,
            'vcv_total' => $VCVtotal,
        ]);
    }

    public function expComissoes()
    {
        $this->request->getPost('dataPIini') == null ? $inpDataIni = date('Y-m-d') : $inpDataIni = $this->request->getPost('dataPIini');
        $this->request->getPost('dataPIfim') == null ? $inpDataFim = date('Y-m-d') : $inpDataFim = $this->request->getPost('dataPIfim');
        $this->request->getPost('empresaPI') == null ? $inpEmpresa = 0 : $inpEmpresa = $this->request->getPost('empresaPI');

        $pis_api = $this->getPI($inpDataIni, $inpDataFim, $inpEmpresa);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Num. PI');
        $sheet->setCellValue('B1', 'Venda');
        $sheet->setCellValue('C1', 'Liberacao');
        $sheet->setCellValue('D1', 'Cliente');
        $sheet->setCellValue('E1', 'Vendedor');
        $sheet->setCellValue('F1', 'Valor Liquido');
        $sheet->setCellValue('G1', 'Comissao Agencia');
        $sheet->setCellValue('H1', 'Comissao Representante');
        $sheet->setCellValue('I1', 'Comissao Vendedor');

        $rowNum = 2;

        foreach ($pis_api as $pi) {

            $sheet->setCellValue('A' . $rowNum, $pi['nr_pi']);
            $sheet->setCellValue('B' . $rowNum, $pi['data_da_venda']);
            $sheet->setCellValue('C' . $rowNum, $pi['data_liberacao']);
            $sheet->setCellValue('D' . $rowNum, $pi['cliente']);
            $sheet->setCellValue('E' . $rowNum, $pi['vendedor']);
            $sheet->setCellValue('F' . $rowNum, $pi['valor_liquido']);
            $sheet->setCellValue('G' . $rowNum, $pi['comissao_agencia']);
            $sheet->setCellValue('H' . $rowNum, $pi['comissao_representante']);
            $sheet->setCellValue('I' . $rowNum, $pi['comissao_vendedor']);
            $rowNum++;
        }

        $sheet->setTitle('pis_athenas');
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="pis_athenas_' . date("dmYHms") . '.xlsx"');
        $writer->save('php://output');
    }

    /*
    DESUSO

    function getPI_old($piInicio, $piFim, $piEmpresa)
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
    */
}
