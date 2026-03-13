<?php

require_once BASE_PATH . '/app/controllers/BaseUserController.php';
require_once BASE_PATH . '/app/models/CartModels.php';
require_once BASE_PATH . '/app/models/ProductModels.php';
require_once BASE_PATH . '/app/models/OrderModels.php';
require_once BASE_PATH . '/app/models/NotificationModels.php';
require_once BASE_PATH . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class UserOrderController extends BaseUserController
{
    private $orderModel;
    private $cartModel;
    private $productModel;
    private $notificationModel;

    public function __construct()
    {
        parent::__construct();
        $this->orderModel   = new OrderModel();
        $this->cartModel    = new CartModel();
        $this->productModel = new ProductModel();
        $this->notificationModel = new NotificationModel();
    }

    public function checkoutAll()
    {
        $customerId = $_SESSION['user']['id'];

        $cartItems = $this->cartModel->getCartByUser($customerId);

        if (empty($cartItems)) {
            $_SESSION['toast'] = [
                'type' => 'warning',
                'message' => 'Cart is empty'
            ];

            header('Location: ' . BASE_URL . 'index.php?c=userCart&m=index');
            exit;
        }

        $totalOrder = 0;
        $sellers = [];

        foreach ($cartItems as $item) {

            $product = $this->productModel->getById($item['product_id']);

            $pendingQty = $this->orderModel
                ->getPendingQtyByProduct($item['product_id']);

            $availableStock = $product['stock'] - $pendingQty;

            if ($availableStock < $item['qty']) {

                $_SESSION['toast'] = [
                    'type' => 'danger',
                    'message' => "Product {$product['name']} stock is reserved"
                ];

                header('Location: ' . BASE_URL . 'index.php?c=userCart&m=index');
                exit;
            }

            $subtotal = $item['price'] * $item['qty'];

            $totalOrder += $subtotal;

            $sellerId = $item['seller_id'];

            if (!isset($sellers[$sellerId])) {

                $sellers[$sellerId] = [
                    'id' => $sellerId,
                    'seller_name' => $item['seller_name'],
                    'items' => [],
                    'total' => 0
                ];
            }

            $sellers[$sellerId]['items'][] = $item;
            $sellers[$sellerId]['total'] += $subtotal;
        }

        $this->render('checkout', [
            'cartItems' => $cartItems,
            'sellers' => $sellers,
            'totalOrder' => $totalOrder
        ]);
    }

    public function placeOrderAll()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'index.php?c=userCart&m=index');
            exit;
        }

        $customerId = $_SESSION['user']['id'];

        $cartItems = $this->cartModel->getCartByUser($customerId);

        if (empty($cartItems)) {
            $_SESSION['toast'] = [
                'type' => 'warning',
                'message' => 'Cart is empty'
            ];
            header('Location: ' . BASE_URL . 'index.php?c=userCart&m=index');
            exit;
        }

        /* ======================
       GROUP CART BY SELLER
    ====================== */

        $grouped = [];

        foreach ($cartItems as $item) {
            $grouped[$item['seller_id']][] = $item;
        }

        $createdOrders = [];

        foreach ($grouped as $sellerId => $items) {

            // HITUNG TOTAL ORDER
            $totalOrder = 0;

            foreach ($items as $item) {
                $totalOrder += $item['price'] * $item['qty'];
            }

            // CREATE ORDER
            $orderId = $this->orderModel->create([
                'customer_id' => $customerId,
                'seller_id'   => $sellerId,
                'total_amount' => $totalOrder,
                'payment_method' => 'cash'
            ]);

            // NOTIFICATION KE SELLER
            $this->notificationModel->create([
                'user_id'  => $sellerId,
                'order_id' => $orderId,
                'type'     => 'new_order',
                'title'    => 'New Order',
                'message'  => "Order #" . str_pad($orderId, 6, '0', STR_PAD_LEFT) . " needs completed payment"
            ]);

            $createdOrders[] = $orderId;

            // INSERT ORDER ITEMS
            foreach ($items as $item) {

                $this->orderModel->createItem([
                    'order_id'   => $orderId,
                    'product_id' => $item['product_id'],
                    'price'      => $item['price'],
                    'qty'        => $item['qty'],
                    'subtotal'   => $item['price'] * $item['qty']
                ]);
            }
        }

        /* ======================
       REMOVE CART
    ====================== */

        foreach ($grouped as $sellerId => $items) {
            $this->cartModel->removeBySeller($customerId, $sellerId);
        }

        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => 'Order successfully placed'
        ];

        $orderIds = implode(',', $createdOrders);

        header('Location: ' . BASE_URL . 'index.php?c=userOrder&m=invoice&orders=' . $orderIds);
        exit;
    }

    public function invoice()
    {
        $orderIds = $_GET['orders'] ?? '';

        if (!$orderIds) {
            header('Location: ' . BASE_URL . 'index.php?c=userOrder&m=history');
            exit;
        }

        $ids = explode(',', $orderIds);

        $orders = $this->orderModel->getOrdersByIds($ids);
        $orderItems = $this->orderModel->getItemsByOrderIds($ids);

        $this->render('invoice', [
            'orders' => $orders,
            'orderItems' => $orderItems
        ]);
    }

    public function downloadInvoice()
    {
        $orderId = $_GET['id'] ?? null;

        if (!$orderId) {
            header('Location: ' . BASE_URL . 'index.php?c=userStatus&m=index');
            exit;
        }

        // Ambil data order
        $order = $this->orderModel->getOrderById($orderId);
        $orderItems = $this->orderModel->getOrderItems($orderId);

        if (!$order) {
            echo "Order not found";
            exit;
        }

        // Load view invoice_pdf.php
        ob_start();
        include BASE_PATH . '/app/views/user/invoice_pdf.php';
        $html = ob_get_clean();

        // Setup Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Nama file
        $filename = "invoice_order_" . str_pad($orderId, 6, '0', STR_PAD_LEFT) . ".pdf";

        // Download
        $dompdf->stream($filename, [
            "Attachment" => true
        ]);
    }
}
