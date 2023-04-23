<template>
    <el-dialog v-model="dialogVisible" id="show-reply-contact" class="bg-[#f4f1f8] h-[89%] overflow-scroll" width="720px" 
     style="margin-top: 42px !important;" :show-close="true">
        <template #header>
            <div class="text-center font-bold text-[18px]">
                Trả lời liên hệ
            </div>
        </template>
        <div class="flex mt-[24px]">
            <div class="py-[12px] px-[12px] w-[100%]">
                <div class="mt-[12px]">
                    <span class="text-[16px] font-bold">Địa chỉ email:</span>
                    <span class="ml-[12px] text-[15px]">{{ dataForm.email }}</span>
                </div>
                <div class="mt-[12px] w-[100%]">
                    <span class="text-[16px] font-bold">Nội dung câu trả lời:</span>
                    <ckeditor-post class="mt-[8px]" ref="content" :contentProp="content" />
                    <div v-if="errors.content" class="ml-[4px] text-[#ff0000]">
                        {{ errors.content }}
                    </div>
                </div>
            </div>
        </div>
        <template #footer>
            <div class="pb-[12px] pt-[8px]">
                <div class="flex justify-end text-[14px] mr-[24px]">
                    <div class="cursor-pointer text-center w-[160px] ml-[18px] rounded-[4px] bg-[#007bff] h-[38px]
                     leading-[38px] text-[16px] text-white"
                        @click="sendReply()">
                        Gửi
                    </div>
                </div>
            </div>
        </template>
    </el-dialog>
</template>

<script>
import axios from 'axios';
import { Link } from '@inertiajs/vue3'
import moment from "moment";
import { ElMessage, ElMessageBox } from 'element-plus'
import CkeditorPost from '@/Components/Ckeditor/Ckeditor.vue';

export default {
    components:{
        Link,
        CkeditorPost,

    },
    data() {
        return {
            dialogVisible: false,
            dataForm: {},
            content: '',
            errors: []
        }
    },
    watch: {
        dialogVisible(value) {
            if(value == false) {
                this.dataForm = {}
                this.$refs['content'].editorData = ''
                this.errors = []
            }
        }
    },
    methods: {
        moment,
        async open(row) {
            this.dialogVisible = true
            this.dataForm = row
        },
        sendReply() {
            if(this.$refs['content'].editorData) {
                ElMessageBox.confirm(
                        `Bạn có gửi câu trả lời trên cho tài khoản ${this.dataForm.email} không?`,
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
                                content: this.$refs['content'].editorData
                            }
                        }
                        axios.post(route('admin.send-reply-contact', this.dataForm.id), pagram)
                            .then(response => {
                                this.dialogVisible = false
                                this.$emit('update-change')
                                ElMessage({
                                    type: 'success',
                                    message: 'Gửi email thành công',
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
            }
            else {
                this.errors.content = 'Trường nội dung là bắt buộc'
            }
        }
    },
}
</script>
<style>
#show-reply-contact .el-dialog__headerbtn {
    font-size: 24px !important;
}
#show-reply-contact.el-dialog {
    border-radius: 4px !important;
    position: fixed !important;
    left: 0;
    right: 0;
}
#show-reply-contact .el-dialog__header {
    position: fixed;
    max-width: 720px;
    background-color: #fff;
    border-bottom: 1px solid #ccc;
    margin-right: 0 !important;
    z-index: 100;
}
#show-reply-contact .el-select,
#show-reply-contact .el-date-editor {
    width: 100% !important;
}
#show-reply-contact .el-input__inner {
    margin-top: 2px;
}
#show-reply-contact .creator {
    margin: 0 12px;
    padding: 0 12px;
    border-left: 2px solid rgba(0, 0, 0, 0.55);
    border-right: 2px solid rgba(0, 0, 0, 0.55);
}
</style>