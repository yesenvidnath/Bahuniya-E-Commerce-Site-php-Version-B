<?php
require('../tcpdf/src/Tcpdf.php');

// Check if the button is clicked
if (isset($_POST['generateReport'])) {
    // PDF generation code using TCPDF
    generateMonthlyIncomeReport();
}

function generateMonthlyIncomeReport() {
    // Create a new TCPDF instance
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator('Your Company');
    $pdf->SetAuthor('Your Company');
    $pdf->SetTitle('Monthly Income Report');
    $pdf->SetSubject('Monthly Income Report');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('dejavusans', '', 12);

    // Add content to the PDF (replace this with your actual report content)
    $pdf->Cell(0, 10, 'Monthly Income Report', 0, 1, 'C');
    $pdf->Ln();

    // Fetch data from the database (you may need to customize this query)
    $orderQuery = "SELECT * FROM OrderTable";
    $orderResult = mysqli_query($conn, $orderQuery);

    while ($orderRow = mysqli_fetch_assoc($orderResult)) {
        $pdf->Cell(50, 10, 'Order ID: ' . $orderRow['OrderID'], 0, 0);
        $pdf->Cell(50, 10, 'Order Total: ' . $orderRow['OrderTotal'], 0, 1);
    }

    // Output the PDF to the browser
    $pdf->Output('monthly_income_report.pdf', 'D');
    exit();
}
?>
