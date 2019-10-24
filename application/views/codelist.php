<html><head>
	<style type="text/css">
		.container h1{
			text-align: center;
		}
		.table-image{
			width: 150px;
			height: 30px;
		}
		.wd33{
			width: 33.33%;
		}
		.text-left{
			text-align: left;
		}
		.text-center{
			text-align: center;
		}
		.list{
			margin-bottom: 10px;
			margin-top: 10px;
		}
		tr.list td {
			border-bottom:1pt solid black;
		}
		table { 
			border-collapse: collapse; 
			margin: 10px; 
		}
	</style>
</head><body>
 <?php
    $path =  base_url().'assets/images/logo_black_medium.png';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64image = 'data:image/' . $type . ';base64,' . base64_encode($data); 
  ?>
  <section class="code-list">
    <div class="container">
      <h1>Codelist</h1>
      <?php if(!empty($students) && isset($students)){ ?>
        <div class="box">
          <table style="width: 100%">
          	<tbody>
          		<?php foreach ($students as $k => $v) { ?>
          			
          		
          		<tr class="list">
          			<td class="wd33 text-left"><div><img class="table-image" src="<?=$base64image?>"><span><br>Check your open tasks on<br><?php echo base_url('student'); ?></span></div></td>
          			<td class="wd33 text-center"><div><p>Username:</p><p><b><?=$v['student_name']?></b></p></div></td>
          			<td class="wd33 text-center"><div><p>Code:</p><p><b><?=$v['code']?></b></p></div></td>
          		</tr>

          		<?php } ?>
          	</tbody>
          </table>
        </div>
    <?php } ?>
    </div>
  </section>

</body></html>