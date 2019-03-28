<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header">
        <i class="fa fa-fw fa-wheelchair"></i> แก้ข้อมูลคนไข้
        </div>
        <div class="card-body">
            <form id="from_patient">
            <?php 
                foreach ($patient as $i => $data) {
            ?>
                <input type="hidden" name="id" value="<?= $data->id_patient ?>">
                <div class="form-group row">
                     <div class="col col-md-6">
                        <label>เลขประจำตัวประชาชน</label>
                        <input class="form-control" id="no_card" name="no_card" type="number" value="<?= $data->no_card?>" >
                     </div>
                     <div class="col col-md-6">
                        <label>เลขที่บัตรคนไข้</label>
                        <input class="form-control" id="no_card_patient" name="no_card_patient" type="text" value="<?= $data->no_card_patient?>">
                     </div>
                </div>

                <div class="form-group row">
                    <div class="col col-md-6">
                        <label>ชื่อ-นามสกุล</label>
                        <input class="form-control" id="full_name" name="full_name" type="text"  value="<?= $data->full_name?>">
                    </div>
                    <div class="col col-md-6">
                        <label>เบอร์โทรศัพท์</label>
                        <input class="form-control" id="phone" name="phone" type="number" value="<?= $data->phone?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>ประวัติแพ้ยา</label>
                    <textarea class="form-control" name="be_allergic"><?= $data->be_allergic?></textarea>
                </div>

                <div class="form-group">
                    <label>ทันตแพทย์เจ้าของคนไข้</label>
                    <select class="form-control" id="ref_dentist_id" name="ref_dentist_id" value="<?= $data->ref_dentist_id?>" >
                      <?php
                          foreach ($dentist as $key => $value) {
                    ?>
                        <option value="<?= $value->id ?>"><?= $value->dentist_gender.' '.$value->fname.'  '.$value->lname ?></option>
                    <?php
                          }
                      ?>
                    </select>
                </div>
            <?php
                } 
            ?>
            </form>
                <div class="form-group">
                    <button id="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
    </div>
</div>

<script type="text/javascript">
$(function(){
  $("#submit").click(function(){
      var formData = new FormData($("#from_patient")[0]);  
      
      $.ajax({
            url: '<?=base_url()?>index.php/patient/edit_patient',
            type: 'POST',
            data: formData,
            async: false,
            success: function (data) {

              try{
                 console.log(data);
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
                    $.simplyToast(e, 'danger');
              }
          },
          cache: false,
          contentType: false,
          processData: false
      });
  });
});
</script>