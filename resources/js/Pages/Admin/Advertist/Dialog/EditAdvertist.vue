<template>
    <el-dialog v-model="dialogVisible" id="edit-advertist" class="bg-[#f4f1f8] max-h-[80%] overflow-y-scroll" width="500px" 
     style="margin-top: 44px !important;" :show-close="true">
        <template #header>
            <div class="text-center font-bold text-[18px]">
                Thêm quảng cáo
            </div>
        </template>
        <div class="mx-[4px] mt-[42px]">
            <div class="mt-[18px] w-[100%]">
                <div class="text-[16px] font-bold text-[#000]">Tên đối tác <span class="text-[red]">*</span></div>
                <el-input class="mt-[2px]" v-model="dataForm.name" placeholder="Nhập tiêu đề" clearable/>
                <div v-if="errors.name" class="mt-[5px] text-[#ff0000]">
                    {{ errors.name[0] }}
                </div>
            </div>
            <div class="mt-[18px] w-[100%]">
                <div class="text-[16px] font-bold text-[#000]">Hình ảnh <span class="text-[red]">*</span></div>
                <div class="w-[280px] mt-[8px]">
                    <template v-if="imageSelected">
                        <el-image
                            style="width: 100%; height: 100%;"
                            :src="imageSelected"
                            :zoom-rate="1.2"
                            preview-teleported="true"
                            hide-on-click-modal="true"
                            :preview-src-list="[imageSelected]"
                            :initial-index="1"
                            fit="cover"
                        />
                    </template>
                    <template v-else>
                        <el-image
                            style="width: 100%; height: 100%;"
                            :src="dataForm.image"
                            :zoom-rate="1.2"
                            preview-teleported="true"
                            hide-on-click-modal="true"
                            :preview-src-list="[dataForm.image]"
                            :initial-index="1"
                            fit="cover"
                        />
                    </template>
                </div>
                <div class="cursor-pointer flex justify-center items-center w-[180px] rounded-[20px]
                  bg-[#007bff] px-[10px] py-[4px] h-[32px] text-[14px] text-white mt-[8px]"
                  @click="this.$refs.file.click()">
                    <input type="file" ref="file" accept=".jpg,.png,.bmp,.jpeg,.tif,.gif" @change="changeImage" hidden>
                    <i class="bi bi-upload text-lg mr-[8px] text-white"></i> Upload hình ảnh
                </div>
                <div v-if="errors.image" class="mt-[5px] text-[#ff0000]">
                    {{ errors.image[0] }}
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
                        @click="editAdvertist">
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
import CkeditorPost from '@/Components/Ckeditor/Ckeditor.vue';
import { ElMessage } from 'element-plus'
import { ElLoading } from 'element-plus'

export default {
    components: {
        Link,
        CkeditorPost
    },
    data() {
        return {
            id: '',
            dialogVisible: false,
            imageSelected: '',
            dataForm: {
                name: ''
            },
            errors: [],
        }
    },
    watch: {
        dialogVisible(value) {
            if(value == false) {
                this.imageSelected = ''
                this.$refs.file = ''
                this.dataForm = {}
                this.errors = []
            }
        }
    },
    methods: {
        async open(id) {
            this.id = id
            this.dialogVisible = true
            const response = await axios.get(route('admin.advertists.show', id))
            this.dataForm = response.data.data
        },
        cancel() {
            this.dialogVisible = false;
        },
        async changeImage(e) {
            try {
                const files = e.target.files || e.dataTransfer.files;
                if (!files.length) return;
                if (files[0].size > 5 * 1024 * 1024) {
                    this.$message.warning(this.$i18n.t('File quá lớn, dung lượng tối đa cho phép 5MB'));
                    return false;
                }

                const nameFile = files[0].name.substring(files[0].name.lastIndexOf('.'));
                const valiFileType = ['.png', '.bmp', '.jpeg', '.tif', '.gif', '.jpg'];
                if (!valiFileType.find((i) => i === nameFile)) {
                    this.$message.warning(
                        this.$i18n.t(`File sai định dạng. Cần thuộc các định dạng sau: `) + valiFileType.join(', ')
                    );

                    return false;
                }
                this.dataForm.image = files[0]
                this.imageSelected = URL.createObjectURL(files[0])
            } catch (err) {
                console.log('handleUploadContent', err);
            }
        },
        async editAdvertist() {
            const pagram = new FormData()
            pagram.append('name', this.dataForm.name ?? '')
            pagram.append('image', this.dataForm.image ?? '')
            await axios.post(route('admin.advertists.update', this.id), pagram)
                .then(response => {
                    ElMessage({
                        showClose: true,
                        message: 'Cập nhật đối tác thành công',
                        type: 'success',
                    })
                    this.dialogVisible = false
                    this.$emit('change-advertist')
                })
                .catch(errors => {
                    this.errors = errors.response.data.errors
                })
        }
    },
}
</script>
<style>
#edit-advertist .el-radio {
    min-width: 220px;
    margin-top: 8px;
}
#edit-advertist .el-dialog__headerbtn {
    font-size: 24px !important;
}
#edit-advertist.el-dialog {
    border-radius: 4px !important;
    position: fixed !important;
    left: 0;
    right: 0;
}
#edit-advertist .el-dialog__header {
    position: fixed;
    width: 500px;
    background-color: #fff;
    border-bottom: 1px solid #ccc;
    margin-right: 0 !important;
}
#edit-advertist .el-select,
#edit-advertist .el-date-editor {
    width: 100% !important;
}
#edit-advertist .el-input__inner {
    margin-top: 2px;
}
#edit-advertist .creator {
    margin: 0 12px;
    padding: 0 12px;
    border-left: 2px solid rgba(0, 0, 0, 0.55);
    border-right: 2px solid rgba(0, 0, 0, 0.55);
}
</style>

