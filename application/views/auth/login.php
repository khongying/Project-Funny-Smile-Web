<div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Funny Smile | Admin</div>
      <div class="card-body">
      
      <img src="<?=base_url("asset/img/tooth.png")?>" alt="Smiley face" style="width: 150px; padding-bottom: 30px;  display: block; margin-left: auto; margin-right: auto;">
        <form>
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input class="form-control" id="email" type="email" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input class="form-control" id="password" type="password" placeholder="Password">
          </div>
        </form>
        <button id="login" class="btn btn-primary btn-block">Login</button>
      </div>
    </div>
  </div>
<script type="text/javascript">

  function login(email,password) {
      $.post('<?= base_url() ?>index.php/auth/chk_login', {email: email, password: password}, function(data) {
      }).done(function(data) {
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
                    window.location = '<?=base_url()?>index.php/main';
                });
              
            }else{
               swal({
                    title: "ไม่สำเร็จ",
                    text: json.message,
                    type: "error",
                    showCancelButton: false
                },
                function(){
                    window.location = '<?=base_url()?>index.php/auth';
                });  
            }
        }catch(e){
                console.log(e);
        }
      });
  }

  $('#login').click(function(event) {
      var email = $('#email').val();
      var password = $('#password').val();
      login(email,password);
  });

  
  $('#password').keypress(function(e) {
    var key = e.which;
    if (key == 13) // the enter key code
    {
      var email = $('#email').val();
      var password = $('#password').val();
      login(email,password);
    }
  });

</script>