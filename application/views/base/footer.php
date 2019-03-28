    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Your Website 2018</small>
        </div>
      </div>
    </footer>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">คุณต้องการออกจากระบบ ?</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="<?= base_url() ?>index.php/auth/logout">Logout</a>
          </div>
        </div>
      </div>
    </div>
   <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url() ?>asset/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?= base_url() ?>asset/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="<?= base_url() ?>asset/vendor/chart.js/Chart.min.js"></script>
    <script src="<?= base_url() ?>asset/vendor/datatables/jquery.dataTables.js"></script>
    <script src="<?= base_url() ?>asset/vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?= base_url() ?>asset/js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="<?= base_url() ?>asset/js/sb-admin-datatables.min.js"></script>
    <!-- <script src="<?= base_url() ?>asset/js/sb-admin-charts.min.js"></script> -->
    </div>
</body>

</html>