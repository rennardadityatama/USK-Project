<?php

require_once BASE_PATH . '/app/middlewares/Middleware.php';
require_once BASE_PATH . '/app/models/UserModels.php';
require_once BASE_PATH . '/app/models/NotificationModels.php';
require_once BASE_PATH . '/app/helpers/Csrf.php';
require_once BASE_PATH . '/app/helpers/chat.php';

class BaseUserController
{
    protected $user;
    protected $notifications = [];
    protected $notifCount = 0;
    private $notificationModel;

    public function __construct()
    {
        // Pastikan user login
        Middleware::check();

        Middleware::role([2]);

        $customerId = $_SESSION['user']['id'];

        $this->user = new User();
        $this->notificationModel = new NotificationModel();

        $this->notifications = $this->notificationModel->getUnreadByUser($customerId);
        $this->notifCount = $this->notificationModel->countUnread($customerId);
    }

    protected function render($view, $data = [])
    {
        $data['notifications'] = $this->notifications;
        $data['notifCount'] = $this->notifCount;

        $data['js'] = $data['js'] ?? [];
        $data['content'] = BASE_PATH . '/app/views/user/' . $view . '.php';

        extract($data);
        
        require_once BASE_PATH . '/app/views/user/layouts/main.php';
    }
}
