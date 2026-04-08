<?php
require_once BASE_PATH . '/app/controllers/BaseAdminController.php';
require_once BASE_PATH . '/app/models/AdminModels.php';
require_once BASE_PATH . '/app/models/OrderModels.php';

class AdminOrderController extends BaseAdminController
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

        $this->render('reports', [
            'title'     => 'Sales Report',
            'menu'      => 'seller_reports'
        ]);
    }

    public function byCustomer()
    {
        $adminId = $_SESSION['user']['id'];
        $customerId = $_GET['id'] ?? null;

        if (!$customerId) {
            die('Customer ID not found');
        }

        // 🔥 ambil data orders customer (sudah ada functionnya)
        $orders = $this->orderModel->getOrdersByCustomer($customerId);

        $this->render('list_order', [
            'title' => 'Users Orders | iTama Book',
            'menu'  => 'orders',
            'orders' => $orders
        ]);
    }
}
