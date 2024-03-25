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
                $attachment = $jon->getAttachment();
                ?>
                <tr>
                    <td><?=$job->getTitle()?></td>
                    <td><?=$job->getLocation()->getLocaleName()?></td>
                    <td>
                        <?php if($attachment) { ?>
                            <a href="<?=$attachment->getUrl()?>" title="<?=$attachment->getName()?>"><?=$attachment->getName()?>
                        <?php } ?>
                    </td>
                    <td><?=$job->getDateTimeCreated()->format()?></td>
                    <td></td>
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