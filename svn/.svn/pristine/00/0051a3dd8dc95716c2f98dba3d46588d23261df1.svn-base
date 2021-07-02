/**
* Hyvor's Official library for Javascript 
* @link https://cdn.hyvor.com/js/hyvorin-2.0.js
* @version 2.0
*/
"use strict";var hy=(function(){var $=(function(){return{isString:function(t){return typeof t==="string";},isObject:function(o){return o===Object(o);},isRealObject:function(o){return o.constructor&&o.constructor===Object;},isDefined:function(u){return u!==null&&typeof u!=="undefined";},isUndefined:function(u){return!$.isDefined(u);},isNull:function(n){return n===null;},isArray:function(a){return a&&a.constructor&&a.constructor===Array;},isFunction:function(f){return f&&typeof f==="function";},trim:function(s){return s.replace(/^\s+|\s+$/g,"");},inArray:function(array,item){return $.isArray(array)&&array.indexOf(item)>-1?true:false;},ajax:function(data){var dataSend=null;try{var http=(window.XMLHttpRequest)?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP");}
catch(e){return;}
if(!data.file)return;if(data.success||data.error){http.onreadystatechange=function(){if(this.readyState===4){if(data.ready)data.ready.call(http);if(this.status===200){if(data.success)data.success.call(http);}else{if(data.error)data.error.call(http);}}}}
data.method=data.method.toUpperCase();if(data.method==="GET"&&$.isObject(data.data)){data.file=data.file+"?"+$.queryString(data.data);dataSend="";}
http.open(data.method,data.file,true);if(data.method==="POST"&&!data.formData){http.setRequestHeader("Content-type","application/x-www-form-urlencoded");if(typeof data.data==="object"){dataSend=$.queryString(data.data);}}
if(dataSend===null)dataSend=data.data;http.send(dataSend);return http;},queryString:function(obj){var x,first=true,$return="";for(x in obj){$return+=(!first?"&":"")+x+"="+obj[x];first=false;}
return $return;},jsonDecode:function(text){try{var json=JSON.parse(text);}
catch(e){return false;}
return json;},jsonEncode:function(text){return JSON.stringify(text);},formData:function(data){var formData=new FormData(),x;for(x in data){if(isArray(data[x])){formData.append(x,data[x][0],data[x][1]);}else{formData.append(x,data[x]);}}
return formData;},each:function(items,callback){if($.isRealObject(items)){for(var i in items){callback(items[i],i);}
return;}
for(var i=0,len=items.length;i<len;i++){callback(items[i],i);}}}})();function hyvorin(pick,parent){if(!pick){return this.length=0;}
if($.isString(pick)){var idMatch=pick.match(/^:([a-z0-9A-Z$_-]+)$/);if(idMatch){var id=idMatch[1],node=document.getElementById(id);return addNodes.call(this,node);}
var classMatch=pick.match(/^(.*)\.(.+)/);if(classMatch){var p=parent||(classMatch[1]?hy(classMatch[1]):document);name=classMatch[2],nodes=nodesByClass(name,p);return addNodes.call(this,nodes);}
var createMatch=pick.match(/<(.*)>:?([0-9]*)/)
if(createMatch){var tagName=createMatch[1],number=createMatch[2]||1,nodes=[];for(var i=0;i<number;i++){nodes.push(document.createElement(tagName));}
return addNodes.call(this,nodes);}
var common={document:document,body:document.body};for(var i in common){if(pick===i){return addNodes.call(this,common[i]);}}
if(pick==='window'){this[0]=window;this.length=1;}
var nodes=(parent||document).querySelectorAll(pick);if(nodes.length){return addNodes.call(this,nodes);}}else if($.isObject(pick)){if(isHyvorinObject(pick)){return pick;}
if($.isRealObject(pick)&&pick.tag){var element=createNodeFromObject(pick,parent);return addNodes.call(this,element);}
return addNodes.call(this,pick);}}
function nodesByClass(name,parent){parent=parent||document;if('getElementsByClassName'in document){var nodes=parent.getElementsByClassName(name);return nodes.length?nodes:null;}else{var thios=parent.getElementsByTagName("*"),nodes=[],reg=new RegExp("\\b"+name+"\\b");for(var i=0,len=thios.length;i<len;i++){var thio=thios[i];if(thio.className.match(reg)){nodes.push(thio);}}
return nodes;}}
function addNodes(nodes){if(!nodes){return this.length=0;}
if(nodes.length&&!nodes.tagName){for(var i=0,len=nodes.length;i<len;i++){this[i]=nodes[i];}
this.length=len;}else{this[0]=nodes;this.length=1;}
return this;}
function createNodeFromObject(obj,parent){var t=obj.tag,c=obj.className,at=obj.attr,s=obj.css,ch=obj.children,html=obj.html,text=obj.text,value=obj.value
var node=hy("<"+t+">");if(c)node.addClass(c);if(at)node.attr(at);if(s)node.css(s);if(obj.id)node.attr("id",obj.id);if(html)node.html(html);if(text)node.text(text);if(value)node.value(value);if(obj.data)node.data(obj.data);if(obj.title)node.attr("title",obj.title);if(obj.href)node.attr("href",obj.href);if(obj.src)node.attr("src",obj.src);if(obj.target)node.attr("target",obj.target);if(obj.click)node.event("click",obj.click);if(obj.appendTo)node.appendTo(obj.appendTo);if(parent){node.appendTo(parent);}
if(ch){$.each(ch,function(child){hy(child).appendTo(node);});}
return node;}
var protoExtend={each:function(func){$.each(this,func);return this;},hy:function(pick){return hy(pick,this._0());},css:function(name,value){if($.isString(name)){if($.isDefined(value)){var parsed=addPX(name,value);this.each(function(node){node.style[parsed.name]=parsed.value;})}else{var name=vendorPrefix(name),node=this._0();if(!node)
return;var style=node.style[name];if(!style&&$.isFunction(window.getComputedStyle)){style=window.getComputedStyle(node)[name];}
return style;}}
if($.isRealObject(name)){for(var i in name){var parsed=addPX(i,name[i]);this.each(function(node){node.style[parsed.name]=parsed.value;});}}
return this;},attr:function(name,value){if($.isString(name)){if($.isDefined(value)){this.each(function(node){node.setAttribute(name,value);})}else{return this._0(true).getAttribute(name)||"";}}
if($.isRealObject(name)){for(var i in name){this.each(function(node){node.setAttribute(i,name[i]);});}}
return this;},id:function(id){return this.attr("id",id);},removeAttr:function(name){this.each(function(node){node.removeAttribute(name);})
return this;},html:function(to){if($.isDefined(to)){this.each(function(node){node.innerHTML=to;});return this;}else
return this._0(true).innerHTML||"";},empty:function(){return this.html("");},text:function(to){if($.isDefined(to)){this.each(function(node){node.innerText=to;});return this;}else
return this._0(true).innerText||"";},value:function(to){if($.isDefined(to)){this.each(function(node){node.value=to;});return this;}else
return this._0(true).value||"";},data:function(name,value){if($.isString(name)){if($.isDefined(value)){this.each(function(node){if(node&&node.dataset){node.dataset[name]=value;}})}else{var n=this._0();if(n&&n.dataset&&n.dataset[name]){return n.dataset[name];}
return false;}}
if($.isRealObject(name)){for(var i in name){this.each(function(node){node.dataset[i]=name[i];});}}
return this;},show:function(type){return this.css("display",$.isDefined(type)?type:"block");},hide:function(){return this.css("display","none");},toggle:function(){this.each(function(node){node=hy(node);if(node.css("display")!=="none")
node.hide();else
node.show();});return this;},appendTo:function(to){var parent=getRealNode(to);this.each(function(node){parent.appendChild(node);})
return this;},prependTo:function(to){var parent=getRealNode(to);this.each(function(node){parent.insertBefore(node,parent.firstChild);})
return this;},insertBefore:function(before,parent){before=getRealNode(before);parent=parent?getRealNode(parent):before.parentElement;this.each(function(node){parent.insertBefore(node,before);})
return this;},append:function(nodes){if(isHyvorinObject(nodes)){nodes.appendTo(this);return this;}
if(nodes.length){$.each(function(node){hy(node).appendTo(this);})
return this;}
if(nodes.tagName){hy(nodes).appendTo(this);return this;}},replaceWith:function(newNode){var t0=this._0(),parent=this.parent()._0(),node=getRealNode(newNode);if(t0&&parent&&node){parent.replaceChild(node,t0);}
return this;},event:function(ev,func,returnDetach){var self=this;doEvents.call(this,ev,func,"add");if(returnDetach)
return function(){self.removeEvent(ev,func);}
return this;},removeEvent:function(ev,func){doEvents.call(this,ev,func,"remove");return this;},on:function(ev,func){this.each(function(node){node["on"+ev]=func;});return this;},off:function(ev){this.each(function(node){node["on"+ev]=null;})
return this;},get:function(property){var node=this._0();return node?node[property]:null;},offset:function(){var node=this._0();if(!node)
return;if(!node.getClientRects().length){return{top:0,left:0};}
var rect=node.getBoundingClientRect();return{left:rect.left,top:rect.top}},by:function(time,func){var self=this;setTimeout(function(){func.call(self);},time);return this;},kill:function(){this.each(function(node){if(node&&node.parentElement){node.parentElement.removeChild(node);}});return this;},killIn:function(mS){this.by(mS,this.kill);return this;},scrollToTop:function(param){var n=this._0();if(!n)
return;if($.isFunction(n.scrollIntoView)){n.scrollIntoView($.isDefined(param)?param:true);}
return this;},scrollToBottom:function(){return this.scrollToTop(false);},scrollToMiddle:function(){var n=this._0();if(!n)
return;n=hy(n);var wOffset=hy.windowOffset(),nOffset=n.offset(),nHeight=n.height();window.scrollTo(wOffset.left,wOffset.top+nOffset.top-(wOffset.height/2)+(nHeight/2));return this;},height:function(){return this._0(true).offsetHeight;},width:function(){return this._0(true).offsetWidth;},parent:function(){var n=this._0();if(!n)
return null;return hy(n.parentElement);},children:function(index){var n=this._0();if(n){var children=n.children,r;if($.isString(index)){if(index==="last"&&children[children.length-1]){r=children[children.length-1];}else if(index==="first"&&children[0]){r=children[0];}}else if($.isDefined(index)){r=children[index];}
return hy(r||children);}
return null;},next:function(){return hy(this._0(true).nextElementSibling);},previous:function(){return hy(this._0(true).previousElementSibling);},clone:function(p){var n=this._0();if(n)
return hy(n.cloneNode(p));},addClass:function(classes){classes=classes.split(" ");this.each(function(node){$.each(classes,function(c){var reg=new RegExp('\\b'+c+'\\b');if(!node.className.match(reg)){node.className+=(node.className===""?"":" ")+c;}});});return this;},removeClass:function(classes){classes=classes.split(" ");this.each(function(node){var cn=node.className;$.each(classes,function(c){var reg=new RegExp('\\s*\\b'+c+'\\b');node.className=cn.replace(reg,"");})});return this;},checkClass:function(cls){var n=this._0();if(!n)
return;return n.className.match(new RegExp('\\b'+cls+'\\b'))?true:false;},getNode:function(index){if(this[index]){return this[index];}},_0:function(returnPsuedoElement){if(this[0]){return this[0];}
if(returnPsuedoElement){return document.createElement("div");}
return null;}}
deepExtend(hyvorin.prototype,protoExtend);$.each(("blur click focus focusin focusout resize scroll dblclick "+
"mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave "+
"change select submit keydown keypress keyup contextmenu").split(' '),function(evName){hyvorin.prototype[evName]=function(func){if($.isFunction(func)){this.event(evName,func);}else{var node=this._0();if(node&&$.isFunction(node[evName])){node[evName]();}}
return this;}});function deepExtend(destination,source){destination=destination||{};for(var property in source){if(source[property]&&source[property].constructor&&source[property].constructor===Object){destination[property]=destination[property]||{};deepExtend(destination[property],source[property]);}else{destination[property]=source[property];}}
return destination;}
function vendorPrefix(name){if(!(name in vendorPrefix.emptyStyles)){var vendor=["Webkit","Moz","ms"];for(var i=0,len=vendor.length;i<len;i++){var newName=vendor[i]+name.charAt(0).toUpperCase()+name.slice(1);if(newName in vendorPrefix.emptyStyles){return newName;}}}
return name;}
vendorPrefix.emptyStyles=document.createElement("DIV").style;var addPX=function(name,value){var match=name.match(/height|width|top|bottom|left|right|margin|marginTop|marginBottom|marginLeft|marginRight|borderRadius|borderTopLeftRadius|borderTopRightRadius|borderBottomLeftRadius|borderBottomRightRadius|padding|paddingRight|paddingLeft|paddingTop|paddingBottom|fontSize/);name=vendorPrefix(name);if(match&&$.isDefined(value)){value=String(value);var valueSplit=value.split(" "),returnValue="";for(var i=0,len=valueSplit.length;i<len;i++){var val=valueSplit[i];if(val.match(/^\d+(\.)?\d*$/)){returnValue+=val+"px";}}
value=returnValue||value;}
return{name:name,value:value};}
function isHyvorinObject(obj){return obj.constructor===hyvorin;}
function getRealNode(to){if($.isFunction(to._0))return to._0();return to;}
function doEvents(ev,func,type){this.each(function(node){if(type==="add"){if(doEvents.e){node.addEventListener(ev,func);}else{node.attachEvent("on"+ev,func);}}
if(type==="remove"){if(doEvents.e){node.removeEventListener(ev,func);}else{node.detachEvent("on"+ev,func);}}});return this;}
doEvents.e=typeof window.addEventListener==="function";function windowOffset(){return{width:window.innerWidth||document.documentElement.clientWidth||document.body.clientWidth,height:window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight,left:(window.pageXOffset!==undefined)?window.pageXOffset:(document.documentElement||document.body.parentNode||document.body).scrollLeft,top:(window.pageYOffset!==undefined)?window.pageYOffset:(document.documentElement||document.body.parentNode||document.body).scrollTop}};(function(constructor){if(constructor&&constructor.prototype&&constructor.prototype.children==null){Object.defineProperty(constructor.prototype,'children',{get:function(){var i=0,node,nodes=this.childNodes,children=[];while(node=nodes[i++]){if(node.nodeType===1){children.push(node);}}
return children;}});}})(window.Node||window.Element);(function(constructor){if(constructor&&!("nextElementSibling"in document.documentElement)){Object.defineProperty(constructor.prototype,"nextElementSibling",{get:function(){var e=this.nextSibling;while(e&&1!==e.nodeType)
e=e.nextSibling;return e;}});}})(window.Node||window.Element);(function(constructor){if(constructor&&!("previousElementSibling"in document.documentElement)){Object.defineProperty(constructor.prototype,"previousElementSibling",{get:function(){var e=this.previousSibling;while(e&&1!==e.nodeType)
e=e.previousSibling;return e;}});}})(window.Node||window.Element)
if(!Array.prototype.indexOf){Array.prototype.indexOf=function(vMember,nStartFrom){if(this==null){throw new TypeError("Array.prototype.indexOf() - can't convert `"+this+"` to object");}
var
nIdx=isFinite(nStartFrom)?Math.floor(nStartFrom):0,oThis=this instanceof Object?this:new Object(this),nLen=isFinite(oThis.length)?Math.floor(oThis.length):0;if(nIdx>=nLen){return-1;}
if(nIdx<0){nIdx=Math.max(nLen+nIdx,0);}
if(vMember===undefined){do{if(nIdx in oThis&&oThis[nIdx]===undefined){return nIdx;}}while(++nIdx<nLen);}else{do{if(oThis[nIdx]===vMember){return nIdx;}}while(++nIdx<nLen);}
return-1;};}
function byId(id){return hy(":"+id);}
var r=function(pick,parent){return new hyvorin(pick,parent);}
r.$=$;r.windowOffset=windowOffset;r.byId=byId;return r;})();
