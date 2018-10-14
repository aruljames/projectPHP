<html>
<head>
<?php $this->getBlock('head')->toHtml(); ?>
</head>
<body>
<?php $this->getBlock('header')->toHtml(); ?>
<?php $this->getBlock()->toHtml(); ?>
<?php $this->getBlock('footer')->toHtml(); ?>
<?php $this->getBlock('foot')->toHtml(); ?>
</body>
</html>
