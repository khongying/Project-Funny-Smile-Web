<?php
	function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}
?>
<div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">History</a>
        </li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
        <?php 
                foreach ($patient as $i => $data) {
        ?>
            <i class="fa fa-fw fa-tasks"></i>  ID : <?= $data->no_card ?> |  เลขที่บัตร : <?= $data->no_card_patient ?> | <?= $data->full_name ?>
             
            
        <?php
                }
        ?>
        </div>
        <div class="card-body">
            <form id="from_patient">
            <?php 
                foreach ($history as $i => $data) {
                    // echo "<pre>";
                    // var_dump($data);
            ?>

                <div class="card">
                    <div class="card-body">
                    <?php
                    switch ($data->state) {
                        case 'Success':
                    ?>
                        <h4 class="card-title"><button class="btn btn-success"><?= $data->state ?></button> <?= DateThai($data->date)?>, <?=  $data->time ?> น.</h4>
                    <?php
                            break;

                        case 'Wait':
                    ?>
                        <h4 class="card-title"><button class="btn btn-secondary"><?= $data->state ?></button> <?= DateThai($data->date)?>, <?=  $data->time ?> น.</h4>
                    <?php
                            break;

                        case 'Postpone':
                    ?>
                        <h4 class="card-title"><button class="btn btn-warning"><?= $data->state ?></button> <?= DateThai($data->date)?>, <?=  $data->time ?> น.</h4>
                    <?php
                            break;
                        
                        default:
                    ?>
                        <h4 class="card-title"><button class="btn btn-light"><?= $data->state ?></button> <?= DateThai($data->date)?>, <?=  $data->time ?> น.</h4>
                    <?php
                            break;
                    }
                   
                    
                    ?>
                        <h4 class="card-title"></h4>
                        <p class="card-text"><?= $data->reason ?></p>
                        <div class="card bg-light text-dark">
                            <div class="card-body">
                                <p class="card-text">  Dentist : <?= $data->dentist_gender ?> <?= $data->fname ?>  <?= $data->lname ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                
            <?php
                } 
            ?>
        </div>
        <div class="card-footer small text-muted">Funny Smile</div>
    </div>
</div>


<!-- object(stdClass)#23 (14) {
  ["id_patient"]=>
  string(1) "1"
  ["no_card"]=>
  string(13) "1229900603504"
  ["no_card_patient"]=>
  string(5) "09-91"
  ["full_name"]=>
  string(37) "คงยิ่ง คุณเขต"
  ["phone"]=>
  string(10) "0922723107"
  ["be_allergic"]=>
  string(5) "sdaas"
  ["ref_dentist_id"]=>
  string(1) "1"
  ["avatar"]=>
  string(0) ""
  ["id"]=>
  string(1) "1"
  ["dentist_number"]=>
  string(10) "2147483647"
  ["dentist_gender"]=>
  string(7) "ทพ."
  ["fname"]=>
  string(18) "คงยิ่ง"
  ["lname"]=>
  string(18) "คุณเขต"
  ["dentist_type"]=>
  string(1) "1"
} -->