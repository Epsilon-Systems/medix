((e,t)=>{if("object"==typeof exports&&"object"==typeof module)module.exports=t();else if("function"==typeof define&&define.amd)define([],t);else{var o=t();for(var s in o)("object"==typeof exports?exports:e)[s]=o[s]}})(self,(function(){return(self.webpackChunkjodit_pro=self.webpackChunkjodit_pro||[]).push([[630],{252(e,t,o){"use strict";o.r(t),o.d(t,{ExportDocs:()=>d});var s=o(62),r=o(50),n=o(1),a=o(2),i=o(17);a.D.prototype.exportDocs={css:"",pdf:{allow:!0,options:{format:"A4",page_orientation:"portrait"}}},a.D.prototype.controls.exportDocs={tooltip:"Export",isDisabled:e=>i.i.isEmptyContent(e.editor),icon:o(253),list:{exportToPdf:"Export to PDF"},command:"exportToPDF"};var c=o(10),l=o(4),p=o(98);class d extends s.S{constructor(){super(...arguments),this.requires=["license"],this.buttons=[{name:"exportDocs",group:"media"}]}afterInit(e){e.registerCommand("exportToPDF",(async()=>{var t;const o=function(e){const t=(e,t=e.ownerDocument.styleSheets)=>(0,c.toArray)(t).map((e=>{try{return(0,c.toArray)(e.cssRules)}catch(e){}return[]})).flat().filter((t=>{try{return t&&e.matches(t.selectorText)}catch(e){}return!1}));return new class{constructor(o,s,r){this.css={};const n=r||{},a=t=>{const o=t.selectorText.split(",").map((e=>e.trim())).sort().join(",");0==!!this.css[o]&&(this.css[o]={});const s=t.style.cssText.split(/;(?![A-Za-z0-9])/);for(let t=0;s.length>t;t++){if(!s[t])continue;const r=s[t].split(":");r[0]=r[0].trim(),r[1]=r[1].trim(),this.css[o][r[0]]=r[1].replace(/var\(([^)]+)\)/g,((t,o)=>{const[s,r]=o.split(",");return(e.ew.getComputedStyle(e.editor).getPropertyValue(s.trim())||r||t).trim()}))}};(()=>{const r=o.innerHeight,i=s.createTreeWalker(e.editor,NodeFilter.SHOW_ELEMENT,(()=>NodeFilter.FILTER_ACCEPT));for(;i.nextNode();){const e=i.currentNode;if(r>e.getBoundingClientRect().top||n.scanFullPage){const o=t(e);if(o)for(let e=0;o.length>e;e++)a(o[e])}}})()}generateCSS(){let e="";for(const t in this.css)if(!/:not\(/.test(t)){e+=t+" { ";for(const o in this.css[t])e+=o+": "+this.css[t][o]+"; ";e+="}\n"}return e}}(e.ew,e.ed,{scanFullPage:!0}).generateCSS()}(e),s=new r.t(e,{...null!==(t=e.o.exportDocs.ajax)&&void 0!==t?t:e.o.filebrowser.ajax,method:"POST",responseType:"blob",onProgress(t){e.progressbar.show().progress(t)},data:{action:"generatePdf",html:`<style>${o+e.o.exportDocs.css}</style>${d.getValue(e)}`}});try{const t=await s.send(),o=await t.blob(),r=this.j.create.a(),n="document.pdf";r.href=URL.createObjectURL(o),r.download=n,r.click(),i.i.safeRemove(r),URL.revokeObjectURL(r.href)}catch(e){e.message&&(0,l.Alert)(e.message)}finally{e.progressbar.progress(100),await e.async.delay(200),e.progressbar.hide()}}))}static getValue(e){return(0,p.$)(e).innerHTML}beforeDestruct(){}}n.Jodit.plugins.add("exportDocs",d)},253(e){e.exports='<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path d="M19,21H5a2,2,0,0,1-2-2V17a1,1,0,0,1,2,0v2H19V17a1,1,0,0,1,2,0v2A2,2,0,0,1,19,21Z"/> <path d="M18,5H6A1,1,0,0,1,6,3H18a1,1,0,0,1,0,2Z"/> <path d="M15.71,10.29l-3-3a1,1,0,0,0-.33-.21,1,1,0,0,0-.76,0,1,1,0,0,0-.33.21l-3,3a1,1,0,0,0-.21,1.09A1,1,0,0,0,9,12h2v3a1,1,0,0,0,2,0V12h2a1,1,0,0,0,.92-.62A1,1,0,0,0,15.71,10.29Z"/> </svg>'}},e=>e(e.s=252)])}));