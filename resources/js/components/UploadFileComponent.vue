<template>
  <div id="app">
      
    <p class="mb-3 detail">* Max file size 20MB with jpeg/png extension</p>
    <file-pond
        name="file"
        ref="pond"
        allowRevert="false"
        accepted-file-types="image/*"
        :server="serverOptions"
        :files="uploadFile"
        @processfile="onFinishedUpload"
        />

  </div>
</template>

<script>
import vueFilePond from 'vue-filepond';
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';

const FilePond = vueFilePond( FilePondPluginFileValidateType, FilePondPluginImagePreview );
export default {
    components: {
        FilePond
    },
    props:{
        id:{
            type:Number
        }
    },
    name: 'upload-file',
    data: function() {
        return { 
            serverOptions: {
                revert: null,
                process: (fieldName, file, metadata, load, error, progress, abort) => {
                    this.$emit('progress');
                    const formData = new FormData();
                    formData.append('file', file, file.name);
                    formData.append('id',this.id);
                    const CancelToken = this.$http.CancelToken;
                    const source = CancelToken.source();
                    axios.post('/api/transaction/proff',formData,{
                        cancelToken: source.token,
                        onUploadProgress: (e) => {
                            progress(e.lengthComputable, e.loaded, e.total);
                        }
                    }).then(response => {
                        console.log(response);
                        this.$emit('loadingFinished')
                        this.$emit('file',response.data)
                        load(response.data.gambar_id)
                    }).catch((thrown) => {
                        if (this.$http.isCancel(thrown)) {
                            console.log('Request canceled', thrown.message);
                        } else {
                            this.$emit('error',thrown.response);
                            console.log(thrown.response);
                        }
                    });

                    // Setup abort interface
                    return {
                        abort: () => {
                            source.cancel('Operation canceled by the user.');
                        }
                    };
                }
            }, 
            uploadFile:null,
        };
    },
    methods: {
        onFinishedUpload(){
            this.$emit('uploaded',true);
        }
    },
    mounted(){
    },

    
};
</script>

<style>
    .detail {
        font-size:0.9rem;
        color:#989898;
    }
</style>
