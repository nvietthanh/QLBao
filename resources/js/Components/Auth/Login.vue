<template>
    <el-dialog v-model="dialogVisible" width="580px" class="bg-[#f4f1f8]" :show-close="false">
        <template #header>
            <div class="text-center font-bold text-[18px]">
                {{ title }}
            </div>
        </template>
        <div v-if="currentTab == 'login'">
            <el-form class="main-input px-5 pt-2" @keyup.enter.prevent="login">
                <div class="flex items-center">
                    <div class="w-[137px] font-bold text-[#000]">Tên đăng nhập</div>
                    <div class="flex-auto">
                        <el-input v-model="user.email" placeholder="Nhập email hoặc tên đăng nhập" clearable/>
                    </div>
                </div>
                <div v-if="errors.email" class="mt-[5px] ml-[138px] text-[#ff0000]">
                    {{ errors.email }}
                </div>
                <div class="flex items-center mt-3">
                    <div class="w-[137px] font-bold text-[#000]">Mật khẩu</div>
                    <div class="flex-auto">
                        <el-input v-model="user.password" placeholder="Nhập mật khẩu" show-password/>
                    </div>
                </div>
                <div v-if="errors.password" class="mt-[5px] ml-[138px] text-[#ff0000]">
                    {{ errors.password }}
                </div>
                <div class="mt-[20px] text-center hover:text-[#17a2b8] text-[#000] cursor-pointer" @click="forgotPassword">
                    Quên mật khẩu?
                </div>
            </el-form>
        </div>
        <div v-else-if="currentTab == 'send-otp'">
            <div class="mx-[12px]">
                <div class="text-[15px] font-bold text-[#000]">Vui lòng nhập email bạn đăng ký trên hệ thống</div>
                <div class="mx-[24px] mt-[12px]">
                    <el-input v-model="forgotUser.email" placeholder="Vui lòng nhập email" clearable @keyup.enter.prevent="sendMailOTP"/>
                    <div v-if="errors.email" class="mt-[5px] text-[#ff0000]">
                        {{ errors.email[0] }}
                    </div>
                </div>
            </div>
        </div>
        <div v-else-if="currentTab == 'check-otp'">
            <div class="mx-[12px]">
                <div class="text-[15px] font-bold text-[#000]">Vui lòng check email và nhập mã xác nhận được gửi cho bạn:</div>
                <div class="mx-[24px] mt-[12px]">
                    <el-input v-model="forgotUser.otp" placeholder="Nhập mã xác thực" clearable @keyup.enter.prevent="checkOTP"/>
                    <div v-if="errors.otp" class="mt-[5px] text-[#ff0000]">
                        {{ errors.otp[0] }}
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="main-input px-5 pt-2">
                <div class="flex items-center">
                    <div class="flex-auto font-bold text-[#000] text-right mr-[18px]">Mật khẩu mới</div>
                    <div class="w-[290px]">
                        <el-input v-model="forgotUser.password" placeholder="Nhập mật khẩu" clearable/>
                    </div>
                </div>
                <div v-if="errors.password" class="ml-[153px] mt-[5px] text-[#ff0000]">
                    {{ errors.password[0] }}
                </div>
                <div class="flex items-center mt-3">
                    <div class="flex-auto font-bold text-[#000] text-right mr-[18px]">Xác nhận mật khẩu</div>
                    <div class="w-[290px]">
                        <el-input v-model="forgotUser.confirm_password" placeholder="Xác nhận mật khẩu mới" show-password/>
                    </div>
                </div>
                <div v-if="errors.confirm_password" class="ml-[153px] mt-[5px] text-[#ff0000]">
                    {{ errors.confirm_password[0] }}
                </div>
            </div>
        </div>
        <template #footer>
            <div v-if="currentTab == 'login'">
                <div class="pb-[12px]">
                    <div class="flex justify-center items-center">
                        <div @click="close"
                            class="cursor-pointer flex justify-center items-center gap-1  w-[120px] rounded-[8px] bg-[#ffffff] py-[4px] h-[32px] text-[15px] text-black border border-[#7d7f92]">
                            Hủy bỏ
                        </div>
                        <div
                            class="cursor-pointer flex justify-center items-center gap-1  w-[120px] ml-[18px] rounded-[8px] bg-[#007bff] py-[4px] h-[32px] text-[15px] text-white"
                            @click="login">
                            Đăng nhập
                        </div>
                    </div>
                </div>
                <div class="text-[16px] pt-[12px] pb-[24px] flex justify-center cursor-pointer">
                    <div class="flex items-center justify-center py-[2px]" @click="loginGoogle">
                        <img src="/image/social_icon/google-register.svg" alt="">
                        <span>Login with google</span>
                    </div>
                </div>
            </div>
            <div v-else-if="currentTab == 'send-otp'">
                <div class="mb-[24px] flex justify-center">
                    <div @click="backLogin"
                        class="cursor-pointer flex justify-center items-center gap-1  w-[120px] rounded-[8px] bg-[#ffffff] py-[4px] h-[32px] text-[15px] text-black border border-[#7d7f92]">
                        Quay lại
                    </div>
                    <div
                        class="cursor-pointer flex justify-center items-center w-[120px] ml-[18px] rounded-[6px] bg-[#007bff] py-[4px] h-[32px] text-[15px] text-white"
                        @click="sendMailOTP">
                        Xác nhận
                    </div>
                </div>
            </div>
            <div v-else-if="currentTab == 'check-otp'">
                <div class="mb-[24px] flex justify-center">
                    <div
                        class="cursor-pointer flex justify-center items-center w-[120px] rounded-[6px] bg-[#007bff] py-[4px] h-[32px] text-[15px] text-white"
                        @click="checkOTP">
                        Xác nhận
                    </div>
                </div>
            </div>
            <div v-else>
                <div class="mb-[24px] flex justify-center">
                    <div
                        class="cursor-pointer flex justify-center items-center w-[120px] rounded-[6px] bg-[#007bff] py-[4px] h-[32px] text-[15px] text-white"
                        @click="changePassword">
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
import { ElMessage } from 'element-plus'

export default {
    components:{
        Link,
    },
    data() {
        return {
            dialogVisible: false,
            title: 'Đăng nhập',
            currentTab: 'login',
            user: {
                email: "",
                password: "",
            },
            forgotUser: {
                email: "",
                otp: "",
                password: "",
                confirm_password: "",
            },
            errors: [],
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
            this.user.email = ""
            this.user.password = ""
            this.forgotUser.email = ""
            this.forgotUser.otp = ""
            this.forgotUser.password = ""
            this.forgotUser.confirm_password = ""
            this.errors = [];
        },
        open() {
            this.email = ""
            this.password = ""
            this.title = 'Đăng nhập'
            this.currentTab = 'login'
            this.dialogVisible = true
        },
        close() {
            this.dialogVisible = false
        },
        validateUser() {
            let validate = true;
            if (!(this.user.email && this.user.email.trim())) {
                validate = false
                this.errors.email = "Vui lòng nhập email"
            } else if (!this.validateEmail(this.user.email)) {
                validate = false
                this.errors.email = "Email không đúng định dạng"
            }
            if (!(this.user.password && this.user.password.trim())) {
                validate = false
                this.errors.password = "Vui lòng nhập mật khẩu"
            }
            return validate
        },
        validateEmail(email) {
            let validEmail = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            if (email.match(validEmail)) {
                return true
            } else {
                return false
            }
        },
        async login() {
            if(this.validateUser()) {
                const pagram = { ...this.user }
                await axios.post(route('guest.login'), pagram)
                    .then(response => {
                        ElMessage({
                            showClose: true,
                            message: 'Đăng nhập tài khoản thành công',
                            type: 'success',
                        })
                        this.dialogVisible = false
                        this.$emit('login')
                    })  
                    .catch(errors => {
                        console.log(errors)
                        this.errors = errors.response.data.errors
                    })
            }
        },
        forgotPassword() {
            this.clearResult()
            this.title = 'Quên mật khẩu'
            this.currentTab = 'send-otp'
        },
        async sendMailOTP() {
            const pagram = { ...{
                email: this.forgotUser.email
            } }
            await axios.get(route('guest.forgot-password', pagram))
                .then(response => {
                    this.title = 'Kiểm tra mã xác thực'
                    this.currentTab = 'check-otp'
                    ElMessage({
                        showClose: true,
                        message: 'Gửi mã OTP thành công',
                        type: 'success',
                    })
                })
                .catch(errors => {
                    this.errors = errors.response.data.errors
                    console.log(errors.response.data.errors)
                })
        },
        backLogin() {
            this.title = 'Đăng nhập'
            this.currentTab = 'login'
            this.clearResult()
        },
        async checkOTP() {
            const pagram = { ...{
                email: this.forgotUser.email,
                otp: this.forgotUser.otp
            } }
            await axios.post(route('guest.check-otp'), pagram)
                .then(response => {
                    this.title = 'Thay đổi mật khẩu'
                    this.currentTab = 'change-password'
                    ElMessage({
                        showClose: true,
                        message: 'Kiểm tra mã OTP thành công',
                        type: 'success',
                    })
                })
                .catch(errors => {
                    this.errors = errors.response.data.errors
                })
        },
        async changePassword() {
            const pagram = { ...{
                email: this.forgotUser.email,
                password: this.forgotUser.password,
                confirm_password: this.forgotUser.confirm_password
            } }
            await axios.post(route('guest.change-forgot-password'), pagram)
                .then(response => {
                    ElMessage({
                        showClose: true,
                        message: 'Thay đổi mật khẩu thành công, vui lòng đăng nhập lại',
                        type: 'success',
                    })
                    this.dialogVisible = false
                })
                .catch(errors => {
                    this.errors = errors.response.data.errors
                })
        },
        loginGoogle(){
            const pagram = {
                'provider': 'google',
                'url': window.location.href
            }
            window.location.href = route('guest.login-social', pagram)
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
.main-input .el-input__wrapper {
    box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.5);
}
</style>

