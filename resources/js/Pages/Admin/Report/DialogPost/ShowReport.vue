<template>
    <el-dialog v-model="dialogVisible" id="show-report-post" class="bg-[#f4f1f8] h-[90%] overflow-scroll" width="820px" 
     style="margin-top: 34px !important;" :show-close="true">
        <template #header>
            <div class="text-center font-bold text-[18px]">
                Xem chi tiết báo cáo vi phạm
            </div>
        </template>
        <div class="flex mt-[38px]">
            <div class="py-[12px] px-[12px]">
                <div>
                    <div class="text-[16px] font-bold text-[blue]">Thông tin bài viết:</div>
                    <div class="pl-[24px]">
                        <div class="mt-[8px]">
                            <span class="text-[16px] font-bold">Tiêu đề:</span>
                            <span class="ml-[12px]">{{ dataForm.post_title }}</span>
                        </div>
                        <div class="mt-[6px]">
                            <span class="text-[16px] font-bold">Tác giả:</span>
                            <span class="ml-[12px]">{{ dataForm.post_creator }}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="text-[16px] font-bold mt-[12px] text-[blue]">Thông tin người dùng:</div>
                    <div class="px-[24px]">
                        <div class="mt-[6px]">
                            <span class="text-[16px] font-bold">Tên người dùng báo cáo:</span>
                            <span class="ml-[12px]">{{ dataForm.account_report_name }}</span>
                        </div>
                        <div class="mt-[6px]">
                            <span class="text-[16px] font-bold">Email báo cáo:</span>
                            <span class="ml-[12px]">{{ dataForm.account_report_email }}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-[12px]">
                    <div class="font-bold text-[16px] text-[blue]">Thông tin chi tiết báo cáo vi phạm:</div>
                    <div class="px-[24px]">
                        <div class="mt-[6px]">
                            <span class="text-[16px] font-bold">Nội dung:</span>
                            <div v-html="dataForm.content" class="pl-[24px] text-[15px]"></div>
                        </div>
                        <div class="mt-[6px]">
                            <span class="text-[16px] font-bold">Hình ảnh kèm theo:</span>
                            <div class="mt-[12px] grid grid-cols-3 gap-3">
                                <template v-for="image in dataForm.image">
                                    <el-image
                                        class="h-[180px]"
                                        :src="image"
                                        :zoom-rate="1.2"
                                        preview-teleported="true"
                                        hide-on-click-modal="true"
                                        :preview-src-list="dataForm.image"
                                        :initial-index="1"
                                        fit="cover"
                                    />
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
            const response = await axios.get(route('admin.report-posts.show-report', row.id))
            this.dataForm = response.data.data
        },
    },
}
</script>
<style>
#show-report-post .el-dialog__headerbtn {
    font-size: 24px !important;
}
#show-report-post.el-dialog {
    border-radius: 4px !important;
    position: fixed !important;
    left: 0;
    right: 0;
}
#show-report-post .el-dialog__header {
    position: fixed;
    width: 820px;
    background-color: #fff;
    border-bottom: 1px solid #ccc;
    margin-right: 0 !important;
    z-index: 100;
}
#show-report-post .el-select,
#show-report-post .el-date-editor {
    width: 100% !important;
}
#show-report-post .el-input__inner {
    margin-top: 2px;
}
#show-report-post .creator {
    margin: 0 12px;
    padding: 0 12px;
    border-left: 2px solid rgba(0, 0, 0, 0.55);
    border-right: 2px solid rgba(0, 0, 0, 0.55);
}
</style>