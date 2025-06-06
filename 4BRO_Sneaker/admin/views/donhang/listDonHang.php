<!-- header? -->
<?php
require './views/layout/header.php'

  ?>
<!-- end header -->
<!-- sidebar -->
<?php
require './views/layout/sidebar.php'

  ?>
<!-- end sidebar -->

<!-- Navbar -->
<?php
include './views/layout/navbar.php'
  ?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Quản lý đơn hàng</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
       
            <!-- /.card-header -->

            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <div class="card">
            
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>STT</th>
                    <th>Mã đơn hàng</th>
                    <th>Tên người nhận</th>
                    <th>Số điện thoại</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>

                  </tr>
                </thead>  
                <tbody>
                  <?php
                  // Sắp xếp $listDonHang theo trang_thai_id tăng dần
                  usort($listDonHang, function($a, $b) {
                    // So sánh theo trạng thái trước (ưu tiên trạng thái cao hơn)
                    if ($a['trang_thai_id'] !== $b['trang_thai_id']) {
                        return $a['trang_thai_id'] <=> $b['trang_thai_id'];
                    }
                    // Nếu trạng thái giống nhau, so sánh theo ngày đặt (mới nhất trước)
                    return strtotime($b['ngay_dat']) <=> strtotime($a['ngay_dat']);
                });
                  foreach ($listDonHang as $key => $donHang) {
                    ?>
                    <tr>
                      <td><?= $key + 1 ?></td>
                      <td><?= $donHang['ma_don_hang'] ?></td>
                      <td><?= $donHang['ten_nguoi_nhan'] ?></td>
                      <td><?= $donHang['sdt_nguoi_nhan'] ?></td>
                      <td><?= $donHang['ngay_dat'] ?></td>
                      <td><?= formatPrice( $donHang['tong_tien'] ).' đ'?></td>
                      <td>
                        <span class="text-<?= getStatusClass($donHang['trang_thai_id']) ?>">
                        <?= $donHang['ten_trang_thai'] ?>
                        </span>
                        </td>
                     
                      <td>
                        <div class="btn-group btn-group-sm">
                          <a href="<?= BASE_URL_ADMIN . '?act=chi-tiet-don-hang&id_don_hang=' . $donHang['id'] ?>" ><button class="btn btn-primary" ><i class="fas fa-eye"></i></button></a>
                          <?php  if($donHang['trang_thai_id']==1){?>
                          <a href="<?= BASE_URL_ADMIN . '?act=huy-don-hang&id_don_hang=' . $donHang['id'] ?>" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng không?')" ><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>
                          <?php } ?>
                        </div>
                      </td>
                    </tr>
                    <?php } ?>


                </tbody>
                <tfoot>
                <tr>
                    <th>STT</th>
                    <th>Mã đơn hàng</th>
                    <th>Tên người nhận</th>
                    <th>Số điện thoại</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>

                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- footer -->
<?php
include './views/layout/footer.php'
  ?>
<!-- end footer -->

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<!-- Code injected by live-server -->

</body>

</html>