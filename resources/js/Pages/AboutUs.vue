<template>
    <AppLayout :current-tab="'main-full'">
        <template v-slot:main-full>
            <div class="box-shadow mx-auto mb-[24px] w-[940px] bg-[#fff] border-[2px] rounded-[5px]">
                <div class="mx-[12px] mt-[8px]">
                    <div class="row p-[12px] mb-[48px]">
                        <div class="col-8 text-[18px]">
                            <div class="uppercase font-bold">Liên hệ soạn báo mới</div>
                            <div class="mx-[4px] mt-[12px] text-[15px] flex items-center">
                                <div class="min-w-[130px]">Họ và tên <span class="text-[red]">*</span></div>
                                <el-input
                                    v-model="dataForm.name"
                                    class="m-[6px]"
                                    size="large"
                                    placeholder="Nhập họ và tên"
                                />
                            </div>
                            <div v-if="errors.name" class="ml-[150px] text-[#ff0000] text-[14px]">
                                {{ errors.name[0] }}
                            </div>
                            <div class="mx-[4px] mt-[8px] text-[15px] flex items-center">
                                <div class="min-w-[130px]">Email <span class="text-[red]">*</span></div>
                                <el-input
                                    v-model="dataForm.email"
                                    class="m-[6px]"
                                    size="large"
                                    placeholder="Nhập email"
                                />
                            </div>
                            <div v-if="errors.email" class="ml-[150px] text-[#ff0000] text-[14px]">
                                {{ errors.email[0] }}
                            </div>
                            <div class="mx-[4px] mt-[8px] text-[15px] flex items-center">
                                <div class="min-w-[130px]">Tiêu đề <span class="text-[red]">*</span></div>
                                <el-input
                                    v-model="dataForm.title"
                                    class="m-[6px]"
                                    size="large"
                                    placeholder="Nhập tiêu đề"
                                />
                            </div>
                            <div v-if="errors.title" class="ml-[150px] text-[#ff0000] text-[14px]">
                                {{ errors.title[0] }}
                            </div>
                            <div class="mx-[4px] mt-[8px] text-[15px] flex items-start">
                                <div class="min-w-[130px]">Ảnh đính kèm <span class="text-[red]">*</span></div>
                                <div class="mx-[8px]">
                                    <el-upload
                                        v-model:file-list="dataForm.images"
                                        list-type="picture"
                                        :auto-upload="false"
                                        multiple
                                        class="max-w-[100%]"
                                    >
                                        <el-button type="primary">Chọn ảnh</el-button>
                                    </el-upload>
                                </div>
                            </div>
                            <div class="mx-[4px] mt-[8px] text-[15px] flex items-center">
                                <div class="min-w-[130px]">Nội dung <span class="text-[red]">*</span></div>
                                <el-input
                                    v-model="dataForm.content"
                                    class="m-[6px]"
                                    size="large"
                                    type="textarea"
                                    :autosize="{ minRows: 6, maxRows: 8 }"
                                    placeholder="Nhập nội dung"
                                />
                            </div>
                            <div v-if="errors.content" class="ml-[150px] text-[#ff0000] text-[14px]">
                                {{ errors.content[0] }}
                            </div>
                            <div class="flex justify-end mr-[24px] mt-[18px]">
                                <div class="cursor-pointer text-center w-[110px] ml-[18px] rounded-[4px] bg-[#007bff] py-[4px] h-[32px]
                                 text-[15px] text-white" @click="sendContact()">
                                    Xác nhận
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="uppercase font-bold">Thông tin tòa soạn</div>
                            <img src="/image/lien-he-toa-soan.png" class="my-[18px]">
                            <div class="mx-[4px] text-[14px]">
                                <div class="font-bold" v-html="aboutData.title"></div>
                                <div class="mt-[12px]" v-html="aboutData.content"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ElMessage, ElMessageBox } from 'element-plus'
import { Link } from '@inertiajs/vue3'
import axios from 'axios';

export default{
    components:{
        AppLayout,
        Link,
    },
    data() {
        return {
            aboutData: {
                title: '',
                content: ''
            },
            dataForm: {
                name: '',
                email: '',
                images: [],
                title: '',
                content: ''
            },
            errors: []
        }  
    },
    created() {
        this.fetchData()
        document.title = `Liên hệ - Báo mới`
    },
    methods: {
        fetchData() {
            axios.get(route('get-about-us'))
                .then(response => {
                    this.aboutData.title = response.data.title
                    this.aboutData.content = response.data.content
                })
        },
        sendContact() {
            ElMessageBox.confirm(
                    `Bạn có muốn gửi liên hệ không?`,
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
                    pagram.append('name', this.dataForm.name ?? '')
                    pagram.append('email', this.dataForm.email ?? '')
                    pagram.append('title', this.dataForm.title ?? '')
                    for(let item of this.dataForm.images) {
                        pagram.append('images[]', item.raw)
                    }
                    pagram.append('content', this.dataForm.content ?? '')
                    axios.post(route('send-contact'), pagram)
                        .then(response => {
                            this.fetchData()
                            this.errors = []
                            ElMessage({
                                type: 'success',
                                message: 'Gửi liên hệ thành công',
                            })
                        })
                        .catch(error => {
                            this.errors = error.response.data.errors
                        })
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
}

</script>
<style scoped>
</style>
  