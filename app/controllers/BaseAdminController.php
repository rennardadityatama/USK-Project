<?php

require_once BASE_PATH . '/app/middlewares/Middleware.php';
require_once BASE_PATH . '/app/models/UserModels.php';
require_once BASE_PATH . '/app/models/NotificationModels.php';
require_once BASE_PATH . '/app/helpers/Csrf.php';

class BaseAdminController
{
    protected $user;
    protected $notifications = [];
    protected $notifCount = 0;
    private $notificationModel;

    public function __construct()
    {
        // Pastikan user login
        Middleware::check();

        // Pastikan role admin (1)
        if (!Middleware::isRole(1)) {
            echo "Hanya admin yang bisa mengakses halaman ini";
            exit;
        }

        $this->user = new User();
        $this->notificationModel = new NotificationModel();

        $sellerId = $_SESSION['user']['id'];

        $this->notifications = $this->notificationModel->getUnreadByUser($sellerId);
        $this->notifCount = $this->notificationModel->countUnread($sellerId);
    }

    protected function render($view, $data = [])
    {
        $data['notifications'] = $this->notifications;
        $data['notifCount'] = $this->notifCount;

        $data['js'] = $data['js'] ?? [];
        $data['content'] = BASE_PATH . '/app/views/admin/' . $view . '.php';

        extract($data);

        require_once BASE_PATH . '/app/views/admin/layouts/main.php';
    }
}
