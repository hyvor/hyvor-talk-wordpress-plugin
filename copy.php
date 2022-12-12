<?php
exec('rm -rf wordpress/wp-content/plugins/hyvor-talk');
exec('cp -R svn/trunk wordpress/wp-content/plugins/hyvor-talk');