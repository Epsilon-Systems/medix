((t,e)=>{if("object"==typeof exports&&"object"==typeof module)module.exports=e();else if("function"==typeof define&&define.amd)define([],e);else{var o=e();for(var s in o)("object"==typeof exports?exports:t)[s]=o[s]}})(self,(function(){return(self.webpackChunkjodit_pro=self.webpackChunkjodit_pro||[]).push([[876],{191(t,e,o){"use strict";o.r(e),o.d(e,{ar:()=>s,cs_cz:()=>l,de:()=>r,es:()=>i,fa:()=>n,fr:()=>a,he:()=>c,hu:()=>h,id:()=>p,it:()=>d,ja:()=>k,ko:()=>u,nl:()=>b,pl:()=>g,pt_br:()=>w,ru:()=>f,tr:()=>B,zh_cn:()=>x,zh_tw:()=>m});const s=o(192),l=o(193),r=o(194),i=o(195),n=o(196),a=o(197),c=o(198),h=o(199),p=o(200),d=o(201),k=o(202),u=o(203),b=o(204),g=o(205),w=o(206),f=o(207),B=o(208),x=o(209),m=o(210)},190(t,e,o){"use strict";o.r(e),o.d(e,{showBlocks:()=>p});var s=o(187),l=o(2);l.D.prototype.showBlocks={enable:!1,color:"#ccc",tagList:["html","body","div","span","applet","object","iframe","h1","h2","h3","h4","h5","h6","p","blockquote","pre","a","abbr","acronym","address","big","cite","code","del","dfn","em","img","ins","kbd","q","s","samp","small","strike","strong","sub","sup","tt","var","b","u","i","center","dl","dt","dd","fieldset","form","label","legend","caption","th","td","li","ol","ul","article","aside","canvas","details","embed","figure","figcaption","footer","header","hgroup","menu","nav","output","ruby","section","summary","time","mark","audio","video"]},l.D.prototype.controls.showBlocks={isActive(t){return!!t.e.fire("showBlocksEnabled")},tooltip:"Show Blocks",command:"toggleShowBlocks"};var r=o(62),i=o(4),n=o(37),a=o(15),c=o(19),h=o(1);class p extends r.S{constructor(t){super(t),this.requires=["license"],this.buttons=[{name:"showBlocks",group:"state"}],this.isEnabled=!1,(0,a.xl)(o(191)),n.JO.set("showBlocks",o(211))}enable(){this.isEnabled=!0;const t=this.j.o.iframe?"body":".jodit-wysiwyg",{tagList:e,color:o}=this.j.o.showBlocks;this.style.innerHTML=e.map((e=>{return`${t} ${e}{\n\t\t\t\t\toutline: 1px dashed ${o};\n\t\t\t\t\tbackground-image: url("${s='<svg xmlns="http://www.w3.org/2000/svg" width="50px"><text dominant-baseline="hanging" text-anchor="end" style="fill: '+o+';font: 10px sans-serif" x="50px" y="0">'+e+"</text></svg>","data:image/svg+xml;utf8,"+escape(s)}");\n\t\t\t\t\tbackground-position: top 2px ${"rtl"===this.j.o.direction?"left":"right"} 4px;\n\t\t\t\t\tbackground-repeat: no-repeat;\n\t\t\t\t\tposition: relative;\n\t\t\t\t}`;var s})).join("")}disable(){this.isEnabled=!1,this.style.innerHTML=""}toggle(){this.isEnabled?this.disable():this.enable(),this.j.e.fire("updateToolbar")}afterInit(t){this.style=(0,a.ZO)(t,p,"style",!0),t.e.on("showBlocksEnabled",(()=>this.isEnabled)),t.registerCommand("enableShowBlocks",this.enable).registerCommand("disableShowBlocks",this.disable).registerCommand("toggleShowBlocks",this.toggle),this.j.o.showBlocks.enable&&this.enable()}beforeDestruct(t){this.disable(),i.Dom.safeRemove(this.style)}}(0,s.gn)([c.autobind],p.prototype,"enable",null),(0,s.gn)([c.autobind],p.prototype,"disable",null),(0,s.gn)([c.autobind],p.prototype,"toggle",null),h.Jodit.plugins.add("show-blocks",p)},187(t,e,o){"use strict";function s(t,e,o,s){var l,r=arguments.length,i=3>r?e:null===s?s=Object.getOwnPropertyDescriptor(e,o):s;if("object"==typeof Reflect&&"function"==typeof Reflect.decorate)i=Reflect.decorate(t,e,o,s);else for(var n=t.length-1;n>=0;n--)(l=t[n])&&(i=(3>r?l(i):r>3?l(e,o,i):l(e,o))||i);return r>3&&i&&Object.defineProperty(e,o,i),i}o.d(e,{gn:()=>s})},192(t){t.exports={"Show Blocks":"تظهر كتل"}},193(t){t.exports={"Show Blocks":"Ukázat Bloky"}},194(t){t.exports={"Show Blocks":"Zeigen Blöcke"}},195(t){t.exports={"Show Blocks":"Mostrar Bloques"}},196(t){t.exports={"Show Blocks":"نشان می دهد بلوک"}},197(t){t.exports={"Show Blocks":"Afficher Les Blocs"}},198(t){t.exports={"Show Blocks":"תראה רחובות"}},199(t){t.exports={"Show Blocks":"Mutasd Meg Blokkok"}},200(t){t.exports={"Show Blocks":"Menunjukkan Blok"}},201(t){t.exports={"Show Blocks":"Visualizza Blocchi"}},202(t){t.exports={"Show Blocks":"ショーのブロック"}},203(t){t.exports={"Show Blocks":"쇼 블록"}},204(t){t.exports={"Show Blocks":"Toon Blokken"}},205(t){t.exports={"Show Blocks":"Pokaż Bloki"}},206(t){t.exports={"Show Blocks":"Mostrar Blocos"}},207(t){t.exports={"Show Blocks":"Показать Блоки"}},208(t){t.exports={"Show Blocks":"Haritayı Blokları"}},209(t){t.exports={"Show Blocks":"显示块"}},210(t){t.exports={"Show Blocks":"แสดงช่วงตึก"}},211(t){t.exports='<svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"> <g> <rect rx="10" height="1620" width="1620" y="79.646973" x="80" stroke-width="100" stroke-dasharray="8% 10%" fill="none"/> <path d="m1333.992706,381.692384l0,52.982419q0,21.04781 -12.98052,44.272981t-29.820114,23.22517q-35.082487,0 -37.889085,0.725787q-18.242893,4.354719 -22.452791,22.499384q-2.104949,7.983652 -2.104949,46.45034l0,836.106125q0,18.144664 -12.629695,31.208822t-30.170938,13.064158l-75.778171,0q-17.541243,0 -30.170938,-13.064158t-12.629695,-31.208822l0,-884.008038l-100.335911,0l0,884.008038q0,18.144664 -12.27887,31.208822t-30.521763,13.064158l-75.778171,0q-18.242893,0 -30.521763,-13.064158t-12.27887,-31.208822l0,-359.990137q-103.14251,-8.709439 -171.904184,-42.821407q-88.407866,-42.095621 -134.716748,-129.915795q-44.905583,-84.917028 -44.905583,-187.978721q0,-120.48057 61.745176,-207.574958q61.745176,-85.642815 146.644794,-115.400064q77.88312,-26.854103 292.587937,-26.854103l336.090221,0q17.541243,0 30.170938,13.064158t12.629695,31.208822z"/> </g> </svg>'}},t=>t(t.s=190)])}));