<template>
  <div class="drop-zone" v-bind:class="{ 'drop-zone-avatar': isAvatar }">
    <div class="drop-zone-wrapper col-12 p-0" >
      <input type="file" class="drop-zone-file" id="keyLabel" accept=".jpg, .jpeg, .png" v-on:input="onFileChange">
      <img :src="file" alt="DropZoneImage" class="drop-zone-image w-100"/>
      <label class="drop-zone-label d-flex" for="keyLabel">
        <i class="fa fa-cloud-upload" aria-hidden="true"></i>
      </label>
    </div>
  </div>
</template>

<script>
	export default {
		props: {
			defaultFile: String,
			isAvatar: Boolean
		},
    data: function(){
		  return {
        file: this.defaultFile,
      }
    },
    mounted(){
			VueEventBus.$on('dropZone:reset', this.onResetVue);
    },
    methods: {
      onFileChange: function($event){
        let filename = $event.target.value.replace(/C:\\fakepath\\/i, '');
        let files = $event.target.files;

        if (!files && files.length === 0){
          return;
        }

        let reader = new FileReader();

        reader.onload = (e) => {
          this.file = e.target.result;
        };
        reader.readAsDataURL(files[0]);
        VueEventBus.$emit('dropZone:onDropZone', files[0]);
      },
			onResetVue: function(){
				this.file = this.defaultFile;
			}
    }
	}
</script>
