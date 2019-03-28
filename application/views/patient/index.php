<div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Patient</a>
        </li>
      </ol>

      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-fw fa-wheelchair"></i> ข้อมูลคนไข้
           <a href="<?= base_url() ?>index.php/patient/add_patient" class="btn btn-primary pull-right">เพิ่มคนไข้</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
               <tr>
                  <th>#</th>
                  <th>เลขที่บัตรคนไข้</th>
                  <th>ชื่อ - นามสกุล</th>
                  <th>ทันตแพทย์เจ้าของคนไข้</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $i = 0;
                  foreach ($patient as $key => $value) {
                    $name_dentist = $value->dentist_gender.' '.$value->fname.'  '.$value->lname;
                ?>
                  <tr>
                    <td><?= ++$i ?></td>
                    <td><?= $value->no_card_patient ?></td>
                    <td><?= $value->full_name ?></td>
                    <td><?= $name_dentist ?></td>
                    <td>
                      <button type="button" onclick="view(<?= $value->id_patient ?>)" class="btn btn-xs btn-info">View</button>
                      <a href="<?= base_url() ?>index.php/patient/history/<?= $value->id_patient ?>" class="btn btn-xs btn-primary">History</a>
                      <a href="<?= base_url() ?>index.php/patient/from_edit_patient/<?= $value->id_patient ?>" class="btn btn-xs btn-warning">Edit</a>
                      <button type="button" onclick="deletepatient(<?= $value->id_patient ?>)" class="btn btn-xs btn-danger">Delete</button>
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

<div id="deletepatient" class="modal fade" role="dialog">
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
    $.get(`<?= base_url() ?>index.php/patient/getdata/${id}`, function(data) {
      var json = jQuery.parseJSON(data);
      $('.modal-title').text('ข้อมูลคนไข้');
      $('.modal-body').html(`
                     <div class="form-group row">
                       <div class="col col-md-6">
                            <label>เลขประจำตัวประชาชน</label>
                            <input disabled class="form-control" value="${json[0].no_card}">
                         </div>
                         <div class="col col-md-6">
                            <label>เลขที่บัตรคนไข้</label>
                            <input disabled class="form-control" value="${json[0].no_card_patient}">
                         </div>
                     </div>

                       <div class="form-group row">
                          <div class="col col-md-6">
                              <label>ชื่อ-นามสกุล</label>
                              <input disabled class="form-control" value="${json[0].full_name}">
                          </div>
                          <div class="col col-md-6">
                              <label>เบอร์โทรศัพท์</label>
                              <input disabled class="form-control" value="${json[0].phone}">
                          </div>
                       </div>

                      <div class="form-group">
                          <label>ประวัติแพ้ยา</label>
                          <textarea disabled class="form-control">${json[0].be_allergic}</textarea>
                      </div>
                      <div class="form-group">
                          <label>ทันตแพทย์เจ้าของคนไข้</label>
                          <input class="form-control" disabled value="${json[0].dentist_gender} ${json[0].fname}  ${json[0].lname}">
                      </div>
                      `)
       $('#modalDentist').modal();
    });
  }

  function deletepatient(id){
    $('.modal-title').text('ลบข้อมูลผู้ป่วย');
    $('.modal-body').html(`
      <center>
          <label>ต้องการลบใช่หรือไม่?</label><br/>
          <button type="button" onclick="delpatient(${id})" class="btn btn-xs btn-info">ตกลง</button>
      </center>
    `)
    $('#deletepatient').modal();
  }

  function delpatient(id) {
    $.get("<?=base_url()?>index.php/patient/trash/"+id).done(function(){
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
                  window.location = '<?=base_url()?>index.php/patient';
              });
            
              
           }else{
             swal({
                  title: "ไม่สำเร็จ",
                  text: json.message,
                  type: "error",
                  showCancelButton: false
              },
              function(){
                  window.location = '<?=base_url()?>index.php/patient';
              });
              
           }
        }catch(e){

        }
    })
  }
</script>