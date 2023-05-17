<template>
    <el-dialog v-model="dialogVisible" width="580px" class="bg-[#f4f1f8]" :show-close="false">
        <template #header>
            <div class="text-center my-header">
                Thay đổi mật khẩu
            </div>
        </template>
        <div class="main-input px-5 pt-2">
            <div class="flex items-center">
                <div class="heading w-[200px]">Mật khẩu cũ</div>
                <el-input v-model="userInfor.password" placeholder="Nhập mật khẩu cũ" show-password/>
            </div>
            <div v-if="errors.password" class="mt-[5px] ml-[138px] text-[#ff0000]">
                {{ errors.password[0] }}
            </div>
            <div class="flex items-center mt-3">
                <div class="heading w-[200px]">Mật khẩu mới</div>
                <el-input v-model="userInfor.new_password" placeholder="Nhập mật khẩu mới" show-password/>
            </div>
            <div v-if="errors.new_password" class="mt-[5px] ml-[138px] text-[#ff0000]">
                {{ errors.new_password[0] }}
            </div>
            <div class="flex items-center mt-3">
                <div class="heading w-[200px]">Xác nhận mật khẩu mới</div>
                <el-input v-model="userInfor.confirm_new_password" placeholder="Xác nhận lại mật khẩu mới" show-password/>
            </div>
            <div v-if="errors.confirm_new_password" class="mt-[5px] ml-[138px] text-[#ff0000]">
                {{ errors.confirm_new_password[0] }}
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
                        class="cursor-pointer flex justify-center items-center gap-1  w-[120px] ml-[18px] rounded-[8px] bg-[#007bff] py-[4px] h-[32px] text-[15px] text-white"
                        @click="chanePassword">
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
    name: "ChangePassword",
    data() {
        return {
            dialogVisible: false,
            userInfor: {
                password: "",
                new_password: "",
                confirm_new_password: ""
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
        open() {
            this.dialogVisible = true;
            this.clearResult()
        },
        close() {
            this.dialogVisible = false
        },
        clearResult() {
            this.userInfor.password = ""
            this.userInfor.new_password = "",
            this.userInfor.confirm_new_password = ""
            this.errors = []
        },
        async chanePassword() {
            const pagram = { ...this.userInfor }
            await axios.post(route('admin.change-password'), pagram)
                .then(response => {
                    this.$emit('change-password')
                    ElMessage({
                        showClose: true,
                        message: 'Thay đổi mật khẩu thành công',
                        type: 'success',
                    })
                    this.dialogVisible = false
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
.my-header {
    font-size: 1.2rem;
    font-weight: 600;
}
.main .heading {
    font-weight: 600;
    color: #000;
    font-size: 1.0rem;
}
.main-input .el-input__wrapper {
    box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.5);
}
</style>

