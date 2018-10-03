<html>
<head>
<?php $this->getBlock('head')->toHtml(); ?>
<?php $this->header()->toHtml(); ?>
</head>
<body>
<h2>This is header </h2>
<h2>This is body </h2>
<?php $this->pageBody()->toHtml(); ?>
<h2>This is Footer </h2>
</body>
</html>