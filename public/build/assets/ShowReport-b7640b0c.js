import{i as p,j as _,l as n,o as r,c as m,w as a,a as t,t as i,b as x}from"./app-2a871929.js";import{h}from"./moment-fbc5633a.js";import{_ as g}from"./_plugin-vue_export-helper-c27b6911.js";const u={components:{Link:p},data(){return{dialogVisible:!1,dataForm:{}}},watch:{dialogVisible(o){o==!1&&(this.dataForm={})}},methods:{moment:h,async open(o){this.dialogVisible=!0;const e=await _.get(route("admin.report-accounts.show-report",o.id));this.dataForm=e.data.data}}},v=t("div",{class:"text-center font-bold text-[18px]"}," Xem chi tiết báo cáo vi phạm ",-1),f={class:"flex mt-[38px]"},b={class:"py-[12px] px-[12px]"},w=t("div",{class:"text-[16px] font-bold text-[blue]"},"Thông tin người dùng:",-1),F={class:"px-[24px]"},V={class:"mt-[8px]"},T=t("span",{class:"text-[16px] font-bold"},"Tên người dùng:",-1),k={class:"ml-[12px]"},y={class:"mt-[6px]"},B=t("span",{class:"text-[16px] font-bold"},"Email:",-1),H={class:"ml-[12px]"},L=t("div",{class:"text-[16px] font-bold mt-[12px] text-[blue]"},"Thông tin người dùng báo cáo:",-1),N={class:"px-[24px]"},S={class:"mt-[6px]"},z=t("span",{class:"text-[16px] font-bold"},"Tên người dùng:",-1),C={class:"ml-[12px]"},E={class:"mt-[6px]"},M=t("span",{class:"text-[16px] font-bold"},"Email:",-1),R={class:"ml-[12px]"},j={class:"mt-[12px]"},D=t("div",{class:"font-bold text-[16px] text-[blue]"},"Thông tin chi tiết báo cáo vi phạm:",-1),U={class:"px-[24px]"},X={class:"mt-[6px]"},q=t("span",{class:"text-[16px] font-bold"},"Nội dung:",-1),A=["innerHTML"],G={class:"mt-[6px]"},I=t("span",{class:"text-[16px] font-bold"},"Hình ảnh kèm theo:",-1),J={class:"mt-[12px] grid grid-cols-3 gap-3"};function K(o,e,O,P,s,Q){const c=n("el-image"),l=n("el-dialog");return r(),m(l,{modelValue:s.dialogVisible,"onUpdate:modelValue":e[0]||(e[0]=d=>s.dialogVisible=d),id:"show-report-account",class:"bg-[#f4f1f8] h-[90%] overflow-scroll",width:"820px",style:{"margin-top":"34px !important"},"show-close":!0},{header:a(()=>[v]),default:a(()=>[t("div",f,[t("div",b,[t("div",null,[w,t("div",F,[t("div",V,[T,t("span",k,i(s.dataForm.account_name),1)]),t("div",y,[B,t("span",H,i(s.dataForm.account_email),1)])])]),t("div",null,[L,t("div",N,[t("div",S,[z,t("span",C,i(s.dataForm.account_report_name),1)]),t("div",E,[M,t("span",R,i(s.dataForm.account_report_email),1)])])]),t("div",j,[D,t("div",U,[t("div",X,[q,t("div",{innerHTML:s.dataForm.content,class:"pl-[24px] text-[15px]"},null,8,A)]),t("div",G,[I,t("div",J,[x(c,{class:"h-[180px]",src:s.dataForm.image,"zoom-rate":1.2,"preview-teleported":"true","hide-on-click-modal":"true","preview-src-list":[s.dataForm.image],"initial-index":1,fit:"cover"},null,8,["src","zoom-rate","preview-src-list"])])])])])])])]),_:1},8,["modelValue"])}const $=g(u,[["render",K]]);export{$ as default};