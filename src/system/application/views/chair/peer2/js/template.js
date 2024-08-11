/*
	reflection.js for mootools v1.2
	by Christophe Beyls (http://www.digitalia.be) - MIT-style license
*/

var Reflection = {

	add: function(img, options){
		img = $(img);
		if (img.getTag() != 'img') return;
		options = {arguments: [img, options]};
		if (window.ie) options.delay = 50;
		img.preload = new Image();
		img.preload.onload = Reflection.reflect.create(options);
		img.preload.src = img.src;
	},

	remove: function(img){
		img = $(img);
		if (img.preload) img.preload.onload = null;
		if ((img.getTag() == 'img') && (img.className == 'reflected')){
			img.className = img.parentNode.className;
			img.style.cssText = img.backupStyle;
			img.parentNode.replaceWith(img);
		}
	},

	reflect: function(img, options){
		options = $extend({
			height: 0.33,
			opacity: 0.5
		}, options || {});

		Reflection.remove(img);
		var canvas, canvasHeight = Math.floor(img.height*options.height);

		if (window.ie){
			canvas = new Element('img', {'src': img.src, 'styles': {
				'width': img.width,
				'marginBottom': -img.height+canvasHeight,
				'filter': 'flipv progid:DXImageTransform.Microsoft.Alpha(opacity='+(options.opacity*100)+', style=1, finishOpacity=0, startx=0, starty=0, finishx=0, finishy='+(options.height*100)+')'
			}});
		} else {
			canvas = new Element('canvas', {'styles': {'width': img.width, 'height': canvasHeight}});
			if (!canvas.getContext) return;
		}

		var div = new Element('div').injectAfter(img).adopt(img, canvas);
		div.className = img.className;
		div.style.cssText = img.backupStyle = img.style.cssText;
		div.removeClass('reflect').setStyles({'width': img.width, 'height': canvasHeight+img.height});
		img.style.cssText = 'vertical-align: bottom';
		img.className = 'reflected';
		if (window.ie) return;

		var context = canvas.setProperties({'width': img.width, 'height': canvasHeight}).getContext('2d');
		context.save();
		context.translate(0, img.height-1);
		context.scale(1, -1);
		context.drawImage(img, 0, 0, img.width, img.height);
		context.restore();
		context.globalCompositeOperation = 'destination-out';
		var gradient = context.createLinearGradient(0, 0, 0, canvasHeight);
		gradient.addColorStop(0, 'rgba(255, 255, 255, '+(1-options.opacity)+')');
		gradient.addColorStop(1, 'rgba(255, 255, 255, 1.0)');
		context.fillStyle = gradient;
		context.rect(0, 0, img.width, canvasHeight);
		context.fill();
	},

	addFromClass: function(){
		$each(document.getElementsByTagName('img'), function(img){
			if ($(img).hasClass('reflect')) Reflection.add(img);
		});
	}
};

Element.extend({
	addReflection: function(options) { Reflection.add(this, options); return this; },
	removeReflection: function(options) { Reflection.remove(this, options); return this; }
});

Window.addEvent("domready", Reflection.addFromClass);
/*
	Slimbox v1.4 - The ultimate lightweight Lightbox clone
	by Christophe Beyls (http://www.digitalia.be) - MIT-style license.
	Inspired by the original Lightbox v2 by Lokesh Dhakar.
*/

var Lightbox = {

	init: function(options){
		this.options = $extend({
			resizeDuration: 400,
			resizeTransition: false,	// default transition
			initialWidth: 250,
			initialHeight: 250,
			animateCaption: true,
			showCounter: true
		}, options || {});

		this.anchors = [];
		$each(document.links, function(el){
			if (el.rel && el.rel.test(/^lightbox/i)){
				el.onclick = this.click.pass(el, this);
				this.anchors.push(el);
			}
		}, this);
		this.eventKeyDown = this.keyboardListener.bindAsEventListener(this);
		this.eventPosition = this.position.bind(this);

		this.overlay = new Element('div', {'id': 'lbOverlay'}).injectInside(document.body);

		this.center = new Element('div', {'id': 'lbCenter', 'styles': {'width': this.options.initialWidth, 'height': this.options.initialHeight, 'marginLeft': -(this.options.initialWidth/2), 'display': 'none'}}).injectInside(document.body);
		this.image = new Element('div', {'id': 'lbImage'}).injectInside(this.center);
		this.prevLink = new Element('a', {'id': 'lbPrevLink', 'href': '#', 'styles': {'display': 'none'}}).injectInside(this.image);
		this.nextLink = this.prevLink.clone().setProperty('id', 'lbNextLink').injectInside(this.image);
		this.prevLink.onclick = this.previous.bind(this);
		this.nextLink.onclick = this.next.bind(this);

		this.bottomContainer = new Element('div', {'id': 'lbBottomContainer', 'styles': {'display': 'none'}}).injectInside(document.body);
		this.bottom = new Element('div', {'id': 'lbBottom'}).injectInside(this.bottomContainer);
		new Element('a', {'id': 'lbCloseLink', 'href': '#'}).injectInside(this.bottom).onclick = this.overlay.onclick = this.close.bind(this);
		this.caption = new Element('div', {'id': 'lbCaption'}).injectInside(this.bottom);
		this.number = new Element('div', {'id': 'lbNumber'}).injectInside(this.bottom);
		new Element('div', {'styles': {'clear': 'both'}}).injectInside(this.bottom);

		var nextEffect = this.nextEffect.bind(this);
		this.fx = {
			overlay: this.overlay.effect('opacity', {duration: 500}).hide(),
			resize: this.center.effects($extend({duration: this.options.resizeDuration, onComplete: nextEffect}, this.options.resizeTransition ? {transition: this.options.resizeTransition} : {})),
			image: this.image.effect('opacity', {duration: 500, onComplete: nextEffect}),
			bottom: this.bottom.effect('margin-top', {duration: 400, onComplete: nextEffect})
		};

		this.preloadPrev = new Image();
		this.preloadNext = new Image();
	},

	click: function(link){
		if (link.rel.length == 8) return this.show(link.href, link.title);

		var j, imageNum, images = [];
		this.anchors.each(function(el){
			if (el.rel == link.rel){
				for (j = 0; j < images.length; j++) if(images[j][0] == el.href) break;
				if (j == images.length){
					images.push([el.href, el.title]);
					if (el.href == link.href) imageNum = j;
				}
			}
		}, this);
		return this.open(images, imageNum);
	},

	show: function(url, title){
		return this.open([[url, title]], 0);
	},

	open: function(images, imageNum){
		this.images = images;
		this.position();
		this.setup(true);
		this.top = window.getScrollTop() + (window.getHeight() / 15);
		this.center.setStyles({top: this.top, display: ''});
		this.fx.overlay.start(0.8);
		return this.changeImage(imageNum);
	},

	position: function(){
		this.overlay.setStyles({'top': window.getScrollTop(), 'height': window.getHeight()});
	},

	setup: function(open){
		var elements = $A(document.getElementsByTagName('object'));
		elements.extend(document.getElementsByTagName(window.ie ? 'select' : 'embed'));
		elements.each(function(el){
			if (open) el.lbBackupStyle = el.style.visibility;
			el.style.visibility = open ? 'hidden' : el.lbBackupStyle;
		});
		var fn = open ? 'addEvent' : 'removeEvent';
		window[fn]('scroll', this.eventPosition)[fn]('resize', this.eventPosition);
		document[fn]('keydown', this.eventKeyDown);
		this.step = 0;
	},

	keyboardListener: function(event){
		switch (event.keyCode){
			case 27: case 88: case 67: this.close(); break;
			case 37: case 80: this.previous(); break;	
			case 39: case 78: this.next();
		}
	},

	previous: function(){
		return this.changeImage(this.activeImage-1);
	},

	next: function(){
		return this.changeImage(this.activeImage+1);
	},

	changeImage: function(imageNum){
		if (this.step || (imageNum < 0) || (imageNum >= this.images.length)) return false;
		this.step = 1;
		this.activeImage = imageNum;

		this.center.style.backgroundColor = '';
		this.bottomContainer.style.display = this.prevLink.style.display = this.nextLink.style.display = 'none';
		this.fx.image.hide();
		this.center.className = 'lbLoading';

		this.preload = new Image();
		this.preload.onload = this.nextEffect.bind(this);
		this.preload.src = this.images[imageNum][0];
		return false;
	},

	nextEffect: function(){
		switch (this.step++){
		case 1:
			this.center.className = '';
			this.image.style.backgroundImage = 'url('+this.images[this.activeImage][0]+')';
			this.image.style.width = this.bottom.style.width = this.preload.width+'px';
			this.image.style.height = this.prevLink.style.height = this.nextLink.style.height = this.preload.height+'px';

			this.caption.setHTML(this.images[this.activeImage][1] || '');
			this.number.setHTML((!this.options.showCounter || (this.images.length == 1)) ? '' : 'Image '+(this.activeImage+1)+' of '+this.images.length);

			if (this.activeImage) this.preloadPrev.src = this.images[this.activeImage-1][0];
			if (this.activeImage != (this.images.length - 1)) this.preloadNext.src = this.images[this.activeImage+1][0];
			if (this.center.clientHeight != this.image.offsetHeight){
				this.fx.resize.start({height: this.image.offsetHeight});
				break;
			}
			this.step++;
		case 2:
			if (this.center.clientWidth != this.image.offsetWidth){
				this.fx.resize.start({width: this.image.offsetWidth, marginLeft: -this.image.offsetWidth/2});
				break;
			}
			this.step++;
		case 3:
			this.bottomContainer.setStyles({top: this.top + this.center.clientHeight, height: 0, marginLeft: this.center.style.marginLeft, display: ''});
			this.fx.image.start(1);
			break;
		case 4:
			this.center.style.backgroundColor = '#000';
			if (this.options.animateCaption){
				this.fx.bottom.set(-this.bottom.offsetHeight);
				this.bottomContainer.style.height = '';
				this.fx.bottom.start(0);
				break;
			}
			this.bottomContainer.style.height = '';
		case 5:
			if (this.activeImage) this.prevLink.style.display = '';
			if (this.activeImage != (this.images.length - 1)) this.nextLink.style.display = '';
			this.step = 0;
		}
	},

	close: function(){
		if (this.step < 0) return;
		this.step = -1;
		if (this.preload){
			this.preload.onload = Class.empty;
			this.preload = null;
		}
		for (var f in this.fx) this.fx[f].stop();
		this.center.style.display = this.bottomContainer.style.display = 'none';
		this.fx.overlay.chain(this.setup.pass(false, this)).start(0);
		return false;
	}
};

/* call moved to YtTools.start */
// window.addEvent('domready', Lightbox.init.bind(Lightbox));
/**
 * YOOtheme Javascript file, base.js
 *
 * @author yootheme.com
 * @copyright Copyright (C) 2007 YOOtheme Ltd. & Co. KG. All rights reserved.
 */

eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('3 J={F:5(E,e,m){3 6=0;3 d=[];3 g=E.G(" ");3 z=g.H();3 f=\'\';g.b(5(A,i){f+=\'.I("\'+A+\'")\'});$o(z).b(5(C,i){N(\'d.M(C\'+f+\');\')});d.b(5(1,i){3 9,c;7(1.B){9=1.B;c=0;c+=1.x(\'D-L\').y();c+=1.x(\'D-K\').y();9-=c;7(e!=r){9-=e}}v 7(1.p.t){9=1.p.t}6=q.s(6,9)});7(m!=r){6=q.s(6,m)}d.b(5(1,i){7(12.17){1.u(\'w\',6+\'n\')}v{1.u(\'O-w\',6+\'n\')}})},18:5(){$o(\'4.15\').b(5(4,i){3 8=14 13(\'a\');3 k=4.h(\'k\').16(/^(\\S+)\\.(11|10|T|R)$/,"$Q.$2");8.l(\'P\',k);8.l(\'U\',4.V);7(4.h(\'j\')){8.l(\'j\',Z(4.h(\'j\')))}4.Y().X(8);4.W(8)})}};',62,71,'|div||var|img|function|maxHeight|if|lightboxLink|divHeight||each|divPadding|matchDivs|divBorder|script|selectors|getProperty||title|src|setProperty|minWidth|px|ES|style|Math|undefined|max|pixelHeight|setStyle|else|height|getStyle|toInt|elements|el|offsetHeight|element|padding|selector|matchDivHeight|split|shift|getElement|YtBase|bottom|top|push|eval|min|href|1_lightbox|png||jpeg|rel|className|replaceWith|injectInside|clone|String|jpg|gif|window|Element|new|lightbox|replace|ie6|setupLightbox'.split('|'),0,{}))
/**
 * YOOtheme Javascript file, morph.js
 *
 * @author yootheme.com
 * @copyright Copyright (C) 2007 YOOtheme Ltd. & Co. KG. All rights reserved.
 */

eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('f j=b q({r:2(k,5,6,3,7){0.9({p:s,t:g.u.o,m:n,8:\'\'},3);0.5=5;0.6=6;0.3=3;0.7=7;$$(k).B(2(1,i){0.d(1,i)}.c(0))},d:2(1,i){f a=b g.C(1,0.4);D(!($A(0.4.8)&&1.z(0.4.8))){1.l(\'v\',2(e){a.9(0.4,0.3).h(0.5)}.c(0));1.l(\'x\',2(e){a.9(0.4,0.7).h(0.6)}.c(0))}}});j.y(b w);',40,40,'this|el|function|enterFx|options|enter|leave|leaveFx|ignoreClass|setOptions|liFxs|new|bind|createOver||var|Fx|start||YtMorph|menu|addEvent|wait|false|expoOut|duration|Class|initialize|500|transition|Transitions|mouseenter|Options|mouseleave|implement|hasClass|chk|each|Styles|if'.split('|'),0,{}))
/**
 * YOOtheme Javascript file, accordionmenu.js
 *
 * @author yootheme.com
 * @copyright Copyright (C) 2007 YOOtheme Ltd. & Co. KG. All rights reserved.
 */

eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('4 t=7 u({v:3(q,p,2){0.w({o:\'m\'},2);0.6=q;0.8=p;x(0.2.o){z\'C\':0.j();y;m:0.e()}},e:3(){4 2={};c(!$B(0.2.9)){2={h:-1}}$k(0.6).l(3(5,i){c(5.n(\'r\'))2={h:i}}.s(0));4 A=7 d.Q(0.6,0.8,$N(0.2,2))},j:3(){$k(0.6).l(3(5,i){4 a=5.g(\'a\');4 f=5.g(0.8);4 b=7 d.M(f,{D:d.P.R,L:K});c(!(5.n(\'r\')||0.2.9==\'F\'||0.2.9==i)){b.E()}a.G(\'H\',3(){b.J()})}.s(0))}});t.I(7 O);',54,54,'this||options|function|var|tog|togs|new|elms|display|span|fx|if|Fx|createDefault|ul|getElement|show||createSlide|ES|each|default|hasClass|accordion|elements|togglers|active|bind|YtAccordionMenu|Class|initialize|setOptions|switch|break|case|accordionMenu|defined|slide|transition|hide|all|addEvent|click|implement|toggle|250|duration|Slide|extend|Options|Transitions|Accordion|linear'.split('|'),0,{}))
/**
 * YOOtheme Javascript file, slidepanel.js
 *
 * @author yootheme.com
 * @copyright Copyright (C) 2007 YOOtheme Ltd. & Co. KG. All rights reserved.
 */

eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('J=r.L.Q({j:4(){6{w:H,z:r.v.B}},A:4(5,7,a,8){3.y(3.j(),8);3.5=$(5);3.7=$(7);3.9=\'g\';3.t=\'a\';3.c=a;3.b=[];3.D(3.8)},x:4(m){k d=$E(m);p(3.5&&d)d.C(\'S\',4(){3.s()}.O(3))},N:4(){P(k i=0;i<2;i++)3.b[i]=3.R(3.M[i],3.F[i])},e:4(){6[3.5.h(\'9-g\').o(),3.7.h(\'a\').o()]},q:4(){6 3.n(3.e(),[0,3.c])},u:4(){6 3.n(3.e(),[-3.c,0])},s:4(){p(3.7.G==0)6 3.q();I 6 3.u()},K:4(){3.5.l(\'9-\'+3.9,3.b[0]+3.8.f);3.7.l(3.t,3.b[1]+3.8.f)}});',55,55,'|||this|function|element|return|wrapper|options|margin|height|now|offset|trigger|vertical|unit|top|getStyle||getOptions|var|setStyle|tr|start|toInt|if|slideIn|Fx|toggle|layout|slideOut|Transitions|duration|addTriggerEvent|setOptions|transition|initialize|linear|addEvent|parent||to|offsetHeight|500|else|YtSlidePanel|increase|Base|from|setNow|bind|for|extend|compute|click'.split('|'),0,{}))
/**
 * YOOtheme Javascript file, styleswitcher.js
 *
 * @author yootheme.com
 * @copyright Copyright (C) 2007 YOOtheme Ltd. & Co. KG. All rights reserved.
 */

eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('3 z=l I({J:2(){h{D:\'4-M\',H:10,K:14,A:0.9,15:1c.16.1e,18:17,d:I.19}},1a:2(c,5){1.1b(1.J(),5);1.o=\'a-Y\',1.v=\'a-X\',1.w=\'a-W\',1.B=\'4-Z\';1.P=\'4-M\';1.k=\'4-13\';1.c=$$(c);1.m=l 12(11.1d);1.8(\'d\',1.5.d);1.F=\'\';3 u=$E(\'#1f\');3 q=$E(\'#1x\');3 t=$E(\'#1t\');3 r=$E(\'#1s\');3 p=$E(\'#1r\');3 s=$E(\'#1v\');7(u)u.8(\'b\',2(){1.f(1.B)}.6(1));7(q)q.8(\'b\',2(){1.f(1.P)}.6(1));7(t)t.8(\'b\',2(){1.f(1.k)}.6(1));7(r)r.8(\'b\',2(){1.g(1.o)}.6(1));7(p)p.8(\'b\',2(){1.g(1.v)}.6(1));7(s)s.8(\'b\',2(){1.g(1.w)}.6(1))},g:2(a){3 O=[1.o,1.v,1.w];O.y(2(x,i){7(x==a){1.m.1l(a)}1o{1.m.1m(x)}}.6(1));j.V(\'1k\',a,{Q:\'/\'});1.1h(\'d\')},f:2(4){3 T=1.C(j.N(\'G\')||1.5.D);3 R=1.C(4);j.V(\'G\',4,{Q:\'/\'});1.c.y(2(e,i){3 n=e.1w(\'4\',1.5);n.8(\'S\',1.U.6(1)).8(\'S\',1.5.d);n.1y(T,R)}.6(1))},U:2(){3 F=j.N(\'G\')||1.5.D;7(F==1.k){1.c.y(2(e,i){e.1g(\'4\',(1.5.A*1n)+\'%\')}.6(1))}},C:2(4){7(4==1.B)h 1.5.H;7(4==1.k)h 1i((1q.1p())*1.5.A);h 1.5.K}});z.L(l 1u);z.L(l 1j);',62,97,'|this|function|var|width|options|bind|if|addEvent||font|click|wrappers|afterSwitch|wrapper|widthSwitch|fontSwitch|return||Cookie|widthFluid|new|htmlbody|fx|fontSmall|switchFontMedium|switchWidthWide|switchFontSmall|switchFontLarge|switchWidthFluid|switchWidthThin|fontMedium|fontLarge|currentFont|each|YtStyleSwitcher|widthFluidPx|widthThin|getWidthPx|widthDefault||widthStyle|ytstylewidth|widthThinPx|Class|getOptions|widthWidePx|implement|wide|get|fonts|widthWide|path|newWidth|onComplete|curWidth|widthSwitchComplete|set|large|medium|small|thin|780|document|Element|fluid|940|transition|Transitions|500|duration|empty|initialize|setOptions|Fx|body|quadOut|switchwidththin|setStyle|fireEvent|parseInt|Options|ytstylefont|addClass|removeClass|100|else|getWidth|Window|switchfontmedium|switchfontsmall|switchwidthfluid|Events|switchfontlarge|effect|switchwidthwide|start'.split('|'),0,{}))
/**
 * YOOtheme Javascript file, spotlight.js
 *
 * @author yootheme.com
 * @copyright Copyright (C) 2007 YOOtheme Ltd. & Co. KG. All rights reserved.
 */

eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('7 n=9 F({E:6(h,b){4.A({z:y,x:j.B.w,D:G},b);$$(h).r(6(3,i){v((3.f()==\'s\'||3.f()==\'u\')&&3.m(\'g-5\')!=\'t\'){4.k(3,i)}}.a(4))},k:6(3,i){7 5=3.m(\'g-5\').p(/^(\\S+)\\.(q|C|Q|V)/,"$U.$2");7 8=9 W(3.f(),{\'Y\':3.H(\'T\',\'R\')});7 c=9 j.K(8,4.b);8.J({\'I\':\'L\',\'g-5\':5,\'d\':0});8.M(3);3.l(\'P\',6(e){c.o({\'d\':1})}.a(4));3.l(\'O\',6(e){c.o({\'d\':0})}.a(4))}});n.N(9 X);',61,61,'|||el|this|image|function|var|overlay|new|bind|options|fxs|opacity||getTag|background|element||Fx|createOver|addEvent|getStyle|YtSpotlight|start|replace|gif|each|div|none|span|if|quadInOut|transition|600|duration|setOptions|Transitions|jpg|wait|initialize|Class|false|getStyles|display|setStyles|Styles|block|injectInside|implement|mouseleave|mouseenter|jpeg|height||width|1_spotlight|png|Element|Options|styles'.split('|'),0,{}))
/**
 * YtTools
 * requires mootools version 1.1
 *
 * @author yootheme.com
 * @copyright Copyright (C) 2007 YOOtheme Ltd. & Co. KG. All rights reserved.
 */ 
var YtTools = {
		
	start: function() {
		
		/* Match height of div tags */
		YtTools.setDivHeight();

		/* Color settings */
		var page = $('page');
		var enterColor = '#676458'; /* default */	
		var leaveColor = '#282828'; /* default */
		var leaveColorSub = '#1e1e1e'; /* default */
		
		if (page.hasClass('red')) {
			enterColor    = '#7D2222';
		 	leaveColor    = '#461414';
			leaveColorSub = '#381010';
		} else if (page.hasClass('blue')) {
			enterColor    = '#344569';
		 	leaveColor    = '#192841';
			leaveColorSub = '#142136';
		} else if (page.hasClass('green')) {
			enterColor    = '#646E3C';
		 	leaveColor    = '#373C1E';
			leaveColorSub = '#2C3018';
		} else if (page.hasClass('grey')) {
			enterColor    = '#505050';
		 	leaveColor    = '#333333';
			leaveColorSub = '#282828';
		} else if (page.hasClass('lilac')) {
			enterColor    = '#960050';
		 	leaveColor    = '#3C0032';
			leaveColorSub = '#2F0026';
		} else if (page.hasClass('turquoise')) {
			enterColor    = '#009DAA';
		 	leaveColor    = '#005050';
			leaveColorSub = '#003C3C';
		} else if (page.hasClass('lemon')) {
			enterColor    = '#4F5638';
		 	leaveColor    = '#333333';
			leaveColorSub = '#282828';
		} else if (page.hasClass('lightblue')) {
			enterColor    = '#505050';
		 	leaveColor    = '#333333';
			leaveColorSub = '#282828';
		} else if (page.hasClass('lightmint')) {
			enterColor    = '#505050';
		 	leaveColor    = '#333333';
			leaveColorSub = '#282828';
		} else if (page.hasClass('lightorange')) {
			enterColor    = '#505050';
		 	leaveColor    = '#333333';
			leaveColorSub = '#282828';
		} else if (page.hasClass('lightpink')) {
			enterColor    = '#505050';
		 	leaveColor    = '#333333';
			leaveColorSub = '#282828';
		}

		/* Accordion menu */
		var accordionFx = new YtAccordionMenu('ul.menu li.toggler', 'ul.accordion', { accordion: 'slide' });

		/* menu level1 */
		var submenuEnter = { 'background-color': enterColor };
		var submenuLeave = { 'background-color': leaveColor };

		var submenuFx1 = new YtMorph('#left ul.menu li.level1', submenuEnter, submenuLeave,
			{ transition: Fx.Transitions.expoOut, duration: 300 },
			{ transition: Fx.Transitions.sineIn, duration: 500 });
		
		var submenuLeave = { 'background-color': leaveColorSub };
		
		/* menu level2 */
		var submenuFx2 = new YtMorph('#left ul.menu li.level2', submenuEnter, submenuLeave,
			{ transition: Fx.Transitions.expoOut, duration: 300 },
			{ transition: Fx.Transitions.sineIn, duration: 500 });

		/* Top panel */
		var toppanelFx = new YtSlidePanel($E('#toppanel'), $E('#toppanel-wrapper'),
			YtSettings.heightToppanel, { transition: Fx.Transitions.expoOut, duration: 500 });
		toppanelFx.addTriggerEvent('#toppanel-container .trigger');
		toppanelFx.addTriggerEvent('#toppanel .close');

		/* Style switcher */
		var switcherFx = new YtStyleSwitcher($ES('.wrapper'), { 
			widthDefault: YtSettings.widthDefault,
			widthThinPx: YtSettings.widthThinPx,
			widthWidePx: YtSettings.widthWidePx,
			widthFluidPx: YtSettings.widthFluidPx,
			afterSwitch: YtTools.setDivHeight,
			transition: Fx.Transitions.expoOut,
			duration: 500
		});		

		/* Lightbox */
		YtBase.setupLightbox();		
		Lightbox.init();
				
		/* Spotlight */
		var spotlightFx = new YtSpotlight('div.spotlight, span.spotlight');

	},

	/* Include addons */
	include: function(library) {
		$ES('script').each(function(s, i){
			var src = s.getProperty('src');
			if (src && src.match(/yt_tools\.js(\?.*)?$/)) {
				var path = src.replace(/yt_tools\.js(\?.*)?$/,'') + 'addons/';
				document.write('<script language="javascript" src="' + path + library + '" type="text/javascript"></script>');		
			}
		});
	},

	/* Match height of div tags */
	setDivHeight: function() {
		YtBase.matchDivHeight('div.bottombox div div div div', 0, 40);
		YtBase.matchDivHeight('div.maintopbox div div div', 2);
		YtBase.matchDivHeight('div.mainbottombox div div div', 2);
		YtBase.matchDivHeight('div.contenttopbox div div div', 2);
		YtBase.matchDivHeight('div.contentbottombox div div div', 2);
	}

};

/* Include addons */
YtTools.include('base.js');
YtTools.include('morph.js');
YtTools.include('accordionmenu.js');
YtTools.include('slidepanel.js');
YtTools.include('styleswitcher.js');
YtTools.include('spotlight.js');

/* Add functions on window load */
window.addEvent('load', YtTools.start);
