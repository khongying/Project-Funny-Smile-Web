<div class="container-fluid">
    <div class="card mb-3">
        <form id="form_dentist"  class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="card-header">
            <i class="fa fa-area-chart"></i> เพิ่มข้อมูลทันตแพทย์
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>เลขประจำตัวประชาชน</label>
                    <input class="form-control" id="dentist_number" name="dentist_number" type="number">
                </div>
                    
                <div class="form-group row">
                    <div class="col col-md-2">
                        <label>คำนำหน้า</label>
                        <select class="form-control" id="dentist_gender" name="dentist_gender">
                            <option value="ทพ.">ทันตแพทย์</option>
                            <option value="ทพญ.">ทันตแพทย์หญิง</option>
                        </select>
                    </div>
                    <div class="col col-md-5">
                        <label>ชื่อ</label>
                        <input class="form-control" id="fname" name="fname" type="text">
                    </div>
                    <div class="col col-md-5">
                        <label>นามสกุล</label>
                        <input class="form-control" id="lname" name="lname" type="text">
                    </div>
                </div>

                <div class="form-group">
                    <label>ความถนัดแพทย์</label>
                    <select class="form-control" id="dentist_type" name="dentist_type">
                      <?php 
                        foreach ($dentis_type as $key => $value) { 
                      ?>
                        <option value="<?= $value->id_type ?>"><?= $value->name_type ?></option>
                      <?php
                        }
                      ?>
                    </select>
                </div>
                 <div class="form-group">
                    <button type="button" class="btn btn-large btn-primary" id="submit">บันทึกข้อมูล</button>
                </div>
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </form>                
    </div>
</div>

<script type="text/javascript">
$(function(){
  $("#submit").click(function(){
      if($("#dentist_number").val() != "" && $("#dentist_gender").val() != "" && $("#fname").val() != "" && $("#lname").val() != ""  && $("#dentist_type").val() != "" ){
        var formData = new FormData($("#form_dentist")[0]);  
      
      $.ajax({
            url: '<?=base_url()?>index.php/dentist/insert_dentist',
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