<form method="post" action="<?= base_url(); ?>event/add" class="form">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Event Title <span class="req">*</span></label>
                <input id="summary" type="text" class="form-control" name="summary"
                    value="<?php echo !empty($summary) ?: ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Event Location <span class="req">*</span></label>
                <input id="location" type="text" class="form-control" name="location"
                    value="<?php echo !empty($location) ?: ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Date <span class="req">*</span></label>
                <input id="date" type="date" name="date" class="form-control"
                    value="<?php echo !empty($date) ?: ''; ?>" required>
            </div>
            <div class="form-group mt-3">
                <div class="input-group">
                    <div class="input-group-addon">Time <span class="req">*</span>&nbsp;</div>
                    <input id="time_from" type="time" name="time_from" class="form-control"
                        value="<?php echo !empty($time_from) ?: ''; ?>" required>
                    <div class="input-group-addon">&nbsp;To <span class="req">*</span>&nbsp;</div>
                    <input id="time_to" type="time" name="time_to" class="form-control"
                        value="<?php echo !empty($time_to) ?: ''; ?>" required>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Event Description</label>
                <textarea id="description" name="description" class="form-control"
                    rows="5"><?php echo !empty($description) ?: ''; ?></textarea>
            </div>
            <div class="form-group">
                <br />
                <input type="submit" class="form-control btn-primary" name="submit" value="Add Event" />
            </div>
        </div>
    </div>
</form>