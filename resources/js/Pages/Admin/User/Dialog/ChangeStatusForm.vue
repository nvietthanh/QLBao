<template>
    <el-dialog v-model="dialogVisible" id="show-report-account" class="bg-[#f4f1f8] h-[60%] overflow-scroll" width="520px" 
     style="margin-top: 82px !important;" :show-close="true">
        <template #header>
            <div class="text-center font-bold text-[18px]">
                Chỉnh sửa trạng thái tài khoản
            </div>
        </template>
        <div class="flex mt-[38px]">
            <div class="py-[12px] px-[12px] w-[100%]">
                <div>
                    <div class="text-[16px] font-bold text-[blue]">Thông tin người dùng:</div>
                    <div class="px-[24px]">
                        <div class="mt-[8px]">
                            <span class="text-[16px] font-bold">Tên người dùng:</span>
                            <span class="ml-[12px]">{{ dataForm.name }}</span>
                        </div>
                        <div class="mt-[6px]">
                            <span class="text-[16px] font-bold">Email:</span>
                            <span class="ml-[12px]">{{ dataForm.email }}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="text-[16px] font-bold mt-[22px] text-[blue]">Trạng thái tài khoản:</div>
                    <div class="px-[24px]">
                        <div class="mt-[6px] flex items-center">
                            <span class="text-[16px] font-bold mr-[12px]">Trạng thái:</span>
                            <div class="flex items-center">
                                <el-switch v-model="dataForm.status"
                                    style="--el-switch-on-color: #13ce66; --el-switch-off-color: #ff4949"
                                />
                                <span class="ml-[8px]" v-if="dataForm.status">Activated</span>
                                <span class="ml-[8px]" v-else>Deactivated</span>
                            </div>
                        </div>
                        <div class="mt-[6px]" v-if="!dataForm.status">
                            <span class="text-[16px] font-bold">Thời gian khóa: </span>
                            <el-date-picker
                                v-model="dataForm.status_expires_at"
                                type="datetime"
                                placeholder="Chọn giờ mở khóa"
                                format="YYYY-MM-DD HH:mm:ss"
                                value-format="YYYY-MM-DD HH:mm:ss"
                                class="w-[100%] mt-[8px]"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <template #footer>
            <div class="pb-[8px] pt-[8px]">
                <div class="flex justify-end text-[14px] mr-[24px]">
                    <div @click="cancel"
                        class="cursor-pointer flex justify-center items-center w-[110px] rounded-[4px] bg-[#ffffff] py-[4px] h-[32px] text-[15px] text-black border border-[#7d7f92]">
                        Hủy bỏ
                    </div>
                    <div class="cursor-pointer flex justify-center items-center w-[110px] ml-[18px] rounded-[4px] bg-[#007bff] py-[4px] h-[32px] text-[15px] text-white"
                        @click="changeStatusAccount()">
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

export default {
    components:{
        Link,
    },
    data() {
        return {
            dialogVisible: false,
            dataForm: {}
        }
    },
    watch: {
        dialogVisible(value) {
            if(value == false) {
                this.dataForm = {}
            }
        }
    },
    methods: {
        moment,
        async open(row) {
            this.dialogVisible = true;
            const response = await axios.get(route('admin.accounts.get-status', row.id))
            this.dataForm = response.data.data
        },
        cancel() {
            this.dialogVisible = false
        },
        async changeStatusAccount() {
            const pagram = { ...
                {
                    'status': this.dataForm.status,
                    'status_expires_at': this.dataForm.status ? '' : this.dataForm.status_expires_at
                }
            }
            await axios.post(route('admin.accounts.change-status', this.dataForm.id), pagram)
                .then(response => {
                    this.dialogVisible = false
                    this.dataForm = {}
                    this.$emit('change-account')
                })
        }
    },
}
</script>
<style>
#show-report-account {
    position: relative;
}
#show-report-account .el-dialog__headerbtn {
    font-size: 24px !important;
}
#show-report-account.el-dialog {
    border-radius: 4px !important;
    position: fixed !important;
    left: 0;
    right: 0;
}
#show-report-account .el-dialog__header {
    position: fixed;
    width: 520px;
    background-color: #fff;
    border-bottom: 1px solid #ccc;
    margin-right: 0 !important;
    z-index: 100;
}
#show-report-account .el-dialog__footer {
    position: absolute;
    bottom: 0;
    right: 0;
    background-color: #fff;
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
</style>

