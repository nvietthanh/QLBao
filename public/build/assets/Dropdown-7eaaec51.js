import{d as y,x as w,O as k,P as c,o as C,e as h,a as n,r as u,S as r,u as s,M as f,N as p,b as S,w as E,n as v,T as $}from"./app-c5eb5df1.js";const b={class:"relative"},z={__name:"Dropdown",props:{align:{type:String,default:"right"},width:{type:String,default:"48"},contentClasses:{type:Array,default:()=>["py-1","bg-white"]}},setup(i){const o=i;let e=y(!1);const l=a=>{e.value&&a.key==="Escape"&&(e.value=!1)};w(()=>document.addEventListener("keydown",l)),k(()=>document.removeEventListener("keydown",l));const g=c(()=>({48:"w-48"})[o.width.toString()]),m=c(()=>o.align==="left"?"origin-top-left left-0":o.align==="right"?"origin-top-right right-0":"origin-top");return(a,t)=>(C(),h("div",b,[n("div",{onClick:t[0]||(t[0]=d=>r(e)?e.value=!s(e):e=!s(e))},[u(a.$slots,"trigger")]),f(n("div",{class:"fixed inset-0 z-40",onClick:t[1]||(t[1]=d=>r(e)?e.value=!1:e=!1)},null,512),[[p,s(e)]]),S($,{"enter-active-class":"transition ease-out duration-200","enter-from-class":"transform opacity-0 scale-95","enter-to-class":"transform opacity-100 scale-100","leave-active-class":"transition ease-in duration-75","leave-from-class":"transform opacity-100 scale-100","leave-to-class":"transform opacity-0 scale-95"},{default:E(()=>[f(n("div",{class:v(["absolute z-50 mt-2 rounded-md shadow-lg",[s(g),s(m)]]),style:{display:"none"},onClick:t[2]||(t[2]=d=>r(e)?e.value=!1:e=!1)},[n("div",{class:v(["rounded-md ring-1 ring-black ring-opacity-5",i.contentClasses])},[u(a.$slots,"content")],2)],2),[[p,s(e)]])]),_:3})]))}};export{z as _};
