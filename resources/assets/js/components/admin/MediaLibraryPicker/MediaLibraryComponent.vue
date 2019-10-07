<template>
	<div class="row wrapper" id="media" style="height:auto !important">
		<div class="container" >
			<media-library-breadcrumb-component @mediaLibrary:explore="onExplorerClick" @mediaLibrary:exploreAll="fetchFileElements"></media-library-breadcrumb-component>
			<div class="row file-elements">
				<div class="col-md-3 mt-4" v-for="fileElement in fileElements" :key="fileElement.id" >
					<media-library-element-component @mediaLibrary:fileElementSelected="onFileElementSelected" @mediaLibrary:fileElementRemoved="onFileElementRemoved" :file-element="fileElement"></media-library-element-component>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import MediaLibraryService from '../../../Services/MediaLibraryServices.js';

	export default {
		props: [],
		data: function(){
			return {
				fileElements: [],
				currentDir: {
					name: '',
					parent: null,
					canGoUp: false,
					isRoot: false,
				}
			}
		},
		mounted(){
			this.fetchFileElements();
		},
		methods: {
			fetchFileElements: function(){
				MediaLibraryService.getFileElements((data) => {
					this.currentDir = {
						id: null,
						name: data.name,
						isRoot: data.isRoot,
						canGoUp: data.canGoUp,
						parent: null
					};
					this.fileElements = data.children;
					VueEventBus.$emit('resetMediaPicker');
				}, (response) => {
					console.error(response);
				});
			},
			onExplorerClick: function(explorerId){
				MediaLibraryService.getFileElement(explorerId, (data) => {
					this.currentDir = {
						id: data.id,
						name: data.name,
						isRoot: false,
						canGoUp: data.canGoUp,
						parent: data.parent_id,
					};
					this.fileElements = data.children;
					VueEventBus.$emit('resetMediaPicker');
				}, (response) => {
					console.error(response);
				});
			},
			onFileElementSelected: function(fileElement){
				if (fileElement.is_dir) {
					this.onExplorerClick(fileElement.id);
					VueEventBus.$emit('mediaLibrary:fileExplored', fileElement)
					return ;
				}
				if(fileElement.deleted){
					delete(fileElement.deleted)
				}
				
				this.$emit('mediaLibrary:fileSelected', fileElement);
			},
			onFileElementRemoved: function(fileElement){
				if (fileElement.is_dir) {
					return ;
				}
				this.$emit('mediaLibrary:fileDeselected', fileElement);
			}
		}
	}
</script>
