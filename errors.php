<?php  if (count($reg_errors) > 0) : ?>
  <div class="error">
  	<?php foreach ($reg_errors as $error) : ?>
  	  <p class="bg-danger text-light p-3"><?php echo $error ?></p>
  	<?php endforeach ?>
  </div>
<?php  elseif(count($sign_errors) > 0) : ?>
  <div class="error">
  	<?php foreach ($sign_errors as $error) : ?>
  	  <p class="bg-danger text-light p-3"><?php echo $error ?></p>
  	<?php endforeach ?>
  </div>
<?php


endif ?>