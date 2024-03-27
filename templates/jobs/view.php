<div class="mb-1">
    <a href="/jobs" title="Back"><< Back</a>
    <a href="/jobs/delete?id=<?=$job->getId()?>" class="djl float-right" title="Delete">Delete</a>
</div>

<div class="job">
    <?php $attachment = $job->getAttachment();?>
    
    <div class="location"><strong>Location</strong>: <span><?=$job->getLocation()->getLocaleName()?></span></div>

    <?php if($attachment) { ?>
        <div class="mt-1"><a href="/<?=$attachment->getPath()?>" title="<?=$attachment->getName()?>" target="_blank" class="attachment mt-1"><?=$attachment->getName()?></a></div>
    <?php } ?>

    <p class="additional-information"><?=$job->getAdditionalInformation()?></p>

    <div class="mt-1">
        <a href="/jobs/delete?id=<?=$job->getId()?>" class="btn btn-block mobile djl">Delete Job</a>
    </div>
</div>