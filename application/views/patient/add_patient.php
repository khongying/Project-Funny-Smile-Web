<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header">
        <i class="fa fa-fw fa-wheelchair"></i> เพิ่มข้อมูลคนไข้
        </div>
        <div class="card-body">
            <form id="from_patient">
                <div class="form-group row">
                     <div class="col col-md-6">
                        <label>เลขประจำตัวประชาชน</label>
                        <input class="form-control" id="no_card" name="no_card" type="number">
                     </div>
                     <div class="col col-md-6">
                        <label>เลขที่บัตรคนไข้</label>
                        <input class="form-control" id="no_card_patient" name="no_card_patient" type="text">
                     </div>
                </div>

                <div class="form-group row">
                    <div class="col col-md-6">
                        <label>ชื่อ-นามสกุล</label>
                        <input class="form-control" id="full_name" name="full_name" type="text">
                    </div>
                    <div class="col col-md-6">
                        <label>เบอร์โทรศัพท์</label>
                        <input class="form-control" id="phone" name="phone" type="number">
                    </div>
                </div>

                <div class="form-group">
                    <label>ประวัติแพ้ยา</label>
                    <textarea class="form-control" name="be_allergic"></textarea>
                </div>

                <div class="form-group">
                    <label>ทันตแพทย์เจ้าของคนไข้</label>
                    <select class="form-control" id="ref_dentist_id" name="ref_dentist_id">
                      <?php
                          foreach ($dentist as $key => $value) {
                    ?>
                        <option value="<?= $value->id ?>"><?= $value->dentist_gender.' '.$value->fname.'  '.$value->lname ?> | <?= $value->name_type?></option>
                    <?php
                          }
                      ?>
                    </select>
                </div>
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
       if($("#no_card").val() != "" && $("#no_card_patient").val() != "" && $("#full_name").val() != "" && $("#phone").val() != ""  && $("#be_allergic").val() != "" && $("#ref_dentist_id").val() != ""){
          var formData = new FormData($("#from_patient")[0]);  
          
          $.ajax({
                url: '<?=base_url()?>index.php/patient/insert_patient',
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

       }else{
        swal("กรุณากรอกข้อมูล", "กรุณากรอกข้อมูลให้ครบ!", "error");
       }
  });
});
</script>