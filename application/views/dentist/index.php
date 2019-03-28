<div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dentist</a>
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
        <i class="fa fa-area-chart"></i> ข้อมูลทันตแพทย์
        <a href="<?= base_url() ?>index.php/dentist/add_dentist" class="btn btn-xs btn-primary pull-right">เพิ่มทันตแพทย์</a>
        </div>
        <div class="card-body">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>#</th>
                  <th>ชื่อ</th>
                  <th>นามสกุล</th>
                  <th>ความถนัด</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $i = 0;
                foreach ($dentis as $key => $value) {
              ?>
                  <tr>
                    <td><?= ++$i ?></td>
                    <td><?= $value->fname ?></td>
                    <td><?= $value->lname ?></td>
                    <td><?= $value->name_type ?></td>
                    <td>
                      <button type="button" onclick="view(<?= $value->id ?>)" class="btn btn-xs btn-info">View</button>
                      <a href="<?= base_url() ?>index.php/dentist/from_edit_dentist/<?= $value->id ?>" class="btn btn-xs btn-warning">Edit</a>
                      <button type="button" onclick="deletedentis(<?= $value->id ?>)" class="btn btn-xs btn-danger">Delete</button>
                    </td>
                  </tr>
              <?php
                }
              ?>
              </tbody>
          </table>
        </div>
      </div>
      <div class="">
        
      </div>

</div>

<div id="modalDentist" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="deletedentis" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<script type="text/javascript">
  function view(id) {
   $.get(`<?= base_url() ?>index.php/dentist/getdata/${id}`, function(data) {
    var json = jQuery.parseJSON(data);
    $('.modal-title').text('ข้อมูลทันตแพทย์');
    $('.modal-body').html(`
                    <div class="form-group">
                        <label>เลขประจำตัวประชาชน</label>
                        <input class="form-control" disabled value="${json[0].dentist_number}">
                    </div>
                        
                    <div class="form-group row">
                        <div class="col col-md-2">
                            <label>คำนำหน้า</label>
                            <input class="form-control" disabled value="${json[0].dentist_gender}">
                        </div>
                        <div class="col col-md-5">
                            <label>ชื่อ</label>
                            <input class="form-control" disabled value="${json[0].fname}">
                        </div>
                        <div class="col col-md-5">
                            <label>นามสกุล</label>
                            <input class="form-control" disabled value="${json[0].lname}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>ความถนัดแพทย์</label>
                        <input class="form-control" disabled value="${json[0].name_type}">
                    </div>
                    `)
     $('#modalDentist').modal();
   });
  }

  function deletedentis(id) {
    $('.modal-title').text('ลบข้อมูลทันตแพทย์');
    $('.modal-body').html(`
      <center>
          <label>ต้องการลบใช่หรือไม่?</label><br/>
          <button type="button" onclick="deldentis(${id})" class="btn btn-xs btn-info">ตกลง</button>
      </center>
    `)
    $('#deletedentis').modal();
  }

  function deldentis(id) {
    $.get("<?=base_url()?>index.php/dentist/trash/"+id).done(function(){
    }).then(function(data){
         try{  
           var json = jQuery.parseJSON(data);

           if(json.status == true){
              swal({
                  title: "สำเร็จ",
                  text: json.message,
                  type: "success",
                  showCancelButton: false
              },
              function(){
                  window.location = '<?=base_url()?>index.php/dentist';
              });
            
              
           }else{
             swal({
                  title: "ไม่สำเร็จ",
                  text: json.message,
                  type: "error",
                  showCancelButton: false
              },
              function(){
                  window.location = '<?=base_url()?>index.php/dentist';
              });
              
           }
        }catch(e){

        }
    })
  }
</script>