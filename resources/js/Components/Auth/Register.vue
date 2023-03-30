<template>
    <el-dialog v-model="dialogVisible" class="bg-[#f4f1f8]" width="740px" style="margin-top: 52px !important;" :show-close="false">
            <template #header>
                <div class="text-center font-bold text-[17px]">
                    Đăng ký tài khoản
                </div>
            </template>
            <div class="flex">
                <div class="px-[24px] w-[400px]">
                    <el-form class="" @keyup.enter.prevent="register">
                        <div class="flex items-start">
                            <div>
                                <div class="font-bold text-[#000]">Họ <span class="text-[red]">*</span></div>
                                <el-input class="mt-[2px]" v-model="dataInfor.first_name" placeholder="Họ" clearable/>
                                <div v-if="errors.first_name" class="mt-[5px] text-[13px] text-[#ff0000]">
                                    {{ errors.first_name[0] }}
                                </div>
                            </div>
                            <div class="ml-[32px]">
                                <div class="font-bold text-[#000]">Tên <span class="text-[red]">*</span></div>
                                <el-input class="mt-[2px]" v-model="dataInfor.last_name" placeholder="Tên" clearable/>
                                <div v-if="errors.last_name" class="mt-[5px] text-[13px] text-[#ff0000]">
                                    {{ errors.last_name[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-[18px]">
                            <div class="font-bold text-[#000]">Email <span class="text-[red]">*</span></div>
                            <el-input class="mt-[2px]" v-model="dataInfor.email" placeholder="Nhập email" clearable/>
                            <div v-if="errors.email" class="mt-[5px] text-[13px] text-[#ff0000]">
                                {{ errors.email[0] }}
                            </div>
                        </div>
                        <div class="flex mt-[18px]">
                            <div class="flex-auto">
                                <div class="font-bold text-[#000]">Ngày sinh</div>
                                <el-date-picker
                                    class="mt-[2px] text-[10px]"
                                    v-model="dataInfor.date_of_birth"
                                    type="date"
                                    format="DD-MM-YYYY"
                                    value-format="DD-MM-YYYY"
                                    placeholder="Nhập ngày sinh"
                                    clearable
                                />
                                <div v-if="errors.date_of_birth" class="mt-[5px] text-[13px] text-[#ff0000]">
                                    {{ errors.date_of_birth[0] }}
                                </div>
                            </div>
                            <div class="w-[120px] ml-[32px]">
                                <div class="font-bold text-[#000]">Giới tính</div>
                                <el-select class="mt-[2px]" v-model="dataInfor.male" placeholder="Giới tính">
                                    <el-option value="0" label="Nam"/>
                                    <el-option value="1" label="Nữ"/>
                                    <el-option value="2" label="Khác"/>
                                </el-select>
                            </div>
                        </div>
                        <div class="mt-[18px]">
                            <div class="font-bold text-[#000]">Số điện thoại</div>
                            <el-input class="mt-[2px]" v-model="dataInfor.phone" placeholder="Nhập số điện thoại" show-password/>
                            <div v-if="errors.phone" class="mt-[5px] text-[13px] text-[#ff0000]">
                                {{ errors.phone[0] }}
                            </div>
                        </div>
                        <div class="mt-[18px]">
                            <div class="font-bold text-[#000]">Mật khẩu <span class="text-[red]">*</span></div>
                            <el-input class="mt-[2px]" v-model="dataInfor.password" placeholder="Nhập mật khẩu" show-password/>
                            <div v-if="errors.password" class="mt-[5px] text-[13px] text-[#ff0000]">
                                {{ errors.password[0] }}
                            </div>
                        </div>
                        <div class="mt-[18px]">
                            <div class="font-bold text-[#000]">Xác nhận mật khẩu <span class="text-[red]">*</span></div>
                            <el-input class="mt-[2px]" v-model="dataInfor.confirm_password" placeholder="Nhập mật khẩu" show-password/>
                            <div v-if="errors.confirm_password" class="mt-[5px] text-[13px] text-[#ff0000]">
                                {{ errors.confirm_password[0] }}
                            </div>
                        </div>
                    </el-form>
                </div>
                <div class="flex flex-auto justify-center items-center">
                    <div class="pt-[32px] w-[220px]">
                        <img src="\image\register.png" alt="" class="w-[180px] ml-[22px]">
                        <div class="text-center text-[16px]">Đăng ký tài khoản để có trải nghiệm tốt nhất</div>
                    </div>
                </div>
            </div>
            <template #footer>
                <div class="pb-[12px] pt-[8px]">
                    <div class="flex justify-center items-center">
                        <div @click="close"
                            class="cursor-pointer flex justify-center items-center gap-1  w-[120px] rounded-[8px] bg-[#ffffff] py-[4px] h-[32px] text-[15px] text-black border border-[#7d7f92]">
                            Hủy bỏ
                        </div>
                        <div
                            class="cursor-pointer flex justify-center items-center gap-1  w-[120px] ml-[12px] rounded-[8px] bg-[#007bff] py-[4px] h-[32px] text-[15px] text-white"
                            @click="register">
                            Xác nhận
                        </div>
                    </div>
                </div>
            </template>
    </el-dialog>
</template>

<script>
import axios from 'axios';
import { ElMessage } from 'element-plus'

export default {
    data() {
        return {
            dialogVisible: false,
            dataInfor: {
                first_name: '',
                last_name: '',
                male: '0',
                date_of_birth: '',
                email: '',
                phone: '',
                password: '',
                confirm_password: ''
            },
            errors: []
        }
    },
    watch: {
        dialogVisible(value) {
            if(value == false) {
                this.clearResult()
            }
        }
    },
    methods: {
        clearResult() {
            this.dataInfor.first_name = ''
            this.dataInfor.last_name = ''
            this.dataInfor.male = '0'
            this.dataInfor.date_of_birth = ''
            this.dataInfor.email = ''
            this.dataInfor.phone = ''
            this.dataInfor.password = ''
            this.dataInfor.confirm_password = ''
            this.errors = []
        },
        open() {
            this.dialogVisible = true;
            this.clearResult()
        },
        close() {
            this.dialogVisible = false
        },
        async register() {
            const pagram = { ...this.dataInfor }
            await axios.post(route('guest.resgister'), pagram)
                .then(respose => {
                    ElMessage({
                        showClose: true,
                        message: 'Đăng ký tài khoản thành công',
                        type: 'success',
                    })
                    this.dialogVisible = false
                    this.$emit('register')
                })
                .catch(errors => {
                    this.errors = errors.response.data.errors
                    console.log(errors.response.data.errors)
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

