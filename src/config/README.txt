To configure a new ARK instance:
* Copy the src/config/ folder and contents to the ARK root config/ folder
* Do NOT modify the contents of php/arkdb/config as these will be ignored
* Modify the contents of config/server.php to configure the root directory and database connection
* In config/preflight_checks.php change $preflight_checks to TRUE
* Run config/preflight_checks.php
* If successful, delete config/preflight_checks.php
* Change the file permissions on the config/ folder and it's contents to restrict access to the webserver user only, usually 440
