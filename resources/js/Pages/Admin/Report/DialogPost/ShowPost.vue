<template>
    <el-dialog v-model="dialogVisible" id="show-post" class="bg-[#f4f1f8] h-[90%] overflow-scroll" width="800px" 
     style="margin-top: 34px !important;" :show-close="true">
        <template #header>
            <div class="text-center font-bold text-[18px]">
                Xem bài viết
            </div>
        </template>
        <div class="flex mt-[38px]">
            <div class="py-[12px] px-[12px]">
                <div class="text-[22px] font-bold">
                    {{ dataForm.title }}
                </div>
                <div class="flex items-center my-[12px]">
                    <div class="text-[16px] text-[#076db6] font-bold">
                        {{ dataForm.categoryName }}
                    </div>
                    <div class="creator text-[16px] font-bold text-[#333]">
                        {{ dataForm.creator }}
                    </div>
                    <div class="text-[14px]">
                        {{ dataForm.created_at }}
                    </div>
                </div>
                <div class="mt-[18px]">
                    <el-image
                        style="width: 100%; height: 100%;"
                        :src="dataForm.image"
                        :zoom-rate="1.2"
                        preview-teleported="true"
                        hide-on-click-modal="true"
                        :preview-src-list="[dataForm.image]"
                        :initial-index="1"
                        fit="cover"
                    />
                    <div class="text-[14px] text-center mt-[8px]">
                        {{ dataForm.description }}
                    </div>
                </div>
                <div v-html="dataForm.content" class="mt-[12px] text-[16px] mb-[18px]"></div>
            </div>
        </div>
    </el-dialog>
</template>

<script>
import axios from 'axios';
import { Link } from '@inertiajs/vue3'
import moment from "moment";
import { ElMessage, ElMessageBox } from 'element-plus'

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
            const response = await axios.get(route('admin.report-posts.show-post', row.post_id))
            this.dataForm = response.data.data
        },
    },
}
</script>
<style>
#show-post .el-dialog__headerbtn {
    font-size: 24px !important;
}
#show-post.el-dialog {
    border-radius: 4px !important;
    position: fixed !important;
    left: 0;
    right: 0;
}
#show-post .el-dialog__header {
    position: fixed;
    width: 800px;
    background-color: #fff;
    border-bottom: 1px solid #ccc;
    margin-right: 0 !important;
    z-index: 100;
}
#show-post .el-select,
#show-post .el-date-editor {
    width: 100% !important;
}
#show-post .el-input__inner {
    margin-top: 2px;
}
#show-post .creator {
    margin: 0 12px;
    padding: 0 12px;
    border-left: 2px solid rgba(0, 0, 0, 0.55);
    border-right: 2px solid rgba(0, 0, 0, 0.55);
}
</style>

