#
#<?php die('Forbidden.'); ?>
#Date: 2023-02-28 12:57:17 UTC
#Software: Joomla! 4.2.0 Stable [ Uaminifu ] 16-August-2022 13:05 GMT

#Fields: datetime	priority clientip	category	message
2023-02-28T12:57:17+00:00	INFO ::1	update	Update started by user super user (752). Old version is 4.2.0.
2023-02-28T12:57:19+00:00	INFO ::1	update	Downloading update file from https://s3-us-west-2.amazonaws.com/joomla-official-downloads/joomladownloads/joomla4/Joomla_4.2.8-Stable-Update_Package.zip?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIA6LXDJLNUINX2AVMH%2F20230228%2Fus-west-2%2Fs3%2Faws4_request&X-Amz-Date=20230228T125706Z&X-Amz-Expires=60&X-Amz-SignedHeaders=host&X-Amz-Signature=573f729b7997a171884849062acd21d81561606b5102ec004b4e634578abc1d7.
2023-02-28T12:57:31+00:00	INFO ::1	update	File Joomla_4.2.8-Stable-Update_Package.zip downloaded.
2023-02-28T12:57:32+00:00	INFO ::1	update	Starting installation of new version.
2023-02-28T12:57:42+00:00	INFO ::1	update	Finalising installation.
2023-02-28T12:57:42+00:00	INFO ::1	update	Start of SQL updates.
2023-02-28T12:57:42+00:00	INFO ::1	update	The current database version (schema) is 4.2.0-2022-06-22.
2023-02-28T12:57:42+00:00	INFO ::1	update	Ran query from file 4.2.1-2022-08-23. Query text: DELETE FROM `#__extensions` WHERE `name` = 'plg_fields_menuitem' AND `type` = 'p.
2023-02-28T12:57:42+00:00	INFO ::1	update	Ran query from file 4.2.3-2022-09-07. Query text: DELETE FROM `#__template_overrides` WHERE `template` NOT IN (SELECT `name` FROM .
2023-02-28T12:57:42+00:00	INFO ::1	update	Ran query from file 4.2.7-2022-12-29. Query text: UPDATE `#__mail_templates`    SET `params` = '{"tags":["name","sitename","siteur.
2023-02-28T12:57:42+00:00	INFO ::1	update	Ran query from file 4.2.7-2022-12-29. Query text: UPDATE `#__mail_templates`    SET `params` = '{"tags":["name","sitename","siteur.
2023-02-28T12:57:42+00:00	INFO ::1	update	End of SQL updates.
2023-02-28T12:57:42+00:00	INFO ::1	update	Deleting removed files and folders.
2023-02-28T12:57:44+00:00	INFO ::1	update	Cleaning up after installation.
2023-02-28T12:57:44+00:00	INFO ::1	update	Update to version 4.2.8 is complete.
