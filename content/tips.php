<?php

/**
 * tips.php
 */
$page['title'] = "Tips";

$page['content'] = <<<EOD

<p class="question">combine chmod with find</p>
<p class="answer">find . -name filename -exec chmod 755 {} \;</p>

<p class="question">find directories named www-mapping and flag sticky bit</p>
<p class="answer">find www-mapping -type d -exec chmod g+s {} \;</p>

<p class="question">find files in /mydir ending with .htm</p>
<p class="answer">find /mydir -iname '*.htm'</p>

<p class="question">add user, create home, give bash shell</p>
<p class="answer">sudo useradd -m -s /bin/bash username</p>

<p class="question">change password</p>
<p class="answer">sudo passwd username</p>

<p class="question">change file owner group to root:www in the www directory:</p>
<p class="answer">sudo chown -R root:www www</p>

<p class="question">change file privileges to 775 in the www directory</p>
<p class="answer">sudo chmod 775 -R www</p>

<p class="question">add a user to a group (both existing)</p>
<p class="answer">sudo adduser username groupname</p>

<p class="question">add a group 'sticky bit' to a directory (so the group doesn't change when someone edits a file)</p>
<p class="answer">sudo chmod g+s dirname (eg /var/www)</p>

<p class="question">create zip archive</p>
<p class="answer">sudo zip -r zipfilename foldertozip</p>

<p class="question">remove .svn files from an entire directory tree</p>
<p class="answer">rm -rf `find . -type d -name .svn` (note the backtick marks - key next to 1)</p>

<p class="question">find process listening on a given port (80 in example)</p>
<p class="answer">sudo fuser -v 80/tcp</p>

<p class="question">test outbound access to a given port (443 in example)</p>
<p class="answer">curl -I https://support.google.com</p>

<p class="question">find all occurances of a string in a group of files</p>
<p class="answer">grep -r 'velocify_leads' .</p>

EOD;

?>
