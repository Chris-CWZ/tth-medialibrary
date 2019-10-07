<template>
  <div class="d-flex flex-column">

    <div class="file-element d-flex flex-column" v-on:click="onClick" @contextmenu.prevent="$refs.menu.open($event)">
      <span class="folder-icon" v-if="fileElement.type == 'd'">
        <i class="fa fa-folder fa-5x" aria-hidden="true"></i>
      </span>
      <img :src="fileElement.url" :alt="fileElement.name" v-if="fileElement.type =='f'" class="file-image">
    </div> <!-- fileElement -->
    <span class="title">{{ fileElement.disp_name }}</span>

    <VueContext ref="menu">
      <ul slot-scope="child">
        <div v-if="fileElement.type =='f'">
          <li @click.prevent="onFilePreview" class="d-flex">
            <i class="material-icons pr-3">remove_red_eye</i>
            <div class="option-item">
              Preview
            </div>
          </li>
          <li @click="onMoveFileModal" class="d-flex">
            <i class="material-icons pr-3">edit</i>
            <div class="option-item">
              Move File
            </div>
          </li>
          <li @click="onFileElementDelete" class="d-flex">
            <i class="material-icons pr-3">delete</i>
            <div class="option-item">
              Delete File
            </div>
          </li>
        </div>

        <div v-if="fileElement.type == 'd'">
          <li @click.prevent="onRenameDirectoryModal" class="d-flex">
            <i class="material-icons pr-3">edit</i>
            <div class="option-item">
              Rename Directory
            </div>
          </li>
          <li @click="onFileElementDelete" class="d-flex">
            <i class="material-icons pr-3">delete</i>
            <div class="option-item">
              Delete Directory
            </div>
          </li>
        </div>
      </ul>
    </VueContext>  <!-- VueContext -->
  </div>
</template>

<script>
  import { VueContext } from 'vue-context';
  import MediaLibraryService from '../../../Services/MediaLibraryServices.js';

  export default{
    props: ['fileElement'],
    components: {
      VueContext
    },
    data: function(){
      return {
        hasError: null,
      }
    },
    mounted(){
      this.eventsHandlers();
    },
    methods: {
      eventsHandlers: function(){
        VueEventBus.$on('directoryNameChanged', this.onDirectoryName);
        VueEventBus.$on('moveFileElement', this.onMoveFileElement);
      },
      onClick: function(){
        this.$emit('explorer:fileElementOpened', this.fileElement);
      },
      onFilePreview: function(){
        this.onClick();
      },
      onRenameDirectoryModal: function(){
        VueEventBus.$emit('openDirectoryNameModal', this.fileElement);
      },
      onMoveFileModal: function(){
        VueEventBus.$emit('openFileMoveModal', this.fileElement);
      },
      onDirectoryName: function(fileElement, name){
        if (fileElement.id != this.fileElement.id) {
          return ;
        }
        MediaLibraryService.renameFileElement(fileElement.id, {name: name}, (data) => {
          this.fileElement.name = name;
          this.fileElement.disp_name = name.length > 10 ? name.substr(0, 10) : name ;
          this.$emit('explorer:directoryRenamed', this.fileElement);
        }, (response) => {
          console.error(response);
        });
      },
      onMoveFileElement: function(fileElement, targetDirectory){
        if (fileElement.id != this.fileElement.id) {
          return ;
        }
        MediaLibraryService.moveFileElement(fileElement.id, { 'target_dir_id': targetDirectory }, (data) => {
          this.$emit('explorer:fileElementMoved', this.fileElement);
        }, (response) => {
          console.error(response);
        });
      },
      onFileElementDelete: function(){
        MediaLibraryService.removeFileElement(this.fileElement.id, (data) => {
          this.$emit('explorer:fileElementRemoved', this.fileElement);
        }, (response) => {
          console.error(response);
        });
      }
    }
  }
</script>
