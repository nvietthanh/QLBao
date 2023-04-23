<template>
    <el-dialog v-model="dialogVisible" id="show-contact" class="bg-[#f4f1f8] h-[90%] overflow-scroll" width="820px" 
     style="margin-top: 34px !important;" :show-close="true">
        <template #header>
            <div class="text-center font-bold text-[18px]">
                Xem chi tiết liên hệ
            </div>
        </template>
        <div class="flex mt-[38px]">
            <div class="py-[12px] px-[12px]">
                <div class="text-[18px] font-bold text-[blue]">Thông tin chi tiết liên hệ:</div>
                <div class="px-[24px]">
                    <div class="mt-[6px]">
                        <span class="text-[16px] font-bold">Họ tên:</span>
                        <span class="ml-[12px] text-[15px]">{{ dataForm.name }}</span>
                    </div>
                    <div class="mt-[12px]">
                        <span class="text-[16px] font-bold">Địa chỉ email:</span>
                        <span class="ml-[12px] text-[15px]">{{ dataForm.email }}</span>
                    </div>
                    <div class="mt-[12px]">
                        <span class="text-[16px] font-bold">Tiêu đề:</span>
                        <span class="ml-[12px] text-[15px]">{{ dataForm.title }}</span>
                    </div>
                    <div class="mt-[12px]">
                        <span class="text-[16px] font-bold">Ngày tạo:</span>
                        <span class="ml-[12px] text-[15px]">{{ dataForm.created_at }}</span>
                    </div>
                    <div class="mt-[12px]">
                        <span class="text-[16px] font-bold">Nội dung:</span>
                        <div v-html="dataForm.content" class="pl-[24px] text-[15px]"></div>
                    </div>
                    <div class="mt-[12px]">
                        <span class="text-[16px] font-bold">Hình ảnh kèm theo:</span>
                        <div class="mt-[12px] grid grid-cols-3 gap-3">
                            <template v-for="image in dataForm.images">
                                <el-image
                                    class="h-[160px]"
                                    :src="image"
                                    :zoom-rate="1.2"
                                    preview-teleported="true"
                                    hide-on-click-modal="true"
                                    :preview-src-list="dataForm.images"
                                    :initial-index="1"
                                    fit="cover"
                                />
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ShowFormMailContact ref="showFormMailContact" @update-change="fetchData"/>
        <template #footer>
            <div v-if="!this.dataForm.is_reply" class="pb-[12px] pt-[8px]">
                <div class="flex justify-end text-[14px] mr-[24px]">
                    <div class="cursor-pointer text-center w-[160px] ml-[18px] rounded-[4px] bg-[#007bff] h-[38px]
                     leading-[38px] text-[16px] text-white"
                        @click="replyContact()">
                        Gửi email trả lời
                    </div>
                </div>
            </div>
            <div v-else class="pb-[12px] pt-[8px]">
                <div class="flex justify-end text-[14px] mr-[24px]">
                    <div class="cursor-pointer text-center w-[160px] ml-[18px] rounded-[4px] bg-[#007bff] h-[38px]
                     leading-[38px] text-[16px] text-white"
                        @click="replyContact()">
                        Đã trả lời (Gửi lại)
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
import ShowFormMailContact from '@/Components/AboutUs/Dialog/SendMailContact.vue';

export default {
    components:{
        Link,
        ShowFormMailContact
    },
    data() {
        return {
            dialogVisible: false,
            id: '',
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
        open(row) {
            this.dialogVisible = true;
            this.id = row.id
            this.fetchData()
        },
        async fetchData() {
            const response = await axios.get(route('admin.get-contact', this.id))
            this.dataForm = response.data.data
        },
        replyContact() {
            this.$refs.showFormMailContact.open(this.dataForm)
        }
    },
}
</script>
<style>
#show-contact .el-dialog__headerbtn {
    font-size: 24px !important;
}
#show-contact.el-dialog {
    border-radius: 4px !important;
    position: fixed !important;
    left: 0;
    right: 0;
}
#show-contact .el-dialog__header {
    position: fixed;
    width: 820px;
    background-color: #fff;
    border-bottom: 1px solid #ccc;
    margin-right: 0 !important;
    z-index: 100;
}
#show-contact .el-select,
#show-contact .el-date-editor {
    width: 100% !important;
}
#show-contact .el-input__inner {
    margin-top: 2px;
}
#show-contact .creator {
    margin: 0 12px;
    padding: 0 12px;
    border-left: 2px solid rgba(0, 0, 0, 0.55);
    border-right: 2px solid rgba(0, 0, 0, 0.55);
}
</style>