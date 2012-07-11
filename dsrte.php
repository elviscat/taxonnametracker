<?php
/**
 * Damn Small Rich Text Editor v0.1.4 for jQuery
 * by Roi Avidan <roi@avidansoft.com>
 * Demo: http://www.avidansoft.com/dsrte/dsrte.php
 * Released under the GPL License
 *
 * Includes a minified version of AjaxFileUpload plugin for jQuery, taken from: http://www.phpletter.com/DOWNLOAD/
 * DOES NOT INCLUDE jQuery! You should download jQuery from http://jquery.com
 */

/**
 * Send compressed HTML to the Browser (reduce 22k output to 4k!!)
 */
function sendcompressedcontent( $content )
{
    header( "Content-Encoding: gzip" );
    return gzencode( $content, 9 );
}

/**
 * This function is used to translate strings, so your Editor may appear multi-lingual.
 * Currently, that logic is not implemented - I'm leaving it to you.
 * And yes... the name's inspirted by Drupal ;)
 *
 * @param $str
 *   String to translate.
 * @return
 *   Translated string.
 */
function t( $str )
{
    return $str;
}

/**
 * Simple function to add JavaScript files to the output source.
 *
 * @param $jsfile
 *   JavaScript filename to include.
 * @return
 *   Nothing.
 */
function add_js( $jsfile )
{
    $GLOBALS['scripts'] .= "<script type=\"text/javascript\" src=\"$jsfile\"></script>\n";
}

/**
 * This is where the magic is.
 * Built the Editor's HTML framework. It creates a valid XHTML 1.0 Transitional code.
 *
 * @param $id
 *   ID for the Editor element.
 * @param $default_text
 *   (Optional) If given, this will be the text that the editor will display once the page
 *   has finished loading.
 * @param $cmds
 *   (Optional) If given, this defines the available Editor commands. each command is separated
 *   by a single space, | (bar) will create a graphic separator bar and , (comma) will move
 *   to a new line.
 */
function build_editor( $id, $default_text = '', $cmds = '', $resizable = true )
{
    $uploadPath = 'uploadedfiles';

    // define available editor commands
    $commands = array(
        'bold' => array( 'icon' => 'bold.gif', 'command' => 'bold', 'arguments' => '', 'title' => t( 'Bold' ) ),
        'italic' => array( 'icon' => 'italic.gif', 'command' => 'italic', 'arguments' => '', 'title' => t( 'Italics' ) ),
        'underline' => array( 'icon' => 'underline.gif', 'command' => 'underline', 'arguments' => '', 'title' => t( 'Underline' ) ),
        'left' => array( 'icon' => 'justifyleft.gif', 'command' => 'justifyleft', 'arguments' => '', 'title' => t( 'Left Justify' ) ),
        'center' => array( 'icon' => 'justifycenter.gif', 'command' => 'justifycenter', 'arguments' => '', 'title' => t( 'Center' ) ),
        'right' => array( 'icon' => 'justifyright.gif', 'command' => 'justifyright', 'arguments' => '', 'title' => t( 'Right Justify' ) ),
        //'justify' => array( 'icon' => 'justifyfull.gif', 'command' => 'justify', 'arguments' => '', 'title' => t( 'Justify' ) ),
        'ul' => array( 'icon' => 'bullet.gif', 'command' => 'insertunorderedlist', 'arguments' => '', 'title' => t( 'Bullets' ) ),
        'ol' => array( 'icon' => 'numlist.gif', 'command' => 'insertorderedlist', 'arguments' => '', 'title' => t( 'Numbered List' ) ),
        'indent' => array( 'icon' => 'indent.gif', 'command' => 'indent', 'arguments' => '', 'title' => t( 'Indent' ) ),
        'outdent' => array( 'icon' => 'outdent.gif', 'command' => 'outdent', 'arguments' => '', 'title' => t( 'Outdent' ) ),
        'color' => array( 'icon' => 'forecolor.gif', 'command' => 'forecolor', 'arguments' => 'color', 'title' => t( 'Font Color' ) ),
        'bgcolor' => array( 'icon' => 'backcolor.gif', 'command' => strpos( strtolower( $_SERVER['HTTP_USER_AGENT'] ), 'msie' ) === false ? 'hilitecolor' : 'backcolor', 'arguments' => 'color', 'title' => t( 'Background Color' ) ),
        'link' => array( 'icon' => 'link.gif', 'command' => 'createlink', 'arguments' => 'link', 'title' => t( 'Insert Link' ) ),
        'unlink' => array( 'icon' => 'unlink.gif', 'command' => 'unlink', 'arguments' => '', 'title' => t( 'Remove Link' ) ),
        
        
        
        'attachment' => array( 'icon' => 'attachment.gif', 'command' => 'insertimage', 'arguments' => 'attachment', 'title' => t( 'Insert Attachment' ) ),
        
        'image' => array( 'icon' => 'image.gif', 'command' => 'insertimage', 'arguments' => 'image', 'title' => t( 'Insert Image' ) ),
        
        
        
        'html' => array( 'icon' => 'html.gif', 'command' => 'inserthtml', 'arguments' => 'html', 'title' => t( 'Insert HTML Code' ) ),
        
        'emoticons' => array( 'icon' => 'emoticons.gif', 'command' => 'insertimage', 'arguments' => 'emoticons', 'title' => t( 'Insert Emoticon' ) ),
        
        'rule' => array( 'icon' => 'hr.gif', 'command' => 'inserthorizontalrule', 'arguments' => '', 'title' => t( 'Horizontal Rule' ) ),
        'clean' => array( 'icon' => 'cleanup.gif', 'command' => '-', 'arguments' => 'clean', 'title' => t( 'Cleanup' ) ),
        'font' => array( 'select' => 'Arial Times Verdana Helvetica Sans', 'command' => 'fontname', 'arguments' => '', 'title' => t( 'Font' ) ),
        'fontsize' => array( 'select' => '1 2 3 4 5 6 7 8 9 10', 'command' => 'fontsize', 'arguments' => '', 'title' => t( 'Size' ) ),
        'sub' => array( 'icon' => 'sub.gif', 'command' => 'subscript', 'arguments' => '', 'title' => t( 'Subscript' ) ),
        'sup' => array( 'icon' => 'sup.gif', 'command' => 'superscript', 'arguments' => '', 'title' => t( 'Superscript' ) ),
        'strikeout' => array( 'icon' => 'strikeout.gif', 'command' => 'strikethrough', 'arguments' => '', 'title' => t( 'Strikeout' ) ),
        'source' => array( 'icon' => 'source.gif', 'command' => 'source', 'arguments' => 'text', 'title' => t( 'View Source' ) ),
    );

    // color table
    $colors = array( "#000000","#000033","#000066","#000099","#0000CC","#0000FF","#330000","#330033","#330066","#330099","#3300CC",
                    "#3300FF","#660000","#660033","#660066","#660099","#6600CC","#6600FF","#990000","#990033","#990066","#990099",
                    "#9900CC","#9900FF","#CC0000","#CC0033","#CC0066","#CC0099","#CC00CC","#CC00FF","#FF0000","#FF0033","#FF0066",
                    "#FF0099","#FF00CC","#FF00FF","#003300","#003333","#003366","#003399","#0033CC","#0033FF","#333300","#333333",
                    "#333366","#333399","#3333CC","#3333FF","#663300","#663333","#663366","#663399","#6633CC","#6633FF","#993300",
                    "#993333","#993366","#993399","#9933CC","#9933FF","#CC3300","#CC3333","#CC3366","#CC3399","#CC33CC","#CC33FF",
                    "#FF3300","#FF3333","#FF3366","#FF3399","#FF33CC","#FF33FF","#006600","#006633","#006666","#006699","#0066CC",
                    "#0066FF","#336600","#336633","#336666","#336699","#3366CC","#3366FF","#666600","#666633","#666666","#666699",
                    "#6666CC","#6666FF","#996600","#996633","#996666","#996699","#9966CC","#9966FF","#CC6600","#CC6633","#CC6666",
                    "#CC6699","#CC66CC","#CC66FF","#FF6600","#FF6633","#FF6666","#FF6699","#FF66CC","#FF66FF","#009900","#009933",
                    "#009966","#009999","#0099CC","#0099FF","#339900","#339933","#339966","#339999","#3399CC","#3399FF","#669900",
                    "#669933","#669966","#669999","#6699CC","#6699FF","#999900","#999933","#999966","#999999","#9999CC","#9999FF",
                    "#CC9900","#CC9933","#CC9966","#CC9999","#CC99CC","#CC99FF","#FF9900","#FF9933","#FF9966","#FF9999","#FF99CC",
                    "#FF99FF","#00CC00","#00CC33","#00CC66","#00CC99","#00CCCC","#00CCFF","#33CC00","#33CC33","#33CC66","#33CC99",
                    "#33CCCC","#33CCFF","#66CC00","#66CC33","#66CC66","#66CC99","#66CCCC","#66CCFF","#99CC00","#99CC33","#99CC66",
                    "#99CC99","#99CCCC","#99CCFF","#CCCC00","#CCCC33","#CCCC66","#CCCC99","#CCCCCC","#CCCCFF","#FFCC00","#FFCC33",
                    "#FFCC66","#FFCC99","#FFCCCC","#FFCCFF","#00FF00","#00FF33","#00FF66","#00FF99","#00FFCC","#00FFFF","#33FF00",
                    "#33FF33","#33FF66","#33FF99","#33FFCC","#33FFFF","#66FF00","#66FF33","#66FF66","#66FF99","#66FFCC","#66FFFF",
                    "#99FF00","#99FF33","#99FF66","#99FF99","#99FFCC","#99FFFF","#CCFF00","#CCFF33","#CCFF66","#CCFF99","#CCFFCC",
                    "#CCFFFF","#FFFF00","#FFFF33","#FFFF66","#FFFF99","#FFFFCC","#FFFFFF"
    );

    // some smiley icons
    $smilies = array( 'cool' => t( 'Cool' ), 'cry' => t( 'Crying' ), 'embarassed' => t( 'Embarassed' ) );
    //$imgs = "/dsrte/images";
    $imgs = "images";
    // set default editor commands
    $cmds = $cmds != '' ? $cmds : 'bold italic underline strikeout | sub sup | left center right | ul ol | indent outdent | color bgcolor  | clean , font fontsize | link unlink attachment image emoticons html rule source';

    // start building HTML
    $html .= "<table cellspacing=\"0\" cellpadding=\"0\" class=\"rte\">";
    $html .= "<tr><td class=\"rte-cmd\" id=\"$id-cmd\">";
    $divs = array();
    foreach ( explode( ',', $cmds ) as $cmdline )
    {
        $html .= $br; $br = "<br />";
        foreach ( explode( ' ', $cmdline ) as $cmd )
        {
            $div = '';
            $cmd = trim( $cmd );
            switch ( $cmd )
            {
                // command buttons separator
                case '|':
                    $html .= "<img alt=\"sep\" class=\"sep\" src=\"$imgs/separator.gif\" />";
                    break;

                // ignore empty strings
                case '':
                    break;

                // all commands are processed here
                default:
                    // if command is a button (can be either button or select box)
                    if ( $commands[$cmd]['icon'] )
                    {
                        // build command html
                        $html .= "<a class=\"cmd\" id=\"cmd-$cmd\" title=\"".$commands[$cmd]['title']."\">";

                        // we use the attrs array to store attributes we can't put directly into
                        // html tags because of XHTML restrictions. These attributes will be
                        // placed using JavaScript after creating the tags.
                        $attrs = array( "'cmd':\"".$commands[$cmd]['command']."\"" );

                        // if this command is "complex", i.e. has arguments, deal with it here
                        if ( ($args = $commands[$cmd]['arguments']) !== '' )
                        {
                            switch ( $cmd )
                            {
                                case 'link':
                                    $div = "<div class=\"rte panel\" id=\"$id-$cmd\">";
                                    $div .= t( 'URL' ).": ";
                                    $div .= "<input size=\"40\" id=\"$args\" />";
                                    $div .= "<input type=\"button\" id=\"$args-ok\" value=\"".t( 'OK' )."\" />";
                                    $div .= "<input type=\"button\" value=\"".t( 'Cancel' )."\" onclick=\"\$('#$id-$cmd').slideUp()\" />";
                                    $div .= "</div>";
                                    break;

                                case 'image':
                                    add_js( "jquery/ajaxfileupload.min.js" );
                                    //$attrs[] = "'filespath':\"$uploadPath\",'path':\"/dsrte/uploadhandler.php\"";
                                    $attrs[] = "'filespath':\"$uploadPath\",'path':\"uploadhandler.php\", 'subdir':\"".time()."\"";
                                    $div = "<div class=\"rte panel\" id=\"$id-$cmd\">";
                                    $div .= t( 'Image' ).": ";
                                    $div .= "<input type=\"file\" size=\"25\" id=\"$args\" name=\"$args-file\" />";
                                    $div .= "<input type=\"button\" id=\"$args-ok\" value=\"".t( 'Upload' )."\" />";
                                    $div .= "<input type=\"button\" value=\"".t( 'Cancel' )."\" onclick=\"\$('#$id-$cmd').slideUp()\" />";
                                    $div .= "</div>";
                                    break;
                                    
                                case 'attachment':
                                    add_js( "jquery/ajaxfileupload.min.js" );
                                    //$attrs[] = "'filespath':\"$uploadPath\",'path':\"/dsrte/uploadhandler.php\"";
                                    $attrs[] = "'filespath':\"$uploadPath\",'path':\"uploadhandler2.php\", 'subdir':\"".time()."\"";
                                    $div = "<div class=\"rte panel\" id=\"$id-$cmd\">";
                                    $div .= t( 'Attachment' ).": ";
                                    $div .= "<input type=\"file\" size=\"25\" id=\"$args\" name=\"$args-file\" />";
                                    $div .= "<input type=\"button\" id=\"$args-ok\" value=\"".t( 'Upload' )."\" />";
                                    $div .= "<input type=\"button\" value=\"".t( 'Cancel' )."\" onclick=\"\$('#$id-$cmd').slideUp()\" />";
                                    $div .= "</div>";
                                    break;
                                    
                                case 'html':
                                case 'pastehtml':
                                case 'emoticons':
                                    if ( $args == 'emoticons' )
                                    {
                                        $div = "<div class=\"rte panel\" id=\"$id-$cmd\">";
                                        $icons = glob( "images/smiley-*.gif" );
                                        for ( $i = 0; $i < count( $icons ); $i++ )
                                        {
                                            preg_match( "/smiley-([a-z-]+)\.gif\$/", $icons[$i], $m );
                                            $div .= "<a class=\"emot\" title=\"".$smilies[$m[1]]."\"><img src=\"$icons[$i]\" alt=\"smiley$i\" /></a>";
                                        }
                                        $div .= "<input type=\"button\" value=\"".t( 'Cancel' )."\" onclick=\"\$('#$id-$cmd').slideUp()\" />";
                                        $div .= "</div>";
                                    }
                                    else
                                    {
                                        $div = "<div class=\"rte panel\" id=\"$id-$cmd\">";
                                        $div .= t( 'HTML' ).": ";
                                        $div .= "<input size=\"40\" id=\"$args\" />";
                                        $div .= "<input type=\"button\" id=\"$args-ok\" value=\"".t( 'OK' )."\" />";
                                        $div .= "<input type=\"button\" value=\"".t( 'Cancel' )."\" onclick=\"\$('#$id-$cmd').slideUp()\" />";
                                        $div .= "</div>";
                                    }
                                    break;

                                case 'color':
                                case 'bgcolor':
                                    if ( !$color_table_defined )
                                    {
                                        $div = "<div class=\"rte panel\" id=\"$id-$cmd\">";
                                        $div .= "<table border=\"1\" cellspacing=\"1\" cellpadding=\"0\" id=\"color-table\">";
                                        for ( $i = 0; $i < count( $colors ); $i++ )
                                        {
                                            if ( $i % 36 == 0 )
                                                $div .= "<tr>";
                                            $div .= "<td bgcolor=\"$colors[$i]\" style=\"width:6px;height:6px\"></td>";
                                            if ( ($i+1) % 36 == 0 )
                                                $div .= "</tr>";
                                        }
                                        $div .= "</table>";
                                        $div .= "<input readonly=\"readonly\" size=\"5\" id=\"color-value\" />";
                                        $div .= "<input type=\"button\" value=\"".t( 'Reset' )."\" onclick=\"\$('#$id')[0].resetcol()\" />";
                                        $div .= "<input type=\"button\" value=\"".t( 'Cancel' )."\" onclick=\"\$('#$id-$cmd').slideUp()\" />";
                                        $div .= "</div>";
                                        $div .= "<script type=\"text/javascript\">\$('#color-table').attr('handled','0')</script>";

                                        $color_table_defined = true;
                                    }
                                    break;

                                default:
                                    $div = '';
                                    break;
                            }
                            if ( $div )
                                $divs[] = $div;

                            $attrs[] = "'args':\"$args\"";
                        }

                        // add command button image
                        $html .= "<img alt=\"$cmd\" src=\"$imgs/".$commands[$cmd]['icon']."\" /></a>";

                        // add missing tag attributes using JavaScript
                        $html .= "<script type=\"text/javascript\">\$('#cmd-$cmd').attr({".implode( ',', $attrs )."})</script>";
                    }
                    else if ( $commands[$cmd]['select'] )
                    {
                        // build select box (used for font and size)
                        $html .= "<select id=\"cmd-$cmd\" size=\"1\"><option value=\"\">".$commands[$cmd]['title']."</option>";
                        foreach ( explode( ' ', $commands[$cmd]['select'] ) as $opt )
                            $html .= "<option value=\"$opt\">$opt</option>";
                        $html .= "</select>";

                        // add missing tag attributes using JavaScript
                        $html .= "<script type=\"text/javascript\">\$('#cmd-$cmd').attr('cmd',\"".$commands[$cmd]['command']."\")</script>";
                    }
                    break;
            }
        }
    }
    $html .= "</td></tr>";

    // add any hidden DIVs (color table, etc.) to the DOM
    if ( !empty( $divs ) )
        $html .= "<tr><td>".implode( '', $divs )."</td></tr>";

    // add IFRAME editor
    $html .= "<tr><td><iframe id=\"$id\" frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\" style=\"border:0\" width=\"100%\"></iframe></td></tr>";

    // make editor resizable, if requested
    if ( $resizable )
        $html .= "<tr><td style=\"border-top:1px solid #cccccc\"><div class=\"rte-resize\" id=\"$id-resize\"><img alt=\"\" src='$imgs/resize.gif' /></div></td></tr>";
    $html .= "</table>";

    // add hidden textarea tag with default editor text (or html)
    $html .= "<textarea rows=\"1\" cols=\"1\" id=\"$id-ta\" name=\"{$id}_text\" style=\"display:none\">$default_text</textarea>";

    return $html;
}

// Build Editor
$dsrte = build_editor( 'dsrte', "Hello World" );

// compress HTML
ob_start( 'sendcompressedcontent' );

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <title>RichTextEditor</title>
    <link rel="stylesheet" href="template/dsrte.css" type="text/css" />
    <script type="text/javascript" src="jquery/jquery-1.3.2.js"></script>
    <script type="text/javascript" src="jquery/dsrte.js"></script>
    <?=$scripts?>
    <script type="text/javascript"><!--
        // keyboard shortcut keys for current language
        var ctrlb='b',ctrli='i',ctrlu='u';
        //-->
    </script>
</head>
<body>
    <h1>RichTextEditor</h1>
    <h4>Text Editor:</h4>
<?
    if ( $_POST['dsrte_text'] )
    {
        $_POST['dsrte_text'] = str_replace('\\', '', $_POST['dsrte_text']);
        $_POST['dsrte_text'] = str_replace('"', "", $_POST['dsrte_text']);
        echo "<div style=\"border:1px dotted black\">";
        echo "Generated HTML:<pre>".htmlentities( $_POST['dsrte_text'])."</pre>";
        echo "Generated HTML:<pre>".$_POST['dsrte_text']."</pre>";
        echo "</div>";
    }
?>
    <!--<form method="post" action="/dsrte/dsrte.php"><div>-->
    <form method="post" action="dsrte.php"><div>
    <?=$dsrte?>
    <input type="submit" value="Submit" />
    </div></form>
</body>
</html>
