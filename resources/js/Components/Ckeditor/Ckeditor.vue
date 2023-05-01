<template>
    <div>
        <ckeditor 
            :config="editorConfig" 
            :editor="editor"
            v-model="editorData"
        />
    </div>
</template>

<script>
import CKEditor from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default {
    components: {
        ckeditor: CKEditor.component,
        ClassicEditor
    },
    props: {
      contentProp: {
        type: String,
        required: false
      }
    },
    data() {
        return {
            errors:{
                name: ''
            },
            editor: ClassicEditor,
            editorData: this.contentProp ?? '',
            editorConfig: { 
                // extraPlugin: [Base64UploadAdapter],
            }
        };
    },
    methods: {
        getContent(value) {
            this.editorData = value
        },
        emitData() {
            this.$emit('updateContent', this.editorData)
        },
        uploader(editor)
        {
            console.log(editor)
            if(editor) {
                editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
                    alert(1)
                    // return new UploadAdapter( loader );
                };
            }
        },
    },
    watch: {
        editorData(value) {
            this.emitData()
            // console.log(value)
        },
    },
}
</script>

<style>
.ck-editor__editable_inline {
    min-height: 350px;
}
.ck-editor__main {
    max-height: 500px;
    overflow-y: scroll;
}
</style>
