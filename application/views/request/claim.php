<div class="container-fluid">
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-fw fa-exchange"></i> คำขอเลื่อนนัด
        </div>
        <div class="card-body">
         
         <?php 
            foreach ($shifts as $key => $value) {
              $shifts_id = $value["id_shifts"];
        ?>
          <div class="form-group row">
            <div class="col col-md-3">
                <label>เลขที่บัตร</label>
                <input class="form-control" disabled value="<?= $value['no_card_patient'] ?>">
            </div>

            <div class="col col-md-3">
                <label>ชื่อ-นามสกุล</label>
                <input class="form-control" disabled value="<?= $value['full_name'] ?>">
            </div>

            <div class="col col-md-3">
                <label>แพทย์ผู้นัด</label>
                <input class="form-control" disabled  value="<?= $value['dentist_gender'] ?> <?= $value['fname'] ?> <?= $value['lname'] ?>">
            </div>

            <div class="col col-md-3">
                <label>เหตุที่นัด</label>
                <input class="form-control" disabled value="<?= $value['reason'] ?>">
            </div>
          </div>

          <div class="form-group row">
            <div class="card mb-3">
              <div class="card-header">
                วันที่นัดเดิม
              </div>
              <div class="card-body">
                 <div class="form-group row">
                      <div class="col col-md-6">
                          <label>วันที่นัด</label>
                          <input class="form-control" disabled value="<?= $value['date'] ?>">
                      </div>
                      <div class="col col-md-6">
                          <label>เวลานัด</label>
                          <input class="form-control" disabled value="<?= $value['time'] ?>">
                      </div>
                 </div>
              </div>

            </div>
            <div>
              <h1 style="margin-top:60px;">
                <i class="fa fa-fw fa-arrow-right"></i>
              </h1>
            </div>
          
        <?php
              }
            foreach ($claim as $key => $value) {
              $claim_id = $value['id_claim'];
              $claim_time = $value['time'];
              $claim_date = $value['date'];
              $ref_patient = $value['ref_patient'];
        ?>
          <div class="card mb-3">
            <div class="card-header">
              วันที่นัดใหม่
            </div>
            <div class="card-body">
               <div class="form-group row">
                    <div class="col col-md-6">
                        <label>วันที่นัด</label>
                        <input class="form-control" disabled value="<?= $value['date'] ?>">
                    </div>
                    <div class="col col-md-6">
                        <label>เวลานัด</label>
                        <input class="form-control" disabled value="<?= $value['time'] ?>">
                    </div>
               </div>
            </div>
          </div>
        <?php
          }
        ?>
          </div>

         <div class="form-group">
            <button type="button" class="btn btn-large btn-success" id="approve">เลื่อนนัด</button>
            <button type="button" class="btn btn-large btn-danger" id="canceled">ยกเลิก</button>
         </div>
       </div>
    </div>
</div>

<script type="text/javascript">
  $(function(){
  $("#approve").click(function(){
      var data = {
        shifts_id: '<?= $shifts_id ?>',
        claim_date: '<?= $claim_date ?>',
        claim_time: '<?= $claim_time ?>',
        claim_id: '<?= $claim_id ?>',
        ref_patient: '<?= $ref_patient ?>'
      };
      $.post('<?=base_url()?>index.php/request/update_shifts', { update: data}, function(data) {
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
                      window.location = '<?=base_url()?>index.php/request';
                  });
                
                  
               }else{
                 swal({
                      title: "ไม่สำเร็จ",
                      text: json.message,
                      type: "error",
                      showCancelButton: false
                  },
                  function(){
                      window.location = '<?=base_url()?>index.php/request';
                  });
                  
               }
            }catch(e){
              console.log(e);
            }
      });
  });

  $("#canceled").click(function(){
     var data = {
        shifts_id: '<?= $shifts_id ?>',
        claim_id: '<?= $claim_id ?>',
        ref_patient: '<?=$ref_patient ?>'
      };
      $.post('<?=base_url()?>index.php/request/canceled', { update: data}, function(data) {
            try{
               console.log(data);
               var json = jQuery.parseJSON(data);
               if(json.status == true){

                  swal({
                      title: "ยกเลิก",
                      text: json.message,
                      type: "error",
                      showCancelButton: false
                  },
                  function(){
                      window.location = '<?=base_url()?>index.php/request';
                  });
                
                  
               }else{
                 swal({
                      title: "ไม่สำเร็จ",
                      text: json.message,
                      type: "error",
                      showCancelButton: false
                  },
                  function(){
                      window.location = '<?=base_url()?>index.php/request';
                  });
                  
               }
            }catch(e){
              console.log(e);
            }
      });
  })

});
</script>


