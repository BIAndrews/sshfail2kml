#
# Regular cron jobs for the sshfail2kml package
#
0 4	* * *	root	[ -x /usr/bin/sshfail2kml_maintenance ] && /usr/bin/sshfail2kml_maintenance
