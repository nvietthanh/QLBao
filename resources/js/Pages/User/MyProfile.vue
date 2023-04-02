<template>
    <AppLayout :current-tab="'main-full'">
        <template v-slot:main-full>
            <div class="min-w-[280px] w-[280px]">
                <Navigation :currentTab="'tab-0'"/>
            </div>
            <div class="flex-auto ml-[16px]">
                <div class="py-[20px] bg-[#fff] box-shadow">
                    <div class="border-b-[2px] mb-[8px]">
                        <div class="border-l-[5px] border-[#db562b] text-[#db562b] font-bold ml-[8px] pl-[8px] mb-[12px] text-[17px]">
                            Thông tin tài khoản cá nhân
                        </div>
                    </div>
                    <div class="mx-[22px] mt-[24px]">
                        <div class="text-[16px] font-bold text-[#6c757d] ml-[12px] mb-[18px]">ID: {{ formData.code }}</div>

                        <div class="row gap-y-[12px]">
                            <div class="relative col-4">
                                <div v-if="!imageSelected && !formData.image"  class="bg-[#5c6bc0] w-[226px] h-[226px] rounded-[8px] border-[1px] flex justify-center items-center"
                                  :class="{ 'cursor-pointer': isEditProfile }" @click="changeImage">
                                    <span class="text-[#fff] text-[50px]">{{ formData.first_name[0] }}</span>
                                </div>
                                <img v-else-if="imageSelected" :src="imageSelected" :alt="formData.image" class="w-[226px] h-[226px] rounded-[8px] border-[1px] object-cover"
                                    :class="{ 'cursor-pointer': isEditProfile }" @click="changeImage">
                                <img v-else :src="formData.image" :alt="formData.image" class="w-[226px] h-[226px] rounded-[8px] border-[1px] object-cover"
                                    :class="{ 'cursor-pointer': isEditProfile }" @click="changeImage">
                                
                                <div v-if="isEditProfile" class="absolute top-[12px] right-[24px] z-50">
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
                            <div class="col-6">
                                <div class="flex">
                                    <div class="w-[150px]">
                                        <div class="text-[#000] font-bold text-[14px] mb-[3px]">Họ <span class="text-[red]">*</span>
                                        </div>
                                        <el-input v-model="formData.first_name" placeholder="Họ" class="h-[30px]"
                                            :disabled="!isEditProfile" />
                                    </div>
                                    <div class="w-[150px] ml-[30px]">
                                        <div class="text-[#000] font-bold text-[14px] mb-[3px]">Tên <span class="text-[red]">*</span>
                                        </div>
                                        <el-input v-model="formData.last_name" placeholder="Tên" class="h-[30px]"
                                            :disabled="!isEditProfile" />
                                    </div>
                                </div>
                                <div class="mt-[16px] flex">
                                    <div class="w-[80px] mr-[24px]">
                                        <div class="text-[#000] font-bold text-[14px] mb-[3px]">Giới tính</div>
                                        <el-select v-model="formData.male" placeholder="Giới tính" :disabled="!isEditProfile">
                                            <el-option value="0" label="Nam"/>
                                            <el-option value="1" label="Nữ"/>
                                            <el-option value="2" label="Khác"/>
                                        </el-select>
                                    </div>
                                    <div class="flex-auto">
                                        <div class="text-[#000] font-bold text-[14px] mb-[3px]">Ngày sinh</div>
                                        <el-date-picker
                                            class="mt-[2px] text-[10px]"
                                            v-model="formData.date_of_birth"
                                            type="date"
                                            format="DD-MM-YYYY"
                                            value-format="DD-MM-YYYY"
                                            :default-time="defaultTime"
                                            placeholder="Nhập ngày sinh"
                                            clearable
                                            :disabled="!isEditProfile"
                                        />
                                    </div>
                                </div>
                                <div class="mt-[16px]">
                                    <div class="text-[#000] font-bold text-[14px] mb-[3px]">Số điện thoại</div>
                                    <el-input v-model="formData.phone" placeholder="Số điện thoại" class="h-[30px]"
                                        :disabled="!isEditProfile"/>
                                </div>
                            </div>
                            <div class="col-12 mt-[12px] h-[80px]">
                                <div class="text-[16px] font-bold">Mô tả</div>
                                <el-input v-model="formData.description" type="textarea" placeholder="Mô tả" class="h-[36px] mt-[4px]"
                                    maxlength="255"    
                                    :disabled="!isEditProfile" />
                            </div>
                            <div class="col-12 mt-[12px] h-[170px]">
                                <div class="text-[16px] font-bold">Đánh dấu</div>
                                <el-input v-model="formData.remark" type="textarea" placeholder="Chi tiết comment" class="h-[30px] mt-[4px]"
                                    :autosize="{ minRows: 8 , maxRows: 8}"
                                    :disabled="!isEditProfile" />
                            </div>
                        </div>
                        <div class="pb-[12px] pt-[58px] mr-[34px]" v-if="!isEditProfile">
                            <div class="flex justify-end text-[14px] mr-[24px]">
                                <div class="w-[100px] py-[6px] bg-[#007bff] text-[#fff] text-center rounded-[4px] cursor-pointer"
                                    @click="editProfile">
                                    Chỉnh sửa
                                </div>
                            </div>
                        </div>
                        <div class="pb-[12px] pt-[58px] mr-[34px]" v-else>
                            <div class="flex justify-end text-[14px] mr-[24px]">
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
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3'
import { ElMessage, ElMessageBox } from 'element-plus'
import { h } from 'vue'
import Navigation from '@/Components/User/Navigation.vue'

export default{
    components:{
        AppLayout,
        Link,
        Navigation
    },
    data() {
        return {
            currentTab: 'tab-0',
            isEditProfile: false,
            imageSelected: '',
            fileImage: '',
            formData: {
                id: '',
                first_name: '',
                last_name: '',
                date_of_birth: new Date(),
                male: '',
                phone: '',
                image: '',
                description: '',
                remark: ''
            },
        }  
    },
    created() {
        this.fetchData()
    },
    methods: {
        async fetchData() {
            this.isEditProfile = false
            await axios.get(route('profiles.index'))
                .then(response => {
                    this.formData = response.data.data
                })
                .catch(()=>{})
        },
        cancel() {
            this.fetchData()
            this.imageSelected = ""
            this.fileImage = ""
            this.isEditProfile = false
        },
        editProfile() {
            this.isEditProfile = true
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
            ElMessageBox({
                title: 'Thay đổi thông tin cá nhân',
                message: h('p', null, [
                    h('span', null, 'Bạn có muốn thay đổi thông tin không ?'),
                ]),
                showCancelButton: true,
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy bỏ',
                beforeClose: (action, instance, done) => {
                    if (action === 'confirm') {
                        instance.confirmButtonLoading = true
                        instance.confirmButtonText = 'Loading...'
                        instance.closeForm = false
                        const pagram = new FormData()
                        let image = ""
                        if(this.fileImage) {
                            image = this.fileImage
                        }
                        else{
                            image = this.formData.image
                        }
                        console.log(this.fileImage ?? this.formData.image)
                        pagram.append('first_name', this.formData.first_name)
                        pagram.append('last_name', this.formData.last_name)
                        pagram.append('date_of_birth', this.formData.date_of_birth ?? '')
                        pagram.append('image', image)
                        pagram.append('phone', this.formData.phone ?? '')
                        pagram.append('male', this.formData.male ?? '')
                        pagram.append('description', this.formData.description ?? '')
                        pagram.append('remark', this.formData.remark ?? '')

                        axios.post(route('profiles.update', this.formData.id), pagram)
                            .then(response => {
                                instance.confirmButtonLoading = false
                                done()
                            })
                            .catch(()=>{})
                    } else {
                        done()
                    }
                },
            }).then(() => {
                ElMessage({
                    type: 'success',
                    message: `Thay đổi thông tin cá nhân thành công`,
                })
                this.isEditProfile = 'false'
                location.reload()
            }).catch(() => {})
        }
    }
}

</script>
<style scoped>
.box-shadow {
    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}
</style>
  