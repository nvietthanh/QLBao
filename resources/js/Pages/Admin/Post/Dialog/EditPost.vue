<template>
    <el-dialog v-model="dialogVisible" id="edit-post" class="bg-[#f4f1f8] max-h-[90%] overflow-y-scroll" width="900px" 
     style="margin-top: 34px !important;" :show-close="true">
        <template #header>
            <div class="text-center font-bold text-[18px]">
                Chỉnh sửa bài viết
            </div>
        </template>
        <div class="mx-[4px] mt-[42px]">
            <div class="mt-[18px] w-[100%]">
                <div class="text-[16px] font-bold text-[#000]">Tiêu đề <span class="text-[red]">*</span></div>
                <el-input class="mt-[2px]" v-model="dataForm.title" placeholder="Nhập tiêu đề" clearable/>
                <div v-if="errors.title" class="mt-[5px] text-[#ff0000]">
                    {{ errors.title[0] }}
                </div>
            </div>
            <div class="mt-[18px] w-[100%]">
                <div class="text-[16px] font-bold text-[#000]">Mô tả </div>
                <el-input class="mt-[2px]" v-model="dataForm.description" placeholder="Nhập mô tả" clearable/>
                <div v-if="errors.description" class="mt-[5px] text-[#ff0000]">
                    {{ errors.description[0] }}
                </div>
            </div>
            <div class="mt-[18px]">
                <div class="text-[16px] font-bold text-[#000]">Hagtag</div>
                <el-select v-model="dataForm.hagtags" class="mt-[2px] max-w-[250px]" placeholder="Chọn hagtag" multiple>
                    <el-option v-for="item in listHagTag"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id"
                    />
                </el-select>
            </div>
            <div class="mt-[18px] w-[100%]">
                <div class="text-[16px] font-bold text-[#000]">Hình ảnh <span class="text-[red]">*</span></div>
                <div class="w-[280px] mt-[8px]">
                    <img v-if="imageSelected" :src="imageSelected" alt="" class="rounded-[4px]">
                    <img v-else :src="dataForm.image" alt="" class="rounded-[4px]">
                </div>
                <div class="cursor-pointer flex justify-center items-center w-[180px] rounded-[20px]
                  bg-[#007bff] px-[10px] py-[4px] h-[32px] text-[14px] text-white mt-[8px]"
                  @click="this.$refs.file.click()">
                    <input type="file" ref="file" accept=".jpg,.png,.bmp,.jpeg,.tif,.gif" @change="changeImage" hidden>
                    <i class="bi bi-upload text-lg mr-[8px] text-white"></i> Upload hình ảnh
                </div>
                <div v-if="errors.image" class="mt-[5px] text-[#ff0000]">
                    {{ errors.image[0] }}
                </div>
            </div>
            <div class="mt-[18px] w-[100%]">
                <div class="text-[16px] font-bold text-[#000]">Nội dung <span class="text-[red]">*</span></div>
                <ckeditor-post class="mt-[8px]" ref="content" :contentProp="dataForm.content" />
                <div v-if="errors.content" class="mt-[5px] text-[#ff0000]">
                    {{ errors.content[0] }}
                </div>
            </div>
        </div>
        <template #footer>
            <div class="pb-[12px] pt-[8px]">
                <div class="flex justify-end text-[14px] mr-[24px]">
                    <div @click="cancel"
                        class="cursor-pointer flex justify-center items-center w-[110px] rounded-[4px] bg-[#ffffff] py-[4px] h-[32px] text-[15px] text-black border border-[#7d7f92]">
                        Hủy bỏ
                    </div>
                    <div class="cursor-pointer flex justify-center items-center w-[110px] ml-[18px] rounded-[4px] bg-[#007bff] py-[4px] h-[32px] text-[15px] text-white"
                        @click="editPost">
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
import CkeditorPost from '@/Components/Ckeditor/Ckeditor.vue';
import { ElMessage } from 'element-plus'

export default {
    components: {
        Link,
        CkeditorPost
    },
    data() {
        return {
            id: '',
            dialogVisible: false,
            imageSelected: '',
            dataForm: {},
            errors: [],
            listHagTag: []
        }
    },
    watch: {
        dialogVisible(value) {
            if(value == false) {
                this.imageSelected = ''
                this.$refs.file = ''
                this.errors = []
            }
        }
    },
    methods: {
        async open(id) {
            this.id = id
            this.dialogVisible = true;
            this.fetchData()
        },
        async fetchData() {
            await axios.get(route('admin.posts.show', this.id))
                .then(response => {
                    this.dataForm = response.data.data
                    this.$refs['content'].editorData = response.data.data.content
                    console.log(this.dataForm)
                })
                .catch(errors => {})
            await axios.get(route('list-hagtag'))
                .then(response => {
                    this.listHagTag = response.data
                })
                .catch(errors => {})
        },
        cancel() {
            this.dialogVisible = false;
        },
        async changeImage(e) {
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
                this.dataForm.image = files[0]
                this.imageSelected = URL.createObjectURL(files[0])
            } catch (err) {
                console.log('handleUploadContent', err);
            }
        },
        async editPost() {
            const pagram = new FormData()
            pagram.append('title', this.dataForm.title ?? '')
            pagram.append('description', this.dataForm.description ?? '')
            pagram.append('image', this.dataForm.image ?? '')
            pagram.append('content', this.$refs['content'].editorData ?? '')
            pagram.append('hagtags', this.dataForm.hagtags ?? '')
            await axios.post(route('creator.posts.update', this.dataForm.id), pagram)
                .then(response => {
                    if(response.data.status == 'false'){
                        ElMessage({
                            showClose: true,
                            message: response.data.msg,
                            type: 'error',
                        })
                    }
                    else {
                        ElMessage({
                            showClose: true,
                            message: 'Cập nhật bài viết thành công',
                            type: 'success',
                        })
                        this.dialogVisible = false
                        this.$emit('change-post')
                    }
                })
                .catch(errors => {
                    this.errors = errors.response.data.errors
                })
        }
    },
}
</script>
<style>
#edit-post .el-dialog__headerbtn {
    font-size: 24px !important;
}
#edit-post.el-dialog {
    border-radius: 4px !important;
    position: fixed !important;
    left: 0;
    right: 0;
}
#edit-post .el-dialog__header {
    position: fixed;
    width: 900px;
    background-color: #fff;
    border-bottom: 1px solid #ccc;
    margin-right: 0 !important;
}
#edit-post .el-select,
#edit-post .el-date-editor {
    width: 100% !important;
}
#edit-post .el-input__inner {
    margin-top: 2px;
}
#edit-post .creator {
    margin: 0 12px;
    padding: 0 12px;
    border-left: 2px solid rgba(0, 0, 0, 0.55);
    border-right: 2px solid rgba(0, 0, 0, 0.55);
}
</style>

