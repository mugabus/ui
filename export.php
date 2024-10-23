<?php
require 'db.php';


// Check which export option was selected (PDF or CSV)
if (isset($_POST['export'])) {
    $format = $_POST['export'];

    // Fetch the data to export
    $sql = "SELECT * FROM water_quality ORDER BY created_at DESC";
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($format === 'csv') {
        // Export to CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="water_quality_report.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, array('ID', 'pH', 'Turbidity', 'Chlorine', 'Conductivity', 'Temperature', 'Date'));

        foreach ($data as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
        exit;
    } elseif ($format === 'pdf') {
        // Check if FPDF library exists
        $fpdfPath = 'libs/fpdf.php'; // Update path if needed

        if (file_exists($fpdfPath)) {
            require $fpdfPath; // Ensure correct path to fpdf.php

            // Initialize FPDF and create PDF
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 12);

            // Table header
            $pdf->Cell(10, 10, 'ID', 1);
            $pdf->Cell(20, 10, 'pH', 1);
            $pdf->Cell(30, 10, 'Turbidity', 1);
            $pdf->Cell(30, 10, 'Chlorine', 1);
            $pdf->Cell(30, 10, 'Conductivity', 1);
            $pdf->Cell(30, 10, 'Temperature', 1);
            $pdf->Cell(40, 10, 'Date', 1);
            $pdf->Ln();

            // Add data rows to PDF
            foreach ($data as $row) {
                $pdf->Cell(10, 10, $row['id'], 1);
                $pdf->Cell(20, 10, $row['pH'], 1);
                $pdf->Cell(30, 10, $row['turbidity'], 1);
                $pdf->Cell(30, 10, $row['chlorine'], 1);
                $pdf->Cell(30, 10, $row['conductivity'], 1);
                $pdf->Cell(30, 10, $row['temperature'], 1);
                $pdf->Cell(40, 10, $row['created_at'], 1);
                $pdf->Ln();
            }

            // Output PDF for download
            $pdf->Output('D', 'water_quality_report.pdf');
            exit;
        } else {
            // Handle error when FPDF library is not found
            echo "FPDF library not found. Please ensure 'fpdf.php' is included in your project.";
            exit;
        }
    }
}
?>
