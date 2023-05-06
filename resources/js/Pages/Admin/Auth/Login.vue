<template>
    <main class="fixed top-0 left-0 right-0 bottom-0 flex justify-center items-center bg-[#ebebeb]">
        <div class="border-[1px] border-[#6c757d] w-[500px] rounded-[4px] pb-[24px] mb-[102px] bg-[#fff]">
            <div class="text-[18px] py-[16px] border-b-[1px] border-[#ced4da] font-bold flex justify-center">
                Đăng nhập
            </div>
            <el-form class="py-[32px] px-[48px] text-[14px]" @keyup.enter.prevent="login">
                <div class="flex items-center">
                    <label class="min-w-[120px] font-bold">Tên đăng nhập</label>
                    <el-input v-model="userInfor.email" placeholder="Nhập email đăng nhập" clearable/>
                </div>
                <span class="text-[13px] text-[red] ml-[122px]" v-if="errors['email']">
                    {{ errors['email'][0] }}
                </span>
                <div class="flex items-center mt-[12px]">
                    <label class="min-w-[120px] font-bold">Mật khẩu</label>
                    <el-input v-model="userInfor.password" placeholder="Nhập mật khẩu" show-password/>
                </div>
                <span class="text-[13px] text-[red] ml-[122px]" v-if="errors['password']">
                    {{ errors['password'][0] }}
                </span>
                <div class="mt-[32px] flex justify-center text-center">
                    <div class="px-[24px] py-[6px] bg-[#2884e7] text-white rounded cursor-pointer" @click="login">
                        Đăng nhập
                    </div>
                </div>
            </el-form>
        </div>
    </main>
</template>
<script>
import { Link } from '@inertiajs/vue3'
import { ElMessage, ElMessageBox } from 'element-plus'
import { h } from 'vue'
import Navigation from '@/Components/User/Navigation.vue'
import axios from 'axios'

export default{
    components:{
        Link,
        Navigation
    },
    data() {
        return {
            userInfor: {
                email: '',
                password: ''
            },
            errors: []
        }  
    },
    created() {
        document.title = "Đăng nhập - Admin hệ thống"
    },
    methods: {
        async login() {
            if(this.validateUser()) {
                const pagram = { ...this.userInfor }
                await axios.post(route('admin.login'), pagram)
                    .then(response => {
                        ElMessage({
                            showClose: true,
                            message: 'Đăng nhập tài khoản thành công',
                            type: 'success',
                        })
                        location.reload()
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors
                        console.log(this.errors)
                    })
            }
        },
        validateEmail(email) {
            let validEmail = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            if (email.match(validEmail)) {
                return true
            } else {
                return false
            }
        },
        validateUser() {
            let validate = true;
            if (!(this.userInfor.email && this.userInfor.email.trim())) {
                validate = false
                this.errors.email = ["Vui lòng nhập email"]
            } else if (!this.validateEmail(this.userInfor.email)) {
                validate = false
                this.errors.email = ["Email không đúng định dạng"]
            }
            if (!(this.userInfor.password && this.userInfor.password.trim())) {
                validate = false
                this.errors.password = ["Vui lòng nhập mật khẩu"]
            }
            return validate
        },
    }
}
</script> 