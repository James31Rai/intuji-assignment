<table class="table table-striped">
    <thead></thead>
    <tbody>
        <?php
        if (count($results) == 0) {
            ?>
            <tr>
                <td colspan="2"><i>No upcoming events found.</i></td>
            </tr>
            <?php
        } else {
            foreach ($results as $event) {
                $start = $event->start->dateTime;
                $dateTime = '';
                if (empty($start)) {
                    $start = $event->start->date;
                }
                $dateTime = '( ' . formatDateTime($start);
                if (!empty($dateTime)) {
                    $end = $event->end->dateTime;
                    if (empty($end)) {
                        $end = $event->end->date;
                    }
                    $dateTime .= ' to ' . formatDateTime($end) . ' )';
                }
                ?>
                <tr>
                    <td><?php echo '<strong>' . $event->getSummary() . '</strong> ' . $dateTime; ?></td>
                    <td><a class="deleteEvent" href="<?= base_url('event/delete?delete=' . $event->getId()) ?>">Delete</a></td>
                </tr>
                <?php
            }
            echo "</ul>";
        }
        ?>
    </tbody>
</table>