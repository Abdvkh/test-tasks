# Steps to use
1. `chmod +x script.php` 
2. `chmod +x script.sh`
   * Change `/Users/abubakr/projects/test-tasks/script-auto-run/script.php` to `/path/to/script-auto-run/script.php` 
3. Add task to crontab to run every minute
    1. `sudo crontab -e`
    2. Insert `* * * * * /path/to/script-auto-run/script.sh >> /path/to/script-auto-run/log`
    
## Warning:
`/path/to/` have to be provided