<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php $this->getBlock('head')->toHtml(); ?>
</head>
<body>
<div class="container">
    <?php $this->getBlock('header')->toHtml(); ?>
    <?php $this->getBlock()->toHtml(); ?>
    <?php $this->getBlock('footer_before')->toHtml(); ?>
    <div class="page-footer" id='footer-section'>
        <div>
            <?php $this->getBlock('footer')->toHtml(); ?>
        </div>
        <div>
            <?php $this->getBlock('foot')->toHtml(); ?>
        </div>
    </div>
</div>
</body>
</html>
