<template>
  <div class="col-md-3 mt-4">
    <div class="file-element d-flex flex-column static-element" data-toggle="modal" data-target="#create-modal">
      <span class="folder-icon">
        <i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i>
      </span>
      <span class="title">Create a directory or <br/> upload a file</span>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="create-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="">Create</h5>
          </div>
          <div class="modal-body">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="pills-directory-tab" data-toggle="pill" href="#pills-directory" role="tab" aria-controls="pills-directory" aria-selected="true">
                  Directory
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pills-file-tab" data-toggle="pill" href="#pills-file" role="tab" aria-controls="pills-file" aria-selected="false">
                  Upload File
                </a>
              </li>
            </ul>

            <div class="tab-content mt-5" id="pills-tabContent">
              <div class="has-error py-2" v-if="hasError">
                {{ hasError }}
              </div>
              <div class="tab-pane fade show active" id="pills-directory" role="tabpanel" aria-labelledby="pills-directory-tab">
                <div class="form-group">
                  <label for="directory">Directory Name</label>
                  <input type="text" class="form-control" id="directory" aria-describedby="directoryHelp" placeholder="Enter Directory Name" v-on:input="onDirectoryName" v-model="name">
                </div>
              </div>
              <div class="tab-pane fade" id="pills-file" role="tabpanel" aria-labelledby="pills-file-tab">
                <drop-zone-component default-file="/images/placeholder.jpg"></drop-zone-component>
              </div>
            </div>
          </div>
          <div class="modal-footer d-flex">
            <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal" v-on:click="dismissModal">
              Close
            </button>
            <button type="button" class="btn btn-primary" style="margin-left:10px;" v-bind:class="{ disabled: disabled }"  v-on:click="onConfirm">
              Confirm
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import MediaLibraryService from '../../../Services/MediaLibraryServices.js';
  export default{
    props: ['currentDir'],
    data: function(){
      return {
        name: '',
        type: 'd',
        disabled: true,
        hasError: null,
      };
    },
    mounted(){
      this.eventsHandlers();
    },
    methods: {
      eventsHandlers: function(){
        VueEventBus.$on('dropZone:onDropZone', this.onFileSelected);
      },
      dismissModal: function(){
        this.name = '';
        this.type = 'd';
        this.hasError = null;
        this.disabled = true;
        VueEventBus.$emit('dropZone:reset');
      },
      onFileSelected: function(file){
        this.name = file;
        this.type = 'f';
        this.disabled = false;
      },
      onDirectoryName: function(){
        this.type = 'd';
        this.disabled = false;
      },
      onConfirm: function(){
        if (this.disabled) {
          return;
        }
        let data = {};
        if (this.type == 'f') {
          data = new FormData();
          data.append('file', this.name);
          data.append('current_dir_id', this.currentDir.id);
        }else{
          data = {
            name: this.name,
            current_dir_id: this.currentDir.id
          };
        }
        MediaLibraryService.createFileElement(data, (data) => {
          this.$emit('explorer:newFileElement', data);
          this.dismissModal();
        }, (response) => {
          this.hasError = response.data.message;
        });
      }
    }
  }
</script>
