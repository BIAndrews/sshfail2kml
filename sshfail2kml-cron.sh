# Cron script for hourly runs every hour 8 minutes after the hour
8 * * * * root /usr/bin/sshfail2kml -q >/dev/null 2>&1
