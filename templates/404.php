<?php if(isset($e)) { ?>
    <p><?=$e->getMessage()?></p>
    <p>Click <a href="/" title="Jobs">here</a> to return home.</p>
<?php } else { ?>
    <p>The resource requested could not be found. Click <a href="/" title="Jobs">here</a> to return home.</p>
<?php } ?>