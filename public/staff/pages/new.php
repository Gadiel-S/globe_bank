<?php

  require_once('../../../private/initialize.php');

  require_login();

  $page = [];

  if(is_post_request()) {
  
    $page['subject_id'] = $_POST['subject_id'] ?? '';
    $page['menu_name'] = $_POST['menu_name'] ?? '';
    $page['position'] = $_POST['position'] ?? '';
    $page['visible'] = $_POST['visible'] ?? '';
    $page['content'] = $_POST['content'] ?? '';
  
    $result = insert_page($page);
    if($result === true) {
      $new_id = mysqli_insert_id($db);
      $_SESSION['message'] = 'The page was created successfully.';
      redirect_to(url_for('/staff/pages/show.php?id=' . $new_id));
    } else {
      $errors = $result;
      // var_dump($errors);
    }
    
  } else {
    $page['subject_id'] = $_GET['subject_id'] ?? '1';
    $page['menu_name'] = '';
    $page['position'] = '';
    $page['visible'] = '';
    $page['content'] = '';
  }

  $page_count = count_pages_by_subject_id($page['subject_id']) + 1;

?>

<?php $page_title = "Create Page"; ?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/subjects/show.php?id=' . h(u($page['subject_id']))); ?>">&laquo; Back to Subject Page</a>

  <div class="page new">
    <h1>Create Page</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/pages/new.php'); ?>" method="post">
      <dl>
        <dt>Subject</dt>
        <dd>
          <select name="subject_id">
          <?php
              $subject_set = find_all_subjects();
              while($subject = mysqli_fetch_assoc($subject_set)) {
                echo "<option value=\"" . h($subject['id']) . "\"";
                if($subject['id']  == $page["subject_id"]) {
                  echo " selected";
                }
                echo ">" . h($subject['menu_name']) . "</option>";
              }
              mysqli_free_result($subject_set);
            ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Menu Name</dt>
        <dd><input type="text" name="menu_name" value="<?php echo h($page['menu_name']); ?>"; /></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position">
          <?php
              for($i=1; $i <= $page_count; $i++ ) {
                echo "<option value=\"{$i}\"";
                if($page['position'] == $i) {
                  echo " selected";
                }
                echo ">{$i}</option>";
              }
            ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd>
          <input type="hidden" name="visible" value="0" />
          <input type="checkbox" name="visible" value="1"<?php if($page['visible'] == "1") { echo " checked"; } ?> />
        </dd>
      </dl>
      <dl>
        <dt>Content</dt>
        <dd>
          <textarea name="content" cols="60" rows="10"><?php echo h($page['content']); ?></textarea>
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Create Page" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>