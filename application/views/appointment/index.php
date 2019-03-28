<div class="container-fluid">
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-fw fa-calendar"></i> การนัดหมาย
        </div>
        <div class="card-body">
            <form id="from_shifts">
                <div class="form-group row">
                    <div class="col col-md-3">
                        <label>ทันตแพทย์</label>
                        <select class="form-control" id="ref_dentist_id" name="ref_dentist_id" >
                        <option selected="selected" disabled>กรุณาเลือก</option>
                          <?php
                              foreach ($dentist as $key => $value) {
                        ?>
                            <option value="<?= $value->id ?>"><?= $value->dentist_gender.' '.$value->fname.'  '.$value->lname ?> | <?= $value->name_type?></option>
                        <?php
                              }
                          ?>
                        </select>
                    </div>
                    <div class"col col-md-3">
                        <label>คนไข้</label>
                        <select class="form-control" name="ref_patient_id" id="patient">
                            <option selected="selected" disabled>กรุณาเลือก</option>
                        </select>
                    </div>
                    <div class="col col-md-3">
                        <label>วันที่</label>
                        <input type="date" name="date" id="date" class="form-control">
                    </div>
                    <div class"col col-md-3">
                        <label>เวลา</label>
                        <select class="form-control" name="time" id="time">
                            <?php 
                                foreach ($time as $data => $data_time) {
                            ?>
                                    <option value="<?= $data_time[0].'-'.$data_time[1] ?>"><?= $data_time[0].'-'.$data_time[1] ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class"col col-md-3" style="margin-left: 15px;">
                      <label>การรักษา</label>
                      <input type="text" name="reason" class="form-control">
                    </div>
                </div>
            </form>
            <div class"form-group row col col-md-4" style="padding-bottom: 50px;">
                <button type="button" class="btn btn-primary" id="submit">บันทึก</button>
            </div>

             <div class="form-group row" id="list_due_date">

             </div>
        </div>
    </div>
</div>


<script>
function trash(id_shifts,ref_patient) {
  $.get("<?=base_url()?>index.php/shifts/trash/"+id_shifts+"/"+ref_patient).done(function(){
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
                  window.location = '<?=base_url()?>index.php/appointment';
              });
            
              
           }else{
             swal({
                  title: "ไม่สำเร็จ",
                  text: json.message,
                  type: "error",
                  showCancelButton: false
              },
              function(){
                  window.location = '<?=base_url()?>index.php/appointment';
              });
              
           }
        }catch(e){

        }
    })
}

function swap(id_shifts,time_data) {
  $("#time"+id_shifts).empty();
  $("#swap"+id_shifts).attr("style", "display:block");
  var time = [
      ["10.00","10.30"],
      ["10.30","11.00"],
      ["11.00","11.30"],
      ["11.30","12.00"],
      ["12.00","12.30"],
      ["12.30","13.00"],
      ["13.00","13.30"],
      ["13.30","14.00"],
      ["14.00","14.30"],
      ["14.30","15.00"],
      ["15.00","15.30"],
      ["15.30","16.00"],
      ["16.00","16.30"],
      ["16.30","17.00"],
      ["17.00","17.30"],
      ["17.30","18.00"],
      ["18.00","18.30"],
      ["18.30","19.00"],
      ["19.00","19.30"],
      ["19.30","20.00"]
    ];
    $.each(time, function(i, item) {
      var selected = "";
      
      //12.00-12.30
      if(time_data == `${item[0]}-${item[1]}`){
        console.log(time_data,i)
        selected = "selected"
      }
      $("#time"+id_shifts).append(`
          <option value="${item[0]}-${item[1]}" ${selected}>${item[0]}-${item[1]}น.</option>
      `)
    });
    
    
}

function change_shift(id_shifts) {
  var formData = new FormData($("#form_swap"+id_shifts)[0]);
  $.ajax({
            url: '<?=base_url()?>index.php/shifts/shift_change',
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
                        window.location = '<?=base_url()?>index.php/appointment';
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
              }
          },
          cache: false,
          contentType: false,
          processData: false
      });
}

function close_change(id_shifts) {
  $("#swap"+id_shifts).attr("style", "display:none");
}

$(function(){
        $("#ref_dentist_id").change(function (e) { 
            $.get("<?=base_url()?>index.php/appointment/dentisrt/"+$(this).val()).done(function(){
            }).then(function(data){
                var json = jQuery.parseJSON(data);
                $.each(json, function(i, item) {
                    $("#patient").append(`
                        <option value="${item.id_patient}">${item.full_name}</option>
                    `)
                });
            })
        }); 

        $("#date").change(function (e) { 
          $("#list_due_date").empty();
            $.get("<?=base_url()?>index.php/appointment/dentisrt_date/"+$(this).val()+"/"+$("#ref_dentist_id").val()).done(function(){
            }).then(function(data){
                var json = jQuery.parseJSON(data);
                $.each(json, function(i, item) {
                    if ( item.state == "Success" ) {
                      $("#list_due_date").append(`
                        <div class="col col-md-3">
                          <div class="card">
                            <div class="card-header" style="background-color: #ABEBC6;">
                              <label>${item.time}</label>
                              <button class="pull-right" onclick="trash(${item.id_shifts},${item.ref_patient})"><i class="fa fa-trash"></i></button>
                              <button class="pull-right" onclick="swap(${item.id_shifts},'${item.time}')"><i class="fa fa-retweet"></i></button>
                            </div>
                            <div class="card-body">
                              <h5 class="card-title">${item.full_name}</h5>
                              <div class="row" id="swap${item.id_shifts}" style="display:none">
                                <form id="form_swap${item.id_shifts}">
                                  <input type="hidden" name="id" value="${item.id_shifts}" />
                                  <label>การรักษา</label>
                                  <input type="text" name="reasom" class="form-control" value="${item.reason}" disabled>
                                  <label>วันที่</label>
                                  <input type="date" name="date" id="date_${item.id_shifts}" class="form-control" value="${item.date}" disabled>
                                  <label>เวลา</label>
                                  <select class="form-control" name="time" id="time${item.id_shifts}" disabled></select>
                                  <label>สถานะ</label>
                                  <input type="text" class="form-control" value="${item.state}" disabled>
                                </form>
                                <button class="btn btn-warning" onclick="close_change(${item.id_shifts})" style="margin-top:20px;">ปิด</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    `)
                    } else {
                      $("#list_due_date").append(`
                        <div class="col col-md-3">
                          <div class="card">
                            <div class="card-header">
                              <label>${item.time}</label>
                              <button class="pull-right" onclick="trash(${item.id_shifts},${item.ref_patient})"><i class="fa fa-trash"></i></button>
                              <button class="pull-right" onclick="swap(${item.id_shifts},'${item.time}')"><i class="fa fa-retweet"></i></button>
                            </div>
                            <div class="card-body">
                              <h5 class="card-title">${item.full_name}</h5>
                              <div class="row" id="swap${item.id_shifts}" style="display:none">
                                <form id="form_swap${item.id_shifts}">
                                  <input type="hidden" name="id" value="${item.id_shifts}"/>
                                  <label>การรักษา</label>
                                  <input type="text" name="reasom" class="form-control" value="${item.reason}">
                                  <label>วันที่</label>
                                  <input type="date" name="date" id="date_${item.id_shifts}" class="form-control" value="${item.date}">
                                  <label>เวลา</label>
                                  <select class="form-control" name="time" id="time${item.id_shifts}"></select>
                                  <label>สถานะ</label>
                                  <select class="form-control" name="state" id="state" value="${item.state}">
                                    <option value="Wait">Wait</option>
                                    <option value="Success">Success</option>
                                    <option value="Postpone">Postpone</option>
                                  </select>
                                </form>
                                <button class="btn btn-primary" onclick="change_shift(${item.id_shifts})" style="margin-top:20px;">บันทึก</button>
                                <button class="btn btn-warning" onclick="close_change(${item.id_shifts})" style="margin-top:20px;">ปิด</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    `)
                    }
                });
            })
        });

      $("#submit").click(function(){
          if($("#ref_dentist_id").val() != "" && $("#patient").val() != "" && $("#date").val() != "" && $("#time").val() != ""){
            var formData = new FormData($("#from_shifts")[0]);  
            
            $.ajax({
                  url: '<?=base_url()?>index.php/shifts/add_shifts',
                  type: 'POST',
                  data: formData,
                  async: false,
                  success: function (data) {

                    try{
                       console.log(data)
                       var json = jQuery.parseJSON(data);

                       if(json.status == true){
                          swal({
                              title: "สำเร็จ",
                              text: json.message,
                              type: "success",
                              showCancelButton: false
                          },
                          function(){
                              window.location = '<?=base_url()?>index.php/appointment';
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
})
</script>
