<template>
    <AppLayoutAdmin :currentTab="'tab-6'" :currentTabChild="'tab-3'">
        <template v-slot:main-full>
            <div class="mt-[12px] flex text-[18px] font-bold uppercase">
               Quản lý thông tin liên hệ
            </div>
            <div class="mt-[12px] flex items-center text-[15px] border-b-[3px] border-b-[#adb5bd]">
                <div class="w-[120px] text-center py-[8px] cursor-pointer"
                 :class="{ 'bg-[#495057] text-white' : tab == 'tab-0' }" @click="changeTab('tab-0')">
                    Thông tin
                </div>
                <div class="w-[180px] text-center py-[8px] cursor-pointer"
                 :class="{ 'bg-[#495057] text-white' : tab == 'tab-1' }" @click="changeTab('tab-1')">
                    Danh sách câu hỏi
                </div>
            </div>
            <template v-if="tab == 'tab-0'">
                <div class="mt-[18px] mb-[28px]">
                    <div class="mb-[12px]">
                        <div class="mb-[4px] font-bold text-[17px]">Tiêu đề</div>
                        <el-input v-model="dataForm.title" size="large" placeholder="Nhập tiêu đề" />
                        <div v-if="errors.title" class="mt-[5px] text-[15px] text-[#ff0000]">
                            {{ errors.title[0] }}
                        </div>
                    </div>
                    <div class="mt-[18px] text-[14px]">
                        <div class="mb-[4px] font-bold text-[17px]">Nội dung</div>
                        <ckeditor-post class="mt-[8px]" ref="content" :contentProp="dataForm.content" />
                        <div v-if="errors.content" class="mt-[5px] text-[15px] text-[#ff0000]">
                            {{ errors.content[0] }}
                        </div>
                    </div>
                </div>
                <div class="mb-[28px]">
                    <div class="flex justify-end text-[14px] mr-[24px]">
                        <div class="cursor-pointer flex justify-center items-center w-[110px] rounded-[4px] bg-[#ffffff] py-[4px] 
                          h-[32px] text-[15px] text-black border border-[#7d7f92]"  @click="cancel">
                            Hủy bỏ
                        </div>
                        <div class="cursor-pointer flex justify-center items-center w-[110px] ml-[18px] rounded-[4px] bg-[#007bff]
                          py-[4px] h-[32px] text-[15px] text-white" @click="updateAboutUs">
                            Xác nhận
                        </div>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="my-[28px]">
                    <div class="mb-[18px] flex items-center">
                        <el-select v-model="filterSearch.limit" class="max-w-[60px] ml-[8px]" @change="fetchDataList()">
                            <el-option
                                v-for="item in options"
                                :key="item"
                                :label="item"
                                :value="item"
                            />
                        </el-select>
                        <el-date-picker
                            v-model="filterSearch.dateRange"
                            type="daterange"
                            start-placeholder="Ngày bắt đầu"
                            end-placeholder="Ngày kết thúc"
                            :size="small"
                            format="DD-MM-YYYY"
                            value-format="DD-MM-YYYY"
                            class="max-w-[260px] mx-[28px]"
                            @change="fetchDataList()"
                        />
                        <el-input class="mr-[28px] max-w-[300px]" v-model="filterSearch.search"
                                    placeholder="Nhập từ khóa" clearable @keyup.enter="fetchDataList()"/>
                        <div class="text-[14px] bg-[red] w-[130px] h-[32px] leading-[32px] text-white 
                        text-center rounded-[4px] cursor-pointer" @click="deleteAbouts">
                            Xóa liên hệ
                        </div>
                    </div>
                    <DataTable :fields="fields" :items="tableData" enable-select-box @row-selected="handleSelectionChange">
                        <template #name="{ row }">
                            <div class="text-left hover:text-[blue]">
                                {{row.name}}
                            </div>
                        </template>
                        <template #email="{ row }">
                            <div class="text-left hover:text-[blue]">
                                {{row.email}}
                            </div>
                        </template>
                        <template #images="{ row }">
                            <div v-if="row.images[0]">
                                <img :src="row.images[0]" alt="" class="w-[100%] h-[100px] object-cover">
                            </div>
                            <div v-else></div>
                        </template>
                        <template #title="{ row }">
                            <div class="text-left hover:text-[blue]">
                                {{row.title}}
                            </div>
                        </template>
                        <template #content="{ row }">
                            <div class="text-left hover:text-[blue]">
                                {{row.content}}
                            </div>
                        </template>
                        <template #options="{ row }">
                            <span class="px-[6px] py-[8px] text-[20px] cursor-pointer" @click="showContact(row)">
                                <i class="bi bi-gear-fill"></i>
                            </span>
                            <span class="px-[6px] py-[8px] text-[20px] cursor-pointer" @click="deleteAbout(row)">
                                <i class="bi bi-trash3-fill"></i>
                            </span>
                        </template>
                    </DataTable>
                    <div v-if="tableData.length != 0" class="flex justify-end mt-[32px] mr-[16px]">
                        <Paginate @page-change="handleCurrentPage" :paginate="paginate" :current-page="filterSearch.page || 1"
                        paginate-background/>
                    </div>
                </div>
            </template>
            <ShowFormContact ref="showFormContact"/>
        </template>
    </AppLayoutAdmin>
</template>
<script>
import AppLayoutAdmin from '@/Layouts/AppLayoutAdmin.vue'
import CkeditorPost from '@/Components/Ckeditor/Ckeditor.vue';
import { Link } from '@inertiajs/vue3'
import { ElMessage, ElMessageBox } from 'element-plus'
import DataTable from '@/Components/UI/DataTable.vue'
import Paginate from "@/Components/UI/Paginate.vue"
import axios from 'axios';
import ShowFormContact from '@/Components/AboutUs/ShowContact.vue';


export default{
    components:{
        AppLayoutAdmin,
        Link,
        Paginate,
        DataTable,
        CkeditorPost,
        ShowFormContact
    },
    data() {
        return {
            tab: 'tab-0',
            fields: [
                { key: 'name', label: 'Họ tên', align: 'center', width: 180 },
                { key: 'email', label: 'Email', align: 'center', width: 180 },
                { key: 'title', label: 'Tiêu đề', align: 'center', width: 180 },
                { key: 'content', label: 'Nội dung', align: 'center'},
                { key: 'images', label: 'Hình ảnh', align: 'center', width: 150 },
                { key: 'created_at', label: 'Ngày tạo', align: 'center', width: 150 },
                { key: 'options', label: 'Tùy chỉnh', align: 'center', width: 100 },
            ],
            options: [6, 12, 18],
            filterSearch: {
                limit: 6,
                dateRange: '',
                search: '',
                page: 1
            },
            paginate: [],
            tableData: [],
            selectedValue: [],
            dataForm: {
                title: '',
                content: ''
            },
            errors: []
        }  
    },
    created(){
        this.fetchData()
        document.title = `Quản lý liên hệ - Admin hệ thống`
    },
    methods: {
        fetchData() {
            axios.get(route('admin.get-about-us'))
                .then(response => {
                    this.dataForm.title = response.data.title
                    this.$refs['content'].editorData = response.data.content
                })
        },
        fetchDataList() {
            const pagram = { ...this.filterSearch }
            axios.get(route('admin.get-list-about-us', pagram))
                .then(response => {
                    this.tableData = response.data.data
                    this.paginate = response.data.meta
                })
        },
        updateAboutUs() {
            this.errors = []
            ElMessageBox.confirm(
                    `Bạn có muốn cập nhật thông tin liên hệ không?`,
                    'Warning',
                    {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy bỏ',
                        type: 'warning',
                        draggable: true,
                    }
                )
                .then(() => {
                    const pagram = new FormData()
                    pagram.append('title', this.dataForm.title ?? '')
                    pagram.append('content', this.$refs['content'].editorData ?? '')
                    axios.post(route('admin.update-about-us'), pagram)
                        .then(response => {
                            this.fetchData()
                            ElMessage({
                                type: 'success',
                                message: 'Cập nhật thông tin liên hệ thành công',
                            })
                        })
                        .catch(error => {
                            this.errors = error.response.data.errors
                        })
                })
                .catch(() => {})
        },
        changeTab(tab) {
            this.tab = tab
            if(tab == 'tab-0') {
                this.fetchData()
            }
            else {
                this.fetchDataList()
            }
        },
        handleCurrentPage(value) {
            this.filterSearch.page = value
            this.fetchDataList()
        },
        handleSelectionChange(value) {
            this.selectedValue = value
        },
        deleteAbout(row) {
            ElMessageBox.confirm(
                    `Bạn có muốn xóa liên hệ này không?`,
                    'Warning',
                    {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy bỏ',
                        type: 'warning',
                        draggable: true,
                    }
                )
                .then(() => {
                    axios.delete(route('admin.delete-contact', row.id))
                        .then(response => {
                            this.fetchDataList()
                            ElMessage({
                                type: 'success',
                                message: 'Xóa liên hệ thành công',
                            })
                        })
                        .catch(error => {
                            ElMessage({
                                type: 'error',
                                message: error.response.data.message,
                            })
                        })
                })
                .catch(() => {})
        },
        deleteAbouts() {
            ElMessageBox.confirm(
                    `Bạn có muốn xóa các liên hệ này không?`,
                    'Warning',
                    {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy bỏ',
                        type: 'warning',
                        draggable: true,
                    }
                )
                .then(() => {
                    const pagram = {
                        ...{
                            contactIds: this.selectedValue
                        }
                    }
                    axios.post(route('admin.delete-contacts'), pagram)
                        .then(response => {
                            this.fetchDataList()
                            ElMessage({
                                type: 'success',
                                message: 'Xóa liên hệ thành công',
                            })
                        })
                        .catch(error => {
                            ElMessage({
                                type: 'error',
                                message: error.response.data.message,
                            })
                        })
                })
                .catch(() => {})
        },
        showContact(row) {
            this.$refs.showFormContact.open(row)
        }
    }
}

</script>
  