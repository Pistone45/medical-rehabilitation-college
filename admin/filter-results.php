<?php
include_once '../functions/functions.php';

if (isset($_POST['class_id'])) {
	$class_id = $_POST['class_id'];

	$getAllClassModules = new Staff();
	$classModule = $getAllClassModules->getAllClassModules($class_id);

            if(isset($classModule) && count($classModule)>0){
              foreach($classModule as $classModules){ ?>
                <option value="<?php echo $classModules['modules_id']; ?>"><?php echo $classModules['module_name']; ?></option>
              <?php
                
              }
            }
        

}



?>