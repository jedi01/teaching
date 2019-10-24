
<body>
  <header class="header" id="hone">
    <div class="container">
      <div class="logo-area">
        <a href="#"><img src="assets/images/logo_black_medium.png" alt=""></a>
      </div>
      <nav>
        <ul>
          <li class="active"><a href="<?php echo base_url('classes'); ?>">Manage Classes</a></li>
          <li><a href="<?php echo base_url('student'); ?>">Manage Students</a></li>
          <li><a href="<?php echo base_url('student/student'); ?>">Students Page</a></li>
        </ul>
      </nav>
      <div class="help-icon">
        <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d9/Icon-round-Question_mark.svg/768px-Icon-round-Question_mark.svg.png" alt=""></a>
      </div>
    </div>
  </header>

  <section class="new-classes">

 
    <div class="container">

      <span>Create a new class</span>
      <form action="<?php echo base_url('classes/manage'); ?>" method="POST">
        <div class="text-field" id="t1">
          <input class="in" type="text" required name="class_name" placeholder="Enter class name">
        </div>

        <div class="text-field" id="t2">
          <input class="in" type="text" required name="teacher_name" value="<?php echo (isset($teacher[0])?$teacher[0]['teacher_name']:''); ?>">
        </div>
        <div class="button" id="b1">
          <button type="submit">Save</button>
        </div>
      </form>
      <div class="gray-guide">
        <p>2 of 3 classes created. Upgrade for more classes.</p>
      </div>
    </div>

  </section>
<?php if(!empty($classes)){ ?>
  <section class="your-class">
    <div class="container">

      <span>Your classes</span>
       
        <?php foreach ($classes as $class) { ?>
          <div class="text-row">
            <div class="text-field">
              <input class="in" type="text" id="class_name<?=$class['_id']?>" required name="class_name" value="<?=$class['class_name']?>">
            </div>
            <div class="btn-set">
              <div class="button">
                <a href="<?php echo base_url('classes/settings/').$class['_id']; ?>">Settings</a>
              </div>
              <div class="button">
                <button type="button" class="delete-class" data-id="<?=$class['_id']?>">Delete</button>
              </div>
              <div class="button">
                <button type="button" onclick="update(`<?=$class['_id']?>`);">Change</button>
              </div>
            </div>
          </div>
        <?php } ?>
       
    </div>
  </section>

  <section class="dropdown-box">
    <div class="container">
      <span>Select main class:</span>
      <form action="<?php echo base_url('classes/standard'); ?>" method="POST">
        <div class="drb">
          <select name="standart_class">
            <?php foreach ($classes as $class) { ?>
            <option <?php if($class['standard'] == 1){ echo "selected"; } ?> value="<?=$class['_id']?>"><?=$class['class_name']?></option>
            <?php } ?>
          </select>
        </div>
        <div class="button">
          <button>Save</button>
        </div>
      </form>
    </div>
  </section>

  <?php } ?>

