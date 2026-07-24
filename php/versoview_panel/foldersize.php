<?php
/*
function folderSize ($dir)
{
    $size = 0;

    foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
        $size += is_file($each) ? filesize($each) : folderSize($each);
    }

    return $size;
}
*/

// original script from http://halgatewood.com/free/file-directory-list/
// modification to show folder sizes from user khanvani on fiverr.com

$mypath = $_SERVER['DOCUMENT_ROOT'];
chdir($mypath);  // change working directory
// THINGS TO CHANGE: 
        // TITLE OF PAGE
        $title = "$_SERVER[SERVER_NAME] <br /><br /> List of Files --  Total size:" . format_size_from_bytes(foldersize(getcwd())) ;
        $sizeOfDir=0;
        // ADD SPECIFIC FILES YOU WANT TO IGNORE HERE
        $ignore_file_list = array( ".htaccess", "Thumbs.db", ".DS_Store" , ".bash_logout" , ".bash_profile", ".bashrc" );

        // ADD SPECIFIC FILE EXTENSIONS YOU WANT TO IGNORE HERE, EXAMPLE: array('psd','jpg','jpeg')
        $ignore_ext_list = array( );

        // SORT BY
        $sort_by = "name_asc"; // options: name_asc, name_desc, date_asc, date_desc

        // ICON URL
        $icon_url = "https://dl.dropbox.com/u/6771946/icons/icons.png";

        // TOGGLE SUB FOLDERS, SET TO false IF YOU WANT OFF
        $toggle_sub_folders = true;


// SET TITLE BASED ON FOLDER NAME, IF NOT SET ABOVE
if( !$title ) { $title = cleanTitle(basename(dirname(__FILE__))); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <title><?php echo $title; ?></title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Lato:700,400,300,300italic,700italic" rel="stylesheet" type="text/css" />
        <style>
                *, *:before, *:after { -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; }
                body { font-family: "Lato", "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; font-weight: 400; font-size: 14px; line-height: 18px; padding: 0; margin: 0; background: #f5f5f5; }
                .wrap { max-width: 600px; margin: 20px auto; background: white; padding: 40px; box-shadow: 0 0 2px #ccc; }
                @media only screen and (max-width: 700px) { .wrap { padding: 15px; } }
                h1 { text-align: center; margin: 40px 0; font-size: 22px; font-weight: bold; color: #666; }
                a { color: #399ae5; text-decoration: none; } a:hover { color: #206ba4; text-decoration: none; }
                .note { padding:  0 5px 25px 0; font-size:80%; color: #666; line-height: 18px; }
                .block { clear: both;  min-height: 50px; border-top: solid 1px #ECE9E9; }
                .block:first-child { border: none; }
                .block .img { width: 50px; height: 50px; display: block; float: left; margin-right: 10px; background: transparent url(https://dl.dropbox.com/u/6771946/icons/icons.png) no-repeat 0 0; }
                .block .date { margin-top: 4px; font-size: 70%; color: #666; }
                .block a { display: block; padding: 10px 15px; transition: all 0.35s; }
                .block a:hover { text-decoration: none; background: #efefef; }

                .jpg, .jpeg, .gif, .png { background-position: -50px 0 !important; } 
                .pdf { background-position: -100px 0 !important; }  
                .txt, .rtf { background-position: -150px 0 !important; }
                .xls, .xlsx { background-position: -200px 0 !important; } 
                .ppt, .pptx { background-position: -250px 0 !important; } 
                .doc, .docx { background-position: -300px 0 !important; }
                .zip, .rar, .tar, .gzip { background-position: -350px 0 !important; }
                .swf { background-position: -400px 0 !important; } 
                .fla { background-position: -450px 0 !important; }
                .mp3 { background-position: -500px 0 !important; }
                .wav { background-position: -550px 0 !important; }
                .mp4 { background-position: -600px 0 !important; }
                .mov, .aiff, .m2v, .avi, .pict, .qif { background-position: -650px 0 !important; }
                .wmv, .avi, .mpg { background-position: -700px 0 !important; }
                .flv, .f2v { background-position: -750px 0 !important; }
                .psd { background-position: -800px 0 !important; }
                .ai { background-position: -850px 0 !important; }
                .html, .xhtml, .dhtml, .php, .asp, .css, .js, .inc { background-position: -900px 0 !important; }
                .dir { background-position: -950px 0 !important; }

                .sub { margin-left: 20px; border-left: solid 1px #ECE9E9; display: none; }

        </style>
</head>
<body>
<h1><?php echo $title ?></h1>
<div class="wrap">
<?php

// FUNCTIONS TO MAKE THE MAGIC HAPPEN, BEST TO LEAVE THESE ALONE
function cleanTitle($title)
{
        return ucwords( str_replace( array("-", "_"), " ", $title) );
}

function getFileExt($filename) 
{
        return substr( strrchr( $filename,'.' ),1 );
}

function format_size($file) 
{
        $bytes = filesize($file);
        if ($bytes < 1024) return $bytes.'b';
        elseif ($bytes < 1048576) return round($bytes / 1024, 2).'Kb';
        elseif ($bytes < 1073741824) return round($bytes / 1048576, 2).'Mb';
        elseif ($bytes < 1099511627776) return round($bytes / 1073741824, 2).'Gb';
        else return round($bytes / 1099511627776, 2).'Tb';
}


// SHOW THE MEDIA BLOCK
function display_block( $file )
{
        global $ignore_file_list, $ignore_ext_list;

        $file_ext = getFileExt($file);
        if( !$file_ext AND is_dir($file)) { $file_ext = "dir"; }
        if(in_array($file, $ignore_file_list)) { return; }
        if(in_array($file_ext, $ignore_ext_list)) { return; }

        echo "<div class=\"block\">";
        echo "<a href=\"$file\" class=\"$file_ext\">";
        echo "  <div class=\"img $file_ext\">&nbsp;</div>";
        echo "  <div class=\"name\">\n";
        echo "          <div class=\"file\">" . basename($file) . "</div>\n";
        if(is_dir($file))
        {
                        echo "<div class=\"date\">Size: " . format_size_from_bytes(foldersize($file))  . "<br />Last modified: " .  date("D. F jS, Y - h:ma", filemtime($file)) . "</div>\n";

        }
        else
        {
        echo "          <div class=\"date\">Size: " . format_size($file) . "<br />Last modified: " .  date("D. F jS, Y - h:ma", filemtime($file)) . "</div>\n";

        }
        echo "  </div>\n";
        echo "  </a>\n";
        echo "</div>";
}
function format_size_from_bytes($size) {
  $mod = 1024;
  $units = explode(' ','B KB MB GB TB PB');
  for ($i = 0; $size > $mod; $i++) {
    $size /= $mod;
  }

  return round($size, 2) . ' ' . $units[$i];
}

function foldersize($path) {
  $total_size = 0;
  $files = scandir($path);

  foreach($files as $t) {
    if (is_dir(rtrim($path, '/') . '/' . $t)) {
      if ($t<>"." && $t<>"..") {
          $size = foldersize(rtrim($path, '/') . '/' . $t);

          $total_size += $size;
      }
    } else {
      $size = filesize(rtrim($path, '/') . '/' . $t);
      $total_size += $size;
    }
  }
  return $total_size;
}

// RECURSIVE FUNCTION TO BUILD THE BLOCKS
function build_blocks( $items, $folder )
{
        global $ignore_file_list, $ignore_ext_list, $sort_by, $toggle_sub_folders;
        $objects = array();
        $objects['directories'] = array();
        $objects['files'] = array();

        foreach($items as $c => $item)
        {
                if( $item == ".." OR $item == ".") continue;

                // IGNORE FILE
                if(in_array($item, $ignore_file_list)) { continue; }

                if( $folder )
                {
                        $item = "$folder/$item";
                }

                $file_ext = getFileExt($item);

                // IGNORE EXT
                if(in_array($file_ext, $ignore_ext_list)) { continue; }

                // DIRECTORIES
                if( is_dir($item) ) 
                {
                        $objects['directories'][] = $item; 
                        continue;
                }

                // FILE DATE
                $file_time = date("U", filemtime($item));

                // FILES
                $objects['files'][$file_time . "-" . $item] = $item;
        }

        foreach($objects['directories'] as $c => $file)
        {
                display_block( $file );

                if($toggle_sub_folders)
                {
                        $sub_items = (array) scandir( $file );
                        if( $sub_items )
                        {
                                echo "<div class='sub' data-folder=\"$file\">";
                                build_blocks( $sub_items, $file );
                                echo "</div>";
                        }
                }
        }

        // SORT BEFORE LOOP
        if( $sort_by == "date_asc" ) { ksort($objects['files']); }
        elseif( $sort_by == "date_desc" ) { krsort($objects['files']); }
        elseif( $sort_by == "name_asc" ) { natsort($objects['files']); }
        elseif( $sort_by == "name_desc" ) { arsort($objects['files']); }

        foreach($objects['files'] as $t => $file)
        {
                $fileExt = getFileExt($file);
                if(in_array($file, $ignore_file_list)) { continue; }
                if(in_array($fileExt, $ignore_ext_list)) { continue; }
                display_block( $file );
        }
}

// GET THE BLOCKS STARTED, FALSE TO INDICATE MAIN FOLDER
//$items = scandir( dirname(__FILE__) );
$items = scandir($mypath);
build_blocks( $items, false );
?>

<?php if($toggle_sub_folders) { ?>
<script>
        $(document).ready(function() 
        {
                $("a.dir").click(function(e)
                {
                        $('.sub[data-folder="' + $(this).attr('href') + '"]').slideToggle();
                        console.log( $(this).attr('href') );
                        e.preventDefault();
                });

        });
</script>
<?php } ?>
</div>
</body>
</html>