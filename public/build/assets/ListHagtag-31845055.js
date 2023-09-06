import{A as C}from"./AppLayoutAdmin-d2e3b506.js";import{i as D,j as g,E as d,k as c,l as o,o as r,c as h,w as p,a as s,b as i,e as m,g as v,F as w,h as F}from"./app-2a871929.js";import{D as V}from"./DataTable-8bf8d838.js";import{P as A}from"./Paginate-55ef9a15.js";import B from"./AddHagtag-eb8c13bd.js";import T from"./EditHagtag-e8da94b2.js";import{_ as P}from"./_plugin-vue_export-helper-c27b6911.js";import"./Dropdown-4ecace4f.js";const E={components:{AppLayoutAdmin:C,Link:D,Paginate:A,DataTable:V,AddHagtagForm:B,EditHagtagForm:T},data(){return{tab:"tab-0",fields:[{key:"name",label:"Tên chủ đề",align:"center",sortable:!0},{key:"slug",label:"Slug",align:"center"},{key:"created_at",label:"Ngày tạo",align:"center",width:190},{key:"updated_at",label:"Ngày cập nhật",align:"center",width:170},{key:"options",label:"Tùy chỉnh",align:"center",width:180}],options:[10,20,30],filterSearch:{limit:10,search:"",page:1},paginate:[],tableData:[],selectedValue:[]}},created(){this.fetchData(),document.title="Quản lý hagtag - Admin hệ thống"},methods:{clearFilter(){this.filterSearch.page=1,this.filterSearch.search="",this.filterSearch.limit=10,this.paginate=[],this.tableData=[]},async fetchData(){const a={...this.filterSearch},e=await g.get(route("admin.hagtags.index",a));this.tableData=e.data.data,this.paginate=e.data.meta},handleCurrentPage(a){this.filterSearch.page=a,this.fetchData()},handleSelectionChange(a){this.selectedValue=a},addHagtag(){this.$refs.addHagtagForm.open()},editHagtag(a){this.$refs.editHagtagForm.open(a)},deleteSelection(a){d.confirm(`Bạn có muốn xóa hagtag ${a.name} không?`,"Warning",{confirmButtonText:"Xác nhận",cancelButtonText:"Hủy bỏ",type:"warning",draggable:!0}).then(()=>{g.delete(route("admin.hagtags.destroy",a.id)).then(e=>{this.fetchData(),c({type:"success",message:"Xóa hagtag thành công"})})}).catch(()=>{})},deleteSelections(){this.selectedValue.length==0?c({type:"warning",message:"Chọn hagtag muốn xóa"}):d.confirm("Bạn có muốn xóa các hagtag đã chọn không?","Warning",{confirmButtonText:"Xác nhận",cancelButtonText:"Hủy bỏ",type:"warning",draggable:!0}).then(()=>{const a={hagtags:this.selectedValue};g.post(route("admin.hagtags.delete-hagtags"),a).then(e=>{this.fetchData(),c({type:"success",message:"Xoá hagtag thành công"})})}).catch(()=>{})}}},L=s("div",{class:"mt-[12px] flex text-[18px] font-bold uppercase"}," Danh sách hagtag ",-1),N={class:"my-[18px]"},X={class:"mb-[18px] flex items-center"},j=["onClick"],M=s("i",{class:"bi bi-pencil-fill"},null,-1),R=[M],U=["onClick"],W=s("i",{class:"bi bi-trash3-fill"},null,-1),K=[W],Q={key:0,class:"flex justify-end mt-[32px] mr-[16px]"};function q(a,e,z,G,l,n){const u=o("el-option"),x=o("el-select"),f=o("el-input"),_=o("DataTable"),b=o("Paginate"),y=o("AddHagtagForm"),k=o("EditHagtagForm"),H=o("AppLayoutAdmin");return r(),h(H,{currentTab:"tab-3"},{"main-full":p(()=>[L,s("div",N,[s("div",X,[i(x,{modelValue:l.filterSearch.limit,"onUpdate:modelValue":e[0]||(e[0]=t=>l.filterSearch.limit=t),class:"max-w-[60px] ml-[8px]",onChange:e[1]||(e[1]=t=>n.fetchData())},{default:p(()=>[(r(!0),m(w,null,v(l.options,t=>(r(),h(u,{key:t,label:t,value:t},null,8,["label","value"]))),128))]),_:1},8,["modelValue"]),i(f,{class:"mx-[20px] max-w-[300px]",modelValue:l.filterSearch.search,"onUpdate:modelValue":e[2]||(e[2]=t=>l.filterSearch.search=t),placeholder:"Nhập từ khóa",clearable:"",onKeyup:e[3]||(e[3]=t=>n.fetchData())},null,8,["modelValue"]),s("div",{class:"bg-[blue] text-[14px] py-[5px] px-[18px] text-white rounded-[4px] cursor-pointer",onClick:e[4]||(e[4]=(...t)=>n.addHagtag&&n.addHagtag(...t))}," Thêm mới "),s("div",{class:"ml-[24px] bg-[red] text-[14px] py-[5px] px-[24px] text-white rounded-[4px] cursor-pointer",onClick:e[5]||(e[5]=(...t)=>n.deleteSelections&&n.deleteSelections(...t))}," Xóa ")]),i(_,{fields:l.fields,items:l.tableData,"enable-select-box":"",onRowSelected:n.handleSelectionChange},{options:p(({row:t})=>[s("span",{class:"px-[8px] py-[8px] text-[20px] cursor-pointer",onClick:S=>n.editHagtag(t)},R,8,j),s("span",{class:"px-[8px] py-[8px] text-[20px] cursor-pointer",onClick:S=>n.deleteSelection(t)},K,8,U)]),_:1},8,["fields","items","onRowSelected"]),l.tableData.length!=0?(r(),m("div",Q,[i(b,{onPageChange:n.handleCurrentPage,paginate:l.paginate,"current-page":l.filterSearch.page||1,"paginate-background":""},null,8,["onPageChange","paginate","current-page"])])):F("",!0)]),i(y,{ref:"addHagtagForm",onChangeHagtag:e[6]||(e[6]=t=>n.fetchData())},null,512),i(k,{ref:"editHagtagForm",onChangeHagtag:e[7]||(e[7]=t=>n.fetchData())},null,512)]),_:1})}const ae=P(E,[["render",q]]);export{ae as default};