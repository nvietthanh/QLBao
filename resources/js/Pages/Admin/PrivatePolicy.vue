<template>
    <AppLayoutAdmin :currentTab="'tab-6'" :currentTabChild="'tab-2'">
        <template v-slot:main-full>
            <div class="mt-[12px] flex text-[18px] font-bold uppercase">
                Chính sách bảo mật
            </div>
            <div class="my-[24px]">
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
            <div class="mb-[24px]">
                <div class="flex justify-end text-[14px] mr-[24px]">
                    <div class="cursor-pointer flex justify-center items-center w-[110px] rounded-[4px] bg-[#ffffff] py-[4px] 
                      h-[32px] text-[15px] text-black border border-[#7d7f92]"  @click="cancel">
                        Hủy bỏ
                    </div>
                    <div class="cursor-pointer flex justify-center items-center w-[110px] ml-[18px] rounded-[4px] bg-[#007bff]
                      py-[4px] h-[32px] text-[15px] text-white" @click="updatePrivatePolicy">
                        Xác nhận
                    </div>
                </div>
            </div>
        </template>
    </AppLayoutAdmin>
</template>
<script>
import AppLayoutAdmin from '@/Layouts/AppLayoutAdmin.vue'
import CkeditorPost from '@/Components/Ckeditor/Ckeditor.vue';
import { Link } from '@inertiajs/vue3'
import { ElMessage, ElMessageBox } from 'element-plus'
import axios from 'axios';

export default{
    components:{
        AppLayoutAdmin,
        Link,
        CkeditorPost
    },
    data() {
        return {
            dataForm: {
                title: '',
                content: ''
            },
            errors: []
        }  
    },
    created(){
        this.fetchData()
        document.title = `Quản lý chính sách bảo mật - Admin hệ thống`
    },
    methods: {
        fetchData() {
            axios.get(route('admin.get-private-policy'))
                .then(response => {
                    this.dataForm.title = response.data.title
                    this.$refs['content'].editorData = response.data.content
                })
        },
        updatePrivatePolicy() {
            this.errors = []
            ElMessageBox.confirm(
                    `Bạn có muốn cập nhật chính sách bảo mật không?`,
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
                    axios.post(route('admin.update-private-policy'), pagram)
                        .then(response => {
                            this.fetchData()
                            ElMessage({
                                type: 'success',
                                message: 'Cập nhật chính sách bảo mật thành công',
                            })
                        })
                        .catch(error => {
                            this.errors = error.response.data.errors
                        })
                })
                .catch(() => {})
        }
    }
}

</script>
  