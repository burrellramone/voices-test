<script>
    var states = <?=json_encode($states, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);?>;
</script>
<div class="mb-1">
    <a href="/jobs" title="Back"><< Back</a>
</div>
<form id="ajf" action="/jobs/create" method="POST" enctype="multipart/form-data" novalidate="true">
    <div class="form-fieldset">
        <div class="form-field">
            <label class="form-field-label" for="title">Title: <span class="required">(required)</span></label>
            <div class="form-field_contents">
                <input type="text" name="title" id="title" maxlength="150" required/>
            </div>
        </div>
        <div class="form-field">
            <div class="form-field_contents content-right">
                <img class="voices" src="/assets/voices.png" alt="Voices"/>
            </div>
        </div>
    </div>
    
    <div class="form-fieldset">
        <div class="form-field">
            <label class="form-field-label" for="country-id">Country: <span class="required">(required)</span></label>
            <div class="form-field_contents">
                <select id="country-id" name="country_id" required>
                    <option value=""> -- Select Country -- </option>
                    <?php foreach($countries as $country) {?>
                        <option value="<?=$country->getId()?>"><?=$country->getLocaleName()?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-field">
            <label class="form-field-label" for="location-id">State/Province: <span class="required">(required)</span></label>
            <div class="form-field_contents">
                <select id="location-id" name="location_id" disabled required>
                    <option value=""> -- Select State/Province -- </option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-fieldset">
        <div class="form-field">
            <label class="form-field-label" for="additional-information">Additional Information:</label>
            <div class="form-field_contents">
                <textarea name="additional_information" id="additional-information"></textarea>
            </div>
            <div id="ai-counter" class="form-field-counter"><span class="count">0</span> Words</div>
        </div>
    </div>

    <div class="form-fieldset">
        <div class="form-field">
            <label class="form-field-label" for="attachment">File Attachment:</label>
            <div class="form-field_contents">
                <input id="attachment" type="file" name="attachment" accept=".pdf,.png,.jpg,.jpeg"/>
            </div>
        </div>
    </div>

    <div class="form-fieldset">
        <div class="form-field">
            <div class="form-field_contents">
                <button type="reset" class="btn">Clear</button>
            </div>
        </div>

        <div class="form-field">
            <div class="form-field_contents">
                <button type="submit" class="btn">Save Job</button>
            </div>
        </div>
    </div>
</form>