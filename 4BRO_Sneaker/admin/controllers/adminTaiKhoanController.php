<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class adminTaiKhoanController {
    public $modelTaiKhoan;

    public function __construct(){
        $this->modelTaiKhoan = new adminTaiKhoan();
    }
    
    
    public function deleteSessionError() {
        if (isset($_SESSION['error'])) {
            unset($_SESSION['error']);
        }
    }

    public function danhSachQuanTri(){
        $listQuanTri = $this->modelTaiKhoan->getAllTaiKhoan(1);

        // Gọi view để hiển thị danh sách quản trị
        require_once './views/taikhoan/quantri/listQuanTri.php';
    }

    

    public function formAddQuanTri(){
        require_once './views/taikhoan/quantri/addQuanTri.php';

        $this->deleteSessionError();
    }

    public function postAddQuanTri(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $ho_ten = $_POST['ho_ten'];
            $email = $_POST['email'];
            $errors =[];
    
            if (empty($ho_ten)){
                $errors['ho_ten'] = 'Tên không được để trống';
            }
    
            if (empty($email)){
                $errors['email'] = 'Email không được để trống';
            }
    
            $_SESSION['error'] = $errors;
    
            if(empty($errors)){
                $password = password_hash('123@123ab', PASSWORD_BCRYPT);
                $chuc_vu_id = 1;
    
                if ($this->modelTaiKhoan->insertTaiKhoan($ho_ten, $email, $password, $chuc_vu_id)) {
                    header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
                    exit();
                } else {
                    $_SESSION['error'] = ['general' => 'Lỗi khi thêm tài khoản.'];
                }
            } else {
                $_SESSION["flash"] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-them-quan-tri');
                exit();
            }
        }
    }

    public function formEditQuanTri(){
        $id_quan_tri = $_GET['id_quan_tri'];
        $quanTri = $this->modelTaiKhoan->getDetailTaiKhoan($id_quan_tri);
        require_once './views/taikhoan/quantri/editQuanTri.php';

        $this->deleteSessionError();
        
    }
    
    public function postEditQuanTri() {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $quan_tri_id = $_POST['quan_tri_id'] ?? '';

            $ho_ten = $_POST['ho_ten'] ?? '';
            $email = $_POST['email'] ?? '';
            $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? '';

            $errors = [];

            if(empty($ho_ten)){
                $errors['ho_ten'] = 'Tên người dùng không được để trống ';
            }
            if(empty($email)){
                $errors['email'] = 'Email người dùng không được để trống ';
            }

            if(empty($trang_thai)){
                $errors['trang_thai'] = 'Vui lòng chọn trạng thái';
            }

            $_SESSION['error'] = $errors;

            if(empty($errors)) {
                $this->modelTaiKhoan->updateTaiKhoan($quan_tri_id,$ho_ten,$email,$so_dien_thoai,$trang_thai);
                header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
                exit();
            }else{
                $_SESSION['flash'] = true;

                header("Location: " . BASE_URL_ADMIN . '?act=form-sua-quan-tri&id_quan_tri' . $quan_tri_id);
                exit();
            }

        }
    }
    
    public function resetPassword() {
        $tai_khoan_id = $_GET['id_quan_tri'];
        $tai_khoan = $this->modelTaiKhoan->getDetailTaiKhoan($tai_khoan_id);
        $password = password_hash('123@123ab', PASSWORD_BCRYPT);
    
        $status = $this->modelTaiKhoan->resetPassword($tai_khoan_id, $password);
        if ($status && $tai_khoan['chuc_vu_id'] == 1) {
            header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
            exit();
        } elseif ($status && $tai_khoan['chuc_vu_id'] == 2) {
            header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-khach-hang');
            exit();
        } else {
            var_dump('Lỗi khi reset tài khoản');
            die();
        }
    }
    

    public function danhSachKhachHang(){
        $listKhachHang = $this->modelTaiKhoan->getAllTaiKhoan(2);

        require_once './views/taikhoan/khachhang/listKhachHang.php';
    }


    public function formEditKhachHang(){
        $id_khach_hang = $_GET['id_khach_hang'];
        $khachHang = $this->modelTaiKhoan->getDetailTaiKhoan($id_khach_hang);
        require_once './views/taikhoan/khachhang/editKhachHang.php';
    
        $this->deleteSessionError();
    }
    

    public function postEditKhachHang() {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $khach_hang_id = $_POST['khach_hang_id'] ?? '';

            $ho_ten = $_POST['ho_ten'] ?? '';
            $email = $_POST['email'] ?? '';
            $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
            $ngay_sinh = $_POST['ngay_sinh'] ?? '';
            $gioi_tinh = $_POST['gioi_tinh'] ?? '';
            $dia_chi = $_POST['dia_chi'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? '';

            $errors = [];

            if(empty($ho_ten)){
                $errors['ho_ten'] = 'Tên người dùng không được để trống ';
            }
            if(empty($email)){
                $errors['email'] = 'Email người dùng không được để trống ';
            }

            if(empty($ngay_sinh)){
                $errors['ngay_sinh'] = 'Ngày sinh người dùng không được để trống ';
            }
            
            if(empty($gioi_tinh)){
                $errors['gioi_tinh'] = 'Giới tính người dùng không được để trống ';
            }

            if(empty($trang_thai)){
                $errors['trang_thai'] = 'Vui lòng chọn trạng thái';
            }

            $_SESSION['error'] = $errors;

            if(empty($errors)) {
                $this->modelTaiKhoan->updateKhachHang($khach_hang_id,
                                                    $ho_ten ,
                                                    $email,
                                                    $so_dien_thoai,
                                                    $ngay_sinh,
                                                    $gioi_tinh,
                                                    $dia_chi,
                                                    $trang_thai
                                                );
                header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-khach-hang');
                exit();
            }else{
                $_SESSION['flash'] = true;

                header("Location: " . BASE_URL_ADMIN . '?act=form-sua-khach-hang&id_khach_hang=' . $khach_hang_id);
                exit();
            }

        }
    }

    public function detailKhachHang(){
        $id_khach_hang = $_GET['id_khach_hang'];
        $khachHang = $this->modelTaiKhoan->getDetailTaiKhoan($id_khach_hang);

        require_once './views/taikhoan/khachhang/detailKhachHang.php';
    }
    


    public function formLogin(){
        require_once './views/auth/formLogin.php';

        $this->deleteSessionError();

    }

    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //lay email va passs

            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->modelTaiKhoan->checkLogin($email, $password);

            if($user ==  $email) {
                $_SESSION['user_admin'] = $user;
                header("Location: " . BASE_URL_ADMIN);
                exit();
            } else {
                $_SESSION['error'] = $user;

                // var_dump($_SESSION['error']);die; 

                $_SESSION['flash'] = true;

                header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            }
        }
    }
}
