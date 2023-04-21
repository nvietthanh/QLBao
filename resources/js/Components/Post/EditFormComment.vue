<template>
    <el-dialog v-model="dialogVisible" id="show-edit-comment" class="bg-[#f4f1f8] max-h-[90%] overflow-scroll" width="620px" 
     style="margin-top: 10% !important;" :show-close="true">
        <template #header>
            <div class="text-center font-bold text-[18px]">
                Chỉnh sửa bình luận
            </div>
        </template>
        <div class="mt-[38px]">
            <div class="py-[12px] px-[32px]">
                <div>
                    <div class="text-[16px] font-bold">Bình luận:</div>
                    <div class="py-[12px] w-[100%]">
                        <el-input v-model="dataForm.content" type="textarea" :autosize="{ minRows: 4, maxRows: 5 }"
                             placeholder="Nhập nội dung" />
                    </div>
                </div>
            </div>
        </div>
        <template #footer>
            <div class="pb-[12px] pt-[8px]">
                <div class="flex justify-end text-[14px] mr-[24px]">
                    <div @click="cancel"
                        class="cursor-pointer flex justify-center items-center w-[110px] rounded-[4px] bg-[#ffffff] py-[4px] h-[32px] text-[15px] text-black border border-[#7d7f92]">
                        Hủy bỏ
                    </div>
                    <div class="cursor-pointer flex justify-center items-center w-[110px] ml-[18px] rounded-[4px] bg-[#007bff] py-[4px] h-[32px] text-[15px] text-white"
                        @click="saveComment()">
                        Xác nhận
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
import { Delete, Download, Plus, ZoomIn } from '@element-plus/icons-vue'
import { ElMessage, ElMessageBox } from 'element-plus'

export default {
    components:{
        Link,
        Delete, Download, Plus, ZoomIn
    },
    data() {
        return {
            dialogVisible: false,
            dataForm: {}
        }
    },
    watch: {
        dialogVisible(value) {
            if(value == false) {
                this.clearData()
            }
        }
    },
    methods: {
        moment,
        clearData() {
            this.dataForm = {}
        },
        async open(id) {
            this.dialogVisible = true
            axios.get(route('get-comment', id))
                .then(response => {
                    this.dataForm = response.data.data
                })
        },
        cancel() {
            this.dialogVisible = false
            this.dataForm = {}
        },
        saveComment() {
            const pagram = {
                ...{
                    content: this.dataForm.content
                }
            }
            axios.post(route('update-comment', this.dataForm.id), pagram)
                .then(response => {
                    this.dialogVisible = false
                    this.$emit('change-update')
                    ElMessage({
                        type: 'success',
                        message: 'Cập nhật bình luận thành công',
                    })
                })
                .catch(error => {
                    ElMessage({
                        type: 'error',
                        message: error.response.data.message,
                    })
                })
        }
    },
}
</script>
<style>
#show-edit-comment .el-dialog__headerbtn {
    font-size: 24px !important;
}
#show-edit-comment.el-dialog {
    border-radius: 4px !important;
    position: fixed !important;
    left: 0;
    right: 0;
}
#showImage > .el-dialog__header {
    border-bottom: none !important;
}
#show-edit-comment > .el-dialog__header {
    position: fixed;
    width: 620px;
    background-color: #fff;
    border-bottom: 1px solid #ccc;
    margin-right: 0 !important;
    z-index: 100;
}
#show-edit-comment .el-select,
#show-edit-comment .el-date-editor {
    width: 100% !important;
}
#show-edit-comment .el-input__inner {
    margin-top: 2px;
}
#show-edit-comment .creator {
    margin: 0 12px;
    padding: 0 12px;
    border-left: 2px solid rgba(0, 0, 0, 0.55);
    border-right: 2px solid rgba(0, 0, 0, 0.55);
}
.el-upload-list--picture-card .el-upload-list__item-thumbnail {
    width: 100%;
    object-fit: cover;
}
</style>

