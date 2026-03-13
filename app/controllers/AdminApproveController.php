<?php

require_once BASE_PATH . '/app/controllers/BaseAdminController.php';
require_once BASE_PATH . '/app/models/OrderModels.php';
require_once BASE_PATH . '/app/models/ProductModels.php';
require_once BASE_PATH . '/app/models/NotificationModels.php';

class AdminApproveController extends BaseAdminController
{
    private $orderModel;
    private $productModel;
    private $notificationModel;

    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new OrderModel();
        $this->productModel = new ProductModel();
        $this->notificationModel = new NotificationModel();
    }

    /**
     * Menampilkan halaman approve (list semua order)
     */
    public function index()
    {
        // Get seller ID dari session
        $sellerId = $_SESSION['user']['id'];

        $perPage = 25;
        $page = $_GET['page'] ?? 1;
        $page = max(1, (int)$page);

        $offset = ($page - 1) * $perPage;

        $orders = $this->orderModel->getOrdersBySellerPaginated($sellerId, $perPage, $offset);
        $totalOrders = $this->orderModel->countOrdersBySeller($sellerId);
        $totalPages = ceil($totalOrders / $perPage);

        // Render view
        $this->render('approve', [
            'title' => 'Approve | iTama Book',
            'menu'  => 'approve',
            'orders' => $orders,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function approveOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'index.php?c=adminApprove&m=index');
            exit;
        }

        $orderId  = $_POST['order_id'] ?? null;
        $sellerId = $_SESSION['user']['id'];

        if (!$orderId) {
            $_SESSION['toast'] = ['type' => 'danger', 'message' => 'Order not found'];
            header('Location: ' . BASE_URL . 'index.php?c=adminApprove&m=index');
            exit;
        }

        $order = $this->orderModel->getOrderByIdForSeller($orderId, $sellerId);

        if (!$order) {
            $_SESSION['toast'] = ['type' => 'danger', 'message' => 'Access denied'];
            header('Location: ' . BASE_URL . 'index.php?c=adminApprove&m=index');
            exit;
        }

        if ($order['status'] !== 'pending') {
            $_SESSION['toast'] = ['type' => 'warning', 'message' => 'Order already processed'];
            header('Location: ' . BASE_URL . 'index.php?c=adminApprove&m=index');
            exit;
        }

        $cashPaid = $_POST['cash_paid'] ?? 0;
        $cashChange = $cashPaid - $order['total_amount'];

        if ($cashPaid < $order['total_amount']) {

            $_SESSION['toast'] = [
                'type' => 'danger',
                'message' => 'Customer money not enough'
            ];

            header('Location: ' . BASE_URL . 'index.php?c=adminApprove&m=index');
            exit;
        }

        $db = Database::getInstance();

        try {
            $db->beginTransaction();

            $items = $this->orderModel->getOrderItemsOnly($orderId);

            foreach ($items as $item) {

                $product = $this->productModel->getById($item['product_id']);

                if ($product['stock'] < $item['qty']) {
                    throw new Exception("Stock not enough for {$product['name']}");
                }

                $updated = $this->productModel->updateStock($item['product_id'], $item['qty']);

                if (!$updated) {
                    throw new Exception("Failed reduce stock");
                }
            }

            $this->orderModel->updateCashPayment($orderId, $cashPaid, $cashChange);
            $this->orderModel->updateOrderStatus($orderId, 'completed');
            $this->orderModel->updatePaymentStatus($orderId, 'paid');
            $this->orderModel->updateShippingStatus($orderId, 'shipped');

            $this->notificationModel->deleteByOrder($orderId, 'new_order');
            $this->notificationModel->create([
                'user_id' => $order['customer_id'],
                'order_id' => $orderId,
                'type' => 'order_completed',
                'title' => 'Order Completed',
                'message' => "Your order #" . str_pad($orderId, 6, '0', STR_PAD_LEFT) . " has been approved"
            ]);

            $db->commit();

            $_SESSION['toast'] = ['type' => 'success', 'message' => 'Order approved'];
        } catch (Exception $e) {

            $db->rollBack();

            $_SESSION['toast'] = [
                'type' => 'danger',
                'message' => $e->getMessage()
            ];
        }

        header('Location: ' . BASE_URL . 'index.php?c=adminApprove&m=index');
        exit;
    }
}
