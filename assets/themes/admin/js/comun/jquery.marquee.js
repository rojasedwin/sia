/**
* author Remy Sharp
* url http://remysharp.com/tag/marquee
*/
function activarMarquesina(){

	(function ($) {
    $.fn.marquee = function (klass) {
        var newMarquee = [],
            last = this.length;

        // works out the left or right hand reset position, based on scroll
        // behavior, current direction and new direction
        function getReset(newDir, marqueeRedux, marqueeState) {
		
            var behavior = marqueeState.behavior, width = marqueeState.width, dir = marqueeState.dir;
            var r = 0;
            if (behavior == 'alternate') {
                r = newDir == 1 ? marqueeRedux[marqueeState.widthAxis] - (width*2) : width;
            } else if (behavior == 'slide') {
                if (newDir == -1) {
                    r = dir == -1 ? marqueeRedux[marqueeState.widthAxis] : width;
                } else {
                    r = dir == -1 ? marqueeRedux[marqueeState.widthAxis] - (width*2) : 0;
                }
            } else {
                r = newDir == -1 ? marqueeRedux[marqueeState.widthAxis] : 0;
            }
			
			
            return r;
        }

        // single "thread" animation
        function animateMarquee() {
           document.getElementById('cajaMarquesina').style.display='block';
		   var i = newMarquee.length,
                marqueeRedux = null,
                $marqueeRedux = null,
                marqueeState = {},
                newMarqueeList = [],
                hitedge = false;
                
				loops=$(newMarquee[0]).data('marqueeState').loops;
				
            while (i--) {
                marqueeRedux = newMarquee[i];
                $marqueeRedux = $(marqueeRedux);
               marqueeState = $marqueeRedux.data('marqueeState');
				
				marqueeRedux[marqueeState.axis]=ponerPosicion(marqueeRedux[marqueeState.axis]);
				
				
				if ($marqueeRedux.data('paused') !== true) {
                    // TODO read scrollamount, dir, behavior, loops and last from data
       				marqueeRedux[marqueeState.axis] += (marqueeState.scrollamount * marqueeState.dir);

                    // only true if it's hit the end
                    hitedge = marqueeState.dir == -1 ? marqueeRedux[marqueeState.axis] <= getReset(marqueeState.dir * -1, marqueeRedux, marqueeState) : marqueeRedux[marqueeState.axis] >= getReset(marqueeState.dir * -1, marqueeRedux, marqueeState);
                    
                    if ((marqueeState.behavior == 'scroll' && marqueeState.last == marqueeRedux[marqueeState.axis]) || (marqueeState.behavior == 'alternate' && hitedge && marqueeState.last != -1) || (marqueeState.behavior == 'slide' && hitedge && marqueeState.last != -1)) {                        
                        if (marqueeState.behavior == 'alternate') {
                            marqueeState.dir *= -1; // flip
                        }
                        marqueeState.last = -1;

                        $marqueeRedux.trigger('stop');

                        marqueeState.loops--;
                        if (marqueeState.loops === 0) {
							/*	
							if (marqueeState.behavior != 'slide') {
                                marqueeRedux[marqueeState.axis] = getReset(marqueeState.dir, marqueeRedux, marqueeState);
                            } else {
                                // corrects the position
                                marqueeRedux[marqueeState.axis] = getReset(marqueeState.dir * -1, marqueeRedux, marqueeState);
                            }
							$marqueeRedux.trigger('end');
                        	*/
						
					
							marqueeState.loops=loops;
							
							// keep this marquee going
                            newMarqueeList.push(marqueeRedux);
                            
							$marqueeRedux.trigger('start');
                            marqueeRedux[marqueeState.axis] = getReset(marqueeState.dir, marqueeRedux, marqueeState);
                     		arrancarMensaje();
							setTimeout(animateMarquee, periodo);

							Cargar('marquesinaPeriodo', 'ajax.php?ma=periodo', 'admin', post);
							
							document.getElementById('cajaMarquesina').style.display='none';
							return null;
						
						} else {
                            // keep this marquee going
                            newMarqueeList.push(marqueeRedux);
                            $marqueeRedux.trigger('start');
                            marqueeRedux[marqueeState.axis] = getReset(marqueeState.dir, marqueeRedux, marqueeState);
                        }
                    } else {
                        newMarqueeList.push(marqueeRedux);
                    }
                    marqueeState.last = marqueeRedux[marqueeState.axis];

                    // store updated state only if we ran an animation
                    $marqueeRedux.data('marqueeState', marqueeState);
                } else {
                    // even though it's paused, keep it in the list
                    newMarqueeList.push(marqueeRedux);                    
                }
            }
			
			
            newMarquee = newMarqueeList;
           
            if (newMarquee.length) {
                setTimeout(animateMarquee, 25);
            } 
        }
        
        // TODO consider whether using .html() in the wrapping process could lead to loosing predefined events...
        this.each(function (i) {
			var loopAtribute=document.getElementById('mar2').getAttribute('loop');
								//alert($marquee.html());
            var $marquee = $(this),
                width = $marquee.attr('width') || $marquee.width(),
                height = $marquee.attr('height') || $marquee.height(),
				
				
				
				
               $marqueeRedux = $marquee.after('<div ' + (klass ? 'class="' + klass + '" ' : '') + 'style="  display: block-inline;  width: ' + width + '%;  /*height: ' + height + 'px;*/ overflow: hidden;     "><div style="  float: left; white-space: nowrap; ">' + $marquee.html() + '</div></div>').next(),
                 //$marqueeRedux = $marquee.after(texto).next();
				marqueeRedux = $marqueeRedux.get(0),
                hitedge = 0,
                direction = ($marquee.attr('direction') || 'left').toLowerCase(),
                marqueeState = {
                    dir : /down|right/.test(direction) ? -1 : 1,
                    axis : /left|right/.test(direction) ? 'scrollLeft' : 'scrollTop',
                    widthAxis : /left|right/.test(direction) ? 'scrollWidth' : 'scrollHeight',
                    last : -1,
                    loops : /*$marquee.attr('loop')*/loopAtribute || -1,
                    scrollamount : $marquee.attr('scrollamount') || this.scrollAmount || 2,
                    behavior : ($marquee.attr('behavior') || 'scroll').toLowerCase(),
                    width : /left|right/.test(direction) ? width : height
                };
            // corrects a bug in Firefox - the default loops for slide is -1
            if ($marquee.attr('loop') == -1 && marqueeState.behavior == 'slide') {
                marqueeState.loops = 1;
            }

            $marquee.remove();
            
            // add padding
            if (/left|right/.test(direction)) {
				$marqueeRedux.find('> div').css('padding', '0 ' + width + '%');
            } else {
                $marqueeRedux.find('> div').css('padding', height + 'px 0');
            }
            
            // events
            $marqueeRedux.bind('stop', function () {
                $marqueeRedux.data('paused', true);
            }).bind('pause', function () {
                $marqueeRedux.data('paused', true);
            }).bind('start', function () {
                $marqueeRedux.data('paused', false);
            }).bind('unpause', function () {
                $marqueeRedux.data('paused', false);
            }).data('marqueeState', marqueeState); // finally: store the state
            
            // todo - rerender event allowing us to do an ajax hit and redraw the marquee

            newMarquee.push(marqueeRedux);

            marqueeRedux[marqueeState.axis] = getReset(marqueeState.dir, marqueeRedux, marqueeState);
            $marqueeRedux.trigger('start');
            
            // on the very last marquee, trigger the animation
            if (i+1 == last) {
                animateMarquee();
            }
        });            

        return $(newMarquee);
    };
}(jQuery));


$(function () {
	$('#cajaMarquesina marquee').marquee('pointer').mouseover(function () {
		$(this).trigger('stop');
	}).mouseout(function () {
		$(this).trigger('start');
	}).mousemove(function (event) {
		if ($(this).data('drag') == true) {
			this.scrollLeft = $(this).data('scrollX') + ($(this).data('x') - event.clientX);
		}
	}).mousedown(function (event) {
		$(this).data('drag', true).data('x', event.clientX).data('scrollX', this.scrollLeft);
	}).mouseup(function () {
		$(this).data('drag', false);
	});
});





}





function arrancarMensaje(){
	obtenerIndiceMensaje();
	meterMensaje();
}

function obtenerIndiceMensaje(){
	numero=indice;
	if(extAnuncios>0)	while(numero==indice)	numero=aleatorio(0,extAnuncios);
	else numero=0;
	indice=numero;	
}

function aleatorio(a,b) {
	return Math.round(Math.random()*(b-a)+a);
}

function meterMensaje(){
	document.getElementById('indiceMarquesina').value=indice;
	document.getElementById('marquesinaTexto').innerHTML=mensajes[indice];	
}

function ponerPosicion(pos){
	
	if(posicion ){
		pos=parseInt(posicion)+4;
		posicion=null;
	}
	document.getElementById('posicionMarquesina').value=pos;
	
	return pos;
}
