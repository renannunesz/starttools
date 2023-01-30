<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PI extends BaseController
{
    function recebeDados()
    {
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://agorarn.datavence.com.br/api/private/faturamentosLiberados',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POST => true,
        //CURLOPT_POSTFIELDS => array('numero_pi' => '15489/2021'),
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

    public function contPI()
    {
        return count($this->recebeDados());
    }

    public function index()
    {

        return view('api', [
            'dados_pi' => $this->recebeDados(),
            'qtd_pi' => $this->contPI()
        ]);
        
    }

    public function filtros()
    {
        $filtroData     = $this->request->getGet('dataPI');
        $filtroEmissao  = $this->request->getGet('tpemissaoPI');
        $filtroEmpresa  = $this->request->getGet('empresaPI');

        $dados = $this->recebeDados();

        //return 'Data: ' . $filtroData . ' Empresa: ' . $filtroEmpresa . ' Tipo Emissao: ' . $filtroEmissao; 

        $filtroAplicado = array_filter($dados, function($dados) { return $dados['empresa_prestadora'] == $this->request->getGet('empresaPI'); });

        return view('api', [
            'dados_pi' => $filtroAplicado,
        ]);

    }

    public function homologAPI()
    {
        return view('homolog', [
            'dados_pi' => $this->recebeDados(),
            'baseurl' => base_url(),
        ]);
    }

    public function exportar()
    {
        $piDados = $this->recebeDados();
        $piQtd = $this->contPI();
        $tabDados = new Spreadsheet();
        
        $tab = $tabDados->getActiveSheet();

        $tab->setCellValue('A1', 'Nome Cliente/Fornecedor');
        $tab->setCellValue('B1', 'CNPJ/CPF');
        $tab->setCellValue('C1', 'Data Registro');
        $tab->setCellValue('D1', 'Observação');
        $tab->setCellValue('E1', 'Valor Total');
        $tab->setCellValue('F1', 'Cod Serviço');
        $tab->setCellValue('G1', 'Código Municipio Prestador');
        $tab->setCellValue('H1', 'Numero NF');
        $tab->setCellValue('I1', 'Cod. Produto');
        $tab->setCellValue('J1', 'Forma de Pagamento');
        $tab->setCellValue('K1', 'Emissao');
        $tab->setCellValue('L1', 'Veiculação');
        $tab->setCellValue('M1', 'Empresa');
        
        $tab->getStyle('A1:M1')->getFont()->setBold(true);

        for ($i=0; $i < $piQtd ; $i++) { 
            $tab->setCellValue('A' . $i+2, $piDados[$i]['cliente']);
            $tab->setCellValue('B' . $i+2, $piDados[$i]['cliente_cnpj']);
            $tab->setCellValue('C' . $i+2, $piDados[$i]['data_da_venda']);
            $tab->setCellValue('D' . $i+2, $piDados[$i]['descricao_servico']);
            $tab->setCellValue('E' . $i+2, $piDados[$i]['valor_liquido']);
            $tab->setCellValue('F' . $i+2, '3501');
            $tab->setCellValue('G' . $i+2, '2408102');
            $tab->setCellValue('H' . $i+2, $i + 1);
            $tab->setCellValue('I' . $i+2, '354932');
            $tab->setCellValue('J' . $i+2, '8');
            $tab->setCellValue('K' . $i+2, $piDados[$i]['emitido_por']);
            $tab->setCellValue('L' . $i+2, $piDados[$i]['periodo_veiculacao'][$i]['periodo_ate']);
            $tab->setCellValue('M' . $i+2, $piDados[$i]['empresa_prestadora']);
        }

        $tab->setTitle('PIs_AgoraRN');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="dados_pis.xls"');

        $writer = new Xlsx($tabDados);
        //$writer->save('C:\Users\Renan Nunes\Downloads\PIs_AgoraRN.xlsx');
        $writer->save('php://output');

        return view('api');
    }

    public function export()
    {
        $dadosTabela = $this->request->getPost('inp_h_tabdados');

        if ( isset($dadosTabela) ) {

            $temporary_html_file = 'C:\xampp\htdocs\agorarn\app\Views\tmp_html' . time() . '.html';

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