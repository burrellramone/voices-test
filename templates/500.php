<?php if(isset($e)) { ?>
    <p><?=$e->getMessage()?></p>
    <pre><?php print_r($e)?></pre>
<?php } else { ?>
    <p>There was an internal server error.</p>
<?php } ?>