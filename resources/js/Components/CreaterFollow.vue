<template>
    <div class="border-b-[2px] mb-[8px]">
        <div class="border-l-[5px] border-[#db562b] text-[#db562b] font-bold ml-[8px] pl-[8px] mb-[12px] text-[17px]">
        Thông tin tài khoản cá nhân
        </div>
    </div>
    <div class="flex ml-[22px] mt-[38px]">
        <div class="relative">
            <div v-if="!this.imageSelected && !this.formData.img"  class="w-[200px] h-[200px] border-[1px] flex justify-center items-center"
            :class="{ 'cursor-pointer': currentTab != 'tab-0', ' bg-[#5c6bc0]' : formData.male == '0',
            'bg-[#9f2348]' : formData.male == '1', 'bg-[#8d98d6]' : formData.male == '2' }" 
            @click="changeImage">
                <span class="text-[#fff] text-[50px]">{{ formData.firstname[0] }}</span>
            </div>
            <img v-else-if="this.imageSelected == ''" :src="this.formData.img" alt="1" class="w-[200px] h-[200px] border-[1px]"
                :class="{ 'cursor-pointer': currentTab != 'tab-0' }" @click="changeImage">
            <img v-else :src="this.imageSelected" alt="2" class="w-[200px] h-[200px] border-[1px]"
                :class="{ 'cursor-pointer': currentTab != 'tab-0' }" @click="changeImage">
            
            <div v-if="currentTab != 'tab-0'" class="absolute top-[12px] right-[12px] z-50">
                <div v-if="this.imageSelected || this.formData.img" class="bg-[#fff] py-[3px] px-[5px] text-[#000] 
                    text-[15px] rounded-[6px] mb-[8px] cursor-pointer hover:bg-[#ced4da]" @click="deleteImage">
                    <i class="bi bi-trash3"></i>
                </div>
                <div class="bg-[#fff] py-[3px] px-[5px] text-[#000] 
                    text-[15px] rounded-[6px] cursor-pointer hover:bg-[#ced4da]" @click="changeImage">
                    <i class="bi bi-camera"></i>
                </div>
            </div>

            <input v-show="false" ref="file" type="file" @change="handleUploadContent"
                accept=".jpg,.png,.bmp,.jpeg,.tif,.gif" />
        </div>
        <div class="ml-[24px]">
            <div class="flex">
                <div class="w-[150px]">
                    <div class="text-[#000] font-bold text-[14px] mb-[3px]">Họ <span class="text-[red]">*</span>
                    </div>
                    <el-input v-if="currentTab == 'tab-0'" v-model="formData.firstname" placeholder="Họ" class="h-[30px]"
                        disabled />
                    <el-input v-else v-model="formData.firstname" placeholder="Họ" class="h-[30px]" />
                </div>
                <div class="w-[150px] ml-[30px]">
                    <div class="text-[#000] font-bold text-[14px] mb-[3px]">Tên <span class="text-[red]">*</span>
                    </div>
                    <el-input v-if="currentTab == 'tab-0'" v-model="formData.lastname" placeholder="Tên" class="h-[30px]"
                        disabled />
                    <el-input v-else v-model="formData.lastname" placeholder="Tên" class="h-[30px]" />
                </div>
            </div>
            <div class="mt-[16px] w-[100px]">
                <div class="text-[#000] font-bold text-[14px] mb-[3px]">Giới tính</div>
                <el-select v-if="currentTab == 'tab-0'" v-model="formData.male" placeholder="Giới tính" disabled>
                    <el-option value="0" label="Nam"/>
                    <el-option value="1" label="Nữ"/>
                    <el-option value="2" label="Khác"/>
                </el-select>
                <el-select v-else v-model="formData.male" placeholder="Select">
                    <el-option value="0" label="Nam"/>
                    <el-option value="1" label="Nữ"/>
                    <el-option value="2" label="Khác"/>
                </el-select>
            </div>
            <div class="mt-[16px]">
                <div class="text-[#000] font-bold text-[14px] mb-[3px]">Số điện thoại</div>
                <el-input v-if="currentTab == 'tab-0'" v-model="formData.phone" placeholder="Số điện thoại" class="h-[30px]"
                    disabled />
                <el-input v-else v-model="formData.phone" placeholder="Số điện thoại" class="h-[30px]" />
            </div>
        </div>
    </div>
    <div class="pb-[12px] pt-[58px] mr-[34px]" v-if="currentTab == 'tab-0'">
        <div class="flex justify-end text-[14px] mr-[24px]">
            <div class="w-[100px] py-[6px] bg-[#007bff] text-[#fff] h-[32px] text-center rounded-[4px] cursor-pointer active:scale-95"
                @click="editProfile">
                Chỉnh sửa
            </div>
        </div>
    </div>
    <div class="pb-[12px] pt-[58px] mr-[34px]" v-else>
        <div class="flex justify-end text-[14px] mr-[24px]">
            <div @click="cancel"
                class="cursor-pointer flex justify-center items-center w-[110px] rounded-[4px] bg-[#ffffff] py-[4px] h-[32px] text-[15px] text-black border border-[#7d7f92]">
                Hủy bỏ
            </div>
            <div class="cursor-pointer flex justify-center items-center w-[110px] ml-[18px] rounded-[4px] bg-[#007bff] py-[4px] h-[32px] text-[15px] text-white"
                @click="changeProfile">
                Xác nhận
            </div>
        </div>
    </div>
</template>
<script>
import { useForm } from '@inertiajs/inertia-vue3'
import { h } from 'vue'
import { ElMessage, ElMessageBox } from 'element-plus'

export default {
    data() {
        return {
            currentTab: 'tab-0',
            imageSelected: '',
            formData: useForm({
                firstname: '',
                lastname: '',
                male: '0',
                phone: '',
                img: '',
            }),
        }  
    },
    created() {
        this.fetchData()
    },
    methods: {
        fetchData() {
            this.currentTab = 'tab-0'
            this.imageSelected = '/image/avatar.jpg'
            this.formData.firstname = 'Nguyễn Viết'
            this.fetchData.lastname = 'Thanh'
            this.formData.male = '0'
            this.formData.phone = '0358387102'
            this.formData.img = ''
        },
        cancel() {
            this.currentTab = 'tab-0'
        },
        editProfile() {
            this.currentTab = 'tab-1'
        },
        changeImage() {
            if(this.currentTab != 'tab-0') { 
                this.$refs.file.click()
            }
        },
        deleteImage() {
            this.imageSelected = ""
            this.formData.img = ""
            this.$refs.file = ""
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
                this.formData.img = files[0]
                this.imageSelected = URL.createObjectURL(files[0])
            } catch (err) {
                console.log('handleUploadContent', err);
            }
        },
        changeProfile() {
            console.log(this.imageSelected)
            console.log(this.formData.img)
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
                        setTimeout(() => {
                            instance.confirmButtonLoading = false
                            done()
                        }, 3000)
                    } else {
                        done()
                    }
                },
            }).then(() => {
                ElMessage({
                    type: 'success',
                    message: `Thay đổi thông tin cá nhân thành công`,
                })
                this.currentTab = 'tab-0'
            }).catch(() => {})
        }
    }
}
</script>