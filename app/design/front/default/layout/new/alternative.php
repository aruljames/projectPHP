<?php
$layout1 = $this->getLayout('new/alternative1');
$layout2 = $this->getLayout('new/alternative2');
$this->getBlock('td1')->setLayout($layout1);
$this->getBlock('td2')->setLayout($layout2);
?>
<table border=1>
	<tr>
		<td><?php $this->getBlock('td1')->toHtml(); ?></td>
	</tr>
	<tr>
		<td><?php $this->getBlock('td2')->toHtml(); ?></td>
	</tr>
</table>
<br>Alternative start
<?php $this->getBlock()->toHtml(); ?>
<br>Alternative end
