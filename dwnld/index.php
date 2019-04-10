<?php
session_start();
###############################################################
# File Download 1.3
###############################################################
# Visit http://www.zubrag.com/scripts/ for updates
###############################################################
# Sample call:
#    download.php?f=phptutorial.zip
#
# Sample call (browser will try to save with new file name):
#    download.php?f=phptutorial.zip&fc=php123tutorial.zip
###############################################################

// Allow direct file download (hotlinking)?
// Empty - allow hotlinking
// If set to nonempty value (Example: example.com) will only allow downloads when referrer contains this text
define('ALLOWED_REFERRER', '');

// Download folder, i.e. folder where you keep all files for download.
// MUST end with slash (i.e. "/" )
//define('BASE_DIR','/home/user/downloads/');

$fpath  = $_SESSION['fpath'];
$FlToDl = $_SESSION['FlToDl'];
if($fpath && $FlToDl){
    define('BASE_DIR', $fpath);

    //define('BASE_DIR','../uploadedfiles/');

    // log downloads?  true/false
    define('LOG_DOWNLOADS',true);

    // log file name
    //define('LOG_FILE','downloads.log');

    // Allowed extensions list in format 'extension' => 'mime type'
    // If myme type is set to empty string then script will try to detect mime type 
    // itself, which would only work if you have Mimetype or Fileinfo extensions
    // installed on server.
    $allowed_ext = array (

        'acx'	=>	'application/internet-property-stream',
        'ai'	=>	'application/postscript',
        'aif'	=>	'audio/x-aiff',
        'aifc'	=>	'audio/x-aiff',
        'aiff'	=>	'audio/x-aiff',
        'asf'	=>	'video/x-ms-asf',
        'asr'	=>	'video/x-ms-asf',
        'asx'	=>	'video/x-ms-asf',
        'au'	=>	'audio/basic',
        'avi'	=>	'video/x-msvideo',
        'axs'	=>	'application/olescript',
        'bas'	=>	'text/plain',
        'bcpio'	=>	'application/x-bcpio',
        'bin'	=>	'application/octet-stream',
        'bmp'	=>	'image/bmp',
        'c'		=>	'text/plain',
        'cat'	=>	'application/vnd.ms-pkiseccat',
        'cdf'	=>	'application/x-cdf',
        'cdf'	=>	'application/x-netcdf',
        'cer'	=>	'application/x-x509-ca-cert',
        'class'	=>	'application/octet-stream',
        'clp'	=>	'application/x-msclip',
        'cmx'	=>	'image/x-cmx',
        'cod'	=>	'image/cis-cod',
        'cpio'	=>	'application/x-cpio',
        'crd'	=>	'application/x-mscardfile',
        'crl'	=>	'application/pkix-crl',
        'crt'	=>	'application/x-x509-ca-cert',
        'csh'	=>	'application/x-csh',
        'css'	=>	'text/css',
        'dcr'	=>	'application/x-director',
        'der'	=>	'application/x-x509-ca-cert',
        'dir'	=>	'application/x-director',
        'dll'	=>	'application/x-msdownload',
        'dms'	=>	'application/octet-stream',
        'doc'	=>	'application/msword',
        'docx'	=>	'application/msword',
        'dot'	=>	'application/msword',
        'dvi'	=>	'application/x-dvi',
        'dxr'	=>	'application/x-director',
        'dxf'	=>	'application/autocad',
        'edrw'	=>	'application/autocad',
        'eps'	=>	'application/postscript',
        'etx'	=>	'text/x-setext',
        'evy'	=>	'application/envoy',
        'exe'	=>	'application/octet-stream',
        'fif'	=>	'application/fractals',
        'flr'	=>	'x-world/x-vrml',
        'gif'	=>	'image/gif',
        'gtar'	=>	'application/x-gtar',
        'gz'	=>	'application/x-gzip',
        'h'		=>	'text/plain',
        'hdf'	=>	'application/x-hdf',
        'hlp'	=>	'application/winhlp',
        'hqx'	=>	'application/mac-binhex40',
        'hta'	=>	'application/hta',
        'htc'	=>	'text/x-component',
        'htm'	=>	'text/html',
        'html'	=>	'text/html',
        'htt'	=>	'text/webviewhtml',
        'ico'	=>	'image/x-icon',
        'ief'	=>	'image/ief',
        'iii'	=>	'application/x-iphone',
        'ins'	=>	'application/x-internet-signup',
        'isp'	=>	'application/x-internet-signup',
        'jfif'	=>	'image/pipeg',
        'jpe'	=>	'image/jpeg',
        'jpeg'	=>	'image/jpeg',
        'jpg'	=>	'image/jpeg',
        'js'	=>	'application/x-javascript',
        'latex'	=>	'application/x-latex',
        'lha'	=>	'application/octet-stream',
        'lsf'	=>	'video/x-la-asf',
        'lsx'	=>	'video/x-la-asf',
        'lzh'	=>	'application/octet-stream',
        'm13'	=>	'application/x-msmediaview',
        'm14'	=>	'application/x-msmediaview',
        'm3u'	=>	'audio/x-mpegurl',
        'man'	=>	'application/x-troff-man',
        'mdb'	=>	'application/x-msaccess',
        'me'	=>	'application/x-troff-me',
        'mht'	=>	'message/rfc822',
        'mhtml'	=>	'message/rfc822',
        'mid'	=>	'audio/mid',
        'mny'	=>	'application/x-msmoney',
        'mov'	=>	'video/quicktime',
        'movie'	=>	'video/x-sgi-movie',
        'mp2'	=>	'video/mpeg',
        'mp3'	=>	'audio/mpeg',
        'mpa'	=>	'video/mpeg',
        'mpe'	=>	'video/mpeg',
        'mpeg'	=>	'video/mpeg',
        'mpg'	=>	'video/mpeg',
        'mpp'	=>	'application/vnd.ms-project',
        'mpv2'	=>	'video/mpeg',
        'ms'	=>	'application/x-troff-ms',
        'msg'	=>	'application/vnd.ms-outlook',
        'mvb'	=>	'application/x-msmediaview',
        'nc'	=>	'application/x-netcdf',
        'nws'	=>	'message/rfc822',
        'oda'	=>	'application/oda',
        'p10'	=>	'application/pkcs10',
        'p12'	=>	'application/x-pkcs12',
        'p7b'	=>	'application/x-pkcs7-certificates',
        'p7c'	=>	'application/x-pkcs7-mime',
        'p7m'	=>	'application/x-pkcs7-mime',
        'p7r'	=>	'application/x-pkcs7-certreqresp',
        'p7s'	=>	'application/x-pkcs7-signature',
        'pbm'	=>	'image/x-portable-bitmap',
        'pdf'	=>	'application/pdf',
        'pfx'	=>	'application/x-pkcs12',
        'pgm'	=>	'image/x-portable-graymap',
        'pko'	=>	'application/ynd.ms-pkipko',
        'pma'	=>	'application/x-perfmon',
        'pmc'	=>	'application/x-perfmon',
        'pml'	=>	'application/x-perfmon',
        'pmr'	=>	'application/x-perfmon',
        'png'	=>	'image/jpeg',
        'pmw'	=>	'application/x-perfmon',
        'pnm'	=>	'image/x-portable-anymap',
        'pot'	=>	'application/vnd.ms-powerpoint',
        'ppm'	=>	'image/x-portable-pixmap',
        'pps'	=>	'application/vnd.ms-powerpoint',
        'ppt'	=>	'application/vnd.ms-powerpoint',
        'prf'	=>	'application/pics-rules',
        'ps'	=>	'application/postscript',
        'pub'	=>	'application/x-mspublisher',
        'qt'	=>	'video/quicktime',
        'ra'	=>	'audio/x-pn-realaudio',
        'ram'	=>	'audio/x-pn-realaudio',
        'ras'	=>	'image/x-cmu-raster',
        'rgb'	=>	'image/x-rgb',
        'rmi'	=>	'audio/mid',
        'roff'	=>	'application/x-troff',
        'rtf'	=>	'application/rtf',
        'rtx'	=>	'text/richtext',
        'scd'	=>	'application/x-msschedule',
        'sct'	=>	'text/scriptlet',
        'setpay'	=>	'application/set-payment-initiation',
        'setreg'	=>	'application/set-registration-initiation',
        'sh'	=>	'application/x-sh',
        'shar'	=>	'application/x-shar',
        'sit'	=>	'application/x-stuffit',
        'snd'	=>	'audio/basic',
        'spc'	=>	'application/x-pkcs7-certificates',
        'spl'	=>	'application/futuresplash',
        'sql'	=>	'text/html',
        'src'	=>	'application/x-wais-source',
        'sst'	=>	'application/vnd.ms-pkicertstore',
        'stl'	=>	'application/vnd.ms-pkistl',
        'stm'	=>	'text/html',
        'sv4cpio'	=>	'application/x-sv4cpio',
        'sv4crc'	=>	'application/x-sv4crc',
        'svg'	=>	'image/svg+xml',
        'swf'	=>	'application/x-shockwave-flash',
        't'		=>	'application/x-troff',
        'tar'	=>	'application/x-tar',
        'tcl'	=>	'application/x-tcl',
        'tex'	=>	'application/x-tex',
        'texi'	=>	'application/x-texinfo',
        'texinfo'	=>	'application/x-texinfo',
        'tgz'	=>	'application/x-compressed',
        'tif'	=>	'image/tiff',
        'tiff'	=>	'image/tiff',
        'tr'	=>	'application/x-troff',
        'trm'	=>	'application/x-msterminal',
        'tsv'	=>	'text/tab-separated-values',
        'txt'	=>	'text/plain',
        'uls'	=>	'text/iuls',
        'ustar'	=>	'application/x-ustar',
        'vcf'	=>	'text/x-vcard',
        'vrml'	=>	'x-world/x-vrml',
        'wav'	=>	'audio/x-wav',
        'wcm'	=>	'application/vnd.ms-works',
        'wdb'	=>	'application/vnd.ms-works',
        'wks'	=>	'application/vnd.ms-works',
        'wmf'	=>	'application/x-msmetafile',
        'wps'	=>	'application/vnd.ms-works',
        'wri'	=>	'application/x-mswrite',
        'wrl'	=>	'x-world/x-vrml',
        'wrz'	=>	'x-world/x-vrml',
        'xaf'	=>	'x-world/x-vrml',
        'xbm'	=>	'image/x-xbitmap',
        'xla'	=>	'application/vnd.ms-excel',
        'xlc'	=>	'application/vnd.ms-excel',
        'xlm'	=>	'application/vnd.ms-excel',
        'xls'	=>	'application/vnd.ms-excel',
        'xlsx'	=>	'application/vnd.ms-excel',
        'xlt'	=>	'application/vnd.ms-excel',
        'xlw'	=>	'application/vnd.ms-excel',
        'xof'	=>	'x-world/x-vrml',
        'xpm'	=>	'image/x-xpixmap',
        'xwd'	=>	'image/x-xwindowdump',
        'z'		=>	'application/x-compress',
        'zip'	=>	'application/zip'
    );



    ####################################################################
    ###  DO NOT CHANGE BELOW
    ####################################################################

    // If hotlinking not allowed then make hackers think there are some server problems
    if (ALLOWED_REFERRER !== ''
    && (!isset($_SERVER['HTTP_REFERER']) || strpos(strtoupper($_SERVER['HTTP_REFERER']),strtoupper(ALLOWED_REFERRER)) === false)
    ) {
      die("Internal server error. Please contact system administrator.");
    }

    // Make sure program execution doesn't time out
    // Set maximum script execution time in seconds (0 means no limit)
    set_time_limit(0);


    if (!$FlToDl) {
        die("Please specify file name for download.");
    }


    // Get real file name.
    // Remove any path info to avoid hacking by adding relative path, etc.

    $fname = basename($FlToDl);

    // Check if the file exists
    // Check in subfolders too
    function find_file ($dirname, $fname, &$file_path) {

      $dir = opendir($dirname);

      while ($file = readdir($dir)) {
        if (empty($file_path) && $file != '.' && $file != '..') {
          if (is_dir($dirname.'/'.$file)) {
            find_file($dirname.'/'.$file, $fname, $file_path);
          }
          else {
            if (file_exists($dirname.'/'.$fname)) {
              $file_path = $dirname.'/'.$fname;
              return;
            }
          }
        }
      }

    } // find_file

    // get full file path (including subfolders)
    $file_path = '';
    find_file(BASE_DIR, $fname, $file_path);

    if (!is_file($file_path)) {
      die("File does not exist. Make sure you specified correct file name."); 
    }

    // file size in bytes
    $fsize = filesize($file_path); 

    // file extension
    $fext = strtolower(substr(strrchr($fname,"."),1));

    // check if allowed extension
    if (!array_key_exists($fext, $allowed_ext)) {
      die("Not allowed file type."); 
    }

    // get mime type
    if ($allowed_ext[$fext] == '') {
      $mtype = '';
      // mime type is not set, get from server settings
      if (function_exists('mime_content_type')) {
        $mtype = mime_content_type($file_path);
      }
      else if (function_exists('finfo_file')) {
        $finfo = finfo_open(FILEINFO_MIME); // return mime type
        $mtype = finfo_file($finfo, $file_path);
        finfo_close($finfo);  
      }
      if ($mtype == '') {
        $mtype = "application/force-download";
      }
    }
    else {
      // get mime type defined by admin
      $mtype = $allowed_ext[$fext];
    }

    // Browser will try to save file with this filename, regardless original filename.
    // You can override it if needed.

    if($_SESSION['FlOrg'])
        $asfname = $_SESSION['FlOrg'];
    elseif (!isset($_GET['fc']) || empty($_GET['fc'])) {
      $asfname = $fname;
    }
    else {
      // remove some bad chars
      $asfname = str_replace(array('"',"'",'\\','/'), '', $_GET['fc']);
      if ($asfname === '') $asfname = 'NoName';
    }

    // set headers
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Type: $mtype");
    header("Content-Disposition: attachment; filename=\"$asfname\"");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . $fsize);

    // download
    // @readfile($file_path);
    $file = @fopen($file_path,"rb");
    if ($file) {
      while(!feof($file)) {
        print(fread($file, 1024*8));
        flush();
        if (connection_status()!=0) {
          @fclose($file);
          die();
        }
      }
      @fclose($file);
    }
}
unset($_SESSION["FlOrg"]);
unset($_SESSION["FlToDl"]);
unset($_SESSION["fpath"]);
?>