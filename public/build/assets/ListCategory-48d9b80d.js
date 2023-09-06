import{A as k}from"./AppLayoutAdmin-d2e3b506.js";import{i as S,j as c,E as D,k as v,l,o as i,c as h,w as d,a as r,b as s,e as p,g as F,F as A,h as V}from"./app-2a871929.js";import{D as w}from"./DataTable-8bf8d838.js";import{P as T}from"./Paginate-55ef9a15.js";import B from"./AddCategory-9665af94.js";import P from"./EditCategory-59c9d7b7.js";import{_ as E}from"./_plugin-vue_export-helper-c27b6911.js";import"./Dropdown-4ecace4f.js";const L={components:{AppLayoutAdmin:k,Link:S,Paginate:T,DataTable:w,AddCategoryForm:B,EditCategoryForm:P},data(){return{tab:"tab-0",fields:[{key:"name",label:"Tên chủ đề",align:"center",sortable:!0},{key:"slug",label:"Slug",align:"center"},{key:"created_at",label:"Ngày tạo",align:"center",width:190},{key:"updated_at",label:"Ngày cập nhật",align:"center",width:190},{key:"options",label:"Tùy chỉnh",align:"center",width:160}],options:[10,20,30],filterSearch:{limit:11,search:"",page:1},paginate:[],tableData:[],selectedValue:[]}},created(){this.fetchData(),document.title="Quản lý chủ đề - Admin hệ thống"},methods:{clearFilter(){this.filterSearch.page=1,this.filterSearch.isApproved="2",this.filterSearch.search="",this.filterSearch.limit=10,this.paginate=[],this.tableData=[]},async fetchData(){const a={...this.filterSearch},e=await c.get(route("admin.categories.index",a));this.tableData=e.data.data,this.paginate=e.data.meta},handleCurrentPage(a){this.filterSearch.page=a,this.fetchData()},handleSelectionChange(a){this.selectedValue=a},changeStatus(a){c.get(route("admin.categories.change-status",a.id))},editCategory(a){this.$refs.editCategoryForm.open(a)},addCategory(){this.$refs.addCategoryForm.open()},deleteSelection(a){D.confirm(`Bạn có muốn xóa chủ đề ${a.name} không?`,"Warning",{confirmButtonText:"Xác nhận",cancelButtonText:"Hủy bỏ",type:"warning",draggable:!0}).then(()=>{c.delete(route("admin.categories.destroy",a.id)).then(e=>{this.fetchData(),v({type:"success",message:"Xóa chủ đề thành công"})})}).catch(()=>{})}}},N=r("div",{class:"mt-[12px] flex text-[18px] font-bold uppercase"}," Danh sách chủ đề ",-1),j={class:"my-[18px]"},M={class:"mb-[18px] flex items-center"},R=["onClick"],U=r("i",{class:"bi bi-pencil-fill"},null,-1),X=[U],H=["onClick"],K=r("i",{class:"bi bi-trash3-fill"},null,-1),Q=[K],W={key:0,class:"flex justify-end mt-[32px] mr-[16px]"};function q(a,e,z,G,n,o){const g=l("el-option"),m=l("el-select"),u=l("el-input"),f=l("DataTable"),_=l("Paginate"),y=l("AddCategoryForm"),x=l("EditCategoryForm"),C=l("AppLayoutAdmin");return i(),h(C,{currentTab:"tab-2"},{"main-full":d(()=>[N,r("div",j,[r("div",M,[s(m,{modelValue:n.filterSearch.limit,"onUpdate:modelValue":e[0]||(e[0]=t=>n.filterSearch.limit=t),class:"max-w-[60px] ml-[8px]",onChange:e[1]||(e[1]=t=>o.fetchData())},{default:d(()=>[(i(!0),p(A,null,F(n.options,t=>(i(),h(g,{key:t,label:t,value:t},null,8,["label","value"]))),128))]),_:1},8,["modelValue"]),s(u,{class:"mx-[20px] max-w-[300px]",modelValue:n.filterSearch.search,"onUpdate:modelValue":e[2]||(e[2]=t=>n.filterSearch.search=t),placeholder:"Nhập từ khóa",clearable:"",onKeyup:e[3]||(e[3]=t=>o.fetchData())},null,8,["modelValue"]),r("div",{class:"bg-[blue] text-[14px] py-[5px] px-[18px] text-white rounded-[4px] cursor-pointer",onClick:e[4]||(e[4]=(...t)=>o.addCategory&&o.addCategory(...t))}," Thêm mới ")]),s(f,{fields:n.fields,items:n.tableData,"enable-select-box":"",onRowSelected:o.handleSelectionChange},{options:d(({row:t})=>[r("span",{class:"text-[18px] cursor-pointer",onClick:b=>o.editCategory(t)},X,8,R),r("span",{class:"pl-[8px] text-[18px] cursor-pointer",onClick:b=>o.deleteSelection(t)},Q,8,H)]),_:1},8,["fields","items","onRowSelected"]),n.tableData.length!=0?(i(),p("div",W,[s(_,{onPageChange:o.handleCurrentPage,paginate:n.paginate,"current-page":n.filterSearch.page||1,"paginate-background":""},null,8,["onPageChange","paginate","current-page"])])):V("",!0)]),s(y,{ref:"addCategoryForm",onChangeCategory:o.fetchData},null,8,["onChangeCategory"]),s(x,{ref:"editCategoryForm",onChangeCategory:o.fetchData},null,8,["onChangeCategory"])]),_:1})}const ae=E(L,[["render",q]]);export{ae as default};