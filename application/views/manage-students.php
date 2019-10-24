
<body>
  <header class="header" id="htwo">
    <div class="container">
      <div class="logo-area">
        <a href="#"><img src="assets/images/logo_black_medium.png" alt=""></a>
      </div>
      <nav>
        <ul>
          <li><a href="<?php echo base_url('classes'); ?>">Manage Classes</a></li>
          <li class="active"><a href="<?php echo base_url('student/'); ?>">Manage Students</a></li>
          <li><a href="<?php echo base_url('student/student'); ?>">Students Page</a></li>
        </ul>
      </nav>
      <div class="help-icon">
        <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d9/Icon-round-Question_mark.svg/768px-Icon-round-Question_mark.svg.png" alt=""></a>
      </div>
    </div>
  </header>

  <section class="add-student">
    <div class="container">
      <span>Add new Students</span>
      <form action="<?php echo base_url('student/manage'); ?>" method="POST">
        <div class="form-top">
          <div class="text-area">
            <textarea name="student_names" class="tarea"  required cols="40" rows="5" placeholder="Enter names comma separated or on new lines."></textarea>
          </div>

          <div class="form-bottom">
            <div class="db">
              <select name="class_id">
                <?php foreach ($classes as $class) { ?>
                  <option <?php if($class['standard'] == 1){ echo "selected"; } ?> value="<?=$class['_id']?>"><?=$class['class_name']?></option>
                <?php } ?>
              </select>
            </div>

            <div class="button">
              <button>Save</button>
            </div>
          </div>
        </div>
      </form>
        <br><br><br>

        <div class="form-mid">
          <div class="per">
            <p class="t">Or transfer students from another teacher.</p>
          </div>
          <div class="button">
            <button id="trn-toggle">Transfer</button>
          </div>
        </div>


        <div class="toggle-part">
          <div class="pas">
            <h3 class="t">Several teachers work on the same class?</h3>

            <p class="t"><b>Important note:</b> Do you work on the same class as another teacher or do you have students who are already managed by another teacher? To avoid students having to remember two accesses, you should ask their teacher for the code list with the access data. So you can adopt students. They can then see the messages of all their teachers in the same dashboard and with a single login.</p>
            <h3 style="color:#B0C936; display: none;" id="success-msg"></h3>
            <h3 style="color: #D6232B;display: none;" id="error-msg"></h3>
          </div>
          <br>
          <form id="transfer-student" action="javascript:;">
          <div class="form-bottom">
            <div class="text-field">
              <input id="ents" class="in" type="text" required name="student_name" placeholder="Enter Student">
            </div>

            <div class="text-field">
              <input class="in" type="text" required name="code" placeholder="Enter Code">
            </div>
            <div class="db">
              <select name="class_id">
                <?php foreach ($classes as $class) { ?>
                  <option <?php if($class['standard'] == 1){ echo "selected"; } ?> value="<?=$class['_id']?>"><?=$class['class_name']?></option>
                <?php } ?>
              </select>
            </div>
            <div class="button">
              <button type="submit">Transfer</button>
            </div>
          </div>
          </form>
        </div>
    </div>
  </section>


  <section class="code-list">
    <div class="container">
      <span>Codelist</span>
      <form action="<?php echo base_url('student/print_codelist'); ?>" method="POST">

        <h3>Give the students their login codes.</h3>

        <div class="db">
          <select name="class">
            <?php foreach ($classes as $class) { ?>
            <option <?php if($class['standard'] == 1){ echo "selected"; } ?> value="<?=$class['_id']?>"><?=$class['class_name']?></option>
            <?php } ?>
          </select>
        </div>

        <div class="button">
          <button type="submit">Print</button>
        </div>

      </form>
    </div>
  </section>

  <?php if(!empty($student_info)){ ?>
  <section class="my-student">
    <div class="container">
      <span>My Students</span>
  
        <?php 

        foreach ($student_info as $student) { 
           $familyEmail = "";
      $motherEmail = "";
      $fatherEmail = "";
          if(!empty($student['student_emails'])){
            if($student['student_emails'][0]['family']){
              $familyEmail = $student['student_emails'][0]['family'];
            }
            if($student['student_emails'][0]['mother']){
              $motherEmail = $student['student_emails'][0]['mother'];
            }
            if($student['student_emails'][0]['father']){
              $fatherEmail = $student['student_emails'][0]['father'];
            }
            $info = "Student - Code:\r\n".$student['student_code']."\r\n \r\n"."Parents Emails:\r\n".$familyEmail."\r\n". $motherEmail."\r\n".$fatherEmail."\r\n";
            // $info = "Student - Code: ".$student['student_code']." <br> "."Parents Emails: ".$familyEmail." /n ". $motherEmail." /n ".$fatherEmail."";
          }else{
            $info = "Student - Code:\r\n".$student['student_code']."";
          }
          
          ?>
        <div class="box">
          <div class="list">
            <div class="student">
              <h3 class="t"><?=$student['student_name']?></h3>
            </div>
            <div class=class>
              <h4 class="t"><?=$student['class_name']?></h4>
            </div>
            <div class="btn">
              <div class="button">
                <button class="delete-student" data-id="<?=$student['student_id']?>">Delete</button>
              </div>
              <div class="button">
                <button title="<?=$info?>">Info</button>

              </div>
              <div class="button">
                <a href="<?php echo base_url('student/setting/').$student['student_id']; ?>">Settings</a>
              </div>
            </div>

          </div>
        </div>
      <?php } ?>


    </div>
  </section>
<?php } ?>
  <script>
    $(document).ready(function() {
      $("#trn-toggle").click(function() {
        $(".toggle-part").toggle();
      });
    });
  </script>
