#
# Regular cron jobs for the sshfail2kml package
#
8 * * * *	root	[ -x /usr/bin/sshfail2kml ] && /usr/bin/sshfail2kml -q
