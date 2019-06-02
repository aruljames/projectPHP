<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php $this->getBlock('head')->toHtml(); ?>
</head>
<body>
<?php $this->getBlock('header')->toHtml(); ?>
<?php $this->getBlock()->toHtml(); ?>
<?php $this->getBlock('footer_before')->toHtml(); ?>
<?php $this->getBlock('footer')->toHtml(); ?>
<?php $this->getBlock('foot')->toHtml(); ?>
</body>
</html>
