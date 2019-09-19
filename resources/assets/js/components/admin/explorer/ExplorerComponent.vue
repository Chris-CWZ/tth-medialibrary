<template>
	<div class="row wrapper" id="media">
		<div class="container" >
			<explorer-header-component @explorer:explore="onExplorerClick" @explorer:exploreAll="fetchFileElements"></explorer-header-component>
			<div class="row file-elements">
				<div class="col-md-3 mt-4" v-for="fileElement in fileElements" :key="fileElement.id" >
					<file-elements-list-component @explorer:fileElementOpened="onFileElementOpened" @explorer:fileElementRemoved="onFileElementRemoved" @explorer:directoryRenamed="onDirectoryRenamed" @explorer:fileElementMoved="onFileElementMoved" :file-element="fileElement"></file-elements-list-component>
				</div>
				<create-file-element-component @explorer:newFileElement="onNewFileElement" :current-dir="currentDir"></create-file-element-component>
			</div>
		</div>

		<lightbox :images="lightboxConfig.images">
	    <lightbox-default-loader slot="loader"></lightbox-default-loader>
		</lightbox>

		<!-- Modal -->
		<rename-directory-component></rename-directory-component>
		<move-file-component></move-file-component>
		<!-- Modal -->
	</div>
</template>

<script>
	import MediaLibraryService from '../../../Services/MediaLibraryServices.js';
	export default{
		props: [],
		data: function(){
			return {
				fileElements: [],
				lightboxConfig: {
					display: false,
					images: [],
				},
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
						console.log(this.currentDir);
						console.log(this.fileElements);
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
				}, (response) => {
					console.error(response);
				});
			},
			onNewFileElement: function(fileElement){
				this.fileElements.push(fileElement);
			},
			onFileElementOpened: function(fileElement){
				if (fileElement.type == 'd') {
					VueEventBus.$emit('fileExplored', fileElement);
					this.onExplorerClick(fileElement.id);
					return;
				}
				this.lightboxConfig.images = [fileElement.url];
				$('.lightbox__thumbnail')[0].click();
			},
			onFileElementRemoved: function(removedFileElement){
				let fileElements = _.reject(this.fileElements, function(fileElement){
					return fileElement.id === removedFileElement.id;
				});
				this.fileElements = fileElements;
			},
			onDirectoryRenamed: function(renamedFileElement){
				_.forEach(this.fileElements, function(fileElement){
					if (fileElement.id === renamedFileElement.id) {
                        fileElement.name = renamedFileElement.name;
						return false;
                    }
				});
			},
			onFileElementMoved: function(movedFileElement) {
                console.log("successfully moved");
				let fileElements = _.reject(this.fileElements, function(fileElement){
					return fileElement.id === movedFileElement.id;
				});
                this.fileElements = fileElements;

			}
		}
	}
</script>
