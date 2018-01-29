<br>===========================<br>
<?php //$this->set("name","Arul James"); ?>
<?php $this->printTemplate('hi') ?>
<br>
<?php echo $this->name ?>
<br>
<?php echo $this->age ?>
<?php //$this->printTemplate('hi\hi') ?>
<?php //$this->printTemplate('\index\index\hi') ?>
<?php $this->printPage('home',array("key" => "mydata","hi" => "ooi")) ?>
<?php
echo "<br>index index view file from design view";
?>
<br>=============================<br>
