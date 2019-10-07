<template >
	<div class="d-flex flex-column">
		<div class="file-element d-flex flex-column" v-on:click="onClick">
			<span class="folder-icon" v-if="fileElement.is_dir">
				<i class="fa fa-folder fa-5x" aria-hidden="true"></i>
			</span>
			<img :src="fileElement.url" :alt="fileElement.name" v-if="!fileElement.is_dir" class="file-image">
			<div class="hover-select" v-if="!fileElement.is_dir && isSelected" >
				<i class="material-icons">check</i>
			</div>
		</div> <!-- fileElement -->
		<span class="title">{{ fileElement.name }}</span>
	</div>
</template>

<script>
	export default {
		props: ['fileElement'],
		data: function(){
			return {
				isSelected: false
			};
		},
		mounted(){
			VueEventBus.$on('mediaLibrary:fileElementOverridden', this.onFileElementOverridden);
			VueEventBus.$on('mediaLibrary:pickerReset', this.onMediaPickerReset);
		},
		methods: {
			onClick: function(){
				this.isSelected = !this.isSelected;
				if (this.isSelected) {
					this.$emit('mediaLibrary:fileElementSelected', this.fileElement);
				}else{
					this.$emit('mediaLibrary:fileElementRemoved', this.fileElement);
				}
			},
			onFileElementOverridden: function(previousFileElement){
				if (this.fileElement.id === previousFileElement.id) {
					this.isSelected = false;
				}
			},
			onMediaPickerReset: function(){
				this.isSelected = false;
			}
		}
	}
</script>
