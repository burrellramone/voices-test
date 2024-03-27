<?php if($job_submitted){?>
    <div class="alert alert-success">Job was successfully submitted.</div>
<?php } elseif($job_deleted){?>
    <div class="alert alert-success">Job was successfully deleted.</div>
<?php } ?>


<div class="content-right mb-1">
    <a href="/jobs/add" title="Add Job">Add Job</a>
</div>

<table class="jobs">
    <thead>
        <tr>
            <th>Title</th>
            <th>Location</th>
            <th>Attachment</th>
            <th>Created</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <?php if(!empty($jobs)) { ?>
            <?php foreach($jobs as $job) {
                $attachment = $job->getAttachment();
                ?>
                <tr>
                    <td>
                        <a href="/jobs/view?id=<?=$job->getId()?>" title="View Job"><?=$job->getTitle()?></a>
                        <?php if($attachment) { ?>
                            <a href="/<?=$attachment->getPath()?>" title="<?=$attachment->getName()?>" target="_blank" class="attachment mt-1"><?=$attachment->getName()?></a>
                        <?php } ?>
                    </td>
                    <td><?=$job->getLocation()->getLocaleName()?></td>
                    <td>
                        <?php if($attachment) { ?>
                            <a href="/<?=$attachment->getPath()?>" title="<?=$attachment->getName()?>" target="_blank" class="attachment"><?=$attachment->getName()?></a>
                        <?php } ?>
                    </td>
                    <td><?=$job->getDateTimeCreated()->format("D, M jS Y h:i a")?></td>
                    <td>
                        <a href="/jobs/delete?id=<?=$job->getId()?>" title="Delete Job" class="djl">Delete</a>
                    </td>
                </tr>
        <?php } ?>
        <?php } else { ?>
            <tr class="nodata">
                <td colspan="5">No Jobs</td>
            </tr>
        <?php } ?>
    </tbody>

    <tfoot>
        <tr>
            <th>Title</th>
            <th>Location</th>
            <th>Attachment</th>
            <th>Created</th>
            <th></th>
        </tr>
    </tfoot>
</table>
<div class="mt-1"><?=count($jobs)?> Jobs</div>