<template>
    <div>
        <ckeditor :config="editorConfig" :editor="editor" v-model="editorData"></ckeditor>
    </div>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

export default {
    name: 'CkeditorComponent',
    props: {
      contentProp: {
          type: String,
          required: false
      }
    },
    data() {
        return {
            editor: ClassicEditor,
            editorData: this.contentProp ?? '',
            editorConfig: {}
        };
    },
    methods: {
        getContent(value) {
            this.editorData = value
        },
        emitData() {
            this.$emit('updateContent', this.editorData)
        },
    },
    watch: {
        editorData() {
            this.emitData()
        },
    },
}
</script>

<style>
.ck-editor__editable_inline {
    min-height: 350px;
}
</style>
