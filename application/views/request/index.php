<div class="container-fluid">
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-fw fa-exchange"></i> คำขอเลื่อนนัด
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>#</th>
                  <th>ชื่อ-นามสกุล</th>
                  <th>เหตุผลการเลื่อนนัด</th>
                  <th>สถานะ</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $i = 0;
                foreach ($claim as $key => $value) {
              ?>
                  <tr>
                    <td><?= ++$i ?></td>
                    <td><?= $value->full_name ?></td>
                    <td><?= $value->reason ?></td>
                    <td><?= $value->state ?></td>
                    <td>
                       <a href="<?= base_url() ?>index.php/request/claim/<?= $value->id_claim ?>" class="btn btn-xs btn-info">View</a>
                    </td>
                  </tr>
              <?php
                }
              ?>
              </tbody>
          </table>
        </div>
    </div>
</div>



<script type="text/javascript">
  function view(id) {
    alert(id)
   
  }
</script>