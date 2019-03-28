<div class="container-fluid">
    <div class="card mb-3">
        <form id="form_dentist"  class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="card-header">
            <i class="fa fa-area-chart"></i> แก้ไขข้อมูลทันตแพทย์
            </div>
            <div class="card-body">
              <?php 
                foreach ($dentis as $i => $data) {
              ?>
                <input type="hidden" name="id" value="<?= $data->id ?>">
                <div class="form-group">
                    <label>เลขประจำตัวประชาชน</label>
                    <input class="form-control" id="dentist_number" name="dentist_number" type="number"  value="<?= $data->dentist_number ?>">
                </div>
                    
                <div class="form-group row">
                    <div class="col col-md-2">
                        <label>คำนำหน้า</label>
                        <select class="form-control" id="dentist_gender" name="dentist_gender" value="<?= $data->dentist_gender ?>" >
                            <option value="ทพ.">ทันตแพทย์</option>
                            <option value="ทพญ.">ทันตแพทย์หญิง</option>
                        </select>
                    </div>
                    <div class="col col-md-5">
                        <label>ชื่อ</label>
                        <input class="form-control" id="fname" name="fname" type="text" value="<?= $data->fname ?>" >
                    </div>
                    <div class="col col-md-5">
                        <label>นามสกุล</label>
                        <input class="form-control" id="lname" name="lname" type="text"  value="<?= $data->lname ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label>ความถนัดแพทย์</label>
                    <select class="form-control" id="dentist_type" name="dentist_type"  value="<?= $data->dentist_type ?>">
                      <?php 
                        foreach ($dentis_type as $key => $value) { 
                      ?>
                        <option value="<?= $value->id_type ?>"><?= $value->name_type ?></option>
                      <?php
                        }
                      ?>
                    </select>
                </div>
              <?php
                }
              ?>
                 <div class="form-group">
                    <button type="button" class="btn btn-large btn-primary" id="submit">Submit</button>
                </div>
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </form>                
    </div>
</div>

<script type="text/javascript">
$(function(){
  $("#submit").click(function(){
      var formData = new FormData($("#form_dentist")[0]);  
      
      $.ajax({
            url: '<?=base_url()?>index.php/dentist/edit_dentist',
            type: 'POST',
            data: formData,
            async: false,
            success: function (data) {

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
                        window.location = '<?=base_url()?>index.php/backend';
                    });
                    
                 }
              }catch(e){
                  console.log("error");
              }
          },
          cache: false,
          contentType: false,
          processData: false
      });
  });
});

</script>