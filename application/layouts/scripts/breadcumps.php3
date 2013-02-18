
<?php 

echo $this->navigation($this->container)
->breadcrumbs()
->setLinkLast(true)                   // link last page
->setSeparator(' &#9654;' . PHP_EOL); // cool separator with newline
?>