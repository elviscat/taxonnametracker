/**
 * Damn Small Rich Text Editor v0.1.4 for jQuery
 * by Roi Avidan <roi@avidansoft.com>
 * Demo: http://www.avidansoft.com/dsrte/dsrte.php
 * Released under the GPL License
 */
$(function() {
    if ( $.browser.msie )
        $(document).bind( "mousemove", _rtersz );
    else
        $(window).bind( "mousemove", _rtersz );
    $(document).bind( "mouseup", _rtersz );

    $('table.rte iframe').each(function() {
        var i = this;
        i.modified = 0;
        i.resetcol = function() {
            $('#color-value').val( $(i).attr( 'colorcmd' ) == 'forecolor' ? '#000000' : '#ffffff' );
            i.setcol();
        };
        i.setcol = function() {
            if( i.rng )
                i.rng.select();
            else if ( !$.browser.msie )
                d.execCommand( 'useCSS', false, false);
            f.focus();
            d.execCommand( $(i).attr( 'colorcmd' ), false, $('#color-value').val() );
            if ( !$.browser.msie )
                d.execCommand( 'useCSS', false, true );
            f.focus();
            i.hidepanels();
        };
        i.clean = function(){
            var s = d.body.innerHTML.replace( new RegExp( '<p \\/>', 'gi' ), '<p>&nbsp;</p>' );
            s = s.replace( new RegExp( '<p>\\s*<\\/p>', 'gi' ), '<p>&nbsp;</p>' );
            s = s.replace( new RegExp( '<br>\\s*<\\/br>', 'gi' ), '<br />' );
            s = s.replace( new RegExp( '<(h[1-6]|p|div|address|pre|form|table|li|ol|ul|td|b|font|em|strong|i|strike|u|span|a|ul|ol|li|blockquote)([a-z]*)([^\\\\|>]*)\\/>', 'gi' ), '<$1$2$3></$1$2>' );
            s = s.replace( new RegExp( '\\s+></','gi' ), '></' );
            s = s.replace( new RegExp( '<(img|br|hr)([^>]*)><\\/(img|br|hr)>', 'gi' ), '<$1$2 />' );
            if ( $.browser.msie ) {
                s = s.replace( new RegExp( '<p><hr \\/><\\/p>', 'gi' ), "<hr>" );
                s = s.replace( /<!(\s*)\/>/g, '');
            };
            d.body.innerHTML = s;
        };
        i.getDoc = function(){
            return d.body.innerHTML;
        };
        i.setDoc = function( x ) {
            d.body.innerHTML=x;
        };
        i.kb = function( e ){
            if ( e.ctrlKey ){
                var k = String.fromCharCode( e.charCode ).toLowerCase();
                var c = '';
                if ( k==ctrlb )
                    c = 'bold';
                else if ( k == ctrli )
                    c = 'italic';
                else if ( k == ctrlu )
                    c = 'underline';
                if ( c ) {
                    f.focus();
                    d.execCommand( c, false, null );
                    f.focus();
                    e.preventDefault();
                    e.stopPropagation();
                }
            }
        };
        i.hidepanels = function() {
            $($(i).parents('table')[0]).find( '.panel' ).hide();
        };
        $('#'+i.id+'-resize').mousedown(function( e ){
            e = typeof( e ) == "undefined" ? window.event : e;
            resizer.i = i;
            resizer.x = e.screenX;
            resizer.y = e.screenY;
            resizer.w = parseInt( i.clientWidth );
            resizer.h = parseInt( i.clientHeight );
            return false;
        });
        var f = $.browser.msie ? frames[i.id] : i.contentWindow;
        var d = $.browser.msie ? f.document : i.contentDocument;
        d.designMode = 'on';
        try {
            d.execCommand( 'useCSS', false, true );
        } catch ( e ) {};
        d.open();
        d.write( $('#'+i.id+'-ta').text() );
        d.close();
        if ( !$.browser.msie )
            d.addEventListener( 'keypress', i.kb, true );
        else
            d.onmouseup = function(){
                if ( d.selection != null )
                    i.rng = d.selection.createRange();
            };
        $(d).keypress(function() {
            i.modified = 1;
        });
        $('html',d).attr( 'dir', 'ltr' );
        $('head',d).append('<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><link rel="stylesheet" href="styles.css" style="text/css" />');
        $('body',d).css( 'backgroundColor', 'white' );
        $("#"+i.id+"-cmd .cmd").each(function(){
            var t = $(this);
            var a = t.attr( 'args' );
            var s = $('#'+i.id+'-'+a);
            if ( $.browser.msie )
                $('img',t).mouseover(function() {
                    this.className = 'hvr';
                }).mouseout(function() {
                    this.className='';
                });
            if ( typeof( a ) == 'string' ) {
                if ( a == 'color' ) {
                    if ( $('#color-table').attr('handled') != '1' ) {
                        $('#color-table').attr( 'handled', '1' ).find('td').mouseover(function(){
                            $('#color-value').val( $(this).attr('bgcolor') );
                        }).click(function() {
                            i.setcol();
                        });
                    }
                }
                else if ( a == 'emoticons' )
                    $(i).parents('table').find('.emot').each(function() {
                        $(this).click(function(){
                            f.focus();
                            d.execCommand( 'insertimage', false, $(this).children()[0].src );
                            f.focus();
                            s.slideUp();
                            return false
                        });
                        if ( $.browser.msie )
                            $('img', $(this)).mouseover(function() {
                                this.className='hvr';
                            }).mouseout(function(){
                                this.className='';
                            });
                    });
                    $('#'+a+'-ok').click(function() {
                        /*
                        f.focus();
                        if( a == 'attachment'){
                          //alert("This is attachment!");
                          //alert(t.attr('cmd'));
                          if ( t.attr('cmd') == 'insertattachment' ) {
                          	  //alert('You are right!');
                              $.ajaxFileUpload({
                                  url: t.attr('path'),
                                  secureuri: false,
                                  fileElementId: a,
                                  dataType: 'json',
                                  success: function(data,s) {
                                      if ( data.error )
                                          alert( data.error );
                                      else
                                          //alert(data.file);
                                          alert('Success');
                                          d.execCommand( t.attr('cmd'), false, t.attr('filespath')+'/'+encodeURIComponent(data.file));
                                  },
                                  error: function(data,s,e) {
                                      alert( e + ': ' + data.responseText );
                                  }
                              });
                              //alert('You are right2!');
                          }
                        }
                        else {
                            if ( $.browser.msie )
                                i.rng.select();
                            if ( a == 'html' )
                                i.rng.pasteHTML( $('#'+a).val() );
                            else
                                d.execCommand( t.attr('cmd'), false, $('#'+a).val() );
                        };
                        */
                        f.focus();
                        if ( $('#'+a).val() == '' || !d.queryCommandEnabled( t.attr('cmd') ) ) {
                            $('#'+a).val('');
                            s.slideUp();
                            return;
                        };

                        if ( t.attr('cmd') == 'insertimage' ) {
                            $.ajaxFileUpload({
                                url: t.attr('path')+'?subdir='+t.attr('subdir'),
                                secureuri: false,
                                fileElementId: a,
                                dataType: 'json',
                                success: function(data,s) {
                                    if ( data.error )
                                        alert( data.error );
                                    else{
                                    	//alert(t.attr('subdir'));
                                      //alert('Elvis is ' + t.attr( 'args'));
                                        //d.execCommand( t.attr('cmd'), false, t.attr('filespath')+'/'+encodeURIComponent(data.file));
                                        if(t.attr( 'args') == 'image'){
                                            d.execCommand( t.attr('cmd'), false, t.attr('filespath')+'/'+t.attr('subdir')+'/'+encodeURIComponent(data.file));
                                        }else if(t.attr( 'args') == 'attachment'){
                                        	d.execCommand( 'createlink', false, t.attr('filespath')+'/'+t.attr('subdir')+'/'+encodeURIComponent(data.file));
                                        }
                                        
                                    }
                                },
                                error: function(data,s,e) {
                                    alert( e + ': ' + data.responseText );
                                }
                            });
                        }
                        
                        else {
                            if ( $.browser.msie )
                                i.rng.select();
                            if ( a == 'html' )
                                i.rng.pasteHTML( $('#'+a).val() );
                            else
                                d.execCommand( t.attr('cmd'), false, $('#'+a).val());
                        };
                        

                        
                        
                        f.focus();
                        $('#'+a).val('');
                        s.slideUp();
                    });
            };
            t.click(function() {
                i.hidepanels();
                if ( typeof(a) == 'string' ) {
                    s.slideToggle();
                    if ( a == 'color' )
                        $(i).attr( 'colorcmd', t.attr('cmd') );
                    else if ( a == 'clean' )
                        i.clean();
                    else if ( t.attr( 'args') == 'text' ) {
                        t.attr( 'args', 'wysiwyg' );
                        if ( $.browser.msie ) {
                            d.body.innerText = d.body.innerHTML;
                        } else {
                            var src = d.createTextNode( d.body.innerHTML );
                            d.body.innerHTML = "";
                            d.body.appendChild(src);
                        }
                    } else if ( t.attr( 'args') == 'wysiwyg' ) {
                        t.attr( 'args', 'text' );
                        if ( $.browser.msie ) {
                            var o = escape( d.body.innerText );
                            o = o.replace( "%3CP%3E%0D%0A%3CHR%3E", "%3CHR%3E" );
                            o = o.replace( "%3CHR%3E%0D%0A%3C/P%3E", "%3CHR%3E" );
                            d.body.innerHTML = unescape( o );
                        } else {
                            var src = d.body.ownerDocument.createRange();
                            src.selectNodeContents( d.body );
                            d.body.innerHTML = src.toString();
                        }
                    }
                }
                else {
                    d.execCommand( t.attr('cmd'), false, '');
                    f.focus();
                }
                i.modified = 1;
                return false;
            })
        });
        $("#"+i.id+"-cmd select").each(function() {
            var s = $(this);
            s.change(function() {
                if ( this.selectedIndex > 0 ) {
                    d.execCommand( s.attr('cmd'), false, this.value );
                    i.modified = 1;
                }
                this.selectedIndex = 0;
                f.focus();
            });
        });
        $(i).parents('form:first').submit(function() {
            $('#'+i.id+'-ta').text( d.body.innerHTML );
        });
    });
});
resizer = {i:null};
function _rtersz( e ) {
    if ( resizer.i == null )
        return;
    e = typeof( e ) == "undefined" ? window.event : e;
    switch ( e.type ) {
        case "mousemove":
            var w = resizer.w + e.screenX - resizer.x;
            var h = resizer.h + e.screenY - resizer.y;
            w = w < 1 ? 1 : w;
            h = h < 1 ? 1 : h;
            resizer.i.style.width = w+"px";
            resizer.i.style.height = h+"px";
            break;
        case "mouseup":
            resizer.i = null;
            break;
    }
};
