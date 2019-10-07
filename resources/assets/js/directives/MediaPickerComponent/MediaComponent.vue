<template>
  <div class="card" id="media-picker-select">
  	<div class="card-header d-flex">
  		<button type="button" class="ml-auto btn-add-media" v-if="files.length > 0"  v-on:click="onMediaLibraryOpen">
				Replace Media
			</button>
  	</div>
		<div class="card-body">
			<div class="upload-title d-flex flex-column" v-if="files.length == 0" v-on:click="onMediaLibraryOpen">
				<i class="material-icons title-icon">photo_library</i>
				<h5 class="title-text mt-4" v-if="multiple">Select files from the media library</h5>
				<h5 class="title-text mt-4" v-if="!multiple">Select file from the media library</h5>
			</div>
			<div class="file-list py-3">
				<media-files-component @media:fileRemoved="onFileRemoved" v-for="file in files" v-if='!file.deleted' :file="file" :key="file.id"></media-files-component>
			</div>
		</div>

		<media-library-picker-component :i-key="iKey" @mediaLibrary:filesSelected="onFilesSelected" :is-open="isOpen" :max="max" :multiple="multiple" @closing="() => { isOpen = false }"></media-library-picker-component>
  </div>
</template>

<script>
	export default {
		props: ['defaultFiles', 'multiple', 'iKey','max'],
		data: function(){
			return {
				files: [],
				isOpen: false,
			}
		},
		watch: {
			defaultFiles: function(newVal, oldVal){
				if (newVal) {
					if (newVal instanceof Array) {
						this.files = newVal;
					}else{
						this.files = [newVal];
					}
				}else{
					this.files = [];
				}
			}
		},
		mounted(){
			if (this.defaultFiles) {
				if (this.defaultFiles instanceof Array) {
					this.files = this.defaultFiles;
				}else{
					this.files = [this.defaultFiles];
				}
			}
			VueEventBus.$on('mediaLibrary:pickerReset', this.onMediaLibraryClose);
		},
		methods: {
			onMediaLibraryOpen: function(){
				this.isOpen = true;
			},
			onMediaLibraryClose: function() {
				this.isOpen = false;
			},
			onFilesSelected: function(files){
				this.files = files;
				this.$emit('media:filesSelected', this.files);
			},
			onFileRemoved: function(removedFile){
				let files = _.reject(this.files, function (file) {
					return  file.id === removedFile.id;
				});

				this.files = files;
				this.$emit('media:filesDeselected', removedFile);
			},
		}
	}
</script>
