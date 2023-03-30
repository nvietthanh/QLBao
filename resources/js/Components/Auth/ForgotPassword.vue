<template>
    <el-dialog v-model="dialogVisible" width="580px" class="bg-[#f4f1f8]" :show-close="false">
        <template #header>
            <div class="text-center my-header">
                Quên mật khẩu
            </div>
        </template>
        <div class="main-input px-5 pt-2">
            <div class="flex items-center">
                <div class="heading w-[200px]">Mật khẩu cũ</div>
                <el-input v-model="password" placeholder="Nhập mật khẩu cũ" show-password	/>
            </div>
            <div class="flex items-center mt-3">
                <div class="heading w-[200px]">Mật khẩu mới</div>
                <el-input v-model="new_password" placeholder="Nhập mật khẩu mới" show-password	/>
            </div>
            <div class="flex items-center mt-3">
                <div class="heading w-[200px]">Xác nhận mật khẩu mới</div>
                <el-input v-model="confirm_new_password" placeholder="Xác nhận lại mật khẩu mới" show-password	/>
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
                        @click="login">
                        Xác nhận
                    </div>
                </div>
            </div>
        </template>
    </el-dialog>
</template>

<script>
import axios from 'axios';

export default {
    name: "DetailFacility",
    data() {
        return {
            dialogVisible: false,
            email: "",
            password: "",
            new_password: "",
            confirm_new_password: ""
        }
    },
    methods: {
        open() {
            this.email = ""
            this.password = ""
            this.new_password = "",
            this.confirm_new_password = ""
            this.dialogVisible = true;
        },
        close() {
            this.dialogVisible = false
        },
        login() {
            this.$emit('change-password')
            this.dialogVisible = false
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

