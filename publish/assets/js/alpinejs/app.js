!function(e){var t={};function n(r){if(t[r])return t[r].exports;var a=t[r]={i:r,l:!1,exports:{}};return e[r].call(a.exports,a,a.exports,n),a.l=!0,a.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var a in e)n.d(r,a,function(t){return e[t]}.bind(null,a));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=228)}({228:function(e,t,n){e.exports=n(229)},229:function(e,t){document.addEventListener("alpine:init",(function(){Alpine.store("menuStyle",{name:""}),Alpine.data("userDropdown",(function(){return{open:!1,toggleUserDropdown:function(){this.open=!this.open}}})),Alpine.data("sudaBody",(function(){return{proSidebar:!1,sidebarStyle:"",toggleSidebar:function(e){var t=this;e.preventDefault(),this.proSidebar=!this.proSidebar,e.currentTarget.parentElement.classList.contains("navbar-suda-icon")?(e.currentTarget.parentElement.classList.remove("navbar-suda-icon"),this.$refs.sidebar.classList.remove("press-sidebar-icon"),this.$refs.sidebar.classList.add("in"),this.$refs.suda_app_content.classList.remove("suda-flat-lg"),this.sidebarStyle="flat"):e.currentTarget.parentElement.classList.contains("navbar-suda-icon")||(e.currentTarget.parentElement.classList.add("navbar-suda-icon"),this.$refs.sidebar.classList.add("press-sidebar-icon"),this.$refs.sidebar.classList.remove("in"),this.$refs.suda_app_content.classList.add("suda-flat-lg"),this.sidebarStyle="icon"),fetch(document.head.querySelector("meta[name=root-path]").content+"/style/sidemenu/"+this.sidebarStyle,{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":document.head.querySelector("meta[name=csrf-token]").content},body:JSON.stringify({})}).then((function(){t.$store.menuStyle.name=t.sidebarStyle})).catch((function(){}))}}}))}))}});