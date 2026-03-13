<?php
require_once BASE_PATH . '/app/controllers/BaseUserController.php';
require_once BASE_PATH . '/app/models/OrderModels.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class UserStatusController extends BaseUserController
{
    private $orderModel;

    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new OrderModel();
    }

    /**
     * Menampilkan halaman status order untuk customer
     */
    public function index()
    {
        $customerId = $_SESSION['user']['id'];

        // Ambil semua order customer
        $orders = $this->orderModel->getOrdersByCustomer($customerId);

        $this->render('status', [
            'orders' => $orders
        ]);
    }

    public function downloadInvoice()
    {
        $orderId = $_GET['id'] ?? null;

        if (!$orderId) {
            $_SESSION['toast'] = [
                'type' => 'danger',
                'message' => 'Order ID not found'
            ];
            header('Location: ' . BASE_URL . 'index.php?c=userStatus&m=index');
            exit;
        }

        $orderModel = new OrderModel();

        $order = $orderModel->getOrderByIdForCustomerSingle($orderId, $_SESSION['user']['id']);

        if (!$order) {
            $_SESSION['toast'] = [
                'type' => 'danger',
                'message' => 'Order not found'
            ];
            header('Location: ' . BASE_URL . 'index.php?c=userStatus&m=index');
            exit;
        }

        $orderItems = $order['items'] ?? [];

        var_dump($orderId, $_SESSION['user']['id']);
        exit;

        ob_start();
        require_once BASE_PATH . "/app/views/user/invoice_pdf.php";
        $html = ob_get_clean();

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = "Invoice-Order-#" . str_pad($order['id'], 6, '0', STR_PAD_LEFT) . ".pdf";
        $dompdf->stream($filename, ["Attachment" => true]);
    }
}
