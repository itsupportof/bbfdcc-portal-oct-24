<?php
/**
 * CLI-only cron script: sends the next batch of queued announcement emails.
 *
 * Schedule it in cPanel -> Cron Jobs (every 2 minutes recommended):
 *   /usr/local/bin/php /home5/optimis7/public_html/brightbeginningsfdcc.com.au/portal/cron_send_announcements.php
 *
 * Each run sends up to 5 emails, so the queue drains gradually and stays
 * within the mail server's rate limits. Runs are harmless when the queue is empty.
 */
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('Forbidden: this script runs from the command line only.');
}
chdir(__DIR__);
require __DIR__ . '/lib.php';
$res = processAnnouncementQueue(5);
echo date('Y-m-d H:i:s') . " announcements: sent={$res['sent']} failed={$res['failed']} remaining={$res['remaining']}\n";
