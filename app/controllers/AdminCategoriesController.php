<?php
require_once BASE_PATH . '/app/controllers/BaseAdminController.php';
require_once BASE_PATH . '/app/models/CategoryModels.php';

class AdminCategoriesController extends BaseAdminController
{
    private $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new CategoryModel();
    }

    private function json($success, $message, $data = [])
    {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'message' => $message,
            'data'    => $data
        ]);
        exit;
    }

    // READ - Show category list
    public function index()
    {
        $categories = $this->categoryModel->getAll();

        $this->render('category', [
            'title' => 'Category List | iTama Book',
            'menu'  => 'category',
            'categories' => $categories
        ]);
    }

    // CREATE - Add new category
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = trim($_POST['name']);

            if (empty($name)) {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'message' => 'Category name is required.'
                ];
                header("Location: " . BASE_URL . "index.php?c=adminCategories&m=index");
                exit;
            }

            if ($this->categoryModel->findByName($name)) {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'message' => 'Category already exists.'
                ];
                header("Location: " . BASE_URL . "index.php?c=adminCategories&m=index");
                exit;
            }

            $this->categoryModel->create($name);

            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Category added successfully.'
            ];

            header("Location: " . BASE_URL . "index.php?c=adminCategories&m=index");
            exit;
        }
    }

    // READ - Get single category (for edit)
    public function show($id)
    {
        header('Content-Type: application/json');

        try {
            $category = $this->categoryModel->getById($id);

            if ($category) {
                echo json_encode([
                    'success' => true,
                    'data' => $category
                ]);
            } else {
                throw new Exception('Category not found.');
            }
        } catch (Exception $e) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }

    // UPDATE - Update category
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = trim($_POST['name']);

            if (empty($name)) {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'message' => 'Category name is required.'
                ];
                header("Location: " . BASE_URL . "index.php?c=adminCategories&m=index");
                exit;
            }

            if ($this->categoryModel->findByName($name)) {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'message' => 'Category already exists.'
                ];
                header("Location: " . BASE_URL . "index.php?c=adminCategories&m=index");
                exit;
            }

            $this->categoryModel->update($id, $name);

            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Category added successfully.'
            ];

            header("Location: " . BASE_URL . "index.php?c=adminCategories&m=index");
            exit;
        }
    }

    // DELETE - Delete category
    public function destroy($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {

                $this->categoryModel->delete($id);
                $_SESSION['alert'] = [
                    'type' => 'success',
                    'message' => 'Category deleted successfully.'
                ];

                header("Location: " . BASE_URL . "index.php?c=adminCategories&m=index");
                exit;
            } catch (PDOException $e) {

                if ($e->getCode() == 23000) {
                    $_SESSION['alert']= [
                        'type' => 'danger',
                        'message' => 'Cannot deleted category because it is still products'
                    ];

                    header("Location:" . BASE_URL . "index.php?c=adminCategories&m=index");
                    exit;
                }

                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'message' => 'Category already exists.'
                ];
                header("Location: " . BASE_URL . "index.php?c=adminCategories&m=index");
                exit;
            }
        }
    }
}
