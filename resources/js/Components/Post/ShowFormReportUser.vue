<template>
    <el-dialog v-model="dialogVisible" id="show-report-account" class="bg-[#f4f1f8] max-h-[90%] overflow-scroll" width="600px" 
     style="margin-top: 2% !important;" :show-close="true">
        <template #header>
            <div class="text-center font-bold text-[18px]">
                Báo cáo vi phạm
            </div>
        </template>
        <div class="flex mt-[38px]">
            <div class="py-[12px] px-[32px]">
                <div>
                    <div class="text-[16px] font-bold">Hãy chọn vấn đề:</div>
                    <div class="py-[12px]">
                        <el-checkbox class="w-[100%] mb-[8px]" v-model="dataForm.content" label="Spam" size="large" border />
                        <el-checkbox class="w-[100%] mb-[8px]" v-model="dataForm.content" label="Chứa nội dung bạo lực" size="large" border />
                        <el-checkbox class="w-[100%] mb-[8px]" v-model="dataForm.content" label="Ngôn từ gây thù ghét" size="large" border />
                        <el-checkbox class="w-[100%] mb-[8px]" v-model="dataForm.content" label="Khủng bố" size="large" border />
                        <el-checkbox class="w-[100%] mb-[8px]" v-model="dataForm.content" label="Thông tin sai sự thật" size="large" border />
                        <el-checkbox class="w-[100%] mb-[8px]" v-model="dataForm.content" label="Quấy rối" size="large" border />
                        <el-checkbox class="w-[100%] mb-[8px]" v-model="isDefault" label="Khác" size="large" border />
                        <div v-if="isDefault" class="flex items-top mt-[4px]">
                            <span class="ml-[12px] mt-[8px] w-[210px]">Nhập nội dung khác:</span>
                            <el-input v-model="dataForm.defaultContent" type="textarea" :autosize="{ minRows: 3, maxRows: 5 }"
                             placeholder="Nhập nội dung" />
                        </div>
                    </div>
                    <div class="text-[16px] font-bold">Thêm hình ảnh bổ sung:</div>
                    <div class="py-[12px]">
                        <el-upload v-model:file-list="dataForm.images"
                            list-type="picture-card" :auto-upload="false"
                            :multiple="true"
                            :on-preview="handlePictureCardPreview">
                            <el-icon><Plus /></el-icon>
                        </el-upload>
                        <el-dialog id="showImage" v-model="dialogVisiblePreview">
                            <div class="flex justify-center">
                                <img class="max-h-[500px] object-cover" :src="dialogImageUrl" alt="Preview Image" />
                            </div>
                        </el-dialog>
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
                        @click="sendReport">
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
            isDefault: false,
            dialogVisiblePreview: false,
            dialogImageUrl: '',
            postId: '',
            dataForm: {
                images: [],
                defaultContent: '',
                content: []
            }
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
            this.dataForm.images = []
            this.dataForm.defaultContent = ''
            this.dataForm.content = []
            this.isDefault = false
            this.dialogVisiblePreview = false
            this.postId = ''
            this.dialogImageUrl = ''
        },
        async open(id) {
            this.dialogVisible = true
            this.postId = id
        },
        handlePictureCardPreview(file) {
            this.dialogImageUrl = file.url
            this.dialogVisiblePreview = true
        },
        async sendReport() {
            if(this.dataForm.content.length == 0 && !this.dataForm.defaultContent) {
                ElMessage({
                    type: 'warning',
                    message: `Vui lòng chọn nội dung báo cáo vi phạm`,
                })
            }
            else {
                const pagram = new FormData()
                this.dataForm.content.push(this.dataForm.defaultContent)
                pagram.append('content', this.dataForm.content)
                for(let image of this.dataForm.images) {
                    pagram.append('images[]', image.raw)
                }
                await axios.post(route('report-account', this.postId), pagram)
                    .then(response => {
                        this.dialogVisible = false
                        this.clearData()
                        ElMessage({
                            type: 'success',
                            message: `Báo cáo vi phạm thành công`,
                        })
                    })
                    .catch(() => {})
            }
        },
        cancel() {
            this.clearData()
            this.dialogVisible = false
        }
    },
}
</script>
<style>
#show-report-account .el-dialog__headerbtn {
    font-size: 24px !important;
}
#show-report-account.el-dialog {
    border-radius: 4px !important;
    position: fixed !important;
    left: 0;
    right: 0;
}
#showImage > .el-dialog__header {
    border-bottom: none !important;
}
#show-report-account > .el-dialog__header {
    position: fixed;
    width: 600px;
    background-color: #fff;
    border-bottom: 1px solid #ccc;
    margin-right: 0 !important;
    z-index: 100;
}
#show-report-account .el-select,
#show-report-account .el-date-editor {
    width: 100% !important;
}
#show-report-account .el-input__inner {
    margin-top: 2px;
}
#show-report-account .creator {
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

