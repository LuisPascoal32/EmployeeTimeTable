<?php

require('tcpdf/tcpdf.php');

function sendPdffile($nome,$fd,$sd) {

    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $obj_pdf->SetCreator(PDF_CREATOR);
    $obj_pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");
    $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $obj_pdf->SetDefaultMonospacedFont('helvetica');
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
    $obj_pdf->setPrintHeader(false);
    $obj_pdf->setPrintFooter(false);
    $obj_pdf->SetAutoPageBreak(TRUE, 10);
    $obj_pdf->SetFont('helvetica', '', 10);
    $obj_pdf->AddPage();
    $content .= '  
      <h3 align="center">List all students</h3><br /><br /><br />
      <table border="1" cellspacing="0" cellpadding="5">  
           <tr>  
                <th width="25%"><strong>Nome</strong></th>  
                <th width="25%"><strong>Data</strong></th>  
                <th width="25%"><strong>Registo Entrada</strong></th>  
                <th width="25%"><strong>Registo Saida</strong></th>   
           </tr>  
      ';


    $content .= output($nome, $fd, $sd);
    $content .= '</table>';
    $obj_pdf->writeHTML($content);
    ob_clean();
    $obj_pdf->Output('sample.pdf', 'I');
}

function output() {

    $conn = mysqli_connect("127.0.0.1", "root", "12345.Luis", "teste");

    /**if ($nome == 'Todos') {
        $sql = mysqli_query($conn, "select e.nome, r.data,r.entrada,r.saida from registo r, Funcionario e where e.id=r.Funcionario_id and data>='$fd' and data<='$sd' order by Funcionario_id;");
    }*/
    $sql = mysqli_query($conn, "select e.nome, r.data,r.entrada,r.saida from registo r, Funcionario e where e.id=r.Funcionario_id and data>='2017-1-1' and data<='2017-1-18' order by Funcionario_id;");


    //$output= '<table><tr><th class="col-md-2">Name</th><th class="col-md-1">SSN</th><th class="col-md-1">Birthdate</th><th class="col-md-2">Email</th><th class="col-md-1">Phone</th><th class="col-md-1">Experience</th><th class="col-md-1">Address</th><th class="col-md-1">Role</th><th class="col-md-1"></th><th class="col-md-1"></th></tr>';


    while ($row = mysqli_fetch_assoc($sql)) {
        $output .= '<tr>  
                          <td>' . $row["nome"] . '</td>  
                          <td>' . $row["data"] . '</td>  
                          <td>' . $row["entrada"] . '</td>  
                          <td>' . $row["saida"] . '</td>  
                            
                     </tr>  
                          ';
    }


    return $output;
}
