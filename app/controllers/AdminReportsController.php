<?php

use Dompdf\Dompdf;
use Dompdf\Options;

require_once BASE_PATH . '/app/controllers/BaseAdminController.php';
require_once BASE_PATH . '/app/models/AdminModels.php';
require_once BASE_PATH . '/app/models/OrderModels.php';

class AdminReportsController extends BaseAdminController
{
    private $adminModel;
    private $orderModel;

    public function __construct()
    {
        parent::__construct();
        $this->adminModel = new AdminModel();
        $this->orderModel  = new OrderModel();
    }

    public function index()
    {
        $adminId = $_SESSION['user']['id'];

        $month = (int)($_GET['month'] ?? date('m'));
        $year  = (int)($_GET['year'] ?? date('Y'));

        $rawChart = $this->orderModel->getSalesChartBySeller($adminId, $month, $year);

        $chartData = [
            'dates'  => [],
            'totals' => []
        ];

        foreach ($rawChart as $row) {
            $chartData['dates'][]  = date('d M', strtotime($row['order_date']));
            $chartData['totals'][] = (int) $row['total_sales'];
        }

        $revenues  = $this->orderModel->getRevenueReportBySeller($adminId, $month, $year);
        $summary   = $this->orderModel->getSellerReportSummary($adminId, $month, $year);

        $this->render('reports', [
            'title'     => 'Sales Report',
            'menu'      => 'seller_reports',
            'chartData' => $chartData,
            'revenues'  => $revenues ?? [],
            'summary'   => $summary ?? [],
            'month'     => $month,
            'year'      => $year
        ]);
    }

    public function exportPdf()
    {
        $adminId = $_SESSION['user']['id'];

        $month = $_POST['month'] ?? date('m');
        $year  = $_POST['year'] ?? date('Y');

        $chartImage = $_POST['chart_image'] ?? null;

        $chartData = $this->orderModel->getSalesChartBySeller($adminId, $month, $year);
        $revenues  = $this->orderModel->getRevenueReportBySeller($adminId, $month, $year);
        $summary   = $this->orderModel->getSellerReportSummary($adminId, $month, $year);

        ob_start();
        include BASE_PATH . '/app/views/admin/report_pdf.php';
        $html = ob_get_clean();

        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream(
            "sales-report-{$month}-{$year}.pdf",
            ['Attachment' => true]
        );
    }
}
