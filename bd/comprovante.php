<?php
require_once('../pdf/src/mpdf.php');

$paniga = 
"
<html>
    <body>
        <h1> OI </h1>
    </body>
</html>
";

$arquivo = "compra1.pdf";
$mpdf = new mPDF();
$mpdf = WriteHTML($paniga);

$mpdf->Output($arquivo, 'I');

?>

