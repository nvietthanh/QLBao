<template>
    <el-dialog v-model="dialogVisible" class="bg-[#f4f1f8]" width="400" style="margin-top: 52px !important;" :show-close="false">
            <template #header>
                <div class="text-center font-bold text-[17px]">
                    Thông tin cá nhân
                </div>
            </template>
            <div class="mx-auto">
                <div class="w-[226px] mx-auto">
                    <div class="relative">
                        <div v-if="!imageSelected && !formData.image"  class="bg-[#5c6bc0] w-[226px] h-[226px] rounded-[8px] border-[1px] flex justify-center items-center"
                            :class="{ 'cursor-pointer': isEditProfile }" @click="changeImage">
                            <span class="text-[#fff] text-[50px]">{{ formData.name[0] }}</span>
                        </div>
                        <img v-else-if="imageSelected" :src="imageSelected" :alt="formData.image" class="w-[226px] h-[226px] rounded-[8px] border-[1px] object-cover"
                            :class="{ 'cursor-pointer': isEditProfile }" @click="changeImage">
                        <img v-else :src="formData.image" :alt="formData.image" class="w-[226px] h-[226px] rounded-[8px] border-[1px] object-cover"
                            :class="{ 'cursor-pointer': isEditProfile }" @click="changeImage">
                        
                        <div v-if="isEditProfile" class="absolute top-[12px] right-[8px] z-50">
                            <div v-if="formData.image || imageSelected" class="bg-[#fff] py-[2px] px-[6px] text-[#000] 
                            text-[15px] rounded-[6px] mb-[8px] cursor-pointer hover:bg-[#ced4da]" @click="deleteImage">
                                <i class="bi bi-trash3"></i>
                            </div>
                            <div class="bg-[#fff] py-[2px] px-[6px] text-[#000] 
                            text-[15px] rounded-[6px] cursor-pointer hover:bg-[#ced4da]" @click="changeImage">
                                <i class="bi bi-camera"></i>
                            </div>
                        </div>
                        <input v-show="false" ref="file" type="file" @change="handleUploadContent"
                            accept=".jpg,.png,.bmp,.jpeg,.tif,.gif" />
                    </div>
                </div>
                <div class="mx-auto">
                    <div class="ml-[66px] ml-[24px] mt-[24px] w-[150px]">
                        <div class="text-[#000] font-bold text-[14px] mb-[3px]">Tên tài khoản <span class="text-[red]">*</span>
                        </div>
                        <el-input v-model="formData.name" placeholder="Họ" class="h-[30px]"
                            :disabled="!isEditProfile" />
                    </div>
                </div>
            </div>
            <div class="pb-[12px] pt-[58px] mr-[8px]" v-if="!isEditProfile">
                <div class="flex justify-end text-[14px]">
                    <div class="w-[100px] py-[6px] bg-[#007bff] text-[#fff] text-center rounded-[4px] cursor-pointer"
                        @click="editProfile">
                        Chỉnh sửa
                    </div>
                </div>
            </div>
            <div class="pb-[12px] pt-[58px]" v-else>
                <div class="flex justify-end text-[14px]">
                    <div @click="cancel"
                        class="cursor-pointer flex justify-center items-center w-[110px] rounded-[4px] bg-[#ffffff] py-[4px] text-[15px] text-black border border-[#7d7f92]">
                        Hủy bỏ
                    </div>
                    <div class="cursor-pointer flex justify-center items-center w-[110px] ml-[18px] rounded-[4px] bg-[#007bff] py-[4px] text-[15px] text-white"
                        @click="changeProfile">
                        Xác nhận
                    </div>
                </div>
            </div>
    </el-dialog>
</template>

<script>
import axios from 'axios';
import { ElMessage } from 'element-plus'

export default {
    data() {
        return {
            dialogVisible: false,
            formData: {
                name: '',
                image: ''
            },
            imageSelected: '',
            fileImage: '',
            isEditProfile: false,
            errors: []
        }
    },
    methods: {
        open() {
            this.dialogVisible = true;
            this.formData.name = this.$page.props.auth.user.name
            this.formData.image = this.$page.props.auth.user.profile_photo_path
        },
        close() {
            this.dialogVisible = false
        },
        editProfile() {
            this.isEditProfile = true
        },
        cancel() {
            this.formData.name = this.$page.props.auth.user.name
            this.formData.image = this.$page.props.auth.user.profile_photo_path
            this.isEditProfile = false
        },
        changeImage() {
            if(this.isEditProfile) { 
                this.$refs.file.click()
            }
        },
        deleteImage() {
            if(this.formData.image && !this.imageSelected) {
                this.formData.image = ""
            }
            else{
                this.imageSelected = ""
                this.fileImage = ""
            }
        },
        async handleUploadContent(e) {
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
                this.fileImage = files[0]
                this.imageSelected = URL.createObjectURL(files[0])
            } catch (err) {
                console.log('handleUploadContent', err);
            }
        },
        changeProfile() {
            const pagram = new FormData()
            let image = ""
            if(this.fileImage) {
                image = this.fileImage
            }
            else{
                image = this.formData.image
            }
            pagram.append('name', this.formData.name ?? '')
            pagram.append('image', image)

            axios.post(route('admin.update-profile'), pagram)
                .then(response => {
                    ElMessage({
                        type: 'success',
                        message: `Thay đổi thông tin cá nhân thành công`,
                    })
                    this.isEditProfile = 'false'
                    location.reload()
                })
                .catch(()=>{
                    ElMessage({
                        type: 'error',
                        message: `Thay đổi thông tin không thành công`,
                    })
                })
        }
    },
}
</script>
<style>
.el-dialog {
    border-radius: 4px !important;
}
.el-dialog__header {
    border-bottom: 1px solid #ccc;
    margin-right: 0 !important;
}
.el-select,
.el-date_of_birth-editor {
    width: 100% !important;
}
.el-input__inner {
    margin-top: 2px;
}
</style>

