<?php
include("../includes/logincheck.php");
if(!empty($_POST)) {
  if(!empty($_POST['download-pdf'])){
    if (!ini_get('display_errors')) {
        ini_set('display_errors', '1');
    }
    require_once('../includes/html2pdf_v4.03/html2pdf.class.php');
    $iEvaluationId = $_POST['evaluation-id'];
    $html2pdf = new HTML2PDF('P', 'A4', 'en');
    
    $username = 'dev';
    $password = 'bradf0rd1911';
     
    $context = stream_context_create(array(
        'http' => array(
            'header'  => "Authorization: Basic " . base64_encode("$username:$password")
        )
    ));
    $content = file_get_contents('http://jamestoothill.co.uk/dev/eval/admin/view_eval_pdf.php?skip_auth=1HGstGtw8272891H&eval_id='.$iEvaluationId.'&remove_formatting=true', false, $context);
    $objEvaluation = new Evaluation(NULL, NULL);
    $objEvaluation->emailEvaluation('jimmytootall3@gmail.com', 'James Toothill', $content);
    //echo $content;
    //$html2pdf->WriteHTML($content);
    //$html2pdf->Output('exemple.pdf');
    exit;
  }
}

?>